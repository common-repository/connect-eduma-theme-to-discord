<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Connect_Eduma_Theme_To_Discord
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
if ( defined( 'WP_UNINSTALL_PLUGIN' )
		&& $_REQUEST['plugin'] === 'connect-eduma-theme-to-discord/connect-eduma-theme-to-discord.php'
		&& $_REQUEST['slug'] === 'connect-eduma-theme-to-discord'
	&& wp_verify_nonce( $_REQUEST['_ajax_nonce'], 'updates' )
  ) {

	global $wpdb;

	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . "usermeta WHERE `meta_key` LIKE '_ets_eduma_%'" ) );
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . "options WHERE `option_name` LIKE 'ets_eduma_%'" ) );
}
