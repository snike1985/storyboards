<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Settings
$pvs_global_settings = array();
$sql = "select setting_key,svalue from " . PVS_DB_PREFIX . "settings";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$pvs_global_settings[$rs->row["setting_key"]] = $rs->row["svalue"];

	$rs->movenext();
}

if ( PVS_LICENSE == 'Free' or PVS_LICENSE == 'Lite' or ! @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ] ) {
	$pvs_global_settings['userupload'] = 0;
	$pvs_global_settings['affiliates'] = 0;
	$pvs_global_settings['common_account'] = 0;
	$pvs_global_settings['examination'] = 0;
	$pvs_global_settings['seller_prices'] = 0;
}

if ( PVS_LICENSE == 'Free' or ! @$pvs_global_settings[ 'a' . 'ctiv' .'a' . 'tion' ] ) {
	$pvs_global_settings['prints_lab'] = 0;
	$pvs_global_settings['rights_managed'] = 0;
	$pvs_global_settings['rights_managed_sellers'] = 0;
	$pvs_global_settings['credits'] = 0;
	$pvs_global_settings['credits_currency'] = 0;
	$pvs_global_settings['subscription'] = 0;
	$pvs_global_settings['subscription_only'] = 0;
	$pvs_global_settings['no_calculation'] = 0;
	$pvs_global_settings['show_content_type'] = 0;
	$pvs_global_settings['messages'] = 0;
	$pvs_global_settings['testimonials'] = 0;
	$pvs_global_settings['reviews'] = 0;
	$pvs_global_settings['friends'] = 0;
	$pvs_global_settings['support'] = 0;
	$pvs_global_settings['multilingual_categories'] = 0;
	$pvs_global_settings['multilingual_publications'] = 0;
	$pvs_global_settings['taxes_cart'] = 0;
	$pvs_global_settings['show_in_stock'] = 0;
	$pvs_global_settings['seller_prints_quantity'] = 0;
	$pvs_global_settings['show_not_in_stock'] = 0;
	$pvs_global_settings['upload_previews'] = 0;
	$pvs_global_settings['collections'] = 0;
	$pvs_global_settings['invoices'] = 0;
	$pvs_global_settings['lightboxes'] = 0;
	
	$pvs_global_settings['prints_previews'] = 0;
	$pvs_global_settings['amazon'] = 0;
	$pvs_global_settings['rackspace'] = 0;
	$pvs_global_settings['backblaze'] = 0;
	$pvs_global_settings['eu_tax'] = 0;
}
//End settings



//Demo mode
$demo_mode = false;

//Dates
define( "date_format", "m/d/Y" );
define( "time_format", "H:i:s" );
define( "datetime_format", "m/d/Y H:i:s" );

//Define server
$site_server_activ = 1;
$site_servers = array();
$sql = "select id,url,activ from " . PVS_DB_PREFIX . "filestorage order by id";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( $rs->row["activ"] == 1 )
	{
		$site_server_activ = $rs->row["id"];
	}
	$site_servers[$rs->row["id"]] = $rs->row["url"];
	$rs->movenext();
}



//Aspect ratio
$aspect_ratio = array();
if ( @$pvs_global_settings["allow_video"] )
{
	$sql = "select name,width,height from " . PVS_DB_PREFIX . "video_ratio";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$aspect_ratio[$rs->row["name"]] = $rs->row["height"] / $rs->row["width"];
		$rs->movenext();
	}
}

//Languages
$pvs_site_langs = array();
$lng = "English";
$lng_original = "English";
$mtg = "utf-8";




$lang_name["Russian"] = "Русский";
$lang_name["English"] = "English";
$lang_name["German"] = "Deutsch";
$lang_name["French"] = "Français";
$lang_name["Arabic"] = "العربية";
$lang_name["Afrikaans formal"] = "Afrikaans formal";
$lang_name["Afrikaans informal"] = "Afrikaans informal";
$lang_name["Brazilian"] = "Português brasileiro";
$lang_name["Bulgarian"] = "Български";
$lang_name["Chinese traditional"] = "漢語";
$lang_name["Chinese simplified"] = "汉语";
$lang_name["Catalan"] = "Сatalà";
$lang_name["Czech"] = "Česky";
$lang_name["Danish"] = "Dansk";
$lang_name["Dutch"] = "Nederlands";
$lang_name["Estonian"] = "Eesti";
$lang_name["Finnish"] = "Suomi";
$lang_name["Georgian"] = "ქართული";
$lang_name["Greek"] = "Ελληνικά";
$lang_name["Hebrew"] = "עברית";
$lang_name["Hungarian"] = "Magyar";
$lang_name["Indonesian"] = "Indonesia";
$lang_name["Italian"] = "Italiano";
$lang_name["Japanese"] = "日本語";
$lang_name["Latvian"] = "Latviešu";
$lang_name["Lithuanian"] = "Lietuvių";
$lang_name["Malaysian"] = "Melayu";
$lang_name["Norwegian"] = "Norsk";
$lang_name["Persian"] = "فارسی";
$lang_name["Polish"] = "Polski";
$lang_name["Portuguese"] = "Português";
$lang_name["Romanian"] = "Română";
$lang_name["Serbian"] = "Српски";
$lang_name["Slovakian"] = "Slovenčina";
$lang_name["Slovenian"] = "Slovenski";
$lang_name["Spanish"] = "Español";
$lang_name["Swedish"] = "Svenska";
$lang_name["Thai"] = "ภาษาไทย";
$lang_name["Turkish"] = "Türkçe";
$lang_name["Ukrainian"] = "Українська";
$lang_name["Croatian"] = "Hrvatski";
$lang_name["Icelandic"] = "Íslenska";
$lang_name["Vietnamese"] = "Vietnamese";
$lang_name["Azerbaijan"] = "Azerbaijan";

