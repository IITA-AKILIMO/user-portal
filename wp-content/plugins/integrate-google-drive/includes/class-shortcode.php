<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();


class Shortcode {
	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {
		add_shortcode( 'integrate_google_drive', [ $this, 'render_shortcode' ] );
	}

	/**
	 * @param array $atts
	 * @param null $data
	 *
	 * @return false|string|void
	 */
	public function render_shortcode( $atts = [], $data = null ) {

		// Get the shortcode ID from attributes
		if ( empty( $data ) ) {
			if ( ! empty( $atts['data'] ) ) {
				$data = json_decode( base64_decode( $atts['data'] ), true );
			} elseif ( ! empty( $atts['id'] ) ) {
				$id = intval( $atts['id'] );

				if ( $id ) {
					$shortcode = Shortcode_Builder::instance()->get_shortcode( $id );

					if ( ! empty( $shortcode ) ) {
						$data = unserialize( $shortcode->config );
					}
				}
			}
		}

		// If the shortcode is not found, return nothing
		if ( empty( $data ) ) {
			return;
		}

		$status = ! empty( $data['status'] ) ? $data['status'] : 'on';

		// Check shortcode status
		if ( 'off' == $status ) {
			return;
		}

		// Check if the shortcode could be rendered
		// Return if not pass the check conditions

		wp_enqueue_style( 'igd-frontend' );

		//If the user has no permission to view the shortcode, return the access denied placeholder
		if ( ! $this->check_should_show( $data ) ) {
			return $this->get_access_denied_placeholder();
		}

		$type = ! empty( $data['type'] ) ? $data['type'] : '';

		// Check file actions Permissions
		if ( in_array( $type, [ 'browser', 'gallery', 'media', 'search', 'slider' ] ) ) {

			// Preview
			$data['preview'] = ! isset( $data['preview'] ) || ( ! empty( $data['preview'] ) && $this->check_permissions( $data, 'preview' ) );

			// Download
			$data['download'] = ! empty( $data['download'] ) && $this->check_permissions( $data, 'download' );

			// Delete
			$data['canDelete'] = ! empty( $data['canDelete'] ) && $this->check_permissions( $data, 'canDelete' );

			// Rename
			$data['rename'] = ! empty( $data['rename'] ) && $this->check_permissions( $data, 'rename' );

			// Upload
			$data['upload'] = ! empty( $data['upload'] ) && $this->check_permissions( $data, 'upload' );

			// New Folder
			$data['newFolder'] = ! empty( $data['newFolder'] ) && $this->check_permissions( $data, 'newFolder' );

			// moveCopy
			$data['moveCopy'] = ! empty( $data['moveCopy'] ) && $this->check_permissions( $data, 'moveCopy' );

			// Share
			$data['allowShare'] = ! empty( $data['allowShare'] ) && $this->check_permissions( $data, 'allowShare' );

			// Search
			$data['allowSearch'] = ! empty( $data['allowSearch'] ) && $this->check_permissions( $data, 'allowSearch' );

			// Edit
			$data['edit'] = ! empty( $data['edit'] ) && $this->check_permissions( $data, 'edit' );

			// Direct Link
			$data['directLink'] = ! empty( $data['directLink'] ) && $this->check_permissions( $data, 'directLink' );

			// Details
			$data['details'] = ! empty( $data['details'] ) && $this->check_permissions( $data, 'details' );

			// Details
			$data['comment'] = ! empty( $data['comment'] ) && $this->check_permissions( $data, 'comment' );
		}


		// Enqueue scripts
		if ( 'media' == $type ) {
			wp_enqueue_script( 'igd-player' );
		} elseif ( 'slider' == $type ) {
			wp_enqueue_style( 'igd-slick' );
			wp_enqueue_script( 'igd-slick' );
		} elseif ( in_array( $type, [ 'browser', 'gallery' ] ) && ! empty( $data['comment'] ) ) {

			$comment_method = ! empty( $data['commentMethod'] ) ? $data['commentMethod'] : 'facebook';

			if ( 'facebook' == $comment_method ) {
				add_action( 'wp_footer', [ $this, 'render_facebook_comments_sdk' ] );
			} elseif ( 'disqus' == $comment_method ) {
				add_action( 'wp_footer', [ $this, 'render_disqus_comments_sdk' ] );
			}
		}

		wp_enqueue_script( 'igd-frontend' );

		// Check if usePrivate folders
		if ( in_array( $type, [ 'browser', 'uploader', 'gallery', 'media', 'search', 'slider', 'embed' ] ) ) {
			$all_folders     = ! empty( $data['allFolders'] );
			$private_folders = ! empty( $data['privateFolders'] );

			if ( ! $all_folders && $private_folders ) {

				if ( is_user_logged_in() ) {
					$folders = get_user_option( 'folders' );

					if ( 'uploader' == $type && ! empty( $folders ) ) {
						$folders = array_values( array_filter( (array) $folders, function ( $item ) {
							return igd_is_dir( $item['type'] );
						} ) );
					}

					if ( empty( $folders ) ) {
						$create_private_folder = ! empty( $data['createPrivateFolder'] );

						if ( $create_private_folder ) {
							$folders = Private_Folders::instance()->create_user_folder( get_current_user_id(), $data );
						}
					}

					if ( ! empty( $folders ) ) {
						$data['folders'] = $folders;
					} else {
						//Module is private and user has no private folders, return the access denied placeholder
						return $this->get_access_denied_placeholder();
					}


				} else {
					//Module is private and user is not logged in, return the access denied placeholder
					return $this->get_access_denied_placeholder();
				}

			}
		}

		// If only one folder is selected, then set the files to the folder as initial files
		if ( in_array( $type, [ 'browser', 'gallery', 'media', 'slider' ] ) && ! empty( $data['folders'] ) ) {

			$is_single_folder = count( $data['folders'] ) == 1 && igd_is_dir( $data['folders'][0]['type'] );

			//If only one folder is selected, then set the files to the folder as initial files
			if ( $is_single_folder ) {
				$data['initParentFolder'] = $data['folders'][0];

				if ( is_array( $data['folders'][0] ) ) {
					$sort = ! empty( $data['sort'] ) ? $data['sort'] : [];

					$files = Rest_Api_Controller::instance()->get_files( [
						'folder'      => $data['folders'][0],
						'sort'        => $sort,
						'from_server' => true,
					] );

					if ( is_array( $files ) && empty( $files['error'] ) ) {
						$data['folders'] = $files;
					}
				}

			} else {
				//If more than one files are selected, then get the updated files from server
				try {
					$data['folders'] = $this->get_files_from_server( $data );
				} catch ( \Exception $e ) {

				}
			}

		}

		// Check excludes
		if ( in_array( $type, [ 'browser', 'gallery', 'media', 'search', 'slider' ] ) && ! empty( $data['folders'] ) ) {

			$excludes = [
				'excludeExtensions'       => ! empty( $data['excludeExtensions'] ) ? $data['excludeExtensions'] : '',
				'excludeAllExtensions'    => ! empty( $data['excludeAllExtensions'] ) ? $data['excludeAllExtensions'] : '',
				'excludeExceptExtensions' => ! empty( $data['excludeExceptExtensions'] ) ? $data['excludeExceptExtensions'] : '',
				'excludeNames'            => ! empty( $data['excludeNames'] ) ? $data['excludeNames'] : '',
				'excludeAllNames'         => ! empty( $data['excludeAllNames'] ) ? $data['excludeAllNames'] : '',
				'excludeExceptNames'      => ! empty( $data['excludeExceptNames'] ) ? $data['excludeExceptNames'] : '',
				'showFiles'               => isset( $data['showFiles'] ) ? $data['showFiles'] : true,
				'showFolders'             => isset( $data['showFolders'] ) ? $data['showFolders'] : true,
			];

			$files = [];

			foreach ( $data['folders'] as $item ) {

				$is_dir = igd_is_dir( $item['type'] );

				if ( ! $is_dir && ! $excludes['showFiles'] ) {
					continue;
				}

				if ( $is_dir && ! $excludes['showFolders'] ) {
					continue;
				}

				$extension = ! empty( $item['extension'] ) ? $item['extension'] : '';
				$name      = ! empty( $item['name'] ) ? $item['name'] : '';

				if ( igd_should_exclude( $excludes, $extension, $name, $is_dir ) ) {
					continue;
				}

				$files[] = $item;

			}

			$data['folders'] = $files;
		}

		$width  = ! empty( $data['moduleWidth'] ) ? $data['moduleWidth'] : '100%';
		$height = ! empty( $data['moduleHeight'] ) ? $data['moduleHeight'] : '';
		
		if ( 'embed' == $type ) {
			$html = igd_get_embed_content( $data );
		} elseif ( 'download' == $type ) {
			$html = igd_get_download_links( $data['folders'] );
		} elseif ( 'view' == $type ) {
			$html = igd_get_view_links( $data['folders'] );
		} else {
			ob_start();
			?>
            <div class="igd igd-shortcode-wrap igd-shortcode-<?php echo esc_attr( $type ); ?>"
                 style="max-width: <?php echo esc_attr( $width ); ?>; max-height: <?php echo esc_attr( $height ); ?>;">
                <script type="application/json" class="shortcode-data"><?php echo json_encode( $data ); ?></script>
            </div>
			<?php
			$html = ob_get_clean();
		}

		return $html;

	}

