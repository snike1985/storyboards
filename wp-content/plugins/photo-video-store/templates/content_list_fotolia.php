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

$auth = base64_encode( $pvs_global_settings["fotolia_id"] . ":" );

//Create search URL:

if ( isset( $_REQUEST["stock_type"] ) ) {
	if ( $_REQUEST["stock_type"] == "" ) {
		$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:all]=1';
	}

	if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["fotolia_prints"] and
		$_REQUEST["stock_type"] == "videos" ) {
		$_REQUEST["stock_type"] = "photo";
	}

	if ( $_REQUEST["stock_type"] == "photo" or $_REQUEST["stock_type"] ==
		"illustration" or $_REQUEST["stock_type"] == "vector" ) {
		$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:' .
			$_REQUEST["stock_type"] . ']=1';
	}

	if ( $_REQUEST["stock_type"] == "videos" ) {
		$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:video]=1';
	}
} else
{
	$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:all]=1';
}

//Search
if ( $search != '' ) {
	$url .= '&search_parameters[words]=' . urlencode( $search );
} else
{
	$url .= '&search_parameters[words]=' . urlencode( $pvs_global_settings["fotolia_query"] );
}

//Page
$url .= '&search_parameters[offset]=' . ( ( @$str - 1 ) * @$items ) .
	'&search_parameters[limit]=' . @$items;

//Sort
if ( @$_REQUEST["sort"] != "" and ( @$_REQUEST["sort"] == 'relevance' or @$_REQUEST["sort"] ==
	'price_1' or @$_REQUEST["sort"] == 'creation' or @$_REQUEST["sort"] ==
	'nb_views' or @$_REQUEST["sort"] == 'nb_downloads' ) ) {
	$url .= '&search_parameters[order]=' . pvs_result( $_REQUEST["sort"] );
} else
{
	$url .= '&search_parameters[order]=relevance';
}

//Contributor
if ( @$_REQUEST["author"] != "" ) {
	$url .= '&search_parameters[creator_id]=' . pvs_result( $_REQUEST["author"] );
} else
{
	if ( $pvs_global_settings["fotolia_contributor"] != "" ) {
		$url .= '&search_parameters[creator_id]=' . $pvs_global_settings["fotolia_contributor"];
	}
}

//Category
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 ) {
	$url .= '&search_parameters[cat1_id]=' . ( int )$_REQUEST["category"];
} else
{
	if ( ! isset( $_REQUEST["category"] ) and $pvs_global_settings["fotolia_category"] !=
		-1 ) {
		$url .= '&search_parameters[cat1_id]=' . $pvs_global_settings["fotolia_category"];
	}
}

//Language
if ( @$_REQUEST["language"] != "" ) {
	$url .= '&search_parameters[language_id]=' . ( int )$_REQUEST["language"];
}

//License
if ( @$_REQUEST["license"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&search_parameters[filters][license_' . pvs_result( $_REQUEST["license"] ) .
		':on]=1';
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["orientation"] != "-1" and @
	$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&search_parameters[filters][orientation]=' . pvs_result( $_REQUEST["orientation"] );
}

//Color
if ( @$_REQUEST["color"] != "" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&search_parameters[filters][colors]=' . pvs_result( $_REQUEST["color"] );
}

//Model property release
if ( isset( $_REQUEST["model"] ) ) {
	$url .= '&search_parameters[filters][has_releases]=1';
}

//Resolution
if ( @$_REQUEST["resolution"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&search_parameters[filters][license_V_' . pvs_result( $_REQUEST["resolution"] ) .
		':on]=1';
}

//Aspect ratio
if ( @$_REQUEST["duration"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&search_parameters[filters][video_duration]=' . pvs_result( $_REQUEST["duration"] );
}

//echo($url."<br><br>");

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Basic ' . $auth ) );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

$data = curl_exec( $ch );
if ( ! curl_errno( $ch ) ) {
	$results = json_decode( $data );
	//var_dump($results);
	$n = 0;
	if ( is_object( $results ) ) {
		foreach ( $results as $key => $value ) {
			$n++;

			if ( isset( $value->id ) )
			{
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

				$pvs_theme_content[ 'item_viewed' ] = @$value->nb_views;
				$pvs_theme_content[ 'item_downloaded' ] = @$value->nb_downloads;

				//Image
				if ( @$value->media_type_id == 1 or @$value->media_type_id == 2 or @$value->
					media_type_id == 3 )
				{
					$pvs_theme_content[ 'item_title' ] = @$value->title;

					$pvs_theme_content[ 'item_img' ] = @$value->thumbnail_400_url;

					$lightbox_width = @$value->thumbnail_400_width;
					$lightbox_height = @$value->thumbnail_400_height;
					$lightbox_url = @$value->thumbnail_400_url;

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
						( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->title ) ) ) ) .
						"','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" . $lightbox_width .
						"," . $lightbox_height . ",event)\"";

					$pvs_theme_content[ 'item_img2' ] = $lightbox_url;

					$flow_width = @$value->thumbnail_400_width;
					$flow_height = @$value->thumbnail_400_height;
				}
				//End image

				//Video
				if ( @$value->media_type_id == 4 )
				{
					$pvs_theme_content[ 'item_title' ] = @$value->title;

					$pvs_theme_content[ 'item_img' ] = @$value->thumbnail_400_url;
					$pvs_theme_content[ 'item_img2' ] = @$value->thumbnail_400_url;

					$video_width = $pvs_global_settings["video_width"];
					$video_height = round( $pvs_global_settings["video_width"] * @$value->
						thumbnail_400_height / @$value->thumbnail_400_width );

					$video_mp4 = @$value->video_data->formats->comp->url;
					$lightbox_hover = "onMouseover=\"lightboxon5('" . @$video_mp4 . "'," . $video_width .
						"," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
						$video_width . "," . $video_height . ",event)\"";

					$flow_width = $pvs_global_settings["width_flow"];
					$flow_height = round( $pvs_global_settings["width_flow"] * @$value->
						thumbnail_400_height / @$value->thumbnail_400_width );
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

				$fotolia_type = "photo";
				if ( @$value->media_type_id == 4 )
				{
					$fotolia_type = "video";
				}

				if ( $pvs_global_settings["fotolia_pages"] )
				{
					$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "fotolia", @$value->
						id, @$value->title, $fotolia_type );
				} else
				{
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
						@$value->title, $prints_preview, "fotolia" );
				}
				
				$show_print_title = true;
				include($template_file);
				if ( @$prints_flag )
				{
					echo($pvs_theme_content[ 'print_content' ]);
				}
			}
		}
	}

	$stock_result_count = @$results->nb_results;

} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>