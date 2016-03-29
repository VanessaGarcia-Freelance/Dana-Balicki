<?php
/**
 * Class Displays a notice on the front-end
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Update_Front_End_Notice' ) ) {
	class WPEX_Update_Front_End_Notice {
		private $args;
		private $logged_in_admin = false;

		/**
		 * Main constructor
		 *
		 * @since 3.0.0
		 */
		public function __construct( $args ) {
			$this->args = $args;
			add_action( 'wp_head', array( $this, 'display_notice' ), 0 );

			// Check if admin is logged in
			if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
				$this->logged_in_admin = true;
			}

		}

		/**
		 * Display notice
		 *
		 * @since 3.0.0
		 */
		public function display_notice() { ?>

			<link rel='stylesheet' id='wpex-font-awesome-css' href='<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css?ver=4.3.0' type='text/css' media='all' />
			
			<?php if ( $this->logged_in_admin ) { ?>
				<link rel='stylesheet' id='wpex-font-awesome-css' href='<?php echo get_template_directory_uri(); ?>/style.css' type='text/css' media='all' />
			<?php } ?>

			<?php echo $this->head_css(); ?>

			</head>

			<div id="wpex-front-end-update-notice" class="clr">

				<?php
				// Title
				if ( $this->logged_in_admin ) { ?>

					<?php if ( isset( $this->args['title'] ) ) { ?>
						<h1><?php echo $this->args['title']; ?></h1>
					<?php } ?>

				<?php } else {

					$title = '<span class="fa fa-wrench"></span>'. __( 'Briefly Unavailable for Maintenance', 'wpex' );
					$title = apply_filters( 'wpex_maintanance_title', $title ); ?>

					<h1 class="wpex-maintenance-title"><?php echo $title; ?></h1>

				<?php } ?>

				<?php
				// Content
				if ( isset( $this->args['content'] ) ) { ?>

					<div id="wpex-front-end-update-notice-content" class="clr">

						<?php if ( 'vc_notice' == $this->args['content'] ) {
							echo $this->vc_notice();
						} else {
							echo $this->args['content'];
						} ?>

					</div>

				<?php } ?>

			</div>

			</body>
			</html>

			<?php exit(); // Don't do anything else ?>

		<?php }

		/**
		 * Display vc notice
		 *
		 * @since 3.0.0
		 */
		public function vc_notice() {
			$update_url = add_query_arg(
				array(
					'page' => 'install-required-plugins',
					'plugin_status' => 'update',
				),
				admin_url( 'themes.php' )
			);
			if ( $this->logged_in_admin ) {
				return '<p>Congrats on updating your Total theme to the latest version! You are currently using version <span class="version red">'. WPB_VC_VERSION .'</span> of the <a href="http://wpexplorer-themes.com/total/docs/updating-visual-composer/" target="_blank" title="How To Update Visual Composer">Visual Composer</a> plugin but the theme requires at least version <span class="version green">'. WPEX_VC_SUPPORTED_VERSION .'</span>. This notice is to prevent front-end issues such as a "white screen of death". Your standard visitors and non-admins will see a different notice (don\'t worry). Once <a href="http://wpexplorer-themes.com/total/docs/updating-visual-composer/" title="How To Update The Visual Composer" target="_blank">updated</a> you can use your site as normal. If you get any error when trying to update, de-activate the Visual Composer plugin and then try updating. If you still have issues you can submit a ticket so we can assist you.</p><p>Go to <strong style="color:#000;text-decoration:underline;">Appearance > Install Plugins</strong> to update.</p><p>~ WPExplorer ~</p>';
			} else {
				$notice = '<p>'. __( 'This website is currently unavailable but should be back in a few moments.</p>', 'wpex' );
				return apply_filters( 'wpex_maintanance_notice', $notice );
			}
		}

		/**
		 * Add inline CSS (don't need to return any of the custom styles though)
		 *
		 * @since 3.0.0
		 */
		public function head_css() {
			return '<style>
						html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;font:inherit;vertical-align:baseline;font-family:inherit;font-size:100%;font-style:inherit;font-weight:inherit;}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}html{font-size:62.5%;overflow-y:scroll;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}*,*:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}body{background:#fff;line-height:1;}article,aside,details,figcaption,figure,footer,header,main,nav,section{display:block}ol,ul{list-style:none}table{border-collapse:collapse;border-spacing:0;}caption,th,td{font-weight:normal;text-align:left;}blockquote:before,blockquote:after,q:before,q:after{content:"";content:none;}blockquote,q{quotes:none}a:focus{outline:none}a:hover,a:active{outline:0}a img{border:0}img{max-width:100%;height:auto;}select{max-width:100%}

						body {
							font-family: "Helvetica Neue", Arial, sans-serif;
							line-height: 1.7;
							background: #f1f1f1;
							font-size: 16px;
							color: #666;
						}
						a {
							text-decoration: underline;
							color: #00a0d2;
							outline: 0;
							border: 0;
						}
						a:hover {
							opacity: 0.7;
						}
						.clr:after {
							content: "";
							display: block;
							height: 0;
							clear: both;
							visibility: hidden;
							zoom: 1;
						}
						#wpex-front-end-update-notice {
							background: #fff;
							padding: 60px;
							margin: 100px auto;
							width: 660px;
							max-width: 80%;
							text-align: center;
							box-shadow: 0 2px 6px rgba(0,0,0,0.1);
						}
						#wpex-front-end-update-notice h1 {
							font-size: 34px;
							margin: 0 0 30px;
							padding: 0;
							background: none;
							border: none;
							color: #000;
							font-weight: bold;
						}
						#wpex-front-end-update-notice h1 .fa {
							margin-right: 10px;
						}
						#wpex-front-end-update-notice h1.wpex-maintenance-title {
							font-size: 21px;
							margin: 0 0 25px;
						}
						#wpex-front-end-update-notice p {
							margin-bottom: 30px;
						}
						#wpex-front-end-update-notice p:last-child {
							margin-bottom: 0;
						}
						#wpex-front-end-update-notice span.version {
							color: #000;
							font-weight: bold;
							display: inline-block;
							background: #eee;
							border-radius: 3px;
							padding: 0 8px;
							font-size: 14px;
						}
						#wpex-front-end-update-notice span.version.red {
							color: #F64744;
						}
						#wpex-front-end-update-notice span.version.green {
							color: #23CF5F;
						}

					</style>';
			}

	}
}