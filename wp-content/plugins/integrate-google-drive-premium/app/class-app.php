<?php

namespace IGD;

defined( 'ABSPATH' ) || exit();


class App {


	protected static $instance = null;

	public $client;
	private $service;
	public $account_id = null;

	public $file_fields = 'capabilities(canEdit,canRename,canDelete,canShare,canTrash,canMoveItemWithinDrive),shared,sharedWithMeTime,description,fileExtension,iconLink,id,driveId,imageMediaMetadata(height,rotation,width,time),mimeType,createdTime,modifiedTime,name,ownedByMe,parents,size,thumbnailLink,trashed,videoMediaMetadata(height,width,durationMillis),webContentLink,webViewLink,exportLinks,permissions(id,type,role,domain),copyRequiresWriterPermission,shortcutDetails,resourceKey';
	public $list_fields = 'files(capabilities(canEdit,canRename,canDelete,canShare,canTrash,canMoveItemWithinDrive),shared,sharedWithMeTime,description,fileExtension,iconLink,id,driveId,imageMediaMetadata(height,rotation,width,time),mimeType,createdTime,modifiedTime,name,ownedByMe,parents,size,thumbnailLink,trashed,videoMediaMetadata(height,width,durationMillis),webContentLink,webViewLink,exportLinks,permissions(id,type,role,domain),copyRequiresWriterPermission,shortcutDetails,resourceKey),nextPageToken';

	public function __construct( $account_id = null ) {

		if ( empty( $account_id ) && ! empty( Account::get_active_account()['id'] ) ) {
			$account_id = Account::get_active_account()['id'];
		}

		$this->account_id = $account_id;

		$this->client = Client::instance( $account_id )->get_client();

		if ( ! class_exists( 'IGDGoogle_Service_Drive' ) ) {
			require_once IGD_PATH . '/vendors/Google-sdk/src/Google/Service/Drive.php';
		}

		$this->service = new \IGDGoogle_Service_Drive( $this->client );
	}

	/**
	 * Get files
	 *
	 * @param array $query
	 * @param null $folder
	 * @param false $is_search
	 * @param string[] $sort
	 *
	 * @return array
	 */
	public function get_files( $params = [], $folder_id = '', $sort = [], $from_server = false ) {

		$active_account = Account::get_active_account();

		$folder_id = ! empty( $folder_id ) ? $folder_id : $active_account['root_id'];

		// If not search, get the result from the cache
		if ( igd_is_cached_folder( $folder_id ) && ! $from_server ) {
			$files = Files::instance( $this->account_id )->get( $folder_id );
		}

		// If is search or no cache exits get the files directly from server
		if ( $from_server || empty( $files ) ) {

			$is_recent = 'recent' == $folder_id;

			$default_params = array(
				'fields'                    => $this->list_fields,
				'pageSize'                  => $is_recent ? 100 : 500,
				'orderBy'                   => "folder,name",
				'q'                         => "trashed=false and '$folder_id' in parents",
				'supportsAllDrives'         => true,
				'includeItemsFromAllDrives' => true,
			);

			$params = wp_parse_args( $params, $default_params );

			$next_page_token = null;
			$items           = [];

			do {

				if ( ! empty( $next_page_token ) ) {
					$params['pageToken'] = $next_page_token;
				}

				try {
					$response = $this->service->files->listFiles( $params );
					$items    = array_merge( $items, $response->getFiles() );

					if ( ! $is_recent ) {
						$next_page_token = $response->getNextPageToken();
					}

				} catch ( \Exception $e ) {

					error_log( 'Integrate Google Drive: ' . sprintf( 'API Error On Line %s: %s', __LINE__, $e->getMessage() ) );

					return [ 'error' => sprintf( '<strong>%s</strong> - %s', __( 'Server error', 'integrate-google-drive' ), __( 'Couldn\'t connect to the Google drive API server.', 'integrate-google-drive' ) ) ];
				}

			} while ( ! empty( $next_page_token ) );

			$files = [];

			if ( empty( $items ) ) {
				return [];
			}

			foreach ( $items as $item ) {
				$files[] = igd_file_map( $item, $this->account_id );
			}

			// Save files to cache if not search
			if ( $folder_id ) {

				//filter computer files
				if ( 'computers' == $folder_id ) {
					$new_files = [];

					foreach ( $files as $file ) {

						if ( ! empty( $file['parents'] ) ) {
							continue;
						}

						$new_files[] = $file;
					}

					$files = $new_files;
				}

				Files::instance( $this->account_id )->set( $files, $folder_id );

				//Add folder to the cache list
				igd_update_cached_folders( $folder_id );
			}

		}

		// Sort files
		if ( 'recent' != $folder_id && ! empty( $files ) ) {

			$files = $this->sort_files( $files, $sort );

			// Move folders to the top
			$folders = [];
			$files   = array_filter( $files, function ( $file ) use ( &$folders ) {

				if ( igd_is_dir( $file['type'] ) || ( igd_is_shortcut( $file['type'] ) && igd_is_dir( $file['shortcutDetails']['targetMimeType'] ) ) ) {
					$folders[] = $file;

					return false;
				}

				return true;
			} );

			$files = array_merge( $folders, $files );
		}

		return $files;
	}

