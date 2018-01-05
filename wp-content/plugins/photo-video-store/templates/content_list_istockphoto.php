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

//Create search URL
$url = 'https://api.gettyimages.com/v3/search/images?fields=thumb,preview,max_dimensions,title,comp,referral_destinations&phrase=' .
	urlencode( pvs_result( @$_REQUEST["search"] ) );

if ( @$_REQUEST["license"] == 'creative' ) {
	$url = 'https://api.gettyimages.com/v3/search/images/creative?fields=thumb,preview,max_dimensions,title,comp,referral_destinations&phrase=' .
		urlencode( pvs_result( @$_REQUEST["search"] ) );
}

if ( @$_REQUEST["license"] == 'editorial' ) {
	$url = 'https://api.gettyimages.com/v3/search/images/editorial?fields=thumb,preview,max_dimensions,title,comp,referral_destinations&phrase=' .
		urlencode( pvs_result( @$_REQUEST["search"] ) );
}

$istocktphoto_type = "photo";

if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["istockphoto_prints"] ) {
	$_REQUEST["stock_type"] = "photo";
}

if ( @$_REQUEST["stock_type"] == "videos" ) {
	$url = 'https://api.gettyimages.com/v3/search/videos?fields=thumb,preview,title,comp&phrase=' .
		urlencode( pvs_result( @$_REQUEST["search"] ) );

	if ( @$_REQUEST["license"] == 'creative' ) {
		$url = 'https://api.gettyimages.com/v3/search/videos/creative?fields=thumb,preview,title,comp&phrase=' .
			urlencode( pvs_result( @$_REQUEST["search"] ) );
	}

	if ( @$_REQUEST["license"] == 'editorial' ) {
		$url = 'https://api.gettyimages.com/v3/search/videos/editorial?fields=thumb,preview,title,comp&phrase=' .
			urlencode( pvs_result( @$_REQUEST["search"] ) );
	}

	$istocktphoto_type = "videos";
}

//Page
$url .= '&page=' . @$str . '&page_size=' . @$items;

//Sort
if ( @$_REQUEST["sort"] != "" and ( @$_REQUEST["sort"] == 'best_match' or @$_REQUEST["sort"] ==
	'most_popular' or @$_REQUEST["sort"] == 'newest' ) ) {
	$url .= '&sort_order=' . pvs_result( $_REQUEST["sort"] );
} else
{
	$url .= '&sort_order=best_match';
}

//Contributor
if ( @$_REQUEST["stock_type"] != "videos" ) {
	if ( @$_REQUEST["author"] != "" ) {
		$url .= '&artists=' . urlencode( pvs_result( $_REQUEST["author"] ) );
	} else {
		if ( $pvs_global_settings["istockphoto_contributor"] != "" ) {
			$url .= '&artists=' . urlencode( $pvs_global_settings["istockphoto_contributor"] );
		}
	}
}

//Collection
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != "" and $_REQUEST["category"] !=
	-1 ) {
	$url .= '&collections_filter_type=include&collection_codes=' . urlencode( pvs_result
		( $_REQUEST["category"] ) );
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&orientations=' . pvs_result( $_REQUEST["orientation"] );
}

//Age
if ( @$_REQUEST["age"] != "" ) {
	$url .= '&age_of_people=' . pvs_result( $_REQUEST["age"] );
}

