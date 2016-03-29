<?php
/**
 * Recent Recent Comments With Avatars Widget
 *
 * @package Total WordPress Theme
 * @subpackage Widgets
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
if ( ! class_exists( 'WPEX_Recent_Comments_Widget' ) ) {
	class WPEX_Recent_Comments_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'wpex_recent_comments_avatars_widget',
				$name = WPEX_THEME_BRANDING . ' - '. __( 'Comments With Avatars', 'wpex' )
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

			// Define variables for widget usage
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$title  = apply_filters( 'widget_title', $title );
			$number = isset( $instance['number'] ) ? $instance['number'] : '3';

			// Before widget WP Hook
			echo $args['before_widget'];

			// Display the title
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			} ?>

			<ul class="wpex-recent-comments-widget clr">

				<?php
				// Query Comments
				$comments = get_comments( array (
					'number'        => $number,
					'status'        => 'approve',
					'post_status'   => 'publish',
					'type'          => 'comment',
				) );
				if ( $comments ) : ?>

					<?php
					// Loop through comments
					foreach ( $comments as $comment ) :

						// Get comment ID
						$comment_id     = $comment->comment_ID;
						$comment_link   = get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment_id;

						// Title alt
						$title_alt = __( 'Read Comment', 'wpex' ); ?>

						<li class="clr">
							<a href="<?php echo $comment_link; ?>" title="<?php echo esc_attr( $title_alt ); ?>" class="avatar"><?php echo get_avatar( $comment->comment_author_email, '50' ); ?></a>
							<strong><?php echo get_comment_author( $comment_id ); ?>:</strong> <?php echo wp_trim_words( $comment->comment_content, '10', '&hellip;' ); ?>
							<br />
							<a href="<?php echo $comment_link; ?>" title="<?php echo esc_attr( $title_alt ); ?>" class="view-comment"><?php _e( 'view comment', 'wpex' ); ?> &rarr;</a>
						</li>

					<?php endforeach; ?>

				<?php
				// Display no comments notice
				else : ?>

					<li><?php _e( 'No comments yet.', 'wpex' ); ?></li>

				<?php endif; ?>

			</ul>

			<?php echo $args['after_widget'];
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
			$instance['title']  = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ! empty( $new_instance['number'] ) ? strip_tags( $new_instance['number'] ) : '';
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

			$instance = wp_parse_args( ( array ) $instance, array(
				'title'     => __( 'Recent Comments', 'wpex' ),
				'number'    => '3',

			) );

			// Esc attributes
			$title  = esc_attr( $instance['title'] );
			$number = esc_attr( $instance['number'] ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpex' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title', 'wpex' ); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number to Show:', 'wpex' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
			</p>

			<?php
		}
	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'register_wpex_recent_comments_widget' ) ) {
	function register_wpex_recent_comments_widget() {
		register_widget( 'WPEX_Recent_Comments_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_recent_comments_widget' );