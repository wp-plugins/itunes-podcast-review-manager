<?php
/*
Plugin Name: iTunes Podcast Review Manager
Plugin URI: http://podwp.com/plugins/itunes-podcast-review-manager
Description: Gathers all of your international podcast reviews from iTunes and displays them in a table. The plugin checks for new reviews in the background every 4 hours. Note: sometimes the iTunes feeds for certain countries are unreachable, and you will have to click the button to manually check for new reviews.
Version: 1.1
Author: Doug Yuen
Author URI: http://podwp.com
License: GPLv2
*/

require_once( dirname(__FILE__) . '/includes/utility-functions.php' );
add_action( 'admin_menu', 'iprm_plugin_menu' );
add_filter( 'cron_schedules', 'iprm_cron_add_every_four_hours' );
add_action( 'iprm_schedule', 'iprm_get_itunes_feed_contents' );
/* SCHEDULE A CRON JOB TO CHECK FOR REVIEWS EVERY 4 HOURS */
if ( !wp_next_scheduled( 'iprm_schedule' ) ) {
	wp_schedule_event( time(), 'four_hours', 'iprm_schedule' );
}

function iprm_display_reviews( $reviews ) {
	$review_number = 0;
	$output = '';
	$rating_total = 0;
	/* CHECKS TO MAKE SURE ITUNES PODCAST URL IS DEFINED */
	if ( get_option( 'iprm_itunes_url' ) ) {
		/* DISPLAY HEADING AND TABLE */
		$output .= '<h2>Your International iTunes Podcast Reviews</h2><br />';
		/* DISPLAY PODCAST INFO */
		$output .= '<table border="1" cellpadding="10" cellspacing="0" style="background: #fefefe; max-width: 1200px;"><tr><td><img src="' . get_option( 'iprm_feed_image' ) . '" /></td><td><h3>' . get_option( 'iprm_feed_name' ) . '</h3>' .  get_option( 'iprm_feed_artist' ) . '<br /><br /></td><td width="50%">' . get_option( 'iprm_feed_summary' ) . '</td></tr></table><br />';
		/* GET REVIEW DATE AND COUNTRY FOR SORTING */
		foreach ( $reviews as $key => $row ) {
		    $review_date[$key]  = $row['review_date'];
		    $country[$key] = $row['country'];
		}
		/* SORT REVIEWS BY DATE DESCENDING, THEN COUNTRY DESCENDING */
		array_multisort( $review_date, SORT_DESC, $country, SORT_DESC, $reviews );
		/* GENERATES TABLE ROWS FOR ALL REVIEWS */
		$table_body_output = '';
		foreach( $reviews as $review ) {
			$review_number++;
			$table_body_output .= '<tr>';
			$table_body_output .= '<td>' . $review_number . '</td>';
			$table_body_output .= '<td>';
			if ( strlen( $review['country'] ) == 2 ) {
				$table_body_output .= iprm_get_country_codes( $review['country'] );
			}
			else {
				$table_body_output .= $review['country'];
			}
			$table_body_output .= '</td>';
			$table_body_output .= '<td>' . substr( $review['review_date'], 0, strpos( $review['review_date'], 'T' ) ) . '</td>';
			$table_body_output .= '<td>' . $review['rating'] . '</td>';
			$rating_total += $review['rating'];
			$table_body_output .= '<td>' . $review['name'] . '</td>';
			$table_body_output .= '<td>' . $review['title'] . '</td>';
			$table_body_output .= '<td>' . $review['content'] . '</td>';
			$table_body_output .= '</tr>';
		}
		/* DISPLAY TABLE */
		$output .= '<table border="1" cellpadding="10" cellspacing="0" style="background: #fefefe; max-width: 1200px;">';
		$output .= '<tr><th style="vertical-align: top;">NUMBER<br /><small>(Total: ' . $review_number . ')</small></th><th style="vertical-align: top;">COUNTRY</th><th style="vertical-align: top;">DATE</th><th style="vertical-align: top;">RATING<br /><small>(Avg: ' . round( ( $rating_total / $review_number ), 2 ) . ')</small></th><th style="vertical-align: top;">NAME</th><th style="vertical-align: top;">TITLE</th><th style="vertical-align: top;">REVIEW</th></tr>';
		$output .= $table_body_output . '</table>';
	}
	return $output;
}
function iprm_get_itunes_feed_contents() {
	/* GET ARRAY OF ALL COUNTRY CODES AND COUNTRY NAMES */
	$country_codes = iprm_get_country_codes();
	/* CHECKS TO MAKE SURE ITUNES PODCAST URL IS DEFINED */
	if ( get_option( 'iprm_itunes_url' ) ) {
		$reviews = array( );
		$review_countries = array( );
		$retrieved_summary = FALSE;
		$podcast_url = get_option( 'iprm_itunes_url' );
		/* GET PODCAST ID */
		preg_match ( '([0-9][0-9][0-9]+)', $podcast_url, $matches );
		$id = $matches[0];
		/* CHECK THROUGH THE REVIEW FEEDS FOR EVERY COUNTRY */
		foreach ( $country_codes as $item ) {
			$country_code = $item['code'];
			$url_xml = 'https://itunes.apple.com/' . $country_code . '/rss/customerreviews/id=' . $id . '/xml';
			$itunes_json = json_encode( wp_remote_get( $url_xml ) );
			$data2 = json_decode( $itunes_json, TRUE );
			$feed_body = $data2['body'];
			/* LOOP THROUGH THE RAW CODE */
			while ( strpos( $feed_body, '<entry>' ) !== false ) {
				$new_review = array( );
				/* LOOK AT CODE IN BETWEEN FIRST INSTANCE OF ENTRY TAGS */
				$opening_tag = '<entry>';
				$closing_tag = '</entry>';
				$pos1 = strpos( $feed_body, $opening_tag );
				$pos2 = strpos( $feed_body, $closing_tag );
				$current_entry = substr( $feed_body, ( $pos1 + strlen( $opening_tag ) ), ( $pos2 - $pos1 - strlen( $opening_tag ) ) );
				/* IF PODCAST INFO IS NOT FOUND, GET IT AND UPDATE DATABASE OPTION VALUES */
				if ( !$retrieved_summary ) {
					$feed_name = iprm_get_contents_inside_tag( $current_entry, '<im:name>', '</im:name>' );
					$feed_artist = iprm_get_contents_inside_tag( $current_entry, '<im:artist>', '</im:artist>' );
					$feed_summary = iprm_get_contents_inside_tag( $current_entry, '<summary>', '</summary>' );
					$feed_image = iprm_get_contents_inside_tag( $current_entry, '<im:image height="55">', '</im:image>' );
					update_option( 'iprm_feed_name', $feed_name );
					update_option( 'iprm_feed_artist', $feed_artist );
					update_option( 'iprm_feed_summary', $feed_summary );
					update_option( 'iprm_feed_image', $feed_image );
					$retrieved_summary = TRUE;
				}
				/* GET REVIEW URL AND REVIEW URL COUNTRY CODE */
				$review_url = iprm_get_contents_inside_tag( $current_entry, '<uri>', '</uri>' );
				$review_url_country_code = substr( $review_url, ( strpos( $review_url, 'reviews' ) - 3 ), 2 );
				/* ADD NEW REVIEW TO REVIEW ARRAY */
				if ( $current_entry !== '' ) {
					$new_review['country'] = iprm_get_country_codes( $review_url_country_code );
					$new_review['review_date'] = iprm_get_contents_inside_tag( $current_entry, '<updated>', '</updated>' );
					$new_review['rating'] = iprm_get_contents_inside_tag( $current_entry, '<im:rating>', '</im:rating>' );
					$new_review['name'] = iprm_get_contents_inside_tag( $current_entry, '<name>', '</name>' );
					$new_review['title'] = iprm_get_contents_inside_tag( $current_entry, '<title>', '</title>' );
					$new_review['content'] = iprm_get_contents_inside_tag( $current_entry, '<content type="text">', '</content>' );
					/* CHECK TO MAKE SURE THERE IS A RATING AND NAME BEFORE ADDING REVIEW TO ARRAY */
					if ( ( $new_review['rating'] != '' ) && ( $new_review['name'] != '' ) ) {
						array_push( $reviews, $new_review );
					}
				}
				/* REMOVE CODE AFTER FIRST INSTANCE OF ENTRY TAGS, SO THE NEXT LOOP ITERATION STARTS WITH THE NEXT INSTANCE OF ENTRY TAGS */
				$feed_body = substr( $feed_body, ( $pos2 + strlen( $closing_tag ) ) );
			}
		}
	}
	/* GET CACHED REVIEWS */
	$old_reviews = get_option( 'iprm_review_cache' );
	/* ADD CACHED REVIEWS TO NEW REVIEWS */
	if ( $old_reviews != '' ) {
		$reviews = array_merge( $reviews, $old_reviews );
	}
	/* REMOVE DUPLICATES FROM COMBINED REVIEW ARRAY */
	$reviews = iprm_remove_duplicates_from_review_array( $reviews );
	/* ADD TIME AND REVIEW COUNT TO REVIEW CACHE HISTORY */
	$review_count = count( $reviews );
	$current_time = current_time( 'mysql' );
	$iprm_review_cache_history = get_option( 'iprm_review_cache_history' );
	if ( !is_array( $iprm_review_cache_history ) ) {
		$iprm_review_cache_history = array( );
	}
	array_push( $iprm_review_cache_history, array( 'time' => $current_time, 'count' => $review_count ) );
	/* REPLACE OLD REVIEW CACHE HISTORY WITH NEW REVIEW CACHE HISTORY */
	update_option( 'iprm_review_cache_history', $iprm_review_cache_history );
	/* REPLACE OLD CACHED REVIEWS WITH NEW CACHED REVIEWS */
	update_option( 'iprm_review_cache', $reviews );
	/* RETURN COMBINED REVIEW ARRAY */
	return $reviews;
}
function iprm_plugin_main() {
	/* DISABLES FOR NON-ADMINISTRATORS */
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	/* IF URL IS ENTERED, UPDATE ITUNES URL. IF ITUNES URL IS NOT FOUND, TRY TO GET IT FROM POWERPRESS OPTION VALUE */
	if ( $podcast_url = esc_url( $_POST["podcasturl"] ) ) { 
		update_option( 'iprm_itunes_url', $podcast_url );
		delete_option( 'iprm_review_cache' );
		delete_option( 'iprm_review_cache_history' );
	}
	elseif ( !get_option( 'iprm_itunes_url' ) ) {
		$powerpress_feed = get_option( 'powerpress_feed' );
		if ( $podcast_url = esc_url( $powerpress_feed['itunes_url'] ) ) {
			update_option( 'iprm_itunes_url', $podcast_url );
			$itunes_url_auto_detected = TRUE;
		}				
	}
	/* IF CHECK FOR REVIEWS MANUALLY BUTTON IS PRESSED, CHECK FOR REVIEWS */
	if ( $_POST["checkreviews"] == 'Check for Reviews Manually' ) {
		$reviews = iprm_get_itunes_feed_contents();
	}
	/* DISPLAY PLUGIN MENU */
	echo '<div class="wrap">';
	echo '<form action="' . $_SERVER["REQUEST_URI"] . '" method="POST"><table border="1" cellpadding="10" cellspacing="0" style="background: #efefef; max-width: 1200px; vertical-align: top;">';
	/* DISPLAY ITUNES URL AND OPTION TO CHANGE IT */
	echo '<tr><td style="vertical-align: top;"><h3>iTunes Podcast URL</h3>';
	if ( $itunes_url_auto_detected ) {
		echo '<p><b>We detected the following iTunes podcast URL. If this is incorrect, please enter your iTunes podcast URL.</b></p>';
	}
	else {
		echo '<p><b>Please enter your iTunes podcast URL.</b></p>';
	}
	echo '<p><i>Example: http://itunes.apple.com/us/podcast/professional-wordpress-podcast/id885696994.</i></p>';
	echo '<p><input type="text" name="podcasturl" size="80" value="' . get_option( 'iprm_itunes_url' ) . '"></p></p><input class="button-primary" type="submit" name="updateurl" value="Update Podcast URL"></p>';
	echo '</td>';
	/* DISPLAY CACHE HISTORY AND MANUAL REVIEW CHECK BUTTON */
	echo '<td style="vertical-align: top;"><h3>Cached Reviews</h3><p><b>Recent Cache History: </b></p><p>';
	$iprm_review_cache_history = get_option( 'iprm_review_cache_history' );
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
	echo '</p><p>This plugin will automatically check every 4 hours.</p><p><input class="button-primary" type="submit" name="checkreviews" value="Check for Reviews Manually"></p>';
	echo '</td></tr>';
	echo '</table></form><br />';
	/* DISPLAY REVIEWS FROM CACHE OR GENERATE NEW REVIEWS IF CACHE IS EMPTY */
	$review_cache_array = get_option( 'iprm_review_cache' );
	if ( ( $review_cache_array == '' ) || ( is_array( $review_cache_array ) && empty( $review_cache_array ) ) ) {
		echo iprm_display_reviews( iprm_get_itunes_feed_contents() );
	}
	else {
		echo iprm_display_reviews( get_option( 'iprm_review_cache' ) );
	}
	/* DISPLAY FULL CACHE HISTORY */
	/*echo iprm_get_full_cache_history();/**/
	echo '</div>';
}
function iprm_plugin_menu() {
	/* ADD PLUGIN MENU */
	add_menu_page( 'Podcast Reviews', 'Podcast Reviews', 'manage_options', 'iprm', 'iprm_plugin_main' );
}

?>