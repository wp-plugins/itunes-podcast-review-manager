<?php
/*
Plugin Name: iTunes Podcast Review Manager
Plugin URI: http://efficientwp.com/plugins/itunes-podcast-review-manager
Description: Get your iTunes podcast reviews from all countries. Checks iTunes automatically and displays your podcast reviews in a sortable table.
Version: 2.1
Author: Doug Yuen
Author URI: http://efficientwp.com
License: GPLv2
*/

/*****************************
* GLOBAL VARIABLES
*****************************/

$iprm_current_plugin_version = 2.1;
$iprm_powerpress_feed = get_option( 'powerpress_feed' );
$iprm_review_cache = get_option( 'iprm_review_cache' );
$iprm_review_cache_history = get_option( 'iprm_review_cache_history' );
$iprm_settings = get_option( 'iprm_settings' );

/*****************************
* INCLUDES
*****************************/

require_once( dirname(__FILE__) . '/includes/data-processing-functions.php' );
require_once( dirname(__FILE__) . '/includes/display-functions.php' );
require_once( dirname(__FILE__) . '/includes/main-page.php' );
require_once( dirname(__FILE__) . '/includes/premium-page.php' );
require_once( dirname(__FILE__) . '/includes/script-functions.php' );
require_once( dirname(__FILE__) . '/includes/settings-page.php' );
require_once( dirname(__FILE__) . '/includes/upgrade-functions.php' );
require_once( dirname(__FILE__) . '/includes/utility-functions.php' );

/* CHECK FOR UPGRADE CHANGES */
iprm_upgrade_check();/**/

add_filter( 'cron_schedules', 'iprm_cron_add_every_four_hours' );
add_action( 'iprm_schedule', 'iprm_get_itunes_feed_contents' );
add_shortcode( 'iprm', 'iprm_display_as_shortcode' );
register_deactivation_hook( __FILE__, 'iprm_deactivate' );

/* SCHEDULE A CRON JOB TO CHECK FOR REVIEWS EVERY 4 HOURS */
if ( !wp_next_scheduled( 'iprm_schedule' ) ) {
	wp_schedule_event( time(), 'four_hours', 'iprm_schedule' );
}