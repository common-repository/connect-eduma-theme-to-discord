<div class="error-log">
<?php
	$uuid     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_uuid_file_name' ) ) );
	$filename = $uuid . Connect_Eduma_Theme_To_Discord_Logs::$log_file_name;
	$handle   = fopen( WP_CONTENT_DIR . '/' . $filename, 'a+' );
if ( $handle ) {
	while ( ! feof( $handle ) ) {
		echo esc_html( fgets( $handle ) ). '<br />';
	}
	fclose( $handle );
}
?>
</div>
<div class="eduma-clrbtndiv">
	<div class="form-group">
		<input type="button" class="ets-eduma-clrbtn ets-submit ets-bg-red" id="ets-eduma-clrbtn" name="learnpress_clrbtn" value="Clear Logs !">
		<span class="clr-log spinner" ></span>
	</div>
	<div class="form-group">
		<input type="button" class="ets-submit ets-bg-green" value="Refresh" onClick="window.location.reload()">
	</div>
	<div class="form-group">
		<a href="<?php echo esc_url( content_url( '/' ) . $filename ); ?>" class="ets-submit ets-eduma-bg-download" download><?php esc_html_e( 'Download', 'connect-eduma-theme-to-discord' ); ?></a>
	</div>
	<div class="form-group">
			<a href="<?php echo esc_url( get_admin_url( '', 'tools.php' ) ) . '?page=action-scheduler&status=pending&s=learnpress'; ?>" class="ets-submit ets-eduma-bg-scheduled-actions"><?php esc_html_e( 'Scheduled Actions', 'connect-eduma-theme-to-discord' ); ?></a>
	</div>    
</div>
