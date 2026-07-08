<?php
/*
Plugin Name: WP Post Page Clone
Plugin URI: https://wordpress.org/plugins/wp-post-page-clone
Description: A plugin to generate duplicate post or page with contents and it's meta fields and other required settings.
Version: 1.3
Author: Gaurang Sondagar
Author URI: http://gaurangsondagar99.wordpress.com/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-post-page-clone
/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define Constant variables
 */
if (!defined('WP_POST_PAGE_CLONE_URL')) {
    define('WP_POST_PAGE_CLONE_URL', plugins_url() . '/wp-post-page-clone');
}

if (!defined('WP_POST_PAGE_CLONE_PLUGIN_DIRNAME')) {
    define('WP_POST_PAGE_CLONE_PLUGIN_DIRNAME', plugin_basename(dirname(__FILE__)));
}

if(!function_exists('wp_post_page_clone_translate')) {
    /**
     * Function for language translations
     */
    function wp_post_page_clone_translate() {

        load_plugin_textdomain('wp-post-page-clone', false, WP_POST_PAGE_CLONE_PLUGIN_DIRNAME . '/languages' );

    }

}

add_action( 'plugins_loaded', 'wp_post_page_clone_translate' );


if(!function_exists('wp_post_page_clone')) {
    /**
     * Function for post / page clone and redirect that post
     * @global type $wpdb
     */
    function wp_post_page_clone(){

            global $wpdb;

            /*
            * get Nonce value
            */
            $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';

            // Safely retrieve post ID
            if ( isset( $_GET['post'] ) ) {
                $post_id = intval( $_GET['post'] );
            } elseif ( isset( $_POST['post'] ) ) {
                $post_id = intval( $_POST['post'] );
            } else {
                $post_id = 0; // Or handle as invalid
            }

            // check access permissions to even consider the cloning....
            if( ! wp_verify_nonce( $nonce, 'wp-post-page-clone-'.$post_id) || ! current_user_can( 'edit_posts' )) {
                wp_die( esc_html__( 'You do not have permission to be here', 'wp-post-page-clone' ) );
            }

            if ( !isset( $_GET['post']) || (!isset($_REQUEST['action']) && 'wp_post_page_clone' != $_REQUEST['action'] ) ) {
                wp_die( esc_html__( 'No post or page to clone has been supplied!, Please try again!', 'wp-post-page-clone' ) );
            }
            
            $post = get_post( $post_id );
            $current_user = wp_get_current_user();
            $post_author = $current_user->ID;

            $allowed_roles = array( 'editor', 'administrator' );
            if ($post->post_author == $current_user->ID || array_intersect( $allowed_roles, $current_user->roles ) || (current_user_can( 'edit_post', $post->ID ))) {

                if (isset( $post ) && $post != null) {

                        $args = array(
                                'comment_status' => $post->comment_status,
                                'ping_status'    => $post->ping_status,
                                'post_author'    => $post_author,
                                'post_content'   => $post->post_content,
                                'post_excerpt'   => $post->post_excerpt,
                                'post_name'      => $post->post_name,
                                'post_parent'    => $post->post_parent,
                                'post_password'  => $post->post_password,
                                'post_status'    => 'draft',
                                'post_title'     => $post->post_title,
                                'post_type'      => $post->post_type,
                                'to_ping'        => $post->to_ping,
                                'menu_order'     => $post->menu_order
                        );

                        $clone_post_id = wp_insert_post( $args );
                        if ( is_wp_error( $clone_post_id ) ) {
                            wp_die( esc_html( $clone_post_id->get_error_message() ) );
                        }
                        

                        /*
                         * get and set terms to the new post draft
                         */
                        $taxonomies = array_map('sanitize_text_field',get_object_taxonomies($post->post_type));
                        if (!empty($taxonomies) && is_array($taxonomies)){
                            foreach ($taxonomies as $taxonomy) {
                                    $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                                    wp_set_object_terms($clone_post_id, $post_terms, $taxonomy, false);
                            }
                        }

                        /*
                        * clone all post meta
                        */
                        $post_meta_keys = get_post_custom_keys( $post_id );
                        if(!empty($post_meta_keys)){
                            foreach ( $post_meta_keys as $meta_key ) {
                                $meta_values = get_post_custom_values( $meta_key, $post_id );
                                foreach ( $meta_values as $meta_value ) {
                                    $meta_value = maybe_unserialize( $meta_value );
                                    update_post_meta( $clone_post_id, $meta_key, wp_slash( $meta_value ) );
                                }
                            }
                        }

                        /**
                         * Added plugin's compatibility with Elementor plugin
                         */
                        if(is_plugin_active( 'elementor/elementor.php' )){
                            $elm = Elementor\Core\Files\CSS\Post::create( $clone_post_id );
                            $elm->update();
                        } 

                        wp_redirect(admin_url('edit.php?post_type='.$post->post_type));
                        exit;

                } else {

                    wp_die( esc_html__( 'Post or Page creation failed, could not find original post:', 'wp-post-page-clone' ) . ' ' . esc_html( $post_id ) );


                }

            } else {
                wp_die( esc_html__( 'Security issue occure, Please try again!.', 'wp-post-page-clone' ) );
                
            }

    }

}

add_action( 'admin_action_wp_post_page_clone', 'wp_post_page_clone' );


if(!function_exists('wp_post_page_link')) {

    /**
     * Add the duplicate link to action list for post_row_actions
     * @param string $actions
     * @param type $post
     * @return string
     */
    function wp_post_page_link( $actions, $post ) {

            // Remove support for acf-field-group post type
			if($post->post_type == 'acf-field-group'){
				return $actions;
			}

            $current_user = wp_get_current_user();
            $post_author = $current_user->ID;
            $allowed_roles = array( 'editor', 'administrator' );
            if ($post->post_author == $current_user->ID || array_intersect( $allowed_roles, $current_user->roles ) || (current_user_can( 'edit_post', $post->ID )) ) {
                    $actions['clone'] = '<a '.$post_author.'==='.$post->post_author.' href="admin.php?action=wp_post_page_clone&amp;post=' . $post->ID . '&amp;nonce='.wp_create_nonce( 'wp-post-page-clone-'.$post->ID ).'" title="'.__('Clone Post and Page', 'wp-post-page-clone').'" rel="permalink">'.__('Click To Clone', 'wp-post-page-clone').'</a>';
            }

            return $actions;
    }

}

/**
 * Filter for post / page row actions
 */
add_filter( 'post_row_actions', 'wp_post_page_link', 10, 2 );
add_filter('page_row_actions', 'wp_post_page_link', 10, 2);