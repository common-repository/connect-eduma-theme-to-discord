<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Connect_Eduma_Theme_To_Discord
 * @subpackage Connect_Eduma_Theme_To_Discord/includes
 */

use Elementor\Modules\WpCli\Update;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Connect_Eduma_Theme_To_Discord
 * @subpackage Connect_Eduma_Theme_To_Discord/includes
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Connect_Eduma_Theme_To_Discord_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'ets_eduma_discord_send_welcome_dm', true );
		update_option( 'ets_eduma_discord_welcome_message', 'Hi [LP_STUDENT_NAME] ([LP_STUDENT_EMAIL]), Welcome, Your courses [LP_COURSES] at [SITE_URL] Thanks, Kind Regards, [BLOG_NAME]' );
		update_option( 'ets_eduma_discord_send_course_complete_dm', true );
		update_option( 'ets_eduma_discord_course_complete_message', 'Hi [LP_STUDENT_NAME] ([LP_STUDENT_EMAIL]), You have completed the course  [LP_COURSE_NAME] at [LP_COURSE_COMPLETE_DATE] on website [SITE_URL], [BLOG_NAME]' );
		update_option( 'ets_eduma_discord_send_lesson_complete_dm', true );
		update_option( 'ets_eduma_discord_lesson_complete_message', 'Hi [LP_STUDENT_NAME] ([LP_STUDENT_EMAIL]), You have completed the lesson  [LP_LESSON_NAME] at [LP_COURSE_LESSON_DATE] on website [SITE_URL], [BLOG_NAME]' );
		update_option( 'ets_eduma_discord_retry_failed_api', true );
		update_option( 'ets_eduma_discord_kick_upon_disconnect', false );
		update_option( 'ets_eduma_discord_retry_api_count', 5 );
		update_option( 'ets_eduma_discord_job_queue_concurrency', 1 );
		update_option( 'ets_eduma_discord_job_queue_batch_size', 6 );
		update_option( 'ets_eduma_discord_log_api_response', false );
		update_option( 'ets_eduma_discord_embed_messaging_feature', false );
		update_option( 'ets_eduma_discord_uuid_file_name', wp_generate_uuid4() );
		update_option( 'ets_eduma_discord_connect_button_bg_color', '#7bbc36' );
		update_option( 'ets_eduma_discord_disconnect_button_bg_color', '#ff0000' );
		update_option( 'ets_eduma_discord_loggedin_button_text', 'Connect With Discord' );
		update_option( 'ets_eduma_discord_non_login_button_text', 'Login With Discord' );
		update_option( 'ets_eduma_discord_disconnect_button_text', 'Disconnect From Discord' );
		update_option( 'ets_eduma_discord_allow_discord_login', false );

		/**
		 * PMPRO
		 */
		update_option( 'ets_eduma_pmpro_discord_payment_failed', true );
		update_option( 'ets_eduma_pmpro_allow_none_member', 'yes' );
		update_option( 'ets_eduma_pmpro_discord_send_welcome_dm', true );
		update_option( 'ets_eduma_pmpro_discord_welcome_message', 'Hi [MEMBER_USERNAME] ([MEMBER_EMAIL]), Welcome, Your membership [MEMBERSHIP_LEVEL] is starting from [MEMBERSHIP_STARTDATE] at [SITE_URL] the last date of your membership is [MEMBERSHIP_ENDDATE] Thanks, Kind Regards, [BLOG_NAME]' );
		update_option( 'ets_eduma_pmpro_discord_send_expiration_warning_dm', true );
		update_option( 'ets_eduma_pmpro_discord_expiration_warning_message', 'Hi [MEMBER_USERNAME] ([MEMBER_EMAIL]), Your membership [MEMBERSHIP_LEVEL] is expiring at [MEMBERSHIP_ENDDATE] at [SITE_URL] Thanks, Kind Regards, [BLOG_NAME]' );
		update_option( 'ets_eduma_pmpro_discord_send_membership_expired_dm', true );
		update_option( 'ets_eduma_pmpro_discord_expiration_expired_message', 'Hi [MEMBER_USERNAME] ([MEMBER_EMAIL]), Your membership [MEMBERSHIP_LEVEL] is expired at [MEMBERSHIP_ENDDATE] at [SITE_URL] Thanks, Kind Regards, [BLOG_NAME]' );
		update_option( 'ets_eduma_pmpro_discord_send_membership_cancel_dm', true );
		update_option( 'ets_eduma_pmpro_discord_cancel_message', 'Hi [MEMBER_USERNAME], ([MEMBER_EMAIL]), Your membership [MEMBERSHIP_LEVEL] at [BLOG_NAME] is cancelled, Regards, [SITE_URL]' );
		update_option( 'ets_eduma_pmpro_discord_embed_messaging_feature', false );
		update_option( 'ets_eduma_pmpro_member_kick_out', false );
		//update_option( 'ets_eduma_pmpro_discord_login_with_discord', false );
		update_option( 'ets_eduma_pmpro_discord_log_api_response', false );
		// update_option( 'ets_eduma_pmpro_discord_force_login_with_discord', false );
		update_option( 'ets_eduma_pmpro_discord_uuid_file_name', wp_generate_uuid4() );

		if ( Connect_Eduma_Theme_To_Discord::is_pmpro_active() ) {
			wp_schedule_event( time(), 'hourly', 'ets_eduma_pmpro_discord_schedule_expiration_warnings' );

		}
		update_option( 'ets_eduma_discord_cache_timeout', 1 );
		update_option( 'ets_eduma_discord_cache_timeout_interval', WEEK_IN_SECONDS );
		update_option( 'ets_eduma_discord_cache_expiration', 604800 );
	}

}
