<?php
/**
 * Perform actions after updating the theme
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hook to init to prevent any possible conflicts in main theme class
function wpex_after_update() {

	// Define dir
	$dir = WPEX_FRAMEWORK_DIR .'updates/';

	// Get theme version
	$theme_version = WPEX_THEME_VERSION;

	// Get user version
	$version = get_option( 'total_version' );
	$version = $version ? $version : '2.1.3'; // needs something

	// Migrate redux options
	if ( ! get_option( 'wpex_customizer_migration_complete' ) && get_option( 'wpex_options' ) ) {
		require_once( $dir .'redux-migrate.php' );
	} else {
		update_option( 'wpex_customizer_migration_complete', 'completed' );
	}

	// Reset plugin notification and enable
	if ( $version != WPEX_THEME_VERSION  ) {
		set_theme_mod( 'recommend_plugins_enable', true );
		delete_metadata( 'user', null, 'tgmpa_dismissed_notice_wpex_theme', null, true );
	}

	// Display Notice if Supported version of VC is smaller then current version
	if ( defined( 'WPB_VC_VERSION' )
		&& apply_filters( 'wpex_display_outdated_vc_notice', true )
		&& version_compare( WPEX_VC_SUPPORTED_VERSION, WPB_VC_VERSION, '>' )
	) {

		// Make sure TGMA is running
		set_theme_mod( 'recommend_plugins_enable', true );
		delete_metadata( 'user', null, 'tgmpa_dismissed_notice_wpex_theme', null, true );

		// Don't display notice anymore...@since 3.1.1
		/*
		require_once( $dir .'update-front-end-notice.php' );
		new WPEX_Update_Front_End_Notice( array(
			'title'   => 'Total v'. $theme_version,
			'content' => 'vc_notice',
		) );*/

	}

	// Lets add an initial version that tells me when they first activated the theme, this never changes
	if ( ! get_option( 'total_initial_version' ) ) {
		update_option( 'total_initial_version', $theme_version );
	}

	// Save all mods to a backup option incase something goes wrong
	function wpex_backup_mods() {
		global $wpex_theme_mods;
		update_option( 'wpex_total_customizer_backup' , $wpex_theme_mods );
	}

	// Version 3.0.0 Update
	if ( $version < '3.0.0' ) {
		wpex_backup_mods(); // Backup first
		$file = WPEX_FRAMEWORK_DIR .'updates/update-3_0_0.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
		}
	}

	// Update theme version
	update_option( 'total_version', $theme_version );

}
add_action( 'init', 'wpex_after_update' );