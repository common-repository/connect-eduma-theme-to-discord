<?php

/**
 * Common functions file.
 */

/**
 * To check settings values saved or not.
 *
 * @return BOOL $status
 */
function eduma_discord_check_saved_settings_status() {
	$ets_eduma_discord_client_id     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_id' ) ) );
	$ets_eduma_discord_client_secret = sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_secret' ) ) );
	$ets_eduma_discord_bot_token     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
	$ets_eduma_discord_redirect_url  = sanitize_text_field( trim( get_option( 'ets_eduma_discord_redirect_url' ) ) );
	$ets_eduma_discord_server_id     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );

	if ( $ets_eduma_discord_client_id && $ets_eduma_discord_client_secret && $ets_eduma_discord_bot_token && $ets_eduma_discord_redirect_url && $ets_eduma_discord_server_id ) {
			$status = true;
	} else {
			$status = false;
	}

	return $status;
}

/**
 * Get current screen URL
 *
 * @return STRING $url
 */
function ets_eduma_discord_get_current_screen_url() {
	$parts       = parse_url( home_url() );
	$current_uri = "{$parts['scheme']}://{$parts['host']}" . ( isset( $parts['port'] ) ? ':' . $parts['port'] : '' ) . add_query_arg( null, null );

	return $current_uri;
}

/**
 * Get WP Pages list
 *
 * @param INT $ets_eduma__discord_redirect_page_id Page ID.
 * @return STRING $options
 */
function ets_eduma_discord_pages_list( $ets_eduma__discord_redirect_page_id ) {
	$args        = array(
		'sort_order'   => 'asc',
		'sort_column'  => 'post_title',
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'exclude_tree' => '',
		'number'       => '',
		'offset'       => 0,
		'post_type'    => 'page',
		'post_status'  => 'publish',
	);
	$eduma_pages = get_pages( $args );

	$options = '<option value="" disabled>-</option>';
	foreach ( $eduma_pages as $eduma_page ) {
		$selected = ( esc_attr( $eduma_page->ID ) === $ets_eduma__discord_redirect_page_id ) ? ' selected="selected"' : '';
		$options .= '<option data-page-url="' . ets_get_eduma_discord_formated_discord_redirect_url( $eduma_page->ID ) . '" value="' . esc_attr( $eduma_page->ID ) . '" ' . $selected . '> ' . $eduma_page->post_title . ' </option>';
	}
	return $options;
}
/**
 * Function to get formated redirect url.
 *
 * @param INT $page_id The page ID.
 * @return STRING $url Formatted URL.
 */
function ets_get_eduma_discord_formated_discord_redirect_url( $page_id ) {
	$url = esc_url( get_permalink( $page_id ) );

	$parsed = parse_url( $url, PHP_URL_QUERY );
	if ( $parsed === null ) {
		return $url .= '?via=connect-eduma-discord-addon';
	} else {
		if ( stristr( $url, 'via=connect-eduma-discord-addon' ) !== false ) {
			return $url;
		} else {
			return $url .= '&via=connect-eduma-discord-addon';
		}
	}
}

/**
 * Function to get formated redirect url for PMPRO
 *
 * @param INT $page_id The page ID.
 * @return STRING $url Formatted URL.
 */
function ets_get_eduma_pmpro_discord_formated_discord_redirect_url( $page_id ) {
	$url = esc_url( get_permalink( $page_id ) );

	$parsed = parse_url( $url, PHP_URL_QUERY );
	if ( $parsed === null ) {
		return $url .= '?via=connect-eduma-pmpro-discord-addon';
	} else {
		if ( stristr( $url, 'via=connect-eduma-pmpro-discord-addon' ) !== false ) {
			return $url;
		} else {
			return $url .= '&via=connect-eduma-pmpro-discord-addon';
		}
	}
}

/**
 * Get BOT name.
 */