//Ethnicity
if ( @$_REQUEST["ethnicity"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&ethnicity=' . pvs_result( $_REQUEST["ethnicity"] );
}

//People number
if ( @$_REQUEST["people_number"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&number_of_people=' . pvs_result( $_REQUEST["people_number"] );
}

//Compositions
if ( @$_REQUEST["compositions"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&compositions=' . pvs_result( $_REQUEST["compositions"] );
}

//File types
if ( @$_REQUEST["file_types"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&file_types=' . pvs_result( $_REQUEST["file_types"] );
}

//Graphical styles
if ( @$_REQUEST["graphical_styles"] != "" and @$_REQUEST["stock_type"] !=
	"videos" ) {
	$url .= '&graphical_styles=' . pvs_result( $_REQUEST["graphical_styles"] );
}

//License models
if ( @$_REQUEST["license_models"] != "" ) {
	$url .= '&license_models=' . pvs_result( $_REQUEST["license_models"] );
}

//Resolution
if ( @$_REQUEST["resolution"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&format_available=' . pvs_result( $_REQUEST["resolution"] );
}

//echo($url."<br><br>");

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Api-Key: ' . $pvs_global_settings["istockphoto_id"] ) );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

$data = curl_exec( $ch );
if ( ! curl_errno( $ch ) ) {
	$results = json_decode( $data );
	//var_dump($results);
	$n = 0;
	if ( isset( $results->images ) or isset( $results->videos ) ) {
		if ( $istocktphoto_type == "photo" ) {
			$data = $results->images;
		} else {
			$data = $results->videos;
		}

		foreach ( $data as $key => $value ) {
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

			$pvs_theme_content[ 'item_viewed' ] = "";
			$pvs_theme_content[ 'item_downloaded' ] = "";

			//Image
			if ( $istocktphoto_type == "photo" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->title;

				$istockphoto_image = @$value->display_sizes;
				$istockphoto_thumb = $istockphoto_image[2];
				$istockphoto_preview = $istockphoto_image[0];

				$pvs_theme_content[ 'item_img' ] = $istockphoto_thumb->uri;

				$lightbox_width = @$value->max_dimensions->width;
				$lightbox_height = @$value->max_dimensions->height;
				$lightbox_url = $istockphoto_preview->uri;

				$pvs_global_settings["max_hover_size"] = 340;

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

				$lightbox_hover = "";

				$lightbox_hover = "onMouseover=\"lightboxon('" . $lightbox_url . "'," . $lightbox_width .
					"," . $lightbox_height . ",event,'" . site_url() . "','" . addslashes( str_replace
					( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->title ) ) ) ) .
					"','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" . $lightbox_width .
					"," . $lightbox_height . ",event)\"";

				$pvs_theme_content[ 'item_img2' ] = $lightbox_url;

				$flow_width = $lightbox_width;
				$flow_height = $lightbox_height;
			}
			//End image

			//Video
			if ( $istocktphoto_type == "videos" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->title;

				$istockphoto_preview2 = @$value->display_sizes;
				$istockphoto_image2 = $istockphoto_preview2[2];
				$istockphoto_video2 = $istockphoto_preview2[0];

				$pvs_theme_content[ 'item_img' ] = @$istockphoto_image2->uri;
				$pvs_theme_content[ 'item_img2' ] = @$istockphoto_image2->uri;

				$video_width = $pvs_global_settings["video_width"];
				$video_height = round( $pvs_global_settings["video_width"] * 9 / 16 );

				$lightbox_hover = "onMouseover=\"lightboxon_istock('" . @$istockphoto_video2->
					uri . "'," . $video_width . "," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
					$video_width . "," . $video_height . ",event)\"";

				$flow_width = $pvs_global_settings["width_flow"];
				$flow_height = round( $pvs_global_settings["width_flow"] * 9 / 16 );
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


			if ( $pvs_global_settings["istockphoto_pages"] )
			{
				$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "istockphoto", @$value->
					id, @$value->title, $istocktphoto_type );
			} else
			{
				$referal_url = @$value->referral_destinations;

				$aff_url = pvs_get_stock_affiliate_url( "istockphoto", @$value->id, $istocktphoto_type,
					@$referal_url[0]->uri, @$referal_url[1]->uri );

				$pvs_theme_content[ 'item_url' ] = $aff_url ;
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
					@$value->title, $prints_preview, "istockphoto" );
			}
			$show_print_title = true;
			include($template_file);

			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}
	}

	$stock_result_count = @$results->result_count;
} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>