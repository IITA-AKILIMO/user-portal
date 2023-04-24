<?php

defined( 'ABSPATH' ) || exit();

use IGD\App;
use IGD\Account;
use IGD\Files;
use IGD\Shortcode_Builder;
use IGD\Zip;

function igd_get_breadcrumb( $folder ) {
	$active_account = Account::get_active_account();

	$account_id = ! empty( $folder['accountId'] ) ? $folder['accountId'] : $active_account['id'];

	if ( empty( $folder ) ) {
		return [];
	}

	if ( ! isset( $folder['name'] ) && isset( $folder['id'] ) ) {
		$folder = App::instance( $account_id )->get_file_by_id( $folder['id'] );
	}

	$items = [ $folder['id'] => $folder['name'] ];

	if ( in_array( $folder['id'], [
		$active_account['root_id'],
		'computers',
		'shared-drives',
		'shared',
		'recent',
		'starred'
	] ) ) {
		return $items;
	}


	if ( ! isset( $folder['parents'] ) ) {
		$folder = App::instance( $account_id )->get_file_by_id( $folder['id'] );
	}

	if ( ! empty( $folder['parents'] ) ) {

		if ( in_array( 'shared-drives', $folder['parents'] ) ) {
			$items['shared-drives'] = __( 'Shared Drives', 'integrate-google-drive' );

			$items = array_reverse( $items );

			return $items;
		}

		$item  = App::instance( $account_id )->get_file_by_id( $folder['parents'][0] );
		$items = array_merge( igd_get_breadcrumb( $item ), $items );
	}

	return $items;
}

function igd_is_dir( $type ) {
	return $type == 'application/vnd.google-apps.folder';
}

function igd_is_shortcut( $type ) {
	return $type == 'application/vnd.google-apps.shortcut';
}

function igd_get_files_recursive(
	$file,
	$current_path = '',
	&$list = [
		'folders' => [],
		'files'   => [],
		'size'    => 0,
	]
) {

	if ( igd_is_dir( $file['type'] ) ) {
		$folder_path = $current_path . $file['name'] . '/';

		$list['folders'][] = $folder_path;

		$account_id = ! empty( $file['accountId'] ) ? $file['accountId'] : Account::get_active_account()['id'];
		$files      = App::instance( $account_id )->get_files( [], $file['id'] );

		if ( ! empty( $files ) ) {
			foreach ( $files as $file ) {
				igd_get_files_recursive( $file, $folder_path, $list );
			}
		}

	} else {
		$file_path = $current_path . $file['name'];

		if ( empty( $file['webContentLink'] ) ) {
			$export_as = igd_get_export_as( $file['type'] );

			$format        = reset( $export_as );
			$download_link = 'https://www.googleapis.com/drive/v3/files/' . $file['id'] . '/export?mimeType=' . urlencode( $format['mimetype'] ) . '&alt=media';
			$file_path     .= '.' . $format['extension'];
		} else {
			$download_link = 'https://www.googleapis.com/drive/v3/files/' . $file['id'] . '?alt=media';
		}

		$file['downloadLink'] = $download_link;

		$file['path']    = $file_path;
		$list['files'][] = $file;
		$list['size']    += $file['size'];
	}


	return $list;
}