$lang_symbol["English"] = "en";
$lang_symbol["Russian"] = "ru";
$lang_symbol["German"] = "de";
$lang_symbol["French"] = "fr";
$lang_symbol["Arabic"] = "ar";
$lang_symbol["Afrikaans formal"] = "af";
$lang_symbol["Afrikaans informal"] = "af";
$lang_symbol["Brazilian"] = "br";
$lang_symbol["Bulgarian"] = "bg";
$lang_symbol["Chinese traditional"] = "zh1";
$lang_symbol["Chinese simplified"] = "zh2";
$lang_symbol["Catalan"] = "ca";
$lang_symbol["Czech"] = "cs";
$lang_symbol["Danish"] = "da";
$lang_symbol["Dutch"] = "nl";
$lang_symbol["Estonian"] = "et";
$lang_symbol["Finnish"] = "fi";
$lang_symbol["Georgian"] = "ka";
$lang_symbol["Greek"] = "el";
$lang_symbol["Hebrew"] = "he";
$lang_symbol["Hungarian"] = "hu";
$lang_symbol["Indonesian"] = "id";
$lang_symbol["Italian"] = "it";
$lang_symbol["Japanese"] = "ja";
$lang_symbol["Latvian"] = "lv";
$lang_symbol["Lithuanian"] = "lt";
$lang_symbol["Malaysian"] = "ms";
$lang_symbol["Norwegian"] = "no";
$lang_symbol["Persian"] = "fa";
$lang_symbol["Polish"] = "pl";
$lang_symbol["Portuguese"] = "pt";
$lang_symbol["Romanian"] = "ro";
$lang_symbol["Serbian"] = "sr";
$lang_symbol["Slovakian"] = "sk";
$lang_symbol["Slovenian"] = "sl";
$lang_symbol["Spanish"] = "es";
$lang_symbol["Swedish"] = "sv";
$lang_symbol["Thai"] = "th";
$lang_symbol["Turkish"] = "tr";
$lang_symbol["Ukrainian"] = "uk";
$lang_symbol["Croatian"] = "hr";
$lang_symbol["Icelandic"] = "is";
$lang_symbol["Vietnamese"] = "vn";
$lang_symbol["Azerbaijan"] = "az";

$lang_wp["Russian"] = "ru_RU";
$lang_wp["English"] = "en_US";
$lang_wp["German"] = "de_DE";
$lang_wp["French"] = "fr_FR";
$lang_wp["Arabic"] = "ar_SA";
$lang_wp["Afrikaans formal"] = "af_ZA";
$lang_wp["Afrikaans informal"] = "af_ZA";
$lang_wp["Brazilian"] = "pt_BR";
$lang_wp["Bulgarian"] = "bg_BG";
$lang_wp["Chinese traditional"] = "zh_CN";
$lang_wp["Chinese simplified"] = "zh_CN";
$lang_wp["Catalan"] = "ca_ES";
$lang_wp["Czech"] = "cs_CZ";
$lang_wp["Danish"] = "da_DK";
$lang_wp["Dutch"] = "nl_NL";
$lang_wp["Estonian"] = "et_EE";
$lang_wp["Finnish"] = "fi_FI";
$lang_wp["Georgian"] = "ka_GE";
$lang_wp["Greek"] = "el_GR";
$lang_wp["Hebrew"] = "he_IL";
$lang_wp["Hungarian"] = "hu_HU";
$lang_wp["Indonesian"] = "id_ID";
$lang_wp["Italian"] = "it_IT";
$lang_wp["Japanese"] = "ja_JP";
$lang_wp["Latvian"] = "lv_LV";
$lang_wp["Lithuanian"] = "lt_LT";
$lang_wp["Malaysian"] = "ma_MY";
$lang_wp["Norwegian"] = "no_NO";
$lang_wp["Persian"] = "fa_IR";
$lang_wp["Polish"] = "pl_PL";
$lang_wp["Portuguese"] = "pt_PT";
$lang_wp["Romanian"] = "ro_RO";
$lang_wp["Serbian"] = "sr_RS";
$lang_wp["Slovakian"] = "sk_SK";
$lang_wp["Slovenian"] = "sl_SI";
$lang_wp["Spanish"] = "es_ES";
$lang_wp["Swedish"] = "sv_SE";
$lang_wp["Thai"] = "th_TH";
$lang_wp["Turkish"] = "tr_TR";
$lang_wp["Ukrainian"] = "uk_UA";
$lang_wp["Croatian"] = "hr_HR";
$lang_wp["Icelandic"] = "is_IS";
$lang_wp["Vietnamese"] = "vn_VN";
$lang_wp["Azerbaijan"] = "az_AZ";


