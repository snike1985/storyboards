<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

/* Fix it
if ( $pvs_global_settings["inetcash_active"] ) {
	$countries = array(
		"AF" => "Afghanistan",
		"AL" => "Albania",
		"DZ" => "Algeria",
		"AS" => "American Samoa",
		"AD" => "Andorra",
		"AO" => "Angola",
		"AI" => "Anguilla",
		"AQ" => "Antarctica",
		"AG" => "Antigua and Barbuda",
		"AR" => "Argentina",
		"AM" => "Armenia",
		"AW" => "Aruba",
		"AU" => "Australia",
		"AT" => "Austria",
		"AZ" => "Azerbaijan",
		"BS" => "Bahamas",
		"BH" => "Bahrain",
		"BD" => "Bangladesh",
		"BB" => "Barbados",
		"BY" => "Belarus",
		"BE" => "Belgium",
		"BZ" => "Belize",
		"BJ" => "Benin",
		"BM" => "Bermuda",
		"BT" => "Bhutan",
		"BO" => "Bolivia",
		"BA" => "Bosnia and Herzegovina",
		"BW" => "Botswana",
		"BV" => "Bouvet Island",
		"BR" => "Brazil",
		"IO" => "British Indian Ocean Territory",
		"BN" => "Brunei Darussalam",
		"BG" => "Bulgaria",
		"BF" => "Burkina Faso",
		"BI" => "Burundi",
		"KH" => "Cambodia",
		"CM" => "Cameroon",
		"CA" => "Canada",
		"CV" => "Cape Verde",
		"KY" => "Cayman Islands",
		"CF" => "Central African Republic",
		"TD" => "Chad",
		"CL" => "Chile",
		"CN" => "China",
		"CX" => "Christmas Island",
		"CC" => "Cocos (Keeling) Islands",
		"CO" => "Colombia",
		"KM" => "Comoros",
		"CG" => "Congo",
		"CD" => "Congo, the Democratic Republic of the",
		"CK" => "Cook Islands",
		"CR" => "Costa Rica",
		"CI" => "Cote D'Ivoire",
		"HR" => "Croatia",
		"CU" => "Cuba",
		"CY" => "Cyprus",
		"CZ" => "Czech Republic",
		"DK" => "Denmark",
		"DJ" => "Djibouti",
		"DM" => "Dominica",
		"DO" => "Dominican Republic",
		"EC" => "Ecuador",
		"EG" => "Egypt",
		"SV" => "El Salvador",
		"GQ" => "Equatorial Guinea",
		"ER" => "Eritrea",
		"EE" => "Estonia",
		"ET" => "Ethiopia",
		"FK" => "Falkland Islands (Malvinas)",
		"FO" => "Faroe Islands",
		"FJ" => "Fiji",
		"FI" => "Finland",
		"FR" => "France",
		"GF" => "French Guiana",
		"PF" => "French Polynesia",
		"TF" => "French Southern Territories",
		"GA" => "Gabon",
		"GM" => "Gambia",
		"GE" => "Georgia",
		"DE" => "Germany",
		"GH" => "Ghana",
		"GI" => "Gibraltar",
		"GR" => "Greece",
		"GL" => "Greenland",
		"GD" => "Grenada",
		"GP" => "Guadeloupe",
		"GU" => "Guam",
		"GT" => "Guatemala",
		"GN" => "Guinea",
		"GW" => "Guinea-Bissau",
		"GY" => "Guyana",
		"HT" => "Haiti",
		"HM" => "Heard Island and Mcdonald Islands",
		"VA" => "Holy See (Vatican City State)",
		"HN" => "Honduras",
		"HK" => "Hong Kong",
		"HU" => "Hungary",
		"IS" => "Iceland",
		"IN" => "India",
		"ID" => "Indonesia",
		"IR" => "Iran, Islamic Republic of",
		"IQ" => "Iraq",
		"IE" => "Ireland",
		"IL" => "Israel",
		"IT" => "Italy",
		"JM" => "Jamaica",
		"JP" => "Japan",
		"JO" => "Jordan",
		"KZ" => "Kazakhstan",
		"KE" => "Kenya",
		"KI" => "Kiribati",
		"KP" => "Korea, Democratic People's Republic of",
		"KR" => "Korea, Republic of",
		"KW" => "Kuwait",
		"KG" => "Kyrgyzstan",
		"LA" => "Lao People's Democratic Republic",
		"LV" => "Latvia",
		"LB" => "Lebanon",
		"LS" => "Lesotho",
		"LR" => "Liberia",
		"LY" => "Libyan Arab Jamahiriya",
		"LI" => "Liechtenstein",
		"LT" => "Lithuania",
		"LU" => "Luxembourg",
		"MO" => "Macao",
		"MK" => "Macedonia, the Former Yugoslav Republic of",
		"MG" => "Madagascar",
		"MW" => "Malawi",
		"MY" => "Malaysia",
		"MV" => "Maldives",
		"ML" => "Mali",
		"MT" => "Malta",
		"MH" => "Marshall Islands",
		"MQ" => "Martinique",
		"MR" => "Mauritania",
		"MU" => "Mauritius",
		"YT" => "Mayotte",
		"MX" => "Mexico",
		"FM" => "Micronesia, Federated States of",
		"MD" => "Moldova, Republic of",
		"MC" => "Monaco",
		"MN" => "Mongolia",
		"MS" => "Montserrat",
		"MA" => "Morocco",
		"MZ" => "Mozambique",
		"MM" => "Myanmar",
		"NA" => "Namibia",
		"NR" => "Nauru",
		"NP" => "Nepal",
		"NL" => "Netherlands",
		"AN" => "Netherlands Antilles",
		"NC" => "New Caledonia",
		"NZ" => "New Zealand",
		"NI" => "Nicaragua",
		"NE" => "Niger",
		"NG" => "Nigeria",
		"NU" => "Niue",
		"NF" => "Norfolk Island",
		"MP" => "Northern Mariana Islands",
		"NO" => "Norway",
		"OM" => "Oman",
		"PK" => "Pakistan",
		"PW" => "Palau",
		"PS" => "Palestinian Territory, Occupied",
		"PA" => "Panama",
		"PG" => "Papua New Guinea",
		"PY" => "Paraguay",
		"PE" => "Peru",
		"PH" => "Philippines",
		"PN" => "Pitcairn",
		"PL" => "Poland",
		"PT" => "Portugal",
		"PR" => "Puerto Rico",
		"QA" => "Qatar",
		"RE" => "Reunion",
		"RO" => "Romania",
		"RU" => "Russian Federation",
		"RW" => "Rwanda",
		"SH" => "Saint Helena",
		"KN" => "Saint Kitts and Nevis",
		"LC" => "Saint Lucia",
		"PM" => "Saint Pierre and Miquelon",
		"VC" => "Saint Vincent and the Grenadines",
		"WS" => "Samoa",
		"SM" => "San Marino",
		"ST" => "Sao Tome and Principe",
		"SA" => "Saudi Arabia",
		"SN" => "Senegal",
		"CS" => "Serbia and Montenegro",
		"SC" => "Seychelles",
		"SL" => "Sierra Leone",
		"SG" => "Singapore",
		"SK" => "Slovakia",
		"SI" => "Slovenia",
		"SB" => "Solomon Islands",
		"SO" => "Somalia",
		"ZA" => "South Africa",
		"GS" => "South Georgia and the South Sandwich Islands",
		"ES" => "Spain",
		"LK" => "Sri Lanka",
		"SD" => "Sudan",
		"SR" => "Suriname",
		"SJ" => "Svalbard and Jan Mayen",
		"SZ" => "Swaziland",
		"SE" => "Sweden",
		"CH" => "Switzerland",
		"SY" => "Syrian Arab Republic",
		"TW" => "Taiwan, Province of China",
		"TJ" => "Tajikistan",
		"TZ" => "Tanzania, United Republic of",
		"TH" => "Thailand",
		"TL" => "Timor-Leste",
		"TG" => "Togo",
		"TK" => "Tokelau",
		"TO" => "Tonga",
		"TT" => "Trinidad and Tobago",
		"TN" => "Tunisia",
		"TR" => "Turkey",
		"TM" => "Turkmenistan",
		"TC" => "Turks and Caicos Islands",
		"TV" => "Tuvalu",
		"UG" => "Uganda",
		"UA" => "Ukraine",
		"AE" => "United Arab Emirates",
		"GB" => "United Kingdom",
		"US" => "United States",
		"UM" => "United States Minor Outlying Islands",
		"UY" => "Uruguay",
		"UZ" => "Uzbekistan",
		"VU" => "Vanuatu",
		"VE" => "Venezuela",
		"VN" => "Viet Nam",
		"VG" => "Virgin Islands, British",
		"VI" => "Virgin Islands, U.s.",
		"WF" => "Wallis and Futuna",
		"EH" => "Western Sahara",
		"YE" => "Yemen",
		"ZM" => "Zambia",
		"ZW" => "Zimbabwe" );
	
	if ( isset( $_GET["art"] ) and isset( $_GET["shopid"] ) ) {
		$mass = explode( "-", pvs_result( $_GET["shopid"] ) );
		$product_type = $mass[0];
		$id = ( int )$mass[1];
	
		if ( $_GET["art"] == "request" ) {
			$product_total = 0;
			$product_firstname = "";
			$product_lastname = "";
			$product_address = "";
			$product_zip = "";
			$product_city = "";
			$product_country = "";
			$product_email = "";
	
			if ( $product_type == "credits" ) {
				$sql = "select * from " . PVS_DB_PREFIX . "credits_list where id_parent=" . $id;
				$rs->open( $sql );
				if ( ! $rs->eof )
				{
					$product_total = 100 * $rs->row["total"];
					$product_firstname = $rs->row["billing_firstname"];
					$product_lastname = $rs->row["billing_lastname"];
					$product_address = $rs->row["billing_address"];
					$product_zip = $rs->row["billing_zip"];
					$product_city = $rs->row["billing_city"];
					$product_country = $rs->row["billing_country"];
					$sql = "select email from " . PVS_DB_PREFIX . "users where login='" . $rs->row["user"] .
						"'";
					$ds->open( $sql );
					if ( ! $ds->eof )
					{
						$product_email = $ds->row["email"];
					}
				}
			}
	
			if ( $product_type == "subscription" ) {
				$sql = "select * from " . PVS_DB_PREFIX . "subscription_list where id_parent=" .
					$id;
				$rs->open( $sql );
				if ( ! $rs->eof )
				{
					$product_total = 100 * $rs->row["total"];
					$product_firstname = $rs->row["billing_firstname"];
					$product_lastname = $rs->row["billing_lastname"];
					$product_address = $rs->row["billing_address"];
					$product_zip = $rs->row["billing_zip"];
					$product_city = $rs->row["billing_city"];
					$product_country = $rs->row["billing_country"];
					$sql = "select email from " . PVS_DB_PREFIX . "users where login='" . $rs->row["user"] .
						"'";
					$ds->open( $sql );
					if ( ! $ds->eof )
					{
						$product_email = $ds->row["email"];
					}
				}
			}
	
			if ( $product_type == "order" ) {
				$sql = "select * from " . PVS_DB_PREFIX . "orders where id=" . ( int )$id;
				$rs->open( $sql );
				if ( ! $rs->eof )
				{
					$product_total = 100 * $rs->row["total"];
					$product_firstname = $rs->row["billing_firstname"];
					$product_lastname = $rs->row["billing_lastname"];
					$product_address = $rs->row["billing_address"];
					$product_zip = $rs->row["billing_zip"];
					$product_city = $rs->row["billing_city"];
					$product_country = $rs->row["billing_country"];
					$sql = "select email from " . PVS_DB_PREFIX . "users where id_parent=" . $rs->
						row["user"];
					$ds->open( $sql );
					if ( ! $ds->eof )
					{
						$product_email = $ds->row["email"];
					}
				}
			}
	
			foreach ( $countries as $key => $value ) {
				if ( $value == $product_country )
				{
					$product_country = $key;
				}
			}
	
			echo ( $product_firstname . ";" . $product_lastname . ";" . $product_address .
				";" . $product_zip . ";" . $product_city . ";" . $product_country . ";" . $product_email .
				";" . $product_total . ";;" . $_SERVER["REMOTE_ADDR"] . ";;;;;" . pvs_get_currency_code(1) );
			exit();
		}
	
		if ( $_GET["art"] == "result" ) {
			if ( $_GET["errcod"] == 0 ) {
				$transaction_id = pvs_transaction_add( "inetcash", pvs_result( $_GET["belegnr"] ),
					pvs_result( $product_type ), $id );
	
				if ( $product_type == "credits" and ! pvs_is_order_approved( $id, 'credits' ) )
				{
					pvs_credits_approve( $id, $transaction_id );
					pvs_send_notification( 'credits_to_user', $id );
					pvs_send_notification( 'credits_to_admin', $id );
				}
	
				if ( $product_type == "subscription" and ! pvs_is_order_approved( $id, 'subscription' ) )
				{
					pvs_subscription_approve( $id );
					pvs_send_notification( 'subscription_to_user', $id );
					pvs_send_notification( 'subscription_to_admin', $id );
				}
	
				if ( $product_type == "order" and ! pvs_is_order_approved( $id, 'order' ) )
				{
					pvs_order_approve( $id );
					pvs_commission_add( $id );
	
					pvs_coupons_add( pvs_order_user( $id ) );
					pvs_send_notification( 'neworder_to_user', $id );
					pvs_send_notification( 'neworder_to_admin', $id );
				}
			}
		}
	}
}
*/
?>