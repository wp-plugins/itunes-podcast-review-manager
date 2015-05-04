<?php

/* ADMIN PAGE */

add_action( 'admin_menu', 'iprm_add_settings_page_link' );

function iprm_settings_page() {
	global $iprm_powerpress_feed;
	global $iprm_review_cache;
	global $iprm_review_cache_history;
	global $iprm_settings;
	$iprm_settings_new = $iprm_settings;
	
	/* DISABLES FOR NON-ADMINISTRATORS */
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	/* IF NEW ITUNES URL IS ENTERED, UPDATE OPTION AND CLEAR REVIEW CACHE */
	if ( $_POST["update_itunes_url"] != '' ) { 
		$iprm_settings_input = $_POST["iprm_settings_input"];
		$iprm_settings_new['itunes_url'] = esc_url( $iprm_settings_input['itunes_url'] );
		iprm_update_option( 'iprm_settings', $iprm_settings_new );
		iprm_delete_option( 'iprm_review_cache' );
		iprm_delete_option( 'iprm_review_cache_history' );
	}
	/* IF ITUNES URL IS NOT FOUND, TRY TO GET IT FROM POWERPRESS OPTION VALUE */
	elseif ( $iprm_settings['itunes_url'] == '' ) {
		if ( esc_url( $iprm_powerpress_feed['itunes_url'] ) != '' ) {
			$iprm_settings_new['itunes_url'] = $iprm_powerpress_feed['itunes_url'];
			iprm_update_option( 'iprm_settings', $iprm_settings_new );
			$itunes_url_auto_detected = TRUE;
		}
	}
	/* IF CHECK FOR REVIEWS MANUALLY BUTTON IS PRESSED, CHECK FOR REVIEWS */
	if ( $_POST["check_manually"] != '' ) {
		$reviews = iprm_get_itunes_feed_contents();
	}

	ob_start(); ?>
	<div class="wrap iprm">
		<?php echo iprm_display_navigation( 'iprm_settings_page' ); ?>
		<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
		<!-- DISPLAY PLUGIN OPTIONS TABLE -->
			<table class="iprm-table-small-border">
				<tr>
					<th><h2><?php _e( 'iTunes Podcast URL', 'iprm_domain' ); ?></h2></th>
					<th><h2><?php _e( 'Cached Reviews', 'iprm_domain' ); ?></h2></th>
				</tr>
				<tr>
					<!-- DISPLAY ITUNES URL AND OPTION TO CHANGE IT -->
					<td>
						<p><b><?php
							if ( $itunes_url_auto_detected ) {
								_e( 'We detected this iTunes podcast URL. If this is incorrect, please enter your iTunes podcast URL.', 'iprm_domain' );
							}
							else {
								_e( 'Please enter your iTunes podcast URL.', 'iprm_domain' );
							}
						?></b><br />
						<i><?php _e( 'Example: http://itunes.apple.com/us/podcast/professional-wordpress-podcast/id885696994.', 'iprm_domain' ); ?></i></p>
						<p><input type="text" id="iprm_settings_input[itunes_url]" name="iprm_settings_input[itunes_url]" size="80" value="<?php echo $iprm_settings['itunes_url']; ?>"></p>
						<p class="submit"><input class="button-primary" type="submit" name="update_itunes_url" value="<?php _e( 'UPDATE ITUNES URL', 'iprm_domain' ); ?>"></p>
					</td>
					<!-- DISPLAY RECENT CACHE HISTORY AND MANUAL REVIEW CHECK BUTTON -->
					<td>
						<p><b><?php _e( 'Recent Cache History:', 'iprm_domain' ); ?></b><br />
							<?php
							$i = 1;
							if ( is_array( $iprm_review_cache_history ) ) {
								foreach ( array_reverse( $iprm_review_cache_history ) as $item ) {
									$i++;
									echo $item['time'] . ' Reviews: ' . $item['count'] . '<br />';
									if ( $i > 5 ) {
										break;
									}
								}
							}
							?>
						</p>
						<p><?php _e( 'This plugin will automatically check every 4 hours.', 'iprm_domain' ); ?></p>
						<p class="submit"><input class="button-primary" type="submit" name="check_manually" value="<?php _e( 'CHECK MANUALLY', 'iprm_domain' ); ?>"></p>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
	echo ob_get_clean();
}
function iprm_add_settings_page_link() {
	add_submenu_page( 'iprm_main_page', 'Settings', 'Settings', 'manage_options', 'iprm_settings_page', 'iprm_settings_page' );
}