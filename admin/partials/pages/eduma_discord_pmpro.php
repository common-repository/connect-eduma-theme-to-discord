<?php
$upon_failed_payment                                = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_payment_failed' ) ) );
$member_kick_out                                    = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_member_kick_out' ) ) );
$ets_eduma_pmpro_discord_send_expiration_warning_dm = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_expiration_warning_dm' ) ) );
$ets_eduma_pmpro_discord_expiration_warning_message = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_expiration_warning_message' ) ) );
$ets_eduma_pmpro_discord_expired_message            = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_expired_message' ) ) );
$ets_eduma_pmpro_discord_send_membership_expired_dm = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_membership_expired_dm' ) ) );
$ets_eduma_pmpro_discord_expiration_expired_message = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_expiration_expired_message' ) ) );
$ets_eduma_pmpro_discord_send_welcome_dm            = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_welcome_dm' ) ) );
$ets_eduma_pmpro_discord_welcome_message            = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_welcome_message' ) ) );
$ets_eduma_pmpro_discord_send_membership_cancel_dm  = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_membership_cancel_dm' ) ) );
$ets_eduma_pmpro_discord_cancel_message             = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_cancel_message' ) ) );
$ets_eduma_pmpro_discord_embed_messaging_feature    = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_embed_messaging_feature' ) ) );
$ets_eduma_pmpro_log_api_res                        = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_log_api_response' ) ) );

?>
<form method="post" action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>">
 <input type="hidden" name="action" value="eduma_discord_save_pmpro_settings">
 <input type="hidden" name="current_url" value="<?php echo esc_url( ets_eduma_discord_get_current_screen_url() ); ?>">   
