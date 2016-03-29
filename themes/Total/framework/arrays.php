<?php
/**
 * Useful functions that return arrays
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 * @since 2.1.3
 */

/**
 * Returns array of Social Options for the Top Bar
 *
 * @since 1.6.0
 */
function wpex_topbar_social_options() {
	return apply_filters ( 'wpex_topbar_social_options', array(
		'twitter' => array(
			'label' => 'Twitter',
			'icon_class' => 'fa fa-twitter',
		),
		'facebook' => array(
			'label' => 'Facebook',
			'icon_class' => 'fa fa-facebook',
		),
		'googleplus' => array(
			'label' => 'Google Plus',
			'icon_class' => 'fa fa-google-plus',
		),
		'pinterest'  => array(
			'label' => 'Pinterest',
			'icon_class' => 'fa fa-pinterest',
		),
		'dribbble' => array(
			'label' => 'Dribbble',
			'icon_class' => 'fa fa-dribbble',
		),
		'vk' => array(
			'label' => 'Vk',
			'icon_class' => 'fa fa-vk',
		),
		'instagram'  => array(
			'label' => 'Instagram',
			'icon_class' => 'fa fa-instagram',
		),
		'linkedin' => array(
			'label' => 'LinkedIn',
			'icon_class' => 'fa fa-linkedin',
		),
		'tumblr'  => array(
			'label' => 'Tumblr',
			'icon_class' => 'fa fa-tumblr',
		),
		'github'  => array(
			'label' => 'Github',
			'icon_class' => 'fa fa-github-alt',
		),
		'flickr'  => array(
			'label' => 'Flickr',
			'icon_class' => 'fa fa-flickr',
		),
		'skype' => array(
			'label' => 'Skype',
			'icon_class' => 'fa fa-skype',
		),
		'youtube' => array(
			'label' => 'Youtube',
			'icon_class' => 'fa fa-youtube',
		),
		'vimeo' => array(
			'label' => 'Vimeo',
			'icon_class' => 'fa fa-vimeo-square',
		),
		'vine' => array(
			'label' => 'Vine',
			'icon_class' => 'fa fa-vine',
		),
		'xing' => array(
			'label' => 'Xing',
			'icon_class' => 'fa fa-xing',
		),
		'yelp' => array(
			'label' => 'Yelp',
			'icon_class' => 'fa fa-yelp',
		),
		'tripadvisor' => array(
			'label' => 'Tripadvisor',
			'icon_class' => 'fa fa-tripadvisor',
		),
		'rss'  => array(
			'label' => __( 'RSS', 'wpex' ),
			'icon_class' => 'fa fa-rss',
		),
		'email' => array(
			'label' => __( 'Email', 'wpex' ),
			'icon_class' => 'fa fa-envelope',
		),
	) );
}

/**
 * Array of social profiles for staff members
 *
 * @since 1.5.4
 */
function wpex_staff_social_array() {
	return apply_filters( 'wpex_staff_social_array', array(
		'twitter'        => array (
			'key'        => 'twitter',
			'meta'       => 'wpex_staff_twitter',
			'icon_class' => 'fa fa-twitter',
			'label'      => 'Twitter',
		),
		'facebook'        => array (
			'key'        => 'facebook',
			'meta'       => 'wpex_staff_facebook',
			'icon_class' => 'fa fa-facebook',
			'label'      => 'Facebook',
		),
		'instagram'      => array (
			'key'        => 'instagram',
			'meta'       => 'wpex_staff_instagram',
			'icon_class' => 'fa fa-instagram',
			'label'      => 'Instagram',
		),
		'google-plus'    => array (
			'key'        => 'google-plus',
			'meta'       => 'wpex_staff_google-plus',
			'icon_class' => 'fa fa-google-plus',
			'label'      => 'Google Plus',
		),
		'linkedin'       => array (
			'key'        => 'linkedin',
			'meta'       => 'wpex_staff_linkedin',
			'icon_class' => 'fa fa-linkedin',
			'label'      => 'Linkedin',
		),
		'dribbble'       => array (
			'key'        => 'dribbble',
			'meta'       => 'wpex_staff_dribbble',
			'icon_class' => 'fa fa-dribbble',
			'label'      => 'Dribbble',
		),
		'vk'             => array (
			'key'        => 'vk',
			'meta'       => 'wpex_staff_vk',
			'icon_class' => 'fa fa-vk',
			'label'      => 'VK',
		),
		'skype'          => array (
			'key'        => 'skype',
			'meta'       => 'wpex_staff_skype',
			'icon_class' => 'fa fa-skype',
			'label'      => 'Skype',
		),
		'phone_number'   => array (
			'key'        => 'phone_number',
			'meta'       => 'wpex_staff_phone_number',
			'icon_class' => 'fa fa-phone',
			'label'      => __( 'Phone Number', 'wpex' ),
		),
		'email'          => array (
			'key'        => 'email',
			'meta'       => 'wpex_staff_email',
			'icon_class' => 'fa fa-envelope',
			'label'      => __( 'Email', 'wpex' ),
		),
		'website'        => array (
			'key'        => 'website',
			'meta'       => 'wpex_staff_website',
			'icon_class' => 'fa fa-external-link-square',
			'label'      => __( 'Website', 'wpex' ),
		),
	) );
}

