<?php

/* PREMIUM PAGE */

add_action( 'admin_menu', 'iprm_add_premium_page_link' );

function iprm_premium_page() {
	ob_start(); ?>
	<div class="wrap iprm">
		<?php echo iprm_display_navigation( 'iprm_premium_page' ); ?>
		<table>
			<tr>
				<th><h2><?php _e( 'Premium Service - Launching Soon!', 'iprm_domain' ); ?></h2></th>
			</tr>
			<tr>
				<td>
					<p><?php _e( 'For more information and to find out when we launch, please <a href="http://eepurl.com/bhU4SD" target="_blank">enter your email here</a>.', 'iprm_domain' ); ?></p>
				</td>
			</tr>
		</table>
	</div>
	<?php
	echo ob_get_clean();
}
function iprm_add_premium_page_link() {
	add_submenu_page( 'iprm_main_page', 'Premium', 'Premium', 'manage_options', 'iprm_premium_page', 'iprm_premium_page' );
}