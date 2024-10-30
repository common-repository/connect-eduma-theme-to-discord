<?php
$ets_eduma_discord_client_id              = sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_id' ) ) );
$ets_eduma_discord_client_secret          = sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_secret' ) ) );
$ets_eduma_discord_bot_token              = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
$ets_eduma_discord_redirect_url           = sanitize_text_field( trim( get_option( 'ets_eduma_discord_redirect_url' ) ) );
$ets_eduma_discord_redirect_page_id       = sanitize_text_field( trim( get_option( 'ets_eduma_discord_redirect_page_id' ) ) );
$ets_eduma_discord_cache_timeout          = sanitize_text_field( trim( get_option( 'ets_eduma_discord_cache_timeout' ) ) );
$ets_eduma_discord_cache_timeout_interval = sanitize_text_field( trim( get_option( 'ets_eduma_discord_cache_timeout_interval' ) ) );

if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) {
	$ets_eduma_pmpro_discord_redirect_url     = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_redirect_url' ) ) );
	$ets_eduma_pmpro_discord_redirect_page_id = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_redirect_page_id' ) ) );
}

$ets_eduma_discord_server_id          = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );
$ets_eduma_discord_connected_bot_name = sanitize_text_field( trim( get_option( 'ets_eduma_discord_connected_bot_name' ) ) );
?>
<form method="post" action="<?php echo esc_url( get_site_url() ) . '/wp-admin/admin-post.php'; ?>">
  <input type="hidden" name="action" value="eduma_discord_application_settings">
  <input type="hidden" name="current_url" value="<?php echo esc_url( ets_eduma_discord_get_current_screen_url() ); ?>">   
	<?php wp_nonce_field( 'save_eduma_discord_general_settings', 'ets_eduma_discord_save_settings' ); ?>
  <div class="ets-input-group">
	<label><?php esc_html_e( 'Client ID', 'connect-eduma-theme-to-discord' ); ?> :</label>
	<?php $ets_eduma_discord_client_id_value = isset( $ets_eduma_discord_client_id ) ? $ets_eduma_discord_client_id : ''; ?>
	<input type="text" id="client-id" class="ets-input" name="ets_eduma_discord_client_id" value="<?php echo esc_attr( $ets_eduma_discord_client_id ); ?>" required placeholder="Discord Client ID">
  </div>
	<div class="ets-input-group">
	  <label><?php esc_html_e( 'Client Secret', 'connect-eduma-theme-to-discord' ); ?> :</label>
	  <?php $ets_eduma_discord_client_secret_value = isset( $ets_eduma_discord_client_secret ) ? $ets_eduma_discord_client_secret : ''; ?>
		<input type="password" class="ets-input" name="ets_eduma_discord_client_secret" value="<?php echo esc_attr( $ets_eduma_discord_client_secret_value ); ?>" required placeholder="Discord Client Secret">
	</div>
	<div class="ets-input-group">
			<label><?php esc_html_e( 'Redirect URL ( LearnPess )', 'connect-eduma-theme-to-discord' ); ?> :</label>
			<p class="redirect-url"><b><?php echo esc_url( $ets_eduma_discord_redirect_url ); ?></b></p>
		<select class= "ets-input" id="ets_eduma_discord_redirect_url" name="ets_eduma_discord_redirect_url" style="max-width: 100%" required>
		<?php _e( ets_eduma_discord_pages_list( wp_kses( $ets_eduma_discord_redirect_page_id, array( 'option' => array( 'data-page-url' => array() ) ) ) ) ); ?>
		</select>
		<p class="description"><?php esc_html_e( 'Registered discord app redirect url for LearnPress', 'connect-eduma-theme-to-discord' ); ?><span class="spinner"></span></p>
				<p class="description ets-discord-update-message"><?php _e( sprintf( wp_kses( __( 'Redirect URL updated, kindly add/update the same in your discord.com application link <a href="https://discord.com/developers/applications/%s/oauth2/general">https://discord.com/developers</a>', 'connect-eduma-theme-to-discord' ), array( 'a' => array( 'href' => array() ) ) ), $ets_eduma_discord_client_id ) ); ?></p>                
	</div>

	<?php if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) : ?>
		<div class="ets-input-group">
			<label><?php esc_html_e( 'Redirect URL ( PMPRO )', 'connect-eduma-theme-to-discord' ); ?> :</label>
			<p class="redirect-url-eduma-pmpro"><b><?php echo esc_url( $ets_eduma_pmpro_discord_redirect_url ); ?></b></p>
		<select class= "ets-input" id="ets_eduma_pmpro_discord_redirect_url" name="ets_eduma_pmpro_discord_redirect_url" style="max-width: 100%" required>
		<?php _e( ets_eduma_discord_pages_list( wp_kses( $ets_eduma_pmpro_discord_redirect_page_id, array( 'option' => array( 'data-page-url' => array() ) ) ) ) ); ?>
		</select>
		<p class="description"><?php esc_html_e( 'Registered discord app redirect url for PMPRO', 'connect-eduma-theme-to-discord' ); ?><span class="spinner"></span></p>
		<p class="description ets-discord-update-message"><?php _e( sprintf( wp_kses( __( 'Redirect URL updated, kindly add/update the same in your discord.com application link <a href="https://discord.com/developers/applications/%s/oauth2/general">https://discord.com/developers</a>', 'connect-eduma-theme-to-discord' ), array( 'a' => array( 'href' => array() ) ) ), $ets_eduma_discord_client_id ) ); ?></p>                
	</div>
	<?php endif; ?>

	<div class="ets-input-group">
			<label><?php esc_html_e( 'Admin Redirect URL Connect to bot', 'connect-eduma-theme-to-discord' ); ?> :</label>
			<input name="ets_eduma_discord_admin_redirect_url" type="text" class="ets-input" value="<?php echo esc_attr( get_admin_url( '', 'admin.php' ) . '?page=thim-ets-discord&via=eduma-discord-bot' ); ?>" readonly required />
		</div>
	<div class="ets-input-group">
			<?php
			if ( isset( $ets_eduma_discord_connected_bot_name ) && ! empty( $ets_eduma_discord_connected_bot_name ) ) {
				_e(
					sprintf(
						wp_kses(
							__( '<p class="description">Make sure the Bot <b> %1$s </b><span class="discord-bot"><b>BOT</b></span>have the high priority than the roles it has to manage. Open <a href="https://discord.com/channels/%2$s">Discord Server</a></p>', 'connect-eduma-theme-to-discord' ),
							array(
								'p'    => array( 'class' => array() ),
								'a'    => array( 'href' => array() ),
								'span' => array( 'class' => array() ),
								'b'    => array(),
							)
						),
						$ets_eduma_discord_connected_bot_name,
						$ets_eduma_discord_server_id
					)
				);
			}
			?>
	  <label><?php esc_html_e( 'Bot Token', 'connect-eduma-theme-to-discord' ); ?> :</label>
	  <?php $ets_eduma_discord_bot_token_value = isset( $ets_eduma_discord_bot_token ) ? $ets_eduma_discord_bot_token : ''; ?>
		<input type="password" class="ets-input" name="ets_eduma_discord_bot_token" value="<?php echo esc_attr( $ets_eduma_discord_bot_token_value ); ?>" required placeholder="Discord Bot Token">
	</div>
	<div class="ets-input-group">
	  <label><?php esc_html_e( 'Server ID', 'connect-eduma-theme-to-discord' ); ?> :</label>
	  <?php $ets_eduma_discord_server_id_value = isset( $ets_eduma_discord_server_id ) ? $ets_eduma_discord_server_id : ''; ?>
		<input type="text" class="ets-input" name="ets_eduma_discord_server_id"
		placeholder="Discord Server Id" value="<?php echo esc_attr( $ets_eduma_discord_server_id_value ); ?>" required>
	</div>
	<div class="ets-input-group">
	  <label><?php esc_html_e( 'Cache timeout', 'connect-eduma-theme-to-discord' ); ?> :</label>
	  <input type="number" min="1" name="ets_eduma_discord_cache_timeout" class="small-text" value="<?php echo esc_attr( (string) $ets_eduma_discord_cache_timeout ); ?>">
	  <select name="ets_eduma_discord_cache_timeout_interval" id="ets_eduma_discord_cache_timeout_interval" style="vertical-align: initial">
		<option value="<?php echo esc_attr( (string) MINUTE_IN_SECONDS ); ?>"
				<?php selected( $ets_eduma_discord_cache_timeout_interval, MINUTE_IN_SECONDS ); ?>>
				<?php esc_html_e( 'Minute(s)', 'connect-eduma-theme-to-discord' ); ?>
			</option>
		<option value="<?php echo esc_attr( (string) HOUR_IN_SECONDS ); ?>"
								<?php selected( $ets_eduma_discord_cache_timeout_interval, HOUR_IN_SECONDS ); ?>>
								<?php esc_html_e( 'Hour(s)', 'connect-eduma-theme-to-discord' ); ?>
		</option>
		<option value="<?php echo esc_attr( (string) DAY_IN_SECONDS ); ?>"
								<?php selected( $ets_eduma_discord_cache_timeout_interval, DAY_IN_SECONDS ); ?>>
								<?php esc_html_e( 'Day(s)', 'connect-eduma-theme-to-discord' ); ?>
		</option>
		<option value="<?php echo esc_attr( (string) WEEK_IN_SECONDS ); ?>"
								<?php selected( $ets_eduma_discord_cache_timeout_interval, WEEK_IN_SECONDS ); ?>>
								<?php esc_html_e( 'Week(s)', 'connect-eduma-theme-to-discord' ); ?>
		</option>
		<option value="<?php echo esc_attr( (string) MONTH_IN_SECONDS ); ?>"
								<?php selected( $ets_eduma_discord_cache_timeout_interval, MONTH_IN_SECONDS ); ?>>
								<?php esc_html_e( 'Month(s)', 'connect-eduma-theme-to-discord' ); ?>
		</option>
		<option value="<?php echo esc_attr( (string) YEAR_IN_SECONDS ); ?>"
								<?php selected( $ets_eduma_discord_cache_timeout_interval, YEAR_IN_SECONDS ); ?>>
								<?php esc_html_e( 'Year(s)', 'connect-eduma-theme-to-discord' ); ?>
		</option>
	</select>
	<p class="description"><?php esc_html_e( 'Time until expiration of cache. (Default = 1 Week). When saving or flushing the Role Mappings, the cache is reset automatically.', 'connect-eduma-theme-to-discord' ); ?></p>
	</div>	
	<?php if ( empty( $ets_eduma_discord_client_id ) || empty( $ets_eduma_discord_client_secret ) || empty( $ets_eduma_discord_bot_token ) || empty( $ets_eduma_discord_redirect_url ) || empty( $ets_eduma_discord_server_id ) ) { ?>
	  <p class="ets-danger-text description">
		<?php esc_html_e( 'Please save your form', 'connect-eduma-theme-to-discord' ); ?>
	  </p>
	<?php } ?>
	<p>
	  <button type="submit" name="submit" value="ets_discord_submit" class="ets-submit ets-bg-green">
		<?php esc_html_e( 'Save Settings', 'connect-eduma-theme-to-discord' ); ?>
	  </button>
	  <?php if ( get_option( 'ets_eduma_discord_client_id' ) ) : ?>

			<a href="?action=ets-eduma-discord-connect-to-bot" class="ets-btn eduma-btn-connect-to-bot" id="eduma-connect-discord-bot"><?php esc_html_e( 'Connect your Bot', 'connect-eduma-theme-to-discord' ); ?> <i class='fab fa-discord'></i></a>
	  <?php endif; ?>
	</p>
</form>
