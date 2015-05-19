<?php

/* FOR DATA PROCESSING */

function iprm_deactivate() {
	wp_clear_scheduled_hook( 'iprm_schedule' );
}
function iprm_get_itunes_feed_contents() {
	global $iprm_review_cache;
	global $iprm_review_cache_history;
	global $iprm_settings;
	$iprm_settings_new = $iprm_settings;
	/* GET ARRAY OF ALL COUNTRY CODES AND COUNTRY NAMES */
	$country_codes = iprm_get_country_data( '', '' );
	/* CHECKS TO MAKE SURE ITUNES PODCAST URL IS DEFINED */
	if ( $iprm_settings['itunes_url'] != '' ) {
		$reviews = array( );
		$review_countries = array( );
		$urls_to_crawl = array( );
		$retrieved_summary = FALSE;

		/* GET PODCAST ID */
		preg_match ( '([0-9][0-9][0-9]+)', $iprm_settings['itunes_url'], $matches );
		$iprm_settings_new['itunes_id'] = $matches[0];
		
		/* CHECK THROUGH THE REVIEW FEEDS FOR EVERY COUNTRY */
		foreach ( $country_codes as $item ) {
			$country_code = $item['code'];
			$url_xml = 'https://itunes.apple.com/' . $country_code . '/rss/customerreviews/id=' . $iprm_settings_new['itunes_id'] . '/xml';
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
					$itunes_feed_name = iprm_get_contents_inside_tag( $current_entry, '<im:name>', '</im:name>' );
					if ( $itunes_feed_name ) {
						$iprm_settings_new['itunes_feed_name'] = iprm_get_contents_inside_tag( $current_entry, '<im:name>', '</im:name>' );
					}
					$itunes_feed_artist = iprm_get_contents_inside_tag( $current_entry, '<im:artist>', '</im:artist>' );
					if ( $itunes_feed_artist ) {
						$iprm_settings_new['itunes_feed_artist'] = iprm_get_contents_inside_tag( $current_entry, '<im:artist>', '</im:artist>' );
					}
					$itunes_feed_summary = iprm_get_contents_inside_tag( $current_entry, '<summary>', '</summary>' );
					if ( $itunes_feed_summary ) {
						$iprm_settings_new['itunes_feed_summary'] = iprm_get_contents_inside_tag( $current_entry, '<summary>', '</summary>' );
					}
					$itunes_feed_image = iprm_get_contents_inside_tag( $current_entry, '<im:image height="170">', '</im:image>' );
					if ( $itunes_feed_image ) {
						$iprm_settings_new['itunes_feed_image'] = iprm_get_contents_inside_tag( $current_entry, '<im:image height="170">', '</im:image>' );
					}
					$retrieved_summary = TRUE;
				}
				/* GET REVIEW URL AND REVIEW URL COUNTRY CODE */
				$review_url = iprm_get_contents_inside_tag( $current_entry, '<uri>', '</uri>' );
				$review_url_country_code = substr( $review_url, ( strpos( $review_url, 'reviews' ) - 3 ), 2 );
				/* ADD NEW REVIEW TO REVIEW ARRAY */
				if ( $current_entry !== '' ) {
					$new_review['country'] = iprm_get_country_data( $review_url_country_code, '' );
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
	/* ADD CACHED REVIEWS TO NEW REVIEWS */
	if ( $iprm_review_cache != '' ) {
		$reviews = array_merge( $reviews, $iprm_review_cache );
	}
	/* REMOVE DUPLICATES FROM COMBINED REVIEW ARRAY */
	$reviews = iprm_remove_duplicates_from_review_array( $reviews );
	/* ADD TIME AND REVIEW COUNT TO REVIEW CACHE HISTORY */
	$review_count = count( $reviews );
	$current_time = current_time( 'mysql' );
	if ( !is_array( $iprm_review_cache_history ) ) {
		$iprm_review_cache_history = array( );
	}
	array_push( $iprm_review_cache_history, array( 'time' => $current_time, 'count' => $review_count ) );
	iprm_update_option( 'iprm_settings', $iprm_settings_new );
	/* REPLACE OLD REVIEW CACHE HISTORY WITH NEW REVIEW CACHE HISTORY */
	iprm_update_option( 'iprm_review_cache_history', $iprm_review_cache_history );
	/* REPLACE OLD CACHED REVIEWS WITH NEW CACHED REVIEWS */
	iprm_update_option( 'iprm_review_cache', $reviews );
	/* RETURN COMBINED REVIEW ARRAY */
	return $reviews;
}
function iprm_delete_option( $option ) {
	delete_option( $option );
	// delete_option( $option );
}
function iprm_get_option( $option ) {
	return get_option( $option );
}
function iprm_update_option( $option_old, $option_new ) {
	update_option( $option_old, $option_new );
	// update_option( $option_old, $option_new );
}