<?php

/* ADMIN PAGE */

add_action( 'admin_menu', 'iprm_add_main_page_link' );

function iprm_main_page() {
	global $iprm_review_cache;
	global $iprm_review_cache_history;
	
	/* DISABLES FOR NON-ADMINISTRATORS */
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	ob_start(); ?>
	<div class="wrap iprm">
		<!-- DISPLAY REVIEWS FROM CACHE OR GENERATE NEW REVIEWS IF CACHE IS EMPTY -->
		<?php
			echo iprm_display_navigation( 'iprm_main_page' );
			/* IF CACHE IS EMPTY, CHECK FOR NEW REVIEWS AND DISPLAY THEM */
			if ( ( $iprm_review_cache == '' ) || ( is_array( $iprm_review_cache ) && empty( $iprm_review_cache ) ) ) {
				echo iprm_display_reviews( iprm_get_itunes_feed_contents() );
			}
			/* IF CACHE IS NOT EMPTY, DISPLAY REVIEWS FROM CACHE */
			else {
				echo iprm_display_reviews( $iprm_review_cache );
			}
		?>
	</div>
	<?php
	echo ob_get_clean();
}
function iprm_add_main_page_link() {
	add_menu_page( 'Podcast Reviews', 'Podcast Reviews', 'manage_options', 'iprm_main_page', 'iprm_main_page', 'dashicons-star-filled' );
}