function igd_file_map( $item, $account_id = null ) {

	if ( empty( $account_id ) ) {
		$account_id = Account::get_active_account()['id'];
	}

	$file = [
		'id'                           => $item->getId(),
		'name'                         => $item->getName(),
		'type'                         => $item->getMimeType(),
		'size'                         => $item->getSize(),
		'iconLink'                     => $item->getIconLink(),
		'thumbnailLink'                => $item->getThumbnailLink(),
		'webViewLink'                  => $item->getWebViewLink(),
		'webContentLink'               => $item->getWebContentLink(),
		'created'                      => $item->getCreatedTime(),
		'updated'                      => $item->getModifiedTime(),
		'description'                  => $item->getDescription(),
		'parents'                      => $item->getParents(),
		'shared'                       => $item->getShared(),
		'sharedWithMeTime'             => $item->getSharedWithMeTime(),
		'extension'                    => $item->getFileExtension(),
		'resourceKey'                  => $item->getResourceKey(),
		'copyRequiresWriterPermission' => $item->getCopyRequiresWriterPermission(),
		'starred'                      => $item->getStarred(),
		'exportLinks'                  => $item->getExportLinks(),
		'accountId'                    => $account_id,
	];

	$canPreview                            = true;
	$canDownload                           = ! empty( $file['webContentLink'] ) || ! empty( $file['exportLinks'] );
	$canShare                              = false;
	$canEdit                               = false;
	$canDelete                             = $item->getOwnedByMe();
	$canTrash                              = $item->getOwnedByMe();
	$canMove                               = $item->getOwnedByMe();
	$canRename                             = $item->getOwnedByMe();
	$canChangeCopyRequiresWriterPermission = true;

	$capabilities = $item->getCapabilities();


	if ( ! empty( $capabilities ) ) {
		$canEdit                               = $capabilities->getCanEdit() && igd_is_editable( $file['type'] );
		$canShare                              = $capabilities->getCanShare();
		$canRename                             = $capabilities->getCanRename();
		$canDelete                             = $capabilities->getCanDelete();
		$canTrash                              = $capabilities->getCanTrash();
		$canMove                               = $capabilities->getCanMoveItemWithinDrive();
		$canChangeCopyRequiresWriterPermission = $capabilities->getCanChangeCopyRequiresWriterPermission();
	}

	// Permission users
	$users = [];

	$permissions = $item->getPermissions();
	if ( count( $permissions ) > 0 ) {
		foreach ( $permissions as $permission ) {
			$users[ $permission->getId() ] = [
				'type'   => $permission->getType(),
				'role'   => $permission->getRole(),
				'domain' => $permission->getDomain()
			];
		}
	}

	// Set the permissions
	$file['permissions'] = [
		'canPreview'                            => $canPreview,
		'canDownload'                           => $canDownload,
		'canEdit'                               => $canEdit,
		'canDelete'                             => $canDelete,
		'canTrash'                              => $canTrash,
		'canMove'                               => $canMove,
		'canRename'                             => $canRename,
		'canShare'                              => $canShare,
		'copyRequiresWriterPermission'          => $item->getCopyRequiresWriterPermission(),
		'canChangeCopyRequiresWriterPermission' => $canChangeCopyRequiresWriterPermission,
		'users'                                 => $users,
	];

	// Set owner
	if ( ! empty( $item->getOwners() ) ) {
		$file['owner'] = $item->getOwners()[0]['displayName'];
	}

	// Get export as
	$file['exportAs'] = igd_get_export_as( $item->getMimeType() );


	// Shortcut details
	if ( ! empty( $item->getShortcutDetails() ) ) {
		$file['shortcutDetails'] = [
			'targetId'       => $item->getShortcutDetails()->getTargetId(),
			'targetMimeType' => $item->getShortcutDetails()->getTargetMimeType(),
		];


		$original_file = App::instance( $account_id )->get_file_by_id( $file['shortcutDetails']['targetId'] );

		if ( ! empty( $original_file ) ) {
			$file['thumbnailLink'] = $original_file['thumbnailLink'];
			$file['iconLink']      = $original_file['iconLink'];
			$file['extension']     = $original_file['extension'];
			$file['exportAs']      = $original_file['exportAs'];
		}


	}

	//Meta Data
	$image_meta_data = $item->getImageMediaMetadata();
	$video_meta_data = $item->getVideoMediaMetadata();

	if ( $image_meta_data ) {
		$file['metaData'] = [
			'width'  => $image_meta_data->getWidth(),
			'height' => $image_meta_data->getHeight(),
		];
	} elseif ( $video_meta_data ) {
		$file['metaData'] = [
			'width'    => $video_meta_data->getWidth(),
			'height'   => $video_meta_data->getHeight(),
			'duration' => $video_meta_data->getDurationMillis(),
		];
	}

	return $file;
}

function igd_is_editable( $type ) {
	return in_array( $type, [
		'application/msword',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.google-apps.document',
		'application/vnd.ms-excel',
		'application/vnd.ms-excel.sheet.macroenabled.12',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'application/vnd.google-apps.spreadsheet',
		'application/vnd.ms-powerpoint',
		'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
		'application/vnd.google-apps.presentation',
		'application/vnd.google-apps.drawing',
	] );
}

function igd_get_export_as( $type ) {
	$export_as = [];

	if ( 'application/vnd.google-apps.document' == $type ) {
		$export_as = [
			'MS Word document' => [
				'mimetype'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'extension' => 'docx',
			],

			'HTML' => [
				'mimetype'  => 'text/html',
				'extension' => 'html',
			],

			'Text' => [
				'mimetype'  => 'text/plain',
				'extension' => 'txt',
			],

			'Open Office document' => [
				'mimetype'  => 'application/vnd.oasis.opendocument.text',
				'extension' => 'odt',
			],

			'PDF' => [
				'mimetype'  => 'application/pdf',
				'extension' => 'pdf',
			],

			'ZIP' => [
				'mimetype'  => 'application/zip',
				'extension' => 'zip',
			],

		];

	} elseif ( 'application/vnd.google-apps.spreadsheet' == $type ) {
		$export_as = [
			'MS Excel document'      => [
				'mimetype'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'extension' => 'xlsx',
			],
			'Open Office sheet'      => [
				'mimetype'  => 'application/x-vnd.oasis.opendocument.spreadsheet',
				'extension' => 'ods',
			],
			'PDF'                    => [
				'mimetype'  => 'application/pdf',
				'extension' => 'pdf',
			],
			'CSV (first sheet only)' => [
				'mimetype'  => 'text/csv',
				'extension' => 'csv',
			],
			'ZIP'                    => [
				'mimetype'  => 'application/zip',
				'extension' => 'zip',
			],
		];
	} elseif ( 'application/vnd.google-apps.drawing' == $type ) {
		$export_as = [
			'JPEG' => [ 'mimetype' => 'image/jpeg', 'extension' => 'jpeg' ],
			'PNG'  => [ 'mimetype' => 'image/png', 'extension' => 'png' ],
			'SVG'  => [ 'mimetype' => 'image/svg+xml', 'extension' => 'svg' ],
			'PDF'  => [ 'mimetype' => 'application/pdf', 'extension' => 'pdf' ],
		];

	} elseif ( 'application/vnd.google-apps.presentation' == $type ) {
		$export_as = [
			'MS PowerPoint document' => [
				'mimetype'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'extension' => 'pptx',
			],
			'PDF'                    => [
				'mimetype'  => 'application/pdf',
				'extension' => 'pdf',
			],
			'Text'                   => [
				'mimetype'  => 'text/plain',
				'extension' => 'txt',
			],
		];
	} elseif ( 'application/vnd.google-apps.script' == $type ) {
		$export_as = [
			'JSON' => [
				'mimetype'  => 'application/vnd.google-apps.script+json',
				'extension' => 'json',
			],
		];
	} elseif ( 'application/vnd.google-apps.form' == $type ) {
		$export_as = [
			'ZIP' => [ 'mimetype' => 'application/zip', 'extension' => 'zip' ],
		];
	}

	return $export_as;
}