$lang_symbol_inv["en"] = "English";
$lang_symbol_inv["ru"] = "Russian";
$lang_symbol_inv["de"] = "German";
$lang_symbol_inv["fr"] = "French";
$lang_symbol_inv["ar"] = "Arabic";
$lang_symbol_inv["af1"] = "Afrikaans formal";
$lang_symbol_inv["af2"] = "Afrikaans informal";
$lang_symbol_inv["br"] = "Brazilian";
$lang_symbol_inv["bg"] = "Bulgarian";
$lang_symbol_inv["zh1"] = "Chinese traditional";
$lang_symbol_inv["zh2"] = "Chinese simplified";
$lang_symbol_inv["ca"] = "Catalan";
$lang_symbol_inv["cs"] = "Czech";
$lang_symbol_inv["da"] = "Danish";
$lang_symbol_inv["nl"] = "Dutch";
$lang_symbol_inv["et"] = "Estonian";
$lang_symbol_inv["fi"] = "Finnish";
$lang_symbol_inv["ka"] = "Georgian";
$lang_symbol_inv["el"] = "Greek";
$lang_symbol_inv["he"] = "Hebrew";
$lang_symbol_inv["hu"] = "Hungarian";
$lang_symbol_inv["id"] = "Indonesian";
$lang_symbol_inv["it"] = "Italian";
$lang_symbol_inv["ja"] = "Japanese";
$lang_symbol_inv["lv"] = "Latvian";
$lang_symbol_inv["lt"] = "Lithuanian";
$lang_symbol_inv["ms"] = "Malaysian";
$lang_symbol_inv["no"] = "Norwegian";
$lang_symbol_inv["fa"] = "Persian";
$lang_symbol_inv["pl"] = "Polish";
$lang_symbol_inv["pt"] = "Portuguese";
$lang_symbol_inv["ro"] = "Romanian";
$lang_symbol_inv["sr"] = "Serbian";
$lang_symbol_inv["sk"] = "Slovakian";
$lang_symbol_inv["sl"] = "Slovenian";
$lang_symbol_inv["es"] = "Spanish";
$lang_symbol_inv["sv"] = "Swedish";
$lang_symbol_inv["th"] = "Thai";
$lang_symbol_inv["tr"] = "Turkish";
$lang_symbol_inv["uk"] = "Ukrainian";
$lang_symbol_inv["hr"] = "Croatian";
$lang_symbol_inv["is"] = "Icelandic";
$lang_symbol_inv["vn"] = "Vietnamese";
$lang_symbol_inv["az"] = "Azerbaijan";




//Countries
$mcountry = Array(
	"Afghanistan",
	"Albania",
	"Algeria",
	"Andorra",
	"Angola",
	"Anguilla",
	"Antarctica",
	"Antigua",
	"Argentina",
	"Armenia",
	"Aruba",
	"Australia",
	"Austria",
	"Azerbaijan",
	"Bahamas",
	"Bahrain",
	"Bangladesh",
	"Barbados",
	"Belarus",
	"Belgium",
	"Belize",
	"Benin",
	"Bermuda",
	"Bhutan",
	"Bolivia",
	"Bosnia/Hercegovina",
	"Botswana",
	"Brazil",
	"Brunei",
	"Bulgaria",
	"Burkina Faso",
	"Burma",
	"Burundi",
	"Cambodia Dem.",
	"Cameroon",
	"Canada",
	"Cape Verde",
	"Cayman Islands",
	"Central African Republic",
	"Chad",
	"Chile",
	"China",
	"Cocos Islands",
	"Colombia",
	"Comoros",
	"Congo",
	"Cook Islands",
	"Costa Rica",
	"Cote D Ivoire",
	"Croatia",
	"Cuba",
	"Cyprus",
	"Czech Republic",
	"Denmark",
	"Djibouti",
	"Dominica",
	"Dominican Republic",
	"Ecuador",
	"Egypt",
	"El Salvador",
	"Equatorial Guinea",
	"Estonia",
	"Ethiopia",
	"Falkland Islands",
	"Faroe Islands",
	"Fiji",
	"Finland",
	"France",
	"French Guiana",
	"French Polynesia",
	"Gabon",
	"Gambia",
	"Georgia",
	"Germany",
	"Ghana",
	"Gibraltar",
	"Greece",
	"Greenland",
	"Grenada",
	"Guadeloupe",
	"Guam",
	"Guatemala",
	"Guinea",
	"Guinea-Bissau",
	"Guyana",
	"Haiti",
	"Honduras",
	"Hong Kong",
	"Hungary",
	"Iceland",
	"India",
	"Indonesia",
	"Iran",
	"Iraq",
	"Ireland",
	"Israel",
	"Italy",
	"Jamaica",
	"Japan",
	"Jordan",
	"Kazakhstan",
	"Kenya",
	"Kiribati",
	"Korea, Democratic Peoples Repbulic",
	"Korea, Rep. Of",
	"Kuwait",
	"Laos Peoples Democratic Republic",
	"Latvia",
	"Lebanon",
	"Lesotho",
	"Liberia",
	"Libyan Arab Jamahiriya",
	"Liechtenstein",
	"Lithuania",
	"Luxembourg",
	"Macau",
	"Madagascar",
	"Malawi",
	"Malaysia",
	"Maldives",
	"Mali",
	"Malta",
	"Marshall Islands",
	"Martinique",
	"Mauritania",
	"Mauritius",
	"Mayotte",
	"Mexico",
	"Micronesia",
	"Moldova",
	"Monaco",
	"Mongolia",
	"Montserrat",
	"Morocco",
	"Mozambique",
	"Myanmar",
	"Namibia",
	"Nauru",
	"Nepal",
	"Neth. Antilles Nevis",
	"Netherlands",
	"New Caledonia",
	"New Zealand",
	"Nicaragua",
	"Niger",
	"Nigeria",
	"Niue",
	"Norfolk Island",
	"Northern Mariana",
	"Norway",
	"Oman",
	"Pakistan",
	"Palau",
	"Panama",
	"Papua New Guinea",
	"Paraguay",
	"Peru",
	"Philippines",
	"Poland",
	"Portugal",
	"Puerto Rico",
	"Qatar",
	"Romania",
	"Russia",
	"Rwanda",
	"Samoa (American)",
	"Samoa (Western)",
	"San Marino",
	"Sao Tome & Principe",
	"Saudi Arabia",
	"Senegal",
	"Serbia",
	"Seychelles",
	"Sierra Leone",
	"Singapore",
	"Slovakia",
	"Slovenia",
	"Solomon Islands",
	"Somalia",
	"South Africa",
	"Spain",
	"Sri Lanka",
	"St. Kitts & Nevis",
	"St. Lucia",
	"St. Pierre & Miquelon",
	"St. Vincent & Grenadines",
	"Sudan",
	"Suriname",
	"Swaziland",
	"Sweden",
	"Switzerland",
	"Syrian Arab Republic",
	"Taiwan",
	"Tajikistan",
	"Tanzania",
	"Thailand",
	"Togo",
	"Tonga",
	"Trinidad & Tobago",
	"Tunisia",
	"Turkey",
	"Turkmenistan",
	"Turks & Caicos",
	"Tuvalu",
	"Uganda",
	"Ukraine",
	"United Arab Emirates",
	"United Kingdom",
	"United States",
	"Uruguay",
	"Uzbekistan",
	"Vanuatu",
	"Vatican City",
	"Venezuela",
	"Vietnam",
	"Virgin Islands (Br.)",
	"Virgin Islands (U.S.)",
	"Wallis & Futuna",
	"Yemen Republic",
	"Zaire",
	"Zambia",
	"Zimbabwe" );

