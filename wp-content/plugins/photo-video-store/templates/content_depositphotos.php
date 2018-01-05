<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

include ( "content_js_stock.php" );

if ( isset( $depositphotos_results ) ) {
	//Show only depositphotos syntax
	foreach ( $mstocks as $key => $value ) {
		if ( $key == 'depositphotos' )
		{
			$pvs_theme_content[ $key ] = true;
		} else
		{
			$pvs_theme_content[ $key ] = false;
		}
	}

	//var_dump($depositphotos_results);

	$pvs_theme_content[ 'id' ] = $depositphotos_results->id;

	if ( get_query_var("depositphotos_type") == "videos" ) {

		$player_video_id = strval( @$depositphotos_results->id );
		$player_video_root = pvs_plugins_url();
		$player_video_width = $pvs_global_settings["ffmpeg_video_width"];
		$player_video_height = round( $pvs_global_settings["ffmpeg_video_width"] *
			@$depositphotos_results->height / @$depositphotos_results->width );
		$player_preview_video = @$depositphotos_results->mp4;
		$player_preview_photo = @$depositphotos_results->
			huge_thumb;
			
		include( PVS_PATH . 'includes/players/video_player.php');

		$pvs_theme_content[ 'image' ] = $video_player;
		$pvs_theme_content[ 'downloadsample' ] = @$depositphotos_results->mp4;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$depositphotos_results->
			huge_thumb );
	} else {
		$pvs_theme_content[ 'image' ] = "<img src='" . @$depositphotos_results->
			huge_thumb . "' />";
		$pvs_theme_content[ 'downloadsample' ] = @$depositphotos_results->
			huge_thumb;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$depositphotos_results->
			huge_thumb );
	}

	$publication_type = str_replace( "image", "photo", str_replace( "video",
		"videos", $depositphotos_results->itype ) );

	$pvs_theme_content[ 'title' ] = @$depositphotos_results->title;
	$pvs_theme_content[ 'keywords' ] = @$depositphotos_keywords_links;
	$pvs_theme_content[ 'keywords_lite' ] = @$depositphotos_keywords_links;
	$pvs_theme_content[ 'description' ] = @$depositphotos_results->
		description;
	$pvs_theme_content[ 'category' ] = @$depositphotos_categories_links;
	$pvs_theme_content[ 'author' ] = '<b>' . pvs_word_lang( "Contributor" ) .
		':</b> <a href="' . site_url() . '/?stock=depositphotos&author=' . @$depositphotos_results->
		username . '&stock_type=' . $publication_type . '" >' . @$depositphotos_results->
		username . '</a>';
	$pvs_theme_content[ 'published' ] = @$depositphotos_results->published;
	$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
		".js'></script>";
	$pvs_theme_content[ 'share_title' ] = urlencode(@$depositphotos_results->title );

	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_print_url( @$depositphotos_results->
			id, ( int )get_query_var("pvs_print_id"), @$depositphotos_results->title, $prints_preview,
			"depositphotos" ) );
	} else {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() .
			pvs_get_stock_page_url( "depositphotos", @$depositphotos_results->id, @$depositphotos_results->
			title, get_query_var("depositphotos_type") ) );
	}

	$pvs_theme_content[ 'share_description' ] = urlencode(@$depositphotos_results->description);

	//Type
	$pvs_theme_content[ 'type' ] = '<a href="' . site_url() .
		'/?stock=depositphotos&stock_type=' . $publication_type . '" >' .
		pvs_word_lang( $publication_type ) . '</a>';

	//Model release
	if ( isset( $depositphotos_results->iseditorial ) ) {
		$pvs_theme_content[ 'flag_model' ] = true;

		if ( @$depositphotos_results->iseditorial )
		{
			$pvs_theme_content[ 'model_release' ] = pvs_word_lang( "yes" );
		} else
		{
			$pvs_theme_content[ 'model_release' ] = pvs_word_lang( "no" );
		}
	} else {
		$pvs_theme_content[ 'flag_model' ] = false;
	}

	//Property release
	$pvs_theme_content[ 'flag_property' ] = false;

	//Editorial
	if ( @$depositphotos_results->iseditorial == 1 ) {
		$pvs_theme_content[ 'flag_editorial' ] = true;
		$pvs_theme_content[ 'editorial' ] = pvs_word_lang( "files for editorial use only" );
	} else {
		$pvs_theme_content[ 'flag_editorial' ] = false;
	}

	//Published
	$pvs_theme_content[ 'flag_published' ] = true;

	//Category
	$pvs_theme_content[ 'flag_category' ] = true;

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
	$sizes = "";

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		$display_files = 'block';
		$display_prints = 'none';
		$checked_files = 'checked';
		$checked_prints = '';

		if ( $pvs_global_settings["depositphotos_prints"] and $pvs_global_settings["depositphotos_show"] ==
			2 and ( $publication_type == 'photo' or $publication_type == 'vector' ) )
		{
			$display_files = 'none';
			$display_prints = 'block';
			$checked_files = '';
			$checked_prints = 'checked';
		}

		if ( $pvs_global_settings["depositphotos_files"] and $pvs_global_settings["depositphotos_prints"] and
			( $publication_type == 'photo' or $publication_type == 'vector' ) )
		{
			$sizes .= "<input type='radio' name='license' id='files_label' style='margin:20px 10px 10px 0px'  onClick='apanel(0);' " .
				$checked_files . "><label for='files_label' >" . pvs_word_lang( "files" ) .
				"</label><input type='radio' name='license' id='prints_label' style='margin:20px 10px 10px 20px'  onClick='apanel(1);' " .
				$checked_prints . "><label for='prints_label' >" . pvs_word_lang( "prints and products" ) .
				"</label>";
		}

		if ( $publication_type == 'photo' or $publication_type == 'vector' )
		{
			$sizes .= "<div id='prices_files' style='display:" . $display_files .
				"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th><th>" .
				pvs_word_lang( "filesize" ) . "</th></tr>";
		} else
		{
			$sizes .= "<div id='prices_files' style='display:" . $display_files .
				"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th><th>" .
				pvs_word_lang( "frames per second" ) . "</th></tr>";
		}

		foreach ( $depositphotos_results->sizes as $key => $value )
		{
			$photo_size = "";
			$photo_filesize = "";

			if ( isset( $value->width ) and isset( $value->height ) )
			{
				$photo_size = @$value->width . ' x ' . @$value->height . 'px';
			}

			if ( isset( $value->mp ) and $value->mp != 0 )
			{
				$photo_filesize = $value->mp . ' Mb.';
			}
			if ( isset( $value->fps ) )
			{
				$photo_filesize = $value->fps;
			}

			$sizes .= '<tr valign="top"><td>' . strtoupper( @$key ) . '</td><td>' . $photo_size .
				'</td><td>' . $photo_filesize . '</td></tr>';
		}

		$sizes .= "</table><br>";

		$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "depositphotos", @$depositphotos_results->
			id, get_query_var("depositphotos_type") ) .
			"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
			pvs_word_lang( "Buy on" ) . " Depositphotos</a></div>";

		if ( $pvs_global_settings["depositphotos_prints"] and ( $publication_type ==
			'photo' or $publication_type == 'vector' ) )
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

			$sizes .= "</table><br><a href=\"javascript:prints_stock('depositphotos'," . @$depositphotos_results->
				id . ",'" . urlencode( pvs_get_stock_affiliate_url( "depositphotos", @$depositphotos_results->
				id, get_query_var("depositphotos_type") ) ) . "','" . urlencode( @$depositphotos_results->
				huge_thumb ) . "','" . pvs_get_stock_page_url( "depositphotos", @$depositphotos_results->
				id, @$depositphotos_results->title, get_query_var("depositphotos_type") ) . "','" .
				addslashes( @$depositphotos_results->title ) . "')\" class = 'btn btn-danger btn-lg' style='color:#ffffff;text-decoration:none;'>" .
				pvs_word_lang( "Order print" ) . "</a></div>";
		}
	}

	$pvs_theme_content[ 'sizes' ] = $sizes;
	//End. Sizes

	//Related items
	$related_items = '';
	$related_count = 0;
	$similar_ids = '';
	$similar_count = 0;

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		foreach ( $depositphotos_results->similar as $key => $value )
		{
			if ( $similar_count < $pvs_global_settings["related_items_quantity"] )
			{
				$similar_ids .= '&dp_media_id[]=' . $value;
			}

			$similar_count++;
		}

		$url = 'http://api.depositphotos.com?dp_apikey=' . $pvs_global_settings["depositphotos_id"] .
			'&dp_command=getMediaData' . $similar_ids;
		//echo($url);

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

		$data = curl_exec( $ch );
		if ( ! curl_errno( $ch ) )
		{
			$depositphotos_related = json_decode( $data );
			//var_dump($depositphotos_related);

			for ( $k = 0; $k < $similar_count; $k++ )
			{
				if ( isset( $depositphotos_related->{"item" . $k} ) )
				{
					$value = $depositphotos_related->{"item" . $k};

					if ( @$value->id != '' )
					{
						//Image
						if ( $value->itype == "image" or $value->itype == "vector" )
						{
							$preview_title = @$value->title;
							$preview_img = @$value->huge_thumb;

							$lightbox_width = @$value->width;
							$lightbox_height = @$value->height;
							$lightbox_url = @$value->huge_thumb;

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

							$flow_width = @$value->assets->preview->width;
							$flow_height = @$value->assets->preview->height;
						}

						//Video
						if ( $value->itype == "video" )
						{
							$preview_title = @$value->title;
							$preview_img = @$value->huge_thumb;

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

						$publication_type = str_replace( "image", "photo", str_replace( "video",
							"videos", $depositphotos_results->itype ) );

						$preview_title = "#" . @$value->id;

						$related_id = @$value->id;
						$related_title = $preview_title;
						$related_description = "";
						$related_url = pvs_get_stock_page_url( "depositphotos", @$value->
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
		$preview_url = @$depositphotos_results->huge_thumb;
		$sz = getimagesize( $preview_url );
		$iframe_width = $sz[0];
		$iframe_height = $sz[1];
		$default_width = @$depositphotos_results->width;
		$default_height = @$depositphotos_results->height;

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

		$stock_id = @$depositphotos_results->id;
		$stock_type = "depositphotos";

		$pvs_theme_content[ 'stock_type' ] = $stock_type;
		$pvs_theme_content[ 'stock_id' ] = $stock_id;
		$pvs_theme_content[ 'stock_url' ] = @$depositphotos_results->itemurl;
		$pvs_theme_content[ 'stock_preview' ] = $preview_url;
		$pvs_theme_content[ 'stock_site_url' ] = pvs_print_url( @$depositphotos_results->
			id, ( int )get_query_var("pvs_print_id"), @$depositphotos_results->title, $prints_preview,
			"depositphotos" );

		$id_parent = get_query_var('depositphotos');
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