function igd_get_embed_content( $items = [], $show_file_name = false, $embed_type = 'readOnly', $direct_image = true, $allow_popout = true ) {

	$files = [];
	foreach ( $items as $item ) {

		// skip root folders
		if ( ! is_array( $item ) ) {
			continue;
		}

		if ( ! igd_is_dir( $item['type'] ) ) {
			$files[] = $item;
		} else {
			$folder_files = App::instance( $item['accountId'] )->get_files( [], $item['id'] );

			foreach ( $folder_files as $folder_file ) {
				if ( ! igd_is_dir( $folder_file['type'] ) ) {
					$files[] = $folder_file;
				}
			}

		}
	}

	ob_start();
	foreach ( $files as $file ) {
		$type = $file['type'];
		$name = $file['name'];

		$is_image = in_array( $type, [
			'image/jpeg',
			'image/png',
			'image/svg+xml',
			'image/gif',
			'image/jpg',
			'image/webp',
			'image/heic'
		] );

		if ( $show_file_name ) { ?>
			<h4 class="igd-embed-name"><?php echo esc_html( $name ); ?></h4>
		<?php }

		if ( $is_image ) {
			$embed_type = 'readOnly';
		}

		if ( empty( $file['permissions']['canEdit'] ) ) {
			$embed_type = 'readOnly';
		}

		$url = igd_get_embed_url( $file, $embed_type, $direct_image );

		if ( $direct_image && $is_image ) {
			printf( '<img class="igd-embed-image" src="%s" alt="%s" style="max-width: 100%%;" />', $url, $name );
		} else {
			$sandbox_attrs = '';

			if ( $allow_popout && $embed_type = 'readOnly' ) {
				$sandbox_attrs = 'sandbox="allow-same-origin allow-scripts"';
			}

			printf( '<iframe class="igd-embed" src="%s" style="width: 100%%" frameborder="0" scrolling="no" width="100%%" height="480" allow="autoplay" allowfullscreen="allowfullscreen" %s></iframe>', $url, $sandbox_attrs );
		}
	}

	$content = ob_get_clean();

	return $content;

}

function igd_get_download_links( $items = [] ) {
	$html = '';

	if ( ! empty( $items ) ) {
		foreach ( $items as $item ) {
			$id         = $item['id'];
			$account_id = $item['accountId'];
			$name       = $item['name'];

			if ( igd_is_dir( $item['type'] ) ) {
				$file_ids      = base64_encode( json_encode( [ $id ] ) );
				$download_link = admin_url( "admin-ajax.php?action=igd_download_zip&file_ids=$file_ids&accountId=$account_id" );
			} else {
				$download_link = admin_url( "admin-ajax.php?action=igd_download&id=$id&accountId=$account_id" );
			}

			$html .= sprintf( '<a href="%s" class="igd-download-link">%s</a>', $download_link, $name );
		}
	}

	return $html;
}

function igd_get_view_links( $items = [] ) {
	$html = '';

	if ( ! empty( $items ) ) {
		foreach ( $items as $item ) {
			$name = $item['name'];

			$view_link = $item['webViewLink'];

			$html .= sprintf( '<a href="%s" class="igd-view-link" target="_blank">%s</a>', $view_link, $name );
		}
	}

	return $html;
}

function igd_delete_thumbnail_cache() {
	$dirname = IGD_CACHE_DIR . '/thumbnails';

	if ( is_dir( $dirname ) ) {
		array_map( 'unlink', glob( "$dirname/*.*" ) );
		rmdir( $dirname );
	}
}

function igd_is_cached_folder( $folder_id ) {
	$cached_folders = (array) get_option( 'igd_cached_folders' );

	return in_array( $folder_id, $cached_folders );
}

function igd_update_cached_folders( $folder_id ) {
	$cached_folders   = (array) get_option( 'igd_cached_folders' );
	$cached_folders[] = $folder_id;

	update_option( 'igd_cached_folders', $cached_folders );
}