<?php wp_nonce_field( 'eduma_discord_pmpro_settings_nonce', 'ets_eduma_discord_pmpro_settings_nonce' ); ?>
  <table class="form-table" role="presentation">
	<tbody>
  <tr>
		<th scope="row"><?php esc_html_e( 'Shortcode', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		[ets_eduma_pmpro_discord]
	<br/>
	<small><?php esc_html_e( ' Using the shortcode [ets_eduma_pmpro_discord] on any page, anyone can join the website discord server by authentication via member discord account. New members will get default role if selected in the setting.', 'connect-eduma-discord-addon' ); ?></small>
		</fieldset></td>
	  </tr>
  <tr>
		<th scope="row"><?php esc_html_e( 'Use rich embed messaging feature?', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_pmpro_discord_embed_messaging_feature" type="checkbox" id="ets_eduma_pmpro_discord_embed_messaging_feature" 
		<?php
		if ( $ets_eduma_pmpro_discord_embed_messaging_feature === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
				<br/>
				<small>Use [LINEBREAK] to split lines.</small>                
		</fieldset></td>
	  </tr>          
  <tr>
		<th scope="row"><?php esc_html_e( 'Send welcome message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_pmpro_discord_send_welcome_dm" type="checkbox" id="ets_eduma_pmpro_discord_send_welcome_dm" 
		<?php
		if ( $ets_eduma_pmpro_discord_send_welcome_dm === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Membership welcome message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_pmpro_discord_welcome_message_text = ( $ets_eduma_pmpro_discord_welcome_message ) ? $ets_eduma_pmpro_discord_welcome_message : ''; ?>
		<textarea class="ets_eduma_pmpro_discord_dm_textarea" name="ets_eduma_pmpro_discord_welcome_message" id="ets_eduma_pmpro_discord_welcome_message" row="25" cols="50"><?php echo esc_textarea( wp_unslash( $ets_eduma_pmpro_discord_welcome_message_text ) ); ?></textarea> 
	<br/>
	<small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME], [MEMBERSHIP_ENDDATE], [MEMBERSHIP_STARTDATE]</small>
		</fieldset></td>
	  </tr>

	<tr>
		<th scope="row"><?php esc_html_e( 'Send membership expiration warning message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_pmpro_discord_send_expiration_warning_dm" type="checkbox" id="ets_eduma_pmpro_discord_send_expiration_warning_dm" 
		<?php
		if ( $ets_eduma_pmpro_discord_send_expiration_warning_dm === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Membership expiration warning message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_pmpro_discord_expiration_warning_message_text = ( $ets_eduma_pmpro_discord_expiration_warning_message ) ? $ets_eduma_pmpro_discord_expiration_warning_message : ''; ?>
		<textarea  class="ets_eduma_pmpro_discord_dm_textarea" name="ets_eduma_pmpro_discord_expiration_warning_message" id="ets_eduma_pmpro_discord_expiration_warning_message" row="25" cols="50"><?php echo esc_textarea( wp_unslash( $ets_eduma_pmpro_discord_expiration_warning_message_text ) ); ?></textarea> 
	<br/>
	<small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME], [MEMBERSHIP_ENDDATE]</small>
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Send membership expired message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_pmpro_discord_send_membership_expired_dm" type="checkbox" id="ets_eduma_pmpro_discord_send_membership_expired_dm" 
		<?php
		if ( $ets_eduma_pmpro_discord_send_membership_expired_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Membership expired message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_pmpro_discord_expiration_expired_message_text = ( $ets_eduma_pmpro_discord_expiration_expired_message ) ? $ets_eduma_pmpro_discord_expiration_expired_message : ''; ?>
		<textarea  class="ets_eduma_pmpro_discord_dm_textarea" name="ets_eduma_pmpro_discord_expiration_expired_message" id="ets_eduma_pmpro_discord_expiration_expired_message" row="25" cols="50"><?php echo esc_textarea( wp_unslash( $ets_eduma_pmpro_discord_expiration_expired_message_text ) ); ?></textarea> 
	<br/>
	<small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME]</small>
		</fieldset>
  </td>
		</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Send membership cancel message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_pmpro_discord_send_membership_cancel_dm" type="checkbox" id="ets_eduma_pmpro_discord_send_membership_cancel_dm" 
		<?php
		if ( $ets_eduma_pmpro_discord_send_membership_cancel_dm === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
		<tr>
		<th scope="row"><?php esc_html_e( 'Membership cancel message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_pmpro_discord_cancel_message_text = ( $ets_eduma_pmpro_discord_cancel_message ) ? $ets_eduma_pmpro_discord_cancel_message : ''; ?>
		<textarea  class="ets_eduma_pmpro_discord_dm_textarea" name="ets_eduma_pmpro_discord_cancel_message" id="ets_eduma_pmpro_discord_cancel_message" row="25" cols="50"><?php echo esc_textarea( wp_unslash( $ets_eduma_pmpro_discord_cancel_message_text ) ); ?></textarea> 
	<br/>
	<small>Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME]</small>
		</fieldset>
  </td>
		</tr>
  <tr>
		<th scope="row"><?php esc_html_e( 'Re-assign roles upon payment failure', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="upon_failed_payment" type="checkbox" id="upon_failed_payment" 
		<?php
		if ( $upon_failed_payment === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>

	  <tr>
		<th scope="row"><?php esc_html_e( 'Kick members out when they Disconnect their Account?', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="member_kick_out" type="checkbox" id="member_kick_out" 
		<?php
		if ( $member_kick_out === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset>
	<small>Members will be kicked out if this setting is checked.</small>
  </td>
	  </tr>



	<tr>
		<th scope="row"><?php esc_html_e( 'Log API calls response (For debugging purpose)', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="log_api_res" type="checkbox" id="log_api_res" 
		<?php
		if ( $ets_eduma_pmpro_log_api_res === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	
	</tbody>
  </table>
  <div class="bottom-btn">
	<button type="submit" name="pmpro_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php esc_html_e( 'Save Settings', 'connect-eduma-discord-addon' ); ?>
	</button>
  </div>
</form>
