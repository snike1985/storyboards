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

$auth = base64_encode( $pvs_global_settings["shutterstock_id"] . ":" . $pvs_global_settings["shutterstock_secret"] );

//Create search URL:

if ( isset( $_REQUEST["stock_type"] ) ) {
	if ( $_REQUEST["stock_type"] == "" ) {
		$url = 'https://api.shutterstock.com/v2/images/search?query=' . urlencode( $search );
	}

	if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["shutterstock_prints"] and
		( $_REQUEST["stock_type"] == "videos" or $_REQUEST["stock_type"] == "music" ) ) {
		$_REQUEST["stock_type"] = "photo";
	}

	if ( $_REQUEST["stock_type"] == "photo" or $_REQUEST["stock_type"] ==
		"illustration" or $_REQUEST["stock_type"] == "vector" ) {
		$url = 'https://api.shutterstock.com/v2/images/search?query=' . urlencode( $search ) .
			'&image_type=' . pvs_result( $_REQUEST["stock_type"] );
	}

	if ( $_REQUEST["stock_type"] == "videos" ) {
		$url = 'https://api.shutterstock.com/v2/videos/search?query=' . urlencode( $search );
	}

	if ( $_REQUEST["stock_type"] == "music" ) {
		$url = 'https://api.shutterstock.com/v2/audio/search?query=' . urlencode( $search );
	}
} else
{
	$url = 'https://api.shutterstock.com/v2/images/search?query=' . urlencode( $search );
}

//Page
$url .= '&page=' . @$str . '&per_page=' . @$items;

//Sort
if ( @$_REQUEST["stock_type"] != "music" ) {
	if ( @$_REQUEST["sort"] != "" and ( @$_REQUEST["sort"] == 'newest' or @$_REQUEST["sort"] ==
		'popular' or @$_REQUEST["sort"] == 'relevance' or @$_REQUEST["sort"] == 'random' ) ) {
		$url .= '&sort=' . pvs_result( $_REQUEST["sort"] );
	} else {
		$url .= '&sort=popular';
	}
}

//Contributor
if ( @$_REQUEST["stock_type"] != "music" ) {
	if ( @$_REQUEST["author"] != "" ) {
		$url .= '&contributor=' . pvs_result( $_REQUEST["author"] );
	} else {
		if ( $pvs_global_settings["shutterstock_contributor"] != "" ) {
			$url .= '&contributor=' . $pvs_global_settings["shutterstock_contributor"];
		}
	}
}

//Category
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 ) {
	$url .= '&category=' . ( int )$_REQUEST["category"];
} else
{
	if ( ! isset( $_REQUEST["category"] ) and $pvs_global_settings["shutterstock_category"] !=
		-1 ) {
		$url .= '&category=' . $pvs_global_settings["shutterstock_category"];
	}
}

//License
if ( @$_REQUEST["license"] != "" and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&license=' . pvs_result( $_REQUEST["license"] );
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["orientation"] != "-1" and @
	$_REQUEST["stock_type"] != "music" and @$_REQUEST["stock_type"] != "videos" ) {
	$url .= '&orientation=' . pvs_result( $_REQUEST["orientation"] );
}

//Color
if ( @$_REQUEST["color"] != "" and @$_REQUEST["stock_type"] != "music" and @$_REQUEST["stock_type"] !=
	"videos" ) {
	$url .= '&color=' . pvs_result( $_REQUEST["color"] );
}

//Model property release
if ( isset( $_REQUEST["model"] ) and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&people_model_released=1';
}

//Age
if ( @$_REQUEST["age"] != "" and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&people_age=' . pvs_result( $_REQUEST["age"] );
}

//Gender
if ( @$_REQUEST["gender"] != "" and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&people_gender=' . pvs_result( $_REQUEST["gender"] );
}

//Ethnicity
if ( @$_REQUEST["ethnicity"] != "" and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&people_ethnicity=' . pvs_result( $_REQUEST["ethnicity"] );
}

//Ethnicity
if ( @$_REQUEST["people_number"] != "" and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&people_number=' . pvs_result( $_REQUEST["people_number"] );
}

//Language
if ( @$_REQUEST["language"] != "" and @$_REQUEST["stock_type"] != "music" ) {
	$url .= '&language=' . pvs_result( $_REQUEST["language"] );
}