function igd_mime_to_ext( $mime ) {
	$mime_map = [
		'video/3gpp2'                                                               => '3g2',
		'video/3gp'                                                                 => '3gp',
		'video/3gpp'                                                                => '3gp',
		'application/x-compressed'                                                  => '7zip',
		'audio/x-acc'                                                               => 'aac',
		'audio/ac3'                                                                 => 'ac3',
		'application/postscript'                                                    => 'ai',
		'audio/x-aiff'                                                              => 'aif',
		'audio/aiff'                                                                => 'aif',
		'audio/x-au'                                                                => 'au',
		'video/x-msvideo'                                                           => 'avi',
		'video/msvideo'                                                             => 'avi',
		'video/avi'                                                                 => 'avi',
		'application/x-troff-msvideo'                                               => 'avi',
		'application/macbinary'                                                     => 'bin',
		'application/mac-binary'                                                    => 'bin',
		'application/x-binary'                                                      => 'bin',
		'application/x-macbinary'                                                   => 'bin',
		'image/bmp'                                                                 => 'bmp',
		'image/x-bmp'                                                               => 'bmp',
		'image/x-bitmap'                                                            => 'bmp',
		'image/x-xbitmap'                                                           => 'bmp',
		'image/x-win-bitmap'                                                        => 'bmp',
		'image/x-windows-bmp'                                                       => 'bmp',
		'image/ms-bmp'                                                              => 'bmp',
		'image/x-ms-bmp'                                                            => 'bmp',
		'application/bmp'                                                           => 'bmp',
		'application/x-bmp'                                                         => 'bmp',
		'application/x-win-bitmap'                                                  => 'bmp',
		'application/cdr'                                                           => 'cdr',
		'application/coreldraw'                                                     => 'cdr',
		'application/x-cdr'                                                         => 'cdr',
		'application/x-coreldraw'                                                   => 'cdr',
		'image/cdr'                                                                 => 'cdr',
		'image/x-cdr'                                                               => 'cdr',
		'zz-application/zz-winassoc-cdr'                                            => 'cdr',
		'application/mac-compactpro'                                                => 'cpt',
		'application/pkix-crl'                                                      => 'crl',
		'application/pkcs-crl'                                                      => 'crl',
		'application/x-x509-ca-cert'                                                => 'crt',
		'application/pkix-cert'                                                     => 'crt',
		'text/css'                                                                  => 'css',
		'text/x-comma-separated-values'                                             => 'csv',
		'text/comma-separated-values'                                               => 'csv',
		'application/vnd.msexcel'                                                   => 'csv',
		'application/x-director'                                                    => 'dcr',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
		'application/x-dvi'                                                         => 'dvi',
		'message/rfc822'                                                            => 'eml',
		'application/x-msdownload'                                                  => 'exe',
		'video/x-f4v'                                                               => 'f4v',
		'audio/x-flac'                                                              => 'flac',
		'video/x-flv'                                                               => 'flv',
		'image/gif'                                                                 => 'gif',
		'application/gpg-keys'                                                      => 'gpg',
		'application/x-gtar'                                                        => 'gtar',
		'application/x-gzip'                                                        => 'gzip',
		'application/mac-binhex40'                                                  => 'hqx',
		'application/mac-binhex'                                                    => 'hqx',
		'application/x-binhex40'                                                    => 'hqx',
		'application/x-mac-binhex40'                                                => 'hqx',
		'text/html'                                                                 => 'html',
		'image/x-icon'                                                              => 'ico',
		'image/x-ico'                                                               => 'ico',
		'image/vnd.microsoft.icon'                                                  => 'ico',
		'text/calendar'                                                             => 'ics',
		'application/java-archive'                                                  => 'jar',
		'application/x-java-application'                                            => 'jar',
		'application/x-jar'                                                         => 'jar',
		'image/jp2'                                                                 => 'jp2',
		'video/mj2'                                                                 => 'jp2',
		'image/jpx'                                                                 => 'jp2',
		'image/jpm'                                                                 => 'jp2',
		'image/jpeg'                                                                => 'jpeg',
		'image/pjpeg'                                                               => 'jpeg',
		'application/x-javascript'                                                  => 'js',
		'application/json'                                                          => 'json',
		'text/json'                                                                 => 'json',
		'application/vnd.google-earth.kml+xml'                                      => 'kml',
		'application/vnd.google-earth.kmz'                                          => 'kmz',
		'text/x-log'                                                                => 'log',
		'audio/x-m4a'                                                               => 'm4a',
		'audio/mp4'                                                                 => 'm4a',
		'application/vnd.mpegurl'                                                   => 'm4u',
		'audio/midi'                                                                => 'mid',
		'application/vnd.mif'                                                       => 'mif',
		'video/quicktime'                                                           => 'mov',
		'video/x-sgi-movie'                                                         => 'movie',
		'audio/mpeg'                                                                => 'mp3',
		'audio/mpg'                                                                 => 'mp3',
		'audio/mpeg3'                                                               => 'mp3',
		'audio/mp3'                                                                 => 'mp3',
		'video/mp4'                                                                 => 'mp4',
		'video/mpeg'                                                                => 'mpeg',
		'application/oda'                                                           => 'oda',
		'audio/ogg'                                                                 => 'ogg',
		'video/ogg'                                                                 => 'ogg',
		'application/ogg'                                                           => 'ogg',
		'font/otf'                                                                  => 'otf',
		'application/x-pkcs10'                                                      => 'p10',
		'application/pkcs10'                                                        => 'p10',
		'application/x-pkcs12'                                                      => 'p12',
		'application/x-pkcs7-signature'                                             => 'p7a',
		'application/pkcs7-mime'                                                    => 'p7c',
		'application/x-pkcs7-mime'                                                  => 'p7c',
		'application/x-pkcs7-certreqresp'                                           => 'p7r',
		'application/pkcs7-signature'                                               => 'p7s',
		'application/pdf'                                                           => 'pdf',
		'application/octet-stream'                                                  => 'pdf',
		'application/x-x509-user-cert'                                              => 'pem',
		'application/x-pem-file'                                                    => 'pem',
		'application/pgp'                                                           => 'pgp',
		'application/x-httpd-php'                                                   => 'php',
		'application/php'                                                           => 'php',
		'application/x-php'                                                         => 'php',
		'text/php'                                                                  => 'php',
		'text/x-php'                                                                => 'php',
		'application/x-httpd-php-source'                                            => 'php',
		'image/png'                                                                 => 'png',
		'image/x-png'                                                               => 'png',
		'application/powerpoint'                                                    => 'ppt',
		'application/vnd.ms-powerpoint'                                             => 'ppt',
		'application/vnd.ms-office'                                                 => 'ppt',
		'application/msword'                                                        => 'doc',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
		'application/x-photoshop'                                                   => 'psd',
		'image/vnd.adobe.photoshop'                                                 => 'psd',
		'audio/x-realaudio'                                                         => 'ra',
		'audio/x-pn-realaudio'                                                      => 'ram',
		'application/x-rar'                                                         => 'rar',
		'application/rar'                                                           => 'rar',
		'application/x-rar-compressed'                                              => 'rar',
		'audio/x-pn-realaudio-plugin'                                               => 'rpm',
		'application/x-pkcs7'                                                       => 'rsa',
		'text/rtf'                                                                  => 'rtf',
		'text/richtext'                                                             => 'rtx',
		'video/vnd.rn-realvideo'                                                    => 'rv',
		'application/x-stuffit'                                                     => 'sit',
		'application/smil'                                                          => 'smil',
		'text/srt'                                                                  => 'srt',
		'image/svg+xml'                                                             => 'svg',
		'application/x-shockwave-flash'                                             => 'swf',
		'application/x-tar'                                                         => 'tar',
		'application/x-gzip-compressed'                                             => 'tgz',
		'image/tiff'                                                                => 'tiff',
		'font/ttf'                                                                  => 'ttf',
		'text/plain'                                                                => 'txt',
		'text/x-vcard'                                                              => 'vcf',
		'application/videolan'                                                      => 'vlc',
		'text/vtt'                                                                  => 'vtt',
		'audio/x-wav'                                                               => 'wav',
		'audio/wave'                                                                => 'wav',
		'audio/wav'                                                                 => 'wav',
		'application/wbxml'                                                         => 'wbxml',
		'video/webm'                                                                => 'webm',
		'image/webp'                                                                => 'webp',
		'audio/x-ms-wma'                                                            => 'wma',
		'application/wmlc'                                                          => 'wmlc',
		'video/x-ms-wmv'                                                            => 'wmv',
		'video/x-ms-asf'                                                            => 'wmv',
		'font/woff'                                                                 => 'woff',
		'font/woff2'                                                                => 'woff2',
		'application/xhtml+xml'                                                     => 'xhtml',
		'application/excel'                                                         => 'xl',
		'application/msexcel'                                                       => 'xls',
		'application/x-msexcel'                                                     => 'xls',
		'application/x-ms-excel'                                                    => 'xls',
		'application/x-excel'                                                       => 'xls',
		'application/x-dos_ms_excel'                                                => 'xls',
		'application/xls'                                                           => 'xls',
		'application/x-xls'                                                         => 'xls',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
		'application/vnd.ms-excel'                                                  => 'xlsx',
		'application/xml'                                                           => 'xml',
		'text/xml'                                                                  => 'xml',
		'text/xsl'                                                                  => 'xsl',
		'application/xspf+xml'                                                      => 'xspf',
		'application/x-compress'                                                    => 'z',
		'application/x-zip'                                                         => 'zip',
		'application/zip'                                                           => 'zip',
		'application/x-zip-compressed'                                              => 'zip',
		'application/s-compressed'                                                  => 'zip',
		'multipart/x-zip'                                                           => 'zip',
		'text/x-scriptzsh'                                                          => 'zsh',
	];

	return isset( $mime_map[ $mime ] ) ? $mime_map[ $mime ] : false;
}