function ets_eduma_discord_update_bot_name_option() {

	$guild_id          = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );
	$discord_bot_token = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
	if ( $guild_id && $discord_bot_token ) {

		$discod_current_user_api = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'users/@me';

		$app_args = array(
			'method'  => 'GET',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
		);

		$app_response = wp_remote_post( $discod_current_user_api, $app_args );

		$response_arr = json_decode( wp_remote_retrieve_body( $app_response ), true );

		if ( is_array( $response_arr ) && array_key_exists( 'username', $response_arr ) ) {

			update_option( 'ets_eduma_discord_connected_bot_name', $response_arr ['username'] );
		} else {
			delete_option( 'ets_eduma_discord_connected_bot_name' );
		}
	}

}

function ets_eduma_discord_roles_assigned_message( $mapped_role_name, $default_role_name, $restrictcontent_discord ) {

	if ( $mapped_role_name ) {
		$restrictcontent_discord .= '<p class="ets_assigned_role">';

		$restrictcontent_discord .= esc_html__( 'Following Roles will be assigned to you in Discord: ', 'connect-eduma-theme-to-discord' );
		$restrictcontent_discord .= $mapped_role_name;
		if ( $default_role_name ) {
			$restrictcontent_discord .= $default_role_name;

		}

		$restrictcontent_discord .= '</p>';
	} elseif ( $default_role_name ) {
		$restrictcontent_discord .= '<p class="ets_assigned_role">';

		$restrictcontent_discord .= esc_html__( 'Following Role will be assigned to you in Discord: ', 'connect-eduma-theme-to-discord' );
		$restrictcontent_discord .= $default_role_name;

		$restrictcontent_discord .= '</p>';

	}
	return $restrictcontent_discord;
}
/**
 * Get student's courses ids
 *
 * @param INT $user_id
 * @return ARRAY|NULL $curr_course_id
 */
function ets_eduma_discord_get_student_courses_id( $user_id = 0 ) {

	global $wpdb;
	$table_user_items = $wpdb->prefix . 'learnpress_user_items';

	$list_courses = $wpdb->prepare( "SELECT item_id FROM `$table_user_items` WHERE user_id = %d", $user_id );
	$user_courses = $wpdb->get_results( $list_courses, ARRAY_A );

	if ( is_array( $user_courses ) ) {
		$result = array();
		foreach ( $user_courses as $key => $course ) {
			array_push( $result, $course['item_id'] );
		}
		return $result;
	} else {
		return null;
	}

}

/**
 * Get allowed html using WordPress API function wp_kses
 *
 * @return ARRAY $allowed_html
 */
function ets_eduma_discord_allowed_html() {
	$allowed_html = array(
		'div'    => array(
			'class' => array(),
		),
		'p'      => array(
			'class' => array(),
		),
		'a'      => array(
			'id'           => array(),
			'data-user-id' => array(),
			'href'         => array(),
			'class'        => array(),
			'style'        => array(),
		),
		'label'  => array(
			'class' => array(),
		),
		'h3'     => array(),
		'span'   => array(
			'class' => array(),
		),
		'i'      => array(
			'style' => array(),
			'class' => array(),
		),
		'button' => array(
			'class'        => array(),
			'data-user-id' => array(),
			'id'           => array(),
		),
		'style'  => array(),
		'img'    => array(
			'src'   => array(),
			'class' => array(),
		),
		'b'      => array(),
	);

	return $allowed_html;
}

/**
 * Get the highest available last attempt schedule time
 */

function ets_eduma_discord_get_highest_last_attempt_timestamp() {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.last_attempt_gmt FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id = ag.group_id WHERE ag.slug = %s ORDER BY aa.last_attempt_gmt DESC limit 1', CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return strtotime( $result['0']['last_attempt_gmt'] );
	} else {
		return false;
	}
}

/**
 * Get randon integer between a predefined range.
 *
 * @param INT $add_upon
 */
function ets_eduma_discord_get_random_timestamp( $add_upon = '' ) {
	if ( $add_upon != '' && $add_upon !== false ) {
		return $add_upon + random_int( 5, 15 );
	} else {
		return strtotime( 'now' ) + random_int( 5, 15 );
	}
}

