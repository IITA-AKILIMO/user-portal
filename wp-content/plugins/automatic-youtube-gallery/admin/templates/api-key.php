<?php

/**
 * Dashboard: Api Key.
 *
 * @link    https://plugins360.com
 * @since   1.3.0
 *
 * @package Automatic_YouTube_Gallery
 */
?>

<p class="about-description"><?php esc_html_e( 'You must create an API Key to build dynamic galleries from YouTube.', 'automatic-youtube-gallery' ); ?></p>

<table id="ayg-table-api-key" class="form-table">
  <tr>
    <th scope="row">
      <label for="ayg-api-key"><?php esc_html_e( 'Youtube API Key', 'automatic-youtube-gallery' ); ?></label>
    </th>
    <td>
      <input type="text" class="regular-text" id="ayg-api-key" value="" />
      <input type="button" id="ayg-button-save-api-key" class="button-primary" value="<?php esc_attr_e( 'Proceed', 'automatic-youtube-gallery' ); ?>" />  
      <span class="ayg-ajax-status"></span>      
      <p class="description">
        <?php
        printf( 
          __( 'Follow <a href="%s" target="_blank">this guide</a> to get your own API key.', 'automatic-youtube-gallery' ),  
          'https://plugins360.com/automatic-youtube-gallery/how-to-get-youtube-api-key/' 
        );
        ?>
      </p>
    </td>
  </tr>
</table>
