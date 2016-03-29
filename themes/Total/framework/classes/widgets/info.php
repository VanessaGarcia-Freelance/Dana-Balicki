<?php
/**
 * Business Info Widget
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
class WPEX_Info_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'wpex_info_widget',
			WPEX_THEME_BRANDING . ' - '. __( 'Business Info', 'wpex' )
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
		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		$title        = apply_filters( 'widget_title', $title );
		$address      = isset( $instance['address'] ) ? $instance['address'] : '';
		$phone_number = isset( $instance['phone_number'] ) ? $instance['phone_number'] : '';
		$fax_number   = isset( $instance['fax_number'] ) ? $instance['fax_number'] : '';
		$email        = isset( $instance['email'] ) ? $instance['email'] : '';

		// Before widget WP hook
		echo $args['before_widget'];

		// Display title if defined
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; 
		} ?>

		<div class="wpex-info-widget wpex-clr">

			<?php if ( $address ) : ?>

				<div class="wpex-info-widget-address wpex-clr">
					<span class="fa fa-map-marker"></span>
					<?php echo wpautop( $address ); ?>
				</div><!-- .wpex-info-widget-address -->

			<?php endif; ?>

			<?php if ( $phone_number ) : ?>

				<div class="wpex-info-widget-phone wpex-clr">
					<span class="fa fa-phone"></span>
					<?php echo $phone_number; ?>
				</div><!-- .wpex-info-widget-address -->

			<?php endif; ?>

			<?php if ( $fax_number ) : ?>

				<div class="wpex-info-widget-fax wpex-clr">
					<span class="fa fa-fax"></span>
					<?php echo $fax_number; ?>
				</div><!-- .wpex-info-widget-address -->

			<?php endif; ?>

			<?php if ( $email ) : ?>

				<div class="wpex-info-widget-email wpex-clr">
					<span class="fa fa-envelope"></span>
					<?php if ( is_email( $email ) ) : ?>
						<a href="mailto:<?php echo $email; ?>" title="<?php _e( 'Email Us', 'wpex' ); ?>"><?php echo $email; ?></a>
					<?php else : ?>
						<?php echo $email; ?>
					<?php endif; ?>
				</div><!-- .wpex-info-widget-address -->

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
		$instance                 = $old_instance;
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['address']      = ( ! empty( $new_instance['address'] ) ) ? $new_instance['address'] : '';
		$instance['phone_number'] = ( ! empty( $new_instance['phone_number'] ) ) ? $new_instance['phone_number'] : '';
		$instance['fax_number']   = ( ! empty( $new_instance['fax_number'] ) ) ? $new_instance['fax_number'] : '';
		$instance['email']        = ( ! empty( $new_instance['email'] ) ) ? $new_instance['email'] : '';
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
			'title'        => __( 'Business Info', 'wpex' ),
			'address'      => '',
			'phone_number' => '',
			'fax_number'   => '',
			'email'        => '',
		) );

		// Extract
		extract( $instance );

		// Sanitize vars
		$title        = esc_attr( $title );
		$address      = esc_attr( $address );
		$phone_number = esc_attr( $phone_number );
		$fax_number   = esc_attr( $fax_number );
		$email        = esc_attr( $email ); ?>

		<?php /* Title */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php /* Address */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>">
			<?php _e( 'Address', 'wpex' ); ?></label>
			<textarea rows="5" class="widefat" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text"><?php echo stripslashes( $instance['address'] ); ?></textarea>
		</p>

		<?php /* Phone Number */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone_number' ); ?>"><?php _e( 'Phone Number', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'phone_number' ); ?>" type="text" value="<?php echo $phone_number; ?>" />
		</p>

		<?php /* Fax Number */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'fax_number' ); ?>"><?php _e( 'Fax Number', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'fax_number' ); ?>" type="text" value="<?php echo $fax_number; ?>" />
		</p>

		<?php /* Email */ ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', 'wpex' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $email; ?>" />
		</p>

		
	<?php
	}
}

// Register the widget
function wpex_register_info_widget() {
	register_widget( 'WPEX_Info_Widget' );
}
add_action( 'widgets_init', 'wpex_register_info_widget' );