function igd_get_all_child_folders( $folder ) {

	$folder_id  = $folder['id'];
	$account_id = $folder['accountId'];

	$app = App::instance( $account_id );


	$list = [];

	if ( 'computers' == $folder_id ) {
		$files = $app->get_computers_files();
	} elseif ( 'shared-drives' == $folder_id ) {
		$files = $app->get_shared_drives();
	} elseif ( 'shared' == $folder_id ) {
		$files = $app->get_shared_files();
	} elseif ( 'recent' == $folder_id ) {
		$files = $app->get_recent_files();
	} elseif ( 'starred' == $folder_id ) {
		$files = $app->get_starred_files();
	} else {
		$files = $app->get_files( [], $folder_id );
	}

	if ( ! empty( $files['error'] ) ) {
		error_log( 'Integrate Google Drive - Error: ' . $files['error'] );

		return $list;
	}

	if ( ! empty( $files ) ) {
		foreach ( $files as $file ) {

			if ( ! igd_is_dir( $file['type'] ) ) {
				continue;
			}

			$list[]        = $file;
			$child_folders = igd_get_all_child_folders( $file );
			$list          = array_merge( $list, $child_folders );
		}
	}

	return $list;
}

function igd_get_scheduled_interval( $hook ) {
	$schedule  = wp_get_schedule( $hook );
	$schedules = wp_get_schedules();

	return ! empty( $schedules[ $schedule ] ) ? $schedules[ $schedule ]['interval'] : false;
}

