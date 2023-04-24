<?php 
$buton_style 	= ' yotu-button-prs '.(isset($settings['styling']['button'])? 'yotu-button-prs-' . $settings['styling']['button'] : ' yotu-button-prs');
$buton_layout 	= isset($settings['styling']['button'])? ' yotu-pager_layout-' . $settings['styling']['pager_layout'] : '';
$prev_text 		= apply_filters( 'yotuwp_prev_text', __('Prev', 'yotuwp-easy-youtube-embed'));
$next_text 		= apply_filters( 'yotuwp_next_text', __('Next', 'yotuwp-easy-youtube-embed'));
$loadmore_text 	= apply_filters( 'yotuwp_loadmore_text', __('Load more', 'yotuwp-easy-youtube-embed'));

do_action('yotuwp_before_pagination', $settings);

$buton_layout .=' yotu-pagination-' . $pagination_pos;

if ($settings['pagitype'] == 'pager'):

$_classes_pagi = ($data->totalPage == 1)? ' yotu-hide' : '';

?>
<div class="yotu-pagination<?php esc_attr_e( $_classes_pagi ); esc_attr_e( $buton_layout ) ;?>">
<a href="#" class="yotu-pagination-prev<?php esc_attr_e( $buton_style );?>" data-page="prev"><?php echo wp_kses_post( $prev_text );?></a>
<span class="yotu-pagination-current">1</span> <span><?php _e('of', 'yotuwp-easy-youtube-embed');?></span> <span class="yotu-pagination-total"><?php esc_html_e( $data->totalPage );?></span>
<a href="#" class="yotu-pagination-next<?php esc_attr_e( $buton_style );?>" data-page="next"><?php echo wp_kses_post( $next_text );?></a>
</div>
<?php else:?>
<div class="yotu-pagination<?php echo ($data->totalPage == 1)? ' yotu-hide' : '';?>">
	<a href="#" class="yotu-pagination-more<?php esc_attr_e( $buton_style );?>" data-page="more"><?php echo wp_kses_post( $loadmore_text );?></a>
</div>
<?php endif;
do_action('yotuwp_after_pagination', $settings);?>