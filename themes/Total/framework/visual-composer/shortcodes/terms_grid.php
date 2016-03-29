<?php
/**
 * Visual Composer Terms Grid
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.1.0
 */
class WPBakeryShortCode_vcex_terms_grid extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_terms_grid.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 2.1.0
 */
function vcex_terms_grid_vc_map() {
	vc_map( array(
		'name' => __( 'Categories Grid', 'wpex' ),
		'description' => __( 'Displays a grid of terms', 'wpex' ),
		'base' => 'vcex_terms_grid',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-terms-grid vcex-icon fa fa-th-large',
		'params' => array(
			// General
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Taxonomy', 'wpex' ),
				'param_name' => 'taxonomy',
				'std' => 'category',
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Parent Terms Only', 'wpex' ),
				'param_name' => 'parent_terms',
				'value' => array(
					__( 'No', 'wpex' ) => false,
					__( 'Yes', 'wpex' ) => true,
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Unique Id', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Classes', 'wpex' ),
				'param_name' => 'classes',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS Animation', 'wpex' ),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns', 'wpex' ),
				'param_name' => 'columns',
				'value' => array_flip( wpex_grid_columns() ),
				'std' => '3',
				'edit_field_class' => 'vc_col-sm-4 vc_column clear',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gap', 'wpex' ),
				'param_name' => 'columns_gap',
				'value' => array_flip( wpex_column_gaps() ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Responsive', 'wpex' ),
				'param_name' => 'columns_responsive',
				'value' => array(
					__( 'Yes', 'wpex' ) => '',
					__( 'No', 'wpex' ) => 'false',
				),
				'std' => '',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
			),
			// Image
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'full',
				'value' => vcex_image_sizes(),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'description' => __( 'Enter a width in pixels.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Link Hover', 'wpex' ),
				'param_name' => 'img_hover_style',
				'value' => array_flip( wpex_image_hovers() ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'group' => __( 'Image', 'wpex' ),
			),
			// Title
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'title',
				'std' => 'true',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex') => 'false',
				),
				'group' => __( 'Title', 'wpex' ),
			),
			array(
				'type' => 'font_container',
				'param_name' => 'title_typo',
				'group' => __( 'Title', 'wpex' ),
				'settings' => array(
					'fields' => array(
						'tag' => 'span',
						//'text_align',
						'font_size',
						'line_height',
						'color',
						'font_style_italic',
						'font_style_bold',
						'font_family',
					),
				),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			// Description
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'description',
				'std' => 'true',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex') => 'false',
				),
				'group' => __( 'Description', 'wpex' ),
			),
			array(
				'type' => 'font_container',
				'param_name' => 'description_typo',
				'group' => __( 'Description', 'wpex' ),
				'settings' => array(
					'fields' => array(
						'font_size',
						//'text_align',
						'line_height',
						'color',
						'font_style_italic',
						'font_style_bold',
						'font_family',
					),
				),
				'dependency' => array( 'element' => 'description', 'value' => 'true' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'entry_css',
				'group' => __( 'Entry CSS', 'wpex' ),
			),
		)
	) );
}

// Map shortcode
add_action( 'vc_before_init', 'vcex_terms_grid_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_terms_grid_taxonomy_callback', 'vcex_suggest_taxonomies', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_terms_grid_taxonomy_render', 'vcex_render_taxonomies', 10, 1 );