function igd_get_shortcodes_array() {
	$shortcodes = Shortcode_Builder::instance()->get_shortcode();

	$formatted = [];

	if ( ! empty( $shortcodes ) ) {
		foreach ( $shortcodes as $shortcode ) {

			$formatted[ $shortcode->id ] = $shortcode->title;
		}
	}

	return $formatted;
}

function igd_download_zip( $file_ids, $request_id = '', $account_id = '' ) {

	$files = [];

	if ( ! empty( $file_ids ) ) {
		$app = App::instance( $account_id );

		foreach ( $file_ids as $file_id ) {
			do_action( 'igd_insert_log', 'download', $file_id, $account_id );

			$files[] = $app->get_file_by_id( $file_id );
		}
	}

	Zip::instance( $files, $request_id )->do_zip();
	exit();
}

function igd_get_free_memory_available() {
	$memory_limit = igd_return_bytes( ini_get( 'memory_limit' ) );

	if ( $memory_limit < 0 ) {
		if ( defined( 'WP_MEMORY_LIMIT' ) ) {
			$memory_limit = igd_return_bytes( WP_MEMORY_LIMIT );
		} else {
			$memory_limit = 1024 * 1024 * 92; // Return 92MB if we can't get any reading on memory limits
		}
	}

	$memory_usage = memory_get_usage( true );

	$free_memory = $memory_limit - $memory_usage;

	if ( $free_memory < ( 1024 * 1024 * 10 ) ) {
		// Return a minimum of 10MB available
		return 1024 * 1024 * 10;
	}

	return $free_memory;
}

function igd_return_bytes( $size_str ) {
	if ( empty( $size_str ) ) {
		return $size_str;
	}

	$unit = substr( $size_str, - 1 );
	if ( ( 'B' === $unit || 'b' === $unit ) && ( ! ctype_digit( substr( $size_str, - 2 ) ) ) ) {
		$unit = substr( $size_str, - 2, 1 );
	}

	switch ( $unit ) {
		case 'M':
		case 'm':
			return (int) $size_str * 1048576;

		case 'K':
		case 'k':
			return (int) $size_str * 1024;

		case 'G':
		case 'g':
			return (int) $size_str * 1073741824;

		default:
			return $size_str;
	}
}

function igd_get_settings( $key = null, $default = null ) {
	$settings = get_option( 'igd_settings', [] );

	if ( ! isset( $settings['notificationEmail'] ) ) {
		$admin_email                   = get_option( 'admin_email' );
		$settings['notificationEmail'] = $admin_email;
	}

	if ( ! isset( $settings['emailReportRecipients'] ) ) {
		$admin_email                       = get_option( 'admin_email' );
		$settings['emailReportRecipients'] = $admin_email;
	}

	if ( empty( $settings ) && ! empty( $default ) ) {
		return $default;
	}

	if ( empty( $key ) ) {
		return ! empty( $settings ) ? $settings : [];
	}

	return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
}

