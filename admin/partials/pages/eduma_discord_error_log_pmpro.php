<div class="error-log-pmpro">
<?php
	$uuid     = sanitize_text_field( trim( get_option( 'ets_pmpro_discord_uuid_file_name' ) ) );
	$filename = $uuid . Connect_Eduma_Theme_To_Discord_Logs_PMPRO::$log_file_name;
	$handle   = fopen( WP_CONTENT_DIR . '/' . $filename, 'a+' );
if ( $handle ) {
	while ( ! feof( $handle ) ) {
		echo fgets( $handle ) . '<br />';
	}
}
	fclose( $handle );
?>
</div>
<div class="eduma-pmpro-clrbtndiv">
	<div class="form-group">
		<input type="button" class="eduma-pmpro-clrbtn ets-submit ets-bg-red" id="eduma-pmpro-clrbtn" name="eduma-pmpro-clrbtn" value="Clear Logs !">
		<span class="clr-log spinner" ></span>
	</div>
	<div class="form-group">
		<input type="button" class="ets-submit ets-bg-green" value="Refresh" onClick="window.location.reload()">
	</div>
  <div class="form-group">
		<a href="<?php echo esc_attr( content_url( '/' ) . $filename ); ?>" class="ets-submit ets-eduma-pmpro-bg-download" download><?php esc_html_e( 'Download', 'connect-eduma-theme-to-discord' ); ?></a>
	</div>
	<div class="form-group">
		<a href="<?php echo esc_url( get_admin_url( '', 'tools.php' ) ); ?>/wp-admin/tools.php?page=action-scheduler&status=pending&s=pmpro" class="ets-submit ets-eduma-pmpro-bg-scheduled-actions"><?php esc_html_e( 'Scheduled Actions', 'connect-eduma-theme-to-discord' ); ?></a>
	</div>
</div>