/**
 * Creates an array for adding the staff social options to the metaboxes
 *
 * @since 1.5.4
 */
function wpex_staff_social_meta_array() {
	$profiles = wpex_staff_social_array();
	$array = array();
	foreach ( $profiles as $profile ) {
		$array[] = array(
				'title' => '<span class="'. $profile['icon_class'] .'"></span>' . $profile['label'],
				'id'    => $profile['meta'],
				'type'  => 'text',
				'std'   => '',
		);
	}
	return $array;
}

/**
 * Grid Columns
 *
 * @since 2.0.0
 */
function wpex_grid_columns() {
	return apply_filters( 'wpex_grid_columns', array(
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
		'7' => '7',
	) );
}

/**
 * Grid Column Gaps
 *
 * @since 2.0.0
 */
function wpex_column_gaps() {
	return apply_filters( 'wpex_column_gaps', array(
		''     => __( 'Default', 'wpex' ),
		'none' => '0px',
		'5'    => '5px',
		'10'   => '10px',
		'15'   => '15px',
		'20'   => '20px',
		'25'   => '25px',
		'30'   => '30px',
		'35'   => '35px',
		'40'   => '40px',
		'50'   => '50px',
		'60'   => '60px',
	) );
}

/**
 * Typography Styles
 *
 * @since 2.0.0
 */
function wpex_typography_styles() {
	return apply_filters( 'wpex_typography_styles', array(
		''      => __( 'Default', 'wpex' ),
		'light' => __( 'Light', 'wpex' ),
		'white' => __( 'White', 'wpex' ),
		'black' => __( 'Black', 'wpex' ),
		'none'  => __( 'None', 'wpex' ),
	) );
}

/**
 * Button styles
 *
 * @since 1.6.2
 */
function wpex_button_styles() {
	return apply_filters( 'wpex_button_styles', array(
		''               => __( 'Default', 'wpex' ),
		'flat'           => _x( 'Flat', 'Theme Button Style', 'wpex' ),
		'graphical'      => _x( 'Graphical', 'Theme Button Style', 'wpex' ),
		'clean'          => _x( 'Clean', 'Theme Button Style', 'wpex' ),
		'three-d'        => _x( '3D', 'Theme Button Style', 'wpex' ),
		'outline'        => _x( 'Outline', 'Theme Button Style', 'wpex' ),
		'minimal-border' => _x( 'Minimal Border', 'Theme Button Style', 'wpex' ),
	) );
}

/**
 * Button colors
 *
 * @since 1.6.2
 */
