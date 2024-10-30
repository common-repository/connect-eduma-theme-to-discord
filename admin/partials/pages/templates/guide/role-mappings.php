<div class="tc-step role-mappings">
<div class="top">
		<div class="row">
			<div class="col-md-12">
				<h2>Role Mappings</h2>

				<div class="caption no-line">
					<?php

					_e(
						wp_kses(
							'<p>After connecting to your discord server, you can now link Discord Roles and LearnPress Courses:</p>
                        ',
							array(
								'p' => array(),
							)
						),
						'connect-eduma-theme-to-discord'
					);
					?>
					<img src='<?php echo esc_attr( CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL ); ?>admin/images/guide/role-mappings/rolemappings-connect-eduma-theme-to-discord.png' >

					<?php

					_e(
						wp_kses(
							'<p>If you plan to activate Paid Memberships Pro too, you can also do the same:</p>',
							array(
								'p' => array(),
							)
						),
						'connect-eduma-theme-to-discord'
					);
					?>
					<img src='<?php echo esc_attr( CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL ); ?>admin/images/guide/role-mappings/pmpro-rolemappings-connect-eduma-theme-to-discord.png' >					
				</div>


			</div>
		</div>
	</div>
</div>
