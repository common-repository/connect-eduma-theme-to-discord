<?php

$args_courses = array(
	'orderby'     => 'title',
	'order'       => 'ASC',
	'post_status' => 'publish',
	'numberposts' => -1,
	'post_type'   => 'lp_course',
);
$courses      = get_posts( $args_courses );

$default_role            = sanitize_text_field( trim( get_option( 'ets_eduma_discord_default_role_id' ) ) );
$allow_none_student      = sanitize_text_field( trim( get_option( 'ets_eduma_discord_allow_none_student' ) ) );
$pmpro_default_role      = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_default_role_id' ) ) );
$pmpro_allow_none_member = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_allow_none_member' ) ) );
?>
<div class="notice notice-warning ets-notice">
  <p><i class='fas fa-info'></i> <?php esc_html_e( 'Drag and Drop the Discord Roles over to the LearnPress Courses', 'connect-eduma-theme-to-discord' ); ?></p>
</div>

<div class="row-container">
<h3><?php esc_html_e( 'LearnPress Roles Mapping', 'connect-eduma-theme-to-discord' ); ?></h3>
<h4><?php esc_html_e( 'Define the role for each Course.', 'connect-eduma-theme-to-discord' ); ?></h4>
  <div class="ets-column eduma-discord-roles-col">
	<h2><?php esc_html_e( 'Discord Roles', 'connect-eduma-theme-to-discord' ); ?></h2>
	<hr>
	<div class="eduma-discord-roles">
	  <span class="spinner"></span>
	</div>
  </div>
  <div class="ets-column">
	<h2><?php esc_html_e( 'Courses', 'connect-eduma-theme-to-discord' ); ?></h2>
	<hr>
	<div class="eduma-discord-courses">
	<?php
	foreach ( $courses as $course ) {

		?>
		  <div class="makeMeDroppable" data-eduma_course_id="<?php echo esc_attr( $course->ID ); ?>" ><span><?php esc_html_e( $course->post_title ); ?></span></div>
			<?php

	}
	?>
	</div>
  </div>
</div>
<?php ets_eduma_discord_pmpro_levels_mapping(); ?>
<hr>
<form method="post" action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>">
 <input type="hidden" name="action" value="eduma_discord_save_role_mapping">
 <input type="hidden" name="current_url" value="<?php echo esc_url( ets_eduma_discord_get_current_screen_url() ); ?>">   
  <table class="form-table" role="presentation">
	<tbody>
	  <tr>
		<th scope="row"><label for="eduma-defaultRole"><?php esc_html_e( 'LearnPress Default Role', 'connect-eduma-theme-to-discord' ); ?></label></th>
		<td>
		  <?php wp_nonce_field( 'eduma_discord_role_mappings_nonce', 'ets_eduma_discord_role_mappings_nonce' ); ?>
		  <input type="hidden" id="selected_default_role" value="<?php echo esc_attr( $default_role ); ?>">
		  <select id="eduma-defaultRole" name="eduma_defaultRole">
			<option value="none"><?php esc_html_e( '-None-', 'connect-eduma-theme-to-discord' ); ?></option>
		  </select>
		  <p class="description"><?php esc_html_e( 'This Role will be assigned to all', 'connect-eduma-theme-to-discord' ); ?></p>
		</td>
	  </tr>
	  <tr>
		<th scope="row"><label><?php esc_html_e( 'Allow non-student', 'connect-eduma-theme-to-discord' ); ?></label></th>
		<td>
		  <fieldset>
		  <label><input type="radio" name="allow_none_student" value="yes"  
		  <?php
			if ( $allow_none_student === 'yes' ) {
				echo esc_attr( 'checked="checked"' ); }
			?>
			 > <span><?php esc_html_e( 'Yes', 'connect-eduma-theme-to-discord' ); ?></span></label><br>
		  <label><input type="radio" name="allow_none_student" value="no" 
		  <?php
			if ( empty( $allow_none_student ) || $allow_none_student === 'no' ) {
				echo esc_attr( 'checked="checked"' ); }
			?>
			 > <span><?php esc_html_e( 'No', 'connect-eduma-theme-to-discord' ); ?></span></label>
		  <p class="description"><?php esc_html_e( 'Display connect button to normal WordPress site users having LearnPress account', 'connect-eduma-theme-to-discord' ); ?></p>
		  </fieldset>
		</td>
	  </tr> 

<?php if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) : ?>
	<tr><td colspan="2"><hr></td></tr>
	<!-- <tr><th scope="row"><?php esc_html_e( 'Paid Memberships Pro', 'connect-eduma-theme-to-discord' ); ?>	</tr></th> -->
	  <tr>
		<th scope="row"><label for="pmpro-defaultRole"><?php esc_html_e( 'PMPRO Default Role', 'connect-eduma-theme-to-discord' ); ?></label></th>
		<td>
		  <input type="hidden" id="pmpro-selected_default_role" value="<?php echo esc_attr( $pmpro_default_role ); ?>">
		  <select id="pmpro-defaultRole" name="pmpro_defaultRole">
			<option value="none"><?php esc_html_e( '-None-', 'connect-eduma-theme-to-discord' ); ?></option>
		  </select>
		  <p class="description"><?php esc_html_e( 'This Role will be assigned to all level members', 'connect-eduma-theme-to-discord' ); ?></p>
		</td>
	  </tr>
	  <tr>
	  <tr>
		<th scope="row"><label><?php esc_html_e( 'Allow non-members', 'connect-eduma-theme-to-discord' ); ?></label></th>
		<td>
		  <fieldset>
		  <label><input type="radio" name="pmpro_allow_none_member" value="yes"  
		  <?php
			if ( $pmpro_allow_none_member === 'yes' ) {
				echo esc_attr( 'checked="checked"' ); }
			?>
			 > <span><?php esc_html_e( 'Yes', 'connect-eduma-theme-to-discord' ); ?></span></label><br>
		  <label><input type="radio" name="pmpro_allow_none_member" value="no" 
		  <?php
			if ( empty( $pmpro_allow_none_member ) || $pmpro_allow_none_member === 'no' ) {
				echo esc_attr( 'checked="checked"' ); }
			?>
			 > <span><?php esc_html_e( 'No', 'connect-eduma-theme-to-discord' ); ?></span></label>
		  <p class="description"><?php esc_html_e( 'This setting will apply on Cancel and Expiry of Membership', 'connect-eduma-theme-to-discord' ); ?></p>
		  </fieldset>
		</td>
	  </tr>

<?php endif; ?>

	</tbody>
  </table>
	<br>
  <div class="mapping-json">
	<textarea id="ets_eduma_mapping_json_val" name="ets_eduma_discord_role_mapping">
	<?php
	if ( isset( $ets_discord_roles ) ) {
		echo stripslashes( esc_html( $ets_discord_roles ) );}
	?>
	</textarea>
	<textarea id="ets_eduma_mapping_pmpro_json_val" name="ets_eduma_pmpro_discord_role_mapping">
	<?php
	if ( isset( $ets_pmpro_discord_roles ) ) {
		echo esc_html( $ets_pmpro_discord_roles );}
	?>
	</textarea>	
  </div>
  <div class="bottom-btn">
	<button type="submit" name="submit" value="ets_submit" class="ets-submit ets-btn-submit ets-bg-green">
	  <?php esc_html_e( 'Save Settings', 'connect-eduma-theme-to-discord' ); ?>
	</button>
	<button id="revertMapping" name="flush" class="ets-submit ets-btn-submit ets-bg-red">
	  <?php esc_html_e( 'Flush Mappings', 'connect-eduma-theme-to-discord' ); ?>
	</button>
  </div>
</form>
