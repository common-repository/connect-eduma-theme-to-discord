<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.expresstechsoftwares.com
 * @since             1.0.0
 * @package           Connect_Eduma_Theme_To_Discord
 *
 * @wordpress-plugin
 * Plugin Name:       Connect Eduma Theme to Discord
 * Plugin URI:        https://www.expresstechsoftwares.com/step-by-step-guide-on-how-to-connect-eduma-theme-to-discord-server
 * Description:       Connect your students to the discord server to create a community, information sharing, competition between students.
 * Version:           1.0.5
 * Author:            ExpressTech Softwares Solutions Pvt Ltd
 * Author URI:        https://www.expresstechsoftwares.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       connect-eduma-theme-to-discord
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CONNECT_EDUMA_THEME_TO_DISCORD_VERSION', '1.0.5' );

/**
 * Define plugin directory path
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Define plugin url
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
/**
 * Discord Bot Permissions.
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_BOT_PERMISSIONS', 8 );

/**
 * Discord api call scopes.
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_OAUTH_SCOPES', 'identify email guilds guilds.join' );

/**
 * Define group name for action scheduler actions
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME', 'ets-eduma-discord' );

/**
 * Discord API url.
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_API_URL', 'https://discord.com/api/v10/' );

/**
 * Follwing response codes not cosider for re-try API calls.
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_DONOT_RETRY_THESE_API_CODES', array( 0, 10003, 50033, 10004, 50025, 10013, 10011 ) );

/**
 * Define plugin directory url
 */
define( 'CONNECT_EDUMA_THEME_DISCORD_DONOT_RETRY_HTTP_CODES', array( 400, 401, 403, 404, 405, 502 ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-connect-eduma-theme-to-discord-activator.php
 */
function activate_connect_eduma_theme_to_discord() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-connect-eduma-theme-to-discord-activator.php';
	Connect_Eduma_Theme_To_Discord_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-connect-eduma-theme-to-discord-deactivator.php
 */
function deactivate_connect_eduma_theme_to_discord() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-connect-eduma-theme-to-discord-deactivator.php';
	Connect_Eduma_Theme_To_Discord_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_connect_eduma_theme_to_discord' );
register_deactivation_hook( __FILE__, 'deactivate_connect_eduma_theme_to_discord' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-connect-eduma-theme-to-discord.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_connect_eduma_theme_to_discord() {

	$plugin = new Connect_Eduma_Theme_To_Discord();
	$plugin->run();

}
run_connect_eduma_theme_to_discord();
