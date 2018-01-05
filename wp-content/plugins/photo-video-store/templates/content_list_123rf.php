<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$flag_empty = false;
$search_content = "";

if ( $flow == 1 ) {
	if ( @$prints_flag and $pvs_global_settings["istockphoto_prints"] ) {
		$template_file = PVS_PATH . "includes/prints/" . $prints_preview . "_small.php";
	} else {
		$template_file = get_stylesheet_directory() . "/item_list_flow.php";
	}
} elseif ( $flow == 2 ) {
	$template_file = get_stylesheet_directory() . "/item_list_flow2.php";
} else
{
	$template_file = get_stylesheet_directory() . "/item_list.php";
}

//Create search URL:

if ( $search == '' ) {
	$search = $pvs_global_settings["rf123_query"];
}

$url = "http://api.123rf.com/rest/?method=123rf.images.search&apikey=" . $pvs_global_settings["rf123_id"] .
	"&keyword=" . urlencode( $search );

if ( @$_REQUEST["stock_type"] != '' ) {
	$url .= '&media_type=' . pvs_result( $_REQUEST["stock_type"] );
}

//Page
$url .= '&page=' . $str . '&perpage=' . @$items;

//Sort
if ( @$_REQUEST["sort"] != "" and ( @$_REQUEST["sort"] == 'latest' or @$_REQUEST["sort"] ==
	'most_downloaded' or @$_REQUEST["sort"] == 'random' ) ) {
	$url .= '&orderby=' . ( int )$_REQUEST["sort"];
} else
{
	$url .= '&orderby=random';
}

//Contributor

if ( @$_REQUEST["author"] != "" ) {
	$url .= '&contributorid=' . pvs_result( $_REQUEST["author"] );
} else
{
	if ( $pvs_global_settings["rf123_contributor"] != "" ) {
		$url .= '&contributorid=' . $pvs_global_settings["rf123_contributor"];
	}
}

//Category
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 and ( int )
	$_REQUEST["category"] != 0 ) {
	$url .= '&category=' . ( int )$_REQUEST["category"];
} else
{
	if ( ! isset( $_REQUEST["category"] ) and $pvs_global_settings["rf123_category"] !=
		-1 and $pvs_global_settings["rf123_category"] != 0 ) {
		$url .= '&category=' . $pvs_global_settings["rf123_category"];
	}
}

//Language
if ( @$_REQUEST["language"] != "" ) {
	$url .= '&language=' . pvs_result( $_REQUEST["language"] );
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["orientation"] != "-1" ) {
	$url .= '&orientation=' . pvs_result( $_REQUEST["orientation"] );
}

//Color
if ( @$_REQUEST["color"] != "" ) {
	$url .= '&color=' . pvs_result( $_REQUEST["color"] );
}

//Age
if ( @$_REQUEST["age"] != "" ) {
	$url .= '&people_age=' . pvs_result( $_REQUEST["age"] );
}

//Gender
if ( @$_REQUEST["gender"] != "" ) {
	$url .= '&people_gender=' . pvs_result( $_REQUEST["gender"] );
}

//Ethnicity
if ( @$_REQUEST["ethnicity"] != "" ) {
	$url .= '&model_preference=' . pvs_result( $_REQUEST["ethnicity"] );
}

//People number
if ( @$_REQUEST["people_number"] != "" ) {
	$url .= '&people_count=' . pvs_result( $_REQUEST["people_number"] );
}

//echo($url."<br><br>");

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

