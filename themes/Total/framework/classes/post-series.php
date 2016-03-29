<?php
/**
 * Post Series Class
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Registers the Post Series Taxonomy
if ( ! class_exists( 'WPEX_Post_Series_Config' ) ) {

	class WPEX_Post_Series_Config {

		/**
		 * Get things started
		 *
		 * @since 2.0.0
		 */
		public function __construct() {

			// Filters
			add_filter( 'manage_edit-post_columns', array( $this, 'edit_columns' ) );
			add_filter( 'wpex_is_blog_query', array( $this, 'wpex_is_blog_query' ) );
			add_filter( 'wpex_customizer_sections', array( $this, 'customizer_settings' ) );

			// Actions
			add_action( 'init', array( $this, 'register' ), 0 );
			add_action( 'manage_post_posts_custom_column', array( $this, 'column_display' ), 10, 2 );
			add_action( 'restrict_manage_posts', array( $this, 'tax_filters' ) );
			add_action( 'wpex_next_prev_same_cat_taxonomy', array( $this, 'next_prev_same_cat_taxonomy' ) );

		}

		/**
		 * Registers the custom taxonomy
		 *
		 * @since 2.0.0
		 */
		public static function register() {

			$name = wpex_get_mod( 'post_series_labels' );
			$name = $name ? $name : __( 'Post Series', 'wpex' );
			$slug = wpex_get_mod( 'post_series_slug' );
			$slug = $slug ? $slug : 'post-series';

			// Apply filters
			$args = apply_filters( 'wpex_taxonomy_post_series_args', array(
				'labels'             => array(
					'name'                       => $name,
					'singular_name'              => $name,
					'menu_name'                  => $name,
					'search_items'               => __( 'Search','wpex' ),
					'popular_items'              => __( 'Popular', 'wpex' ),
					'all_items'                  => __( 'All', 'wpex' ),
					'parent_item'                => __( 'Parent', 'wpex' ),
					'parent_item_colon'          => __( 'Parent', 'wpex' ),
					'edit_item'                  => __( 'Edit', 'wpex' ),
					'update_item'                => __( 'Update', 'wpex' ),
					'add_new_item'               => __( 'Add New', 'wpex' ),
					'new_item_name'              => __( 'New', 'wpex' ),
					'separate_items_with_commas' => __( 'Separate with commas', 'wpex' ),
					'add_or_remove_items'        => __( 'Add or remove', 'wpex' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'wpex' ),
				),
				'public'            => true,
				'show_in_nav_menus' => true,
				'show_ui'           => true,
				'show_tagcloud'     => true,
				'hierarchical'      => true,
				'rewrite'           => array(
					'slug'  => $slug,
				),
				'query_var'         => true
			) );

			// Register the taxonomy
			register_taxonomy( 'post_series', array( 'post' ), $args );

		}

		/**
		 * Adds columns to the WP dashboard edit screen
		 *
		 * @since 2.0.0
		 */
		public static function edit_columns( $columns ) {
			$columns['wpex_post_series'] = __( 'Post Series', 'wpex' );
			return $columns;
		}

		/**
		 * Adds columns to the WP dashboard edit screen
		 *
		 * @since 2.0.0
		 */
		public static function column_display( $column, $post_id ) {
			switch ( $column ) {
				case "wpex_post_series":
				if ( $category_list = get_the_term_list( $post_id, 'post_series', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}
				break;
			}
		}

		/**
		 * Adds taxonomy filters to the posts admin page
		 *
		 * @since 2.0.0
		 */
		public static function tax_filters() {
			global $typenow;
			if ( 'post' == $typenow ) {
				$tax_slug         = 'post_series';
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj          = get_taxonomy( $tax_slug );
				$tax_name         = $tax_obj->labels->name;
				$terms            = get_terms( $tax_slug );
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}

		/**
		 * Alter next/previous post links same_cat taxonomy
		 *
		 * @since 2.0.0
		 */
		public static function next_prev_same_cat_taxonomy( $taxonomy ) {
			if ( wpex_is_post_in_series() ) {
				$taxonomy = 'post_series';
			}
			return $taxonomy;
		}

		/**
		 * Return true for the wpex_is_blog_query when visiting a post_series tax page
		 *
		 * @since 2.0.0
		 */
		public static function wpex_is_blog_query( $bool ) {
			if ( is_tax( 'post_series' ) ) {
				$bool = true;
			}
			return $bool;
		}

		/**
		 * Adds customizer settings for the animations
		 *
		 * @return array
		 *
		 * @since 2.1.0
		 */
		public function customizer_settings( $sections ) {
			$sections['wpex_post_series'] = array(
				'title' => __( 'Post Series', 'wpex' ),
				'panel' => 'wpex_general',
				'settings' => array(
					array(
						'id' => 'post_series_labels',
						'transport' => 'postMessage',
						'control' => array (
							'label' => __( 'Admin Label', 'wpex' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'post_series_slug',
						'transport' => 'postMessage',
						'control' => array (
							'label' => __( 'Slug', 'wpex' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'post_series_bg',
						'control' => array (
							'label' => __( 'Background', 'wpex' ),
							'type' => 'color',
						),
						'inline_css' => array(
							'target' => array(
								'#post-series',
								'#post-series-title',
							),
							'alter' => 'background',
						),
					),
					array(
						'id' => 'post_series_borders',
						'control' => array (
							'label' => __( 'Borders', 'wpex' ),
							'type' => 'color',
						),
						'inline_css' => array(
							'target' => array(
								'#post-series',
								'#post-series-title',
								'#post-series li',
							),
							'alter' => 'border-color',
						),
					),
					array(
						'id' => 'post_series_color',
						'control' => array (
							'label' => __( 'Color', 'wpex' ),
							'type' => 'color',
						),
						'inline_css' => array(
							'target' => array(
								'#post-series',
								'#post-series a',
								'#post-series .post-series-count',
								'#post-series-title',
							),
							'alter' => 'color',
						),
					),
				)
			);
			return $sections;
		}

	}
}
$wpex_post_series = new WPEX_Post_Series_Config;