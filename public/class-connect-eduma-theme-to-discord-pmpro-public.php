<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Connect_Eduma_Theme_To_Discord
 * @subpackage Connect_Eduma_Theme_To_Discord/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Connect_Eduma_Theme_To_Discord
 * @subpackage Connect_Eduma_Theme_To_Discord/public
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Connect_Eduma_Theme_To_Discord_Pmpro_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Connect_Eduma_Theme_To_Discord_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Connect_Eduma_Theme_To_Discord_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$min_css = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min';
		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/connect-eduma-theme-to-discord-public' . $min_css . '.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Connect_Eduma_Theme_To_Discord_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Connect_Eduma_Theme_To_Discord_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name . '-pmpro-public', plugin_dir_url( __FILE__ ) . 'js/connect-eduma-theme-to-discord-pmpro-public.js', array( 'jquery' ), $this->version, false );
		$script_params = array(
			'admin_ajax'                    => admin_url( 'admin-ajax.php' ),
			'permissions_const'             => CONNECT_EDUMA_THEME_DISCORD_BOT_PERMISSIONS,
			'is_admin'                      => is_admin(),
			'ets_eduma_pmpro_discord_nonce' => wp_create_nonce( 'ets-eduma-pmpro-discord-ajax-nonce' ),
		);
		wp_localize_script( $this->plugin_name . '-pmpro-public', 'etsEdumaPmproParams', $script_params );

	}

	/**
	 * Add button to make connection in between user and discord.
	 */
	public function ets_eduma_pmpro_discord_add_connect_discord_button() {

		wp_enqueue_style( $this->plugin_name );
		wp_enqueue_script( $this->plugin_name . '-pmpro-public' );

		$user_id = sanitize_text_field( trim( get_current_user_id() ) );

		$access_token = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true ) ) );

		$default_role                                 = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_default_role_id' ) ) );
		$ets_eduma_pmpro_discord_role_mapping         = json_decode( get_option( 'ets_eduma_pmpro_discord_role_mapping' ), true );
		$all_roles                                    = unserialize( get_option( 'ets_eduma_discord_all_roles' ) );
		$roles_color                                  = unserialize( get_option( 'ets_eduma_discord_roles_color' ) );
		$ets_eduma_discord_connect_button_bg_color    = sanitize_text_field( trim( get_option( 'ets_eduma_discord_connect_button_bg_color' ) ) );
		$ets_eduma_discord_disconnect_button_bg_color = sanitize_text_field( trim( get_option( 'ets_eduma_discord_disconnect_button_bg_color' ) ) );
		$ets_eduma_discord_disconnect_button_text     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_disconnect_button_text' ) ) );
		$ets_eduma_discord_loggedin_button_text       = sanitize_text_field( trim( get_option( 'ets_eduma_discord_loggedin_button_text' ) ) );
		$pmpro_allow_none_member                      = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_allow_none_member' ) ) );

		if ( isset( $_GET['level'] ) && $_GET['level'] > 0 ) {
			$curr_level_id = filter_input( INPUT_GET, $_GET['level'] );
		} else {
			$curr_level_id = ets_eduma_pmpro_discord_get_current_level_id( $user_id );
		}

		$mapped_role_name = '';
		if ( $curr_level_id && is_array( $all_roles ) ) {
			if ( is_array( $ets_eduma_pmpro_discord_role_mapping ) && array_key_exists( 'pmpro_level_id_' . $curr_level_id, $ets_eduma_pmpro_discord_role_mapping ) ) {
				$mapped_role_id = $ets_eduma_pmpro_discord_role_mapping[ 'pmpro_level_id_' . $curr_level_id ];
				if ( array_key_exists( $mapped_role_id, $all_roles ) ) {
					$mapped_role_name = '<span> <i style="background-color:#' . dechex( $roles_color[ $mapped_role_id ] ) . '"></i>' . $all_roles[ $mapped_role_id ] . '</span>';
				}
			}
		}
		$default_role_name = '';
		if ( $default_role != 'none' && is_array( $all_roles ) && array_key_exists( $default_role, $all_roles ) ) {
			$default_role_name = '<span> <i style="background-color:#' . dechex( $roles_color[ $default_role ] ) . '"></i>' . $all_roles[ $default_role ] . '</span>';
		}
		$pmpro_connecttodiscord_btn = '';
		if ( eduma_discord_check_saved_settings_status() ) {
			if ( $access_token ) {
				$discord_username        = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_username', true ) ) );
				$discord_user_id         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
				$discord_user_avatar     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_avatar', true ) ) );
				$disconnect_btn_bg_color = 'style="background-color:' . $ets_eduma_discord_disconnect_button_bg_color . '"';

				$pmpro_connecttodiscord_btn     .= '<div class="connect-eduma-pmpro-theme-to-discord">';
				$pmpro_connecttodiscord_btn     .= '<div class="ets_pmpro_discord_title">';
				$pmpro_connecttodiscord_btn     .=
					'<i class="fab fa-discord"></i><label class="ets-pmpro-connection-lbl">' .
					esc_html__(
						'Discord Connection',
						'connect-eduma-theme-to-discord'
					) .
					'</label>';
				$pmpro_connecttodiscord_btn     .= '</div>';
				$pmpro_connecttodiscord_btn     .= '<div class="">';
				$pmpro_connecttodiscord_btn     .=
					'<a href="' . ets_eduma_discord_get_current_screen_url() . '/?disconnect=eduma-pmpro-disconnect" class="ets-btn connect-eduma-theme-discord-btn-disconnect" ' .
					$disconnect_btn_bg_color .
					' data-user-id="' .
					esc_attr( $user_id ) .
					'">' .
					esc_html__( $ets_eduma_discord_disconnect_button_text ) .
					'</a>';
					$pmpro_connecttodiscord_btn .= '<span class="ets-spinner"></span>';
				$pmpro_connecttodiscord_btn     .=
					'<p class="ets-connected-account">' .
					ets_eduma_discord_get_user_avatar( $discord_user_id, $discord_user_avatar, '' ) .
					esc_html__(
						sprintf(
							'Connected account: %s',
							$discord_username
						),
						'connect-eduma-theme-to-discord'
					) .
					'</p>';

				$pmpro_connecttodiscord_btn  = ets_eduma_discord_roles_assigned_message(
					$mapped_role_name,
					$default_role_name,
					$pmpro_connecttodiscord_btn
				);
				$pmpro_connecttodiscord_btn .= '</div>';
				$pmpro_connecttodiscord_btn .= '</div>';
			} elseif ( pmpro_hasMembershipLevel() || $pmpro_allow_none_member === 'yes' ) {

				$current_url                 = ets_eduma_discord_get_current_screen_url();
				$pmpro_connecttodiscord_btn .= '<style>.pmpro-btn-connect{background-color: ' . $ets_eduma_discord_connect_button_bg_color . ';}</style><div><label class="ets-connection-lbl">' . esc_html__( 'Discord connection', 'connect-eduma-theme-to-discord' ) . '</label>';
				$pmpro_connecttodiscord_btn .= '<a href="?action=eduma-pmpro-discord-login" class="pmpro-btn-connect ets-btn" >' . esc_html( $ets_eduma_discord_loggedin_button_text ) . '<i class="fab fa-discord"></i></a>';
				$pmpro_connecttodiscord_btn .= '<p class="ets_assigned_role">';
				if ( $mapped_role_name || $default_role_name ) {
					$pmpro_connecttodiscord_btn .= esc_html__( 'Following Roles will be assigned to you in Discord: ', 'connect-eduma-theme-to-discord' );
				}
				if ( $mapped_role_name ) {
					$pmpro_connecttodiscord_btn .= $mapped_role_name;
				}

				if ( $default_role_name && $mapped_role_name ) {
					// $pmpro_connecttodiscord_btn .= ' , ';
				}
				if ( $default_role_name ) {
					$pmpro_connecttodiscord_btn .= $default_role_name;
				}
				$pmpro_connecttodiscord_btn .= '</p></div>';

			}
		}
		return wp_kses( $pmpro_connecttodiscord_btn, ets_eduma_discord_allowed_html() );

	}

	/**
	 * Display Discord connect button.
	 */
	public function ets_eduma_pmpro_display_discord_button() {
		echo do_shortcode( '[ets_eduma_pmpro_discord]' );
	}

	/**
	 * Discord API Callback
	 */
	public function ets_eduma_pmpro_discord_api_callback() {
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			if ( isset( $_GET['action'] ) && $_GET['action'] === 'eduma-pmpro-discord-login' ) {
				$params                    = array(
					'client_id'     => sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_id' ) ) ),
					'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_redirect_url' ) ) ),
					'response_type' => 'code',
					'scope'         => 'identify email connections guilds guilds.join',
				);
				$discord_authorise_api_url = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );

				wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
				exit();
			}

			if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) && $_GET['via'] === 'connect-eduma-pmpro-discord-addon' ) {
				$code     = sanitize_text_field( trim( $_GET['code'] ) );
				$response = $this->create_discord_auth_token( $code, $user_id );
				if ( ! empty( $response ) && ! is_wp_error( $response ) ) {
					$res_body              = json_decode( wp_remote_retrieve_body( $response ), true );
					$discord_exist_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
					if ( is_array( $res_body ) ) {
						if ( array_key_exists( 'access_token', $res_body ) ) {
							$access_token = sanitize_text_field( trim( $res_body['access_token'] ) );
							update_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', $access_token );
							if ( array_key_exists( 'refresh_token', $res_body ) ) {
								$refresh_token = sanitize_text_field( trim( $res_body['refresh_token'] ) );
								update_user_meta( $user_id, '_ets_eduma_pmpro_discord_refresh_token', $refresh_token );
							}
							if ( array_key_exists( 'expires_in', $res_body ) ) {
								$expires_in = $res_body['expires_in'];
								$date       = new DateTime();
								$date->add(
									DateInterval::createFromDateString(
										'' . $expires_in . ' seconds'
									)
								);
								$token_expiry_time = $date->getTimestamp();
								update_user_meta( $user_id, '_ets_eduma_pmpro_discord_expires_in', $token_expiry_time );
							}
							$user_body = $this->get_discord_current_user( $access_token );

							if ( is_array( $user_body ) && array_key_exists( 'discriminator', $user_body ) ) {
								$discord_user_number           = $user_body['discriminator'];
								$discord_user_name             = $user_body['username'];
								$discord_user_avatar           = $user_body['avatar'];
								$discord_user_name_with_number = $discord_user_name . '#' . $discord_user_number;
								update_user_meta( $user_id, '_ets_eduma_pmpro_discord_username', $discord_user_name_with_number );
								update_user_meta( $user_id, '_ets_eduma_pmpro_discord_avatar', $discord_user_avatar );
							}
							if ( is_array( $user_body ) && array_key_exists( 'id', $user_body ) ) {
								$_ets_eduma_pmpro_discord_user_id = sanitize_text_field( trim( $user_body['id'] ) );
								if ( $discord_exist_user_id === $_ets_eduma_pmpro_discord_user_id && pmpro_hasMembershipLevel() ) {

									// If member has already levels

								}
								update_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', $_ets_eduma_pmpro_discord_user_id );
								$this->add_discord_member_in_guild( $_ets_eduma_pmpro_discord_user_id, $user_id, $access_token );
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Create authentication token for discord API
	 *
	 * @param STRING $code
	 * @param INT    $user_id
	 * @return OBJECT API response
	 */
	public function create_discord_auth_token( $code, $user_id ) {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();

		}
		// stop users who having the direct URL of discord Oauth.
		// We must check IF NONE Student is set to NO and user having no Eduma account.
		$allow_none_member = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_allow_none_member' ) ) );

		// if ( pmpro_hasMembershipLevel() === false && $allow_none_member == 'no' ) {
		// return;
		// }
		$response              = '';
		$refresh_token         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_refresh_token', true ) ) );
		$token_expiry_time     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_expires_in', true ) ) );
		$discord_token_api_url = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'oauth2/token';
		if ( $refresh_token ) {
			$date              = new DateTime();
			$current_timestamp = $date->getTimestamp();
			if ( $current_timestamp > $token_expiry_time ) {
				$args     = array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type' => 'application/x-www-form-urlencoded',
					),
					'body'    => array(
						'client_id'     => sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_id' ) ) ),
						'client_secret' => sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_secret' ) ) ),
						'grant_type'    => 'refresh_token',
						'refresh_token' => $refresh_token,
						'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_redirect_url' ) ) ),
						'scope'         => CONNECT_EDUMA_THEME_DISCORD_OAUTH_SCOPES,
					),
				);
				$response = wp_remote_post( $discord_token_api_url, $args );
				ets_eduma_pmpro_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
				if ( ets_eduma_discord_check_api_errors( $response ) ) {
					$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
					Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				}
			}
		} else {
			$args     = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
				'body'    => array(
					'client_id'     => sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_id' ) ) ),
					'client_secret' => sanitize_text_field( trim( get_option( 'ets_eduma_discord_client_secret' ) ) ),
					'grant_type'    => 'authorization_code',
					'code'          => $code,
					'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_redirect_url' ) ) ),
					'scope'         => CONNECT_EDUMA_THEME_DISCORD_OAUTH_SCOPES,
				),
			);
			$response = wp_remote_post( $discord_token_api_url, $args );
			ets_eduma_pmpro_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
			if ( ets_eduma_discord_check_api_errors( $response ) ) {
				$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			}
		}
		return $response;
	}

	/**
	 * Get Discord user details from API
	 *
	 * @param STRING $access_token
	 * @param INIT   $new_eduma_student
	 * @return OBJECT REST API response
	 */
	public function get_discord_current_user( $access_token, $new_eduma_student = '' ) {
		if ( ! is_user_logged_in() && $new_eduma_student === '' ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		$user_id = get_current_user_id();

		$discord_cuser_api_url = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);
		$user_response         = wp_remote_get( $discord_cuser_api_url, $param );
		ets_eduma_pmpro_discord_log_api_response( $user_id, $discord_cuser_api_url, $param, $user_response );

		$response_arr = json_decode( wp_remote_retrieve_body( $user_response ), true );
		// Eduma_Discord_Add_On_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
		$user_body = json_decode( wp_remote_retrieve_body( $user_response ), true );
		return $user_body;

	}

	/**
	 * Add new member into discord guild
	 *
	 * @param INT    $_ets_eduma_pmpro_discord_user_id
	 * @param INT    $user_id
	 * @param STRING $access_token
	 * @return NONE
	 */
	private function add_discord_member_in_guild( $_ets_eduma_pmpro_discord_user_id, $user_id, $access_token ) {
		$curr_level_id = sanitize_text_field( trim( ets_eduma_pmpro_discord_get_current_level_id( $user_id ) ) );
		if ( $curr_level_id !== null ) {
			as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_handle_add_member_to_guild', array( $_ets_eduma_pmpro_discord_user_id, $user_id, $access_token ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
		}
	}

	/**
	 * Method to add new members to discord guild.
	 *
	 * @param INT    $_ets_eduma_pmpro_discord_user_id
	 * @param INT    $user_id
	 * @param STRING $access_token
	 * @return NONE
	 */
	public function ets_eduma_pmpro_discord_as_handler_add_member_to_guild( $_ets_eduma_pmpro_discord_user_id, $user_id, $access_token ) {
		// Member is delete from DB.
		if ( get_userdata( $user_id ) === false ) {
			return;
		}

		$server_id                               = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );
		$discord_bot_token                       = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
		$default_role                            = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_default_role_id' ) ) );
		$ets_eduma_pmpro_discord_role_mapping    = json_decode( get_option( 'ets_eduma_pmpro_discord_role_mapping' ), true );
		$discord_role                            = '';
		$curr_level_id                           = sanitize_text_field( trim( ets_eduma_pmpro_discord_get_current_level_id( $user_id ) ) );
		$ets_eduma_pmpro_discord_welcome_message = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_welcome_message' ) ) );
		$ets_eduma_pmpro_discord_send_welcome_dm = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_welcome_dm' ) ) );

		if ( is_array( $ets_eduma_pmpro_discord_role_mapping ) && array_key_exists( 'pmpro_level_id_' . $curr_level_id, $ets_eduma_pmpro_discord_role_mapping ) ) {
			$discord_role = sanitize_text_field( trim( $ets_eduma_pmpro_discord_role_mapping[ 'pmpro_level_id_' . $curr_level_id ] ) );
		} elseif ( $discord_role = '' && $default_role ) {
			$discord_role = $default_role;
		}

		$guilds_memeber_api_url = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'guilds/' . $server_id . '/members/' . $_ets_eduma_pmpro_discord_user_id;
		$guild_args             = array(
			'method'  => 'PUT',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => json_encode(
				array(
					'access_token' => $access_token,
					'roles'        => array(
						$discord_role,
					),
				)
			),
		);
		$guild_response         = wp_remote_post( $guilds_memeber_api_url, $guild_args );

		ets_eduma_pmpro_discord_log_api_response( $user_id, $guilds_memeber_api_url, $guild_args, $guild_response );
		if ( ets_eduma_discord_check_api_errors( $guild_response ) ) {

			$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
			Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			// this should be catch by Action schedule failed action.
			throw new Exception( 'Failed in function ets_eduma_pmpro_discord_as_handler_add_member_to_guild' );
		}

		update_user_meta( $user_id, '_ets_eduma_pmpro_discord_role_id', $discord_role );
		if ( $discord_role && $discord_role != 'none' && isset( $user_id ) ) {
			$this->put_discord_role_api( $user_id, $discord_role );
		}

		if ( $default_role && $default_role != 'none' && isset( $user_id ) ) {
			$this->put_discord_role_api( $user_id, $default_role );
			update_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', $default_role );
		}
		if ( empty( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_join_date', true ) ) ) {
			update_user_meta( $user_id, '_ets_eduma_pmpro_discord_join_date', current_time( 'Y-m-d H:i:s' ) );
		}

		// Send welcome message.
		if ( $ets_eduma_pmpro_discord_send_welcome_dm === true ) {
			as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_send_dm', array( $user_id, $curr_level_id, 'welcome' ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
		}
	}

	/**
	 * API call to change discord user role
	 *
	 * @param INT  $user_id
	 * @param INT  $role_id
	 * @param BOOL $is_schedule
	 * @return object API response
	 */
	public function put_discord_role_api( $user_id, $role_id, $is_schedule = true ) {
		if ( $is_schedule ) {
			as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_schedule_member_put_role', array( $user_id, $role_id, $is_schedule ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
		} else {
			$this->ets_eduma_pmpro_discord_as_handler_put_memberrole( $user_id, $role_id, $is_schedule );
		}
	}

	/**
	 * Action Schedule handler for mmeber change role discord.
	 *
	 * @param INT  $user_id
	 * @param INT  $role_id
	 * @param BOOL $is_schedule
	 * @return object API response
	 */
	public function ets_eduma_pmpro_discord_as_handler_put_memberrole( $user_id, $role_id, $is_schedule ) {
		$access_token                     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true ) ) );
		$server_id                        = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );
		$_ets_eduma_pmpro_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
		$discord_bot_token                = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
		$discord_change_role_api_url      = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'guilds/' . $server_id . '/members/' . $_ets_eduma_pmpro_discord_user_id . '/roles/' . $role_id;

		if ( $access_token && $_ets_eduma_pmpro_discord_user_id ) {
			$param = array(
				'method'  => 'PUT',
				'headers' => array(
					'Content-Type'   => 'application/json',
					'Authorization'  => 'Bot ' . $discord_bot_token,
					'Content-Length' => 0,
				),
			);

			$response = wp_remote_get( $discord_change_role_api_url, $param );

			ets_eduma_pmpro_discord_log_api_response( $user_id, $discord_change_role_api_url, $param, $response );
			if ( ets_eduma_discord_check_api_errors( $response ) ) {
				$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				if ( $is_schedule ) {
					// this exception should be catch by action scheduler.
					throw new Exception( 'Failed in function ets_eduma_pmpro_discord_as_handler_put_memberrole' );
				}
			}
		}
	}

	/**
	 * Discord DM a member using bot.
	 *
	 * @param INT    $user_id
	 * @param STRING $type (warning|expired)
	 */
	public function ets_eduma_pmpro_discord_handler_send_dm( $user_id, $membership_level_id, $type = 'warning' ) {
		$discord_user_id                                    = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
		$discord_bot_token                                  = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
		$ets_eduma_pmpro_discord_expiration_warning_message = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_expiration_warning_message' ) ) );
		$ets_eduma_pmpro_discord_expiration_expired_message = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_expiration_expired_message' ) ) );
		$ets_eduma_pmpro_discord_welcome_message            = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_welcome_message' ) ) );
		$ets_eduma_pmpro_discord_cancel_message             = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_cancel_message' ) ) );
		$embed_messaging_feature                            = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_embed_messaging_feature' ) ) );
		// Check if DM channel is already created for the user.
		$user_dm = get_user_meta( $user_id, '_ets_eduma_pmpro_discord_dm_channel', true );

		if ( ! isset( $user_dm['id'] ) || $user_dm === false || empty( $user_dm ) ) {
			$this->ets_eduma_pmpro_discord_create_member_dm_channel( $user_id );
			$user_dm       = get_user_meta( $user_id, '_ets_eduma_pmpro_discord_dm_channel', true );
			$dm_channel_id = $user_dm['id'];
		} else {
			$dm_channel_id = $user_dm['id'];
		}

		if ( $type === 'warning' ) {
			update_user_meta( $user_id, '_ets_eduma_pmpro_discord_expitration_warning_dm_for_' . $membership_level_id, true );
			$message = ets_eduma_pmpro_discord_get_formatted_dm( $user_id, $membership_level_id, $ets_eduma_pmpro_discord_expiration_warning_message );
		}
		if ( $type === 'expired' ) {
			update_user_meta( $user_id, '_ets_eduma_pmpro_discord_expired_dm_for_' . $membership_level_id, true );
			$message = ets_eduma_pmpro_discord_get_formatted_dm( $user_id, $membership_level_id, $ets_eduma_pmpro_discord_expiration_expired_message );
		}
		if ( $type === 'welcome' ) {
			update_user_meta( $user_id, '_ets_eduma_pmpro_discord_welcome_dm_for_' . $membership_level_id, true );
			$message = ets_eduma_pmpro_discord_get_formatted_dm( $user_id, $membership_level_id, $ets_eduma_pmpro_discord_welcome_message );
		}

		if ( $type === 'cancel' ) {
			update_user_meta( $user_id, '_ets_eduma_pmpro_discord_cancel_dm_for_' . $membership_level_id, true );
			$message = ets_eduma_pmpro_discord_get_formatted_dm( $user_id, $membership_level_id, $ets_eduma_pmpro_discord_cancel_message );
		}

		$creat_dm_url = CONNECT_EDUMA_THEME_DISCORD_API_URL . '/channels/' . $dm_channel_id . '/messages';
		if ( $embed_messaging_feature ) {
			$dm_args = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bot ' . $discord_bot_token,
				),
				'body'    => ets_eduma_discord_get_rich_embed_message( trim( $message ) ),

			);
		} else {
			$dm_args = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bot ' . $discord_bot_token,
				),
				'body'    => json_encode(
					array(
						'content' => sanitize_text_field( trim( wp_unslash( $message ) ) ),
					)
				),
			);
		}
		$dm_response = wp_remote_post( $creat_dm_url, $dm_args );
		ets_eduma_pmpro_discord_log_api_response( $user_id, $creat_dm_url, $dm_args, $dm_response );
		$dm_response_body = json_decode( wp_remote_retrieve_body( $dm_response ), true );
		if ( ets_eduma_discord_check_api_errors( $dm_response ) ) {
			Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $dm_response_body, $user_id, debug_backtrace()[0] );
			// this should be catch by Action schedule failed action.
			throw new Exception( 'Failed in function ets_eduma_pmpro_discord_handler_send_dm' );
		}

	}

	/**
	 * Create DM channel for a give user_id
	 *
	 * @param INT $user_id
	 * @return MIXED
	 */
	public function ets_eduma_pmpro_discord_create_member_dm_channel( $user_id ) {
		$discord_user_id       = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
		$discord_bot_token     = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
		$create_channel_dm_url = CONNECT_EDUMA_THEME_DISCORD_API_URL . '/users/@me/channels';
		$dm_channel_args       = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => json_encode(
				array(
					'recipient_id' => $discord_user_id,
				)
			),
		);

		$created_dm_response = wp_remote_post( $create_channel_dm_url, $dm_channel_args );
		ets_eduma_pmpro_discord_log_api_response( $user_id, $create_channel_dm_url, $dm_channel_args, $created_dm_response );
		$response_arr = json_decode( wp_remote_retrieve_body( $created_dm_response ), true );

		if ( is_array( $response_arr ) && ! empty( $response_arr ) ) {
			// check if there is error in create dm response
			if ( array_key_exists( 'code', $response_arr ) || array_key_exists( 'error', $response_arr ) ) {
				Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				if ( ets_eduma_discord_check_api_errors( $created_dm_response ) ) {
					// this should be catch by Action schedule failed action.
					throw new Exception( 'Failed in function ets_eduma_pmpro_discord_create_member_dm_channel' );
				}
			} else {
				update_user_meta( $user_id, '_ets_eduma_pmpro_discord_dm_channel', $response_arr );
			}
		}
		return $response_arr;
	}

	/**
	 * Disconnect user from discord, and , if the case, kick students on disconnect
	 */
	public function ets_eduma_pmpro_discord_disconnect_user() {

		if ( isset( $_GET['disconnect'] ) && $_GET['disconnect'] === 'eduma-pmpro-disconnect' ) {

			if ( ! is_user_logged_in() ) {
				wp_send_json_error( 'Unauthorized user', 401 );
				exit();
			}

			$user_id              = sanitize_text_field( get_current_user_id() );
			$kick_upon_disconnect = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_member_kick_out' ) ) );
			$access_token         = get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true );
			if ( $user_id && $access_token ) {
				if ( $kick_upon_disconnect === true ) {
					$this->delete_member_from_guild( $user_id, false );
				}
				delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_refresh_token' );
				$default_role                     = sanitize_text_field( trim( get_option( '_ets_eduma_pmpro_discord_default_role_id' ) ) );
				$_ets_eduma_pmpro_discord_role_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_role_id', true ) ) );
				$previous_default_role            = get_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', true );
				if ( ! empty( $access_token ) ) {
					// delete already assigned role.
					if ( isset( $_ets_eduma_pmpro_discord_role_id ) && $_ets_eduma_pmpro_discord_role_id != '' && $_ets_eduma_pmpro_discord_role_id != 'none' ) {
						$this->delete_discord_role( $user_id, $_ets_eduma_pmpro_discord_role_id, true );
						delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_role_id', true );
					}
					// Assign role which is saved as default.
					if ( $default_role != 'none' ) {
						if ( isset( $previous_default_role ) && $previous_default_role != '' && $previous_default_role != 'none' ) {
								$this->delete_discord_role( $user_id, $previous_default_role, true );
						}
						delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', true );
						$this->put_discord_role_api( $user_id, $default_role, true );
						update_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', $default_role );
					} elseif ( $default_role === 'none' ) {
						if ( isset( $previous_default_role ) && $previous_default_role != '' && $previous_default_role != 'none' ) {
							$this->delete_discord_role( $user_id, $previous_default_role, true );
						}
						update_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', $default_role );
					}
					delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token' );
				}
			}
			wp_safe_redirect( ets_eduma_discord_get_current_screen_url() );

		}
	}


	/**
	 * Method to save job queue for cancelled pmpro members.
	 *
	 * @param INT $level_id
	 * @param INT $user_id
	 * @param INT $cancel_level
	 * @return NONE
	 */
	public function ets_eduma_pmpro_discord_as_schdule_job_pmpro_cancel( $level_id, $user_id, $cancel_level ) {
		$membership_status = sanitize_text_field( trim( $this->ets_eduma_pmpro_check_current_membership_status( $user_id ) ) );
		$access_token      = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true ) ) );
		$next_payment      = pmpro_next_payment( $user_id );
		// global $pmpro_next_payment_timestamp;

		if ( ! empty( $cancel_level ) || $membership_status === 'admin_cancelled' ) {
			$args = array(
				'hook'    => 'ets_eduma_pmpro_discord_as_handle_pmpro_cancel',
				'args'    => array( $level_id, $user_id, $cancel_level ),
				'status'  => ActionScheduler_Store::STATUS_PENDING,
				'orderby' => 'date',
			);

			// check if member is already added to job queue.
			$cancl_arr_already_added = as_get_scheduled_actions( $args, ARRAY_A );

			if ( count( $cancl_arr_already_added ) === 0 && $access_token && ( $membership_status === 'cancelled' || $membership_status === 'admin_cancelled' ) ) {
				as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_handle_pmpro_cancel', array( $user_id, $level_id, $cancel_level ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
			}
		}
	}

	/**
	 * Get user membership status by user_id
	 *
	 * @param INT $user_id
	 * @return STRING $status
	 */
	public function ets_eduma_pmpro_check_current_membership_status( $user_id ) {
		global $wpdb;
		$sql    = $wpdb->prepare( 'SELECT `status` FROM ' . $wpdb->prefix . 'pmpro_memberships_users' . ' WHERE `user_id`= %d ORDER BY `id` DESC limit 1', array( $user_id ) );
		$result = $wpdb->get_results( $sql );
		return $result[0]->status;
	}

	/**
	 * Method to process queue of canceled pmpro members.
	 *
	 * @param INT $user_id
	 * @param INT $level_id
	 * @param INT $cancel_level_id
	 * @return NONE
	 */
	public function ets_eduma_pmpro_discord_as_handler_pmpro_cancel( $user_id, $level_id, $cancel_level_id ) {
		$this->ets_eduma_pmpro_discord_set_member_roles( $user_id, false, $cancel_level_id, true );
	}

	/**
	 * Method to adjust level mapped and default role of a member.
	 *
	 * @param INT  $user_id
	 * @param INT  $expired_level_id
	 * @param INT  $cancel_level_id
	 * @param BOOL $is_schedule
	 */
	private function ets_eduma_pmpro_discord_set_member_roles( $user_id, $expired_level_id = false, $cancel_level_id = false, $is_schedule = true ) {
		$allow_none_member                            = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_allow_none_member' ) ) );
		$default_role                                 = sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_default_role_id' ) ) );
		$_ets_eduma_pmpro_discord_role_id             = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_role_id', true ) ) );
		$ets_eduma_pmpro_discord_role_mapping         = json_decode( get_option( 'ets_eduma_pmpro_discord_role_mapping' ), true );
		$curr_level_id                                = sanitize_text_field( trim( ets_eduma_pmpro_discord_get_current_level_id( $user_id ) ) );
		$previous_default_role                        = get_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', true );
		$ets_pmpro_discord_send_membership_expired_dm = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_membership_expired_dm' ) ) );
		$ets_pmpro_discord_send_membership_cancel_dm  = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_membership_cancel_dm' ) ) );
		$access_token                                 = get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true );
		if ( ! empty( $access_token ) ) {
			if ( $expired_level_id ) {
				$curr_level_id = $expired_level_id;
			}
			if ( $cancel_level_id ) {
				$curr_level_id = $cancel_level_id;
			}
			// delete already assigned role.
			if ( isset( $_ets_eduma_pmpro_discord_role_id ) && $_ets_eduma_pmpro_discord_role_id != '' && $_ets_eduma_pmpro_discord_role_id != 'none' ) {
					$this->delete_discord_role( $user_id, $_ets_eduma_pmpro_discord_role_id, $is_schedule );
					delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_role_id', true );
			}
			if ( $curr_level_id !== null ) {
				// Assign role which is mapped to the mmebership level.
				if ( is_array( $ets_eduma_pmpro_discord_role_mapping ) && array_key_exists( 'pmpro_level_id_' . $curr_level_id, $ets_eduma_pmpro_discord_role_mapping ) ) {
					$mapped_role_id = sanitize_text_field( trim( $ets_eduma_pmpro_discord_role_mapping[ 'pmpro_level_id_' . $curr_level_id ] ) );
					if ( $mapped_role_id && $expired_level_id == false && $cancel_level_id == false ) {
						$this->put_discord_role_api( $user_id, $mapped_role_id, $is_schedule );
						update_user_meta( $user_id, '_ets_eduma_pmpro_discord_role_id', $mapped_role_id );
					}
				}
			}
			// Assign role which is saved as default.
			if ( $default_role != 'none' ) {
				if ( $default_role !== $previous_default_role && isset( $previous_default_role ) && $previous_default_role != '' && $previous_default_role != 'none' ) {
						$this->delete_discord_role( $user_id, $previous_default_role, $is_schedule );
						delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', true );
						$this->put_discord_role_api( $user_id, $default_role, $is_schedule );
						update_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', $default_role );
				}
			} elseif ( $default_role === 'none' ) {
				if ( isset( $previous_default_role ) && $previous_default_role != '' && $previous_default_role != 'none' ) {
					$this->delete_discord_role( $user_id, $previous_default_role, $is_schedule );
					update_user_meta( $user_id, '_ets_eduma_pmpro_discord_default_role_id', $default_role );
				}
			}

			if ( isset( $user_id ) && $allow_none_member === 'no' && $curr_level_id == null ) {
				$this->delete_member_from_guild( $user_id, false );
			}

			delete_user_meta( $user_id, '_ets_eduma_pmpro_discord_expitration_warning_dm_for_' . $curr_level_id );

			// Send DM about expiry, but only when allow_none_member setting is yes
			if ( $ets_pmpro_discord_send_membership_expired_dm === true && $expired_level_id !== false && $allow_none_member = 'yes' ) {
				as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_send_dm', array( $user_id, $expired_level_id, 'expired' ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
			}

			// Send DM about cancel, but only when allow_none_member setting is yes
			if ( $ets_pmpro_discord_send_membership_cancel_dm === true && $cancel_level_id !== false && $allow_none_member = 'yes' ) {
				as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_send_dm', array( $user_id, $cancel_level_id, 'cancel' ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
			}
		}
	}

	/**
	 * Schedule delete discord role for a member
	 *
	 * @param INT  $user_id
	 * @param INT  $ets_role_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function delete_discord_role( $user_id, $ets_role_id, $is_schedule = true ) {
		if ( $is_schedule ) {
			as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_schedule_delete_role', array( $user_id, $ets_role_id, $is_schedule ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
		} else {
			$this->ets_eduma_pmpro_discord_as_handler_delete_memberrole( $user_id, $ets_role_id, $is_schedule );
		}
	}

	/**
	 * Action Schedule handler to process delete role of a member.
	 *
	 * @param INT  $user_id
	 * @param INT  $ets_role_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function ets_eduma_pmpro_discord_as_handler_delete_memberrole( $user_id, $ets_role_id, $is_schedule = true ) {
		$server_id                        = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );
		$_ets_eduma_pmpro_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
		$discord_bot_token                = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
		$discord_delete_role_api_url      = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'guilds/' . $server_id . '/members/' . $_ets_eduma_pmpro_discord_user_id . '/roles/' . $ets_role_id;
		if ( $_ets_eduma_pmpro_discord_user_id ) {
			$param = array(
				'method'  => 'DELETE',
				'headers' => array(
					'Content-Type'   => 'application/json',
					'Authorization'  => 'Bot ' . $discord_bot_token,
					'Content-Length' => 0,
				),
			);

			$response = wp_remote_request( $discord_delete_role_api_url, $param );
			ets_eduma_pmpro_discord_log_api_response( $user_id, $discord_delete_role_api_url, $param, $response );
			if ( ets_eduma_discord_check_api_errors( $response ) ) {
				$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				if ( $is_schedule ) {
					// this exception should be catch by action scheduler.
					throw new Exception( 'Failed in function ets_eduma_pmpro_discord_as_handler_delete_memberrole' );
				}
			}
			return $response;
		}
	}

	/**
	 * Schedule delete existing user from guild
	 *
	 * @param INT  $user_id
	 * @param BOOL $is_schedule
	 * @param NONE
	 */
	public function delete_member_from_guild( $user_id, $is_schedule = true ) {
		if ( $is_schedule && isset( $user_id ) ) {

			as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_schedule_delete_member', array( $user_id, $is_schedule ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
		} else {
			if ( isset( $user_id ) ) {
				$this->ets_eduma_pmpro_discord_as_handler_delete_member_from_guild( $user_id, $is_schedule );
			}
		}
	}

	/**
	 * AS Handling member delete from huild
	 *
	 * @param INT  $user_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function ets_eduma_pmpro_discord_as_handler_delete_member_from_guild( $user_id, $is_schedule ) {
		$server_id                        = sanitize_text_field( trim( get_option( 'ets_eduma_discord_server_id' ) ) );
		$discord_bot_token                = sanitize_text_field( trim( get_option( 'ets_eduma_discord_bot_token' ) ) );
		$_ets_eduma_pmpro_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_user_id', true ) ) );
		$guilds_delete_memeber_api_url    = CONNECT_EDUMA_THEME_DISCORD_API_URL . 'guilds/' . $server_id . '/members/' . $_ets_eduma_pmpro_discord_user_id;
		$guild_args                       = array(
			'method'  => 'DELETE',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
		);
		$guild_response                   = wp_remote_post( $guilds_delete_memeber_api_url, $guild_args );

		ets_eduma_pmpro_discord_log_api_response( $user_id, $guilds_delete_memeber_api_url, $guild_args, $guild_response );
		if ( ets_eduma_discord_check_api_errors( $guild_response ) ) {
			$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
			Connect_Eduma_Theme_To_Discord_Logs_PMPRO::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			if ( $is_schedule ) {
				// this exception should be catch by action scheduler.
				throw new Exception( 'Failed in function ets_eduma_pmpro_discord_as_handler_delete_member_from_guild' );
			}
		}

		/*Delete all usermeta related to discord connection*/
		ets_eduma_pmpro_discord_remove_usermeta( $user_id );

	}

	/*
	* Action schedule to schedule a function to run upon PMPRO Expiry.
	*
	* @param INT $user_id
	* @param INT $level_id
	* @return NONE
	*/
	public function ets_eduma_pmpro_discord_as_schdule_job_pmpro_expiry( $user_id, $level_id ) {
		$membership_status = sanitize_text_field( trim( $this->ets_eduma_pmpro_check_current_membership_status( $user_id ) ) );
		$access_token      = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true ) ) );
		if ( $membership_status === 'expired' && $access_token ) {
			as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_handle_pmpro_expiry', array( $user_id, $level_id ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
		}
	}

	/*
	* Action scheduler method to process expired pmpro members.
	* @param INT $user_id
	* @param INT $expired_level_id
	*/
	public function ets_eduma_pmpro_discord_as_handler_pmpro_expiry( $user_id, $expired_level_id ) {
		$this->ets_eduma_pmpro_discord_set_member_roles( $user_id, $expired_level_id, false, true );
	}

	/**
	 * Method to queue all members into cancel job when pmpro level is deleted.
	 *
	 * @param INT $level_id
	 * @return NONE
	 */
	public function ets_eduma_pmpro_discord_as_schedule_job_pmpro_level_deleted( $level_id ) {
		global $wpdb;
		$result = $wpdb->get_results( $wpdb->prepare( 'SELECT `user_id` FROM ' . $wpdb->prefix . 'pmpro_memberships_users' . ' WHERE `membership_id` = %d GROUP BY `user_id`', array( $level_id ) ) );
		// $ets_pmpor_discord_role_mapping = json_decode( get_option( 'ets_eduma_pmpro_discord_role_mapping' ), true );
		update_option( 'ets_admin_level_deleted', true );
		foreach ( $result as $key => $ids ) {
			$user_id      = $ids->user_id;
			$access_token = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_eduma_pmpro_discord_access_token', true ) ) );
			if ( $access_token ) {
				as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_handle_pmpro_cancel', array( $user_id, $level_id, $level_id ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
			}
		}
	}

	/**
	 * Change discord role from admin user edit.
	 *
	 * @param INT $level_id
	 * @param INT $user_id
	 * @param INT $cancel_level
	 * @return NONE
	 */
	public function ets_eduma_pmpro_discord_change_discord_role_from_pmpro( $level_id, $user_id, $cancel_level ) {
		$is_schedule = true;
		$is_schedule = apply_filters( 'ets_pmpro_discord_schedule_change_renew_api_calls', $is_schedule );
		$this->ets_eduma_pmpro_discord_set_member_roles( $user_id, false, false, $is_schedule );
	}

	/**
	 * Send expiration warning DM to discord members.
	 *
	 * @param NONE
	 * @param NONE
	 */

	public function ets_eduma_pmpro_discord_send_expiration_warning_DM() {
		global $wpdb;
		// clean up errors in the memberships_users table that could cause problems.
		pmpro_cleanup_memberships_users_table();
		$today                              = date( 'Y-m-d 00:00:00', current_time( 'timestamp' ) );
		$pmpro_email_days_before_expiration = apply_filters( 'pmpro_email_days_before_expiration', 7 );
		$ets_eduma_pmpro_discord_send_expiration_warning_DM = (bool) sanitize_text_field( trim( get_option( 'ets_eduma_pmpro_discord_send_expiration_warning_DM' ) ) );

		if ( $ets_eduma_pmpro_discord_send_expiration_warning_DM === false ) {
			return;
		}
		// Configure the interval to select records from
		$interval_start = $today;
		$interval_end   = date( 'Y-m-d 00:00:00', strtotime( "{$today} +{$pmpro_email_days_before_expiration} days", current_time( 'timestamp' ) ) );

		// look for memberships that are going to expire within one week (but we haven't emailed them within a week)
		$sqlQuery      = $wpdb->prepare(
			"SELECT DISTINCT 
			mu.user_id, mu.membership_id, mu.startdate, mu.enddate 
			FROM {$wpdb->pmpro_memberships_users} AS mu 
			WHERE mu.enddate 
			BETWEEN %s AND %s
			AND ( mu.status = 'active' )
			AND ( mu.membership_id <> 0 OR mu.membership_id <> NULL ) 
			ORDER BY mu.enddate",
			$today,
			$interval_end
		);
		$expiring_soon = $wpdb->get_results( $sqlQuery );

		if ( ! empty( $expiring_soon ) ) {
			// foreach members and send DM
			foreach ( $expiring_soon as $key => $user_obj ) {
				// check if the message is not already sent
				$membership_level = pmpro_getMembershipLevelForUser( $user_obj->user_id );
				$already_sent     = get_user_meta( $user_obj->user_id, '_ets_eduma_pmpro_discord_expitration_warning_dm_for_' . $membership_level->ID, true );
				$access_token     = get_user_meta( $user_obj->user_id, '_ets_eduma_pmpro_discord_access_token', true );
				if ( ! empty( $access_token ) && $membership_level !== false && $already_sent != 1 ) {
					as_schedule_single_action( ets_eduma_discord_get_random_timestamp( ets_eduma_discord_get_highest_last_attempt_timestamp() ), 'ets_eduma_pmpro_discord_as_send_dm', array( $user_obj->user_id, $membership_level->ID ), CONNECT_EDUMA_THEME_DISCORD_AS_GROUP_NAME );
				}
			}
		}

	}
}
