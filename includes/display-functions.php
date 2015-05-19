<?php

/* FOR DISPLAYING CONTENT */

function iprm_display_as_shortcode( ) {
	global $iprm_review_cache;
	return '<div class="wrap iprm">' . iprm_display_reviews( $iprm_review_cache ) . '</div>';
}
function iprm_display_navigation( $current_page ) {
	$navigation = array (
		'iprm_main_page' => array ( 
			'class' => 'dashicons-admin-site', 
			'name' => 'REVIEWS', 
			'target' => '_self',
			'url' => '?page=iprm_main_page', 
			),
		'iprm_settings_page' => array ( 
			'class' => 'dashicons-admin-settings', 
			'name' => 'SETTINGS', 
			'target' => '_self', 
			'url' => '?page=iprm_settings_page', 
			),
		'iprm_premium_page' => array ( 
			'class' => 'dashicons-star-filled', 
			'name' => 'PREMIUM', 
			'target' => '_self', 
			'url' => '?page=iprm_premium_page', 
			),
		);
	$output = '<div class="iprm-navigation">';
	foreach ( $navigation as $item => $value ) {
		$output .= '<a href="' . $value['url'] . '" target="' . $value['target'] . '" class="dashicons-before ' . $value['class'];
		if ( $item == $current_page ) {
			$output .= ' current-page';
		}
		$output .= '"> ' . __( $value['name'], 'iprm_domain' ) . '</a> ';
	}
	$output .= '</div>';
	return $output;
}
function iprm_display_alert( $alert ) {
	if ( $alert ) {
		return '<div class="iprm-alert"><p>' . $alert . '</p></div>';
	}
}
function iprm_display_notice( $notice ) {
	if ( $notice ) {
		return '<div class="iprm-notice"><p>' . $notice . '</p></div>';
	}
}
function iprm_display_itunes_feed_summary( $iprm_settings ) {
	/* CHECKS TO MAKE SURE ITUNES PODCAST URL IS DEFINED */
	if ( $iprm_settings['itunes_url'] != '' ) {
		/* DISPLAY HEADING AND TABLE WITH PODCAST INFO */
		$output = '
			<table class="iprm-table-small-border">
				<tr>
					<td width="15%" rowspan="2">
						<img src="' . $iprm_settings['itunes_feed_image'] . '" />
					</td>
					<th width="85%">
						<h2>' . $iprm_settings['itunes_feed_name'] . '</h2>
					</th>
				</tr>
				<tr>
					<td>
						<p>by ' .  $iprm_settings['itunes_feed_artist'] . '</p>
						<p>' . $iprm_settings['itunes_feed_summary'] . '</p>
					</td>
				</tr>
			</table>
		';
	}
	return $output;
}
function iprm_display_reviews( $reviews ) {
	global $iprm_settings;
	$review_number = 0;
	$output = '';
	$rating_total = 0;
	if ( is_admin() )  {
		$sort_colspan = 2;
	}
	else {
		$sort_colspan = 1;
	}
	$sort_colspan = 2;
	/* CHECKS TO MAKE SURE ITUNES PODCAST URL IS DEFINED */
	if ( $iprm_settings['itunes_url'] != '' ) {
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
			$rating_total += $review['rating'];
			$table_body_output .= '
				<tr>
					<td>' . $review_number . '</td>
					<td class="flag">';
						if ( $review['country'] ) {
							if ( strlen( $review['country'] ) == 2 ) {
								$code = $review['country'];
							}
							else {
								$code = iprm_get_country_data( '', $review['country'] );
							}
							$flag_image = 'images/flags/' . $code . '.png';
							$table_body_output .= '<img src="' . plugins_url( $flag_image, dirname( __FILE__ ) ) . '" />';
						}
					$table_body_output .= '
					</td>
					<td colspan="' . $sort_colspan . '">';
						if ( strlen( $review['country'] ) == 2 ) {
							$table_body_output .= iprm_get_country_data( $review['country'], '' );
						}
						else {
							$table_body_output .= $review['country'];
						}
					$table_body_output .= '
					</td>
					<td colspan="' . $sort_colspan . '">' . substr( $review['review_date'], 0, strpos( $review['review_date'], 'T' ) ) . '</td>
					<td colspan="' . $sort_colspan . '">' . $review['rating'] . '</td>
					<td colspan="' . $sort_colspan . '">' . $review['name'] . '</td>
					<td colspan="' . $sort_colspan . '">' . $review['title'] . '</td>
					<td colspan="' . $sort_colspan . '">' . $review['content'] . '</td>
				</tr>
			';
		}
		/* DISPLAY TABLE */
		$output .= '
			<table class="iprm-review-table iprm-table-small-border">
				<tr>
					<th class="iprm-alt">
						<div class="iprm-sort-text">
							' . __( 'NUMBER', 'iprm_domain' ) . '<br />
							<small>(' . __( 'Total:', 'iprm_domain' ) . ' ' . $review_number . ')</small>
						</div>
					</th>
					<th class="">
						<div class="iprm-sort-text">
							' . __( 'FLAG', 'iprm_domain' ) . '
						</div>
					</th>
					<th class="iprm-alt">
						<div class="iprm-sort-text">
							' . __( 'COUNTRY', 'iprm_domain' ) . '
						</div>
					</th>';
		if ( $sort_colspan == 2 ) {
			$output .= '
					<th class="iprm-sort iprm-alt">
						<div class="iprm-sort-icon">
							<a href="?page=iprm_main_page&country=asc"><span class="dashicons dashicons-arrow-up"></span></a><br />
							<a href="?page=iprm_main_page&country=desc"><span class="dashicons dashicons-arrow-down"></span></a>
						</div>
					</th>';
		}
		$output .= '
					<th class="">
						<div class="iprm-sort-text">
							' . __( 'DATE', 'iprm_domain' ) . '
						</div>
					</th>';
		if ( $sort_colspan == 2 ) {
			$output .= '
					<th class="iprm-sort">
						<div class="iprm-sort-icon">
							<a href="?page=iprm_main_page&date=asc"><span class="dashicons dashicons-arrow-up"></span></a><br />
							<a href="?page=iprm_main_page&date=desc"><span class="dashicons dashicons-arrow-down"></span></a>
						</div>
					</th>';
		}
		$output .= '
					<th class="iprm-alt">
						<div class="iprm-sort-text">
							' . __( 'RATING', 'iprm_domain' ) . '<br />
							<small>(' . __( 'Average:', 'iprm_domain' ) . ' ' . round( ( $rating_total / $review_number ), 2 ) . ')</small>
						</div>
					</th>';
		if ( $sort_colspan == 2 ) {
			$output .= '
					<th class="iprm-sort iprm-alt">
						<div class="iprm-sort-icon">
							<a href="?page=iprm_main_page&rating=asc"><span class="dashicons dashicons-arrow-up"></span></a><br />
							<a href="?page=iprm_main_page&rating=desc"><span class="dashicons dashicons-arrow-down"></span></a>
						</div>
					</th>';
		}
		$output .= '
					<th class="">
						<div class="iprm-sort-text">
							' . __( 'NAME', 'iprm_domain' ) . ' 
						</div>
					</th>';
		if ( $sort_colspan == 2 ) {
			$output .= '
					<th class="iprm-sort">
						<div class="iprm-sort-icon">
							<a href="?page=iprm_main_page&name=asc"><span class="dashicons dashicons-arrow-up"></span></a><br />
							<a href="?page=iprm_main_page&name=desc"><span class="dashicons dashicons-arrow-down"></span></a>
						</div>
					</th>';
		}
		$output .= '
					<th class="iprm-alt">
						<div class="iprm-sort-text">
							' . __( 'TITLE', 'iprm_domain' ) . ' 
						</div>
					</th>';
		if ( $sort_colspan == 2 ) {
			$output .= '
					<th class="iprm-sort iprm-alt">
						<div class="iprm-sort-icon">
							<a href="?page=iprm_main_page&title=asc"><span class="dashicons dashicons-arrow-up"></span></a><br />
							<a href="?page=iprm_main_page&title=desc"><span class="dashicons dashicons-arrow-down"></span></a>
						</div>
					</th>';
		}
		$output .= '
					<th class="">
						<div class="iprm-sort-text">
							' . __( 'REVIEW', 'iprm_domain' ) . ' 
						</div>
					</th>';
		if ( $sort_colspan == 2 ) {
			$output .= '
					<th class="iprm-sort">
						<div class="iprm-sort-icon">
							<a href="?page=iprm_main_page&content=asc"><span class="dashicons dashicons-arrow-up"></span></a><br />
							<a href="?page=iprm_main_page&content=desc"><span class="dashicons dashicons-arrow-down"></span></a>
						</div>
					</th>
				</tr>';
		}
		$output .= $table_body_output . '
			</table>
		';
	}
	else {
		$output .= '<table class="iprm-review-table iprm-table-small-border"><tr><td>' . __( 'No reviews found.', 'iprm_domain' ) . '</td></tr></table>';
	}
	return $output;
}