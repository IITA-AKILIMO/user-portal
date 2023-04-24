<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
echo "<div class='caf-post-title'><h2><a href='" . get_the_permalink() . "'>" . esc_html($title) . "</a></h2></div>";