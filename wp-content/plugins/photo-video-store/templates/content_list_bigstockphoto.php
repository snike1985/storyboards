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

$url = 'https://api.bigstockphoto.com/2/' . $pvs_global_settings["bigstockphoto_id"] .
	'/search/?response_detail=all&q=' . urlencode( $search );

if ( @$_REQUEST["stock_type"] != '' ) {
	if ( $_REQUEST["stock_type"] == "photo" ) {
		$url = 'https://api.bigstockphoto.com/2/' . $pvs_global_settings["bigstockphoto_id"] .
			'/search/?response_detail=all&q=' . urlencode( $search ) .
			'&illustrations=n&vectors=n';
	}

	if ( $_REQUEST["stock_type"] == "illustration" ) {
		$url = 'https://api.bigstockphoto.com/2/' . $pvs_global_settings["bigstockphoto_id"] .
			'/search/?response_detail=all&q=' . urlencode( $search ) . '&illustrations=y';
	}

	if ( $_REQUEST["stock_type"] == "vector" ) {
		$url = 'https://api.bigstockphoto.com/2/' . $pvs_global_settings["bigstockphoto_id"] .
			'/search/?response_detail=all&q=' . urlencode( $search ) . '&vectors=y';
	}
}

//Page
$url .= '&page=' . $str . '&limit=' . @$items;

//Sort
if ( @$_REQUEST["sort"] != "" and ( @$_REQUEST["sort"] == 'relevant' or @$_REQUEST["sort"] ==
	'popular' or @$_REQUEST["sort"] == 'new' ) ) {
	$url .= '&order=' . pvs_result( $_REQUEST["sort"] );
} else
{
	$url .= '&order=popular';
}

//Contributor

if ( @$_REQUEST["author"] != "" ) {
	$url .= '&contributor=' . pvs_result( $_REQUEST["author"] );
} else
{
	if ( $pvs_global_settings["bigstockphoto_contributor"] != "" ) {
		$url .= '&contributor=' . $pvs_global_settings["bigstockphoto_contributor"];
	}
}

//Category
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 ) {
	$url .= '&category=' . pvs_result( $_REQUEST["category"] );
} else
{
	if ( ! isset( $_REQUEST["category"] ) and $pvs_global_settings["bigstockphoto_category"] !=
		-1 ) {
		$url .= '&category=' . $pvs_global_settings["bigstockphoto_category"];
	}
}

//License
if ( @$_REQUEST["license"] == "commercial" ) {
	$url .= '&editorial=Y';
}
if ( @$_REQUEST["license"] == "editorial" ) {
	$url .= '&editorial=N';
}

//Language
if ( @$_REQUEST["language"] != "" ) {
	$url .= '&language=' . pvs_result( $_REQUEST["language"] );
}

//Orientation
if ( @$_REQUEST["orientation"] != "" and @$_REQUEST["orientation"] != "-1" ) {
	$url .= '&orientation=' . pvs_result( $_REQUEST["orientation"] );
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
	if ( isset( $results->data->images ) ) {
		foreach ( $results->data->images as $key => $value ) {
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

			$pvs_theme_content[ 'item_title' ] = @$value->title;

			$pvs_theme_content[ 'item_img' ] = @$value->preview->url;

			$lightbox_width = @$value->preview->width;
			$lightbox_height = @$value->preview->height;
			$lightbox_url = @$value->preview->url;

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

			$flow_width = @$value->preview->width;
			$flow_height = @$value->preview->height;

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

			$pvs_theme_content[ 'item_description' ] = $value->description;
			$pvs_theme_content[ 'item_keywords' ] = $value->keywords;

			if ( $pvs_global_settings["bigstockphoto_pages"] )
			{
				$pvs_theme_content[ 'item_url' ] = pvs_get_stock_page_url( "bigstockphoto", @
					$value->id, @$value->title, "photo" );
			} else
			{
				$aff_url = pvs_get_stock_affiliate_url( "bigstockphoto", @$value->id, "photo" );

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
					@$value->title, $prints_preview, "bigstockphoto" );
			}
			
			$show_print_title = true;
			include($template_file);
			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}
	}

	$stock_result_count = @$results->data->paging->total_items;
} else
{
	echo ( pvs_word_lang( "Error. The script cannot connect to API." ) );
}

curl_close( $ch );?>