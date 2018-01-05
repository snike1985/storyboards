<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

include ( "content_js_stock.php" );

if ( isset( $istockphoto_results ) ) {
	//Show only istockphoto syntax
	foreach ( $mstocks as $key => $value ) {
		if ( $key == 'istockphoto' )
		{
			$pvs_theme_content[ $key ] = true;
		} else
		{
			$pvs_theme_content[ $key ] = false;
		}
	}

	$pvs_theme_content[ 'id' ] = $istockphoto_results->id;

	if ( get_query_var('istockphoto_type') == "videos" ) {

		$istockphoto_video = @$istockphoto_results->display_sizes;
		$istockphoto_video2 = $istockphoto_video[0];

		$player_video_id = strval( @$istockphoto_results->id );
		$player_video_root = pvs_plugins_url();
		$player_video_width = $pvs_global_settings["ffmpeg_video_width"];
		$player_video_height = round( $pvs_global_settings["ffmpeg_video_width"] * 9 / 16 );
		$player_preview_video = @$istockphoto_video2->uri;
		$player_preview_photo = @$istockphoto_image2->uri;
		
		include( PVS_PATH . 'includes/players/video_player.php');

		$pvs_theme_content[ 'image' ] = $video_player;
		$pvs_theme_content[ 'downloadsample' ] = @$istockphoto_video2->uri;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$istockphoto_image2-> uri );
	} else {
		$pvs_theme_content[ 'image' ] = "<img src='" . @$istockphoto_preview->uri .
			"' />";
		$pvs_theme_content[ 'downloadsample' ] = @$istockphoto_preview->uri;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$istockphoto_preview->uri );
	}

	$publication_type = pvs_result( get_query_var('istockphoto_type') );

	$pvs_theme_content[ 'title' ] = @$istockphoto_results->title;
	$pvs_theme_content[ 'keywords' ] = @$istockphoto_keywords_links;
	$pvs_theme_content[ 'keywords_lite' ] = @$istockphoto_keywords_links;
	$pvs_theme_content[ 'description' ] = "";
	$pvs_theme_content[ 'category' ] = @$istockphoto_categories_links;
	$pvs_theme_content[ 'author' ] = '<b>' . pvs_word_lang( "Artist" ) .
		':</b> <a href="' . site_url() . '/?stock=istockphoto&author=' . @$istockphoto_results->
		artist . '&stock_type=' . $publication_type . '&print_id=' . ( int ) get_query_var('pvs_print_id') .
		'" >' . @$istockphoto_results->artist . '</a>';
	$pvs_theme_content[ 'published' ] = @$istockphoto_results->date_submitted;
	$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
		".js'></script>";
	$pvs_theme_content[ 'share_title' ] = urlencode( @$istockphoto_results->title );
	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_print_url( @$istockphoto_results->
			id, ( int ) get_query_var('pvs_print_id'), @$istockphoto_results->title, $prints_preview,
			"istockphoto" ) );
	} else {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() .
			pvs_get_stock_page_url( "istockphoto", @$istockphoto_results->id, @$istockphoto_results->
			title, get_query_var('istockphoto_type') ) );
	}
	$pvs_theme_content[ 'share_description' ] = "";

	//Type
	$pvs_theme_content[ 'type' ] = '<a href="' . site_url() .
		'/?stock=istockphoto&stock_type=' . $publication_type . '&print_id=' .
		( int ) get_query_var('pvs_print_id') . '" >' . pvs_word_lang( $publication_type ) .
		'</a>';

	//Published
	$pvs_theme_content[ 'flag_published' ] = true;

	//Category
	$pvs_theme_content[ 'flag_category' ] = true;

	//Model release
	if ( isset( $istockphoto_results->allowed_use->release_info ) ) {
		$pvs_theme_content[ 'flag_model' ] = true;
		$pvs_theme_content[ 'model_release' ] = @$istockphoto_results->
			allowed_use->release_info;
	} else {
		$pvs_theme_content[ 'flag_model' ] = false;
	}

	//Property release
	$pvs_theme_content[ 'flag_property' ] = false;

	//Editorial
	if ( @$istockphoto_results->asset_family == 'editorial' ) {
		$pvs_theme_content[ 'flag_editorial' ] = true;
		$pvs_theme_content[ 'editorial' ] = pvs_word_lang( "files for editorial use only" );
	} else {
		$pvs_theme_content[ 'flag_editorial' ] = false;
	}

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
		if ( get_query_var('istockphoto_type') == "photo" )
		{
			$display_files = 'block';
			$display_prints = 'none';
			$checked_files = 'checked';
			$checked_prints = '';

			if ( $pvs_global_settings["istockphoto_prints"] and $pvs_global_settings["istockphoto_show"] ==
				2 )
			{
				$display_files = 'none';
				$display_prints = 'block';
				$checked_files = '';
				$checked_prints = 'checked';
			}

			if ( $pvs_global_settings["istockphoto_files"] and $pvs_global_settings["istockphoto_prints"] )
			{
				$sizes .= "<input type='radio' name='license' id='files_label' style='margin:20px 10px 10px 0px'  onClick='apanel(0);' " .
					$checked_files . "><label for='files_label' >" . pvs_word_lang( "files" ) .
					"</label><input type='radio' name='license' id='prints_label' style='margin:20px 10px 10px 20px'  onClick='apanel(1);' " .
					$checked_prints . "><label for='prints_label' >" . pvs_word_lang( "prints and products" ) .
					"</label>";
			}

			$sizes .= "<div id='prices_files' style='display:" . $display_files .
				"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th style='width:50%'>" .
				pvs_word_lang( "type" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th><th>" .
				pvs_word_lang( "filesize" ) . "</th></tr>";

			foreach ( $istockphoto_results->download_sizes as $key => $value )
			{
				if ( isset( $value->media_type ) )
				{
					$photo_size = "";
					$photo_filesize = "";

					if ( isset( $value->width ) and isset( $value->height ) )
					{
						$photo_size = @$value->width . ' x ' . @$value->height . 'px';
					}

					if ( isset( $value->bytes ) )
					{
						$photo_filesize = strval( pvs_price_format( @$value->bytes / ( 1024 * 1024 ), 3 ) ) .
							' Mb.';
					}

					$size_title = explode( "/", @$value->media_type );

					$sizes .= '<tr valign="top"><td>' . strtoupper( @$size_title[1] ) . '</td><td>' .
						$photo_size . '</td><td>' . $photo_filesize . '</td></tr>';
				}
			}

			$sizes .= "</table><br>";

			$referal_url = @$istockphoto_results->referral_destinations;

			$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "istockphoto", @$istockphoto_results->
				id, get_query_var('istockphoto_type'), @$referal_url[0]->uri, @$referal_url[1]->uri ) .
				"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
				pvs_word_lang( "Buy on" ) . " " . $pvs_global_settings['istockphoto_site'] .
				"</a></div>";

			if ( $pvs_global_settings["istockphoto_prints"] )
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

				$sizes .= "</table><br><a href=\"javascript:prints_stock('istockphoto'," . @$istockphoto_results->
					id . ",'" . urlencode( pvs_get_stock_affiliate_url( "istockphoto", @$istockphoto_results->
					id, get_query_var('istockphoto_type'), @$referal_url[0]->uri, @$referal_url[1]->uri ) ) .
					"','" . urlencode( @$istockphoto_preview->uri ) . "','" . pvs_get_stock_page_url( "istockphoto",
					@$istockphoto_results->id, @$istockphoto_results->title, get_query_var('istockphoto_type') ) .
					"','" . addslashes( @$istockphoto_results->title ) . "')\" class = 'btn btn-danger btn-lg' style='color:#ffffff;text-decoration:none;'>" .
					pvs_word_lang( "Order print" ) . "</a></div>";
			}
		} else
		{
			$sizes = "<table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th >" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "description" ) .
				"</th><th>" . pvs_word_lang( "type" ) . "</th></tr>";

			foreach ( $istockphoto_results->download_sizes as $key => $value )
			{
				if ( isset( $value->name ) )
				{
					$sizes .= '<tr valign="top"><td>' . strtoupper( @$value->name ) . '</td><td>' .
						@$value->description . ' ' . @$value->bit_depth . '</td><td>' . @$value->
						content_type . '</td></tr>';
				}
			}

			$sizes .= "</table><br><br>";

			$referal_url = @$istockphoto_results->referral_destinations;

			$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "istockphoto", @$istockphoto_results->
				id, get_query_var('istockphoto_type'), @$referal_url[0]->uri, @$referal_url[1]->uri ) .
				"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
				pvs_word_lang( "Buy on" ) . " " . $pvs_global_settings['istockphoto_site'] .
				"</a>";
		}
	}
	$pvs_theme_content[ 'sizes' ] = $sizes;
	//End. Sizes

	//Related items
	$related_items = '';
	$related_count = 0;

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		if ( get_query_var('istockphoto_type') == "photo" )
		{
			$url = 'https://api.gettyimages.com/v3/search/images?fields=thumb,preview,max_dimensions,title,comp&phrase=' .
				urlencode( str_replace( " ", ",", @$istockphoto_keywords_related ) ) .
				'&page=1&page_size=' . $pvs_global_settings["related_items_quantity"] .
				'&artists=' . urlencode( @$istockphoto_results->artist );
		} else
		{
			$url = 'https://api.gettyimages.com/v3/search/videos?fields=thumb,preview,title,comp&phrase=' .
				urlencode( str_replace( " ", ",", @$istockphoto_keywords_related ) ) .
				'&page=1&page_size=' . $pvs_global_settings["related_items_quantity"];
		}
		//echo($url);

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Api-Key: ' . $pvs_global_settings["istockphoto_id"] ) );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

		$data = curl_exec( $ch );
		if ( ! curl_errno( $ch ) )
		{
			$istockphoto_related = json_decode( $data );
			//var_dump($istockphoto_related);

			if ( isset( $istockphoto_related->images ) or isset( $istockphoto_related->
				videos ) )
			{
				if ( get_query_var('istockphoto_type') == "photo" )
				{
					$data_istock = $istockphoto_related->images;
				} else
				{
					$data_istock = $istockphoto_related->videos;
				}

				foreach ( $data_istock as $key => $value )
				{
					$preview_title = @$value->title;

					if ( get_query_var('istockphoto_type') == "photo" )
					{
						$preview_image = @$value->display_sizes;
						$preview_image2 = $preview_image[0];
						$preview_img = @$preview_image2->uri;

						$lightbox_width = @$value->max_dimensions->width;
						$lightbox_height = @$value->max_dimensions->height;
						$lightbox_url = @$preview_image2->uri;

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

						$flow_width = @$preview_image2->width;
						$flow_height = @$preview_image2->height;
					} else
					{
						//Video
						$istockphoto_preview2 = @$value->display_sizes;
						$istockphoto_image2 = $istockphoto_preview2[2];
						$istockphoto_video2 = $istockphoto_preview2[0];

						$preview_img = @$istockphoto_image2->uri;

						$video_width = $pvs_global_settings["video_width"];
						$video_height = round( $pvs_global_settings["video_width"] * 9 / 16 );

						$lightbox_hover = "onMouseover=\"lightboxon_istock('" . @$istockphoto_video2->
							uri . "'," . $video_width . "," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
							$video_width . "," . $video_height . ",event)\"";

						$flow_width = $pvs_global_settings["width_flow"];
						$flow_height = round( $pvs_global_settings["width_flow"] * 9 / 16 );
					}

					$preview_title = "#" . @$value->id;


					$related_id = @$value->id;
					$related_title = $preview_title;
					$related_description = "";
					$related_url = pvs_get_stock_page_url( "istockphoto", @$value->
						id, @$value->title, "photo" );
					$related_preview = $preview_img;
					$related_lightbox = $lightbox_hover;

					$related_width = $flow_width;
					$related_height = $flow_height;

					if ( @$value->id != @$istockphoto_results->id )
					{
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
		$preview_url = @$istockphoto_preview->uri;
		$sz = getimagesize( $preview_url );
		$iframe_width = $sz[0];
		$iframe_height = $sz[1];
		$default_width = @$istockphoto_results->max_dimensions->width;
		$default_height = @$istockphoto_results->max_dimensions->height;

		$pvs_theme_content[ 'print_title' ] = pvs_word_lang( @$prints_title );

		$flag_resize = 0;
		$resize_min = $pvs_global_settings["thumb_width2"];
		;
		$resize_max = $pvs_global_settings["prints_previews_width"];
		$resize_value = $pvs_global_settings["thumb_width2"];
		;

		$sql = "select * from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int ) get_query_var('pvs_print_id');
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

		$stock_id = $istockphoto_results->id;
		$stock_type = "istockphoto";

		$pvs_theme_content[ 'stock_type' ] = $stock_type;
		$pvs_theme_content[ 'stock_id' ] = $stock_id;
		$pvs_theme_content[ 'stock_url' ] = @$istockphoto_results->referral_destinations{0}->uri;
		$pvs_theme_content[ 'stock_preview' ] = $preview_url;
		$pvs_theme_content[ 'stock_site_url' ] = pvs_print_url( @$istockphoto_results->
			id, ( int ) get_query_var('pvs_print_id'), @$istockphoto_results->title, $prints_preview,
			"istockphoto" );


		
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