	public function sort_files( $files, $sort ) {

		if ( empty( $sort ) ) {
			$sort = [ 'sortBy' => 'name', 'sortDirection' => 'asc' ];
		}

		$sort_by        = $sort['sortBy'];
		$sort_direction = $sort['sortDirection'] === 'asc' ? SORT_ASC : SORT_DESC;

		$sort_array = array_column( $files, $sort_by );
		if ( in_array( $sort_by, [ 'created', 'updated' ] ) ) {
			$sort_array = array_map( 'strtotime', $sort_array );
		}

		array_multisort( $sort_array, $sort_direction, SORT_NATURAL | SORT_FLAG_CASE, $files );

		return $files;
	}

	public function get_root_files( $sort = [] ) {
		$args['q'] = "'me' in owners and trashed=false and 'root' in parents";

		return $this->get_files( $args, 'root', $sort );
	}

	public function get_computers_files( $sort = [] ) {
		$args['q'] = "'me' in owners and mimeType='application/vnd.google-apps.folder' and trashed=false";

		return $this->get_files( $args, 'computers', $sort );
	}

	public function get_recent_files() {
		$args['orderBy'] = "recency desc";
		$args['q']       = "mimeType!='application/vnd.google-apps.folder' and mimeType!='application/vnd.google-apps.shortcut' and trashed=false";

		return $this->get_files( $args, 'recent' );
	}

	public function get_starred_files( $sort = [] ) {
		$args['q'] = "starred=true";

		return $this->get_files( $args, 'starred', $sort );
	}

	public function get_shared_files( $sort = [] ) {
		$params['q'] = "sharedWithMe=true";

		return $this->get_files( $params, 'shared', $sort );
	}

