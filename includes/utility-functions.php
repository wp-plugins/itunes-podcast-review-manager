<?php

/* FOR UTILITY FUNCTIONS */

function iprm_get_country_codes( $code ) {
	/* RETURNS AN ARRAY OF COUNTRY CODES WITH COUNTRY NAMES, OR THE COUNTRY NAME ASSOCIATED WITH A PARTICULAR COUNTRY CODE */
	$country_codes = array( 
		array( 'code' => 'us', 'country' => 'United States' ), 
		array( 'code' => 'gb', 'country' => 'United Kingdom' ), 
		array( 'code' => 'ca', 'country' => 'Canada' ), 
		array( 'code' => 'au', 'country' => 'Australia' ), 
		array( 'code' => 'ad', 'country' => 'Andorra' ), 
		array( 'code' => 'ae', 'country' => 'United Arab Emirates' ), 
		array( 'code' => 'ag', 'country' => 'Antigua and Barbuda' ), 
		array( 'code' => 'al', 'country' => 'Albania' ), 
		array( 'code' => 'am', 'country' => 'Armenia' ), 
		array( 'code' => 'ao', 'country' => 'Angola' ), 
		array( 'code' => 'ar', 'country' => 'Argentina' ), 
		array( 'code' => 'at', 'country' => 'Austria' ), 
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
	/* IF NO COUNTRY CODE IS PASSED TO THIS FUNCTION, RETURN THE ENTIRE ARRAY */
	if ( $code == '' ) {
		return $country_codes;
	} 
	/* OTHERWISE, RETURN THE COUNTRY NAME ASSOCIATED WITH THAT COUNTRY CODE */
	else {
		foreach ( $country_codes as $item ) {
			if ( $item['code'] == $code ) {
				return $item['country'];
			}
		}
		return '';
	}
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