<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "content_js_stock.php" );

if ( isset( $rf123_results ) ) {
	//Show only istockphoto syntax
	foreach ( $mstocks as $key => $value ) {
		if ( $key == 'rf123' )
		{
			$pvs_theme_content[ $key ] = true;
		} else
		{
			$pvs_theme_content[ $key ] = false;
		}
	}

	//var_dump($rf123_results);

	$pvs_theme_content[ 'id' ] = @$rf123_results->{"@attributes"}->id;

	$preview = 'http://images.assetsdelivery.com/compings/' . @$rf123_results->
		contributor->{"@attributes"}->id . '/' . @$rf123_results->{"@attributes"}->
		folder . '/' . @$rf123_results->{"@attributes"}->filename . '.jpg';

	$pvs_theme_content[ 'image' ] = "<img src='" . $preview . "' />";
	$pvs_theme_content[ 'downloadsample' ] = $preview;
	$pvs_theme_content[ 'share_image' ] = urlencode( $preview );

	$publication_type = "all";

	if ( @$rf123_results->{"@attributes"}->mediatype == 'Photography' ) {
		$publication_type = 0;
	}
	if ( @$rf123_results->{"@attributes"}->mediatype == 'Illustration' ) {
		$publication_type = 1;
	}
	if ( @$rf123_results->{"@attributes"}->mediatype == 'Editorial' ) {
		$publication_type = 4;
	}

	$pvs_theme_content[ 'title' ] = @$rf123_results->description;
	$pvs_theme_content[ 'keywords' ] = @$rf123_keywords_links;
	$pvs_theme_content[ 'keywords_lite' ] = @$rf123_keywords_links;
	$pvs_theme_content[ 'description' ] = "";
	$pvs_theme_content[ 'category' ] = @$rf123_categories_links;
	$pvs_theme_content[ 'author' ] = '<b>' . pvs_word_lang( "Contributor" ) .
		':</b> <a href="' . site_url() . '/?stock=rf123&author=' . @$rf123_results->
		contributor->{"@attributes"}->id . '&stock_type=' . $publication_type . '" >' .
		@$rf123_results->contributor->{"@attributes"}->id . '</a>';
	$pvs_theme_content[ 'published' ] = @$rf123_results->published;
	$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
		".js'></script>";
	$pvs_theme_content[ 'share_title' ] = urlencode(@$rf123_results->description );

	if ( (int)get_query_var('pvs_print_id') > 0 ) {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_print_url( @$rf123_results->{
			"@attributes"}->id, ( int )get_query_var("pvs_print_id"), @$rf123_results->description,
			$prints_preview, "rf123" ) );
	} else {
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() .
			pvs_get_stock_page_url( "123rf", @$rf123_results->{"@attributes"}->id, @$rf123_results->
			description, "photo" ) );

	}

	$pvs_theme_content[ 'share_description' ] = urlencode(@$rf123_results->description );

	//Type
	$pvs_theme_content[ 'type' ] = '<a href="' . site_url() .
		'/?stock=rf123&stock_type=' . $publication_type . '" >' . pvs_word_lang
		( @$rf123_results->{"@attributes"}->mediatype ) . '</a>';

	//Model release
	if ( isset( $rf123_results->release->{"@attributes"}->model ) ) {
		$pvs_theme_content[ 'flag_model' ] = true;

		if ( @$rf123_results->release->{"@attributes"}->model )
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
	if ( isset( $rf123_results->release->{"@attributes"}->property ) ) {
		$pvs_theme_content[ 'flag_property' ] = true;

		if ( @$rf123_results->release->{"@attributes"}->property )
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
	if ( @$rf123_results->{"@attributes"}->mediatype == 'Editorial' ) {
		$pvs_theme_content[ 'flag_editorial' ] = false;
		$pvs_theme_content[ 'editorial' ] = pvs_word_lang( "files for editorial use only" );
	} else {
		$pvs_theme_content[ 'flag_editorial' ] = false;
	}

	//Published
	$pvs_theme_content[ 'flag_published' ] = false;

	//Category
	$pvs_theme_content[ 'flag_category' ] = false;

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

		if ( $pvs_global_settings["rf123_prints"] and $pvs_global_settings["rf123_show"] ==
			2 )
		{
			$display_files = 'none';
			$display_prints = 'block';
			$checked_files = '';
			$checked_prints = 'checked';
		}

		if ( $pvs_global_settings["rf123_files"] and $pvs_global_settings["rf123_prints"] )
		{
			$sizes .= "<input type='radio' name='license' id='files_label' style='margin:20px 10px 10px 0px'  onClick='apanel(0);' " .
				$checked_files . "><label for='files_label' >" . pvs_word_lang( "files" ) .
				"</label><input type='radio' name='license' id='prints_label' style='margin:20px 10px 10px 20px'  onClick='apanel(1);' " .
				$checked_prints . "><label for='prints_label' >" . pvs_word_lang( "prints and products" ) .
				"</label>";
		}

		$sizes .= "<div id='prices_files' style='display:" . $display_files .
			"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
			pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "type" ) . "</th><th>" .
			pvs_word_lang( "size" ) . "</th><th>" . pvs_word_lang( "filesize" ) .
			"</th></tr>";

		foreach ( $rf123_results->sizes->size as $key => $value )
		{
			$photo_size = '';
			$photo_filefile = '';

			if ( @$value->{"@attributes"}->width > 0 and @$value->{"@attributes"}->height >
				0 )
			{
				$photo_size = @$value->{"@attributes"}->width . ' x ' . @$value->{"@attributes"
					}->height . ' px';
			} else
			{
				$photo_size = @$value->{"@attributes"}->width;
			}

			if ( @$value->{"@attributes"}->rawSize > 0 )
			{
				$photo_filesize = @$value->{"@attributes"}->rawSize . ' Mb.';
			} else
			{
				$photo_filesize = @$value->{"@attributes"}->rawSize;
			}

			$sizes .= '<tr valign="top"><td>' . strtoupper( @$value->{"@attributes"}->label ) .
				'</td><td>' . @$value->{"@attributes"}->format . '</td><td>' . $photo_size .
				'</td><td>' . $photo_filesize . '</td></tr>';
		}

		$sizes .= "</table><br>";

		$sizes .= "<a href='" . pvs_get_stock_affiliate_url( "123rf", @$rf123_results->{
			"@attributes"}->id, get_query_var('rf123_type') ) .
			"' target='blank' class = 'btn btn-primary btn-lg' style='color:#ffffff;text-decoration:none'>" .
			pvs_word_lang( "Buy on" ) . " 123RF</a></div>";

		if ( $pvs_global_settings["rf123_prints"] )
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

			$sizes .= "</table><br><a href=\"javascript:prints_stock('rf123'," . @$rf123_results->{
				"@attributes"}->id . ",'" . urlencode( pvs_get_stock_affiliate_url( "123rf", @$rf123_results->{
				"@attributes"}->id, get_query_var('rf123_type') ) ) . "','" . urlencode( @$preview ) .
				"','" . pvs_get_stock_page_url( "123rf", @$rf123_results->{"@attributes"}->id, @
				$rf123_results->description, "photo" ) . "','" . addslashes( @$rf123_results->
				description ) . "')\" class = 'btn btn-danger btn-lg' style='color:#ffffff;text-decoration:none;'>" .
				pvs_word_lang( "Order print" ) . "</a></div>";
		}
	}

	$pvs_theme_content[ 'sizes' ] = $sizes;
	//End. Sizes

	//Related items
	$related_items = '';
	$related_count = 0;
	if ( (int)get_query_var('pvs_print_id') == 0 ) {
		$url = "http://api.123rf.com/rest/?method=123rf.images.search&apikey=" . $pvs_global_settings["rf123_id"] .
			"&keyword=" . urlencode( $rf123_keywords_similar ) . "&page=1&perpage=" . $pvs_global_settings["related_items_quantity"];
		//echo($url);

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

		$data = curl_exec( $ch );
		if ( ! curl_errno( $ch ) )
		{
			$rf123_related = json_decode( json_encode( simplexml_load_string( $data ) ) );
			//var_dump($rf123_related);

			if ( isset( $rf123_related->images->image ) )
			{
				foreach ( $rf123_related->images->image as $key => $value )
				{
					if ( @$value->{"@attributes"}->id != '' and @$value->{"@attributes"}->id != ( int )
						get_query_var('rf123') )
					{
						$preview_title = @$value->{"@attributes"}->description;
						$preview_img = 'http://images.assetsdelivery.com/compings/' . @$value->{
							"@attributes"}->contributorid . '/' . @$value->{"@attributes"}->folder . '/' . @
							$value->{"@attributes"}->filename . '.jpg';

						$size = GetImageSize( $preview_img );

						$lightbox_width = @$size[0];
						$lightbox_height = @$size[1];
						$lightbox_url = $preview_img;

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
							( "'", "", str_replace( "\n", "", str_replace( "\r", "", @$value->{
							"@attributes"}->description ) ) ) ) . "','');\" onMouseout=\"lightboxoff();\" onMousemove=\"lightboxmove(" .
							$lightbox_width . "," . $lightbox_height . ",event)\"";

						$flow_width = $lightbox_width;
						$flow_height = $lightbox_height;

						$preview_title = "#" . @$value->{"@attributes"}->id;

						$related_id = @$value->{"@attributes"}->id;
						$related_title = $preview_title;
						$related_description = "";
						$related_url = pvs_get_stock_page_url( "123rf", @$value->{
							"@attributes"}->id, @$value->{"@attributes"}->description, "photo" );
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
		$preview_url = $preview;
		$sz = getimagesize( $preview_url );
		$iframe_width = $sz[0];
		$iframe_height = $sz[1];
		$default_width = $sz[0] * 20;
		$default_height = $sz[0] * 20;

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

		$stock_id = @$rf123_results->{"@attributes"}->id;
		$stock_type = "123rf";

		$pvs_theme_content[ 'stock_type' ] = $stock_type;
		$pvs_theme_content[ 'stock_id' ] = $stock_id;
		$pvs_theme_content[ 'stock_url' ] = pvs_get_stock_affiliate_url( "123rf",
			@$rf123_results->{"@attributes"}->id, "photo" );
		$pvs_theme_content[ 'stock_preview' ] = $preview_url;
		$pvs_theme_content[ 'stock_site_url' ] = pvs_print_url( @$rf123_results->{
			"@attributes"}->id, ( int )get_query_var("pvs_print_id"), @$rf123_results->description,
			$prints_preview, "rf123" );

		$id_parent = get_query_var('rf123');
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