	/**
	 * Check if the shortcode should be shown.
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function check_should_show( $data ) {
		$should_show = false;

		$display_for = ! empty( $data['displayFor'] ) ? $data['displayFor'] : 'everyone';

		if ( 'everyone' == $display_for ) {
			$should_show = true;
		} elseif ( 'loggedIn' == $display_for && is_user_logged_in() ) {
			$display_users    = ! empty( $data['displayUsers'] ) ? $data['displayUsers'] : [];
			$display_everyone = ! empty( $data['displayEveryone'] ) ? filter_var( $data['displayEveryone'], FILTER_VALIDATE_BOOLEAN ) : false;
			$display_except   = ! empty( $data['displayExcept'] ) ? $data['displayExcept'] : [];

			$users = array_filter( $display_users, function ( $item ) {
				return is_string( $item );
			} );

			$except_users = array_filter( $display_except, function ( $item ) {
				return is_string( $item );
			} );

			$current_user = wp_get_current_user();

			if ( ! $display_everyone ) {

				if ( ! empty( $users ) ) {

					if ( in_array( 'everyone', $users ) ) { // Check if everyone
						$should_show = true;
					} elseif ( ! empty( array_intersect( $current_user->roles, $users ) ) ) { // If matches roles
						$should_show = true;
					}
				}

				if ( in_array( $current_user->ID, $display_users ) ) { // If current user_id
					$should_show = true;
				}

			} else {

				if ( ! in_array( $current_user->ID, $display_except ) &&
				     empty( array_intersect( $current_user->roles, $except_users ) )
				) {
					$should_show = true;
				}
			}

			if ( empty( $users ) && ( ( $display_everyone && empty( $except_users ) ) || ! $display_everyone ) ) {
				$should_show = true;
			}

		}


		return $should_show;
	}

	/**
	 * Check action permissions
	 *
	 * @param $data
	 * @param $type
	 *
	 * @return bool
	 */
	public function check_permissions( $data, $type ) {
		$users = [];

		if ( 'preview' == $type ) {
			$users = ! empty( $data['previewUsers'] ) ? $data['previewUsers'] : [ 'everyone' ];
		} elseif ( 'download' == $type ) {
			$users = ! empty( $data['downloadUsers'] ) ? $data['downloadUsers'] : [ 'everyone' ];
		} elseif ( 'upload' == $type ) {
			$users = ! empty( $data['uploadUsers'] ) ? $data['uploadUsers'] : [ 'everyone' ];
		} elseif ( 'allowShare' == $type ) {
			$users = ! empty( $data['shareUsers'] ) ? $data['shareUsers'] : [ 'everyone' ];
		} elseif ( 'edit' == $type ) {
			$users = ! empty( $data['editUsers'] ) ? $data['editUsers'] : [ 'everyone' ];
		} elseif ( 'directLink' == $type ) {
			$users = ! empty( $data['directLinkUsers'] ) ? $data['directLinkUsers'] : [ 'everyone' ];
		} elseif ( 'details' == $type ) {
			$users = ! empty( $data['detailsUsers'] ) ? $data['detailsUsers'] : [ 'everyone' ];
		} elseif ( 'allowSearch' == $type ) {
			$users = ! empty( $data['searchUsers'] ) ? $data['searchUsers'] : [ 'everyone' ];
		} elseif ( 'canDelete' == $type ) {
			$users = ! empty( $data['deleteUsers'] ) ? $data['deleteUsers'] : [ 'everyone' ];
		} elseif ( 'rename' == $type ) {
			$users = ! empty( $data['renameUsers'] ) ? $data['renameUsers'] : [ 'everyone' ];
		} elseif ( 'moveCopy' == $type ) {
			$users = ! empty( $data['moveCopyUsers'] ) ? $data['moveCopyUsers'] : [ 'everyone' ];
		} elseif ( 'newFolder' == $type ) {
			$users = ! empty( $data['newFolderUsers'] ) ? $data['newFolderUsers'] : [ 'everyone' ];
		} elseif ( 'comment' == $type ) {
			$users = ! empty( $data['commentUsers'] ) ? $data['commentUsers'] : [ 'everyone' ];
		}

		if ( in_array( 'everyone', $users ) ) {
			return true;
		} elseif ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			if ( ! empty( array_intersect( $current_user->roles, $users ) ) ) { // If matches roles
				return true;
			}

			if ( in_array( $current_user->ID, $users ) ) { // If current user_id
				return true;
			}

		}

