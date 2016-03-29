<?php
/**
 * Displays changelog in the admin
 *
 * @package Total WordPress theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
class WPEX_Theme_Changelog {
	private $transient;
	private $vc_changelog;

	/**
	 * Start things up
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// Add changelog admin panel
		add_action( 'admin_menu', array( $this, 'add_page' ), 100 );

		// Custom styles for changelog
		add_action( 'admin_print_styles-'. WPEX_ADMIN_PANEL_HOOK_PREFIX . '-changelog', array( $this,'css' ), 40 );

		// Delete transient
		if ( isset( $_GET['wpex_refresh_changelog'] ) ) {
			delete_transient( 'wpex_theme_changelog' );
		}

		// Get transient
		else {
			$this->transient = get_transient( 'wpex_theme_changelog' );
		}

	}

	/**
	 * Add sub menu page
	 *
	 * @since 2.0.0
	 */
	public function add_page() {
		add_submenu_page(
			WPEX_THEME_PANEL_SLUG,
			__( 'Changelog', 'wpex' ),
			__( 'Changelog', 'wpex' ),
			'administrator',
			WPEX_THEME_PANEL_SLUG .'-changelog',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Display admin page
	 *
	 * @since 2.0.0
	 */
	public function create_admin_page() { ?>

		<div class="wrap">

			<h1><?php _e( 'Theme Changelog', 'wpex' ); ?></h1>
			<p>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=wpex-panel-changelog&wpex_refresh_changelog=true' ) ); ?>" title="<?php _e( 'Refresh', 'wpex' ); ?>" class="button button-primary"><?php _e( 'Refresh', 'wpex' ); ?></a>
				<?php
				// Display VC changelog link
				if ( WPEX_VC_ACTIVE ) {
					$vc_changelog = WPEX_FRAMEWORK_DIR .'plugins/vc_changelog.txt';
					if ( file_exists( $vc_changelog ) ) {  ?>
						<a href="<?php echo WPEX_FRAMEWORK_DIR_URI .'plugins/vc_changelog.txt'; ?>" title="<?php _e( 'VC Changelog', 'wpex' ); ?>" class="button button-secondary wpex-lightbox" target="_blank"><?php _e( 'VC Changelog', 'wpex' ); ?></a>
					<?php } ?>
				<?php } ?>
			</p>


			<div class="wpex-theme-changelog clr">
				<?php
				// Display transient
				if ( $this->transient ) {
					echo $this->transient;
				}
				// Get changelog from remote url
				else {
					$response = wp_safe_remote_get( 'http://wpexplorer-themes.com/total/remote-changelog/' );
					if ( is_array( $response ) ) {
						$header = $response['headers'];
						if ( ! empty( $response['body'] ) ) {
							echo $response['body'];
							set_transient( 'wpex_theme_changelog', $response['body'], 24 * HOUR_IN_SECONDS );
						}
					} else {
						'Sorry could not retrieve the changelog, our servers may be down. Please try again later. Sorry for the inconvenience!';
					}
				} ?>
				<p><a href="http://wpexplorer-themes.com/total/changelog/" class="button button-primary" target="_blank"><?php _e( 'Full Changelog', 'wpex' ); ?></a></p>

			</div><!-- .wpex-theme-changelog -->

		</div><!-- .wrap -->

	<?php }

	/**
	 * Admin css
	 *
	 * @since 2.0.0
	 */
	public function css() { ?>

		<style type="text/css">
			.wpex-changelog-entry { margin-bottom: 30px; background: #fff; padding: 30px; }
			.wpex-changelog-entry li:first-child { padding-top: 0; }
			.wpex-changelog-entry li:last-child { padding-bottom: 0; border: 0; }
			.wpex-changelog-entry li { padding: 10px 0; margin: 0 !important; border-bottom: 1px solid #eee; }
			.wrap .wpex-changelog-entry h2 { margin: -30px -30px 30px; border-bottom: 1px solid #ededed; padding: 15px 30px; font-size: 18px; font-weight: normal; color: #777; }
			.wpex-theme-changelog .span-blue,
			.wpex-theme-changelog .span-green,
			.wpex-theme-changelog .span-yellow,
			.wpex-theme-changelog .span-red {
				display: inline-block;
				moz-border-radius: 3px;
				-webkit-border-radius: 3px;
				border-radius: 3px;
				font-size: 10px;
				font-weight: bold;
				font-weight: 500;
				padding: 3px 0;
				width: 60px;
				text-align: center;
				text-transform: uppercase;
				color: #fff;
				display: inline-block;
				line-height: 1em;
				margin-right: 10px;
			}
			.wpex-theme-changelog .span-green { background: #77cc33; }
			.wpex-theme-changelog .span-blue { background: #0099cc; }
			.wpex-theme-changelog .span-yellow { background: #ffcc33; }
			.wpex-theme-changelog .span-red { background: #DD5858; }
			.wpex-version-number { color: #000; font-weight: bold; }
		</style>

	<?php }

}
new WPEX_Theme_Changelog();