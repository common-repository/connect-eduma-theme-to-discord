<?php
$ets_eduma_discord_send_welcome_dm         = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_send_welcome_dm' ) ) );
$ets_eduma_discord_welcome_message         = sanitize_text_field( trim( get_option( 'ets_eduma_discord_welcome_message' ) ) );
$ets_eduma_discord_send_course_complete_dm = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_send_course_complete_dm' ) ) );
$ets_eduma_discord_course_complete_message = sanitize_text_field( trim( get_option( 'ets_eduma_discord_course_complete_message' ) ) );
$ets_eduma_discord_send_lesson_complete_dm = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_send_lesson_complete_dm' ) ) );
$ets_eduma_discord_lesson_complete_message = sanitize_text_field( trim( get_option( 'ets_eduma_discord_lesson_complete_message' ) ) );
$retry_failed_api                          = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_retry_failed_api' ) ) );
$kick_upon_disconnect                      = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_kick_upon_disconnect' ) ) );
$retry_api_count                           = sanitize_text_field( trim( get_option( 'ets_eduma_discord_retry_api_count' ) ) );
$set_job_cnrc                              = sanitize_text_field( trim( get_option( 'ets_eduma_discord_job_queue_concurrency' ) ) );
$set_job_q_batch_size                      = sanitize_text_field( trim( get_option( 'ets_eduma_discord_job_queue_batch_size' ) ) );
$log_api_res                               = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_log_api_response' ) ) );
$embed_messaging_feature                   = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_embed_messaging_feature' ) ) );
$allow_discord_login                       = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_allow_discord_login' ) ) );
?>
<form method="post" action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>">
 <input type="hidden" name="action" value="eduma_discord_save_advance_settings">
 <input type="hidden" name="current_url" value="<?php echo esc_url( ets_eduma_discord_get_current_screen_url() ); ?>">   
<?php wp_nonce_field( 'eduma_discord_advance_settings_nonce', 'ets_eduma_discord_advance_settings_nonce' ); ?>
  <table class="form-table" role="presentation">
	<tbody>	<tr>
		<th scope="row"><?php esc_html_e( 'Shortcode:', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		[ets_eduma_discord]
		<br/>
		<small><?php esc_html_e( 'Use this shortcode [ets_eduma_discord] to display connect to discord button on any page.', 'connect-eduma-discord-addon' ); ?></small>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Use rich embed messaging feature?', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="embed_messaging_feature" type="checkbox" id="embed_messaging_feature" 
		<?php
		if ( $embed_messaging_feature === true ) {
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
		<input name="ets_eduma_discord_send_welcome_dm" type="checkbox" id="ets_eduma_discord_send_welcome_dm" 
		<?php
		if ( $ets_eduma_discord_send_welcome_dm === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	</tr>
       
	<tr>
		<th scope="row"><?php esc_html_e( 'Welcome message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<textarea class="ets_eduma_discord_dm_textarea" name="ets_eduma_discord_welcome_message" id="ets_eduma_discord_welcome_message" row="25" cols="50">
<?php
if ( $ets_eduma_discord_welcome_message ) {
	echo esc_textarea( wp_unslash( $ets_eduma_discord_welcome_message ) ); }
?>
		</textarea> 
	<br/>
	<small>Merge fields: [LP_STUDENT_NAME], [LP_STUDENT_EMAIL], [LP_COURSES], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Send Course Complete message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_discord_send_course_complete_dm" type="checkbox" id="ets_eduma_discord_send_course_complete_dm" 
		<?php
		if ( $ets_eduma_discord_send_course_complete_dm === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Course Complete message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_course_complete_message_text = ( $ets_eduma_discord_course_complete_message ) ? $ets_eduma_discord_course_complete_message : ''; ?>
		<textarea class="ets_eduma_discord_course_complete_message" name="ets_eduma_discord_course_complete_message" id="ets_eduma_discord_course_complete_message" row="25" cols="50"><?php echo esc_textarea( wp_unslash( $ets_eduma_discord_course_complete_message_text ) ); ?></textarea> 
	<br/>
	<small>Merge fields: [LP_STUDENT_NAME], [LP_STUDENT_EMAIL], [LP_COURSE_NAME], [LP_COURSE_COMPLETE_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Send Lesson Complete message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_eduma_discord_send_lesson_complete_dm" type="checkbox" id="ets_eduma_discord_send_lesson_complete_dm" 
		<?php
		if ( $ets_eduma_discord_send_lesson_complete_dm === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Lesson Complete message', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $ets_eduma_discord_lesson_complete_message = ( $ets_eduma_discord_lesson_complete_message ) ? $ets_eduma_discord_lesson_complete_message : ''; ?>
		<textarea class="ets_eduma_discord_lesson_complete_message" name="ets_eduma_discord_lesson_complete_message" id="ets_eduma_discord_lesson_complete_message" row="25" cols="50"><?php echo esc_textarea( wp_unslash( $ets_eduma_discord_lesson_complete_message ) ); ?></textarea> 
	<br/>
	<small>Merge fields:  [LP_STUDENT_NAME], [LP_STUDENT_EMAIL], [LP_LESSON_NAME], [LP_COURSE_LESSON_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	  </tr>	
	  <tr>
		<th scope="row"><?php esc_html_e( 'Retry Failed API calls', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="retry_failed_api" type="checkbox" id="retry_failed_api" 
		<?php
		if ( $retry_failed_api === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Don\'t kick students upon disconnect', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="kick_upon_disconnect" type="checkbox" id="kick_upon_disconnect" 
		<?php
		if ( $kick_upon_disconnect === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Allow Discord Authentication before checkout?', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="allow_discord_login" type="checkbox" id="allow_discord_login" 
		<?php
		if ( $allow_discord_login === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset>
  </td>
	  </tr>           
	<tr>
		<th scope="row"><?php esc_html_e( 'How many times a failed API call should get re-try', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $retry_api_count_value = ( isset( $retry_api_count ) ) ? esc_attr( intval( $retry_api_count ) ) : 1; ?>
		<input name="ets_eduma_retry_api_count" type="number" min="1" id="ets_eduma_retry_api_count" value="<?php echo intval( esc_attr( $retry_api_count_value ) ); ?>">
		</fieldset></td>
	  </tr> 
	  <tr>
		<th scope="row"><?php esc_html_e( 'Set job queue concurrency', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $set_job_cnrc_value = ( isset( $set_job_cnrc ) ) ? esc_attr( intval( $set_job_cnrc ) ) : 1; ?>
		<input name="set_job_cnrc" type="number" min="1" id="set_job_cnrc" value="<?php echo intval( esc_attr( $set_job_cnrc_value ) ); ?>">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Set job queue batch size', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
			<?php $set_job_q_batch_size_value = ( isset( $set_job_q_batch_size ) ) ? esc_attr( intval( $set_job_q_batch_size ) ) : 10; ?>
		<input name="set_job_q_batch_size" type="number" min="1" id="set_job_q_batch_size" value="<?php echo intval( esc_attr( $set_job_q_batch_size_value ) ); ?>">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Log API calls response (For debugging purpose)', 'connect-eduma-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="log_api_res" type="checkbox" id="log_api_res" 
		<?php
		if ( $log_api_res === true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	
	</tbody>
  </table>
  <div class="bottom-btn">
	<button type="submit" name="adv_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php esc_html_e( 'Save Settings', 'connect-eduma-discord-addon' ); ?>
	</button>
  </div>
</form>
