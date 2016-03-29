<?php
/**
 * Flickr Widget
 *
 * @package Total WordPress Theme
 * @subpackage Widgets
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
if ( ! class_exists( 'WPEX_Flickr_Widget' ) ) {
	class WPEX_Flickr_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_flickr',
				$name = WPEX_THEME_BRANDING . ' - '. __( 'Flickr Stream', 'wpex' )
			);

		}
	
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		function widget( $args, $instance ) {

			// Extract widget arguments
			extract( $args );

			// Set variables for widget usage
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$title  = apply_filters( 'widget_title', $title );
			$number = isset( $instance['number'] ) ? $instance['number'] : '';
			$id     = isset( $instance['id'] ) ? $instance['id'] : '';

			// Before widget WP hook
			echo $before_widget;

			// Display the title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			} ?>

			<?php
			// Display flickr feed if ID is defined
			if ( $id ) : ?>
				<div class="wpex-flickr-widget">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
				</div>
			<?php endif; ?>

			<?php
			// After widget WP hook
			echo $after_widget;
		}
	
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 * @since 1.0.0
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		function update( $new_instance, $old_instance ) {
			$instance           = $old_instance;
			$instance['title']  = strip_tags( $new_instance['title'] );
			$instance['number'] = intval( strip_tags( $new_instance['number'] ) );
			$instance['id']     = strip_tags( $new_instance['id'] );
			return $instance;
		}
		
		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 * @since 1.0.0
		 *
		 * @param array $instance Previously saved values from database.
		 */
		function form( $instance ) {

			// combine provided fields with defaults
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'     =>'Flickr Feed',
				'id'        => '',
				'number'    => 8,
			) );
			$id     = strip_tags( $instance['id'] );
			$number = strip_tags( $instance['number'] );
			$title  = strip_tags( $instance['title'] ); ?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpex' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo
				esc_attr($title); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'id' ); ?>">
				<?php _e( 'Flickr ID ', 'wpex' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" type="text" value="<?php echo
				esc_attr($id); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php _e( 'Number:', 'wpex' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo
				esc_attr($number); ?>" />
			</p>

		<?php
		}

	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'register_wpex_flickr_widget' ) ) {
	function register_wpex_flickr_widget() {
		register_widget( 'WPEX_Flickr_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_flickr_widget' );