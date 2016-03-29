<?php
/**
 * Google Map
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package Total WordPress Theme
 * @subpackage Widgets
 *
 * @since 3.1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class WPEX_Google_Map extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'wpex_gmap_widget',
			WPEX_THEME_BRANDING . ' - '. __( 'Google Map', 'wpex' )
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
		$title       = isset( $instance['title'] ) ? $instance['title'] : '';
		$title       = apply_filters( 'widget_title', $title );
		$description = isset( $instance['description'] ) ? $instance['description'] : '';
		$embed_code  = isset( $instance['embed_code'] ) ? $instance['embed_code'] : '';
		$height      = isset( $instance['height'] ) ? intval( $instance['height'] ) : '';

		// Before widget WP hook
		echo $args['before_widget'];

		// Display title if defined
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; 
		} ?>

		<div class="wpex-gmap-widget wpex-clr">

			<?php if ( $description ) : ?>

				<div class="wpex-gmap-widget-description wpex-clr">
					<?php echo wpautop( $description ); ?>
				</div><!-- .wpex-gmap-widget-description -->

			<?php endif; ?>

			<?php if ( $embed_code ) :

				// Parse size
				if ( is_numeric( $height ) ) {
					$embed_code = preg_replace( '/height="[0-9]*"/', 'height="' . $height . '"', $embed_code );
				} ?>

				<div class="wpex-gmap-widget-embed wpex-clr">
					<?php echo $embed_code; ?>
				</div><!-- .wpex-gmap-widget-embed -->

			<?php endif; ?>

		</div><!-- .wpex-info-widget -->

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
		$instance                = $old_instance;
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';
		$instance['embed_code']  = ( ! empty( $new_instance['embed_code'] ) ) ? $new_instance['embed_code'] : '';
		$instance['height']      = ( ! empty( $new_instance['height'] ) ) ? intval( $new_instance['height'] ) : '';
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
			'title'        => __( 'Google Map', 'wpex' ),
			'description'  => '',
			'embed_code'   => '',
			'height'       => '',
		) );

		// Extract
		extract( $instance );

		// Sanitize vars
		$title       = esc_attr( $title );
		$description = esc_attr( $description );
		$embed_code  = esc_attr( $embed_code );
		$height      = esc_attr( $height ); ?>

		<?php /* Title */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php /* Description */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>">
			<?php _e( 'Description', 'wpex' ); ?></label>
			<textarea rows="5" class="widefat" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text"><?php echo stripslashes( $instance['description'] ); ?></textarea>
		</p>

		<?php /* Embed code */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'embed_code' ); ?>">
			<?php _e( 'Embed Code', 'wpex' ); ?></label>
			<textarea rows="5" class="widefat" name="<?php echo $this->get_field_name( 'embed_code' ); ?>" type="text"><?php echo stripslashes( $instance['embed_code'] ); ?></textarea>
		</p>

		<?php /* Height */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $height; ?>" />
		</p>

		
	<?php
	}
}

// Register the widget
function wpex_register_google_map_widget() {
	register_widget( 'WPEX_Google_Map' );
}
add_action( 'widgets_init', 'wpex_register_google_map_widget' );