//EU Countries
$mcountry_eu = Array(
	"Austria",
	"Belgium",
	"Bulgaria",
	"Croatia",
	"Cyprus",
	"Czech Republic",
	"Denmark",
	"Estonia",
	"Finland",
	"France",
	"Germany",
	"Greece",
	"Hungary",
	"Ireland",
	"Italy",
	"Latvia",
	"Lithuania",
	"Luxembourg",
	"Malta",
	"Netherlands",
	"Poland",
	"Portugal",
	"Romania",
	"Slovakia",
	"Slovenia",
	"Spain",
	"Sweden",
	"United Kingdom" );

$mcountry_code["Afghanistan"] = "AF";
$mcountry_code["Albania"] = "Al";
$mcountry_code["Algeria"] = "DZ";
$mcountry_code["Andorra"] = "AD";
$mcountry_code["Angola"] = "AO";
$mcountry_code["Anguilla"] = "AI";
$mcountry_code["Antarctica"] = "AQ";
$mcountry_code["Antigua"] = "AG";
$mcountry_code["Argentina"] = "AR";
$mcountry_code["Armenia"] = "AM";
$mcountry_code["Aruba"] = "AW";
$mcountry_code["Australia"] = "AU";
$mcountry_code["Austria"] = "AT";
$mcountry_code["Azerbaijan"] = "AZ";
$mcountry_code["Bahamas"] = "BS";
$mcountry_code["Bahrain"] = "BH";
$mcountry_code["Bangladesh"] = "BD";
$mcountry_code["Barbados"] = "BB";
$mcountry_code["Belarus"] = "BY";
$mcountry_code["Belgium"] = "BE";
$mcountry_code["Belize"] = "BZ";
$mcountry_code["Benin"] = "BJ";
$mcountry_code["Bermuda"] = "BM";
$mcountry_code["Bhutan"] = "BT";
$mcountry_code["Bolivia"] = "BO";
$mcountry_code["Bosnia/Hercegovina"] = "BA";
$mcountry_code["Botswana"] = "BW";
$mcountry_code["Brazil"] = "BR";
$mcountry_code["Brunei"] = "BN";
$mcountry_code["Bulgaria"] = "BG";
$mcountry_code["Burkina Faso"] = "BF";
$mcountry_code["Burma"] = "BU";
$mcountry_code["Burundi"] = "BI";
$mcountry_code["Cambodia Dem."] = "KH";
$mcountry_code["Cameroon"] = "CM";
$mcountry_code["Canada"] = "CA";
$mcountry_code["Cape Verde"] = "CV";
$mcountry_code["Cayman Islands"] = "KY";
$mcountry_code["Central African Republic"] = "CF";
$mcountry_code["Chad"] = "TD";
$mcountry_code["Chile"] = "CL";
$mcountry_code["China"] = "CN";
$mcountry_code["Cocos Islands"] = "CC";
$mcountry_code["Colombia"] = "CO";
$mcountry_code["Comoros"] = "KM";
$mcountry_code["Congo"] = "CG";
$mcountry_code["Cook Islands"] = "CK";
$mcountry_code["Costa Rica"] = "CR";
$mcountry_code["Cote D Ivoire"] = "CI";
$mcountry_code["Croatia"] = "HR";
$mcountry_code["Cuba"] = "CU";
$mcountry_code["Cyprus"] = "CY";
$mcountry_code["Czech Republic"] = "CZ";
$mcountry_code["Denmark"] = "DK";
$mcountry_code["Djibouti"] = "DJ";
$mcountry_code["Dominica"] = "DM";
$mcountry_code["Dominican Republic"] = "DO";
$mcountry_code["Ecuador"] = "EC";
$mcountry_code["Egypt"] = "EG";
$mcountry_code["El Salvador"] = "SV";
$mcountry_code["Equatorial Guinea"] = "GQ";
$mcountry_code["Estonia"] = "EE";
$mcountry_code["Ethiopia"] = "ET";
$mcountry_code["Falkland Islands"] = "FK";
$mcountry_code["Faroe Islands"] = "FO";
$mcountry_code["Fiji"] = "FJ";
$mcountry_code["Finland"] = "FI";
$mcountry_code["France"] = "FR";
$mcountry_code["French Guiana"] = "GF";
$mcountry_code["French Polynesia"] = "PF";
$mcountry_code["Gabon"] = "GA";
$mcountry_code["Gambia"] = "GM";
$mcountry_code["Georgia"] = "GE";
$mcountry_code["Germany"] = "DE";
$mcountry_code["Ghana"] = "GH";
$mcountry_code["Gibraltar"] = "GI";
$mcountry_code["Greece"] = "GR";
$mcountry_code["Greenland"] = "GL";
$mcountry_code["Grenada"] = "GD";
$mcountry_code["Guadeloupe"] = "GP";
$mcountry_code["Guam"] = "GU";
$mcountry_code["Guatemala"] = "GT";
$mcountry_code["Guinea"] = "GN";
$mcountry_code["Guinea-Bissau"] = "GW";
$mcountry_code["Guyana"] = "GY";
$mcountry_code["Haiti"] = "HT";
$mcountry_code["Honduras"] = "HN";
$mcountry_code["Hong Kong"] = "HK";
$mcountry_code["Hungary"] = "HU";
$mcountry_code["Iceland"] = "IS";
$mcountry_code["India"] = "IN";
$mcountry_code["Indonesia"] = "ID";
$mcountry_code["Iran"] = "IR";
$mcountry_code["Iraq"] = "IQ";
$mcountry_code["Ireland"] = "IE";
$mcountry_code["Israel"] = "IL";
$mcountry_code["Italy"] = "IT";
$mcountry_code["Jamaica"] = "JM";
$mcountry_code["Japan"] = "JP";
$mcountry_code["Jordan"] = "JO";
$mcountry_code["Kazakhstan"] = "KZ";
$mcountry_code["Kenya"] = "KE";
$mcountry_code["Kiribati"] = "KI";
$mcountry_code["Korea, Democratic Peoples Repbulic"] = "KP";
$mcountry_code["Korea, Rep. Of"] = "KR";
$mcountry_code["Kuwait"] = "KW";
$mcountry_code["Laos Peoples Democratic Republic"] = "LA";
$mcountry_code["Latvia"] = "LV";
$mcountry_code["Lebanon"] = "LB";
$mcountry_code["Lesotho"] = "LS";
$mcountry_code["Liberia"] = "LR";
$mcountry_code["Libyan Arab Jamahiriya"] = "LY";
$mcountry_code["Liechtenstein"] = "LI";
$mcountry_code["Lithuania"] = "LT";
$mcountry_code["Luxembourg"] = "LU";
$mcountry_code["Macau"] = "MO";
$mcountry_code["Madagascar"] = "MG";
$mcountry_code["Malawi"] = "MW";
$mcountry_code["Malaysia"] = "MY";
$mcountry_code["Maldives"] = "MV";
$mcountry_code["Mali"] = "ML";
$mcountry_code["Malta"] = "MT";
$mcountry_code["Marshall Islands"] = "MH";
$mcountry_code["Martinique"] = "MQ";
$mcountry_code["Mauritania"] = "MR";
$mcountry_code["Mauritius"] = "MU";
$mcountry_code["Mayotte"] = "YT";
$mcountry_code["Mexico"] = "MX";
$mcountry_code["Micronesia"] = "FM";
$mcountry_code["Moldova"] = "MD";
$mcountry_code["Monaco"] = "MC";
$mcountry_code["Mongolia"] = "MN";
$mcountry_code["Montserrat"] = "MS";
$mcountry_code["Morocco"] = "MA";
$mcountry_code["Mozambique"] = "MZ";
$mcountry_code["Myanmar"] = "MM";
$mcountry_code["Namibia"] = "NA";
$mcountry_code["Nauru"] = "NR";
$mcountry_code["Nepal"] = "NP";
$mcountry_code["Neth. Antilles Nevis"] = "AN";
$mcountry_code["Netherlands"] = "NL";
$mcountry_code["New Caledonia"] = "NC";
$mcountry_code["New Zealand"] = "NZ";
$mcountry_code["Nicaragua"] = "NI";
$mcountry_code["Niger"] = "NE";
$mcountry_code["Nigeria"] = "NG";
$mcountry_code["Niue"] = "NU";
$mcountry_code["Norfolk Island"] = "NF";
$mcountry_code["Northern Mariana"] = "MP";
$mcountry_code["Norway"] = "NO";
$mcountry_code["Oman"] = "OM";
$mcountry_code["Pakistan"] = "PK";
$mcountry_code["Palau"] = "PW";
$mcountry_code["Panama"] = "PA";
$mcountry_code["Papua New Guinea"] = "PG";
$mcountry_code["Paraguay"] = "PY";
$mcountry_code["Peru"] = "PE";
$mcountry_code["Philippines"] = "PH";
$mcountry_code["Poland"] = "PL";
$mcountry_code["Portugal"] = "PT";
$mcountry_code["Puerto Rico"] = "PR";
$mcountry_code["Qatar"] = "QA";
$mcountry_code["Romania"] = "RO";
$mcountry_code["Russia"] = "RU";
$mcountry_code["Rwanda"] = "RW";
$mcountry_code["Samoa (American)"] = "WS";
$mcountry_code["Samoa (Western)"] = "WS";
$mcountry_code["San Marino"] = "SM";
$mcountry_code["Sao Tome & Principe"] = "ST";
$mcountry_code["Saudi Arabia"] = "SA";
$mcountry_code["Senegal"] = "SN";
$mcountry_code["Seychelles"] = "SC";
$mcountry_code["Sierra Leone"] = "SL";
$mcountry_code["Singapore"] = "SG";
$mcountry_code["Slovakia"] = "SK";
$mcountry_code["Slovenia"] = "SI";
$mcountry_code["Solomon Islands"] = "SB";
$mcountry_code["Somalia"] = "SO";
$mcountry_code["South Africa"] = "ZA";
$mcountry_code["Spain"] = "ES";
$mcountry_code["Sri Lanka"] = "LK";
$mcountry_code["St. Kitts & Nevis"] = "";
$mcountry_code["St. Lucia"] = "";
$mcountry_code["St. Pierre & Miquelon"] = "";
$mcountry_code["St. Vincent & Grenadines"] = "";
$mcountry_code["Sudan"] = "SD";
$mcountry_code["Suriname"] = "SR";
$mcountry_code["Swaziland"] = "SZ";
$mcountry_code["Sweden"] = "SE";
$mcountry_code["Switzerland"] = "CH";
$mcountry_code["Syrian Arab Republic"] = "SY";
$mcountry_code["Taiwan"] = "TW";
$mcountry_code["Tajikistan"] = "TJ";
$mcountry_code["Tanzania"] = "TZ";
$mcountry_code["Thailand"] = "TH";
$mcountry_code["Togo"] = "TG";
$mcountry_code["Tonga"] = "TO";
$mcountry_code["Trinidad & Tobago"] = "TT";
$mcountry_code["Tunisia"] = "TN";
$mcountry_code["Turkey"] = "TR";
$mcountry_code["Turkmenistan"] = "TM";
$mcountry_code["Turks & Caicos"] = "TC";
$mcountry_code["Tuvalu"] = "TV";
$mcountry_code["Uganda"] = "UG";
$mcountry_code["Ukraine"] = "UA";
$mcountry_code["United Arab Emirates"] = "AE";
$mcountry_code["United Kingdom"] = "UK";
$mcountry_code["United States"] = "US";
$mcountry_code["Uruguay"] = "UY";
$mcountry_code["Uzbekistan"] = "UZ";
$mcountry_code["Vanuatu"] = "VU";
$mcountry_code["Vatican City"] = "VA";
$mcountry_code["Venezuela"] = "VE";
$mcountry_code["Vietnam"] = "VN";
$mcountry_code["Virgin Islands (Br.)"] = "VG";
$mcountry_code["Virgin Islands (U.S.)"] = "VI";
$mcountry_code["Wallis & Futuna"] = "WF";
$mcountry_code["Yemen Republic"] = "YE";
$mcountry_code["Yugoslavia"] = "YU";
$mcountry_code["Zaire"] = "ZR";
$mcountry_code["Zambia"] = "ZM";
$mcountry_code["Zimbabwe"] = "ZW";

