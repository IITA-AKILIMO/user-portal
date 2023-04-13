<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class WooCommerce_Uploads {

	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {

		// Add Product Type
		add_filter( 'product_type_options', [ $this, 'add_uploadable_product_option' ] );

		// Add Product Data Tab
		add_filter( 'woocommerce_product_data_tabs', [ $this, 'add_product_data_tab' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'add_product_data_tab_content' ] );

		// Save product meta
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_product_meta' ] );
		add_action( 'woocommerce_process_product_meta_variable', [ $this, 'save_product_meta' ] );
		add_action( 'woocommerce_ajax_save_product_variations', [ $this, 'save_product_meta' ] );
		add_action( 'woocommerce_process_product_meta_composite', [ $this, 'save_product_meta' ] );

		// Admin order page details
		add_action( 'woocommerce_admin_order_item_headers', [ $this, 'admin_order_item_headers' ] );
		add_action( 'woocommerce_admin_order_item_values', [ $this, 'admin_order_item_values' ], 10, 3 );


		//Add product page uploader
		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'render_product_page_uploader' ] );

		// Render Order Received Page Upload Box
		add_action( 'woocommerce_order_item_meta_end', [ $this, 'render_order_received_uploader' ], 10, 3 );

		// Change Thank You Text
		add_filter( 'woocommerce_thankyou_order_received_text', [ $this, 'change_order_received_text' ], 10, 2 );

		// Add Upload button to my Order Table
		add_filter( 'woocommerce_my_account_my_orders_actions', [ $this, 'add_orders_column_actions' ], 10, 2 );

		// Add cart page uploader
		add_filter( 'woocommerce_after_cart_item_name', [ $this, 'render_cart_page_uploader' ] );

		// Render checkout page upload box
		add_action( 'woocommerce_after_order_notes', [ $this, 'render_checkout_uploader' ] );

		// Save files to order on checkout
		add_action( 'woocommerce_new_order_item', [ $this, 'save_checkout_uploads' ], 10, 3 );

	}

	public function add_product_data_tab( $product_data_tabs ) {

		$product_data_tabs['upload_options'] = [
			'label'  => __( 'Upload Options', 'integrate-google-drive' ),
			'target' => 'upload_options',
			'class'  => [ 'show_if_uploadable' ],
		];

		return $product_data_tabs;
	}

	public function add_orders_column_actions( $actions, \WC_Order $order ) {
		$upload_btn_text           = __( 'Upload Documents', 'integrate-google-drive' );
		$should_show_upload_button = false;

		if ( $this->requires_order_uploads( $order ) ) {

			foreach ( $order->get_items() as $order_item ) {
				$product    = $this->get_product( $order_item );
				$product_id = $product->get_id();

				$requires_upload = $this->requires_product_uploads( $product, $order );

				if ( ! $requires_upload ) {
					$should_show_upload_button = false;
					continue;
				}

				if ( $this->is_dokan_active() ) {
					$upload_locations = $this->get_dokan_upload_locations( $product_id );

					if ( in_array( 'my-account', $upload_locations ) ) {
						$should_show_upload_button = true;
					}

				} elseif ( in_array( 'my-account', $this->get_woocommerce_upload_locations() ) ) {
					$should_show_upload_button = true;
				}


				if ( 'variation' === $product->get_type() ) {
					$product = wc_get_product( $product->get_parent_id() );
				}

				$upload_btn_text = get_post_meta( $product->get_id(), '_igd_upload_button_text', true );

				break;
			}

			if ( $should_show_upload_button ) {
				$actions['upload'] = [
					'url'  => $order->get_view_order_url() . '#igd-uploads',
					'name' => $upload_btn_text,
				];
			}
		}

		return $actions;
	}

	public function change_order_received_text( $thank_you_text, $order ) {

		if ( ! $this->requires_order_uploads( $order ) ) {
			return $thank_you_text;
		}


		$should_show_upload_button = false;


		foreach ( $order->get_items() as $order_item ) {
			$product    = $this->get_product( $order_item );
			$product_id = $product->get_id();

			$requires_upload = $this->requires_product_uploads( $product, $order );

			if ( ! $requires_upload ) {
				$should_show_upload_button = false;
				continue;
			}

			if ( $this->is_dokan_active() ) {
				$upload_locations = $this->get_dokan_upload_locations( $product_id );

				if ( in_array( 'my-account', $upload_locations ) && in_array( 'order-received', $upload_locations ) ) {
					$should_show_upload_button = true;
				}

			} elseif ( in_array( 'my-account', $this->get_woocommerce_upload_locations() ) && in_array( 'order-received', $this->get_woocommerce_upload_locations() ) ) {
				$should_show_upload_button = true;
			}

			break;

		}

		if ( ! $should_show_upload_button ) {
			return $thank_you_text;
		}

		$order_url = $order->get_view_order_url() . '#igd-uploads';

		$custom_text    = ' ' . sprintf( esc_html__( 'You can now %s start uploading your documents %s', 'integrate-google-drive' ), '<a href="' . $order_url . '">', '</a>' ) . '.';
		$thank_you_text .= apply_filters( 'igd_wc_thank_you_text', $custom_text, $order, $this );


		return $thank_you_text;
	}

	public function admin_order_item_headers( $order ) {
		if ( ! $this->requires_order_uploads( $order ) ) {
			return;
		}

		?>
        <th><?php esc_html_e( 'Uploaded Files', 'integrate-google-drive' ); ?></th>
		<?php

	}

	public function admin_order_item_values( $_product, $item, $item_id ) {

		if ( ! $this->requires_order_uploads( $item->get_order() ) ) {
			return;
		}

		if ( ! $this->requires_product_uploads( $_product, $item->get_order() ) ) {
			return;
		}

		$files = wc_get_order_item_meta( $item_id, '_igd_files', false );

		if ( empty( $files ) ) {
			return;
		}

		?>
        <td class="igd-wc-uploaded-files-wrap">
            <ul class="igd-wc-uploaded-files">
				<?php foreach ( $files as $file ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $file['webViewLink'] ); ?>" target="_blank">
                            <img src="<?php echo esc_url( $file['iconLink'] ); ?>"
                                 alt="<?php echo esc_attr( $file['name'] ); ?>"/>
                            <span><?php echo esc_html( $file['name'] ); ?></span>
                        </a>
                    </li>
				<?php endforeach; ?>
            </ul>
        </td>
		<?php
	}

	public function is_dokan_active() {
		$integrations    = igd_get_settings( 'integrations' );
		$is_dokan_upload = igd_get_settings( 'dokanUpload', false );

		return in_array( 'dokan', $integrations ) && $is_dokan_upload && class_exists( 'WeDevs_Dokan' );
	}

	public function get_dokan_upload_locations( $product_id ) {
		$upload_locations = get_user_meta( get_post_field( 'post_author', $product_id ), '_igd_dokan_upload_locations', true );

		return is_array( $upload_locations ) ? $upload_locations : array( 'checkout', 'order-received', 'my-account' );
	}


	public function render_product_page_uploader() {
		global $product;

		//check if dokan
		if ( $this->is_dokan_active() ) {
			$product_id       = get_the_ID();
			$upload_locations = $this->get_dokan_upload_locations( $product_id );

			if ( ! in_array( 'product', $upload_locations ) ) {
				return;
			}
		} elseif ( ! in_array( 'product', $this->get_woocommerce_upload_locations() ) ) {
			return;
		}


		$this->render_uploader( $product );
	}

	public function render_cart_page_uploader( $cart_item ) {
		$product_id = $cart_item['product_id'];
		$product    = wc_get_product( $product_id );

		//check if dokan
		if ( $this->is_dokan_active() ) {
			$upload_locations = $this->get_dokan_upload_locations( $product_id );

			if ( ! in_array( 'cart', $upload_locations ) ) {
				return;
			}
		} elseif ( ! in_array( 'cart', $this->get_woocommerce_upload_locations() ) ) {
			return;
		}

		$this->render_uploader( $product );

	}

	public function render_checkout_uploader() {
		$cart_items = WC()->cart->get_cart();

		foreach ( $cart_items as $cart_item_key => $cart_item ) {
			$product_id = $cart_item['product_id'];
			$product    = wc_get_product( $product_id );

			//check if dokan
			if ( $this->is_dokan_active() ) {
				$upload_locations = $this->get_dokan_upload_locations( $product_id );

				if ( ! in_array( 'checkout', $upload_locations ) ) {
					return;
				}
			} elseif ( ! in_array( 'checkout', $this->get_woocommerce_upload_locations() ) ) {
				return;
			}

			$this->render_uploader( $product );
		}
	}

	public function render_order_received_uploader( $item_id, $item, $order ) {
		$product = $item->get_product();

		//check if dokan
		if ( $this->is_dokan_active() ) {
			$product_id       = $product->get_id();
			$upload_locations = $this->get_dokan_upload_locations( $product_id );

			if ( is_wc_endpoint_url( 'order-received' ) && ! in_array( 'order-received', $upload_locations ) ) {
				return;
			} elseif ( is_wc_endpoint_url( 'view-order' ) && ! in_array( 'my-account', $upload_locations ) ) {
				return;
			}

		} elseif ( is_wc_endpoint_url( 'order-received' ) && ! in_array( 'order-received', $this->get_woocommerce_upload_locations() ) ) {
			return;
		} elseif ( is_wc_endpoint_url( 'view-order' ) && ! in_array( 'my-account', $this->get_woocommerce_upload_locations() ) ) {
			return;
		}

		if ( $this->requires_product_uploads( $product, $order ) ) {
			// Add upload button in the email
			$is_sending_mail = doing_action( 'woocommerce_email_order_details' );
			if ( $is_sending_mail || ! ( is_wc_endpoint_url() || is_admin() ) ) {
				$order_url = $order->get_view_order_url() . "#igd-uploads-{$item_id}";

				echo '<br/><small  class="igd-upload-text">' . sprintf( esc_html__( 'You can start uploading your documents on the %s order page%s', 'integrate-google-drive' ), '<a href="' . $order_url . '">', '</a>' ) . '.</small>';

				return;
			}
		}

		$this->render_uploader( $product, $order );

	}

	public function render_uploader( $product, $order = null ) {

		if ( ! $this->requires_product_uploads( $product ) ) {
			return;
		}

		$product_id = $product->get_id();

		$igd_upload_box_button_text = get_post_meta( $product_id, '_igd_upload_button_text', true );
		$igd_upload_box_button_text = ! empty( $igd_upload_box_button_text ) ? $igd_upload_box_button_text : __( 'Upload Documents', 'integrate-google-drive' );

		?>

        <div class="igd-wc-upload-wrap">

			<?php
			if ( is_checkout() ) {
				echo '<h3>' . __( 'Upload files for ', 'integrate-google-drive' ) . $product->get_title() . '</h3>';
			}
			?>

            <button type="button" class="button upload-button">
                <i class="dashicons dashicons-upload"></i>
                <span><?php echo $igd_upload_box_button_text; ?></span>
            </button>

			<?php

			// Render Upload Box
			$this->render_upload_box( $product, $order );

			// Render Description
			$description = get_post_meta( $product_id, '_igd_upload_description', true );

			if ( ! empty( $description ) ) {
				echo '<p class="igd-wc-upload-description">' . $description . '</p>';
			}

			// Render File List
			$files = WC()->session->get( 'igd_product_files_' . $product_id, [] );

			$this->render_file_list( $files );

			?>
        </div>

		<?php
	}

	public function save_checkout_uploads( $item_id, $values, $order_id ) {
		$product_id = $values['product_id'];

		if ( ! $product_id ) {
			return;
		}

		$product = wc_get_product( $product_id );

		if ( ! $this->requires_product_uploads( $product ) ) {
			return;
		}

		// Save files to order
		if ( WC()->session->__isset( 'igd_product_files_' . $product_id ) ) {
			$files = WC()->session->get( 'igd_product_files_' . $product_id, [] );

			foreach ( $files as $file ) {
				wc_add_order_item_meta( $item_id, '_igd_files', $file );
			}

			WC()->session->__unset( 'igd_product_files_' . $product_id );

		}

		//Rename uploaded folder once order is placed
		if ( WC()->session->__isset( 'igd_upload_folder_' . $product_id ) ) {
			$folder = WC()->session->get( 'igd_upload_folder_' . $product_id, [] );

			if ( $this->is_dokan_active() ) {
				$upload_folder_name = get_user_meta( get_post_field( 'post_author', $product_id ), '_igd_dokan_upload_folder_name', true );
				$upload_folder_name = ! empty( $upload_folder_name ) ? $upload_folder_name : 'Order - %wc_order_id% - %wc_product_name% (%user_email%)';
			} else {
				$upload_folder_name = igd_get_settings( 'wooCommerceUploadFolderNameTemplate', 'Order - %wc_order_id% - %wc_product_name% (%user_email%)' );
			}

			$args = [
				'name'       => $upload_folder_name,
				'wc_product' => $product,
			];

			$order = wc_get_order( $order_id );

			if ( ! empty( $order ) ) {
				$user = $order->get_user();

				// Guest User
				if ( ! $user ) {
					$user_id = $order->get_order_key();

					$user                 = new \stdClass();
					$user->user_login     = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
					$user->display_name   = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
					$user->user_firstname = $order->get_billing_first_name();
					$user->user_lastname  = $order->get_billing_last_name();
					$user->user_email     = $order->get_billing_email();
					$user->ID             = $user_id;
					$user->user_role      = esc_html__( 'Anonymous user', 'integrate-google-drive' );
				}

				$args['user']     = $user;
				$args['wc_order'] = $order;
			}

			$name = Private_Folders::instance()->get_folder_name( $args );

			App::instance( $folder['accountId'] )->rename( $name, $folder['id'] );

			// Save folder to order
			$folder['name'] = $name;
			wc_update_order_item_meta( $item_id, '_igd_upload_folder', $folder );

			WC()->session->__unset( 'igd_upload_folder_' . $product_id );

		}

	}

	public function render_file_list( $files ) { ?>
        <div class="wc-file-list-wrap <?php echo esc_attr( empty( $files ) ? 'hidden' : '' ); ?>">
            <h4><?php esc_html_e( 'Uploaded Files', 'integrate-google-drive' ); ?></h4>

            <ul class="wc-file-list">
				<?php
				if ( ! empty( $files ) ) {
					foreach ( $files as $file ) {
						?>
                        <li>
                            <img src="<?php echo esc_url( $file['iconLink'] ); ?>"/>
                            <span><?php echo esc_html( $file['name'] ); ?></span>
                        </li>
						<?php
					}
				}
				?>
            </ul>
        </div>
	<?php }

	public function render_upload_box( $product, $order = null ) {
		$product_id = $product->get_id();

		$max_file_size   = get_post_meta( $product_id, '_igd_upload_max_file_size', true );
		$min_file_size   = get_post_meta( $product_id, '_igd_upload_min_file_size', true );
		$file_extensions = get_post_meta( $product_id, '_igd_upload_file_types', true );

		$wc_page = false;

		if ( is_account_page() ) {
			$wc_page = 'my-account';
		} elseif ( is_wc_endpoint_url( 'order-received' ) ) {
			$wc_page = 'order-received';
		} elseif ( is_product() ) {
			$wc_page = 'product';
		} elseif ( is_checkout() ) {
			$wc_page = 'checkout';
		} elseif ( is_cart() ) {
			$wc_page = 'cart';
		}

		$data = [
			'type'        => 'uploader',
			'maxFileSize' => $max_file_size,
			'minFileSize' => $min_file_size,

			'isWooCommerceUploader' => $wc_page,
			'wcOrderId'             => $order ? $order->get_id() : null,
			'wcProductId'           => $product_id,
		];

		if ( ! empty( $file_extensions ) ) {
			$data['excludeAllExtensions']    = true;
			$data['excludeExceptExtensions'] = trim( $file_extensions, ',' );
		}

		echo Shortcode::instance()->render_shortcode( [], $data );

	}

	// Used in Uploader get_resume_url
	public function get_upload_folder( $product, $order = null ) {
		$product_id = $product->get_id();

		if ( $order ) {
			$order_item_id = $this->get_order_item_id_by_product_id( $order, $product_id );

			if ( ! $order_item_id ) {
				return;
			}

			$folder = wc_get_order_item_meta( $order_item_id, '_igd_upload_folder', true );
		} else {
			$folder = WC()->session->get( 'igd_upload_folder_' . $product_id, [] );
		}

		if ( ! empty( $folder ) ) {
			//check if folder is exists in Google Drive
			try {
				$folder = App::instance( $folder['accountId'] )->get_file_by_id( $folder['id'], true );
			} catch ( \Exception $e ) {
				$folder = $this->create_upload_folder( $product, $order );
			}

		}

		if ( empty( $folder ) ) {
			$folder = $this->create_upload_folder( $product, $order );
		}

		return $folder;
	}

	/**
	 * Check if product requires uploads
	 *
	 * @param \WC_Product $product
	 * @param \WC_Order $order
	 *
	 * @return bool
	 */
	public function requires_product_uploads( $product = null, $order = null ) {

		if ( empty( $product ) || ! ( $product instanceof \WC_Product ) ) {
			return false;
		}

		if ( 'variation' === $product->get_type() ) {
			$product = wc_get_product( $product->get_parent_id() );
		}

		$product_id = $product->get_id();

		$uploadable = get_post_meta( $product_id, '_uploadable', true ) == 'yes';
		$igd_upload = get_post_meta( $product_id, '_igd_upload', true ) == 'yes';

		//Check if checkout page
		if ( ! $order ) {
			return $uploadable && $igd_upload;
		}

		//Order Status

		$order_status = igd_get_settings( 'wooCommerceUploadOrderStatuses', array(
			'wc-pending',
			'wc-processing'
		) );

		if ( $this->is_dokan_active() ) {
			$order_status = get_user_meta( get_post_field( 'post_author', $product_id ), '_igd_dokan_upload_order_statuses', true );
		}

		$upload_active = in_array( 'wc-' . $order->get_status(), $order_status );

		if ( is_admin() ) {
			$current_screen = get_current_screen();
			if ( ! empty( $current_screen ) && in_array( $current_screen->post_type, [ 'shop_order' ] ) ) {
				$upload_active = true;
			} elseif ( isset( $_REQUEST['type'] ) || 'wc-item-details' !== $_REQUEST['type'] ) {
				$upload_active = true;
			}
		}

		$show_upload_box = apply_filters( 'igd_wc_show_upload_field', $upload_active, $order, $product, $this );

		if ( $uploadable && $igd_upload && $show_upload_box ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if order requires uploads
	 *
	 * @param $order
	 *
	 * @return bool
	 */
	public function requires_order_uploads( $order ) {
		if ( ! ( $order instanceof \WC_Order ) ) {
			return false;
		}

		foreach ( $order->get_items() as $order_item ) {
			$product         = $this->get_product( $order_item );
			$requires_upload = $this->requires_product_uploads( $product, $order );

			if ( $requires_upload ) {
				return true;
			}
		}

		return false;
	}

	public function create_upload_folder( $product, $order = null ) {
		$product_id = $product->get_id();

		$upload_folder_name = igd_get_settings( 'wooCommerceUploadFolderNameTemplate', 'Order - %wc_order_id% - %wc_product_name% (%user_email%)' );
		$parent_folder      = igd_get_settings( 'wooCommerceUploadParentFolder', [] );

		if ( $this->is_dokan_active() ) {
			$author_id = get_post_field( 'post_author', $product_id );

			$upload_folder_name = get_user_meta( $author_id, '_igd_dokan_upload_folder_name', true );
			$upload_folder_name = ! empty( $upload_folder_name ) ? $upload_folder_name : 'Order - %wc_order_id% - %wc_product_name% (%user_email%)';

			//Parent Folder
			$parent_folder = get_user_meta( $author_id, '_igd_dokan_upload_parent_folder', true );

		}

		$args = [
			'parent'     => $parent_folder,
			'name'       => $upload_folder_name,
			'wc_product' => $product,
		];

		if ( ! empty( $order ) ) {
			$user = $order->get_user();

			// Guest User
			if ( ! $user ) {
				$user_id = $order->get_order_key();

				$user                 = new \stdClass();
				$user->user_login     = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
				$user->display_name   = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
				$user->user_firstname = $order->get_billing_first_name();
				$user->user_lastname  = $order->get_billing_last_name();
				$user->user_email     = $order->get_billing_email();
				$user->ID             = $user_id;
				$user->user_role      = esc_html__( 'Anonymous user', 'integrate-google-drive' );
			}

			$args['user']     = $user;
			$args['wc_order'] = $order;
		}

		$folder = Private_Folders::instance()->create_folder( $args );

		if ( ! empty( $order ) ) {
			//get order item id by product id
			$order_item_id = $this->get_order_item_id_by_product_id( $order, $product_id );

			if ( $order_item_id ) {
				wc_update_order_item_meta( $order_item_id, '_igd_upload_folder', $folder );
			}

		} else {
			WC()->session->set( 'igd_upload_folder_' . $product_id, $folder );
		}

		return $folder;
	}

	/**
	 * Get Product from Order Item
	 *
	 * @param $order_item
	 *
	 * @return false|\WC_Product
	 */
	public function get_product( $order_item ) {
		$product = $order_item->get_product();

		if ( empty( $product ) || ! ( $product instanceof \WC_Product ) ) {
			return false;
		}

		return $product;
	}

	public function get_order_item_id_by_product_id( $order, $product_id ) {
		foreach ( $order->get_items() as $order_item_id => $order_item ) {
			$product = $order_item->get_product();
			if ( $product && $product->get_id() == $product_id ) {
				return $order_item_id;
			}
		}

		return 0;
	}

	/**
	 * Add Uploadable Product Option to Product Data Tab
	 *
	 * @param $options
	 *
	 * @return mixed
	 */
	public function add_uploadable_product_option( $options ) {
		$options['uploadable'] = [
			'id'            => '_uploadable',
			'wrapper_class' => 'show_if_simple show_if_variable',
			'label'         => __( 'Uploadable', 'integrate-google-drive' ),
			'description'   => __( 'Allow customers to upload files to this product.', 'integrate-google-drive' ),
			'default'       => 'no',
		];

		return $options;
	}

	public function add_product_data_tab_content() {
		global $post;

		$igd_upload = get_post_meta( $post->ID, '_igd_upload', true );

		$description = get_post_meta( $post->ID, '_igd_upload_description', true );

		$upload_btn_text = get_post_meta( $post->ID, '_igd_upload_button_text', true );
		$upload_btn_text = ! empty( $upload_btn_text ) ? $upload_btn_text : __( 'Upload Documents', 'integrate-google-drive' );

		$max_file_size   = get_post_meta( $post->ID, '_igd_upload_max_file_size', true );
		$min_file_size   = get_post_meta( $post->ID, '_igd_upload_min_file_size', true );
		$file_extensions = get_post_meta( $post->ID, '_igd_upload_file_types', true );

		?>

        <div id="upload_options" class="panel woocommerce_options_panel hidden" style="display:none">

        <div class="options_group">
            <p class="form-field">
                <label for="_igd_upload"><?php _e( 'Upload to Google Drive', 'integrate-google-drive' ); ?></label>
                <input type="checkbox" class="checkbox" name="_igd_upload"
                       id="_igd_upload" <?php checked( $igd_upload, 'yes' ); ?> />
            </p>

            <div class="show_if_igd_upload upload-box-settings">
                <h4><?php _e( 'Google Drive Upload Settings', 'integrate-google-drive' ); ?></h4>

                <!-- Upload Button Text -->
                <p class="form-field upload-box-button-text-field">
                    <label for="upload_box_button_text"><?php _e( 'Upload Button Text', 'integrate-google-drive' ); ?></label>

					<?php echo wc_help_tip( __( 'Enter the upload button text.', 'integrate-google-drive' ) ); ?>

                    <input type="text" class="short" name="_igd_upload_button_text" id="igd_upload_box_button_text"
                           value="<?php echo esc_attr( $upload_btn_text ); ?>"
                           placeholder="<?php _e( 'Upload Documents', 'integrate-google-drive' ); ?>"/>
                </p>

                <!-- Description -->
                <p class="form-field upload-box-description-field">
                    <label for="upload_description"><?php _e( 'Upload Description', 'integrate-google-drive' ); ?></label>

					<?php echo wc_help_tip( __( 'Enter the description for the upload box.', 'integrate-google-drive' ) ); ?>

                    <input name="_igd_upload_description" id="upload_description" class="short" type="text"
                           value="<?php echo esc_attr( $description ); ?>"
                           placeholder="<?php _e( 'Upload Description', 'integrate-google-drive' ); ?>"
                    />
                </p>


                <!-- Max File Size -->
                <p class="form-field upload-max-file-size-field">
                    <label for="upload_max_file_size"><?php _e( 'Max File Size', 'integrate-google-drive' ); ?></label>

                    <input type="number" class="short" name="_igd_upload_max_file_size" id="upload_max_file_size"
                           min="0"
                           value="<?php echo esc_attr( $max_file_size ); ?>"
                           placeholder="<?php _e( 'Max File Size', 'integrate-google-drive' ); ?>"/>

                    <span class="description">
                        <?php esc_html_e( 'Maximum file size in MB. Leave blank for no limit.', 'integrate-google-drive' ); ?>
                    </span>
                </p>

                <!-- Min File Size -->
                <p class="form-field upload-min-file-size-field">
                    <label for="upload_min_file_size"><?php _e( 'Min File Size', 'integrate-google-drive' ); ?></label>

                    <input type="number" class="short" name="_igd_upload_min_file_size" id="upload_min_file_size"
                           min="0"
                           value="<?php echo esc_attr( $min_file_size ); ?>"
                           placeholder="<?php _e( 'Min File Size', 'integrate-google-drive' ); ?>"/>

                    <span class="description">
                        <?php esc_html_e( 'Minimum file size in MB. Leave blank for no limit.', 'integrate-google-drive' ); ?>
                    </span>
                </p>

                <!-- File Extensions -->
                <p class="form-field upload-file-extensions-field">
                    <label for="upload_file_extensions"><?php _e( 'Allowed File Types', 'integrate-google-drive' ); ?></label>

                    <input type="text" class="short" name="_igd_upload_file_types" id="upload_file_extensions"
                           value="<?php echo esc_attr( $file_extensions ); ?>"
                           placeholder="<?php esc_attr_e( 'jpg, png, gif, zip', 'integrate-google-drive' ); ?>"/>

                    <span class="description">
                        <?php esc_html_e( 'Comma separated list of allowed file extensions e.g (jpg, png, gif). Leave blank for no limit.', 'integrate-google-drive' ); ?>
                    </span>
                </p>

            </div>
        </div>
		<?php
	}

	/**
	 * Save uploadable product meta
	 *
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_product_meta( $post_id ) {

		$uploadable         = ! empty( $_POST['_uploadable'] ) ? 'yes' : 'no';
		$upload_button_text = ! empty( $_POST['_igd_upload_button_text'] ) ? sanitize_text_field( $_POST['_igd_upload_button_text'] ) : 'Upload Documents';

		$description = ! empty( $_POST['_igd_upload_description'] ) ? sanitize_text_field( $_POST['_igd_upload_description'] ) : '';

		$igd_upload = ! empty( $_POST['_igd_upload'] ) ? 'yes' : 'no';

		$max_file_size   = ! empty( $_POST['_igd_upload_max_file_size'] ) ? sanitize_text_field( $_POST['_igd_upload_max_file_size'] ) : '';
		$min_file_size   = ! empty( $_POST['_igd_upload_min_file_size'] ) ? sanitize_text_field( $_POST['_igd_upload_min_file_size'] ) : '';
		$file_extensions = ! empty( $_POST['_igd_upload_file_types'] ) ? sanitize_text_field( $_POST['_igd_upload_file_types'] ) : '';

		update_post_meta( $post_id, '_igd_upload_button_text', $upload_button_text );
		update_post_meta( $post_id, '_igd_upload_description', $description );
		update_post_meta( $post_id, '_igd_upload_max_file_size', $max_file_size );
		update_post_meta( $post_id, '_igd_upload_min_file_size', $min_file_size );
		update_post_meta( $post_id, '_igd_upload_file_types', $file_extensions );
		update_post_meta( $post_id, '_igd_upload', $igd_upload );
		update_post_meta( $post_id, '_uploadable', $uploadable );
	}

	public function get_woocommerce_upload_locations() {
		if ( ! igd_get_settings( 'wooCommerceUpload' ) ) {
			return [];
		}

		return igd_get_settings( 'wooCommerceUploadLocations', [
			'checkout',
			'order-received',
			'my-account',
		] );
	}

	/**
	 * @return WooCommerce_Uploads|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

WooCommerce_Uploads::instance();