$data = curl_exec( $ch );
if ( ! curl_errno( $ch ) ) {
	$results = json_decode( json_encode( simplexml_load_string( $data ) ) );
	//var_dump($results);
	$n = 0;
	if ( isset( $results->images ) ) {
		foreach ( $results->images->image as $key => $value ) {
			$n++;

			$pvs_theme_content[ 'item_title' ] = "#" . @$value->{"@attributes"}->id;
			$pvs_theme_content[ 'item_id' ] = @$value->{"@attributes"}->id;

			$pvs_theme_content[ 'cart' ] = false;
			$pvs_theme_content[ 'cartflow' ] = false;
			$pvs_theme_content[ 'cartflow2' ] = false;
			$pvs_theme_content[ 'featured' ] = false;
			$pvs_theme_content[ 'new' ] = false;
			$pvs_theme_content[ 'free' ] = false;
			$pvs_theme_content[ 'rights_managed' ] = false;
			$pvs_theme_content[ 'class2' ] = "";

			$pvs_theme_content[ 'item_viewed' ] = "";
			$pvs_theme_content[ 'item_downloaded' ] = "";

			$pvs_theme_content[ 'item_title' ] = @$value->{"@attributes"}->
				description;

			$preview1 = 'http://images.assetsdelivery.com/thumbnails/' . @$value->{
				"@attributes"}->contributorid . '/' . @$value->{"@attributes"}->folder . '/' . @
				$value->{"@attributes"}->filename . '.jpg';
			$preview2 = 'http://images.assetsdelivery.com/compings/' . @$value->{
				"@attributes"}->contributorid . '/' . @$value->{"@attributes"}->folder . '/' . @
				$value->{"@attributes"}->filename . '.jpg';

			$pvs_theme_content[ 'item_img' ] = $preview1;

			$size = GetImageSize( $preview2 );

			$lightbox_width = @$size[0];
			$lightbox_height = @$size[1];
			$lightbox_url = $preview2;

			if ( $lightbox_width > $lightbox_height )
			{
				if ( $lightbox_width > $pvs_global_settings["max_hover_size"] )
				{

					$lightbox_height = round( $lightbox_height * $pvs_global_settings["max_hover_size"] /
						$lightbox_width );
					$lightbox_width = $pvs_global_settings["max_hover_size"];
				}
			} else
			{
				if ( $lightbox_height > $pvs_global_settings["max_hover_size"] )
				{
					$lightbox_width = round( $lightbox_width * $pvs_global_settings["max_hover_size"] /
						$lightbox_height );
					$lightbox_height = $pvs_global_settings["max_hover_size"];
				}
			}

			$lightbox_hover = "onMouseover=\"lightboxon('" . $lightbox_url . "'," . $lightbox_width .
				"," . $lightbox_height . ",event,'" . site_url() . "','" . addslashes( str_replace
				( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->{
				"@attributes"}->description ) ) ) ) . "','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
				$lightbox_width . "," . $lightbox_height . ",event)\"";

			$pvs_theme_content[ 'item_img2' ] = $lightbox_url;

			$flow_width = @$size[0];
			$flow_height = @$size[1];

			$pvs_theme_content[ 'item_lightbox' ] = $lightbox_hover;

			$width_limit = $pvs_global_settings["width_flow"];

			if ( ( $flow_width > $width_limit or $flow_height > $width_limit ) and $flow_width !=
				0 )
			{
				$flow_height = round( $flow_height * $width_limit / $flow_width );
				$flow_width = $width_limit;
			}

			$pvs_theme_content[ 'width' ] = $flow_width;
			$pvs_theme_content[ 'height' ] = $flow_height;

			$pvs_theme_content[ 'width_prints' ] = $flow_width;
			$pvs_theme_content[ 'height_prints' ] = $flow_height;

			$pvs_theme_content[ 'item_description' ] = "";
			$pvs_theme_content[ 'item_keywords' ] = "";

			if ( $pvs_global_settings["rf123_pages"] )
			{
				$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "123rf", @$value->{
					"@attributes"}->id, @$value->{"@attributes"}->description, "photo" );
			} else
			{
				$aff_url = pvs_get_stock_affiliate_url( "123rf", @$value->{"@attributes"}->id,
					"photo" );

				$pvs_theme_content[ 'item_url' ] = $aff_url;
			}

			//Prints
			if ( @$prints_flag and isset( $_REQUEST["print_id"] ) )
			{
				$sql = "select price from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int )
					$_REQUEST["print_id"];
				$dn->open( $sql );
				if ( ! $dn->eof )
				{
					$pvs_theme_content[ 'price' ] = pvs_currency( 1 ) . pvs_price_format( $dn->
						row["price"], 2, true ) . " " . pvs_currency( 2 );
				} else
				{
					$pvs_theme_content[ 'price' ] = "";
				}

				$pvs_theme_content[ 'print_url' ] = pvs_print_url( @$value->{"@attributes"}->
					id, ( int )$_REQUEST["print_id"], @$value->{"@attributes"}->description, $prints_preview,
					"123rf" );
			}
			$show_print_title = true;
			include($template_file);
			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}
	}

	$stock_result_count = @$results->images->{"@attributes"}->total;
} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>