		return false;

	}

	public function get_access_denied_placeholder() {

		ob_start();
		?>
        <div class="igd-access-denied-placeholder">
            <div class="placeholder-inner">
                <div class="placeholder-image">
                    <img src="<?php echo esc_url( IGD_ASSETS . '/images/access-denied.png' ); ?>"
                         alt="<?php esc_attr_e( 'Access Denied', 'integrate-google-drive' ); ?>">
                </div>

                <div class="placeholder-title">
					<?php esc_html_e( 'Access Denied', 'integrate-google-drive' ); ?>
                </div>

                <div class="placeholder-description">
					<?php esc_html_e( 'We\'re sorry, but your account does not currently have access to this content. To gain access, please contact the site administrator who can assist in linking your account to the appropriate content. Thank you.', 'integrate-google-drive' ); ?>
                </div>
            </div>

        </div>
		<?php

		return ob_get_clean();

	}

	public function render_disqus_comments_sdk() { ?>
        <!-- Disqus SDK -->
        <div id="disqus_thread"></div>

        <script>

            var disqus_config = function () {
                this.page.url = '<?php echo esc_url( get_permalink() ); ?>';  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = '<?php echo esc_attr( get_the_ID() ); ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };

            (function () {
                // DON'T EDIT BELOW THIS LINE
                var d = document,
                    s = d.createElement('script');
                s.src = 'https://lg-disqus.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>

	<?php }

	public function render_facebook_comments_sdk() { ?>

        <!-- Facebook SDK-->
        <div id="fb-root"></div>

        <script>
            (function (d, s, id) {
                var js,
                    fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4';
                fjs.parentNode.insertBefore(js, fjs);
            })(document, 'script', 'facebook-jssdk');
        </script>

	<?php }

	public function get_files_from_server( $data ) {
		$type = isset( $data['type'] ) ? $data['type'] : 'folder';

		//Get files from server
		$account_id = $data['folders'][0]['accountId'];
		$app        = App::instance( $account_id );
		$client     = $app->client;
		$service    = $app->getService();
		$batch      = new \IGDGoogle_Http_Batch( $client );
		$client->setUseBatch( true );

		foreach ( $data['folders'] as $key => $item ) {

			$request = $service->files->get( $item['id'], [
				'supportsAllDrives' => true,
				'fields'            => $app->file_fields,
			] );

			$batch->add( $request, ! empty( $key ) ? $key : '-1' );

		}

		$batch_result = $batch->execute();

		if ( ! empty( $batch_result ) ) {
			foreach ( $batch_result as $key => $file ) {


				$index = str_replace( 'response-', '', $key );
				$index = $index < 0 ? 0 : $index;

				if ( is_a( $file, 'IGDGoogle_Service_Exception' ) || is_a( $file, 'IGDGoogle_Exception' ) ) {
					unset( $data['folders'][ $index ] );
					continue;
				}

				if ( isset( $data['fileNumbers'] ) && $data['fileNumbers'] > 0 && count( $data['folders'] ) > $data['fileNumbers'] ) {
					unset( $data['folders'][ $index ] );
					continue;
				}

				$file = igd_file_map( $file, $account_id );

				$data['folders'][ $index ] = $file;
			}
		}

		$client->setUseBatch( false );


		//Get files from folders if slider
		if ( 'slider' == $type && ! empty( $data['folders'] ) ) {
			$folder_ids = [];

			foreach ( $data['folders'] as $item ) {
				if ( igd_is_dir( $item['type'] ) ) {
					$folder_ids[] = $item['id'];
				}
			}

			$query = "trashed=false and ('" . implode( "' in parents or '", $folder_ids ) . "' in parents) ";

			$files = App::instance( $account_id )->get_files( [ 'q' => $query, ], '', [], true );

			if ( isset( $files['error'] ) ) {
				unset( $files['error'] );
			}

			$data['folders'] = array_merge( $data['folders'], $files );

			//remove folders and not have thumbnailLink
			foreach ( $data['folders'] as $key => $item ) {

				if ( igd_is_dir( $item['type'] ) || empty( $item['thumbnailLink'] ) ) {
					unset( $data['folders'][ $key ] );
				}
			}

			if ( isset( $data['fileNumbers'] ) && $data['fileNumbers'] > 0 && count( $data['folders'] ) > $data['fileNumbers'] ) {
				$data['folders'] = array_slice( $data['folders'], 0, $data['fileNumbers'] );
			}

		}

		// Move folders to the start of the list
		$files   = [];
		$folders = [];

		foreach ( $data['folders'] as $item ) {
			if ( ! empty( $item ) ) {
				if ( igd_is_dir( $item['type'] ) ) {
					$folders[] = $item;
				} else {
					$files[] = $item;
				}
			}
		}

		return array_merge( $folders, $files );
	}

	/**
	 * @return Shortcode|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Shortcode::instance();