<?php

/* FOR UPGRADE FUNCTIONS */

function iprm_upgrade_check() {
	global $iprm_current_plugin_version;
	global $iprm_settings;
	$iprm_settings_new = $iprm_settings;
	if ( $iprm_current_plugin_version != $iprm_settings_new['iprm_plugin_version'] ) {
		if ( $iprm_settings_new['itunes_url'] == '' ) {
			$iprm_settings_new['itunes_url'] = get_option( 'iprm_itunes_url' );
		}
		iprm_delete_option( 'iprm_itunes_url' );
		if ( $iprm_settings_new['itunes_feed_artist'] == '' ) {
			$iprm_settings_new['itunes_feed_artist'] = get_option( 'iprm_itunes_feed_artist' );
		}
		iprm_delete_option( 'iprm_itunes_feed_artist' );
		if ( $iprm_settings_new['itunes_feed_image'] == '' ) {
			$iprm_settings_new['itunes_feed_image'] = get_option( 'iprm_itunes_feed_image' );
		}
		iprm_delete_option( 'iprm_itunes_feed_image' );
		if ( $iprm_settings_new['itunes_feed_name'] == '' ) {
			$iprm_settings_new['itunes_feed_name'] = get_option( 'iprm_itunes_feed_name' );
		}
		iprm_delete_option( 'iprm_itunes_feed_name' );
		if ( $iprm_settings_new['itunes_feed_summary']  == '' ) {
			$iprm_settings_new['itunes_feed_summary'] = get_option( 'iprm_itunes_feed_summary' );
		}
		iprm_delete_option( 'iprm_itunes_feed_summary' );
		$iprm_settings_new['iprm_plugin_version'] = $iprm_current_plugin_version;
		iprm_update_option( 'iprm_settings', $iprm_settings_new );
	}
}