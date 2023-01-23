<?php

$attributes = array_merge( array(
    'blockID'          => array(
    'type' => 'string',
),
    'slidesToShow'     => array(
    'type'    => 'object',
    'default' => 1,
),
    'slidesToScroll'   => array(
    'type'    => 'number',
    'default' => 1,
),
    'slidesGap'        => array(
    'type'    => 'object',
    'default' => '0px',
),
    'effect'           => array(
    'type'    => 'string',
    'default' => 'slide',
),
    'cssEase'          => array(
    'type'    => 'string',
    'default' => 'ease',
),
    'duration'         => array(
    'type'    => 'number',
    'default' => 700,
),
    'infinite'         => array(
    'type'    => 'string',
    'default' => 'yes',
),
    'autoplay'         => array(
    'type'    => 'string',
    'default' => 'no',
),
    'pauseOnHover'     => array(
    'type'    => 'string',
    'default' => 'yes',
),
    'autoplaySpeed'    => array(
    'type'    => 'number',
    'default' => 5000,
),
    'prevArrow'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => '.yuki-slides-prev-arrow i',
    'attribute' => 'class',
    'default'   => 'fas fa-chevron-left',
),
    'nextArrow'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => '.yuki-slides-next-arrow i',
    'attribute' => 'class',
    'default'   => 'fas fa-chevron-right',
),
    'navigation'       => array(
    'type'    => 'string',
    'default' => 'yes',
),
    'navigationMotion' => array(
    'type'    => 'string',
    'default' => 'no',
),
    'pagination'       => array(
    'type'    => 'string',
    'default' => 'yes',
),
    'paginationMotion' => array(
    'type'    => 'string',
    'default' => 'no',
),
), kenta_blocks_advanced_attrs() );
$metadata = array(
    'title'       => __( 'Slides (KB)', 'kenta-blocks' ),
    'description' => __( 'Display a carousel with any blocks in the slides.', 'kenta-blocks' ),
    'keywords'    => array(
    'slider',
    'slick',
    'carousel',
    'slides',
    'side'
),
    'supports'    => array(
    'anchor' => true,
    'align'  => array( 'wide', 'full' ),
    'html'   => false,
),
    'attributes'  => $attributes,
);
if ( !function_exists( 'kenta_blocks_slides_block_add_frontend_assets' ) ) {
    /**
     * Slides frontend assets function.
     *
     * @return void
     */
    function kenta_blocks_slides_block_add_frontend_assets()
    {
        
        if ( has_block( 'kenta-blocks/slides' ) ) {
            wp_enqueue_style( 'slick' );
            wp_enqueue_script( 'slick' );
            wp_enqueue_script( 'kenta-blocks-frontend-script' );
        }
    
    }

}
add_action( 'wp_enqueue_scripts', 'kenta_blocks_slides_block_add_frontend_assets' );
add_action( 'the_post', 'kenta_blocks_slides_block_add_frontend_assets' );
add_action( 'enqueue_block_editor_assets', 'kenta_blocks_slides_block_add_frontend_assets' );
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $css[".kb-slides.kb-slides-{$id}"] = array_merge( array(
        '--kb-slides-items-gutter' => kenta_blocks_block_attr( 'slidesGap', $attrs, $metadata ),
    ), kenta_blocks_advanced_css( $attrs, $metadata ) );
    return $css;
},
    'script'   => function ( $id, $attrs ) use( $metadata ) {
    $slidesShow = kenta_blocks_script()->sanitizeResponsiveValue( kenta_blocks_block_attr( 'slidesToShow', $attrs, $metadata ), 1 );
    $slidesScroll = absint( kenta_blocks_block_attr( 'slidesToScroll', $attrs, $metadata ) );
    $isFade = kenta_blocks_block_attr( 'effect', $attrs, $metadata ) === 'fade';
    $options = wp_json_encode( array(
        'rtl'            => is_rtl(),
        'infinite'       => kenta_blocks_block_attr( 'infinite', $attrs, $metadata ) === 'yes',
        'fade'           => 1 == absint( $slidesShow['desktop'] ) && $isFade,
        'speed'          => absint( kenta_blocks_block_attr( 'duration', $attrs, $metadata ) ),
        'arrows'         => kenta_blocks_block_attr( 'navigation', $attrs, $metadata ) === 'yes',
        'dots'           => kenta_blocks_block_attr( 'pagination', $attrs, $metadata ) === 'yes',
        'cssEase'        => kenta_blocks_block_attr( 'cssEase', $attrs, $metadata ),
        'autoplay'       => kenta_blocks_block_attr( 'autoplay', $attrs, $metadata ) === 'yes',
        'autoplaySpeed'  => absint( kenta_blocks_block_attr( 'autoplaySpeed', $attrs, $metadata ) ),
        'pauseOnHover'   => kenta_blocks_block_attr( 'pauseOnHover', $attrs, $metadata ) === 'yes',
        'prevArrow'      => '#kb-slides-prev-' . $id,
        'nextArrow'      => '#kb-slides-next-' . $id,
        'slidesToShow'   => max( absint( $slidesShow['desktop'] ), 1 ),
        'slidesToScroll' => $slidesScroll,
        'responsive'     => [ [
        'breakpoint' => absint( kenta_blocks_css()->desktop() ),
        'settings'   => [
        'slidesToShow'   => max( absint( $slidesShow['tablet'] ), 1 ),
        'slidesToScroll' => ( $slidesScroll > absint( $slidesShow['tablet'] ) ? 1 : $slidesScroll ),
        'fade'           => 1 == absint( $slidesShow['tablet'] ) && $isFade,
    ],
    ], [
        'breakpoint' => absint( kenta_blocks_css()->tablet() ),
        'settings'   => [
        'slidesToShow'   => max( absint( $slidesShow['mobile'] ), 1 ),
        'slidesToScroll' => ( $slidesScroll > absint( $slidesShow['mobile'] ) ? 1 : $slidesScroll ),
        'fade'           => 1 == absint( $slidesShow['mobile'] ) && $isFade,
    ],
    ] ],
    ) );
    echo  "createKBSlides('{$id}', {$options});" ;
},
);