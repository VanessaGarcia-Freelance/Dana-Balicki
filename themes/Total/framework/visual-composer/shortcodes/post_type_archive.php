<?php
/**
 * Post Type Archive
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_post_type_archive extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_post_type_archive.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_post_type_archive_vc_map() {
	$post_types = array();
	if ( is_admin() ) {
		$post_types = vcex_get_post_types();
	}
	vc_map( array(
		'name' => __( 'Post Types Archive', 'wpex' ),
		'description' => __( 'Custom post type archive', 'wpex' ),
		'base' => 'vcex_post_type_archive',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-post-type-grid vcex-icon fa fa-files-o',
		'params' => array(
			// General
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
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Appear Animation', 'wpex'),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Posts Per Page', 'wpex' ),
				'param_name' => 'posts_per_page',
				'value' => '12',
				'description' => __( 'You can enter "-1" to display all posts.', 'wpex' ),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Pagination', 'wpex' ),
				'param_name' => 'pagination',
				'value' => array(
					__( 'False', 'wpex') => '',
					__( 'True', 'wpex' ) => 'true',
				),
				'description' => __( 'Important: Pagination will not work on your homepage due to how WordPress Queries function.', 'wpex' ),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post Type', 'wpex' ),
				'param_name' => 'post_type',
				'value' => $post_types,
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Limit By Post ID\'s', 'wpex' ),
				'param_name' => 'posts_in',
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'Seperate by a comma.', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Limit By Author', 'wpex' ),
				'param_name' => 'author_in',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Query by Taxonomy', 'wpex' ),
				'param_name' => 'tax_query',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex') => 'true',
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Taxonomy Name', 'wpex' ),
				'param_name' => 'tax_query_taxonomy',
				'dependency' => array(
					'element' => 'tax_query',
					'value' => 'true',
				),
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					//'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'If you do not see your taxonomy in the dropdown you can still enter the taxonomy name manually.', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Terms', 'wpex' ),
				'param_name' => 'tax_query_terms',
				'dependency' => array(
					'element' => 'tax_query',
					'value' => 'true',
				),
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => true,
					//'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'If you do not see your terms in the dropdown you can still enter the term slugs manually seperated by a space.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order', 'wpex' ),
				'param_name' => 'order',
				'group' => __( 'Query', 'wpex' ),
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'DESC', 'wpex' ) => 'DESC',
					__( 'ASC', 'wpex' ) => 'ASC',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order By', 'wpex' ),
				'param_name' => 'orderby',
				'value' => vcex_orderby_array(),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Orderby: Meta Key', 'wpex' ),
				'param_name' => 'orderby_meta_key',
				'group' => __( 'Query', 'wpex' ),
				'dependency' => array(
					'element' => 'orderby',
					'value' => array( 'meta_value_num', 'meta_value' ),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post With Thumbnails Only', 'wpex' ),
				'param_name' => 'thumbnail_query',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex') => 'true',
				),
				'group' => __( 'Query', 'wpex' ),
			),

		)
	) );
}

// Map Shortcodes
add_action( 'init', 'vcex_post_type_archive_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_post_type_archive_tax_query_taxonomy_callback', 'vcex_suggest_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_archive_tax_query_terms_callback', 'vcex_suggest_terms', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_archive_author_in_callback', 'vcex_suggest_users', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_post_type_archive_tax_query_taxonomy_render', 'vcex_render_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_archive_tax_query_terms_render', 'vcex_render_terms', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_archive_author_in_render', 'vcex_render_users', 10, 1 );