/**
 * Get Action data from table `actionscheduler_actions`
 *
 * @param INT $action_id
 */
function ets_eduma_discord_as_get_action_data( $action_id ) {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.hook, aa.status, aa.args, ag.slug AS as_group FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id=ag.group_id WHERE `action_id`=%d AND ag.slug=%s', $action_id, CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME ), ARRAY_A );
	if ( ! empty( $result ) ) {
		return $result[0];
	} else {
		return false;
	}
}

/**
 * Get how many times a hook is failed in a particular day.
 *
 * @param STRING $hook
 */
function ets_eduma_discord_count_of_hooks_failures( $hook ) {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT count(last_attempt_gmt) as hook_failed_count FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE `hook`=%s AND status="failed" AND DATE(last_attempt_gmt) = %s', $hook, date( 'Y-m-d' ) ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result['0']['hook_failed_count'];
	} else {
		return false;
	}
}

/**
 * Get pending jobs
 */
function ets_eduma_discord_get_all_pending_actions() {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.* FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id = ag.group_id WHERE ag.slug = %s AND aa.status="pending" ', CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result['0'];
	} else {
		return false;
	}
}

/**
 * Get All failed actions from action scheduler.
 */
function ets_eduma_discord_get_all_failed_actions() {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.action_id, aa.hook, ag.slug AS as_group FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id=ag.group_id WHERE  ag.slug=%s AND aa.status = "failed" ', CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result;
	} else {
		return false;
	}
}

/**
 * Check API call response and detect conditions which can cause of action failure and retry should be attemped.
 *
 * @param ARRAY|OBJECT $api_response
 * @param BOOLEAN
 */
function ets_eduma_discord_check_api_errors( $api_response ) {
	// check if response code is a WordPress error.
	if ( is_wp_error( $api_response ) ) {
		return true;
	}

	// First Check if response contain codes which should not get re-try.
	$body = json_decode( wp_remote_retrieve_body( $api_response ), true );
	if ( isset( $body['code'] ) && in_array( $body['code'], CONNECT_EDUMA_THEME_DISCORD_DONOT_RETRY_THESE_API_CODES ) ) {
		return false;
	}

	$response_code = strval( $api_response['response']['code'] );
	if ( isset( $api_response['response']['code'] ) && in_array( $response_code, CONNECT_EDUMA_THEME_DISCORD_DONOT_RETRY_HTTP_CODES ) ) {
		return false;
	}

	// check if response code is in the range of HTTP error.
	if ( ( 400 <= absint( $response_code ) ) && ( absint( $response_code ) <= 599 ) ) {
		return true;
	}
}

/**
 *  Log API call response
 *
 * @param INT          $user_id
 * @param STRING       $api_url
 * @param ARRAY        $api_args
 * @param ARRAY|OBJECT $api_response
 */
function ets_eduma_discord_log_api_response( $user_id, $api_url = '', $api_args = array(), $api_response = '' ) {
	$log_api_response = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_discord_log_api_response' ) ) );
	if ( $log_api_response === true ) {
		$log_string  = '==>' . $api_url;
		$log_string .= '-::-' . serialize( $api_args );
		$log_string .= '-::-' . serialize( $api_response );

		// $logs = new Eduma_Discord_Add_On_Logs();
		// $logs->write_api_response_logs( $log_string, $user_id );
	}
}

/**
 *  Log API call response
 *
 * @param INT          $user_id
 * @param STRING       $api_url
 * @param ARRAY        $api_args
 * @param ARRAY|OBJECT $api_response
 */
function ets_eduma_pmpro_discord_log_api_response( $user_id, $api_url = '', $api_args = array(), $api_response = '' ) {
	$log_api_response = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_log_api_response' ) ) );
	if ( $log_api_response === true ) {
		$log_string  = '==>' . $api_url;
		$log_string .= '-::-' . serialize( $api_args );
		$log_string .= '-::-' . serialize( $api_response );

		$logs = new Connect_Eduma_Theme_To_Discord_Logs_PMPRO();
		$logs->write_api_response_logs( $log_string, $user_id );
	}
}

