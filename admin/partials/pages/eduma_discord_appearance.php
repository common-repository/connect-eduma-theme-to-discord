<?php
$ets_eduma_discord_connect_button_bg_color    = sanitize_text_field( trim( get_option( 'ets_eduma_discord_connect_button_bg_color' ) ) );
$ets_eduma_discord_disconnect_button_bg_color = sanitize_text_field( trim( get_option( 'ets_eduma_discord_disconnect_button_bg_color' ) ) );
$ets_eduma_discord_loggedin_button_text       = sanitize_text_field( trim( get_option( 'ets_eduma_discord_loggedin_button_text' ) ) );
$ets_eduma_discord_non_login_button_text      = sanitize_text_field( trim( get_option( 'ets_eduma_discord_non_login_button_text' ) ) );
$ets_eduma_discord_disconnect_button_text     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_disconnect_button_text' ) ) );
?>
<form method="post" action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>">
 <input type="hidden" name="action" value="eduma_discord_save_appearance_settings">
 <input type="hidden" name="current_url" value="<?php echo esc_url( ets_eduma_discord_get_current_screen_url() ); ?>" />
<?php wp_nonce_field( 'eduma_discord_appearance_settings_nonce', 'ets_eduma_discord_appearance_settings_nonce' ); ?>
  <table class="form-table" role="presentation">
	<tbody>
	<tr>
		<th scope="row"><?php esc_html_e( 'Connect/Login Button background color', 'connect-eduma-theme-to-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_connect_button_bg_color_value = ( isset( $ets_eduma_discord_connect_button_bg_color ) ) ? $ets_eduma_discord_connect_button_bg_color : '#7bbc36'; ?>
				<input name="ets_eduma_discord_connect_button_bg_color" type="text" id="ets_eduma_discord_connect_button_bg_color"  class="wp-color-picker-field" value="<?php echo esc_attr( $ets_eduma_discord_connect_button_bg_color_value ); ?>" data-default-color="#7bbc36">
		</fieldset></td> 
	</tr>
	<tr>        
		<th scope="row"><?php esc_html_e( 'Disconnect Button background color', 'connect-eduma-theme-to-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_disconnect_button_bg_color_value = ( isset( $ets_eduma_discord_disconnect_button_bg_color ) ) ? $ets_eduma_discord_disconnect_button_bg_color : '#ff0000'; ?>
		<input name="ets_eduma_discord_disconnect_button_bg_color" type="text" id="ets_eduma_discord_disconnect_button_bg_color" value="<?php echo esc_attr( $ets_eduma_discord_disconnect_button_bg_color_value ); ?>" data-default-color="#ff0000">
		</fieldset></td> 
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Text on the Button for logged-in users', 'connect-eduma-theme-to-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_loggedin_button_text_value = ( isset( $ets_eduma_discord_loggedin_button_text ) ) ? $ets_eduma_discord_loggedin_button_text : ''; ?>
		<input name="ets_eduma_discord_loggedin_button_text" type="text" id="ets_eduma_discord_loggedin_button_text" value="<?php echo esc_attr( $ets_eduma_discord_loggedin_button_text ); ?>">
		</fieldset></td> 
	</tr>         
	<tr>
		<th scope="row"><?php esc_html_e( 'Text on the Button for non-login users', 'connect-eduma-theme-to-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_non_login_button_text_value = ( isset( $ets_eduma_discord_non_login_button_text ) ) ? $ets_eduma_discord_non_login_button_text : ''; ?>
		<input name="ets_eduma_discord_non_login_button_text" type="text" id="ets_eduma_discord_non_login_button_text" value="<?php echo esc_attr( $ets_eduma_discord_non_login_button_text_value ); ?>">
		</fieldset></td> 
	</tr>	
	<tr>
		<th scope="row"><?php esc_html_e( 'Text on the Disconnect Button', 'connect-eduma-theme-to-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_disconnect_button_text_value = ( isset( $ets_eduma_discord_disconnect_button_text ) ) ? $ets_eduma_discord_disconnect_button_text : ''; ?>
		<input name="ets_eduma_discord_disconnect_button_text" type="text" id="ets_eduma_discord_disconnect_button_text" value="<?php echo esc_attr( $ets_eduma_discord_disconnect_button_text_value ); ?>">
		</fieldset></td> 
	</tr>	
	</tbody>
  </table>
  <div class="bottom-btn">
	<button type="submit" name="appearance_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php esc_html_e( 'Save Settings', 'connect-eduma-theme-to-discord' ); ?>
	</button>
  </div>
</form>
