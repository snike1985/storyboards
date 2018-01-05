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

$pixabay_type = "photo";

if ( isset( $_REQUEST["stock_type"] ) ) {
	if ( $_REQUEST["stock_type"] == "" ) {
		$url = 'https://pixabay.com/api/?key=' . $pvs_global_settings["pixabay_id"] .
			'&q=' . urlencode( $search );
	}

	if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["pixabay_prints"] and
		$_REQUEST["stock_type"] == "videos" ) {
		$_REQUEST["stock_type"] = "photo";
	}

	if ( $_REQUEST["stock_type"] == "photo" ) {
		$url = 'https://pixabay.com/api/?key=' . $pvs_global_settings["pixabay_id"] .
			'&q=' . urlencode( $search );
	}

	if ( $_REQUEST["stock_type"] == "videos" ) {
		$url = 'https://pixabay.com/api/videos/?key=' . $pvs_global_settings["pixabay_id"] .
			'&q=' . urlencode( $search );
		$pixabay_type = "videos";
	}
} else
{
	$url = 'https://pixabay.com/api/?key=' . $pvs_global_settings["pixabay_id"] .
		'&q=' . urlencode( $search );
}

//Page
$url .= '&page=' . @$str . '&per_page=' . @$items;

//Sort
if ( @$_REQUEST["order"] != "" and ( @$_REQUEST["order"] == 'popular' or @$_REQUEST["order"] ==
	'latest' ) ) {
	$url .= '&order=' . pvs_result( $_REQUEST["order"] );
} else
{
	$url .= '&order=popular';
}

//Category
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 ) {
	$url .= '&category=' . pvs_result( $_REQUEST["category"] );
} else
{
	if ( ! isset( $_REQUEST["category"] ) and $pvs_global_settings["pixabay_category"] !=
		-1 ) {
		$url .= '&category=' . $pvs_global_settings["pixabay_category"];
	}
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&orientation=' . pvs_result( $_REQUEST["orientation"] );
}

//Language
if ( @$_REQUEST["lang"] != "" ) {
	$url .= '&lang=' . pvs_result( $_REQUEST["lang"] );
}

//Image type
if ( @$_REQUEST["image_type"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&image_type=' . pvs_result( $_REQUEST["image_type"] );
}

//Video type
if ( @$_REQUEST["video_type"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&video_type=' . pvs_result( $_REQUEST["video_type"] );
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
	if ( isset( $results->hits ) ) {
		foreach ( $results->hits as $key => $value ) {
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
			if ( $pixabay_type == "photo" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->tags;

				$pvs_theme_content[ 'item_img' ] = @$value->webformatURL;

				$lightbox_width = @$value->webformatWidth;
				$lightbox_height = @$value->webformatHeight;
				$lightbox_url = @$value->webformatURL;

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
					( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->tags ) ) ) ) .
					"','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" . $lightbox_width .
					"," . $lightbox_height . ",event)\"";

				$pvs_theme_content[ 'item_img2' ] = $lightbox_url;

				$flow_width = @$value->webformatWidth;
				$flow_height = @$value->webformatHeight;
			}
			//End image

			//Video
			if ( $pixabay_type == "videos" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->tags;

				$pvs_theme_content[ 'item_img' ] = "https://i.vimeocdn.com/video/" . @$value->
					picture_id . "_295x166.jpg";
				$pvs_theme_content[ 'item_img2' ] = "https://i.vimeocdn.com/video/" . @$value->
					picture_id . "_295x166.jpg";

				$video_width = $pvs_global_settings["video_width"];
				$video_height = round( $pvs_global_settings["video_width"] * 166 / 295 );

				$lightbox_hover = "onMouseover=\"lightboxon5('" . @$value->videos->small->url .
					"'," . $video_width . "," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
					$video_width . "," . $video_height . ",event)\"";

				$flow_width = $pvs_global_settings["width_flow"];
				$flow_height = round( $pvs_global_settings["width_flow"] * 166 / 295 );
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

			if ( $pvs_global_settings["pixabay_pages"] )
			{
				$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "pixabay", @$value->
					id, @$value->tags, $pixabay_type );
			} else
			{
				$aff_url = @$value->pageURL;

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
					@$value->tags, $prints_preview, "pixabay" );
			}
			
			$show_print_title = true;
			include($template_file);
			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}
	}

	$stock_result_count = @$results->total;
} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>