	public function get_search_files( $keyword, $folders = [], $sort = [], $full_text_search = true, $file_numbers = 1000 ) {

		$params = array(
			'fields'   => $this->list_fields,
			'pageSize' => $file_numbers < 0 ? 1000 : $file_numbers,
			'orderBy'  => "", // Order by not supported in fullText search
			'q'        => "fullText contains '{$keyword}' and trashed = false",
		);

		if ( ! $full_text_search ) {
			$params['q']       = "name contains '{$keyword}' and trashed = false";
			$params['orderBy'] = 'folder,name';
		}

		$files = [];

		$look_in_to = [];
		if ( ! empty( $folders ) ) {
			foreach ( $folders as $key => $folder ) {

				if ( in_array( $folder['id'], [
					$this->get_root_id(),
					'root',
					'computers',
					'shared-drives',
					'shared',
					'recent',
					'starred'
				] ) ) {
					continue;
				}

				// Skip if not a folder
				if ( ! igd_is_dir( $folder['type'] ) || ( ! empty( $folder['shortcutDetails'] ) && ! igd_is_dir( $folder['shortcutDetails']['targetMimeType'] ) ) ) {

					if ( strpos( $folder['name'], $keyword ) !== false ) {
						$files[] = $folder;
					}

					continue;
				}

				if ( ! empty( $folder['shortcutDetails'] ) ) {
					$folder_id       = $folder['shortcutDetails']['targetId'];
					$folder          = $this->get_file_by_id( $folder_id );
					$folders[ $key ] = $folder;
				}

				$look_in_to[] = $folder['id'];

				$child_folders     = igd_get_all_child_folders( $folder );
				$child_folders_ids = wp_list_pluck( $child_folders, 'id' );
				$look_in_to        = array_merge( $look_in_to, $child_folders_ids );
			}
		}


		// Maximum 99 parents per request
		$requests = array_chunk( $look_in_to, 99, true );

		if ( ! empty( $requests ) ) {
			foreach ( $requests as $request_folder_ids ) {
				if ( 1 === count( $request_folder_ids ) ) {
					$parents_query = " and ('" . $folders[0]['id'] . "' in parents) ";
				} else {
					$parents_query = " and ('" . implode( "' in parents or '", $request_folder_ids ) . "' in parents) ";
				}

				$params['q'] = "fullText contains '{$keyword}' {$parents_query} and trashed = false";
				if ( ! $full_text_search ) {
					$params['q'] = "name contains '{$keyword}' {$parents_query} and trashed = false";
				}

				$items = $this->get_files( $params, '', $sort, true );
				if ( ! empty( $items ) ) {
					$files = array_merge( $files, $items );
				}

			}
		} else {
			$items = $this->get_files( $params, '', $sort, true );
			if ( ! empty( $items ) ) {
				$files = array_merge( $files, $items );
			}
		}

		return $files;

	}

	public function get_shared_drives() {

		// Get the result from the cache
		if ( igd_is_cached_folder( 'shared-drives' ) ) {
			$files = Files::instance( $this->account_id )->get( 'shared-drives' );

			return $files;
		}

		$shared_drives = [];
		$params        = [
			'fields'   => 'kind,nextPageToken,drives(kind,id,name,capabilities,backgroundImageFile,backgroundImageLink,createdTime,hidden)',
			'pageSize' => 50,
		];

		$next_page_token = null;

		// Get all files in folder
		while ( $next_page_token || null === $next_page_token ) {
			try {
				if ( null !== $next_page_token ) {
					$params['pageToken'] = $next_page_token;
				}

				$more_drives     = $this->service->drives->listDrives( $params );
				$shared_drives   = array_merge( $shared_drives, $more_drives->getDrives() );
				$next_page_token = ( null !== $more_drives->getNextPageToken() ) ? $more_drives->getNextPageToken() : false;
			} catch ( \Exception $ex ) {
				error_log( $ex->getMessage() );

				return [];
			}
		}

		$files = [];

		if ( ! empty( $shared_drives ) ) {

			foreach ( $shared_drives as $key => $drive ) {
				$drive = $drive->toSimpleObject();

				$file = [
					'id'            => $drive->id,
					'name'          => $drive->name,
					'iconLink'      => $drive->backgroundImageLink,
					'thumbnailLink' => $drive->backgroundImageLink,
					'created'       => $drive->createdTime,
					'hidden'        => $drive->hidden,
					'shared-drives' => true,
					'accountId'     => $this->account_id,
					'type'          => 'application/vnd.google-apps.folder',
					'parents'       => [ 'shared-drives' ],
				];

				$file['permissions'] = $drive->capabilities;

				$files[] = $file;
			}
		}

		Files::instance( $this->account_id )->set( $files, 'shared-drives' );

		//Add folder to the cache list
		igd_update_cached_folders( 'shared-drives' );

		return $files;

	}


