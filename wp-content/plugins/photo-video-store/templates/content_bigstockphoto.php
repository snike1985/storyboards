<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

include ( "content_js_stock.php" );

if ( isset( $bigstockphoto_results ) ) {
	//Show only bigstockphoto syntax
	foreach ( $mstocks as $key => $value ) {
		if ( $key == 'bigstockphoto' )
		{
			$pvs_theme_content[ $key ] = true;
		} else
		{
			$pvs_theme_content[ $key ] = false;
		}
	}

	//var_dump($bigstockphoto_results);

	$pvs_theme_content[ 'id' ] = $bigstockphoto_results->id;

	$pvs_theme_content[ 'image' ] = "<img src='" . @$bigstockphoto_results->
		preview->url . "' />";
	$pvs_theme_content[ 'downloadsample' ] = @$bigstockphoto_results->preview->
		url;
	$pvs_theme_content[ 'share_image' ] = urlencode( @$bigstockphoto_results->
		preview->url );

	$publication_type = "photo";

	$pvs_theme_content[ 'title' ] = @$bigstockphoto_results->title;
	$pvs_theme_content[ 'keywords' ] = @$bigstockphoto_keywords_links;
	$pvs_theme_content[ 'keywords_lite' ] = @$bigstockphoto_keywords_links;
	$pvs_theme_content[ 'description' ] = @$bigstockphoto_results->
		description;
	$pvs_theme_content[ 'category' ] = @$bigstockphoto_categories_links;
	$pvs_theme_content[ 'author' ] = '<b>' . pvs_word_lang( "Contributor" ) .
		':</b> <a href="' . site_url() . '/?stock=bigstockphoto&author=' . @$bigstockphoto_results->
		contributor . '&stock_type=' . $publication_type . '" >' . @$bigstockphoto_results->
		contributor . '</a>';
	$pvs_theme_content[ 'published' ] = "";
	$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
		".js'></script>";
	$pvs_theme_content[ 'share_title' ] = urlencode( @$bigstockphoto_results->title );

	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_print_url( @$bigstockphoto_results->
			id, ( int )get_query_var("pvs_print_id"), @$bigstockphoto_results->title, $prints_preview,
			"bigstockphoto" ) );
	} else {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() .
			pvs_get_stock_page_url( "bigstockphoto", @$bigstockphoto_results->id, @$bigstockphoto_results->
			title, get_query_var("bigstockphoto_type") ) );
	}

	$pvs_theme_content[ 'share_description' ] = urlencode( @$bigstockphoto_results->description );

	//Type
	$pvs_theme_content[ 'type' ] = '<a href="' . site_url() .
		'/?stock=bigstockphoto&stock_type=' . $publication_type . '" >' .
		pvs_word_lang( $publication_type ) . '</a>';

	//Published
	$pvs_theme_content[ 'flag_published' ] = false;

	//Category
	$pvs_theme_content[ 'flag_category' ] = true;

	//Model release
	$pvs_theme_content[ 'flag_model' ] = false;

	//Property release
	$pvs_theme_content[ 'flag_property' ] = false;

	//Editorial
	$pvs_theme_content[ 'flag_editorial' ] = false;

	//Duration
	$pvs_theme_content[ 'flag_duration' ] = false;

	//Aspect ratio
	$pvs_theme_content[ 'flag_aspect' ] = false;

	//Bites per minute
	$pvs_theme_content[ 'flag_bpm' ] = false;

	//Album
	$pvs_theme_content[ 'flag_album' ] = false;

	//Vocal description
	$pvs_theme_content[ 'flag_vocal_description' ] = false;

	//Lyrics
	$pvs_theme_content[ 'flag_lyrics' ] = false;

	//Artists
	$pvs_theme_content[ 'flag_artists' ] = false;

	//Genres
	$pvs_theme_content[ 'flag_genres' ] = false;

	//Instruments
	$pvs_theme_content[ 'flag_instruments' ] = false;

	//Moods
	$pvs_theme_content[ 'flag_moods' ] = false;

	//Sizes
	$sizes = '';

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		$display_files = 'block';
		$display_prints = 'none';
		$checked_files = 'checked';
		$checked_prints = '';

		if ( $pvs_global_settings["bigstockphoto_prints"] and $pvs_global_settings["bigstockphoto_show"] ==
			2 )
		{
			$display_files = 'none';
			$display_prints = 'block';
			$checked_files = '';
			$checked_prints = 'checked';
		}

		if ( $pvs_global_settings["bigstockphoto_files"] and $pvs_global_settings["bigstockphoto_prints"] )
		{
			$sizes .= "<input type='radio' name='license' id='files_label' style='margin:20px 10px 10px 0px'  onClick='apanel(0);' " .
				$checked_files . "><label for='files_label' >" . pvs_word_lang( "files" ) .
				"</label><input type='radio' name='license' id='prints_label' style='margin:20px 10px 10px 20px'  onClick='apanel(1);' " .
				$checked_prints . "><label for='prints_label' >" . pvs_word_lang( "prints and products" ) .
				"</label>";
		}

		$sizes .= "<div id='prices_files' style='display:" . $display_files .
			"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th style='width:70%'>" .
			pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th></tr>";

		foreach ( $bigstockphoto_results->formats as $key => $value )
		{
			$sizes .= '<tr valign="top"><td>' . strtoupper( @$value->size_code ) .
				'</td><td>' . @$value->width . ' x ' . @$value->height . ' px</td></tr>';
		}

		$sizes .= "</table><br>";

		$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "bigstockphoto", @$bigstockphoto_results->
			id, get_query_var("bigstockphoto_type") ) .
			"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
			pvs_word_lang( "Buy on" ) . " Bigstockphoto</a></div>";

		if ( $pvs_global_settings["bigstockphoto_prints"] )
		{
			$print_buy_checked = "checked";

			$sizes .= "<div id='prices_prints' style='display:" . $display_prints .
				"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "price" ) . "</th><th>" .
				pvs_word_lang( "buy" ) . "</th></tr>";

			$sql = "select id,title from " . PVS_DB_PREFIX .
				"prints_categories where active=1 order by priority";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sizes .= "<tr><td colspan='3'><b>" . pvs_word_lang( $dd->row["title"] ) .
					"</b></th></td>";

				$sql = "select id_parent,title,price,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
					PVS_DB_PREFIX . "prints  where category=" . $dd->row["id"] .
					" order by priority";
				$dr->open( $sql );

				while ( ! $dr->eof )
				{
					$prints_preview = "";
					if ( file_exists( pvs_upload_dir() .
						"/content/prints/product" . $dr->row["id_parent"] . "_1_big.jpg" ) or
						file_exists( pvs_upload_dir() . "/content/prints/product" .
						$dr->row["id_parent"] . "_2_big.jpg" ) or file_exists( pvs_upload_dir() . "/content/prints/product" . $dr->row["id_parent"] . "_3_big.jpg" ) )
					{
						$prints_preview = "<a href='javascript:show_prints_preview(" . $dr->row["id_parent"] .
							");'>";
					}

					$price = pvs_define_prints_price( $dr->row["price"], $dr->row["option1"], $dr->
						row["option1_value"], $dr->row["option2"], $dr->row["option2_value"], $dr->row["option3"],
						$dr->row["option3_value"], $dr->row["option4"], $dr->row["option4_value"], $dr->
						row["option5"], $dr->row["option5_value"], $dr->row["option6"], $dr->row["option6_value"],
						$dr->row["option7"], $dr->row["option7_value"], $dr->row["option8"], $dr->row["option8_value"],
						$dr->row["option9"], $dr->row["option9_value"], $dr->row["option10"], $dr->row["option10_value"] );

					$sizes .= "<tr class='tr_cart' id='tr_cart" . $dr->row["id_parent"] .
						"'><td width='40%' onClick='xprint(" . $dr->row["id_parent"] . ");'>" . $prints_preview .
						pvs_word_lang( $dr->row["title"] ) . "</td><td onClick='xprint(" . $dr->row["id_parent"] .
						");' ><span class='price'>" . pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) .
						" " . pvs_currency( 2 ) . "</span></td><td onClick='xprint(" . $dr->row["id_parent"] .
						");'><input type='radio'  id='cartprint' name='cartprint' value='" . $dr->row["id_parent"] .
						"' " . $print_buy_checked . "></td></tr>";

					$print_buy_checked = "";

					$dr->movenext();
				}

				$dd->movenext();
			}

			$sizes .= "</table><br><a href=\"javascript:prints_stock('bigstockphoto'," . @$bigstockphoto_results->
				id . ",'" . urlencode( pvs_get_stock_affiliate_url( "bigstockphoto", @$bigstockphoto_results->
				id, get_query_var("bigstockphoto_type") ) ) . "','" . urlencode( @$bigstockphoto_results->
				preview->url ) . "','" . pvs_get_stock_page_url( "bigstockphoto", @$bigstockphoto_results->
				id, @$bigstockphoto_results->title, get_query_var("bigstockphoto_type") ) . "','" .
				addslashes( @$bigstockphoto_results->title ) . "')\" class = 'btn btn-danger btn-lg' style='color:#ffffff;text-decoration:none;'>" .
				pvs_word_lang( "Order print" ) . "</a></div>";
		}
	}

	$pvs_theme_content[ 'sizes' ] = $sizes;
	//End. Sizes

	//Related items
	$related_items = '';
	$related_count = 0;

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		$url = 'https://api.bigstockphoto.com/2/' . $pvs_global_settings["bigstockphoto_id"] .
			'/search/?response_detail=all&q=' . urlencode( @$bigstockphoto_results->title ) .
			'&page=1&limit=' . $pvs_global_settings["related_items_quantity"];

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

		$data = curl_exec( $ch );
		if ( ! curl_errno( $ch ) )
		{
			$bigstockphoto_related = json_decode( $data );
			//var_dump($bigstockphoto_related);

			if ( isset( $bigstockphoto_related->data->images ) )
			{
				foreach ( $bigstockphoto_related->data->images as $key => $value )
				{
					if ( @$value->id != '' and @$value->id != ( int )get_query_var("bigstockphoto") )
					{
						$preview_title = @$value->title;
						$preview_img = @$value->preview->url;

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
							( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->description ) ) ) ) .
							"','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" . $lightbox_width .
							"," . $lightbox_height . ",event)\"";

						$flow_width = @$value->preview->width;
						$flow_height = @$value->preview->height;

						$publication_type = "photo";

						$preview_title = "#" . @$value->id;

						$related_id = @$value->id;
						$related_title = $preview_title;
						$related_description = "";
						$related_url = pvs_get_stock_page_url( "bigstockphoto", @$value->
							id, @$value->title, $publication_type );
						$related_preview = $preview_img;
						$related_lightbox = $lightbox_hover;

						$related_width = $flow_width;
						$related_height = $flow_height;

						include( get_stylesheet_directory(). '/item_related_stock.php' );
						$related_items .= $pvs_theme_content[ 'related_content' ];
						$related_count++;
					}
				}
			}
		}
	}

	$flag_related = false;
	if ( $pvs_global_settings["related_items"] and $related_count > 0 ) {
		$flag_related = true;
	}
	$pvs_theme_content[ 'flag_related' ] = $flag_related;

	$pvs_theme_content[ 'related_items' ] = $related_items;
	//End. Related items

	//Prints
	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$preview_url = @$bigstockphoto_results->preview->url;
		$iframe_width = @$bigstockphoto_results->preview->width;
		$iframe_height = @$bigstockphoto_results->preview->height;
		$default_width = @$bigstockphoto_results->preview->width * 20;
		$default_height = @$bigstockphoto_results->preview->height * 20;

		$pvs_theme_content[ 'print_title' ] = pvs_word_lang( @$prints_title );

		$flag_resize = 0;
		$resize_min = $pvs_global_settings["thumb_width2"];
		;
		$resize_max = $pvs_global_settings["prints_previews_width"];
		$resize_value = $pvs_global_settings["thumb_width2"];
		;

		$sql = "select * from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int )@get_query_var("pvs_print_id");
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$flag_resize = $ds->row["resize"];
			$resize_min = $ds->row["resize_min"];
			$resize_max = $ds->row["resize_max"];
			$resize_value = $ds->row["resize_value"];
		}

		$pvs_theme_content[ 'big_width_prints' ] = $iframe_width;
		$pvs_theme_content[ 'big_height_prints' ] = $iframe_height;

		$pvs_theme_content[ 'print_type' ] = $prints_preview;

		$pvs_theme_content[ 'image' ] = $preview_url;
		$pvs_theme_content[ 'preview_url' ] = $preview_url;
			
		include( PVS_PATH . "includes/prints/" . $prints_preview . "_big.php" );
		
		$pvs_theme_content[ 'image' ] = $pvs_theme_content[ 'print_content' ];

		$pvs_theme_content[ 'flag_resize' ] = $flag_resize;

		if ( $default_width < $default_height )
		{
			$photo_size = $default_height;
		} else
		{
			$photo_size = $default_width;
		}

		$print_thumb = $preview_url;
		if ( $default_width > $default_height )
		{
			$print_width = $pvs_global_settings["prints_previews_width"];
			$print_height = round( $pvs_global_settings["prints_previews_width"] * $default_height /
				$default_width );
		} else
		{
			$print_height = $pvs_global_settings["prints_previews_width"];
			$print_width = round( $pvs_global_settings["prints_previews_width"] * $default_width /
				$default_height );
		}

		$pvs_theme_content[ 'print_preview' ] = $print_thumb;
		$pvs_theme_content[ 'width_print_preview' ] = $print_width;
		$pvs_theme_content[ 'height_print_preview' ] = $print_height;
		$pvs_theme_content[ 'default_width' ] = $default_width;
		$pvs_theme_content[ 'default_height' ] = $default_height;

		$stock_id = @$bigstockphoto_results->id;
		$stock_type = "bigstockphoto";

		$pvs_theme_content[ 'stock_type' ] = $stock_type;
		$pvs_theme_content[ 'stock_id' ] = $stock_id;
		$pvs_theme_content[ 'stock_url' ] = pvs_get_stock_affiliate_url( "bigstockphoto", @$bigstockphoto_results->id, "photo" );
		$pvs_theme_content[ 'stock_preview' ] = $preview_url;
		$pvs_theme_content[ 'stock_site_url' ] = pvs_print_url( @$bigstockphoto_results->
			id, ( int )get_query_var("pvs_print_id"), @$bigstockphoto_results->title, $prints_preview,
			"bigstockphoto" );

		$id_parent = get_query_var('istockphoto');
		include ( "content_print_properties.php" );
	}
	//End. Prints

	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		require_once( get_stylesheet_directory(). '/item_stockapi_print.php' );
	} else {
		require_once( get_stylesheet_directory(). '/item_stockapi.php' );
	}
}
?>