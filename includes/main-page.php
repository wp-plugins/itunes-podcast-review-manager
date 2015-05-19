<?php

/* ADMIN PAGE */

add_action( 'admin_menu', 'iprm_add_main_page_link' );

function iprm_main_page() {
	global $iprm_review_cache;
	global $iprm_review_cache_history;
	
	/* DISABLES FOR NON-ADMINISTRATORS */
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'iprm_domain' ) );
	}
	/* IF CACHE IS EMPTY, CHECK FOR NEW REVIEWS */
	if ( ( $iprm_review_cache == '' ) || ( is_array( $iprm_review_cache ) && empty( $iprm_review_cache ) ) ) {
		$iprm_review_cache = iprm_get_itunes_feed_contents();
	}
	if ( empty( $iprm_review_cache ) ) {
		$alert = __( 'No reviews found for this podcast.', 'iprm_domain' );
	}
	ob_start(); ?>
	<div class="wrap iprm">
		<?php echo iprm_display_alert( $alert ); ?>
		<?php echo iprm_display_notice( $notice ); ?>
		<?php echo iprm_display_navigation( 'iprm_main_page' ); ?>
		<?php
			/* DISPLAY REVIEWS FROM CACHE */
			if ( !empty( $iprm_review_cache ) ) {
				echo iprm_display_itunes_feed_summary( iprm_get_option( 'iprm_settings' ) );
				echo iprm_display_reviews( $iprm_review_cache );
			}
		?>
		<p style="color: #ecf0f1; text-align: right;">Flag icons by <a href="http://www.icondrawer.com" target="_blank">IconDrawer</a>.</p>
	</div>
	<?php
	echo ob_get_clean();
}
function iprm_add_main_page_link() {
	add_menu_page( 'Podcast Reviews', 'Podcast Reviews', 'manage_options', 'iprm_main_page', 'iprm_main_page', 'dashicons-star-filled' );
}