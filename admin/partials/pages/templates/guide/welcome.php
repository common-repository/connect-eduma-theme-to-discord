
<div class="tc-step welcome active">

<div class="top">
		<div class="row">
			<div class="col-md-12">
				<h2>Welcome to Connect Eduma Theme to Discord</h2>

				<div class="caption no-line">
					<?php

					_e(
						wp_kses(
							'<p>Hello there,</p>
                        <p>Thank you for choosing our Add-On.</p>
                        <p>The Connect Eduma Theme to Discord plugin allows you to offer your students the ability to create a discord community, thus, you create an atmosphere of communication, information sharing and competitions between students.</p>
                       <p>Each student enrolled in a course, can get the discord role corresponding to course(s).</p> 
                       <p>The student can connect to discord from his <b>LearnPress</b> profile page : </p>
                        ',
							array(
								'p' => array(),
								'b' => array(),
							)
						),
						'connect-eduma-theme-to-discord'
					);
					?>
					<img src='<?php echo esc_attr( CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL ); ?>admin/images/guide/lp-profile-connect-eduma-theme-to-discord.png' >

					<?php

					_e(
						wp_kses(
							'<p>The student can also log in from the <b>woocommerce</b> account page (if woocommerce is activated)</p>',
							array(
								'p' => array(),
								'b' => array(),
							)
						),
						'connect-eduma-theme-to-discord'
					);
					?>
					<img src='<?php echo esc_attr( CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL ); ?>admin/images/guide/woo-connect-eduma-theme-to-discord.png' >

					<?php

					_e(
						wp_kses(
							'<p>The same for <b>Paid Memberships Pro</b>(if PMPRO is activated)</p>',
							array(
								'p' => array(),
								'b' => array(),
							)
						),
						'connect-eduma-theme-to-discord'
					);
					?>
					<img src='<?php echo esc_attr( CONNECT_EDUMA_THEME_DISCORD_PLUGIN_URL ); ?>admin/images/guide/pmpro-connect-eduma-theme-to-discord.png' >
				</div>
			</div>
		</div>
	</div>
</div>
