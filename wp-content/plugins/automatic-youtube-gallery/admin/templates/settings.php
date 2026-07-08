<?php

/**
 * Settings Form.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package Automatic_YouTube_Gallery
 */

$gallery_settings = ayg_get_option( 'ayg_gallery_settings' );
$player_settings  = ayg_get_option( 'ayg_player_settings' );

$active_tab     = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->tabs ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
$active_section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';
$active_theme   = $gallery_settings['theme'];
$player_type    = isset( $player_settings['player_type'] ) ? $player_settings['player_type'] : 'youtube';

$sections = array();
foreach ( $this->sections as $section ) {
	$tab = $section['tab'];
	
	if ( ! isset( $sections[ $tab ] ) ) {
		$sections[ $tab ] = array();
    }
    
    $sections[ $tab ][] = $section;
}
?>

<div id="ayg-settings" class="ayg ayg-settings theme-<?php echo esc_attr( $active_theme ); ?> player_type-<?php echo esc_attr( $player_type ); ?> wrap">
    <?php settings_errors(); ?>

    <h2 class="nav-tab-wrapper wp-clearfix">
		<?php
        foreach ( $this->tabs as $tab => $title ) {
            $url = add_query_arg( 'tab', $tab, admin_url( 'admin.php?page=automatic-youtube-gallery-settings' ) );  

            foreach ( $sections[ $tab ] as $section ) {
                $url = add_query_arg( 'section', $section['id'], $url );

				if ( $tab == $active_tab && empty( $active_section ) ) {
					$active_section = $section['id'];
                }
                
				break;
            }

            $classes = array( 'nav-tab' );
            if ( $tab == $active_tab ) $classes[] = 'nav-tab-active';

            printf( 
                '<a href="%s" class="%s">%s</a>', 
                esc_url( $url ), 
                implode( ' ', $classes ), 
                esc_html( $title )
            );
        }
        ?>
    </h2>
    
	<?php	
	$section_links = array();

	foreach ( $sections[ $active_tab ] as $section ) {
        $page = $section['page'];

        $url = add_query_arg( 
            array(
                'tab'     => $active_tab,
                'section' => $page
            ), 
            admin_url( 'admin.php?page=automatic-youtube-gallery-settings' ) 
        );

        if ( ! isset( $section_links[ $page ] ) ) {
            $section_links[ $page ] = sprintf( 
                '<a href="%s" class="%s">%s</a>',			
                esc_url( $url ),
                ( $section['id'] == $active_section ? 'current' : '' ),
                ( isset( $section['menu_title'] ) ? esc_html( $section['menu_title'] ) : esc_html( $section['title'] ) )
            );
        }
	}

	if ( count( $section_links ) > 1 ) : ?>
		<ul class="ayg-margin-bottom subsubsub"><li><?php echo implode( ' | </li><li>', $section_links ); ?></li></ul>
		<div class="clear"></div>
	<?php endif; ?>
    
	<form method="post" action="options.php"> 
		<?php
        $page_hook = $active_section;

        settings_fields( $page_hook );
        do_settings_sections( $page_hook );
        ?>

        <?php if ( 'general' == $active_tab && 'ayg_general_settings' == $active_section ) : ?>
            <table id="ayg-table-delete-cache" class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Delete Cache', 'automatic-youtube-gallery' ); ?></label>
                        </th>
                        <td>
                            <input type="submit" id="ayg-button-delete-cache" class="button-secondary" value="<?php esc_attr_e( 'Delete Cache', 'automatic-youtube-gallery' ); ?>" />
                            <span class="ayg-ajax-status"></span>
                            <p class="description"><?php esc_html_e( 'Delete all of the YouTube API data cached by the plugin.', 'automatic-youtube-gallery' ); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

        <?php submit_button(); ?>
    </form>
</div>
