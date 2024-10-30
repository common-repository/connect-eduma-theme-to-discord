<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Connect_Eduma_Theme_To_Discord
 * @subpackage Connect_Eduma_Theme_To_Discord/admin/partials
 */
?>
<?php
if ( isset( $_GET['save_settings_msg'] ) ) {
	?>
	<div class="notice notice-success is-dismissible support-success-msg">
		<p><?php echo esc_html( $_GET['save_settings_msg'] ); ?></p>
	</div>
	<?php
}
?>
<h3><?php esc_html_e( 'Connect Eduma Theme to Discord Add-On Settings', 'connect-eduma-theme-to-discord' ); ?></h3>
		<div id="eduma-theme-discorddiscord-outer" class="eduma-theme-discord-outer skltbs-theme-light" data-skeletabs='{ "startIndex": 0 }'>
			<ul class="skltbs-tab-group">
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="settings" ><?php esc_html_e( 'Application Details', 'connect-eduma-theme-to-discord' ); ?><span class="initialtab spinner"></span></button>
				</li>
				<?php if ( eduma_discord_check_saved_settings_status() ) : ?>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="level-mapping" ><?php esc_html_e( 'Role Mappings', 'connect-eduma-theme-to-discord' ); ?></button>
				</li>
				<?php endif; ?>				
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="advanced" ><?php esc_html_e( 'LearnPess', 'connect-eduma-theme-to-discord' ); ?>	
				</button>
				</li>
				<?php if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) : ?>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="ets_eduma_pmpro" ><?php esc_html_e( 'Paid Memberships Pro', 'connect-eduma-theme-to-discord' ); ?>	
				</button>
				</li>
				<?php endif; ?>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="appearance" ><?php esc_html_e( 'Appearance', 'connect-eduma-theme-to-discord' ); ?>	
				</button>
				</li>                                
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="logs" ><?php esc_html_e( 'LP Logs', 'connect-eduma-theme-to-discord' ); ?>	
				</button>				
				</li>
				<?php if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) : ?>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="logs-pmpro" ><?php esc_html_e( 'PMPRO Logs', 'connect-eduma-theme-to-discord' ); ?>	
				</button>	
				<li class="skltbs-tab-item">
				<button class="skltbs-tab ets-eduma-discord-tab" data-identity="documentation" ><?php esc_html_e( 'How-to guide', 'connect-eduma-theme-to-discord' ); ?>	
				</button>							
				</li>					
				<?php endif; ?>

			</ul>
			<div class="skltbs-panel-group">
				<div id="ets_eduma_application_details" class="ets-eduma-discord-tab-content skltbs-panel">
				<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_application_details.php'; ?>
				</div>
				<?php if ( eduma_discord_check_saved_settings_status() ) : ?>      
				<div id="ets_eduma_discord_role_mapping" class="ets-eduma-discord-tab-content skltbs-panel">
					<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_role_mapping.php'; ?>
				</div>
				<?php endif; ?>
				<div id='ets_eduma_discord_advanced' class="ets-eduma-discord-tab-content skltbs-panel">
				<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_advanced.php'; ?>
				</div>
				<?php if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) : ?>
					<div id='ets_eduma_discord_pmpro' class="ets-eduma-discord-tab-content skltbs-panel">
					<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_pmpro.php'; ?>
					</div>
				<?php endif; ?>
				<div id='ets_eduma_discord_appearance' class="ets-eduma-discord-tab-content skltbs-panel">
				<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_appearance.php'; ?>
				</div>                            
				<div id='ets_eduma_discord_logs' class="ets-eduma-discord-tab-content skltbs-panel">
				<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_error_log.php'; ?>
				</div>  
				<?php if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) : ?>
				<div id='ets_eduma_discord_logs_pmoro' class="ets-eduma-discord-tab-content skltbs-panel">
					<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_error_log_pmpro.php'; ?>
				</div>
				<div id='ets_eduma_discord_documentation' class="ets-eduma-discord-tab-content skltbs-panel">
					<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/eduma_discord_documentation.php'; ?>
				</div> 				
				<?php endif; ?>				                          
			</div>  
		</div>