function wpex_button_colors() {
	return apply_filters( 'wpex_button_colors', array(
		''       => __( 'Default', 'wpex' ),
		'black'  => __( 'Black', 'wpex' ),
		'blue'   => __( 'Blue', 'wpex' ),
		'brown'  => __( 'Brown', 'wpex' ),
		'grey'   => __( 'Grey', 'wpex' ),
		'green'  => __( 'Green', 'wpex' ),
		'gold'   => __( 'Gold', 'wpex' ),
		'orange' => __( 'Orange', 'wpex' ),
		'pink'   => __( 'Pink', 'wpex' ),
		'purple' => __( 'Purple', 'wpex' ),
		'red'    => __( 'Red', 'wpex' ),
		'rosy'   => __( 'Rosy', 'wpex' ),
		'teal'   => __( 'Teal', 'wpex' ),
		'white'  => __( 'White', 'wpex' ),
	) );
}

/**
 * Array of image crop locations
 *
 * @link 2.0.0
 */
function wpex_image_crop_locations() {
	return array(
		''              => __( 'Default', 'wpex' ),
		'left-top'      => __( 'Top Left', 'wpex' ),
		'right-top'     => __( 'Top Right', 'wpex' ),
		'center-top'    => __( 'Top Center', 'wpex' ),
		'left-center'   => __( 'Center Left', 'wpex' ),
		'right-center'  => __( 'Center Right', 'wpex' ),
		'center-center' => __( 'Center Center', 'wpex' ),
		'left-bottom'   => __( 'Bottom Left', 'wpex' ),
		'right-bottom'  => __( 'Bottom Right', 'wpex' ),
		'center-bottom' => __( 'Bottom Center', 'wpex' ),
	);
}

/**
 * Image Hovers
 *
 * @since 1.6.2
 */
function wpex_image_hovers() {
	return apply_filters( 'wpex_image_hovers', array(
		''             => __( 'Default', 'wpex' ),
		'opacity'      => _x( 'Opacity', 'Image Hover', 'wpex' ),
		'grow'         => _x( 'Grow', 'Image Hover', 'wpex' ),
		'shrink'       => _x( 'Shrink', 'Image Hover', 'wpex' ),
		'side-pan'     => _x( 'Side Pan', 'Image Hover', 'wpex' ),
		'vertical-pan' => _x( 'Vertical Pan', 'Image Hover', 'wpex' ),
		'tilt'         => _x( 'Tilt', 'Image Hover', 'wpex' ),
		'blurr'        => _x( 'Normal - Blurr', 'Image Hover', 'wpex' ),
		'blurr-invert' => _x( 'Blurr - Normal', 'Image Hover', 'wpex' ),
		'sepia'        => _x( 'Sepia', 'Image Hover', 'wpex' ),
		'fade-out'     => _x( 'Fade Out', 'Image Hover', 'wpex' ),
		'fade-in'      => _x( 'Fade In', 'Image Hover', 'wpex' ),
	) );
}

/**
 * Font Weights
 *
 * @since Total 1.6.2
 */
function wpex_font_weights() {
	return apply_filters( 'wpex_font_weights', array(
		''         => __( 'Default', 'wpex' ),
		'normal'   => _x( 'Normal', 'Font Weight', 'wpex' ),
		'semibold' => _x( 'Semibold', 'Font Weight', 'wpex' ),
		'bold'     => _x( 'Bold', 'Font Weight', 'wpex' ),
		'bolder'   => _x( 'Bolder', 'Font Weight', 'wpex' ),
		'100'      => '100',
		'200'      => '200',
		'300'      => '300',
		'400'      => '400',
		'500'      => '500',
		'600'      => '600',
		'700'      => '700',
		'800'      => '800',
		'900'      => '900',
	) );
}

/**
 * Text Transform
 *
 * @since 1.6.2
 */
function wpex_text_transforms() {
	return array(
		''           => __( 'Default', 'wpex' ),
		'none'       => __( 'None', 'wpex' ) ,
		'capitalize' => __( 'Capitalize', 'wpex' ),
		'uppercase'  => __( 'Uppercase', 'wpex' ),
		'lowercase'  => __( 'Lowercase', 'wpex' ),
	);
}

/**
 * Border Styles
 *
 * @since 1.6.0
 */
function wpex_border_styles() {
	return array(
		''       => __( 'Default', 'wpex' ),
		'solid'  => __( 'Solid', 'wpex' ),
		'dotted' => __( 'Dotted', 'wpex' ),
		'dashed' => __( 'Dashed', 'wpex' ),
	);
}

