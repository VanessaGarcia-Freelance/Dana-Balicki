<?php
/**
 * Testimonials Post Type Configuration file
 *
 * @package Total WordPress Theme
 * @subpackage Testimonials Functions
 */

class WPEX_Testimonials_Config {

	/**
	 * Get things started
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// Helper functions
		require_once( WPEX_FRAMEWORK_DIR .'testimonials/testimonials-helpers.php' );

		// Adds the testimonials post type
		add_action( 'init', array( $this, 'register_post_type' ), 0 );

		// Adds the testimonials taxonomies
		add_action( 'init', array( $this, 'register_categories' ), 0 );

		// Adds columns in the admin view for taxonomies
		add_filter( 'manage_edit-testimonials_columns', array( $this, 'edit_columns' ) );
		add_action( 'manage_testimonials_posts_custom_column', array( $this, 'column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_init', array( $this,'register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'notices' ) );

		// Adds the testimonials custom sidebar
		add_filter( 'widgets_init', array( $this, 'register_sidebar' ) );
		add_filter( 'wpex_get_sidebar', array( $this, 'display_sidebar' ) );

		// Alter the default page title
		add_action( 'wpex_title', array( $this, 'alter_title' ) );

		// Alter the post layouts for testimonials posts and archives
		add_filter( 'wpex_post_layout_class', array( $this, 'layouts' ) );

		// Posts per page
		add_action( 'pre_get_posts', array( $this, 'posts_per_page' ) );

		// Add image sizes
		add_filter( 'wpex_image_sizes', array( $this, 'add_image_sizes' ) );

		// Single next/prev visibility
		add_filter( 'wpex_has_next_prev', array( $this, 'next_prev' ) );

		// Alter previous post link title
		add_filter( 'wpex_prev_post_link_title', array( $this, 'prev_post_link_title' ) );

		// Alter next post link title
		add_filter( 'wpex_next_post_link_title', array( $this, 'next_post_link_title' ) );
		
	}
	
	/**
	 * Register post type
	 *
	 * @since 2.0.0
	 */
	public function register_post_type() {

		// Get values and sanitize
		$name                = wpex_get_mod( 'testimonials_labels' );
		$name                = $name ? $name : __( 'Testimonials', 'wpex' );
		$singular_name       = wpex_get_mod( 'testimonials_singular_name' );
		$singular_name       = $singular_name ? $singular_name : __( 'Testimonials Item', 'wpex' );
		$slug                = wpex_get_mod( 'testimonials_slug' );
		$slug                = $slug ? $slug : 'testimonial';
		$menu_icon           = wpex_get_mod( 'testimonials_admin_icon' );
		$menu_icon           = $menu_icon ? $menu_icon : 'format-status';
		$testimonials_search = wpex_get_mod( 'testimonials_search', true );
		$testimonials_search = ! $testimonials_search ? true : false;

		// Labels
		$labels = array(
			'name'               => $name,
			'singular_name'      => $singular_name,
			'add_new'            => __( 'Add New', 'wpex' ),
			'add_new_item'       => __( 'Add New Item', 'wpex' ),
			'edit_item'          => __( 'Edit Item', 'wpex' ),
			'new_item'           => __( 'Add New Testimonials Item', 'wpex' ),
			'view_item'          => __( 'View Item', 'wpex' ),
			'search_items'       => __( 'Search Items', 'wpex' ),
			'not_found'          => __( 'No Items Found', 'wpex' ),
			'not_found_in_trash' => __( 'No Items Found In Trash', 'wpex' )
		);

		// Args
		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'menu_icon'           => 'dashicons-'. $menu_icon,
			'menu_position'       => 20,
			'exclude_from_search' => $testimonials_search,
			'rewrite'             => array(
				'slug'  => $slug,
			),
			'supports'            => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'comments',
				'custom-fields',
				'revisions',
				'author',
				'page-attributes',
			),
		);

		// Apply filters
		$args = apply_filters( 'wpex_testimonials_args', $args );

		// Register the post type
		register_post_type( 'testimonials', $args );

	}

	/**
	 * Register Testimonials category
	 *
	 * @since 2.0.0
	 */
	public function register_categories() {

		// Define and sanitize options
		$name = wpex_get_mod( 'testimonials_cat_labels');
		$name = $name ? $name : __( 'Testimonials Categories', 'wpex' );
		$slug = wpex_get_mod( 'testimonials_cat_slug' );
		$slug = $slug ? $slug : 'testimonials-category';

		// Define testimonials category labels
		$labels = array(
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
		);

		// Define testimonials category arguments
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => $slug,
			),
		);

		// Apply filters for child theming
		$args = apply_filters( 'wpex_taxonomy_testimonials_category_args', $args );

		// Register the testimonials category taxonomy
		register_taxonomy( 'testimonials_category', array( 'testimonials' ), $args );

	}

	/**
	 * Adds columns to the WP dashboard edit screen
	 *
	 * @since 2.0.0
	 */
	public function edit_columns( $columns ) {
		$columns['testimonials_category'] = __( 'Category', 'wpex' );
		return $columns;
	}
	
	/**
	 * Adds columns to the WP dashboard edit screen
	 *
	 * @since 2.0.0
	 */
	public function column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the testimonials categories in the column view
			case 'testimonials_category':

				if ( $category_list = get_the_term_list( $post_id, 'testimonials_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the testimonials admin page
	 *
	 * @since 2.0.0
	 */
	function tax_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'testimonials_category' );

		// must set this to the post type you want the filter(s) displayed on
		if ( 'testimonials' == $typenow ) {

			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug   = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj            = get_taxonomy( $tax_slug );
				$tax_name           = $tax_obj->labels->name;
				$terms              = get_terms( $tax_slug );
				if ( count( $terms ) > 0 ) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}

	/**
	 * Add sub menu page for the Testimonials Editor
	 *
	 * @since 2.0.0
	 */
	function add_page() {
		add_submenu_page(
			'edit.php?post_type=testimonials',
			__( 'Post Type Editor', 'wpex' ),
			__( 'Post Type Editor', 'wpex' ),
			'administrator',
			'wpex-testimonials-editor',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Function that will register the testimonials editor admin page
	 *
	 * @since 2.0.0
	 */
	function register_page_options() {
		register_setting( 'wpex_testimonials_options', 'wpex_testimonials_branding', array( $this, 'sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved
	 *
	 * @since 2.0.0
	 */
	function notices() {
		settings_errors( 'wpex_testimonials_editor_page_notices' );
	}

	/**
	 * Sanitizes input and saves theme_mods
	 *
	 * @since 2.0.0
	 */
	function sanitize( $options ) {

		// Save values to theme mod
		if ( ! empty ( $options ) ) {
			foreach( $options as $key => $value ) {
				if ( $value ) {
					set_theme_mod( $key, $value );
				}
			}
		}

		// Add notice
		add_settings_error(
			'wpex_testimonials_editor_page_notices',
			esc_attr( 'settings_updated' ),
			__( 'Settings saved.', 'wpex' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	/**
	 * Output for the actual Testimonials Editor admin page
	 *
	 * @since 2.0.0
	 */
	function create_admin_page() { ?>
		<div class="wrap">
			<h2><?php _e( 'Post Type Editor', 'wpex' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'wpex_testimonials_options' ); ?>
				<p><?php _e( 'If you alter any slug\'s make sure to reset your permalinks to prevent 404 errors.', 'wpex' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Admin Icon', 'wpex' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','testimonials','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="wpex_testimonials_branding[testimonials_admin_icon]">
								<option value="0"><?php _e( 'Select', 'wpex' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo $dashicon; ?>" <?php selected( wpex_get_mod( 'testimonials_admin_icon' ), $dashicon, true ); ?>><?php echo $dashicon; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Post Type: Name', 'wpex' ); ?></th>
						<td><input type="text" name="wpex_testimonials_branding[testimonials_labels]" value="<?php echo wpex_get_mod( 'testimonials_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Post Type: Singular Name', 'wpex' ); ?></th>
						<td><input type="text" name="wpex_testimonials_branding[testimonials_singular_name]" value="<?php echo wpex_get_mod( 'testimonials_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Post Type: Slug', 'wpex' ); ?></th>
						<td><input type="text" name="wpex_testimonials_branding[testimonials_slug]" value="<?php echo wpex_get_mod( 'testimonials_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Categories: Label', 'wpex' ); ?></th>
						<td><input type="text" name="wpex_testimonials_branding[testimonials_cat_labels]" value="<?php echo wpex_get_mod( 'testimonials_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Categories: Slug', 'wpex' ); ?></th>
						<td><input type="text" name="wpex_testimonials_branding[testimonials_cat_slug]" value="<?php echo wpex_get_mod( 'testimonials_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

	/**
	 * Registers a new custom testimonials sidebar
	 *
	 * @since 2.0.0
	 */
	public function register_sidebar() {

		// Return if custom sidebar is disabled
		if ( ! wpex_get_mod( 'testimonials_custom_sidebar', true ) ) {
			return;
		}

		// Get heading tag
		$heading_tag = wpex_get_mod( 'sidebar_headings', 'div' );
		$heading_tag = $heading_tag ? $heading_tag : 'div';

		// Get post type object to name sidebar correctly
		$obj            = get_post_type_object( 'testimonials' );
		$post_type_name = $obj->labels->name;

		// Register custom sidebar
		register_sidebar( array (
			'name'          => $post_type_name .' '. __( 'Sidebar', 'wpex' ),
			'id'            => 'testimonials_sidebar',
			'before_widget' => '<div class="sidebar-box %2$s clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $heading_tag .' class="widget-title">',
			'after_title'   => '</'. $heading_tag .'>',
		) );

	}

	/**
	 * Alter main sidebar to display testimonials sidebar
	 *
	 * @since 2.0.0
	 */
	public function display_sidebar( $sidebar ) {
		if ( wpex_get_mod( 'testimonials_custom_sidebar', true ) && ( is_singular( 'testimonials' ) || wpex_is_testimonials_tax() ) ) {
			$sidebar = 'testimonials_sidebar';
		}
		return $sidebar;
	}

	/**
	 * Alters the default page title
	 *
	 * @since 2.0.0
	 */
	public function alter_title( $title ) {
		if ( is_singular( 'testimonials' ) ) {
			$author = get_post_meta( get_the_ID(), 'wpex_testimonial_author', true );
			if ( ! wpex_get_mod( 'testimonials_labels' ) && $author ) {
				$title = sprintf( __( 'Testimonial by: %s', 'wpex' ), $author );
			} else {
				$obj    = get_post_type_object( 'testimonials' );
				$title  = $obj->labels->singular_name;
			}
		}
		return $title;
	}

	/**
	 * Alter the post layouts for testimonials posts and archives
	 *
	 * @since 2.0.0
	 */
	public function layouts( $class ) {
		if ( is_singular( 'testimonials' ) ) {
			$class = wpex_get_mod( 'testimonials_single_layout', 'right-sidebar' );
		} elseif ( wpex_is_testimonials_tax() && ! is_search() ) {
			$class = wpex_get_mod( 'testimonials_archive_layout', 'full-width' );
		}
		return $class;
	}

	/**
	 * Alters posts per page for the testimonials taxonomies
	 *
	 * @since 2.0.0
	 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
	 */
	public function posts_per_page( $query ) {
		if ( wpex_is_testimonials_tax() && $query->is_main_query() ) {
			$query->set( 'posts_per_page', wpex_get_mod( 'testimonials_archive_posts_per_page', '12' ) );
			return;
		}
	}

	/**
	 * Adds image sizes for the testimonials to the image sizes panel
	 *
	 * @since 2.0.0
	 */
	public function add_image_sizes( $sizes ) {
		$obj            = get_post_type_object( 'testimonials' );
		$post_type_name = $obj->labels->singular_name;
		$new_sizes  = array(
			'testimonials_entry'   => array(
				'label'     => sprintf( __( '%s Entry', 'wpex' ), $post_type_name ),
				'width'     => 'testimonials_entry_image_width',
				'height'    => 'testimonials_entry_image_height',
				'crop'      => 'testimonials_entry_image_crop',
			),
		);
		$sizes = array_merge( $sizes, $new_sizes );
		return $sizes;
	}

	/**
	 * Disables the next/previous links if disabled via the customizer.
	 *
	 * @since 2.0.0
	 */
	public function next_prev( $return ) {
		if ( is_singular( 'testimonials' ) && ! wpex_get_mod( 'testimonials_next_prev', true ) ) {
			$return = false;
		}
		return $return;
	}

	/**
	 * Alter previous post link title
	 *
	 * @since 2.0.0
	 */
	public function prev_post_link_title( $title ) {
		if ( is_singular( 'testimonials' ) ) {
			$title = '<span class="fa fa-angle-double-left"></span>' . __( 'Previous', 'wpex' );
		}
		return $title;
	}
	
	/**
	 * Alter next post link title
	 *
	 * @since 2.0.0
	 */
	public function next_post_link_title( $title ) {
		if ( is_singular( 'testimonials' ) ) {
			$title = __( 'Next', 'wpex' ) . '<span class="fa fa-angle-double-right"></span>';
		}
		return $title;
	}

}
$wpex_testimonials_config = new WPEX_Testimonials_Config;