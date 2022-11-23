<?php
/**
 * About Kenta Theme
 *
 * @package Kenta Companion
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap kcmp-admin-page">
    <div class="kcmp-page-container">
        <img class="kenta-logo" src="<?php echo esc_url( KCMP_ASSETS_URL . 'images/kenta-logo-color.png' ) ?>" alt="Kenta Logo">
        <h1 class="kenta-name"><?php esc_html_e( 'Kenta Theme', 'kenta-companion' ) ?></h1>
        <p>
            <?php esc_html_e( 'Looking for a WordPress theme? Kenta Compantion is built for the Kenta theme. Try the Kenta theme for endless possibilities.', 'kenta-companion' ) ?>
        </p>
        
        <a class="kcmp-button kcmp-button-solid" href="https://kentatheme.com/?utm_source=kcmp-screen">
            <?php esc_html_e( 'Learn More', 'kenta' ) ?>
        </a>
    </div>
</div>