function igd_get_embed_url( $file, $embed_type = 'readOnly', $direct_image = false, $is_preview = false, $popout = false ) {

	$id         = $file['id'];
	$account_id = $file['accountId'];
	$type       = ! empty( $file['type'] ) ? $file['type'] : '';

	$app = App::instance( $account_id );

	if ( ! $app->has_permission( $file ) ) {
		$app->set_permission( $file );
	}

	$arguments = 'preview?rm=demo';

	$is_editable       = in_array( $embed_type, [ 'editable', 'fullEditable' ] );
	$is_full_editable  = $embed_type === 'fullEditable';
	$editable_arguemts = $is_full_editable ? 'edit?usp=drivesdk&rm=embedded&embedded=true' : 'edit?usp=drivesdk&rm=minimal&embedded=true';

	$is_image = in_array( $type, [
		'image/jpeg',
		'image/png',
		'image/svg+xml',
		'image/gif',
		'image/jpg',
		'image/webp',
		'image/heic'
	] );

	if ( ! $is_preview || ! $popout ) {
		if ( in_array( $type, [
			'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.google-apps.document',
		] ) ) {
			$arguments = $is_editable ? $editable_arguemts : 'preview?rm=minimal';
			$url       = "https://docs.google.com/document/d/$id/$arguments";
		} elseif ( ! $is_preview && in_array( $type, [
				'application/vnd.ms-excel',
				'application/vnd.ms-excel.sheet.macroenabled.12',
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'application/vnd.google-apps.spreadsheet',
			] ) ) {
			$arguments = $is_editable ? $editable_arguemts : 'preview';
			$url       = "https://docs.google.com/spreadsheets/d/$id/$arguments";

			if ( ! $is_editable ) {
				$url = "https://drive.google.com/file/d/$id/preview?rm=minimal";
			}

		} elseif ( ! $is_preview && in_array( $type, [
				'application/vnd.ms-powerpoint',
				'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
				'application/vnd.google-apps.presentation',
			] ) ) {
			$arguments = $is_editable ? $editable_arguemts : $arguments;
			$url       = "https://docs.google.com/presentation/d/$id/$arguments";

			if ( ! $is_editable ) {
				$url = "https://drive.google.com/file/d/$id/preview?rm=minimal";
			}
		} elseif ( 'application/vnd.google-apps.folder' == $type ) {
			$url = "https://drive.google.com/open?id=$id";
		} elseif ( 'application/vnd.google-apps.drawing' == $type ) {
			$arguments = $is_editable ? $editable_arguemts : '?';
			$url       = "https://docs.google.com/drawings/d/{$id}{$arguments}";
		} elseif ( 'application/vnd.google-apps.form' == $type ) {
			$arguments = $is_editable ? $editable_arguemts : '?';
			$url       = "https://docs.google.com/forms/d/$id/viewform{$arguments}";
		} else if ( $direct_image && $is_image ) {
			$url = admin_url( "admin-ajax.php?action=igd_get_preview_thumbnail&id=$id&size=large&accountId=$account_id" );
		} else {
			$arguments = $is_editable ? $editable_arguemts : 'preview?rm=minimal';
			$url       = "https://drive.google.com/file/d/$id/$arguments";
		}
	} else {
		$url = "https://drive.google.com/file/d/$id/preview?rm=minimal";
	}


	// Add Resources key to give permission to access the item
	if ( ! empty( $file['resourceKey'] ) ) {
		$url .= "&resourcekey={$file['resourceKey']}";
	}

	return $url;

}

function igd_get_mime_type( $mime, $returnGroup = false ) {

	$mimes = [

		'text' => [
			'application/vnd.oasis.opendocument.text' => 'Text',
			'text/plain'                              => 'Text',
		],

		'file'  => [
			'text/html'                        => 'HTML',
			'text/php'                         => 'PHP',
			'x-httpd-php'                      => 'PHP',
			'text/css'                         => 'CSS',
			'text/js'                          => 'JavaScript',
			'application/javascript'           => 'JavaScript',
			'application/json'                 => 'JSON',
			'application/xml'                  => 'XML',
			'application/x-shockwave-flash'    => 'SWF',
			'video/x-flv'                      => 'FLV',
			'application/vnd.google-apps.file' => 'File',
		],

		// images
		'image' => [
			'application/vnd.google-apps.photo' => 'Photo',
			'image/png'                         => 'PNG',
			'image/jpeg'                        => 'JPEG',
			'image/jpg'                         => 'JPG',
			'image/gif'                         => 'GIF',
			'image/bmp'                         => 'BMP',
			'image/vnd.microsoft.icon'          => 'ICO',
			'image/tiff'                        => 'TIFF',
			'image/tif'                         => 'TIF',
			'image/svg+xml'                     => 'SVG',
		],

		// archives
		'zip'   => [
			'application/zip'                   => 'ZIP',
			'application/x-rar-compressed'      => 'RAR',
			'application/x-msdownload'          => 'EXE',
			'application/vnd.ms-cab-compressed' => 'CAB',
		],

		// audio/video
		'audio' => [
			'audio/mpeg'                        => 'MP3',
			'video/quicktime'                   => 'QT',
			'application/vnd.google-apps.audio' => 'Audio',
			'audio/x-m4a'                       => 'Audio',
			'audio/mp4'                         => 'Audio',
			'audio/ogg'                         => 'Audio',
			'audio/wav'                         => 'Audio',
			'audio/webm'                        => 'Audio',
		],

		'video' => [
			'application/vnd.google-apps.video' => 'Video',
			'video/x-flv'                       => 'Video',
			'video/mp4'                         => 'Video',
			'video/webm'                        => 'Video',
			'video/ogg'                         => 'Video',
			'application/x-mpegURL'             => 'Video',
			'video/MP2T'                        => 'Video',
			'video/3gpp'                        => 'Video',
			'video/quicktime'                   => 'Video',
			'video/x-msvideo'                   => 'Video',
			'video/x-ms-wmv'                    => 'Video',
		],

		// adobe
		'pdf'   => [
			'application/pdf' => 'PDF',
		],

		// ms office
		'word'  => [
			'application/msword' => 'MS Word',
		],

		'doc' => [
			'application/vnd.google-apps.document' => 'Google Docs',
		],

		'excel' => [
			'application/vnd.ms-excel'                                          => 'Excel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel',
		],

		'presentation' => [
			'application/vnd.google-apps.presentation'        => 'Slide',
			'application/vnd.oasis.opendocument.presentation' => 'Presentation'
		],

		'powerpoint' => [
			'application/vnd.ms-powerpoint' => 'Powerpoint',
		],

		'form' => [
			'application/vnd.google-apps.form' => 'Form',
		],

		'folder' => [
			'application/vnd.google-apps.folder' => 'Folder',
		],

		'drawing' => [
			'application/vnd.google-apps.drawing' => 'Drawing',
		],

		'script' => [
			'application/vnd.google-apps.script' => 'Script',
		],

		'sites' => [
			'application/vnd.google-apps.sites' => 'Sites',
		],

		'spreadsheet' => [
			'application/vnd.google-apps.spreadsheet'        => 'Spreadsheet',
			'application/vnd.oasis.opendocument.spreadsheet' => 'Spreadsheet',
		],
	];

	$file_type  = 'File';
	$group_type = 'file';

	foreach ( $mimes as $group => $types ) {
		if ( array_key_exists( $mime, $types ) ) {
			$file_type  = $types[ $mime ];
			$group_type = $group;
			break;
		}
	}

	return $returnGroup ? $group_type : $file_type;

}