/**
 * Get rich embed message
 *
 * @param STRING $message
 * @return STRING $rich_embed_message
 */

function ets_eduma_discord_get_rich_embed_message( $message ) {

	if ( is_array( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) ) ) {
		$blog_logo_full = esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] );
	} else {
		$blog_logo_full = '';
	}
	if ( is_array( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'thumbnail' ) ) ) {
		$blog_logo_thumbnail = esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'thumbnail' )[0] );
	} else {
		$blog_logo_thumbnail = '';
	}

	$SITE_URL         = get_bloginfo( 'url' );
	$BLOG_NAME        = get_bloginfo( 'name' );
	$BLOG_DESCRIPTION = get_bloginfo( 'description' );

	$timestamp     = date( 'c', strtotime( 'now' ) );
	$convert_lines = preg_split( '/\[LINEBREAK\]/', $message );
	$fields        = array();
	if ( is_array( $convert_lines ) ) {
		for ( $i = 0; $i < count( $convert_lines ); $i++ ) {
			array_push(
				$fields,
				array(
					'name'   => '.',
					'value'  => $convert_lines[ $i ],
					'inline' => false,
				)
			);
		}
	}

	$rich_embed_message = json_encode(
		array(
			'content'    => '',
			'username'   => $BLOG_NAME,
			'avatar_url' => $blog_logo_thumbnail,
			'tts'        => false,
			'embeds'     => array(
				array(
					'title'       => '',
					'type'        => 'rich',
					'description' => $BLOG_DESCRIPTION,
					'url'         => '',
					'timestamp'   => $timestamp,
					'color'       => hexdec( '3366ff' ),
					'footer'      => array(
						'text'     => $BLOG_NAME,
						'icon_url' => $blog_logo_thumbnail,
					),
					'image'       => array(
						'url' => $blog_logo_full,
					),
					'thumbnail'   => array(
						'url' => $blog_logo_thumbnail,
					),
					'author'      => array(
						'name' => $BLOG_NAME,
						'url'  => $SITE_URL,
					),
					'fields'      => $fields,

				),
			),

		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	);

	return $rich_embed_message;
}

/**
 * Get formatted message to send in DM
 *
 * @param INT   $user_id
 * @param ARRAY $courses the student's list of sources
 * Merge fields: [LP_COURSES], [LP_STUDENT_NAME], [LP_STUDENT_EMAIL]
 */