	/**
	 * Get file item by file id
	 *
	 * @param $id
	 *
	 * @return array|false|mixed|void
	 */
	public function get_file_by_id( $id, $from_server = false ) {

		// Get cache file
		if ( ! $from_server ) {
			$file = Files::instance( $this->account_id )->get_file_by_id( $id );
		}

		// If no cache file then get file from server
		if ( empty( $file ) || $from_server ) {

			$item = $this->getService()->files->get( $id, [
				'supportsAllDrives' => true,
				'fields'            => $this->file_fields,
			] );

			// Skip errors if folder is not found
			if ( ! is_object( $item ) || ! method_exists( $item, 'getId' ) ) {
				return false;
			}

			//check if file is in trash
			if ( $item->trashed ) {
				return false;
			}

			$file = igd_file_map( $item, $this->account_id );

			Files::instance( $this->account_id )->add_file( $file );
		}

		return $file;
	}

	/**
	 * Get file item by file name
	 *
	 * @param $name
	 * @param null $parent_folder
	 *
	 * @return false|mixed
	 */
	public function get_file_by_name( $name, $parent_folder = null ) {

		$items = $this->get_files( [], $parent_folder );

		$file = false;

		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				if ( $item['name'] == $name ) {
					$file = $item;
					break;
				}
			}
		}

		return $file;
	}

	/**
	 * Create new folder
	 *
	 * @param $folder_name
	 * @param $parent_folder array | string
	 *
	 * @return array
	 */
	public function new_folder( $folder_name, $parent_folder ) {

		if ( empty( $parent_folder ) ) {
			$parent_folder = Account::get_active_account()['root_id'];
		}

		$parent_folder_id = ! empty( $parent_folder['id'] ) ? $parent_folder['id'] : $parent_folder;

		$params = [
			'fields'              => $this->file_fields,
			'supportsAllDrives'   => true,
			'enforceSingleParent' => true
		];

		$request = $this->getService()->files->create( new \IGDGoogle_Service_Drive_DriveFile( [
			'name'     => $folder_name,
			'parents'  => [ $parent_folder_id ],
			'mimeType' => 'application/vnd.google-apps.folder'
		] ), $params );

		// add new folder to cache
		$item = igd_file_map( $request, $this->account_id );

		Files::instance( $this->account_id )->add_file( $item );

		return $item;
	}

	/**
	 * Move Files
	 *
	 * @param $file_ids
	 * @param $newParentId
	 *
	 * @return string|void
	 */
	public function move_file( $file_ids, $newParentId ) {

		try {

			$emptyFileMetadata = new \IGDGoogle_Service_Drive_DriveFile();

			if ( ! empty( $file_ids ) ) {
				foreach ( $file_ids as $file_id ) {
					// Retrieve the existing parents to remove
					$file = $this->get_file_by_id( $file_id );

					$previousParents = join( ',', $file['parents'] );

					// Move the file to the new folder
					$file = $this->service->files->update( $file_id, $emptyFileMetadata, array(
						'addParents'    => $newParentId,
						'removeParents' => $previousParents,
						'fields'        => $this->file_fields,
					) );

					//Update cached file
					if ( $file->getId() ) {
						Files::instance( $this->account_id )->update_file(
							[
								'parent_id' => $newParentId,
								'data'      => serialize( igd_file_map( $file, $this->account_id ) ),
							],
							[ 'id' => $file_id ]
						);
					}

				}
			}

		} catch ( \Exception $e ) {
			return "An error occurred: " . $e->getMessage();
		}
	}

	/**
	 * Rename file
	 *
	 * @param $name
	 * @param $file_id
	 *
	 * @return \IGDGoogle_Http_Request|\IGDGoogle_Service_Drive_DriveFile|string
	 */
	public function rename( $name, $file_id ) {
		try {

			$fileMetadata = new \IGDGoogle_Service_Drive_DriveFile();
			$fileMetadata->setName( $name );

			// Move the file to the new folder
			$file = $this->service->files->update( $file_id, $fileMetadata, array(
				'fields' => $this->file_fields,
			) );

			//Update cached file
			if ( $file->getId() ) {
				Files::instance( $this->account_id )->update_file( [
					'name' => $name,
					'data' => serialize( igd_file_map( $file, $this->account_id ) ),
				], [ 'id' => $file_id ] );
			}

			return $file;
		} catch ( \Exception $e ) {
			return "An error occurred: " . $e->getMessage();
		}
	}


	public function copy( $files ) {

		try {
			$this->client->setUseBatch( true );

			$batch    = new \IGDGoogle_Http_Batch( $this->client );
			$metaData = new \IGDGoogle_Service_Drive_DriveFile();

			foreach ( $files as $file ) {
				$metaData->setName( 'Copy of ' . $file['name'] );

				$batch->add( $this->service->files->copy( $file['id'], $metaData, [ 'fields' => $this->file_fields ] ) );
			}

			$batch_result = $batch->execute();

			$copied_files = [];
			foreach ( $batch_result as $file ) {
				if ( ! empty( $file->getId() ) ) {
					$file = igd_file_map( $file, $this->account_id );
					Files::instance( $this->account_id )->add_file( $file );

					$copied_files[] = $file;
				}
			}

			$this->client->setUseBatch( false );

			return $copied_files;

		} catch ( \Exception $e ) {
			$this->client->setUseBatch( false );

			return "An error occurred: " . $e->getMessage();
		}
	}

	public function copy_folder( $folder, $parent_id ) {

		if ( empty( $folder ) || empty( $parent_id ) ) {
			return false;
		}

		$folder_id = ! empty( $folder['id'] ) ? $folder['id'] : $folder;

		// Check if folder has files
		$files = $this->get_files( [], $folder_id );

//		// Parent files
//		$parent_files = $this->get_files( [], $parent_id );

//		// Filter files that are not in parent folder by name and type
//		$files = array_filter( $files, function ( $file ) use ( $parent_files ) {
//			$parent_file = array_filter( $parent_files, function ( $parent_file ) use ( $file ) {
//				return $parent_file['name'] == $file['name'] && $parent_file['type'] == $file['type'];
//			} );
//
//			return empty( $parent_file );
//		} );

		if ( empty( $files ) ) {
			return false;
		}

		$batch          = new \IGDGoogle_Http_Batch( $this->client );
		$batch_requests = 0;
		$this->client->setUseBatch( true );


		foreach ( $files as $file ) {

			if ( igd_is_dir( $file['type'] ) ) {
				//Create new folder in parent folder
				$new_folder = new \IGDGoogle_Service_Drive_DriveFile();
				$new_folder->setName( $file['name'] );
				$new_folder->setMimeType( 'application/vnd.google-apps.folder' );
				$new_folder->setParents( [ $parent_id ] );

				$batch->add( $this->service->files->create( $new_folder, [
					'fields'            => $this->file_fields,
					'supportsAllDrives' => true
				] ), $file['id'] );
			} else {
				// Copy file to new folder
				$new_file = new \IGDGoogle_Service_Drive_DriveFile();
				$new_file->setName( $file['name'] );
				$new_file->setParents( [ $parent_id ] );

				$batch->add( $this->service->files->copy( $file['id'], $new_file, [
					'fields'            => $this->file_fields,
					'supportsAllDrives' => true
				] ), $file['id'] );
			}

			++ $batch_requests;
		}

		// Execute the Batch Call
		try {
			usleep( 20000 * $batch_requests );
			@set_time_limit( 30 );

			$batch_result = $batch->execute();
		} catch ( \Exception $ex ) {
			error_log( '[Integrate Google Drive Message]: ' . sprintf( 'API Error on line %s: %s', __LINE__, $ex->getMessage() ) );

			return false;
		}

		$this->client->setUseBatch( false );

		foreach ( $batch_result as $key => $file ) {

			$file = igd_file_map( $file, $this->account_id );
			Files::instance( $this->account_id )->add_file( $file );

			if ( igd_is_dir( $file['type'] ) ) {
				$original_id   = str_replace( 'response-', '', $key );
				$original_file = array_filter( $files, function ( $item ) use ( $original_id ) {
					return $item['id'] == $original_id;
				} );
				$original_file = array_shift( $original_file );
				$new_id        = $file['id'];

				$this->copy_folder( $original_file, $new_id );
			}
		}
	}

	/**
	 * Delete files
	 *
	 * @param $file_ids
	 *
	 * @return string|void
	 */
	public function delete( $file_ids, $account_id = null ) {
		try {
			$this->client->setUseBatch( true );

			$batch = new \IGDGoogle_Http_Batch( $this->client );

			foreach ( $file_ids as $file_id ) {
				do_action( 'igd_insert_log', 'delete', $file_id, $account_id );

				$batch->add( $this->service->files->delete( $file_id ) );
				Files::instance( $this->account_id )->delete( [ 'id' => $file_id ] );
			}

			$batch->execute();

		} catch ( \Exception $e ) {
			return "An error occurred: " . $e->getMessage();
		}
	}

	/**
	 * Google Drive Service Instance
	 *
	 * @return \IGDGoogle_Service_Drive
	 */
	public function getService() {
		return $this->service;
	}

	public function get_root_id() {
		if ( $this->account_id ) {
			$account = Account::get_accounts( $this->account_id );
		} else {
			$account = Account::get_active_account();
		}

		if ( ! empty( $account ) ) {
			return $account['root_id'];
		}

		return 'root';

	}

	/**
	 * Render File Browser
	 */
	public static function view() { ?>
        <div id="igd-app" class="igd-app"></div>
	<?php }


	/**
	 * Check if file is public
	 *
	 * @param string[] $permission_role
	 * @param false $force_update
	 *
	 * @return bool
	 * @throws \IGDGoogle_IO_Exception
	 */
	public function has_permission( $file = [], $permission_role = [ 'reader', 'writer' ], $force_update = false ) {


		$permission_domain = igd_get_settings( 'workspaceDomain' );
		$permission_type   = ! empty( $permission_domain ) ? 'domain' : 'anyone';

		if ( ! empty( $file['permissions'] ) ) {
			$file_permissions = $file['permissions'];

			$users = $file_permissions['users'];

			// If the permissions are not yet set, grab them via the API
			if ( ( empty( $users ) && $file_permissions['canShare'] ) || $force_update ) {
				$users = [];

				$params = [
					'fields'            => 'permissions(id,role,type,domain)',
					'pageSize'          => 100,
					'supportsAllDrives' => true,
				];

				$next_page_token = null;

				// Get all files in folder
				while ( $next_page_token || null === $next_page_token ) {
					try {
						if ( null !== $next_page_token ) {
							$params['pageToken'] = $next_page_token;
						}

						$more_permissions = $this->service->permissions->listPermissions( $file['id'], $params );
						$users            = array_merge( $users, $more_permissions->getPermissions() );
						$next_page_token  = ( null !== $more_permissions->getNextPageToken() ) ? $more_permissions->getNextPageToken() : false;
					} catch ( \Exception $ex ) {
						error_log( 'Integrate Google : Error ' . sprintf( 'API Error on line %s: %s', __LINE__, $ex->getMessage() ) );

						return false;
					}
				}

				$permission_users = [];
				foreach ( $users as $user ) {
					$permission_users[ $user->getId() ] = [
						'type'   => $user->getType(),
						'role'   => $user->getRole(),
						'domain' => $user->getDomain()
					];
				}

				$file['permissions']['users'] = $permission_users;

				Files::instance( $this->account_id )->update_file(
					[ 'data' => serialize( $file ) ],
					[ 'id' => $file['id'] ]
				);

			}

			$users = (array) $file_permissions['users'];

			if ( count( $users ) > 0 ) {
				foreach ( $users as $user ) {

					$user = (array) $user;

					if ( ( $user['type'] == $permission_type ) && ( in_array( $user['role'], $permission_role ) ) && ( $user['domain'] == $permission_domain ) ) {
						return true;
					}
				}
			}
		}

		/* For shared files not owned by account, the sharing permissions cannot be viewed or set.
		 * In that case, just check if the file is public shared
		 */
		if ( in_array( 'reader', $permission_role ) ) {
			$check_url = 'https://drive.google.com/file/d/' . $file['id'] . '/view';

			// Add Resources key to give permission to access the item via a shared link
			if ( ! empty( $file['resourceKey'] ) ) {
				$check_url .= "&resourcekey={$file['resourceKey']}";
			}


			$request = new \IGDGoogle_Http_Request( $check_url, 'GET' );
			$this->client->getIo()->setOptions( [ CURLOPT_FOLLOWLOCATION => 0 ] );
			$httpRequest = $this->client->getIo()->makeRequest( $request );
			curl_close( $this->client->getIo()->getHandler() );

			if ( 200 == $httpRequest->getResponseHttpCode() ) {

				$users['anyoneWithLink'] = [
					'domain' => $permission_domain,
					'role'   => "reader",
					'type'   => "anyone",
				];

				$file['permissions']['users'] = $users;

				Files::instance( $this->account_id )->update_file(
					[ 'data' => serialize( $file ) ],
					[ 'id' => $file['id'] ]
				);

				return true;
			}

		}


		return false;
	}

	/**
	 * Set file permission to public
	 *
	 * @param string $permission_role
	 *
	 * @return bool
	 */
	public function set_permission( $file = [], $permission_role = 'reader' ) {

		$permission_domain = igd_get_settings( 'workspaceDomain' );
		$permission_type   = ! empty( $permission_domain ) ? 'domain' : 'anyone';

		$file_permissions = (array) $file['permissions'];

		// Check if manage permission is allowed
		$manage_permissions = igd_get_settings( 'manageSharing', true );

		// Set new permission if needed
		if ( $manage_permissions && $file_permissions['canShare'] ) {

			$new_permission = new \IGDGoogle_Service_Drive_Permission();
			$new_permission->setType( $permission_type );
			$new_permission->setRole( $permission_role );
			$new_permission->setAllowFileDiscovery( false );

			if ( $permission_domain ) {
				$new_permission->setDomain( $permission_domain );
			}

			$params = [
				'fields'            => 'permissions(id,role,type,domain)',
				'supportsAllDrives' => true,
			];

			try {
				$updated_permission = $this->service->permissions->create( $file['id'], $new_permission, $params );

				$users                                 = (array) $file_permissions['users'];
				$users[ $updated_permission->getId() ] = [
					'type'   => $updated_permission->getType(),
					'role'   => $updated_permission->getRole(),
					'domain' => $updated_permission->getDomain()
				];

				$file['permissions']['users'] = $users;

				Files::instance( $this->account_id )->update_file(
					[ 'data' => serialize( $file ) ],
					[ 'id' => $file['id'] ]
				);

				return true;
			} catch ( \Exception $ex ) {
				error_log( 'Integrate Google Drive: Manage Permissions Error - ' . sprintf( 'API Error on line %s: %s', __LINE__, $ex->getMessage() ) );

				return false;
			}
		}

		return false;
	}

	public static function instance( $account_id = null ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $account_id );
		} elseif ( ! is_null( $account_id ) ) {
			self::$instance->account_id = $account_id;
		} elseif ( ! empty( self::$instance->account_id ) && ( self::$instance->account_id != $account_id ) ) {
			self::$instance->account_id = $account_id;
		}

		return self::$instance;
	}

}