/**
 * Alignments
 *
 * @since 1.6.0
 */
function wpex_alignments() {
	return array(
		''       => __( 'Default', 'wpex' ),
		'left'   => __( 'Left', 'wpex' ),
		'right'  => __( 'Right', 'wpex' ),
		'center' => __( 'Center', 'wpex' ),
	);
}

/**
 * Visibility
 *
 * @since 1.6.0
 */
function wpex_visibility() {
	return apply_filters( 'wpex_visibility', array(
		''                         => __( 'Always Visible', 'wpex' ),
		'hidden-phone'             => __( 'Hidden on Phones', 'wpex' ),
		'hidden-tablet'            => __( 'Hidden on Tablets', 'wpex' ),
		'hidden-tablet-landscape'  => __( 'Hidden on Tablets: Landscape', 'wpex' ),
		'hidden-tablet-portrait'   => __( 'Hidden on Tablets: Portrait', 'wpex' ),
		'hidden-desktop'           => __( 'Hidden on Desktop', 'wpex' ),
		'visible-desktop'          => __( 'Visible on Desktop Only', 'wpex' ),
		'visible-phone'            => __( 'Visible on Phones Only', 'wpex' ),
		'visible-tablet'           => __( 'Visible on Tablets Only', 'wpex' ),
		'visible-tablet-landscape' => __( 'Visible on Tablets: Landscape Only', 'wpex' ),
		'visible-tablet-portrait'  => __( 'Visible on Tablets: Portrait Only', 'wpex' ),
	) );
}

/**
 * CSS Animations
 *
 * @since 1.6.0
 */
function wpex_css_animations() {
	return apply_filters( 'wpex_css_animations', array(
		''              => __( 'None', 'wpex') ,
		'top-to-bottom' => __( 'Top to bottom', 'wpex' ),
		'bottom-to-top' => __( 'Bottom to top', 'wpex' ),
		'left-to-right' => __( 'Left to right', 'wpex' ),
		'right-to-left' => __( 'Right to left', 'wpex' ),
		'appear'        => __( 'Appear from center', 'wpex' ),
	) );
}

/**
 * Array of Hover CSS animations
 *
 * @since 2.0.0
 */
function wpex_hover_css_animations() {
	return apply_filters( 'wpex_hover_css_animations', array(
		''                          => __( 'Default', 'wpex' ),
		'shadow'                    => _x( 'Shadow', 'Hover Effect', 'wpex' ),
		'grow-shadow'               => _x( 'Grow Shadow', 'Hover Effect', 'wpex' ),
		'float-shadow'              => _x( 'Float Shadow', 'Hover Effect', 'wpex' ),
		'grow'                      => _x( 'Grow', 'Hover Effect', 'wpex' ),
		'shrink'                    => _x( 'Shrink', 'Hover Effect', 'wpex' ),
		'pulse'                     => _x( 'Pulse', 'Hover Effect', 'wpex' ),
		'pulse-grow'                => _x( 'Pulse Grow', 'Hover Effect', 'wpex' ),
		'pulse-shrink'              => _x( 'Pulse Shrink', 'Hover Effect', 'wpex' ),
		'push'                      => _x( 'Push', 'Hover Effect', 'wpex' ),
		'pop'                       => _x( 'Pop', 'Hover Effect', 'wpex' ),
		'bounce-in'                 => _x( 'Bounce In', 'Hover Effect', 'wpex' ),
		'bounce-out'                => _x( 'Bounce Out', 'Hover Effect', 'wpex' ),
		'rotate'                    => _x( 'Rotate', 'Hover Effect', 'wpex' ),
		'grow-rotate'               => _x( 'Grow Rotate', 'Hover Effect', 'wpex' ),
		'float'                     => _x( 'Float', 'Hover Effect', 'wpex' ),
		'sink'                      => _x( 'Sink', 'Hover Effect', 'wpex' ),
		'bob'                       => _x( 'Bob', 'Hover Effect', 'wpex' ),
		'hang'                      => _x( 'Hang', 'Hover Effect', 'wpex' ),
		'skew'                      => _x( 'Skew', 'Hover Effect', 'wpex' ),
		'skew-backward'             => _x( 'Skew Backward', 'Hover Effect', 'wpex' ),
		'wobble-horizontal'         => _x( 'Wobble Horizontal', 'Hover Effect', 'wpex' ),
		'wobble-vertical'           => _x( 'Wobble Vertical', 'Hover Effect', 'wpex' ),
		'wobble-to-bottom-right'    => _x( 'Wobble To Bottom Right', 'Hover Effect', 'wpex' ),
		'wobble-to-top-right'       => _x( 'Wobble To Top Right', 'Hover Effect', 'wpex' ),
		'wobble-top'                => _x( 'Wobble Top', 'Hover Effect', 'wpex' ),
		'wobble-bottom'             => _x( 'Wobble Bottom', 'Hover Effect', 'wpex' ),
		'wobble-skew'               => _x( 'Wobble Skew', 'Hover Effect', 'wpex' ),
		'buzz'                      => _x( 'Buzz', 'Hover Effect', 'wpex' ),
		'buzz-out'                  => _x( 'Buzz Out', 'Hover Effect', 'wpex' ),
		'glow'                      => _x( 'Glow', 'Hover Effect', 'wpex' ),
		'shadow-radial'             => _x( 'Shadow Radial', 'Hover Effect', 'wpex' ),
		'box-shadow-outset'         => _x( 'Box Shadow Outset', 'Hover Effect', 'wpex' ),
		'box-shadow-inset'          => _x( 'Box Shadow Inset', 'Hover Effect', 'wpex' ),
	) );
}

