<?php


$ets_eduma_discord_steps       = ets_eduma_discord_get_steps();
$ets_eduma_discord_count_steps = count( $ets_eduma_discord_steps );

if ( ! $ets_eduma_discord_count_steps ) {
	return;
}

?>

<div class="thim-getting-started ets-eduma-theme-disccord-guide">
	<header>
		<p><a target="_blank" href="https://www.expresstechsoftwares.com/step-by-step-guide-on-how-to-connect-eduma-theme-to-discord-server/"><?php esc_html_e( 'Online Step By Step Documentaion', 'connect-eduma-theme-to-discord' ); ?></a></p>
		<p><a target="_blank" href="https://www.expresstechsoftwares.com/discord-add-ons-documentation/"><?php esc_html_e( 'All Discord Add-Ons Documentaion', 'connect-eduma-theme-to-discord' ); ?></a></p>
		<ul class="tc-controls">
			<?php
			foreach ( $ets_eduma_discord_steps as $index => $step ) :
				$position = $index + 1;
				$active   = ( $step['key'] === 'welcome' ) ? 'active' : '';
				?>
				<li>
					<a class="step ets-eduma-step <?php echo esc_attr( $active ); ?>" data-position="<?php echo esc_attr( $index ); ?>" data-step="<?php echo esc_attr( $step['key'] ); ?>" title="<?php echo esc_attr( $step['title'] ); ?> <?php printf( __( '(%1$s of %2$s)', 'connect-eduma-theme-to-discord' ), $position, $ets_eduma_discord_count_steps ); ?>"></a>
					<span class="label"><?php echo esc_html( $step['title'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</header>

	<main>
	<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/templates/guide/welcome.php'; ?>
	<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/templates/guide/setup.php'; ?>
	<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/templates/guide/role-mappings.php'; ?>
	<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/templates/guide/settings.php'; ?>
	<?php require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/templates/guide/appearance.php'; ?>
	<?php // require_once CONNECT_EDUMA_THEME_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/templates/guide/logs.php'; ?>	
	</main>
</div>




