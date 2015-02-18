<?php
/*
Plugin Name: iTunes Podcast Review Manager
Plugin URI: http://podwp.com/plugins/itunes-podcast-review-manager
Description: Gathers all of your international podcast reviews from iTunes and displays them in a table. Upcoming features: column sorting, multiple podcasts, caching. Possible features: rotating widget, email notifications for new reviews.
Version: 1.0
Author: Doug Yuen
Author URI: http://podwp.com
License: GPLv2
*/

add_action( 'admin_menu', 'podwp_iprm_plugin_menu' );

function podwp_iprm_get_contents_inside_tag( $string, $opening_tag, $closing_tag ) {
	$pos1 = strpos( $string, $opening_tag );
	$pos2 = strpos( $string, $closing_tag );
	if ( $pos1 !== FALSE and $pos2 !== FALSE ) {
		return substr( $string, ( $pos1 + strlen( $opening_tag ) ), ( $pos2 - $pos1 - strlen( $opening_tag ) ) );
	}
	else {
		return '';
	}
}
function podwp_iprm_plugin_main() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	$country_codes = array( 
		array( 'code' => 'ad', 'country' => 'Andorra' ), 
		array( 'code' => 'ae', 'country' => 'United Arab Emirates' ), 
		array( 'code' => 'ag', 'country' => 'Antigua and Barbuda' ), 
		array( 'code' => 'al', 'country' => 'Albania' ), 
		array( 'code' => 'am', 'country' => 'Armenia' ), 
		array( 'code' => 'ao', 'country' => 'Angola' ), 
		array( 'code' => 'ar', 'country' => 'Argentina' ), 
		array( 'code' => 'at', 'country' => 'Austria' ), 
		array( 'code' => 'au', 'country' => 'Australia' ), 
		array( 'code' => 'az', 'country' => 'Azerbaijan' ), 
		array( 'code' => 'ba', 'country' => 'Bosnia and Herzegovina' ), 
		array( 'code' => 'bb', 'country' => 'Barbados' ), 
		array( 'code' => 'bd', 'country' => 'Bangladesh' ), 
		array( 'code' => 'be', 'country' => 'Belgium' ), 
		array( 'code' => 'bf', 'country' => 'Burkina Faso' ), 
		array( 'code' => 'bg', 'country' => 'Bulgaria' ), 
		array( 'code' => 'bh', 'country' => 'Bahrain' ), 
		array( 'code' => 'bi', 'country' => 'Burundi' ), 
		array( 'code' => 'bj', 'country' => 'Benin' ), 
		array( 'code' => 'bm', 'country' => 'Bermuda' ), 
		array( 'code' => 'bn', 'country' => 'Brunei Darussalam' ), 
		array( 'code' => 'bo', 'country' => 'Bolivia' ), 
		array( 'code' => 'br', 'country' => 'Brazil' ), 
		array( 'code' => 'bs', 'country' => 'Bahamas' ), 
		array( 'code' => 'bt', 'country' => 'Bhutan' ), 
		array( 'code' => 'bw', 'country' => 'Botswana' ), 
		array( 'code' => 'by', 'country' => 'Belarus' ), 
		array( 'code' => 'bz', 'country' => 'Belize' ), 
		array( 'code' => 'ca', 'country' => 'Canada' ), 
		array( 'code' => 'cd', 'country' => 'Democratic Republic of the Congo' ), 
		array( 'code' => 'cf', 'country' => 'Central African Republic' ), 
		array( 'code' => 'cg', 'country' => 'Congo' ), 
		array( 'code' => 'ch', 'country' => 'Switzerland' ), 
		array( 'code' => 'ci', 'country' => 'Côte d’Ivoire' ), 
		array( 'code' => 'cl', 'country' => 'Chile' ), 
		array( 'code' => 'cm', 'country' => 'Cameroon' ), 
		array( 'code' => 'cn', 'country' => 'China' ), 
		array( 'code' => 'co', 'country' => 'Colombia' ), 
		array( 'code' => 'cr', 'country' => 'Costa Rica' ), 
		array( 'code' => 'cu', 'country' => 'Cuba' ), 
		array( 'code' => 'cv', 'country' => 'Cape Verde' ), 
		array( 'code' => 'cy', 'country' => 'Cyprus' ), 
		array( 'code' => 'cz', 'country' => 'Czech' ), 
		array( 'code' => 'de', 'country' => 'Germany' ), 
		array( 'code' => 'dj', 'country' => 'Djibouti' ), 
		array( 'code' => 'dk', 'country' => 'Denmark' ), 
		array( 'code' => 'dm', 'country' => 'Dominica' ), 
		array( 'code' => 'do', 'country' => 'Dominican Republic' ), 
		array( 'code' => 'dz', 'country' => 'Algeria' ), 
		array( 'code' => 'ec', 'country' => 'Ecuador' ), 
		array( 'code' => 'ee', 'country' => 'Estonia' ), 
		array( 'code' => 'eg', 'country' => 'Egypt' ), 
		array( 'code' => 'er', 'country' => 'Eritrea' ), 
		array( 'code' => 'es', 'country' => 'Spain' ), 
		array( 'code' => 'et', 'country' => 'Ethiopia' ), 
		array( 'code' => 'fi', 'country' => 'Finland' ), 
		array( 'code' => 'fj', 'country' => 'Fiji' ), 
		array( 'code' => 'fk', 'country' => 'Falkland Islands' ), 
		array( 'code' => 'fo', 'country' => 'Faroe Islands' ), 
		array( 'code' => 'fr', 'country' => 'France' ), 
		array( 'code' => 'ga', 'country' => 'Gabon' ), 
		array( 'code' => 'gb', 'country' => 'United Kingdom' ), 
		array( 'code' => 'gd', 'country' => 'Grenada' ), 
		array( 'code' => 'ge', 'country' => 'Georgia' ), 
		array( 'code' => 'gl', 'country' => 'Greenland' ), 
		array( 'code' => 'gm', 'country' => 'Gambia' ), 
		array( 'code' => 'gn', 'country' => 'Guinea' ), 
		array( 'code' => 'gq', 'country' => 'Equatorial Guinea' ), 
		array( 'code' => 'gr', 'country' => 'Greece' ), 
		array( 'code' => 'gs', 'country' => 'South Georgia and South Sandwich Islands' ), 
		array( 'code' => 'gt', 'country' => 'Guatemala' ), 
		array( 'code' => 'gw', 'country' => 'Guinea-Bissau' ), 
		array( 'code' => 'gy', 'country' => 'Guyana' ), 
		array( 'code' => 'hk', 'country' => 'Hong Kong' ), 
		array( 'code' => 'hn', 'country' => 'Honduras' ), 
		array( 'code' => 'hr', 'country' => 'Croatia' ), 
		array( 'code' => 'ht', 'country' => 'Haiti' ), 
		array( 'code' => 'hu', 'country' => 'Hungary' ), 
		array( 'code' => 'id', 'country' => 'Indonesia' ), 
		array( 'code' => 'ie', 'country' => 'Ireland' ), 
		array( 'code' => 'il', 'country' => 'Israel' ), 
		array( 'code' => 'im', 'country' => 'Isle of Man' ), 
		array( 'code' => 'in', 'country' => 'India' ), 
		array( 'code' => 'iq', 'country' => 'Iraq' ), 
		array( 'code' => 'ir', 'country' => 'Iran' ), 
		array( 'code' => 'is', 'country' => 'Iceland' ), 
		array( 'code' => 'it', 'country' => 'Italy' ), 
		array( 'code' => 'jm', 'country' => 'Jamaica' ), 
		array( 'code' => 'jo', 'country' => 'Jordan' ), 
		array( 'code' => 'jp', 'country' => 'Japan' ), 
		array( 'code' => 'ke', 'country' => 'Kenya' ), 
		array( 'code' => 'kg', 'country' => 'Kyrgyzstan' ), 
		array( 'code' => 'kh', 'country' => 'Cambodia' ), 
		array( 'code' => 'ki', 'country' => 'Kiribati' ), 
		array( 'code' => 'km', 'country' => 'Comoros' ), 
		array( 'code' => 'kp', 'country' => 'North Korea' ), 
		array( 'code' => 'kr', 'country' => 'South Korea' ), 
		array( 'code' => 'kw', 'country' => 'Kuwait' ), 
		array( 'code' => 'ky', 'country' => 'Cayman Islands' ), 
		array( 'code' => 'kz', 'country' => 'Kazakhstan' ), 
		array( 'code' => 'la', 'country' => 'Lao People’s Democratic Republic' ), 
		array( 'code' => 'lb', 'country' => 'Lebanon' ), 
		array( 'code' => 'lc', 'country' => 'Saint Lucia' ), 
		array( 'code' => 'li', 'country' => 'Liechtenstein' ), 
		array( 'code' => 'lk', 'country' => 'Sri Lanka' ), 
		array( 'code' => 'lr', 'country' => 'Liberia' ), 
		array( 'code' => 'ls', 'country' => 'Lesotho' ), 
		array( 'code' => 'lt', 'country' => 'Lithuania' ), 
		array( 'code' => 'lu', 'country' => 'Luxembourg' ), 
		array( 'code' => 'lv', 'country' => 'Latvia' ), 
		array( 'code' => 'ly', 'country' => 'Libyan Jamahiriya' ), 
		array( 'code' => 'ma', 'country' => 'Morocco' ), 
		array( 'code' => 'mc', 'country' => 'Monaco' ), 
		array( 'code' => 'md', 'country' => 'Moldova' ), 
		array( 'code' => 'me', 'country' => 'Montenegro' ), 
		array( 'code' => 'mg', 'country' => 'Madagascar' ), 
		array( 'code' => 'mk', 'country' => 'Macedonia' ), 
		array( 'code' => 'ml', 'country' => 'Mali' ), 
		array( 'code' => 'mm', 'country' => 'Myanmar' ), 
		array( 'code' => 'mn', 'country' => 'Mongolia' ), 
		array( 'code' => 'mo', 'country' => 'Macao' ), 
		array( 'code' => 'mr', 'country' => 'Mauritania' ), 
		array( 'code' => 'mt', 'country' => 'Malta' ), 
		array( 'code' => 'mu', 'country' => 'Mauritius' ), 
		array( 'code' => 'mv', 'country' => 'Maldives' ), 
		array( 'code' => 'mw', 'country' => 'Malawi' ), 
		array( 'code' => 'mx', 'country' => 'Mexico' ), 
		array( 'code' => 'my', 'country' => 'Malaysia' ), 
		array( 'code' => 'mz', 'country' => 'Mozambique' ), 
		array( 'code' => 'na', 'country' => 'Namibia' ), 
		array( 'code' => 'nc', 'country' => 'New Caledonia' ), 
		array( 'code' => 'ne', 'country' => 'Niger' ), 
		array( 'code' => 'ng', 'country' => 'Nigeria' ), 
		array( 'code' => 'ni', 'country' => 'Nicaragua' ), 
		array( 'code' => 'nl', 'country' => 'Netherlands' ), 
		array( 'code' => 'no', 'country' => 'Norway' ), 
		array( 'code' => 'np', 'country' => 'Nepal' ), 
		array( 'code' => 'nr', 'country' => 'Nauru' ), 
		array( 'code' => 'nz', 'country' => 'New Zealand' ), 
		array( 'code' => 'om', 'country' => 'Oman' ), 
		array( 'code' => 'pa', 'country' => 'Panama' ), 
		array( 'code' => 'pe', 'country' => 'Peru' ), 
		array( 'code' => 'pf', 'country' => 'French Polynesia' ), 
		array( 'code' => 'pg', 'country' => 'Papua New Guinea' ), 
		array( 'code' => 'ph', 'country' => 'Philippines' ), 
		array( 'code' => 'pk', 'country' => 'Pakistan' ), 
		array( 'code' => 'pl', 'country' => 'Poland' ), 
		array( 'code' => 'pt', 'country' => 'Portugal' ), 
		array( 'code' => 'py', 'country' => 'Paraguay' ), 
		array( 'code' => 'qa', 'country' => 'Qatar' ), 
		array( 'code' => 'ro', 'country' => 'Romania' ), 
		array( 'code' => 'rs', 'country' => 'Serbia' ), 
		array( 'code' => 'ru', 'country' => 'Russian Federation' ), 
		array( 'code' => 'rw', 'country' => 'Rwanda' ), 
		array( 'code' => 'sa', 'country' => 'Saudi Arabia' ), 
		array( 'code' => 'sb', 'country' => 'Solomon Islands' ), 
		array( 'code' => 'sc', 'country' => 'Seychelles' ), 
		array( 'code' => 'sd', 'country' => 'Sudan' ), 
		array( 'code' => 'se', 'country' => 'Sweden' ), 
		array( 'code' => 'sg', 'country' => 'Singapore' ), 
		array( 'code' => 'sh', 'country' => 'Saint Helena' ), 
		array( 'code' => 'si', 'country' => 'Slovenia' ), 
		array( 'code' => 'sk', 'country' => 'Slovakia' ), 
		array( 'code' => 'sl', 'country' => 'Sierra Leone' ), 
		array( 'code' => 'sn', 'country' => 'Senegal' ), 
		array( 'code' => 'so', 'country' => 'Somalia' ), 
		array( 'code' => 'sr', 'country' => 'Suriname' ), 
		array( 'code' => 'st', 'country' => 'Sao Tome and Principe' ), 
		array( 'code' => 'sv', 'country' => 'El Salvador' ), 
		array( 'code' => 'sy', 'country' => 'Syrian Arab Republic' ), 
		array( 'code' => 'sz', 'country' => 'Swaziland' ), 
		array( 'code' => 'td', 'country' => 'Chad' ), 
		array( 'code' => 'tg', 'country' => 'Togo' ), 
		array( 'code' => 'th', 'country' => 'Thailand' ), 
		array( 'code' => 'tj', 'country' => 'Tajikistan' ), 
		array( 'code' => 'tl', 'country' => 'Timor-Leste' ), 
		array( 'code' => 'tm', 'country' => 'Turkmenistan' ), 
		array( 'code' => 'tn', 'country' => 'Tunisia' ), 
		array( 'code' => 'to', 'country' => 'Tonga' ), 
		array( 'code' => 'tr', 'country' => 'Turkey' ), 
		array( 'code' => 'tt', 'country' => 'Trinidad and Tobago' ), 
		array( 'code' => 'tv', 'country' => 'Tuvalu' ), 
		array( 'code' => 'tw', 'country' => 'Taiwan' ), 
		array( 'code' => 'tz', 'country' => 'United Republic of Tanzania' ), 
		array( 'code' => 'ua', 'country' => 'Ukraine' ), 
		array( 'code' => 'ug', 'country' => 'Uganda' ), 
		array( 'code' => 'us', 'country' => 'United States' ), 
		array( 'code' => 'uy', 'country' => 'Uruguay' ), 
		array( 'code' => 'uz', 'country' => 'Uzbekistan' ), 
		array( 'code' => 'va', 'country' => 'Vatican' ), 
		array( 'code' => 'vc', 'country' => 'Saint Vincent and the Grenadines' ), 
		array( 'code' => 've', 'country' => 'Venezuela' ), 
		array( 'code' => 'vn', 'country' => 'Viet Nam' ), 
		array( 'code' => 'vu', 'country' => 'Vanuatu' ), 
		array( 'code' => 'ws', 'country' => 'Samoa' ), 
		array( 'code' => 'ye', 'country' => 'Yemen' ), 
		array( 'code' => 'yu', 'country' => 'Serbia and Montenegro' ), 
		array( 'code' => 'za', 'country' => 'South Africa' ), 
		array( 'code' => 'zm', 'country' => 'Zambia' ), 
		array( 'code' => 'zw', 'country' => 'Zimbabwe' )
	);
	if ( $podcast_url = esc_url( $_POST["podcasturl"] ) ) { 
		update_option( 'podwp_iprm_itunes_url', $podcast_url );
	}
	elseif ( !get_option( 'podwp_iprm_itunes_url' ) ) {
		$powerpress_feed = get_option( 'powerpress_feed' );
		if ( $podcast_url = esc_url( $powerpress_feed['itunes_url'] ) ) {
			update_option( 'podwp_iprm_itunes_url', $podcast_url );
			$itunes_url_auto_detected = TRUE;
		}				
	}
	if ( get_option( 'podwp_iprm_itunes_url' ) ) {
		$podcast_url = get_option( 'podwp_iprm_itunes_url' );
		preg_match ( '([0-9][0-9][0-9]+)', $podcast_url, $matches );
		$id = $matches[0];
		$number = 0;
		$reviews = array( );
		$review_countries = array( );
		$retrieved_summary = FALSE;
		foreach ( $country_codes as $item ) {
			$country_code = $item['code'];
			$url_xml = 'https://itunes.apple.com/' . $country_code . '/rss/customerreviews/id=' . $id . '/xml';
			$itunes_xml = wp_remote_get( $url_xml );
			$itunes_json = json_encode( $itunes_xml );
			$data2 = json_decode( $itunes_json, TRUE );
			$feed_body = $data2['body'];
			while ( strpos( $feed_body, '<entry>' ) !== false ) {
				$new_review = array( );
				$opening_tag = '<entry>';
				$closing_tag = '</entry>';
				$pos1 = strpos( $feed_body, $opening_tag );
				$pos2 = strpos( $feed_body, $closing_tag );
				$current_entry = substr( $feed_body, ( $pos1 + strlen( $opening_tag ) ), ( $pos2 - $pos1 - strlen( $opening_tag ) ) );
				if ( !$retrieved_summary ) {
					$feed_name = podwp_iprm_get_contents_inside_tag( $current_entry, '<im:name>', '</im:name>' );
					$feed_artist = podwp_iprm_get_contents_inside_tag( $current_entry, '<im:artist>', '</im:artist>' );
					$feed_summary = podwp_iprm_get_contents_inside_tag( $current_entry, '<summary>', '</summary>' );
					$feed_image = podwp_iprm_get_contents_inside_tag( $current_entry, '<im:image height="55">', '</im:image>' );
					$retrieved_summary = TRUE;
				}	
				$review_url = podwp_iprm_get_contents_inside_tag( $current_entry, '<uri>', '</uri>' );
				$review_url_country_code = substr( $review_url, ( strpos( $review_url, 'reviews' ) - 3 ), 2 );
				if ( ( $country_code === $review_url_country_code ) && ( $current_entry !== '' ) ) {
					$new_review['country'] = $item['country'];
					$new_review['review_date'] = podwp_iprm_get_contents_inside_tag( $current_entry, '<updated>', '</updated>' );
					$new_review['rating'] = podwp_iprm_get_contents_inside_tag( $current_entry, '<im:rating>', '</im:rating>' );
					$new_review['name'] = podwp_iprm_get_contents_inside_tag( $current_entry, '<name>', '</name>' );
					$new_review['title'] = podwp_iprm_get_contents_inside_tag( $current_entry, '<title>', '</title>' );
					$new_review['content'] = podwp_iprm_get_contents_inside_tag( $current_entry, '<content type="text">', '</content>' );
					array_push( $reviews, $new_review );
				}
				$feed_body = substr( $feed_body, ( $pos2 + strlen( $closing_tag ) ) );
			}
		}
	}
	echo '<div class="wrap">';
	echo '<h2>Your Podcast</h2><br /><table border="1" cellpadding="10" cellspacing="0" style="max-width: 1000px;">';
	if ( get_option( 'podwp_iprm_itunes_url' ) ) {
		echo '<tr><td><img src="' . $feed_image . '" /></td><td><h3>' . $feed_name . '</h3>' .  $feed_artist . '<br /><br /></td><td width="50%">' . $feed_summary . '</td></tr>';
	}
	echo '<tr><td colspan="3"><form action="' . $_SERVER["REQUEST_URI"] . '" method="POST">';
	if ( $itunes_url_auto_detected ) {
		echo 'We detected the following iTunes podcast URL. If this is incorrect, please paste your correct iTunes URL in the text box below.<br />';
	}
	else {
		echo '<h3>Please enter your iTunes podcast URL.</h3><i>Example: http://itunes.apple.com/us/podcast/professional-wordpress-podcast/id885696994</i>.<br /><br />';
	}
	echo '<input type="text" name="podcasturl" size="80" value="' . get_option( 'podwp_iprm_itunes_url' ) . '"> <input class="button-primary" type="submit" name="updateurl" value="Update Podcast URL">';
	echo '</form><br /></td></tr></table><br />';
	if ( get_option( 'podwp_iprm_itunes_url' ) ) {
		echo '<h2>Your International iTunes Podcast Reviews</h2><br />';
		echo '<table border="1" cellpadding="10" cellspacing="0" style="max-width: 1000px;">';
		echo '<tr>';
		echo '<th>NUMBER</th>';
		echo '<th>COUNTRY</th>';
		echo '<th>DATE</th>';
		echo '<th>RATING</th>';
		echo '<th>NAME</th>';
		echo '<th>REVIEW TITLE</th>';
		echo '<th>REVIEW TEXT</th>';
		echo '</tr>';
		foreach ($reviews as $key => $row) {
		    $review_date[$key]  = $row['review_date'];
		    $country[$key] = $row['country'];
		}
		array_multisort( $review_date, SORT_DESC, $country, SORT_DESC, $reviews );
		foreach( $reviews as $review ) {
			$number++;
			echo '<tr>';
			echo '<td>' . $number . '</td>';
			echo '<td>' . $review['country'] . '</td>';
			echo '<td>' . substr( $review['review_date'], 0, strpos( $review['review_date'], 'T' ) ) . '</td>';
			echo '<td>' . $review['rating'] . '</td>';
			echo '<td>' . $review['name'] . '</td>';
			echo '<td>' . $review['title'] . '</td>';
			echo '<td>' . $review['content'] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	echo '</div>';
}
function podwp_iprm_plugin_menu() {
	add_menu_page( 'Podcast Reviews', 'Podcast Reviews', 'manage_options', 'podwp_iprm', 'podwp_iprm_plugin_main' );
}

?>