//Aspect ratio
if ( @$_REQUEST["aspect_ratio"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&aspect_ratio=' . pvs_result( $_REQUEST["aspect_ratio"] );
}

//Resolution
if ( @$_REQUEST["resolution"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&resolution=' . pvs_result( $_REQUEST["resolution"] );
}

//Duration video
if ( @$_REQUEST["duration_video"] != "" and @$_REQUEST["stock_type"] == "videos" ) {
	$url .= '&duration_from=' . $duration_video1 . '&duration_to=' . $duration_video2;
}

//Album title
if ( @$_REQUEST["album_title"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&album_title=' . pvs_result( $_REQUEST["album_title"] );
}

//Artists
if ( @$_REQUEST["artists"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&artists=' . pvs_result( $_REQUEST["artists"] );
}

//Genre
if ( @$_REQUEST["genre"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&genre=' . pvs_result( $_REQUEST["genre"] );
}

//Instruments
if ( @$_REQUEST["instruments"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&instruments=' . pvs_result( $_REQUEST["instruments"] );
}

//Lyrics
if ( @$_REQUEST["lyrics"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&lyrics=' . pvs_result( $_REQUEST["lyrics"] );
}

//Moods
if ( @$_REQUEST["moods"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&moods=' . pvs_result( $_REQUEST["moods"] );
}

//Vocal description
if ( @$_REQUEST["vocal_description"] != "" and @$_REQUEST["stock_type"] ==
	"music" ) {
	$url .= '&vocal_description=' . pvs_result( $_REQUEST["vocal_description"] );
}

//Instrumental
if ( isset( $_REQUEST["instrumental"] ) and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&is_instrumental=1';
}

//Duration audio
if ( @$_REQUEST["duration_audio"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$url .= '&duration_from=' . $duration_audio1 . '&duration_to=' . $duration_audio2;
}

//BMP
if ( @$_REQUEST["bmp"] != "" and @$_REQUEST["stock_type"] == "music" ) {
	$bmp1 = 0;
	$bmp2 = 240;
	$bmp_mass = explode( " - ", pvs_result( $_REQUEST["bmp"] ) );
	if ( isset( $bmp_mass[0] ) and isset( $bmp_mass[1] ) ) {
		$bmp1 = ( int )$bmp_mass[0];
		$bmp2 = ( int )$bmp_mass[1];
	}
	$url .= '&bmp_from=' . $bmp1 . '&bmp_to=' . $bmp2;
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
	if ( isset( $results->data ) ) {
		foreach ( $results->data as $key => $value ) {
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
			if ( @$value->media_type == "image" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->description;

				$pvs_theme_content[ 'item_img' ] = @$value->assets->small_thumb->url;

				$lightbox_width = @$value->assets->preview->width;
				$lightbox_height = @$value->assets->preview->height;
				$lightbox_url = @$value->assets->preview->url;

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

				$flow_width = @$value->assets->preview->width;
				$flow_height = @$value->assets->preview->height;
			}
			//End image

			//Video
			if ( $value->media_type == "video" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->description;

				$pvs_theme_content[ 'item_img' ] = @$value->assets->thumb_jpg->url;
				$pvs_theme_content[ 'item_img2' ] = @$value->assets->thumb_jpg->url;

				$video_width = $pvs_global_settings["video_width"];
				$video_height = round( $pvs_global_settings["video_width"] / $value->aspect );

				$lightbox_hover = "onMouseover=\"lightboxon5('" . $value->assets->preview_mp4->
					url . "'," . $video_width . "," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
					$video_width . "," . $video_height . ",event)\"";

				$flow_width = $pvs_global_settings["width_flow"];
				if ( $value->aspect != 0 )
				{
					$flow_height = round( $pvs_global_settings["width_flow"] / @$value->aspect );
				}
			}
			//End. Video

			//Audio
			if ( $value->media_type == "audio" )
			{
				$pvs_theme_content[ 'item_title' ] = @$value->title;

				$pvs_theme_content[ 'item_img' ] = @$value->assets->waveform->url;
				$pvs_theme_content[ 'item_img2' ] = @$value->assets->waveform->url;

				$flow_width = $pvs_global_settings["width_flow"];
				$flow_height = round( $pvs_global_settings["width_flow"] * 9 / 11 );

				$lightbox_hover = "onMouseover=\"lightboxon4('" . @$value->assets->preview_mp3->
					url . "',200,20,event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(200,20,event)\"";
			}
			//End. Audio

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

			if ( $pvs_global_settings["shutterstock_pages"] )
			{
				$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "shutterstock", @
					$value->id, @$value->description, @$value->media_type );
			} else
			{
				$aff_url = pvs_get_stock_affiliate_url( "shutterstock", @$value->id, @$value->
					media_type );

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
					@$value->description, $prints_preview, "shutterstock" );
			}

			$show_print_title = true;
			include($template_file);
			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}
	}

	$stock_result_count = @$results->total_count;
} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>