//States of Russia
$mstates["Russia"] = array(
	"Москва",
	"Санкт-Петербург",
	"Севастополь",
	"Республика Адыгея (Адыгея)",
	"Республика Алтай",
	"Республика Башкортостан",
	"Республика Бурятия",
	"Республика Дагестан",
	"Республика Ингушетия",
	"Кабардино-Балкарская Республика",
	"Республика Калмыкия",
	"Карачаево-Черкесская Республика",
	"Республика Карелия",
	"Республика Коми",
	"Республика Крым",
	"Республика Марий Эл",
	"Республика Мордовия",
	"Республика Саха (Якутия)",
	"Республика Северная Осетия - Алания",
	"Республика Татарстан (Татарстан)",
	"Республика Тыва",
	"Удмуртская Республика",
	"Республика Хакасия",
	"Чеченская Республика",
	"Чувашская Республика - Чувашия",
	"Алтайский край",
	"Забайкальский край",
	"Камчатский край",
	"Краснодарский край",
	"Красноярский край",
	"Пермский край",
	"Приморский край",
	"Ставропольский край",
	"Хабаровский край",
	"Амурская область",
	"Архангельская область",
	"Астраханская область",
	"Белгородская область",
	"Брянская область",
	"Владимирская область",
	"Волгоградская область",
	"Вологодская область",
	"Воронежская область",
	"Ивановская область",
	"Иркутская область",
	"Калининградская область",
	"Калужская область",
	"Кемеровская область",
	"Кировская область",
	"Костромская область",
	"Курганская область",
	"Курская область",
	"Ленинградская область",
	"Липецкая область",
	"Магаданская область",
	"Московская область",
	"Мурманская область",
	"Нижегородская область",
	"Новгородская область",
	"Новосибирская область",
	"Омская область",
	"Оренбургская область",
	"Орловская область",
	"Пензенская область",
	"Псковская область",
	"Ростовская область",
	"Рязанская область",
	"Самарская область",
	"Саратовская область",
	"Сахалинская область",
	"Свердловская область",
	"Смоленская область",
	"Тамбовская область",
	"Тверская область",
	"Томская область",
	"Тульская область",
	"Тюменская область",
	"Ульяновская область",
	"Челябинская область",
	"Ярославская область",
	"Еврейская автономная область",
	"Ненецкий автономный округ",
	"Ханты-Мансийский автономный округ - Югра",
	"Чукотский автономный округ",
	"Ямало-Ненецкий автономный округ" );

