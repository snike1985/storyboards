<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
include ( "content_js_stock.php" );

if ( isset( $fotolia_results ) ) {
	//Show only fotolia syntax
	foreach ( $mstocks as $key => $value ) {
		if ( $key == 'fotolia' )
		{
			$pvs_theme_content[ $key ] = true;
		} else
		{
			$pvs_theme_content[ $key ] = false;
		}
	}

	//var_dump($fotolia_results);

	$pvs_theme_content[ 'id' ] = $fotolia_results->id;

	$fotolia_photo = str_replace( "/110_", "/500_", @$fotolia_results->
		thumbnail_url );

	if ( get_query_var("fotolia_type") == "video" ) {

		$player_video_id = strval( @$fotolia_results->id );
		$player_video_root = pvs_plugins_url();
		$player_video_width = $pvs_global_settings["ffmpeg_video_width"];
		$player_video_height = round( $pvs_global_settings["ffmpeg_video_width"] *
			@$fotolia_results->thumbnail_height / @$fotolia_results->thumbnail_width );
		$player_preview_video = @$fotolia_results->flv_url;
		$player_preview_photo = $fotolia_photo;
		
		include( PVS_PATH . 'includes/players/video_player.php');

		$pvs_theme_content[ 'image' ] = $video_player;
		$pvs_theme_content[ 'downloadsample' ] = @$fotolia_results->flv_url;
		$pvs_theme_content[ 'share_image' ] = urlencode( $fotolia_photo );
	} else {

		$pvs_theme_content[ 'image' ] = "<img src='" . $fotolia_photo . "' />";
		$pvs_theme_content[ 'downloadsample' ] = $fotolia_photo;
		$pvs_theme_content[ 'share_image' ] = urlencode( $fotolia_photo );
	}

	if ( @$fotolia_results->media_type_id == 1 ) {
		$publication_type = "photo";
	}
	if ( @$fotolia_results->media_type_id == 2 ) {
		$publication_type = "illustration";
	}
	if ( @$fotolia_results->media_type_id == 3 ) {
		$publication_type = "vector";
	}
	if ( @$fotolia_results->media_type_id == 4 ) {
		$publication_type = "videos";
	}

	$pvs_theme_content[ 'title' ] = @$fotolia_results->title;
	$pvs_theme_content[ 'viewed' ] = @$fotolia_results->nb_views;
	$pvs_theme_content[ 'downloaded' ] = @$fotolia_results->nb_downloads;
	$pvs_theme_content[ 'keywords' ] = @$fotolia_keywords_links;
	$pvs_theme_content[ 'keywords_lite' ] = @$fotolia_keywords_links;
	$pvs_theme_content[ 'description' ] = "";
	$pvs_theme_content[ 'category' ] = $fotolia_categories_links;
	$pvs_theme_content[ 'author' ] = '<b>' . pvs_word_lang( "Contributor" ) .
		':</b> <a href="' . site_url() . '/?stock=fotolia&author=' . $fotolia_results->
		creator_id . '&stock_type=' . $publication_type . '" >' . $fotolia_results->
		creator_name . '</a>';

	$fotolia_date = explode( ".", @$fotolia_results->creation_date );

	$pvs_theme_content[ 'published' ] = $fotolia_date[0];
	$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
		".js'></script>";
	$pvs_theme_content[ 'share_title' ] = urlencode( @$fotolia_results->title );

	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_print_url( @$fotolia_results->
			id, ( int )get_query_var("pvs_print_id"), @$fotolia_results->title, $prints_preview,
			"fotolia" ) );
	} else {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() .
			pvs_get_stock_page_url( "fotolia", @$fotolia_results->id, @$fotolia_results->
			title, get_query_var("fotolia_type") ) );
	}

	$pvs_theme_content[ 'share_description' ] = "";

	//Type
	$pvs_theme_content[ 'type' ] = '<a href="' . site_url() .
		'/?stock=fotolia&stock_type=' . $publication_type . '" >' .
		pvs_word_lang( $publication_type ) . '</a>';

	//Model release
	if ( isset( $fotolia_results->has_releases ) ) {
		$pvs_theme_content[ 'flag_model' ] = true;

		if ( @$fotolia_results->has_releases )
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
	$pvs_theme_content[ 'flag_editorial' ] = false;

	//Duration
	if ( isset( $fotolia_results->duration ) ) {
		$pvs_theme_content[ 'flag_duration' ] = true;
		$pvs_theme_content[ 'duration' ] = @$fotolia_results->duration;
	} else {
		$pvs_theme_content[ 'flag_duration' ] = false;
	}

	//Aspect ratio
	if ( isset( $fotolia_results->aspect_ratio ) ) {
		$pvs_theme_content[ 'flag_aspect' ] = true;
		$pvs_theme_content[ 'aspect' ] =@$fotolia_results->aspect_ratio;
	} else {
		$pvs_theme_content[ 'flag_aspect' ] = false;
	}

	//Published
	$pvs_theme_content[ 'flag_published' ] = true;

	//Category
	$pvs_theme_content[ 'flag_category' ] = true;

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
	$fps = "";

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		$display_files = 'block';
		$display_prints = 'none';
		$checked_files = 'checked';
		$checked_prints = '';

		if ( $pvs_global_settings["fotolia_prints"] and $pvs_global_settings["fotolia_show"] ==
			2 and @$fotolia_results->media_type_id != 4 )
		{
			$display_files = 'none';
			$display_prints = 'block';
			$checked_files = '';
			$checked_prints = 'checked';
		}

		if ( @$fotolia_results->media_type_id == 4 )
		{
			$fps = "<th>" . pvs_word_lang( "FPS" ) . "</th>";
		}

		if ( $pvs_global_settings["fotolia_files"] and $pvs_global_settings["fotolia_prints"] and
			@$fotolia_results->media_type_id != 4 )
		{
			$sizes .= "<input type='radio' name='license' id='files_label' style='margin:20px 10px 10px 0px'  onClick='apanel(0);' " .
				$checked_files . "><label for='files_label' >" . pvs_word_lang( "files" ) .
				"</label><input type='radio' name='license' id='prints_label' style='margin:20px 10px 10px 20px'  onClick='apanel(1);' " .
				$checked_prints . "><label for='prints_label' >" . pvs_word_lang( "prints and products" ) .
				"</label>";
		}

		$sizes .= "<div id='prices_files' style='display:" . $display_files .
			"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
			pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th>" . $fps .
			"</tr>";

		foreach ( $fotolia_results->licenses_details as $key => $value )
		{
			if ( isset( $value->license_name ) )
			{
				if ( @$fotolia_results->media_type_id == 4 )
				{
					$sizes .= '<tr valign="top"><td>' . $value->license_name . '</td><td>' . $value->
						dimensions . '</td><td>' . $value->fps . '</td></tr>';
				} else
				{
					$sizes .= '<tr valign="top"><td>' . $value->license_name . '</td><td>' . $value->
						phrase . '</td></tr>';
				}
			}
		}

		$sizes .= "</table><br>";

		$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "fotolia", $fotolia_results->
			id, get_query_var("fotolia_type") ) .
			"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
			pvs_word_lang( "Buy on" ) . " Fotolia</a></div>";

		if ( $pvs_global_settings["fotolia_prints"] and @$fotolia_results->
			media_type_id != 4 )
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

			$sizes .= "</table><br><a href=\"javascript:prints_stock('fotolia'," . @$fotolia_results->
				id . ",'" . urlencode( pvs_get_stock_affiliate_url( "fotolia", @$fotolia_results->
				id, get_query_var("fotolia_type"), @$fotolia_results->affiliation_link ) ) . "','" .
				urlencode( @$fotolia_photo ) . "','" . pvs_get_stock_page_url( "fotolia", @$fotolia_results->
				id, @$fotolia_results->title, get_query_var("fotolia_type") ) . "','" . addslashes( @$fotolia_results->
				title ) . "')\" class = 'btn btn-danger btn-lg' style='color:#ffffff;text-decoration:none;'>" .
				pvs_word_lang( "Order print" ) . "</a></div>";
		}
	}
	$pvs_theme_content[ 'sizes' ] = $sizes;
	//End. Sizes

	//Related items
	$related_items = '';
	$related_count = 0;

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		if ( get_query_var("fotolia_type") != "audio" )
		{
			$auth = base64_encode( $pvs_global_settings["fotolia_id"] . ":" );

			if ( @$fotolia_results->media_type_id == 1 )
			{
				$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:photo]=1&search_parameters[similar]=' .
					@$fotolia_results->id . '&search_parameters[offset]=0&search_parameters[limit]=' .
					$pvs_global_settings["related_items_quantity"];
			}
			if ( @$fotolia_results->media_type_id == 2 )
			{
				$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:illustration]=1&search_parameters[similar]=' .
					@$fotolia_results->id . '&search_parameters[offset]=0&search_parameters[limit]=' .
					$pvs_global_settings["related_items_quantity"];
			}
			if ( @$fotolia_results->media_type_id == 3 )
			{
				$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:vector]=1&search_parameters[similar]=' .
					@$fotolia_results->id . '&search_parameters[offset]=0&search_parameters[limit]=' .
					$pvs_global_settings["related_items_quantity"];
			}
			if ( @$fotolia_results->media_type_id == 4 )
			{
				$url = 'http://api.fotolia.com/Rest/1/search/getSearchResults?search_parameters[filters][content_type:video]=1&search_parameters[similar]=' .
					@$fotolia_results->id . '&search_parameters[offset]=0&search_parameters[limit]=' .
					$pvs_global_settings["related_items_quantity"];
			}

			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Basic ' . $auth ) );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

			$data = curl_exec( $ch );
			if ( ! curl_errno( $ch ) )
			{
				$fotolia_related = json_decode( $data );
				//var_dump($fotolia_related);

				foreach ( $fotolia_related as $key => $value )
				{
					if ( isset( $value->id ) )
					{
						//Image
						if ( @$value->media_type_id == 1 or @$value->media_type_id == 2 or @$value->
							media_type_id == 3 )
						{
							$preview_title = @$value->title;
							$preview_img = @$value->thumbnail_400_url;

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
								( "'", "", str_replace( "\n", "", str_replace( "\r", "", $value->title ) ) ) ) .
								"','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" . $lightbox_width .
								"," . $lightbox_height . ",event)\"";

							$flow_width = @$value->thumbnail_400_width;
							$flow_height = @$value->thumbnail_400_height;
						}

						//Video
						if ( @$value->media_type_id == 4 )
						{
							$preview_title = @$value->title;
							$preview_img = @$value->thumbnail_400_url;

							$video_width = $pvs_global_settings["video_width"];
							$video_height = round( $pvs_global_settings["video_width"] * @$value->
								thumbnail_400_height / @$value->thumbnail_400_width );

							$video_mp4 = @$value->video_data->formats->comp->url;
							$lightbox_hover = "onMouseover=\"lightboxon5('" . $video_mp4 . "'," . $video_width .
								"," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
								$video_width . "," . $video_height . ",event)\"";

							$flow_width = $pvs_global_settings["width_flow"];
							$flow_height = round( $pvs_global_settings["width_flow"] * @$value->
								thumbnail_400_height / @$value->thumbnail_400_width );
						}

						if ( @$value->media_type_id == 1 )
						{
							$related_type = "photo";
						}
						if ( @$value->media_type_id == 2 )
						{
							$related_type = "illustration";
						}
						if ( @$value->media_type_id == 3 )
						{
							$related_type = "vector";
						}
						if ( @$value->media_type_id == 4 )
						{
							$related_type = "videos";
						}

						$preview_title = "#" . @$value->id;

						$related_id = @$value->id;
						$related_title = $preview_title;
						$related_description = "";
						$related_url = pvs_get_stock_page_url( "fotolia", $value->
							id, $value->title, $related_type );
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
		$preview_url = $fotolia_photo;
		$sz = getimagesize( $preview_url );
		$iframe_width = $sz[0];
		$iframe_height = $sz[1];
		$default_width = $sz[0] * 20;
		$default_height = $sz[1] * 20;

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

		$stock_id = @$fotolia_results->id;
		$stock_type = "fotolia";

		$pvs_theme_content[ 'stock_type' ] = $stock_type;
		$pvs_theme_content[ 'stock_id' ] = $stock_id;
		$pvs_theme_content[ 'stock_url' ] = pvs_get_stock_affiliate_url( "fotolia",
			@$fotolia_results->id, $publication_type, @$fotolia_results->affiliation_link );
		$pvs_theme_content[ 'stock_preview' ] = $preview_url;
		$pvs_theme_content[ 'stock_site_url' ] = pvs_print_url( @$fotolia_results->
			id, ( int )get_query_var("pvs_print_id"), @$fotolia_results->title, $prints_preview,
			"fotolia" );

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