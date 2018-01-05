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

$url = 'http://api.depositphotos.com?dp_apikey=' . $pvs_global_settings["depositphotos_id"] .
	'&dp_command=search&dp_search_query=' . urlencode( $search );

if ( @$_REQUEST["stock_type"] != '' ) {
	if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["depositphotos_prints"] and
		$_REQUEST["stock_type"] == "videos" ) {
		$_REQUEST["stock_type"] = "photo";
	}

	if ( $_REQUEST["stock_type"] == "photo" ) {
		$url = 'http://api.depositphotos.com?dp_apikey=' . $pvs_global_settings["depositphotos_id"] .
			'&dp_command=search&dp_search_photo=1&dp_search_vector=0&dp_search_video=0&dp_search_query=' .
			urlencode( $search );
	}

	if ( $_REQUEST["stock_type"] == "vector" ) {
		$url = 'http://api.depositphotos.com?dp_apikey=' . $pvs_global_settings["depositphotos_id"] .
			'&dp_command=search&dp_search_vector=1&dp_search_photo=0&dp_search_video=0&dp_search_query=' .
			urlencode( $search );
	}

	if ( $_REQUEST["stock_type"] == "videos" ) {
		$url = 'http://api.depositphotos.com?dp_apikey=' . $pvs_global_settings["depositphotos_id"] .
			'&dp_command=search&dp_search_video=1&dp_search_photo=0&dp_search_vector=0&dp_search_query=' .
			urlencode( $search );
	}
}

//Page
$url .= '&dp_search_offset=' . ( ( @$str - 1 ) * @$items ) . '&dp_search_limit=' .
	@$items;

//Sort
if ( @$_REQUEST["sort"] != "" and ( @$_REQUEST["sort"] == 1 or @$_REQUEST["sort"] ==
	4 or @$_REQUEST["sort"] == 5 ) ) {
	$url .= '&dp_search_sort=' . ( int )$_REQUEST["sort"];
} else
{
	$url .= '&dp_search_sort=4';
}

//Contributor

if ( @$_REQUEST["author"] != "" ) {
	$url .= '&dp_search_username=' . pvs_result( $_REQUEST["author"] );
} else
{
	if ( $pvs_global_settings["depositphotos_contributor"] != "" ) {
		$url .= '&dp_search_username=' . $pvs_global_settings["depositphotos_contributor"];
	}
}

//Category
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 and ( int )
	$_REQUEST["category"] != 0 ) {
	$url .= '&dp_search_categories=' . ( int )$_REQUEST["category"];
} else
{
	if ( ! isset( $_REQUEST["category"] ) and $pvs_global_settings["depositphotos_category"] !=
		-1 ) {
		$url .= '&dp_search_categories=' . $pvs_global_settings["depositphotos_category"];
	}
}

//License
if ( @$_REQUEST["license"] == "commercial" ) {
	$url .= '&dp_search_editorial=0';
}
if ( @$_REQUEST["license"] == "editorial" ) {
	$url .= '&dp_search_editorial=1';
}

//Language
if ( @$_REQUEST["language"] != "" ) {
	$url .= '&dp_lang=' . pvs_result( $_REQUEST["language"] );
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["orientation"] != "-1" ) {
	$url .= '&dp_search_orientation=' . pvs_result( $_REQUEST["orientation"] );
}

//Color
if ( @$_REQUEST["color"] != "" ) {
	$url .= '&dp_search_color=' . pvs_result( $_REQUEST["color"] );
}

//Age
if ( @$_REQUEST["age"] != "" ) {
	$url .= '&dp_search_age=' . pvs_result( $_REQUEST["age"] );
}

//Gender
if ( @$_REQUEST["gender"] != "" ) {
	$url .= '&dp_search_gender=' . pvs_result( $_REQUEST["gender"] );
}

//Ethnicity
if ( @$_REQUEST["ethnicity"] != "" ) {
	$url .= '&dp_search_race=' . pvs_result( $_REQUEST["ethnicity"] );
}

//People number
if ( @$_REQUEST["people_number"] != "" ) {
	$url .= '&dp_search_quantity=' . pvs_result( $_REQUEST["people_number"] );
}

//echo($url."<br><br>");

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

$data = curl_exec( $ch );
if ( ! curl_errno( $ch ) ) {
	$results = json_decode( $data );
	//var_dump($results);
	$n = 0;
	if ( isset( $results->result ) ) {
		foreach ( $results->result as $key => $value ) {
			$n++;
			
			$pvs_theme_content[ 'item_title' ] = "#" . @$value->id;
			$pvs_theme_content[ 'item_id' ] = @$value->id;

			$pvs_theme_content[ 'cart' ] = false;
			$pvs_theme_content[ 'cartflow' ] = false;
			$pvs_theme_content[ 'cartflow2' ] = false;
			$pvs_theme_content[ 'featured' ] = false;
			$pvs_theme_content[ 'new' ] = false;
			$pvs_theme_content[ 'free' ] = false;
			$pvs_theme_content[ 'rights_managed' ] = false;
			$pvs_theme_content[ 'class2' ] = "";

			$pvs_theme_content[ 'item_viewed' ] = @$value->views;
			$pvs_theme_content[ 'item_downloaded' ] = @$value->downloads;

			//Image
			if ( @$value->type == "image" or @$value->type == "vector" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->title;

				$pvs_theme_content[ 'item_img' ] = @$value->thumb_large;

				$lightbox_width = @$value->width;
				$lightbox_height = @$value->height;
				$lightbox_url = @$value->thumb_max;

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
					( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->description ) ) ) ) .
					"','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" . $lightbox_width .
					"," . $lightbox_height . ",event)\"";

				$pvs_theme_content[ 'item_img2' ] = $lightbox_url;

				$flow_width = @$value->width;
				$flow_height = @$value->height;
			}
			//End image

			//Video
			if ( $value->type == "video" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->title;

				$pvs_theme_content[ 'item_img' ] = @$value->huge_thumb;
				$pvs_theme_content[ 'item_img2' ] = @$value->huge_thumb;

				$video_width = $pvs_global_settings["video_width"];
				$video_height = round( $pvs_global_settings["video_width"] * @$value->height / @
					$value->width );

				$lightbox_hover = "onMouseover=\"lightboxon5('" . $value->mp4 . "'," . $video_width .
					"," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
					$video_width . "," . $video_height . ",event)\"";

				$flow_width = $pvs_global_settings["width_flow"];
				$flow_height = round( $pvs_global_settings["width_flow"] * @$value->height / @$value->
					width );
			}
			//End. Video

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

			$pvs_theme_content[ 'item_description' ] = $value->description;
			$pvs_theme_content[ 'item_keywords' ] = "";

			if ( $pvs_global_settings["depositphotos_pages"] )
			{
				$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "depositphotos", @
					$value->id, @$value->title, str_replace( "video", "videos", @$value->type ) );
			} else
			{
				$aff_url = pvs_get_stock_affiliate_url( "depositphotos", @$value->id, @$value->
					type );

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

				$pvs_theme_content[ 'print_url' ] = pvs_print_url( @$value->id, ( int )$_REQUEST["print_id"],
					@$value->title, $prints_preview, "depositphotos" );
			}

			$show_print_title = true;
			include($template_file);
			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}
	}


	$stock_result_count = @$results->count;
} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>