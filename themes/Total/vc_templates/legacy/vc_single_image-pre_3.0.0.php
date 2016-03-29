<?php
// Shortcode params
extract( shortcode_atts( array(
    'title'                     => '',
    'image'                     => '',
    'link'                      => '',
    'img_size'                  => 'full',
    'img_link_large'            => false,
    'img_link'                  => '',
    'img_link_target'           => '_self',
    'alignment'                 => '',
    'el_class'                  => '',
    'css_animation'             => '',
    'img_hover'                 => '',
    'img_caption'               => '',
    'rounded_image'             => '',
    'img_filter'                => '',
    'style'                     => '',
    'border_color'              => '',
    'css'                       => '',
    'lightbox_video'            => '',
    'lightbox_custom_img'       => '',
    'lightbox_gallery'          => '',
    'lightbox_iframe_type'      => '',
    'lightbox_video_html5_webm' => '',
    'lightbox_dimensions'       => '',
), $atts ) );

// Add lightbox script for front end
if ( function_exists( 'vcex_inline_js' ) ) {
    vcex_inline_js( array( 'ilightbox' ) );
}

// Output var
$output = '';

// Link
if ( $link ) {
    $img_link = esc_url( $link );
}

// Border color
if ( $border_color ) {
    $border_color = ' vc_box_border_' . $border_color;
}

// Data attributes
$data_attributes = '';

// Get the image ID
$img_id = preg_replace('/[^\d]/', '', $image);

// Get image alt
if ( $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) {
    $img_alt = 'alt="'. $img_alt .'"';
}

// The image string
$img = wpb_getImageBySize( array(
    'attach_id'     => $img_id,
    'thumb_size'    => $img_size,
    'class'         => $style . $border_color
) );

// No Image so bail.
if ( $img == NULL ) {
    $thumbnail  = '<img src="'. get_template_directory_uri() .'/images/dummy-image.jpg" />';
    $img        = array(
        'thumbnail' => $thumbnail
    );
}

$el_class = $this->getExtraClass( $el_class );

$link_to = '';
$a_class='';

// Wrapper Classes
$wrapper_classes = array( 'vc_single_image-wrapper' ); 
if ( $img_hover ) {
    $wrapper_classes[] = wpex_image_hover_classes( $img_hover );
}
if ( $style ) {
    $wrapper_classes[] = $style;
}
if ( $border_color ) {
    $wrapper_classes[] = $border_color;
}
$wrapper_classes = implode( ' ', $wrapper_classes );

// Gallery Lightbox
if ( $lightbox_gallery ) {
    vcex_enque_style( 'ilightbox' );
    $gallery_ids = explode( ",",$lightbox_gallery );
    if ( $gallery_ids && is_array( $gallery_ids ) ) {
        $gallery_images = '';
        $count=0;
        foreach ( $gallery_ids as $id ) {
            $count++;
            if ( $count != count( $gallery_ids ) ) {
                $gallery_images .= wp_get_attachment_url( $id ) . ',';
            } else {
                $gallery_images .= wp_get_attachment_url( $id );
            }
        }
        $data_attributes .= ' data-gallery="'. $gallery_images .'"';
    }
    $link_to = '#';
    $a_class .= ' wpex-lightbox-gallery';
}

// Link to custom Video
elseif ( $lightbox_video ) {
    vcex_enque_style( 'ilightbox' );
    $lightbox_video      = esc_url( $lightbox_video );
    $lightbox_dimensions = vcex_parse_lightbox_dims( $lightbox_dimensions );
    if ( $lightbox_iframe_type ) {
        if ( 'video_embed' == $lightbox_iframe_type ) {
            $video_embed_url    = wpex_sanitize_data( $lightbox_video, 'embed_url' );
            $lightbox_video     = $video_embed_url ? $video_embed_url : $lightbox_video;
            $a_class .= ' wpex-lightbox';
            $data_attributes .= ' data-type="iframe"';
            $data_attributes .= ' data-options="'. $lightbox_dimensions .'"';
        } elseif ( 'url' == $lightbox_iframe_type ) {
            $a_class .= ' wpex-lightbox';
            $data_attributes .= ' data-type="iframe"';
            $data_attributes .= ' data-options="'. $lightbox_dimensions .'"';
        } elseif ( 'html5' == $lightbox_iframe_type ) {
            $poster = wp_get_attachment_image_src( $img_id, 'full');
            $poster = $poster[0];
            $a_class .= ' wpex-lightbox';
            $data_attributes .= ' data-type="video"';
            $data_attributes .= ' data-options="'. $lightbox_dimensions .',html5video: { webm: \''. $lightbox_video_html5_webm .'\', poster: \''. $poster .'\' }"';
        } elseif ( 'quicktime' == $lightbox_iframe_type ) {
            $a_class .= ' wpex-lightbox';
            $data_attributes .= ' data-type="video"';
            $data_attributes .= ' data-options="'. $lightbox_dimensions .'"';
        }
    } else {
        $a_class .= ' wpex-lightbox-autodetect';
    }
    $link_to = $lightbox_video;
}

// Link to custom image
elseif ( '' != $lightbox_custom_img ) {
    vcex_enque_style( 'ilightbox' );
    $link_to = wp_get_attachment_image_src( $lightbox_custom_img, 'full');
    $link_to = $link_to[0];
    $data_attributes .= ' data-type="image"';
    $a_class .= ' wpex-lightbox';
}

// Link to large image lightbox
elseif ( $img_link_large == true ) {

    // Load ilightbox skin
    vcex_enque_style( 'ilightbox' );

    // Alter link to
    $link_to = wp_get_attachment_image_src( $img_id, 'full' );
    $link_to = $link_to[0];

    // Add data attributes
    $data_attributes .= ' data-type="image"';

    // Add link class
    $a_class .= ' wpex-lightbox';

}

// Link to external URL
elseif ( ! empty( $img_link ) ) {
    $link_to = $img_link;
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element clr' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
if ( $css_animation ) {
    $css_class .= $this->getCSSAnimation( $css_animation );
}

if ( 'yes' == $rounded_image ) {
    $css_class .= ' vcex-rounded-images';
}

if ( $img_filter ) {
    $css_class .= ' '. wpex_image_filter_class( $img_filter );
}

// Image output
$img_output = ( $style == 'vc_box_shadow_3d' ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];

// Caption
if ( $img_caption ) {
    $img_output .='<span class="wpb_single_image_caption">'. $img_caption .'</span>';
}

// Default image string
$image_string = ! empty( $link_to ) ? '<div class="'. $wrapper_classes .'"><a class="' . $a_class . '" href="' . $link_to . '"' . ' target="' . $img_link_target . '"'. ''. $data_attributes .'>' . $img_output . '</a></div>' : '<div class="'. $wrapper_classes .'">' . $img_output . '</div>';

$css_class .= $this->getCSSAnimation( $css_animation );
if ( $alignment ) {
    $css_class .= ' vc_align_' . $alignment;
}
$output .= "\n\t" . '<div class="' . $css_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_single_image' );
echo $output;