<!-- wp:cover {"minHeight":400,"minHeightUnit":"px","customGradient":"linear-gradient(180deg,#d3f0ff 0%,#f2f2fc 100%)","isDark":false,"align":"full","className":"kenta-business-hero"} -->
<div class="wp-block-cover alignfull is-light kenta-business-hero" style="min-height:400px">
    <span aria-hidden="true"
          class="wp-block-cover__background has-background-dim-100 has-background-dim has-background-gradient"
          style="background:linear-gradient(180deg,#d3f0ff 0%,#f2f2fc 100%)">
    </span>
    <div class="wp-block-cover__inner-container">
        <!-- wp:spacer {"height":"80px"} -->
        <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:columns {"className":"align-items-center"} -->
        <div class="wp-block-columns align-items-center">
            <!-- wp:column {"width":"60%"} -->
            <div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading {"level":1} -->
                <h1><?php esc_html_e( 'Brand, Design & Development Agency', 'kenta-business' ); ?></h1>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <!-- /wp:paragraph -->

                <!-- wp:spacer {"height":"12px"} -->
                <div style="height:12px" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:buttons -->
                <div class="wp-block-buttons"><!-- wp:button {"className":"uppercase"} -->
                <div class="wp-block-button uppercase">
                <a class="wp-block-button__link"><?php esc_html_e( 'get in touch', 'kenta-business' ); ?></a></div>
                <!-- /wp:button -->

                <!-- wp:button {"className":"uppercase is-style-outline"} -->
                <div class="wp-block-button uppercase is-style-outline">
                <a class="wp-block-button__link"><?php esc_html_e( 'learn more', 'kenta-business' ); ?></a>
                </div>
                <!-- /wp:button --></div>
                <!-- /wp:buttons -->
            </div>
            <!-- /wp:column -->

            <!-- wp:column {"width":"40%"} -->
            <div class="wp-block-column" style="flex-basis:40%">
                <!-- wp:image {"id":84,"sizeSlug":"full","linkDestination":"none"} -->
                <figure class="wp-block-image size-full">
                    <img src="<?php echo esc_url( kenta_business_asset_url( 'images/hero-image.png' ) ) ?>" alt="" class="wp-image-84" />
                </figure>
                <!-- /wp:image --></div>
            <!-- /wp:column --></div>
        <!-- /wp:columns --></div>

        <!-- wp:spacer {"height":"68px"} -->
        <div style="height:68px" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
</div>
<!-- /wp:cover -->