//States of USA
$mstates["United States"] = array(
	'Alabama',
	'Alaska',
	'Arizona',
	'Arkansas',
	'California',
	'Colorado',
	'Connecticut',
	'Delaware',
	'Florida',
	'Georgia',
	'Hawaii',
	'Idaho',
	'Illinois',
	'Indiana',
	'Iowa',
	'Kansas',
	'Kentucky',
	'Louisiana',
	'Maine',
	'Maryland',
	'Massachusetts',
	'Michigan',
	'Minnesota',
	'Mississippi',
	'Missouri',
	'Montana',
	'Nebraska',
	'Nevada',
	'New Hampshire',
	'New Jersey',
	'New Mexico',
	'New York',
	'North Carolina',
	'North Dakota',
	'Ohio',
	'Oklahoma',
	'Oregon',
	'Pennsylvania',
	'Rhode Island',
	'South Carolina',
	'South Dakota',
	'Tennessee',
	'Texas',
	'Utah',
	'Vermont',
	'Virginia',
	'Washington',
	'West Virginia',
	'Wisconsin',
	'Wyoming' );

//States of Canada
$mstates["Canada"] = array(
	"British Columbia",
	"Ontario",
	"Newfoundland",
	"Nova Scotia",
	"Prince Edward Island",
	"New Brunswick",
	"Quebec",
	"Manitoba",
	"Saskatchewan",
	"Alberta",
	"Northwest Territories",
	"Yukon Territory" );

