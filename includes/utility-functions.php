<?php

/* FOR UTILITY FUNCTIONS */

function iprm_get_country_data( $country_code, $country_name ) {
	/* RETURNS AN ARRAY OF COUNTRY CODES WITH COUNTRY NAMES, OR THE COUNTRY NAME ASSOCIATED WITH A PARTICULAR COUNTRY CODE, OR THE COUNTRY CODE ASSOCIATED WITH A PARTICULAR COUNTRY NAME */
	$countries = array( 
		array( 'code' => 'us', 'name' => 'United States' ), 
		array( 'code' => 'gb', 'name' => 'United Kingdom' ), 
		array( 'code' => 'ca', 'name' => 'Canada' ), 
		array( 'code' => 'au', 'name' => 'Australia' ), 
		array( 'code' => 'ad', 'name' => 'Andorra' ), 
		array( 'code' => 'ae', 'name' => 'United Arab Emirates' ), 
		array( 'code' => 'ag', 'name' => 'Antigua and Barbuda' ), 
		array( 'code' => 'al', 'name' => 'Albania' ), 
		array( 'code' => 'am', 'name' => 'Armenia' ), 
		array( 'code' => 'ao', 'name' => 'Angola' ), 
		array( 'code' => 'ar', 'name' => 'Argentina' ), 
		array( 'code' => 'at', 'name' => 'Austria' ), 
		array( 'code' => 'az', 'name' => 'Azerbaijan' ), 
		array( 'code' => 'ba', 'name' => 'Bosnia and Herzegovina' ), 
		array( 'code' => 'bb', 'name' => 'Barbados' ), 
		array( 'code' => 'bd', 'name' => 'Bangladesh' ), 
		array( 'code' => 'be', 'name' => 'Belgium' ), 
		array( 'code' => 'bf', 'name' => 'Burkina Faso' ), 
		array( 'code' => 'bg', 'name' => 'Bulgaria' ), 
		array( 'code' => 'bh', 'name' => 'Bahrain' ), 
		array( 'code' => 'bi', 'name' => 'Burundi' ), 
		array( 'code' => 'bj', 'name' => 'Benin' ), 
		array( 'code' => 'bm', 'name' => 'Bermuda' ), 
		array( 'code' => 'bn', 'name' => 'Brunei Darussalam' ), 
		array( 'code' => 'bo', 'name' => 'Bolivia' ), 
		array( 'code' => 'br', 'name' => 'Brazil' ), 
		array( 'code' => 'bs', 'name' => 'Bahamas' ), 
		array( 'code' => 'bt', 'name' => 'Bhutan' ), 
		array( 'code' => 'bw', 'name' => 'Botswana' ), 
		array( 'code' => 'by', 'name' => 'Belarus' ), 
		array( 'code' => 'bz', 'name' => 'Belize' ), 
		array( 'code' => 'cd', 'name' => 'Democratic Republic of the Congo' ), 
		array( 'code' => 'cf', 'name' => 'Central African Republic' ), 
		array( 'code' => 'cg', 'name' => 'Congo' ), 
		array( 'code' => 'ch', 'name' => 'Switzerland' ), 
		array( 'code' => 'ci', 'name' => 'Côte d’Ivoire' ), 
		array( 'code' => 'cl', 'name' => 'Chile' ), 
		array( 'code' => 'cm', 'name' => 'Cameroon' ), 
		array( 'code' => 'cn', 'name' => 'China' ), 
		array( 'code' => 'co', 'name' => 'Colombia' ), 
		array( 'code' => 'cr', 'name' => 'Costa Rica' ), 
		array( 'code' => 'cu', 'name' => 'Cuba' ), 
		array( 'code' => 'cv', 'name' => 'Cape Verde' ), 
		array( 'code' => 'cy', 'name' => 'Cyprus' ), 
		array( 'code' => 'cz', 'name' => 'Czech' ), 
		array( 'code' => 'de', 'name' => 'Germany' ), 
		array( 'code' => 'dj', 'name' => 'Djibouti' ), 
		array( 'code' => 'dk', 'name' => 'Denmark' ), 
		array( 'code' => 'dm', 'name' => 'Dominica' ), 
		array( 'code' => 'do', 'name' => 'Dominican Republic' ), 
		array( 'code' => 'dz', 'name' => 'Algeria' ), 
		array( 'code' => 'ec', 'name' => 'Ecuador' ), 
		array( 'code' => 'ee', 'name' => 'Estonia' ), 
		array( 'code' => 'eg', 'name' => 'Egypt' ), 
		array( 'code' => 'er', 'name' => 'Eritrea' ), 
		array( 'code' => 'es', 'name' => 'Spain' ), 
		array( 'code' => 'et', 'name' => 'Ethiopia' ), 
		array( 'code' => 'fi', 'name' => 'Finland' ), 
		array( 'code' => 'fj', 'name' => 'Fiji' ), 
		array( 'code' => 'fk', 'name' => 'Falkland Islands' ), 
		array( 'code' => 'fo', 'name' => 'Faroe Islands' ), 
		array( 'code' => 'fr', 'name' => 'France' ), 
		array( 'code' => 'ga', 'name' => 'Gabon' ), 
		array( 'code' => 'gd', 'name' => 'Grenada' ), 
		array( 'code' => 'ge', 'name' => 'Georgia' ), 
		array( 'code' => 'gl', 'name' => 'Greenland' ), 
		array( 'code' => 'gm', 'name' => 'Gambia' ), 
		array( 'code' => 'gn', 'name' => 'Guinea' ), 
		array( 'code' => 'gq', 'name' => 'Equatorial Guinea' ), 
		array( 'code' => 'gr', 'name' => 'Greece' ), 
		array( 'code' => 'gs', 'name' => 'South Georgia and South Sandwich Islands' ), 
		array( 'code' => 'gt', 'name' => 'Guatemala' ), 
		array( 'code' => 'gw', 'name' => 'Guinea-Bissau' ), 
		array( 'code' => 'gy', 'name' => 'Guyana' ), 
		array( 'code' => 'hk', 'name' => 'Hong Kong' ), 
		array( 'code' => 'hn', 'name' => 'Honduras' ), 
		array( 'code' => 'hr', 'name' => 'Croatia' ), 
		array( 'code' => 'ht', 'name' => 'Haiti' ), 
		array( 'code' => 'hu', 'name' => 'Hungary' ), 
		array( 'code' => 'id', 'name' => 'Indonesia' ), 
		array( 'code' => 'ie', 'name' => 'Ireland' ), 
		array( 'code' => 'il', 'name' => 'Israel' ), 
		array( 'code' => 'im', 'name' => 'Isle of Man' ), 
		array( 'code' => 'in', 'name' => 'India' ), 
		array( 'code' => 'iq', 'name' => 'Iraq' ), 
		array( 'code' => 'ir', 'name' => 'Iran' ), 
		array( 'code' => 'is', 'name' => 'Iceland' ), 
		array( 'code' => 'it', 'name' => 'Italy' ), 
		array( 'code' => 'jm', 'name' => 'Jamaica' ), 
		array( 'code' => 'jo', 'name' => 'Jordan' ), 
		array( 'code' => 'jp', 'name' => 'Japan' ), 
		array( 'code' => 'ke', 'name' => 'Kenya' ), 
		array( 'code' => 'kg', 'name' => 'Kyrgyzstan' ), 
		array( 'code' => 'kh', 'name' => 'Cambodia' ), 
		array( 'code' => 'ki', 'name' => 'Kiribati' ), 
		array( 'code' => 'km', 'name' => 'Comoros' ), 
		array( 'code' => 'kp', 'name' => 'North Korea' ), 
		array( 'code' => 'kr', 'name' => 'South Korea' ), 
		array( 'code' => 'kw', 'name' => 'Kuwait' ), 
		array( 'code' => 'ky', 'name' => 'Cayman Islands' ), 
		array( 'code' => 'kz', 'name' => 'Kazakhstan' ), 
		array( 'code' => 'la', 'name' => 'Lao People’s Democratic Republic' ), 
		array( 'code' => 'lb', 'name' => 'Lebanon' ), 
		array( 'code' => 'lc', 'name' => 'Saint Lucia' ), 
		array( 'code' => 'li', 'name' => 'Liechtenstein' ), 
		array( 'code' => 'lk', 'name' => 'Sri Lanka' ), 
		array( 'code' => 'lr', 'name' => 'Liberia' ), 
		array( 'code' => 'ls', 'name' => 'Lesotho' ), 
		array( 'code' => 'lt', 'name' => 'Lithuania' ), 
		array( 'code' => 'lu', 'name' => 'Luxembourg' ), 
		array( 'code' => 'lv', 'name' => 'Latvia' ), 
		array( 'code' => 'ly', 'name' => 'Libyan Jamahiriya' ), 
		array( 'code' => 'ma', 'name' => 'Morocco' ), 
		array( 'code' => 'mc', 'name' => 'Monaco' ), 
		array( 'code' => 'md', 'name' => 'Moldova' ), 
		array( 'code' => 'me', 'name' => 'Montenegro' ), 
		array( 'code' => 'mg', 'name' => 'Madagascar' ), 
		array( 'code' => 'mk', 'name' => 'Macedonia' ), 
		array( 'code' => 'ml', 'name' => 'Mali' ), 
		array( 'code' => 'mm', 'name' => 'Myanmar' ), 
		array( 'code' => 'mn', 'name' => 'Mongolia' ), 
		array( 'code' => 'mo', 'name' => 'Macao' ), 
		array( 'code' => 'mr', 'name' => 'Mauritania' ), 
		array( 'code' => 'mt', 'name' => 'Malta' ), 
		array( 'code' => 'mu', 'name' => 'Mauritius' ), 
		array( 'code' => 'mv', 'name' => 'Maldives' ), 
		array( 'code' => 'mw', 'name' => 'Malawi' ), 
		array( 'code' => 'mx', 'name' => 'Mexico' ), 
		array( 'code' => 'my', 'name' => 'Malaysia' ), 
		array( 'code' => 'mz', 'name' => 'Mozambique' ), 
		array( 'code' => 'na', 'name' => 'Namibia' ), 
		array( 'code' => 'nc', 'name' => 'New Caledonia' ), 
		array( 'code' => 'ne', 'name' => 'Niger' ), 
		array( 'code' => 'ng', 'name' => 'Nigeria' ), 
		array( 'code' => 'ni', 'name' => 'Nicaragua' ), 
		array( 'code' => 'nl', 'name' => 'Netherlands' ), 
		array( 'code' => 'no', 'name' => 'Norway' ), 
		array( 'code' => 'np', 'name' => 'Nepal' ), 
		array( 'code' => 'nr', 'name' => 'Nauru' ), 
		array( 'code' => 'nz', 'name' => 'New Zealand' ), 
		array( 'code' => 'om', 'name' => 'Oman' ), 
		array( 'code' => 'pa', 'name' => 'Panama' ), 
		array( 'code' => 'pe', 'name' => 'Peru' ), 
		array( 'code' => 'pf', 'name' => 'French Polynesia' ), 
		array( 'code' => 'pg', 'name' => 'Papua New Guinea' ), 
		array( 'code' => 'ph', 'name' => 'Philippines' ), 
		array( 'code' => 'pk', 'name' => 'Pakistan' ), 
		array( 'code' => 'pl', 'name' => 'Poland' ), 
		array( 'code' => 'pt', 'name' => 'Portugal' ), 
		array( 'code' => 'py', 'name' => 'Paraguay' ), 
		array( 'code' => 'qa', 'name' => 'Qatar' ), 
		array( 'code' => 'ro', 'name' => 'Romania' ), 
		array( 'code' => 'rs', 'name' => 'Serbia' ), 
		array( 'code' => 'ru', 'name' => 'Russian Federation' ), 
		array( 'code' => 'rw', 'name' => 'Rwanda' ), 
		array( 'code' => 'sa', 'name' => 'Saudi Arabia' ), 
		array( 'code' => 'sb', 'name' => 'Solomon Islands' ), 
		array( 'code' => 'sc', 'name' => 'Seychelles' ), 
		array( 'code' => 'sd', 'name' => 'Sudan' ), 
		array( 'code' => 'se', 'name' => 'Sweden' ), 
		array( 'code' => 'sg', 'name' => 'Singapore' ), 
		array( 'code' => 'sh', 'name' => 'Saint Helena' ), 
		array( 'code' => 'si', 'name' => 'Slovenia' ), 
		array( 'code' => 'sk', 'name' => 'Slovakia' ), 
		array( 'code' => 'sl', 'name' => 'Sierra Leone' ), 
		array( 'code' => 'sn', 'name' => 'Senegal' ), 
		array( 'code' => 'so', 'name' => 'Somalia' ), 
		array( 'code' => 'sr', 'name' => 'Suriname' ), 
		array( 'code' => 'st', 'name' => 'Sao Tome and Principe' ), 
		array( 'code' => 'sv', 'name' => 'El Salvador' ), 
		array( 'code' => 'sy', 'name' => 'Syrian Arab Republic' ), 
		array( 'code' => 'sz', 'name' => 'Swaziland' ), 
		array( 'code' => 'td', 'name' => 'Chad' ), 
		array( 'code' => 'tg', 'name' => 'Togo' ), 
		array( 'code' => 'th', 'name' => 'Thailand' ), 
		array( 'code' => 'tj', 'name' => 'Tajikistan' ), 
		array( 'code' => 'tl', 'name' => 'Timor-Leste' ), 
		array( 'code' => 'tm', 'name' => 'Turkmenistan' ), 
		array( 'code' => 'tn', 'name' => 'Tunisia' ), 
		array( 'code' => 'to', 'name' => 'Tonga' ), 
		array( 'code' => 'tr', 'name' => 'Turkey' ), 
		array( 'code' => 'tt', 'name' => 'Trinidad and Tobago' ), 
		array( 'code' => 'tv', 'name' => 'Tuvalu' ), 
		array( 'code' => 'tw', 'name' => 'Taiwan' ), 
		array( 'code' => 'tz', 'name' => 'United Republic of Tanzania' ), 
		array( 'code' => 'ua', 'name' => 'Ukraine' ), 
		array( 'code' => 'ug', 'name' => 'Uganda' ), 
		array( 'code' => 'uy', 'name' => 'Uruguay' ), 
		array( 'code' => 'uz', 'name' => 'Uzbekistan' ), 
		array( 'code' => 'va', 'name' => 'Vatican' ), 
		array( 'code' => 'vc', 'name' => 'Saint Vincent and the Grenadines' ), 
		array( 'code' => 've', 'name' => 'Venezuela' ), 
		array( 'code' => 'vn', 'name' => 'Viet Nam' ), 
		array( 'code' => 'vu', 'name' => 'Vanuatu' ), 
		array( 'code' => 'ws', 'name' => 'Samoa' ), 
		array( 'code' => 'ye', 'name' => 'Yemen' ), 
		array( 'code' => 'yu', 'name' => 'Serbia and Montenegro' ), 
		array( 'code' => 'za', 'name' => 'South Africa' ), 
		array( 'code' => 'zm', 'name' => 'Zambia' ), 
		array( 'code' => 'zw', 'name' => 'Zimbabwe' )
	);
	/* IF NO COUNTRY CODE OR COUNTRY NAME IS PASSED TO THIS FUNCTION, RETURN THE ENTIRE ARRAY */
	if ( ( $country_code == '' ) && ( $country_name == '' ) ) {
		return $countries;
	} 
	/* IF COUNTRY CODE IS SENT, RETURN THE COUNTRY NAME */
	elseif ( $country_code != '' ) {
		foreach ( $countries as $item ) {
			if ( $item['code'] == $country_code ) {
				return $item['name'];
			}
		}
	}
	/* IF COUNTRY NAME IS SENT, RETURN THE COUNTRY CODE */
	elseif ( $country_name != '' ) {
		foreach ( $countries as $item ) {
			if ( $item['name'] == $country_name ) {
				return $item['code'];
			}
		}
	}
	return '';
}
function iprm_cron_add_every_four_hours( $schedules ) {
	/* ADDS A NEW CRON INTERVAL OF FOUR HOURS */
	$schedules['four_hours'] = array(
		'interval' => 14400,
		'display' => __( 'Once Every 4 Hours' )
	);
	return $schedules;
}
function iprm_get_contents_inside_tag( $string, $opening_tag, $closing_tag ) {
	/* GET FIRST POSITIONS OF OPENING AND CLOSING TAGS */
	$pos1 = strpos( $string, $opening_tag );
	$pos2 = strpos( $string, $closing_tag, $pos1 );
	/* IF BOTH ARE FOUND, RETURN THE CONTENTS BETWEEN THEM */
	if ( $pos1 !== FALSE and $pos2 !== FALSE ) {
		return substr( $string, ( $pos1 + strlen( $opening_tag ) ), ( $pos2 - $pos1 - strlen( $opening_tag ) ) );
	}
	/* OTHERWISE, RETURN NOTHING */
	else {
		return '';
	}
}
function iprm_remove_duplicates_from_review_array( $reviews ) {
	/* REMOVES THE DUPLICATE ENTRIES FROM REVIEW ARRAY, AS WELL AS ANY WITHOUT A RATING OR USERNAME */
	$review_count = count( $reviews );
	for ( $i = 0; $i < $review_count; $i++ ) {
		/* REMOVES REVIEWS WITHOUT A RATING OR USERNAME */
		if ( ( $reviews[$i]['rating'] == '' ) || ( $reviews[$i]['name'] == '' ) ) {
			unset( $reviews[$i] );
		}
		/* REMOVES DUPLICATE ENTRIES */
		else {
			for ( $j = $i + 1; $j < $review_count; $j++ ) {
				if ( $reviews[$i] == $reviews[$j] ) {
					unset( $reviews[$j] );
				}
			}
		}
	}
	return $reviews;
}