function igd_get_mime_icon( $mime ) {
	$mime_type = igd_get_mime_type( $mime, true );

	return IGD_ASSETS . "/images/icons/$mime_type.png";
}

function igd_sanitize_array_bool( $array ) {
	if ( is_array( $array ) && ! empty( $array ) ) {
		foreach ( $array as $key => $value ) {
			if ( 'true' == $value ) {
				$array[ $key ] = true;
			} elseif ( 'false' == $value ) {
				$array[ $key ] = false;
			} else {
				$array[ $key ] = $value;
			}
		}
	}

	return $array;
}

function igd_should_exclude( $excludes = [], $extension = '', $name = '', $is_dir = false ) {
	extract( $excludes );

	//Extensions
	if ( ! $is_dir ) {
		if ( $excludeAllExtensions ) {

			if ( $excludeExceptExtensions ) {

				$exceptExtensions = array_map( function ( $item ) {
					return trim( $item );
				}, explode( ',', $excludeExceptExtensions ) );

				if ( ! in_array( $extension, $exceptExtensions ) ) {
					return true;
				}
			}

		} else {
			if ( $excludeExtensions ) {
				$excludedExtensions = array_map( function ( $item ) {
					return trim( $item );
				}, explode( ',', $excludeExtensions ) );

				if ( in_array( $extension, $excludedExtensions ) ) {
					return true;
				}
			}
		}
	}

	//Names
	if ( $excludeAllNames ) {

		if ( $excludeExceptNames ) {

			$exceptNames = array_map( function ( $item ) {
				return strtolower( trim( $item ) );
			}, explode( ',', $excludeExceptNames ) );

			if ( ! in_array( strtolower( $name ), $exceptNames ) ) {
				return true;
			}
		}

	} else {

		if ( $excludeNames ) {
			$excludedNames = array_map( function ( $item ) {
				return strtolower( trim( $item ) );
			}, explode( ',', $excludeNames ) );

			if ( in_array( strtolower( $name ), $excludedNames ) ) {
				return true;
			}
		}
	}

	return false;
}

function igd_delete_cache() {
	$active_account = Account::get_active_account();
	$account_id     = ! empty( $active_account ) ? $active_account['id'] : null;

	// Delete folder cache
	delete_option( 'igd_cached_folders' );

	// Delete files
	Files::instance( $account_id )->delete_account_files();

	// Delete thumbnails
	//igd_delete_thumbnail_cache();
}

function igd_color_brightness( $hex, $steps ) {

	// return if not hex color
	if ( ! preg_match( '/^#([a-f0-9]{3}){1,2}$/i', $hex ) ) {
		return $hex;
	}

	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( - 255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return      = '#';

	foreach ( $color_parts as $color ) {
		$color  = hexdec( $color ); // Convert to decimal
		$color  = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}

function igd_hex2rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if ( empty( $color ) ) {
		return $default;
	}

	//Sanitize $color if "#" is provided
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb = array_map( 'hexdec', $hex );

	//Check if opacity is set(rgba or rgb)
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ",", $rgb ) . ')';
	}

	//Return rgb(a) color string
	return $output;
}

function igd_get_user_gravatar( $user_id, $size = 32 ) {
	$user = get_user_by( 'id', $user_id );

	if ( function_exists( 'get_wp_user_avatar' ) ) {
		$gravatar = get_wp_user_avatar( $user->user_email, $size );
	} else {
		$gravatar = get_avatar( $user->user_email, $size );
	}

	if ( empty( $gravatar ) ) {
		$gravatar = sprintf( '<img src="%s/images/user-icon.png" height="%s" />', IGD_ASSETS, $size );
	}

	return $gravatar;
}

function igd_get_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		//check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		//to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}