//States of UK
$mstates["United Kingdom"] = array(
	'Bedfordshire',
	'Berkshire',
	'Buckinghamshire',
	'Cambridgeshire',
	'Cheshire',
	'Cornwall',
	'Cumberland',
	'Derbyshire',
	'Devon',
	'Dorset',
	'Durham',
	'East Yorkshire',
	'Essex',
	'Gloucestershire',
	'Hampshire',
	'Herefordshire',
	'Hertfordshire',
	'Huntingdonshire',
	'Kent',
	'Lancashire',
	'Leicestershire',
	'Lincolnshire',
	'Middlesex',
	'Norfolk',
	'North Yorkshire',
	'Northamptonshire',
	'Northumberland',
	'Nottinghamshire',
	'Oxfordshire',
	'Rutland',
	'Shropshire',
	'Somerset',
	'Staffordshire',
	'Suffolk',
	'Surrey',
	'Sussex',
	'Warwickshire',
	'West Yorkshire',
	'Westmorland',
	'Wiltshire',
	'Worcestershire',
	'Aberdeenshire',
	'Angus/Forfarshire',
	'Argyllshire',
	'Ayrshire',
	'Banffshire',
	'Berwickshire',
	'Buteshire',
	'Cromartyshire',
	'Caithness',
	'Clackmannanshire',
	'Dumfriesshire',
	'Dunbartonshire/Dumbartonshire',
	'East Lothian/Haddingtonshire',
	'Fife',
	'Inverness-shire',
	'Kincardineshire',
	'Kinross-shire',
	'Kirkcudbrightshire',
	'Lanarkshire',
	'Midlothian/Edinburghshire',
	'Morayshire',
	'Nairnshire',
	'Orkney',
	'Peeblesshire',
	'Perthshire',
	'Renfrewshire',
	'Ross-shire',
	'Roxburghshire',
	'Selkirkshire',
	'Shetland',
	'Stirlingshire',
	'Sutherland',
	'West Lothian/Linlithgowshire',
	'Wigtownshire',
	'Anglesey/Sir Fon',
	'Brecknockshire/Sir Frycheiniog',
	'Caernarfonshire/Sir Gaernarfon',
	'Carmarthenshire/Sir Gaerfyrddin',
	'Cardiganshire/Ceredigion',
	'Denbighshire/Sir Ddinbych',
	'Flintshire/Sir Fflint',
	'Glamorgan/Morgannwg',
	'Merioneth/Meirionnydd',
	'Monmouthshire/Sir Fynwy',
	'Montgomeryshire/Sir Drefaldwyn',
	'Pembrokeshire/Sir Benfro',
	'Radnorshire/Sir Faesyfed',
	'County Antrim',
	'County Armagh',
	'County Down',
	'County Fermanagh',
	'County Tyrone',
	'County Londonderry/Derry' );

//Regions de la France
$mstates["France"] = array(
	"Île-de-France",
	"Auvergne-Rhône-Alpes",
	"Bourgogne-Franche-Comté",
	"Bretagne",
	"Centre-Val-de-Loire",
	"Grand-Est",
	"Hauts-de-France",
	"Normandie",
	"Nouvelle-Aquitaine",
	"Occitanie",
	"Pays-de-la-Loire",
	"Provence-Alpes-Côte-d-Azur",
	"Corsica",
	"Réunion",
	"Guadeloupe",
	"Martinique",
	"St. Barths",
	"St. Martin",
	"TAAF",
	"Clipperton" );

//States of Germany
$mstates["Germany"] = array(
	"Baden-Württemberg",
	"Bayern",
	"Berlin",
	"Brandenburg",
	"Bremen",
	"Hamburg",
	"Hessen",
	"Mecklenburg-Vorpommern",
	"Nordrhein-Westfalen",
	"Rheinland-Pfalz",
	"Saarland",
	"Sachsen",
	"Sachsen-Anhalt",
	"Schleswig-Holstein",
	"Thüringen" );

//Months
$m_month[0] = "January";
$m_month[1] = "February";
$m_month[2] = "March";
$m_month[3] = "April";
$m_month[4] = "May";
$m_month[5] = "June";
$m_month[6] = "July";
$m_month[7] = "August";
$m_month[8] = "September";
$m_month[9] = "October";
$m_month[10] = "November";
$m_month[11] = "December";

//Stocks
$mstocks["site"] = pvs_word_lang( "site" );
$mstocks["istockphoto"] = "Getty/iStock";
$mstocks["shutterstock"] = "Shutterstock";
$mstocks["fotolia"] = "Fotolia";
$mstocks["depositphotos"] = "Depositphotos";
$mstocks["rf123"] = "123rf";
$mstocks["bigstockphoto"] = "Bigstockphoto";
$mstocks["pixabay"] = "Pixabay";

//Currency symbol
$currency_symbol["USD"] = '<i class="fa fa-usd"></i>';
$currency_symbol["EUR"] = '<i class="fa fa-eur"></i> ';
$currency_symbol["RUB"] = '<i class="fa fa-rub"></i> ';
$currency_symbol["GBP"] = '<i class="fa fa-gbp"></i> ';
$currency_symbol["ILS"] = '<i class="fa fa-ils"></i> ';
$currency_symbol["INR"] = '<i class="fa fa-inr"></i> ';
$currency_symbol["JPY"] = '<i class="fa fa-jpy"></i> ';
$currency_symbol["KRW"] = '<i class="fa fa-krw"></i> ';
$currency_symbol["TRY"] = '<i class="fa fa-try"></i> ';

