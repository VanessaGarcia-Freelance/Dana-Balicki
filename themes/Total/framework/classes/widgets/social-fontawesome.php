<?php
/**
 * Font Awesome social widget
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
if ( ! class_exists( 'WPEX_Fontawesome_Social_Widget' ) ) {
	class WPEX_Fontawesome_Social_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'wpex_fontawesome_social_widget',
				WPEX_THEME_BRANDING . ' - '. __( 'Font Awesome Social Widget', 'wpex' )
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Get social services and 
			$social_services = isset( $instance['social_services'] ) ? $instance['social_services'] : '';

			// Return if no services defined
			if ( ! $social_services ) {
				return;
			}

			// Define vars
			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$title = apply_filters( 'widget_title', $title );
			$description = isset( $instance['description'] ) ? $instance['description'] : '';
			$style = isset( $instance['style'] ) ? $instance['style'] : '';
			$type = isset( $instance['type'] ) ? $instance['type'] : '';
			$target = isset( $instance['target'] ) ? $instance['target'] : '';
			$size = isset( $instance['size'] ) ? intval( $instance['size'] ) : '';
			$font_size = isset( $instance['font_size'] ) ? $instance['font_size'] : '';
			$border_radius = isset( $instance['border_radius'] ) ? $instance['border_radius'] : '';

			// Parse style
			$style = $this->parse_style( $style, $type );

			// Sanitize vars
			$size = $size ? wpex_sanitize_data( $size, 'px' ) : '';
			$font_size = $font_size ? wpex_sanitize_data( $font_size, 'font_size' ) : '';
			$border_radius = $border_radius ? wpex_sanitize_data( $border_radius, 'border_radius' ) : '';
			$target = 'blank' == $target ? ' target="_blank"' : ''; ?>

			<?php
			// Before widget hook
			echo $before_widget; ?>

			<?php
			// Display title
			if ( $title ) {

				echo $before_title . $title . $after_title;

			} ?>

			<div class="wpex-fa-social-widget clr">

				<?php
				// Inline style
				$add_style = '';
				if ( '30' != $size && $size ) {
					$add_style .= 'height:'. $size .';width:'. $size .';line-height:'. $size .';';
				}
				if ( $font_size ) {
					$add_style .= 'font-size:'. $font_size .';';
				}
				if ( $border_radius ) {
					$add_style .= 'border-radius:'. $border_radius .';';
				}
				if ( $add_style ) {
					$add_style = ' style="' . esc_attr( $add_style ) . '"';
				} ?>

				<?php
				// Description
				if ( $description ) : ?>

					<div class="desc clr">
						<?php echo $description; ?>
					</div><!-- .desc -->

				<?php endif; ?>

				<ul>

					<?php
					// Loop through each social service and display font icon
					foreach( $social_services as $key => $service ) {
						$link = ! empty( $service['url'] ) ? esc_url( $service['url'] ) : null;
						$name = $service['name'];
						if ( $link ) {
							$key = 'vimeo-square' == $key ? 'vimeo' : $key;
							$icon = 'youtube' == $key ? 'youtube-play' : $key;
							$icon = 'vimeo-square' == $key ? 'vimeo' : $icon;
							echo '<li>
									<a href="'. $link .'" title="'. esc_attr( $name ) .'" class="wpex-'. $key .' '. wpex_get_social_button_class( $style ) .'"'. $add_style . $target .'><span class="fa fa-'. $icon .'"></span>
									</a>
								</li>';
						}
					} ?>

				</ul>

			</div><!-- .fontawesome-social-widget -->

			<?php echo $after_widget; ?>

		<?php
		}

		/**
		 * Parses style attribute for fallback styles
		 *
		 * @since 3.0.0
		 */
		public function parse_style( $style = '', $type = '' ) {
			if ( 'color' == $style && 'flat' == $type ) {
				return 'flat-color';
			}
			if ( 'color' == $style && 'graphical' == $type ) {
				return 'graphical-rounded';
			}
			if ( 'black' == $style && 'flat' == $type ) {
				return 'black-rounded';
			}
			if ( 'black' == $style && 'graphical' == $type ) {
				return 'black-rounded';
			}
			if ( 'black-color-hover' == $style && 'flat' == $type ) {
				return 'black-ch-rounded';
			}
			if ( 'black-color-hover' == $style && 'graphical' == $type ) {
				return 'black-ch-rounded';
			}
			return $style;
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
		public function update( $new, $old ) {

			// Sanitize data
			$instance = $old;
			$instance['title'] = ! empty( $new['title'] ) ? strip_tags( $new['title'] ) : null;
			$instance['description'] = ! empty( $new['description'] ) ? $new['description'] : null;
			$instance['style'] = ! empty( $new['style'] ) ? strip_tags( $new['style'] ) : 'flat-color';
			$instance['target'] = ! empty( $new['target'] ) ? strip_tags( $new['target'] ) : 'blank';
			$instance['size'] = ! empty( $new['size'] ) ? strip_tags( $new['size'] ) : '30px';
			$instance['border_radius'] = ! empty( $new['border_radius'] ) ? strip_tags( $new['border_radius'] ) : '';
			$instance['font_size'] = ! empty( $new['font_size'] ) ? strip_tags( $new['font_size'] ) : '';
			$instance['social_services'] = $new['social_services'];

			// Remove deprecated param
			$instance['type'] = null;

			// Return instance
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
		public function form( $instance ) {

			$social_services_array = array(
				'twitter' => array(
					'name' => 'Twitter',
					'url' => ''
				),
				'facebook' => array(
					'name' => 'Facebook',
					'url' => ''
				),
				'instagram' => array(
					'name' => 'Instagram',
					'url' => ''
				),
				'google-plus' => array(
					'name' => 'GooglePlus',
					'url' => ''
				),
				'linkedin' => array(
					'name' => 'LinkedIn',
					'url' => ''
				),
				'pinterest' => array(
					'name' => 'Pinterest',
					'url' => ''
				),
				'yelp' => array(
					'name' => 'Yelp',
					'url' => ''
				),
				'dribbble' => array(
					'name' => 'Dribbble',
					'url' => ''
				),
				'flickr' => array(
					'name' => 'Flickr',
					'url' => ''
				),
				'vk' => array(
					'name' => 'VK',
					'url' => ''
				),
				'github' => array(
					'name' => 'GitHub',
					'url' => ''
				),
				'tumblr' => array(
					'name' => 'Tumblr',
					'url' => ''
				),
				'skype' => array(
					'name' => 'Skype',
					'url' => ''
				),
				'trello' => array(
					'name' => 'Trello',
					'url' => ''
				),
				'foursquare' => array(
					'name' => 'Foursquare',
					'url' => ''
				),
				'renren' => array(
					'name' => 'RenRen',
					'url' => ''
				),
				'xing' => array(
					'name' => 'Xing',
					'url' => ''
				),
				'vimeo-square' => array(
					'name' => 'Vimeo',
					'url' => ''
				),
				'vine' => array(
					'name' => 'Vine',
					'url' => ''
				),
				'youtube' => array(
					'name' => 'Youtube',
					'url' => ''
				),
				'rss' => array(
					'name' => 'RSS',
					'url' => ''
				),
			);
			$social_services_array = apply_filters( 'wpex_social_widget_profiles', $social_services_array );

			$instance = wp_parse_args( ( array ) $instance, array(
				'title' => __( 'Follow Us', 'wpex' ),
				'description' => '',
				'style' => 'flat-color',
				'font_size' => '',
				'border_radius' => '',
				'target' => 'blank',
				'size' => '30px',
				'social_services' => $social_services_array
			) );

			$title = esc_attr( $instance['title'] );
			$number = esc_attr( $instance['description'] );
			$type = isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
			$style = esc_attr( $instance['style'] );
			$font_size = esc_attr( $instance['font_size'] );
			$border_radius = esc_attr( $instance['border_radius'] );
			$target = esc_attr( $instance['target'] );
			$size = esc_attr( $instance['size'] ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'wpex' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e( 'Description:','wpex' ); ?></label> 
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e( 'Description:', 'wpex' ); ?></label> 
				<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo $instance['description']; ?></textarea>
			</p>

			<?php
			// Styles
			$social_styles = wpex_social_button_styles();

			// Parse style
			$style = $this->parse_style( $style, $type ); ?>

			<p>
				<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e( 'Style', 'wpex'); ?></label>
				<br />
				<select class='wpex-widget-select' name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
					<?php foreach ( $social_styles as $key => $val ) { ?>
						<option value="<?php echo $key; ?>" <?php selected( $style, $key ); ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Link Target:', 'wpex' ); ?></label>
				<br />
				<select class='wpex-widget-select' name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
					<option value="blank" <?php if ($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'wpex' ); ?></option>
					<option value="self" <?php if ($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'wpex' ); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Icon Size', 'wpex' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $instance['size']; ?>" />
				<small><?php _e( 'Enter a size to be used for the height/width for the icon.', 'wpex'); ?></small>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('font_size'); ?>"><?php _e( 'Icon Font Size', 'wpex' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('font_size'); ?>" name="<?php echo $this->get_field_name('font_size'); ?>" type="text" value="<?php echo $instance['font_size']; ?>" />
				<small><?php _e( 'Enter a custom font size for the icons.', 'wpex'); ?></small>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('border_radius'); ?>"><?php _e( 'Border Radius', 'wpex' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'border_radius' ); ?>" name="<?php echo $this->get_field_name('border_radius'); ?>" type="text" value="<?php echo $instance['border_radius']; ?>" />
				<small><?php _e( 'Enter a custom border radius. For circular icons enter a number equal or greater to the Icon Size field above.', 'wpex'); ?></small>
			</p>

			<?php
			$field_id_services = $this->get_field_id( 'social_services' );
			$field_name_services = $this->get_field_name( 'social_services' ); ?>
			<h3 style="margin-top:20px;margin-bottom:0;"><?php _e( 'Social Links','wpex' ); ?></h3> 
			<small style="display:block;margin-bottom:10px;"><?php _e( 'Enter the full URL to your social profile.', 'wpex' ); ?> <?php _e( 'Drag and drop to re-order items.', 'wpex' ); ?></small>
			<ul id="<?php echo $field_id_services; ?>" class="wpex-services-list">
				<input type="hidden" id="<?php echo $field_name_services; ?>" value="<?php echo $field_name_services; ?>">
				<input type="hidden" id="<?php echo wp_create_nonce( 'wpex_fontawesome_social_widget_nonce' ); ?>">
				<?php
				$display_services = isset ( $instance['social_services'] ) ? $instance['social_services']: '';
				if ( ! empty( $display_services ) ) {
					foreach( $display_services as $key => $service ) {
						$url = isset( $service['url'] ) ? $service['url'] : 0;
						$name = isset( $service['name'] ) ? $service['name'] : ''; ?>
						<li id="<?php echo $field_id_services; ?>_0<?php echo $key ?>">
							<p>
								<label for="<?php echo $field_id_services; ?>-<?php echo $key ?>-name"><?php echo $name; ?>:</label>
								<input type="hidden" id="<?php echo $field_id_services; ?>-<?php echo $key ?>-url" name="<?php echo $field_name_services .'['.$key.'][name]'; ?>" value="<?php echo $name; ?>">
								<input type="url" class="widefat" id="<?php echo $field_id_services; ?>-<?php echo $key ?>-url" name="<?php echo $field_name_services .'['.$key.'][url]'; ?>" value="<?php echo $url; ?>" />
							</p>
						</li>
					<?php }
				} ?>
			</ul>
			
		<?php
		}

	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'register_wpex_fontawesome_social_widget' ) ) {
	function register_wpex_fontawesome_social_widget() {
		register_widget( 'WPEX_Fontawesome_Social_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_fontawesome_social_widget' );

// Widget Styles
if ( ! function_exists( 'wpex_social_widget_style' ) ) {
	function wpex_social_widget_style() { ?>
		<style> 
		.wpex-services-list li {
			cursor: move;
			background: #fafafa;
			padding: 10px;
			border: 1px solid #e5e5e5;
			margin-bottom: 10px;
		}
		.wpex-services-list li p {
			margin: 0;
		}
		.wpex-services-list li label {
			margin-bottom: 3px;
			display: block;
			color: #222;
		}
		.wpex-services-list .placeholder {
			border: 1px dashed #e3e3e3;
		}
		</style>
	<?php
	}
}


// Widget AJAX functions
function wpex_fontawesome_social_widget_scripts() {
	global $pagenow;
	if ( is_admin() && $pagenow == "widgets.php" ) {
		add_action('admin_head', 'wpex_social_widget_style');
		add_action('admin_footer', 'add_new_wpex_fontawesome_social_ajax_trigger');
		function add_new_wpex_fontawesome_social_ajax_trigger() { ?>
			<script type="text/javascript" >
				jQuery(document).ready(function($) {
					jQuery(document).ajaxSuccess(function(e, xhr, settings) {
						var widget_id_base = 'wpex_fontawesome_social_widget';
						if (settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + widget_id_base) != -1) {
							wpexSortServices();
						}
					});
					function wpexSortServices() {
						jQuery('.wpex-services-list').each( function() {
							var id = jQuery(this).attr('id');
							$('#'+ id).sortable({
								placeholder: "placeholder",
								opacity: 0.6
							});
						});
					}
					wpexSortServices();
				});
			</script>
		<?php
		}
	}
}
add_action('admin_init','wpex_fontawesome_social_widget_scripts');