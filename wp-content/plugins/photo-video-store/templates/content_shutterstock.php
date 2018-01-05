<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
include ( "content_js_stock.php" );

if ( isset( $shutterstock_results ) ) {

	//Show only istockphoto syntax
	foreach ( $mstocks as $key => $value ) {
		if ( $key == 'shutterstock' )
		{
			$pvs_theme_content[ $key ] = true;
		} else
		{
			$pvs_theme_content[ $key ] = false;
		}
	}

	//var_dump($shutterstock_results);

	$pvs_theme_content[ 'id' ] = $shutterstock_results->id;

	if ( get_query_var('shutterstock_type') == "video" ) {

		$player_video_id = strval( @$shutterstock_results->id );
		$player_video_root = pvs_plugins_url();
		$player_video_width = $pvs_global_settings["ffmpeg_video_width"];
		$player_video_height = round( $pvs_global_settings["ffmpeg_video_width"] / @$shutterstock_results->aspect );
		$player_preview_video = @$shutterstock_results->assets-> preview_mp4->url;
		$player_preview_photo = @$shutterstock_results->assets-> thumb_jpg->url;

		include( PVS_PATH . 'includes/players/video_player.php');

		$pvs_theme_content[ 'image' ] = $video_player;
		
		$pvs_theme_content[ 'downloadsample' ] = @$shutterstock_results->assets->
			preview_mp4->url;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$shutterstock_results->
			assets->thumb_jpg->url );
	} elseif ( get_query_var("shutterstock_type") == "audio" ) {

		$player_audio_id = strval( @$shutterstock_results->id );
		$player_audio_root = pvs_plugins_url();
		$player_preview_audio = @$shutterstock_results->assets->preview_mp3->url;

		$pvs_theme_content[ 'image' ] = "<img src='" . @$shutterstock_results->
			assets->waveform->url . "' style='margin-bottom:5px' />" . $audio_player;
		$pvs_theme_content[ 'downloadsample' ] = @$shutterstock_results->assets->
			preview_mp3->url;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$shutterstock_results->
			assets->waveform->url );
	} else {
		$pvs_theme_content[ 'image' ] = "<img src='" . @$shutterstock_results->
			assets->preview->url . "' />";
		$pvs_theme_content[ 'downloadsample' ] = @$shutterstock_results->assets->
			preview->url;
		$pvs_theme_content[ 'share_image' ] = urlencode( @$shutterstock_results->
			assets->preview->url );
	}

	$publication_type = 'photo';
	if ( isset( $shutterstock_results->image_type ) ) {
		$publication_type = @$shutterstock_results->image_type;
	} else {
		$publication_type = str_replace( "audio", "music", str_replace( "video",
			"videos", @$shutterstock_results->media_type ) );
	}

	$pvs_theme_content[ 'title' ] = @$shutterstock_results->description;
	$pvs_theme_content[ 'keywords' ] = @$shutterstock_keywords_links;
	$pvs_theme_content[ 'keywords_lite' ] = @$shutterstock_keywords_links;
	$pvs_theme_content[ 'description' ] = @$shutterstock_results->description;
	$pvs_theme_content[ 'category' ] = @$shutterstock_categories_links;
	$pvs_theme_content[ 'author' ] = '<b>' . pvs_word_lang( "Contributor" ) .
		':</b> <a href="' . site_url() . '/?stock=shutterstock&author=' . @$shutterstock_results->
		contributor->id . '&stock_type=' . $publication_type . '" >#' . @$shutterstock_results->
		contributor->id . '</a>';
	$pvs_theme_content[ 'published' ] = @$shutterstock_results->added_date;
	$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
		".js'></script>";
	$pvs_theme_content[ 'share_title' ] = urlencode(@$shutterstock_results->description);

	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_print_url( @$shutterstock_results->
			id, ( int ) get_query_var('pvs_print_id'), @$shutterstock_results->description, $prints_preview,
			"shutterstock" ) );
	} else {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() .
			pvs_get_stock_page_url( "shutterstock", @$shutterstock_results->id, @$shutterstock_results->
			description, get_query_var('shutterstock_type') ) );
	}

	$pvs_theme_content[ 'share_description' ] = urlencode(@$shutterstock_results->description );

	//Type
	$pvs_theme_content[ 'type' ] = '<a href="' . site_url() .
		'/?stock=shutterstock&stock_type=' . $publication_type . '" >' .
		pvs_word_lang( $publication_type ) . '</a>';

	//Published
	$pvs_theme_content[ 'flag_published' ] = true;

	//Category
	$pvs_theme_content[ 'flag_category' ] = true;

	//Model release
	if ( isset( $shutterstock_results->has_model_release ) ) {
		$pvs_theme_content[ 'flag_model' ] = true;

		if ( @$shutterstock_results->has_model_release )
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
	if ( isset( $shutterstock_results->has_property_release ) ) {
		$pvs_theme_content[ 'flag_property' ] = true;

		if ( @$shutterstock_results->has_property_release )
		{
			$pvs_theme_content[ 'property_release' ] = pvs_word_lang( "yes" );
		} else
		{
			$pvs_theme_content[ 'property_release' ] = pvs_word_lang( "no" );
		}
	} else {
		$pvs_theme_content[ 'flag_property' ] = false;
	}

	//Editorial
	if ( isset( $shutterstock_results->is_editorial ) ) {
		$pvs_theme_content[ 'flag_editorial' ] = true;
		$pvs_theme_content[ 'editorial' ] = pvs_word_lang( "files for editorial use only" );
	} else {
		$pvs_theme_content[ 'flag_editorial' ] = false;
	}

	//Duration
	if ( isset( $shutterstock_results->duration ) ) {
		$pvs_theme_content[ 'flag_duration' ] = true;
		$pvs_theme_content[ 'duration' ] = @$shutterstock_results->duration;
	} else {
		$pvs_theme_content[ 'flag_duration' ] = false;
	}

	//Aspect ratio
	if ( isset( $shutterstock_results->aspect_ratio ) ) {
		$pvs_theme_content[ 'flag_aspect' ] = true;
		$pvs_theme_content[ 'aspect_ratio' ] = @$shutterstock_results->
			aspect_ratio;
	} else {
		$pvs_theme_content[ 'flag_aspect' ] = false;
	}

	//Bites per minute
	if ( isset( $shutterstock_results->bpm ) ) {
		$pvs_theme_content[ 'flag_bpm' ] = true;
		$pvs_theme_content[ 'bpm' ] = @$shutterstock_results->bpm;
	} else {
		$pvs_theme_content[ 'flag_bpm' ] = false;
	}

	//Album
	if ( isset( $shutterstock_results->album->title ) and $shutterstock_results->
		album->title != '' ) {
		$pvs_theme_content[ 'flag_album' ] = true;
		$pvs_theme_content[ 'album' ] = '<a href="' . site_url() .
			'/?stock=shutterstock&stock_type=music&album=' . @$shutterstock_results->
			album->title . '">' . @$shutterstock_results->album->title . "</a>";
	} else {
		$pvs_theme_content[ 'flag_album' ] = false;
	}

	//Vocal description
	if ( isset( $shutterstock_results->vocal_description ) and $shutterstock_results->
		vocal_description != '' ) {
		$pvs_theme_content[ 'flag_vocal_description' ] = true;
		$pvs_theme_content[ 'vocal_description' ] = @$shutterstock_results->vocal_description;
	} else {
		$pvs_theme_content[ 'flag_vocal_description' ] = false;
	}

	//Lyrics
	if ( isset( $shutterstock_results->lyrics ) and $shutterstock_results->lyrics !=
		'' ) {
		$pvs_theme_content[ 'flag_lyrics' ] = true;
		$pvs_theme_content[ 'lyrics' ] = @$shutterstock_results->lyrics;
	} else {
		$pvs_theme_content[ 'flag_lyrics' ] = false;
	}

	//Artists
	if ( isset( $shutterstock_results->artists ) ) {
		$shutterstock_artists = "";
		if ( isset( $shutterstock_results->artists ) )
		{
			foreach ( $shutterstock_results->artists as $key => $value )
			{
				if ( $shutterstock_artists != "" )
				{
					$shutterstock_artists .= ', ';
				}
				$shutterstock_artists .= '<a href="' . site_url() .
					'/?stock=shutterstock&stock_type=music&artists=' . @$value->name .
					'" >' . @$value->name . '</a>';
			}
		}

		if ( $shutterstock_artists != '' )
		{
			$pvs_theme_content[ 'artists' ] = $shutterstock_artists;
			$pvs_theme_content[ 'flag_artists' ] = true;
		} else
		{
			$pvs_theme_content[ 'flag_artists' ] = false;
		}
	} else {
		$pvs_theme_content[ 'flag_artists' ] = false;
	}

	//Genres
	if ( isset( $shutterstock_results->genres ) ) {
		$shutterstock_genres = "";
		if ( isset( $shutterstock_results->genres ) )
		{
			foreach ( $shutterstock_results->genres as $key => $value )
			{
				if ( $shutterstock_genres != "" )
				{
					$shutterstock_genres .= ', ';
				}
				$shutterstock_genres .= '<a href="' . site_url() .
					'/?stock=shutterstock&stock_type=music&genre=' . $value . '" >' . $value .
					'</a>';
			}
		}

		if ( $shutterstock_genres != '' )
		{
			$pvs_theme_content[ 'genres' ] = $shutterstock_genres;
			$pvs_theme_content[ 'flag_genres' ] = true;
		} else
		{
			$pvs_theme_content[ 'flag_genres' ] = false;
		}
	} else {
		$pvs_theme_content[ 'flag_genres' ] = false;
	}

	//Instruments
	if ( isset( $shutterstock_results->instruments ) ) {
		$shutterstock_instruments = "";
		if ( isset( $shutterstock_results->instruments ) )
		{
			foreach ( $shutterstock_results->instruments as $key => $value )
			{
				if ( $shutterstock_instruments != "" )
				{
					$shutterstock_instruments .= ', ';
				}
				$shutterstock_instruments .= '<a href="' . site_url() .
					'/?stock=shutterstock&stock_type=music&instruments=' . $value . '" >' .
					$value . '</a>';
			}
		}

		if ( $shutterstock_instruments != '' )
		{
			$pvs_theme_content[ 'instruments' ] = $shutterstock_instruments;
			$pvs_theme_content[ 'flag_instruments' ] = true;
		} else
		{
			$pvs_theme_content[ 'flag_instruments' ] = false;
		}
	} else {
		$pvs_theme_content[ 'flag_instruments' ] = false;
	}

	//Moods
	if ( isset( $shutterstock_results->moods ) ) {
		$shutterstock_moods = "";
		if ( isset( $shutterstock_results->moods ) )
		{
			foreach ( $shutterstock_results->moods as $key => $value )
			{
				if ( $shutterstock_moods != "" )
				{
					$shutterstock_moods .= ', ';
				}
				$shutterstock_moods .= '<a href="' . site_url() .
					'/?stock=shutterstock&stock_type=music&moods=' . $value . '" >' . $value .
					'</a>';
			}
		}

		if ( $shutterstock_moods != '' )
		{
			$pvs_theme_content[ 'moods' ] = $shutterstock_moods;
			$pvs_theme_content[ 'flag_moods' ] = true;
		} else
		{
			$pvs_theme_content[ 'flag_moods' ] = false;
		}
	} else {
		$pvs_theme_content[ 'flag_moods' ] = false;
	}

	//Sizes
	$sizes = '';
	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		$display_files = 'block';
		$display_prints = 'none';
		$checked_files = 'checked';
		$checked_prints = '';

		if ( $pvs_global_settings["shutterstock_prints"] and $pvs_global_settings["shutterstock_show"] ==
			2 and get_query_var("shutterstock_type") != "audio" and get_query_var("shutterstock_type") !=
			"video" )
		{
			$display_files = 'none';
			$display_prints = 'block';
			$checked_files = '';
			$checked_prints = 'checked';
		}

		if ( get_query_var("shutterstock_type") != "video" and get_query_var("shutterstock_type") !=
			"audio" )
		{
			$th_dpi = '<th>DPI</th>';
		} else
		{
			$th_dpi = '';
		}

		if ( get_query_var("shutterstock_type") == "audio" )
		{
			$sizes = "<table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "filesize" ) .
				"</th></tr>";

			$sizes .= '<tr valign="top"><td>' . pvs_word_lang( "audio" ) . '</td><td>' .
				strval( pvs_price_format( @$shutterstock_results->assets->clean_audio->
				file_size / ( 1024 * 1024 ), 3 ) ) . ' Mb.' . '</td></tr>';

			$sizes .= "</table><br><br>";

		} else
		{
			if ( $pvs_global_settings["shutterstock_files"] and $pvs_global_settings["shutterstock_prints"] and
				get_query_var("shutterstock_type") != "audio" and get_query_var("shutterstock_type") != "video" )
			{
				$sizes = "<input type='radio' name='license' id='files_label' style='margin:20px 10px 10px 0px'  onClick='apanel(0);' " .
					$checked_files . "><label for='files_label' >" . pvs_word_lang( "files" ) .
					"</label><input type='radio' name='license' id='prints_label' style='margin:20px 10px 10px 20px'  onClick='apanel(1);' " .
					$checked_prints . "><label for='prints_label' >" . pvs_word_lang( "prints and products" ) .
					"</label>";
			}

			$sizes .= "<div id='prices_files' style='display:" . $display_files .
				"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "type" ) . "</th><th>" .
				pvs_word_lang( "size" ) . "</th>" . $th_dpi . "<th>" . pvs_word_lang( "filesize" ) .
				"</th></tr>";

			foreach ( $shutterstock_results->assets as $key => $value )
			{
				if ( isset( $value->display_name ) )
				{
					$photo_size = "";
					$photo_dpi = "";
					$photo_filesize = "";

					if ( isset( $value->width ) and isset( $value->height ) )
					{
						$photo_size = @$value->width . ' x ' . @$value->height . 'px';
					}

					if ( isset( $value->dpi ) and get_query_var("shutterstock_type") != "video" and get_query_var("shutterstock_type") !=
						"audio" )
					{
						$photo_dpi = '<td>' . @$value->dpi . 'dpi</td>';
					}

					if ( isset( $value->file_size ) )
					{
						$photo_filesize = strval( pvs_price_format( @$value->file_size / ( 1024 * 1024 ),
							3 ) ) . ' Mb.';
					}

					$sizes .= '<tr valign="top"><td>' . @$value->display_name . '</td><td>' .
						strtoupper( @$value->format ) . '</td><td>' . $photo_size . '</td>' . $photo_dpi .
						'<td>' . $photo_filesize . '</td></tr>';
				}
			}

			$sizes .= "</table><br>";
		}

		$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "shutterstock", @$shutterstock_results->
			id, get_query_var("shutterstock_type") ) .
			"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
			pvs_word_lang( "Buy on" ) . " Shutterstock</a></div>";

		if ( $pvs_global_settings["shutterstock_prints"] and get_query_var("shutterstock_type") !=
			"audio" and get_query_var("shutterstock_type") != "video" )
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

			$sizes .= "</table><br><a href=\"javascript:prints_stock('shutterstock'," . @$shutterstock_results->
				id . ",'" . urlencode( pvs_get_stock_affiliate_url( "shutterstock", @$shutterstock_results->
				id, get_query_var("shutterstock_type") ) ) . "','" . urlencode( @$shutterstock_results->
				assets->preview->url ) . "','" . pvs_get_stock_page_url( "shutterstock", @$shutterstock_results->
				id, @$shutterstock_results->description, get_query_var("shutterstock_type") ) . "','" .
				addslashes( @$shutterstock_results->description ) . "')\" class = 'btn btn-danger btn-lg' style='color:#ffffff;text-decoration:none;'>" .
				pvs_word_lang( "Order print" ) . "</a></div>";
		}
	}

	$pvs_theme_content[ 'sizes' ] = $sizes;
	//End. Sizes

	//Related items
	$related_items = '';
	$related_count = 0;

	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		if ( get_query_var("shutterstock_type") != "audio" )
		{
			$auth = base64_encode( $pvs_global_settings["shutterstock_id"] . ":" . $pvs_global_settings["shutterstock_secret"] );

			$url = 'https://api.shutterstock.com/v2/images/' . ( int ) get_query_var('shutterstock') .
				"/similar?per_page=" . $pvs_global_settings["related_items_quantity"];

			if ( get_query_var("shutterstock_type") == "video" )
			{
				$url = 'https://api.shutterstock.com/v2/videos/' . ( int ) get_query_var('shutterstock') .
					"/similar?per_page=" . $pvs_global_settings["related_items_quantity"];
			}

			if ( get_query_var("shutterstock_type") == "audio" )
			{
				$url = 'https://api.shutterstock.com/v2/audio/' . ( int ) get_query_var('shutterstock') .
					"/similar?per_page=" . $pvs_global_settings["related_items_quantity"];
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
				$shutterstock_related = json_decode( $data );
				//var_dump($shutterstock_related);

				if ( isset( $shutterstock_related->data ) )
				{
					foreach ( $shutterstock_related->data as $key => $value )
					{
						//Image
						if ( $value->media_type == "image" )
						{
							$preview_title = @$value->description;
							$preview_img = @$value->assets->preview->url;

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

							$flow_width = @$value->assets->preview->width;
							$flow_height = @$value->assets->preview->height;
						}

						//Video
						if ( $value->media_type == "video" )
						{
							$preview_title = @$value->description;
							$preview_img = @$value->assets->thumb_jpg->url;

							$video_width = $pvs_global_settings["video_width"];
							$video_height = round( $pvs_global_settings["video_width"] / @$value->aspect );
							$lightbox_hover = "onMouseover=\"lightboxon5('" . $value->assets->preview_mp4->
								url . "'," . $video_width . "," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
								$video_width . "," . $video_height . ",event)\"";

							$flow_width = $pvs_global_settings["width_flow"];
							if ( $value->aspect != 0 )
							{
								$flow_height = round( $pvs_global_settings["width_flow"] / @$value->aspect );
							}
						}

						//Audio
						if ( $value->media_type == "audio" )
						{
							$preview_title = @$value->title;
							$preview_img = @$value->assets->waveform->url;

							$video_width = $pvs_global_settings["video_width"];
							$video_height = round( $pvs_global_settings["video_width"] / @$value->aspect );
							$lightbox_hover = "onMouseover=\"lightboxon5('" . @$value->assets->preview_mp4->
								url . "'," . $video_width . "," . $video_height . ",event,'" . site_url() . "');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
								$video_width . "," . $video_height . ",event)\"";

							$flow_width = $pvs_global_settings["width_flow"];
							if ( @$value->aspect != 0 )
							{
								$flow_height = round( $pvs_global_settings["width_flow"] / @$value->aspect );
							}
						}

						$preview_title = "#" . @$value->id;


						$related_title = $preview_title;

						$related_id = @$value->id;

						$related_description = "";
						$related_url = pvs_get_stock_page_url( "shutterstock", @$value->
							id, @$value->description, @$value->media_type );
						$related_preview = $preview_img;
						$related_lightbox = $lightbox_hover;

						$related_width = $flow_width;
						$related_height = $flow_height;
						
						if ( @$value->id != @$shutterstock_results->id )
						{
							include( get_stylesheet_directory(). '/item_related_stock.php' );
							$related_items .= $pvs_theme_content[ 'related_content' ];
							$related_count++;
						}
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
		$preview_url = @$shutterstock_results->assets->preview->url;
		$iframe_width = @$shutterstock_results->assets->preview->width;
		$iframe_height = @$shutterstock_results->assets->preview->height;
		$default_width = @$shutterstock_results->assets->huge_jpg->width;
		$default_height = @$shutterstock_results->assets->huge_jpg->height;

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

		$stock_id = @$shutterstock_results->id;
		$stock_type = "shutterstock";

		$pvs_theme_content[ 'stock_type' ] = $stock_type;
		$pvs_theme_content[ 'stock_id' ] = $stock_id;
		$pvs_theme_content[ 'stock_url' ] = pvs_get_stock_affiliate_url( "shutterstock",
			@$shutterstock_results->id, @$shutterstock_results->media_type );
		$pvs_theme_content[ 'stock_preview' ] = $preview_url;
		$pvs_theme_content[ 'stock_site_url' ] = pvs_print_url( @$shutterstock_results->
			id, ( int )get_query_var("pvs_print_id"), @$shutterstock_results->description, $prints_preview,
			"shutterstock" );

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