//Amazon regions
$amazon_region["REGION_US_E1"] = "US Standart";
$amazon_region["REGION_US_W1"] = "US West (N. California)";
$amazon_region["REGION_US_W2"] = "US West (Oregon)";
$amazon_region["REGION_EU_W1"] = "EU (Ireland)";
//$amazon_region["REGION_EU_W2"]="EU (Frankfurt)";
$amazon_region["REGION_APAC_SE1"] = "Asia Pacific (Singapore)";
$amazon_region["REGION_APAC_SE2"] = "Asia Pacific (Sydney)";
$amazon_region["REGION_APAC_NE1"] = "Asia Pacific (Tokyo)";
$amazon_region["REGION_SA_E1"] = "South America (Sao Paulo)";

//Payments
$pvs_payments = array();
if ( PVS_LICENSE != 'Free' and @$pvs_global_settings[ 'act' . 'iv' .'a' . 'tion' ]  ) {
	$pvs_payments["2checkout"] = "2Checkout";
	$pvs_payments["authorize"] = "Authorize";
	$pvs_payments["bitpay"] = "Bitcoin";
	$pvs_payments["cashu"] = "CashU";
	$pvs_payments["ccavenue"] = "CCAvenue";
	$pvs_payments["ccbill"] = "ccBill";
	$pvs_payments["checkoutfi"] = "Checkout.fi";
	$pvs_payments["cheque"] = "Cheque or Money order";
	$pvs_payments["chronopay"] = "ChronoPay";
	$pvs_payments["clickbank"] = "ClickBank";
	$pvs_payments["coinpayments"] = "CoinPayments";
	$pvs_payments["dotpay"] = "Dotpay";
	$pvs_payments["dwolla"] = "Dwolla";
	$pvs_payments["enets"] = "eNETs";
	$pvs_payments["epay"] = "Epay";
	$pvs_payments["epaykkbkz"] = "Epay.kkb.kz";
	$pvs_payments["epoch"] = "Epoch";
	$pvs_payments["eway"] = "eWay";
	$pvs_payments["fortumo"] = "Fortumo";
	$pvs_payments["google"] = "Google Checkout";
	$pvs_payments["goemerchant"] = "GoEMerchant";
	$pvs_payments["gopay"] = "GoPay";
	$pvs_payments["inetcash"] = "InetCash";
	$pvs_payments["jvzoo"] = "JVZoo";
	$pvs_payments["mellatbank"] = "Mellat bank";
	$pvs_payments["midtrans"] = "Midtrans";
	$pvs_payments["moneyua"] = "Money.ua";
	$pvs_payments["mollie"] = "Mollie";
	$pvs_payments["multicards"] = "MultiCards";
	$pvs_payments["myvirtualmerchant"] = "MyVirtualMerchant";
	$pvs_payments["nmi"] = "Network Merchants";
	$pvs_payments["nochex"] = "Nochex";
	$pvs_payments["pagseguro"] = "PagSeguro";
	$pvs_payments["payfast"] = "PayFast";
	$pvs_payments["paygate"] = "Paygate";
	$pvs_payments["paypal"] = "Paypal";
	$pvs_payments["paypalpro"] = "Paypal PRO";
	$pvs_payments["payprin"] = "PayPrin";
	$pvs_payments["paysera"] = "Paysera";
	$pvs_payments["payson"] = "Payson";
	$pvs_payments["alertpay"] = "Payza";
	$pvs_payments["paxum"] = "Paxum";
	$pvs_payments["paystack"] = "Paystack";
	$pvs_payments["payu"] = "PayU";
	$pvs_payments["payumoney"] = "PayUMoney";
	$pvs_payments["privatbank"] = "PrivatBank.ua";
	$pvs_payments["qiwi"] = "QIWI";
	$pvs_payments["robokassa"] = "Robokassa";
	$pvs_payments["rbkmoney"] = "RBK Money";
	$pvs_payments["segpay"] = "Segpay";
	$pvs_payments["skrill"] = "Skrill";
	$pvs_payments["stripe"] = "Stripe";
	$pvs_payments["targetpay"] = "Targetpay";
	$pvs_payments["transferuj"] = "Transferuj";
	$pvs_payments["verotel"] = "Verotel";
	$pvs_payments["victoriabank"] = "Victoria bank";
	$pvs_payments["webmoney"] = "Webmoney";
	$pvs_payments["webpay"] = "WebPay.by";
	$pvs_payments["worldpay"] = "Worldpay";
	$pvs_payments["yandex"] = "Yandex.Money";
	$pvs_payments["zombaio"] = "Zombaio";
} else {
	$pvs_payments["paypal"] = "Paypal";
	$pvs_payments["cheque"] = "Cheque or Money order";
}

$site_yandex_payments["PC"] =
	"Оплата из кошелька в Яндекс.Деньгах";
$site_yandex_payments["AC"] =
	"Оплата с произвольной банковской карты";
$site_yandex_payments["MC"] =
	"Платеж со счета мобильного телефона";
$site_yandex_payments["GP"] =
	"Оплата наличными через кассы и терминалы";
$site_yandex_payments["WM"] =
	"Оплата из кошелька в системе WebMoney";
$site_yandex_payments["SB"] =
	"Оплата через Сбербанк: оплата по SMS или Сбербанк Онлайн";
$site_yandex_payments["MP"] =
	"Оплата через мобильный терминал (mPOS)";
$site_yandex_payments["AB"] = "Оплата через Альфа-Клик";
$site_yandex_payments["МА"] = "Оплата через MasterPass";
$site_yandex_payments["PB"] =
	"Оплата через Промсвязьбанк";

?>