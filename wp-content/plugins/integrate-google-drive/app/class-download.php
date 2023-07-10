<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();


class Download {
	/**
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * Google API Client
	 *
	 * @var \Exception|false|\IGDGoogle_Client|mixed
	 */
	private $client;

	private $app;
	private $file;
	private $mimetype;
	private $proxy;
	private $is_stream;
	private $download_method = 'redirect';

	/**
	 * @throws \Exception
	 */
	public function __construct( $file, $is_stream = false, $mimetype = 'default', $proxy = false ) {
		$this->file      = $file;
		$this->mimetype  = $mimetype;
		$this->proxy     = $proxy;
		$this->is_stream = $is_stream;

		$this->client = Client::instance()->get_client();

		$account_id = ! empty( $file['accountId'] ) ? $file['accountId'] : '';
		$this->app  = App::instance( $account_id );

		wp_using_ext_object_cache( false );
	}

	/**
	 * Start Download Process
	 * @throws \IGDGoogle_IO_Exception
	 */
	public function start_download() {
		wp_using_ext_object_cache( false );

		$this->set_download_method();

		$this->process_download();
	}

	/**
	 * Process Download
	 *
	 * @throws \IGDGoogle_IO_Exception
	 */
	private function process_download() {

		if ( 'proxy' === $this->download_method ) {

			if ( 'default' === $this->mimetype ) {
				if ( $this->is_stream ) {
					$this->stream_content();
				} else {
					$filename = $this->file['name'];

					header( 'Content-Disposition: attachment; ' . sprintf( 'filename="%s"; ', rawurlencode( $filename ) ) . sprintf( "filename*=utf-8''%s", rawurlencode( $filename ) ) );
					$this->stream_content();
				}
			} else {
				$this->export_content();
			}

		} elseif ( 'redirect' === $this->download_method ) {
			if ( 'default' === $this->mimetype ) {
				$this->redirect_to_content();
			} else {
				$this->export_content();
			}
		}

		exit();
	}

	public function stream_content() {

		if ( function_exists( 'apache_setenv' ) ) {
			@apache_setenv( 'no-gzip', 1 );
		}

		@ini_set( 'zlib.output_compression', 'Off' );
		@session_write_close();

		// Stop WP from buffering
		wp_ob_end_flush_all();

		$chunk_size = min( igd_get_free_memory_available() - ( 1024 * 1024 * 5 ), 1024 * 1024 * 50 ); // Chunks of 50MB or less if memory isn't sufficient

		$size = $this->file['size'];

		$length = $size;           // Content length
		$start  = 0;               // Start byte
		$end    = $size - 1;       // End byte
		header( 'Accept-Ranges: bytes' );
		header( 'Content-Type: ' . $this->file['type'] );

		$seconds_to_cache = 60 * 60 * 24;
		$ts               = gmdate( 'D, d M Y H:i:s', time() + $seconds_to_cache ) . ' GMT';
		header( "Expires: {$ts}" );
		header( 'Pragma: cache' );
		header( "Cache-Control: max-age={$seconds_to_cache}" );

		if ( isset( $_SERVER['HTTP_RANGE'] ) ) {
			$c_end = $end;

			list( , $range ) = explode( '=', $_SERVER['HTTP_RANGE'], 2 );

			if ( false !== strpos( $range, ',' ) ) {
				header( 'HTTP/1.1 416 Requested Range Not Satisfiable' );
				header( "Content-Range: bytes {$start}-{$end}/{$size}" );

				exit;
			}

			if ( '-' == $range ) {
				$c_start = $size - substr( $range, 1 );
			} else {
				$range   = explode( '-', $range );
				$c_start = (int) $range[0];

				if ( isset( $range[1] ) && is_numeric( $range[1] ) ) {
					$c_end = (int) $range[1];
				} else {
					$c_end = $size;
				}

				if ( $c_end - $c_start > $chunk_size ) {
					$c_end = $c_start + $chunk_size;
				}
			}

			$c_end = ( $c_end > $end ) ? $end : $c_end;

			if ( $c_start > $c_end || $c_start > $size - 1 || $c_end >= $size ) {
				header( 'HTTP/1.1 416 Requested Range Not Satisfiable' );
				header( "Content-Range: bytes {$start}-{$end}/{$size}" );

				exit;
			}

			$start = $c_start;

			$end    = $c_end;
			$length = $end - $start + 1;
			header( 'HTTP/1.1 206 Partial Content' );
		}

		header( "Content-Range: bytes {$start}-{$end}/{$size}" );
		header( 'Content-Length: ' . $length );

		$chunk_start = $start;

		@set_time_limit( 0 );

		while ( $chunk_start <= $end ) {
			//Output the chunk

			$chunk_end = ( ( ( $chunk_start + $chunk_size ) > $end ) ? $end : $chunk_start + $chunk_size );
			$this->stream_get_chunk( $chunk_start, $chunk_end );

			$chunk_start = $chunk_end + 1;
		}
	}

