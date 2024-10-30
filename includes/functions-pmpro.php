<?php
/**
 * Get pmpro current level id
 *
 * @param INT $user_id
 * @return INT|NULL $curr_level_id
 */
function ets_eduma_pmpro_discord_get_current_level_id( $user_id ) {
	$membership_level = pmpro_getMembershipLevelForUser( $user_id );
	if ( $membership_level ) {
		$curr_level_id = sanitize_text_field( trim( $membership_level->ID ) );
		return $curr_level_id;
	} else {
		return null;
	}
}

/**
 * Get formatted message to send in DM
 *
 * @param INT $user_id
 * Merge fields: [MEMBER_USERNAME], [MEMBER_EMAIL], [MEMBERSHIP_LEVEL], [SITE_URL], [BLOG_NAME], [MEMBERSHIP_ENDDATE], [MEMBERSHIP_STARTDATE]</small>
 */
function ets_eduma_pmpro_discord_get_formatted_dm( $user_id, $level_id, $message ) {
	global $wpdb;
	$user_obj         = get_user_by( 'id', $user_id );
	$level            = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = %d LIMIT 1", $level_id ) );
	$membership_level = pmpro_getMembershipLevelForUser( $user_id );

	$MEMBER_USERNAME = sanitize_text_field( $user_obj->user_login );
	$MEMBER_EMAIL    = sanitize_email( $user_obj->user_email );
	if ( $membership_level !== false ) {
		$MEMBERSHIP_LEVEL = $membership_level->name;
	} elseif ( $level !== null ) {
		$MEMBERSHIP_LEVEL = $level->name;
	} else {
		$MEMBERSHIP_LEVEL = '';
	}

	$SITE_URL  = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME = sanitize_text_field( get_bloginfo( 'name' ) );

	if ( $membership_level !== false && isset( $membership_level->startdate ) && $membership_level->startdate != '' ) {
		$MEMBERSHIP_STARTDATE = date( 'F jS, Y', $membership_level->startdate );

	} else {
		$MEMBERSHIP_STARTDATE = '';
	}
	if ( $membership_level !== false && isset( $membership_level->enddate ) && $membership_level->enddate != '' ) {
		$MEMBERSHIP_ENDDATE = date( 'F jS, Y', $membership_level->enddate );
	} elseif ( $level !== null && $level->expiration_period === '' ) {
		$MEMBERSHIP_ENDDATE = 'Never';
	} else {
		$MEMBERSHIP_ENDDATE = '';
	}

	$find    = array(
		'[MEMBER_USERNAME]',
		'[MEMBER_EMAIL]',
		'[MEMBERSHIP_LEVEL]',
		'[SITE_URL]',
		'[BLOG_NAME]',
		'[MEMBERSHIP_ENDDATE]',
		'[MEMBERSHIP_STARTDATE]',
	);
	$replace = array(
		$MEMBER_USERNAME,
		$MEMBER_EMAIL,
		$MEMBERSHIP_LEVEL,
		$SITE_URL,
		$BLOG_NAME,
		$MEMBERSHIP_ENDDATE,
		$MEMBERSHIP_STARTDATE,
	);

	return str_replace( $find, $replace, $message );
}

/**
 * Remove PMPRO User's data
 *
 * @param INT @user_id User ID
 */
function ets_eduma_pmpro_discord_remove_usermeta( $user_id ) {

	global $wpdb;

	$usermeta_table      = $wpdb->prefix . 'usermeta';
	$usermeta_sql        = 'DELETE FROM ' . $usermeta_table . " WHERE `user_id` = %d AND  `meta_key` LIKE '_ets_eduma_pmpro_discord%'; ";
	$delete_usermeta_sql = $wpdb->prepare( $usermeta_sql, $user_id );
	$wpdb->query( $delete_usermeta_sql );

}
