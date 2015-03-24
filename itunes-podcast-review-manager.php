<?php
/*
Plugin Name: iTunes Podcast Review Manager
Plugin URI: http://podwp.com/plugins/itunes-podcast-review-manager
Description: Gathers all of your international podcast reviews from iTunes and displays them in a table. The plugin checks for new reviews in the background every 4 hours. Note: sometimes the iTunes feeds for certain countries are unreachable, and you will have to click the button to manually check for new reviews.
Version: 1.2
Author: Doug Yuen
Author URI: http://efficientwp.com
License: GPLv2
*/

require_once( dirname(__FILE__) . '/includes/utility-functions.php' );
add_action( 'admin_init', 'iprm_plugin_init' );
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
		    $review_country[$key] = $row['country'];
		    $review_rating[$key] = $row['rating'];
		    $review_name[$key] = $row['name'];
		    $review_title[$key] = $row['title'];
		    $review_content[$key] = $row['content'];
		}
		/* SORT REVIEWS BY DATE DESCENDING, THEN COUNTRY DESCENDING */
		
		if ( $_GET["country"] == 'asc' ) { 
			array_multisort( $review_country, SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["country"] == 'desc' ) { 
			array_multisort( $review_country, SORT_DESC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["date"] == 'asc' ) { 
			array_multisort( $review_date, SORT_ASC, $review_country, SORT_DESC, $reviews );
		}
		elseif ( $_GET["date"] == 'desc' ) { 
			array_multisort( $review_date, SORT_DESC, $review_country, SORT_DESC, $reviews );
		}
		elseif ( $_GET["rating"] == 'asc' ) { 
			array_multisort( $review_rating, SORT_ASC, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["rating"] == 'desc' ) { 
			array_multisort( $review_rating, SORT_DESC, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["name"] == 'asc' ) { 
			array_multisort( $review_name, SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["name"] == 'desc' ) { 
			array_multisort( $review_name, SORT_DESC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["title"] == 'asc' ) { 
			array_multisort( $review_title, SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["title"] == 'desc' ) { 
			array_multisort( $review_title, SORT_DESC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["content"] == 'asc' ) { 
			array_multisort( $review_content, SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		elseif ( $_GET["content"] == 'desc' ) { 
			array_multisort( $review_content, SORT_DESC, SORT_STRING | SORT_FLAG_CASE, $review_date, SORT_DESC, $reviews );
		}
		else {
			array_multisort( $review_date, SORT_DESC, $review_country, SORT_DESC, $reviews );
		}
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
		$output .= '<table border="1" cellpadding="10" cellspacing="0" class="iprm-review-table" style="background: #fefefe; max-width: 1200px;">';
		$output .= '<tr>';
		$output .= '<th>NUMBER<br /><small>(Total: ' . $review_number . ')</small></th>';
		$output .= '<th>COUNTRY ';
		$output .= '<a href="?page=iprm&country=asc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-up"></span></a>';
		$output .= '<a href="?page=iprm&country=desc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-down"></span></a> ';
		$output .= '</th>';
		$output .= '<th>DATE ';
		$output .= '<a href="?page=iprm&date=asc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-up"></span></a>';
		$output .= '<a href="?page=iprm&date=desc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-down"></span></a> ';
		$output .= '</th>';
		$output .= '<th>RATING ';
		$output .= '<a href="?page=iprm&rating=asc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-up"></span></a>';
		$output .= '<a href="?page=iprm&rating=desc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-down"></span></a> ';
		$output .= '<br /><small>(Average: ' . round( ( $rating_total / $review_number ), 2 ) . ')</small></th>';
		$output .= '<th>NAME ';
		$output .= '<a href="?page=iprm&name=asc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-up"></span></a>';
		$output .= '<a href="?page=iprm&name=desc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-down"></span></a> ';
		$output .= '</th>';
		$output .= '<th>TITLE ';
		$output .= '<a href="?page=iprm&title=asc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-up"></span></a>';
		$output .= '<a href="?page=iprm&title=desc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-down"></span></a> ';
		$output .= '</th>';
		$output .= '<th>REVIEW ';
		$output .= '<a href="?page=iprm&content=asc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-up"></span></a>';
		$output .= '<a href="?page=iprm&content=desc" class="iprm-sort-icon"><span class="dashicons dashicons-arrow-down"></span></a> ';
		$output .= '</th>';
		$output .= '</tr>';
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
		$urls_to_crawl = array( );
		$retrieved_summary = FALSE;
		$podcast_url = get_option( 'iprm_itunes_url' );
		/* GET PODCAST ID */
		preg_match ( '([0-9][0-9][0-9]+)', $podcast_url, $matches );
		$id = $matches[0];
		/* CHECK THROUGH THE REVIEW FEEDS FOR EVERY COUNTRY */
		foreach ( $country_codes as $item ) {
			$country_code = $item['code'];
			$url_xml = 'https://itunes.apple.com/' . $country_code . '/rss/customerreviews/id=' . $id . '/xml';
			$urls_to_crawl[] = $url_xml;
			$itunes_json1 = json_encode( wp_remote_get( $url_xml ) );
			$data1 = json_decode( $itunes_json1, TRUE );
			$feed_body1 = $data1['body'];/**/
			$first_review_page_url = iprm_get_contents_inside_tag( $feed_body1, '<link rel="first" href="', '"/>' );
			$last_review_page_url = iprm_get_contents_inside_tag( $feed_body1, '<link rel="last" href="', '"/>' );
			$next_review_page_url = iprm_get_contents_inside_tag( $feed_body1, '<link rel="next" href="', '"/>' );
			if ( $first_review_page_url != $last_review_page_url ) {
				$urls_to_crawl[] = $next_review_page_url;
				$i = 0;
				while ( ( $next_review_page_url != $last_review_page_url ) && ( $i < 100 ) ) {
					$next_page_number = iprm_get_contents_inside_tag( $next_review_page_url, 'page=', '/id' );
					$pos = strpos( $next_review_page_url, $next_page_number );
					if ($pos !== false) {
					    $next_review_page_url = substr_replace( $next_review_page_url, $next_page_number + 1, $pos, strlen( $next_page_number ) );
					}
					$urls_to_crawl[] = $next_review_page_url;
					$i++;
				}
			}
		}
		$urls_to_crawl = array_unique( $urls_to_crawl );
		foreach ( $urls_to_crawl as $url ) {
			$itunes_json = json_encode( wp_remote_get( $url ) );
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
function iprm_plugin_init() {
	wp_register_style( 'iprm_plugin_stylesheet', plugins_url( 'style.css', __FILE__ ) );
}
function iprm_plugin_main() {
	/* DISABLES FOR NON-ADMINISTRATORS */
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	/* IF URL IS ENTERED, UPDATE ITUNES URL. IF ITUNES URL IS NOT FOUND, TRY TO GET IT FROM POWERPRESS OPTION VALUE */
	if ( $_POST["podcasturl"] != '' ) { 
		$podcast_url = esc_url( $_POST["podcasturl"] );
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
	echo '<p><input type="text" name="podcasturl" size="80" value="' . get_option( 'iprm_itunes_url' ) . '"></p></p><input class="button-primary" type="submit" name="updateurl" value="Update Podcast URL"><br /><br /></p>';
	echo '<h3>Premium Service - Launching Soon!</h3>';
	echo '<p>For more information and to find out when we launch, please <a href="http://eepurl.com/bhU4SD" target="_blank">enter your email here</a>.</p>';
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
	$page = add_menu_page( 'Podcast Reviews', 'Podcast Reviews', 'manage_options', 'iprm', 'iprm_plugin_main', 'dashicons-star-filled' );
	add_action( 'admin_print_styles-' . $page, 'iprm_plugin_styles' );
}
function iprm_plugin_styles() {
	wp_enqueue_style( 'iprm_plugin_stylesheet' );
}

?>