	private function stream_get_chunk( $start, $end ) {
		$headers = [ 'Range' => 'bytes=' . $start . '-' . $end ];

		// Add Resources key to give permission to access the item
		if ( ! empty( $this->file['resourcekey'] ) ) {
			$headers['X-Goog-Drive-Resource-Keys'] = $this->file['id'] . '/' . $this->file['resourcekey'];
		}

		$request = new \IGDGoogle_Http_Request( $this->get_api_url(), 'GET', $headers );
		$request->disableGzip();

		$this->client->getIo()->setOptions(
			[
				CURLOPT_RETURNTRANSFER => false,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_RANGE          => null,
				CURLOPT_NOBODY         => null,
				CURLOPT_HEADER         => false,
				CURLOPT_WRITEFUNCTION  => [ $this, 'stream_chunk_to_output' ],
				CURLOPT_CONNECTTIMEOUT => null,
				CURLOPT_TIMEOUT        => null,
			]
		);

		$this->client->getAuth()->authenticatedRequest( $request );
	}

	public function stream_chunk_to_output( $ch, $str ) {
		echo $str;

		return strlen( $str );
	}

	public function export_content() {
		// Stop WP from buffering
		wp_ob_end_flush_all();

		$export_link = $this->get_export_url();

		if ( ( $this->file['size'] <= 10485760 ) && ( empty( $export_link ) || ! $this->app->has_permission( $this->file ) || 'proxy' == $this->download_method ) ) {
			// Only use export link if publicly accessible
			$export_link = $this->get_api_url();
		} else {
			header( 'Location: ' . $export_link );

			return;
		}

		$request     = new \IGDGoogle_Http_Request( $export_link, 'GET' );
		$httpRequest = $this->client->getAuth()->authenticatedRequest( $request );
		$headers     = $httpRequest->getResponseHeaders();

		if ( isset( $headers['location'] ) ) {
			header( 'Location: ' . $headers['location'] );
		} else {
			foreach ( $headers as $key => $header ) {
				if ( 'transfer-encoding' === $key ) {
					continue;
				}

				if ( is_array( $header ) ) {
					header( "{$key}: " . implode( ' ', $header ) );
				} else {
					header( "{$key}: " . str_replace( "\n", ' ', $header ) );
				}
			}
		}

		echo $httpRequest->getResponseBody();
	}

	public function get_api_url() {
		if ( 'default' !== $this->mimetype ) {
			return 'https://www.googleapis.com/drive/v3/files/' . $this->file['id'] . '/export?alt=media&mimeType=' . $this->mimetype;
		}

		return 'https://www.googleapis.com/drive/v3/files/' . $this->file['id'] . '?alt=media';
	}

	/**
	 * Set Download Method
	 *
	 * @return string
	 * @throws \IGDGoogle_IO_Exception
	 */
	public function set_download_method() {

		if ( $this->proxy ) {
			$this->download_method = 'proxy';
		}

		// Files larger than 25MB can only be streamed unfortunately
		// There isn't a direct download link available for those files and
		// a cookie security check by Google prevents them to be downloaded directly.

		if ( $this->file['size'] > 25165824 ) {
			return $this->download_method = 'proxy';
		}

		$copy_disabled = $this->file['copyRequiresWriterPermission'];

		if ( $copy_disabled ) {
			return $this->download_method = 'proxy';
		}

		// Is file already shared ?
		$is_shared = $this->app->has_permission( $this->file );

		if ( $is_shared ) {
			return $this->download_method = 'redirect';
		}

		// File permissions
		$file_permissions = (array) $this->file['permissions'];

		// Can the sharing permissions of the file be updated via the plugin?
		$manage_permissions     = igd_get_settings( 'manageSharing', true );
		$can_update_permissions = $manage_permissions && $file_permissions['canShare'];

		if ( ! $can_update_permissions ) {
			return $this->download_method = 'proxy';
		}

		// Update the Sharing Permissions
		$is_sharing_permission_updated = $this->app->set_permission( $this->file );

		if ( ! $is_sharing_permission_updated ) {
			return $this->download_method = 'proxy';
		}

		return $this->download_method = 'redirect';

	}

	/**
	 * @throws \IGDGoogle_IO_Exception
	 */
	public function redirect_to_content() {
		header( 'Location: ' . $this->get_content_url() );

		exit();
	}

	public function get_content_url() {

		if ( 'default' == $this->mimetype && ! empty( $this->file['webContentLink'] ) ) {
			return $this->file['webContentLink'] . '&userIp=' . igd_get_user_ip();
		}

		return $this->get_export_url() . '&userIp=' . igd_get_user_ip();

	}

	public function get_export_url() {
		if ( ! empty( $this->file['exportLinks'][ $this->mimetype ] ) ) {
			return $this->file['exportLinks'][ $this->mimetype ];
		}

		return false;
	}

	/**
	 * @return Download|null
	 * @throws \Exception
	 */
	public static function instance( $file, $is_stream = false, $mimetype = 'default' ) {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $file, $is_stream, $mimetype );
		}

		return self::$instance;
	}

}