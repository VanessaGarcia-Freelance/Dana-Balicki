<?php
/**
 * Recent posts grid custom widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package Total WordPress Theme
 * @subpackage Widgets
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class Wpex_Recent_Posts_Thumb_Grid extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'wpex_recent_posts_thumb_grid',
			WPEX_THEME_BRANDING . ' - '. __( 'Posts Thumbnail Grid', 'wpex' )
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {

		// Set vars for widget usage
		$title      = isset( $instance['title'] ) ? $instance['title'] : '';
		$title      = apply_filters( 'widget_title', $title );
		$post_type  = isset( $instance['post_type'] ) ? $instance['post_type'] : '';
		$taxonomy   = isset( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
		$terms      = isset( $instance['terms'] ) ? $instance['terms'] : '';
		$number     = isset( $instance['number'] ) ? $instance['number'] : '';
		$order      = isset( $instance['order'] ) ? $instance['order'] : '';
		$columns    = isset( $instance['columns'] ) ? $instance['columns'] : '3';
		$img_hover  = isset( $instance['img_hover'] ) ? $instance['img_hover'] : '';
		$img_size   = isset( $instance['img_size'] ) ? $instance['img_size'] : 'wpex_custom';
		$img_height = ( ! empty( $instance['img_height'] ) ) ? intval( $instance['img_height'] ) : '';
		$img_width  = ( ! empty( $instance['img_width'] ) ) ? intval( $instance['img_width'] ) : '';
		$img_size   = ( $img_width || $img_height ) ? 'wpex_custom' : $img_size;
		$exclude    = ( is_singular() ) ? array( get_the_ID() ) : NULL;

		// Sanitize terms
		if ( $terms ) {
			$terms = str_replace( ', ', ',', $terms );
			$terms = explode( ',', $terms );
		}

		// Before widget WP hook
		echo $args['before_widget'];

		// Display title if defined
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; 
		} ?>

		<ul class="wpex-recent-posts-thumb-grid wpex-row clr">

			<?php
			// Query args
			$query_args = array(
				'post_type'         => $post_type,
				'posts_per_page'    => $number,
				'orderby'           => $order,
				'meta_key'          => '_thumbnail_id',
				'post__not_in'      => $exclude,
				'no_found_rows'     => true,
			);

			// Taxonomy args
			if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
				$query_args['tax_query']  = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $terms,
					),
				);
			}

			// Query posts
			$my_query = new WP_Query( $query_args ); ?>
			
			<?php
			// Set post counter variable
			$count=0; ?>

			<?php
			// Loop through posts
			while ( $my_query->have_posts() ) : $my_query->the_post(); ?>

				<?php
				// Add to counter variable
				$count++; ?>
				
				<?php
				// Get post thumbnail
				$thumbnail = wpex_get_post_thumbnail( array(
					'size'      => $img_size,
					'width'     => $img_width,
					'height'    => $img_height,
					'alt'       => wpex_get_esc_title(),
				) ); ?>

				<?php
				// Get hover classes
				if ( $img_hover ) {
					$hover_classes = ' class="'. wpex_image_hover_classes( $img_hover ) .'"';
				} else {
					$hover_classes = '';
				} ?>

				<li class="<?php echo wpex_grid_class( $columns ); ?> nr-col col-<?php echo $count; ?>">
					<a href="<?php wpex_permalink(); ?>" title="<?php wpex_esc_title(); ?>"<?php echo $hover_classes; ?>><?php echo $thumbnail; ?></a>
				</li>

				<?php
				// Reset counter to clear floats
				if ( $count == $columns ) $count = '0'; ?>

			<?php
			// End loop
			endwhile; ?>

			<?php
			// Reset global query post data
			wp_reset_postdata(); ?>

		</ul>

		<?php
		// After widget WP hook
		echo $args['after_widget']; ?>
		
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {

		$instance               = $old_instance;
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_type']  = ( ! empty( $new_instance['post_type'] ) ) ? $new_instance['post_type'] : '';
		$instance['taxonomy']   = ( ! empty( $new_instance['taxonomy'] ) ) ? $new_instance['taxonomy'] : '';
		$instance['terms']      = ( ! empty( $new_instance['terms'] ) ) ?  strip_tags( $new_instance['terms'] ) : '';
		$instance['number']     = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		$instance['order']      = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['columns']    = ( ! empty( $new_instance['columns'] ) ) ? $new_instance['columns'] : '3';
		$instance['img_hover']  = ( ! empty( $new_instance['img_hover'] ) ) ? $new_instance['img_hover'] : '';
		$instance['img_size']   = ( ! empty( $new_instance['img_size'] ) ) ? $new_instance['img_size'] : 'wpex_custom';
		$instance['img_height'] = ( ! empty( $new_instance['img_height'] ) ) ? intval( strip_tags( $new_instance['img_height'] ) ) : '';
		$instance['img_width']  = ( ! empty( $new_instance['img_width'] ) ) ? intval( strip_tags( $new_instance['img_width'] ) ) : '';

		return $instance;

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, array(
			'title'         => __( 'Recent Posts', 'wpex' ),
			'number'        => '6',
			'post_type'     => 'post',
			'taxonomy'      => '',
			'terms'         => '',
			'order'         => 'DESC',
			'columns'       => '3',
			'img_size'      => 'wpex_custom',
			'img_hover'     => '',
			'img_width'     => '',
			'img_height'    => '',
		) );

		// Sanitize vars
		$title      = esc_attr( $instance['title'] );
		$number     = esc_attr( $instance['number'] );
		$post_type  = esc_attr( $instance['post_type'] );
		$taxonomy   = esc_attr( $instance['taxonomy'] );
		$terms      = esc_attr( $instance['terms'] );
		$order      = esc_attr( $instance['order'] );
		$columns    = esc_attr( $instance['columns'] );
		$img_hover  = esc_attr( $instance['img_hover'] );
		$img_size   = esc_attr( $instance['img_size'] );
		$img_width  = esc_attr( $instance['img_width'] );
		$img_height = esc_attr( $instance['img_height'] ); ?>

		<?php /* Title */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php /* Post Type */ ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type', 'wpex' ); ?></label>
		<br />
		<select class='wpex-select' name="<?php echo $this->get_field_name( 'post_type' ); ?>" style="width:100%;">
			<option value="post" <?php if ( $post_type == 'post' ) { ?>selected="selected"<?php } ?>><?php _e( 'Post', 'wpex' ); ?></option>
			<?php
			// Get Post Types
			$args = array(
				'public'                => true,
				'_builtin'              => false,
				'exclude_from_search'   => false
			);
			$output = 'names';
			$operator = 'and';
			$get_post_types = get_post_types( $args, $output, $operator );
			if ( ! isset( $get_post_types['portfolio'] ) && WPEX_PORTFOLIO_IS_ACTIVE ) {
				$obj = get_post_type_object( 'portfolio' );
				$get_post_types['portfolio'] = $obj->labels->name;
			}
			if ( ! isset( $get_post_types['staff'] ) && WPEX_STAFF_IS_ACTIVE ) {
				$obj = get_post_type_object( 'staff' );
				$get_post_types['staff'] = $obj->labels->name;
			}
			if ( ! isset( $get_post_types['testimonials'] ) && WPEX_TESTIMONIALS_IS_ACTIVE ) {
				$obj = get_post_type_object( 'testimonials' );
				$get_post_types['testimonials'] = $obj->labels->name;
			}
			foreach ( $get_post_types as $get_post_type ) : ?>
				<?php if ( $get_post_type != 'post' ) { ?>
					<option value="<?php echo $get_post_type; ?>" <?php if ( $post_type == $get_post_type ) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $get_post_type ); ?></option>
				<?php } ?>
			<?php endforeach; ?>
		</select>
		</p>

		<?php /* Taxonomy */ ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Query By Taxonomy', 'wpex' ); ?></label>
		<br />
		<select class='wpex-select' name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" style="width:100%;">
			<option value="post" <?php if ( ! $taxonomy ) { ?>selected="selected"<?php } ?>><?php _e( 'No', 'wpex' ); ?></option>
			<?php
			// Get Taxonomies
			$get_taxonomies = get_taxonomies( array(
				'public' => true,
			), 'objects' ); ?>
			<?php foreach ( $get_taxonomies as $get_taxonomy ) : ?>
				<option value="<?php echo $get_taxonomy->name; ?>" <?php if ( $get_taxonomy->name == $taxonomy ) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $get_taxonomy->labels->singular_name ); ?></option>
			<?php endforeach; ?>
		</select>
		</p>

		<?php /* Terms */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'terms' ); ?>"><?php _e( 'Terms', 'wpex' ); ?></label>
			<br />
			<input class="widefat" name="<?php echo $this->get_field_name( 'terms' ); ?>" type="text" value="<?php echo $terms; ?>" />
			<small><?php _e( 'Enter the term slugs to query by seperated by a "comma"', 'wpex' ); ?></small>
		</p>

		<?php /* Order */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name( 'order' ); ?>" style="width:100%;">
				<option value="DESC" <?php if ( $order == 'DESC' ) { ?>selected="selected"<?php } ?>><?php _e( 'Recent', 'wpex' ); ?></option>
				<option value="rand" <?php if ( $order == 'rand' ) { ?>selected="selected"<?php } ?>><?php _e( 'Random', 'wpex' ); ?></option>
				<option value="comment_count" <?php if ( $order == 'comment_count' ) { ?>selected="selected"<?php } ?>><?php _e( 'Most Comments', 'wpex' ); ?></option>
				<option value="modified" <?php if ( $order == 'modified' ) { ?>selected="selected"<?php } ?>><?php _e( 'Last Modified', 'wpex' ); ?></option>
			</select>
		</p>

		<?php /* Number */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
		</p>

		<?php /* Columns */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Columns', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name( 'columns' ); ?>">
				<option value="1" <?php if ( $columns == 1 ) { ?>selected="selected"<?php } ?>>1</option>
				<option value="2" <?php if ( $columns == 2 ) { ?>selected="selected"<?php } ?>>2</option>
				<option value="3" <?php if ( $columns == 3 ) { ?>selected="selected"<?php } ?>>3</option>
				<option value="4" <?php if ( $columns == 4 ) { ?>selected="selected"<?php } ?>>4</option>
				<option value="5" <?php if ( $columns == 5 ) { ?>selected="selected"<?php } ?>>5</option>
				<option value="6" <?php if ( $columns == 6 ) { ?>selected="selected"<?php } ?>>6</option>
			</select>
		</p>

		<?php /* Image Hover Animation */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_hover' ); ?>"><?php _e( 'Image Hover', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name( 'img_hover' ); ?>" style="width:100%;">
				<?php
				// Get image sizes
				$hovers = wpex_image_hovers();
				// Loop through hovers and add options
				foreach ( $hovers as $key => $val ) { ?>
					<option value="<?php echo $key; ?>" <?php if ( $img_hover == $key ) { ?>selected="selected"<?php } ?>><?php echo $val; ?></option>
				<?php } ?>
				
			</select>
		</p>

		<?php /* Image Size */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_size' ); ?>"><?php _e( 'Image Size', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name( 'img_size' ); ?>" style="width:100%;">
			<option value="wpex_custom" <?php if ( $img_size == 'wpex_custom' ) { ?>selected="selected"<?php } ?>><?php _e( 'Custom', 'wpex' ); ?></option>
				<?php
				// Get image sizes
				$get_img_sizes = wpex_get_thumbnail_sizes(); ?>

				<?php foreach ( $get_img_sizes as $key => $val ) { ?>
					<option value="<?php echo $key; ?>" <?php if ( $img_size == $key ) { ?>selected="selected"<?php } ?>><?php echo $key; ?></option>
				<?php } ?>
				
			</select>
		</p>

		<?php /* Image Width */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_width' ); ?>"><?php _e( 'Image Crop Width', 'wpex' ); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name( 'img_width' ); ?>" type="text" value="<?php echo $img_width; ?>" />
		</p>

		<?php /* Image Height */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_height' ); ?>"><?php _e( 'Image Crop Height', 'wpex' ); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name( 'img_height' ); ?>" type="text" value="<?php echo $img_height; ?>" />
		</p>
		
	<?php
	}
}

// Register the widget
function register_wpex_recent_posts_thumb_grid() {
	register_widget( 'Wpex_Recent_Posts_Thumb_Grid' );
}
add_action( 'widgets_init', 'register_wpex_recent_posts_thumb_grid' ); ?>