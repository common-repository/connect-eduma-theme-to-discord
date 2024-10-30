<div class="tc-step setup">
<div class="top">
		<div class="row">
			<div class="col-md-12">
				<h2>setup</h2>

				<div class="caption no-line">
					<?php

					_e(
						wp_kses(
							"<p>To put the plugin into service, here are the main steps to do:</p>
                        
						<p><b>Fill in the form 'Application Details' : </b></p>
						<p><i>Client ID Client</i>, <i>Secret</i>, <i>Redirect URL ( LearnPess )</i>, <i>Redirect URL ( PMPRO )</i>, <i>Admin Redirect URL Connect to bot</i>, <i>Bot Token</i>, <i>Server ID</i>, <i>Cache timeout</i>.</p>
						<p>The fields concerning Discord, you must retrieve them from your discord server.</p>
						<p>The fields : <i>Admin Redirect URL Connect to bot</i> and <i>Redirect URL</i> : this is the urls to define as a redirect during discord authentication. </p>
						<p>You added it from your discord application in the <b>oAuth2</b> section: </p>
                        ",
							array(
								'p' => array(),
								'b' => array(),
								'i' => array(),
							)
						),
						'connect-eduma-theme-to-discord'
					);
					?>
					<img src='<?php echo esc_attr( CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL ); ?>admin/images/guide/setup/setup-oauth2-connect-eduma-theme-to-discord.png' >

				</div>


			</div>
		</div>
	</div>
</div>