function ets_eduma_discord_get_formatted_dm( $user_id, $courses, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$COURSES = '';
	if ( is_array( $courses ) ) {
		$args_courses     = array(
			'orderby'     => 'title',
			'order'       => 'ASC',
			'numberposts' => count( $courses ),
			'post_type'   => 'lp_course',
			'post__in'    => $courses,
		);
		$enrolled_courses = get_posts( $args_courses );
		$lastKeyCourse    = array_key_last( $enrolled_courses );
		$commas           = ', ';
		foreach ( $enrolled_courses as $key => $course ) {
			if ( $lastKeyCourse === $key ) {
				$commas = ' ';
			}
			$COURSES .= esc_html( $course->post_title ) . $commas;
		}
	}

		$find    = array(
			'[LP_COURSES]',
			'[LP_STUDENT_NAME]',
			'[LP_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$COURSES,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );

}

/**
 * Get student's roles ids
 *
 * @param INT $user_id
 * @return ARRAY|NULL $roles
 */
function ets_eduma_discord_get_user_roles( $user_id ) {
	global $wpdb;

	$usermeta_table     = $wpdb->prefix . 'usermeta';
	$user_roles_sql     = 'SELECT * FROM ' . $usermeta_table . " WHERE `user_id` = %d AND ( `meta_key` like '_ets_eduma_discord_role_id_for_%' OR `meta_key` = 'ets_eduma_discord_default_role_id' OR `meta_key` = '_ets_eduma_discord_last_default_role' ); ";
	$user_roles_prepare = $wpdb->prepare( $user_roles_sql, $user_id );

	$user_roles = $wpdb->get_results( $user_roles_prepare, ARRAY_A );

	if ( is_array( $user_roles ) && count( $user_roles ) ) {
		$roles = array();
		foreach ( $user_roles as  $role ) {

			array_push( $roles, $role['meta_value'] );
		}

				return $roles;

	} else {

		return null;
	}

}

/**
 * Remove User's data
 *
 * @param INT @user_id User ID
 */
function ets_eduma_discord_remove_usermeta( $user_id ) {

	global $wpdb;

	$usermeta_table      = $wpdb->prefix . 'usermeta';
	$usermeta_sql        = 'DELETE FROM ' . $usermeta_table . " WHERE `user_id` = %d AND  `meta_key` LIKE '_ets_eduma_discord%'; ";
	$delete_usermeta_sql = $wpdb->prepare( $usermeta_sql, $user_id );
	$wpdb->query( $delete_usermeta_sql );

}

/**
 * Check if PMPRO is active and return roles mapping UI.
 *
 * @return string|void
 */
function ets_eduma_discord_pmpro_levels_mapping() {

	if ( ! function_exists( 'pmpro_getAllLevels' ) ) {
		return;
	}

	$pmpro_levels = pmpro_getAllLevels( true, true );
	?>
	<hr>
	<h3><?php esc_html_e( 'PMPRO Roles Mapping', 'connect-eduma-theme-to-discord' ); ?></h3>
<h4><?php esc_html_e( 'Define the role for each Membership.', 'connect-eduma-theme-to-discord' ); ?></h4>
<div class="notice notice-warning ets-notice">
	<p><i class='fas fa-info'></i> <?php esc_html_e( 'Drag and Drop the Discord Roles over to the Pmpro Levels', 'connect-eduma-theme-to-discord' ); ?></p>
</div>
<div class="notice notice-warning ets-notice">
	<p><i class='fas fa-info'></i> <?php esc_html_e( 'Note: Inactive memberships will not display', 'connect-eduma-theme-to-discord' ); ?></p>
</div>
<div class="row-container">
	<div class="ets-column eduma-pmpro-levels-discord-roles-col">
		<h2><?php esc_html_e( 'Discord Roles', 'connect-eduma-theme-to-discord' ); ?></h2>
		<hr>
		<div class="eduma-pmpro-levels-discord-roles">
			<span class="spinner"></span>
		</div>
	</div>
	<div class="ets-column">
		<h2><?php esc_html_e( 'Pmpro Memberships', 'connect-eduma-theme-to-discord' ); ?></h2>
		<hr>
		<div class="pmpro-levels">
			<?php
			foreach ( array_reverse( $pmpro_levels ) as $key => $value ) {
				?>
				<div class="makePmproDroppable" data-pmpro_level_id="<?php echo esc_attr( $value->id ); ?>" ><span><?php echo esc_html( $value->name ); ?></span></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
	<?php
}

/**
 * Get formatted Course complete message to send in DM
 *
 * @param INT $user_id
 * @param INT $course_id
 * Merge fields: [LP_COURSE_NAME], [LP_COURSE_COMPLETE_DATE], [LP_STUDENT_NAME], [LP_STUDENT_EMAIL], [SITE_URL], [BLOG_NAME]
 */
function ets_eduma_discord_get_formatted_course_complete_dm( $user_id, $course_id, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$course      = get_post( $course_id );
	$COURSE_NAME = sanitize_text_field( $course->post_title );

	$COURSE_COMPLETE_DATE = date_i18n( get_option( 'date_format' ), time() );

		$find    = array(
			'[LP_COURSE_NAME]',
			'[LP_COURSE_COMPLETE_DATE]',
			'[LP_STUDENT_NAME]',
			'[LP_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$COURSE_NAME,
			$COURSE_COMPLETE_DATE,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );

}

/**
 * Get formatted Lesson complete message to send in DM
 *
 * @param INT $user_id
 * @param INT $lesson_id
 * Merge fields: [LP_LESSON_NAME],[LP_COURSE_LESSON_DATE], [LP_STUDENT_NAME], [LP_STUDENT_EMAIL], [SITE_URL], [BLOG_NAME]
 */
function ets_eduma_discord_get_formatted_lesson_complete_dm( $user_id, $lesson_id, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$lesson      = get_post( $lesson_id );
	$LESSON_NAME = sanitize_text_field( $lesson->post_title );

	$LESSON_COMPLETE_DATE = date_i18n( get_option( 'date_format' ), time() );

		$find    = array(
			'[LP_LESSON_NAME]',
			'[LP_COURSE_LESSON_DATE]',
			'[LP_STUDENT_NAME]',
			'[LP_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$LESSON_NAME,
			$LESSON_COMPLETE_DATE,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );

}

/**
 * Get student's roles ids
 *
 * @param INT $user_id
 * @return ARRAY|NULL $roles
 */
function ets_eduma_learnpress_discord_get_user_roles( $user_id ) {
	global $wpdb;

	$usermeta_table     = $wpdb->prefix . 'usermeta';
	$user_roles_sql     = 'SELECT * FROM ' . $usermeta_table . " WHERE `user_id` = %d AND ( `meta_key` like '_ets_eduma_discord_role_id_for_%' OR `meta_key` = '_ets_eduma_discord_last_default_role' OR `meta_key` = '_ets_eduma_discord_last_default_role' ); ";
	$user_roles_prepare = $wpdb->prepare( $user_roles_sql, $user_id );

	$user_roles = $wpdb->get_results( $user_roles_prepare, ARRAY_A );

	if ( is_array( $user_roles ) && count( $user_roles ) ) {
		$roles = array();
		foreach ( $user_roles as  $role ) {

			array_push( $roles, $role['meta_value'] );
		}

				return $roles;

	} else {

		return null;
	}

}
/**
 * Get the discord user avatar
 *
 * @param INT    $discord_user_id The discord user ID.
 * @param INT    $user_avatar The user avatar number.
 * @param STRING $restrictcontent_discord The html to return.
 *
 * @return STRING
 */
function ets_eduma_discord_get_user_avatar( $discord_user_id, $user_avatar, $restrictcontent_discord = '' ) {
	if ( $user_avatar ) {
		$avatar_url = '<img class="ets-eduma-discord-avatar" src="https://cdn.discordapp.com/avatars/' . $discord_user_id . '/' . $user_avatar . '.png" />';
		if ( $restrictcontent_discord != '' ) {
			$restrictcontent_discord .= $avatar_url;
			return $restrictcontent_discord;
		} else {
			return $avatar_url;
		}
	} else {
		return $restrictcontent_discord;
	}
}

/**
 * Get steps.
 *
 * @return array
 */
function ets_eduma_discord_get_steps() {
	$steps   = array();
	$steps[] = array(
		'key'   => 'welcome',
		'title' => esc_html__( 'Welcome', 'connect-eduma-theme-to-discord' ),
	);

		$steps[] = array(
			'key'   => 'setup',
			'title' => esc_html__( 'Setup', 'connect-eduma-theme-to-discord' ),
		);

		$steps[] = array(
			'key'   => 'role-mappings',
			'title' => esc_html__( 'Role Mappings', 'connect-eduma-theme-to-discord' ),
		);

		$steps[] = array(
			'key'   => 'settings',
			'title' => esc_html__( 'Settings', 'connect-eduma-theme-to-discord' ),
		);

		$steps[] = array(
			'key'   => 'appearance',
			'title' => esc_html__( 'Appearance', 'connect-eduma-theme-to-discord' ),
		);

		// $steps[] = array(
		// 'key'   => 'logs',
		// 'title' => esc_html__( 'Logs', 'connect-eduma-theme-to-discord' ),
		// );

		return $steps;
}