/**
 * Image filter styles
 *
 * @since 1.4.0
 */
function wpex_image_filters() {
	return apply_filters( 'wpex_image_filters', array (
		''          => __( 'None', 'wpex' ),
		'grayscale' => __( 'Grayscale', 'wpex' ),
	) );
}

/**
 * Social Link styles
 *
 * @since 3.0.0
 */
function wpex_social_button_styles() {
	return apply_filters( 'wpex_social_button_styles', array (
		''                   => __( 'Skin Default', 'wpex' ),
		'none'               => __( 'None', 'wpex' ),
		'minimal'            => _x( 'Minimal', 'Social Button Style', 'wpex' ),
		'minimal-rounded'    => _x( 'Minimal Rounded', 'Social Button Style', 'wpex' ),
		'minimal-round'      => _x( 'Minimal Round', 'Social Button Style', 'wpex' ),
		'flat'               => _x( 'Flat', 'Social Button Style', 'wpex' ),
		'flat-rounded'       => _x( 'Flat Rounded', 'Social Button Style', 'wpex' ),
		'flat-round'         => _x( 'Flat Round', 'Social Button Style', 'wpex' ),
		'flat-color'         => _x( 'Flat Color', 'Social Button Style', 'wpex' ),
		'flat-color-rounded' => _x( 'Flat Color Rounded', 'Social Button Style', 'wpex' ),
		'flat-color-round'   => _x( 'Flat Color Round', 'Social Button Style', 'wpex' ),
		'3d'                 => _x( '3D', 'Social Button Style', 'wpex' ),
		'3d-color'           => _x( '3D Color', 'Social Button Style', 'wpex' ),
		'black'              => _x( 'Black', 'Social Button Style', 'wpex' ),
		'black-rounded'      => _x( 'Black Rounded', 'Social Button Style', 'wpex' ),
		'black-round'        => _x( 'Black Round', 'Social Button Style', 'wpex' ),
		'black-ch'           => _x( 'Black & Color Hover', 'Social Button Style', 'wpex' ),
		'black-ch-rounded'   => _x( 'Black & Color Hover Rounded', 'Social Button Style', 'wpex' ),
		'black-ch-round'     => _x( 'Black & Color Hover Round', 'Social Button Style', 'wpex' ),
		'graphical'          => _x( 'Graphical', 'Social Button Style', 'wpex' ),
		'graphical-rounded'  => _x( 'Graphical Rounded', 'Social Button Style', 'wpex' ),
		'graphical-round'    => _x( 'Graphical Round', 'Social Button Style', 'wpex' ),
	) );
}