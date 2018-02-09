<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $rs->row["contacts"] == 0 ) {

	if ( $rs->row["rights_managed"] == 0 ) {
		$sizebox = "";
		$sizebox_labels = "";
		$sizeboxes = array();
		if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $folder ) ) {
			$subscription_item = false;
			if ( ( $pvs_global_settings["subscription"] and
				pvs_user_subscription( pvs_get_user_login (), get_query_var('pvs_id') ) ) or $rs->row["free"] ==
				1 or $pvs_global_settings["subscription_only"] ) {
				if ( $ds->row["shipped"] != 1 ) {
					$subscription_item = true;
				}
			}

			$sql = "select id_parent,name from " . PVS_DB_PREFIX . "licenses order by priority";
			$dd->open( $sql );
			$sizebox_labels_checked = "checked";
			$sizebox_buy_checked = "checked";
			while ( ! $dd->eof ) {
				$flag_license = true;
				
				if (get_query_var('pvs_page') == 'video') {
					$sql = "select id_parent,title from " . PVS_DB_PREFIX . "video_types where license=" . $dd->row["id_parent"] . " order by priority";
				}
				if (get_query_var('pvs_page') == 'audio') {
					$sql = "select id_parent,title from " . PVS_DB_PREFIX . "audio_types where license=" . $dd->row["id_parent"] . " order by priority";
				}
				if (get_query_var('pvs_page') == 'vector') {
					$sql = "select id_parent,title from " . PVS_DB_PREFIX . "vector_types where license=" . $dd->row["id_parent"] . " order by priority";
				}
				$dr->open( $sql );
				while ( ! $dr->eof ) {
					$sql = "select id,name,url,price,shipped from " . PVS_DB_PREFIX .
						"items where price_id=" . $dr->row["id_parent"] . " and id_parent=" . ( int )get_query_var('pvs_id') .
						" order by priority";
					$ds->open( $sql );
					while ( ! $ds->eof ) {
						if ( $flag_license ) {
							$sizeboxes[$dd->row["id_parent"]] = "";
							/*$sizebox_labels .= "<input type='radio' name='license' id='license" . $dd->row["id_parent"] .
								"' value='" . $dd->row["id_parent"] .
								"' style='margin-left:20px;margin-right:10px'  onClick='apanel(" . $dd->row["id_parent"] .
								");' " . $sizebox_labels_checked . "><label for='license" . $dd->row["id_parent"] .
								"' >" . pvs_word_lang( $dd->row["name"] ) . "</label>";*/
							$sizebox_labels_checked = "";
							$flag_license = false;
						}

						$size = "";
						if ( $ds->row["shipped"] == 1 ) {
							$size = pvs_word_lang( "shipped" );
						} else {
							if ( ! $flag_storage and file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
								"/" . $folder . "/" . $ds->row["url"] ) ) {
								$size = strval( pvs_price_format( filesize( pvs_upload_dir() . pvs_server_url( $rs->
									row["server1"] ) . "/" . $folder . "/" . $ds->row["url"] ) / ( 1024 * 1024 ), 3 ) ) .
									" Mb";
							} else {//var_dump($remote_files);
								if ( isset( $remote_files[$ds->row["url"]] ) )
								{
									$size = strval( pvs_price_format( $remote_files[$ds->row["url"]] / ( 1024 * 1024 ),
										3 ) ) . " Mb";
								}
							}
						}
						$file_type_index = strripos($ds->row["url"], '.');
						$file_type = substr($ds->row["url"], $file_type_index + 1);
						$bt = "<input type='radio' class='radio-button' id='cart-" . $ds->row["id"] ."' name='cart' value='" . $ds->row["id"] .
							"' " . $sizebox_buy_checked . ">";
						$sizebox_buy_checked = "";

						if ( $subscription_item and $ds->row["shipped"] == 1 ) {

						} else {
							if ( $ds->row["price"] != 0 )
							{
								$price_text = pvs_currency( 1 ) . pvs_price_format( $ds->row["price"], 2, true ) .
									" " . pvs_currency( 2 );
							} else
							{
								$price_text = pvs_word_lang( "free download" );
							}

							$content_price = "<span class='file-price'>" . $price_text . "</span>";

							if ( $rs->row["free"] == 1 )
							{
								$content_price = "";
							}

							$sizeboxes[$dd->row["id_parent"]] .= "<div class='select'>" . $bt .
							                                     "<label for=\"cart-" . $ds->row["id"] . "\">".
								                                     "<span class=\"selectOption\">".
									                                     "<span class=\"file-type\">" . $file_type . "</span>".
									                                     "<span class=\"file-option\">" . pvs_word_lang( $ds->row["name"] ) . "</span>".
									                                     "<span class=\"file-size\">" . $size . "</span>".
							                                         $content_price .
								                                     "</span>".
							                                     "</label></div>";
						}

						$ds->movenext();
					}
					$dr->movenext();
				}
				$dd->movenext();
			}

			$sizebox_display = "";
			foreach ( $sizeboxes as $key => $value ) {
				/*if ( $value != "" ) {
					$word_buy = pvs_word_lang( "buy" );
					if ( $subscription_item )
					{
						$word_buy = pvs_word_lang( "download" );
					}

					$text_price = "<th>" . pvs_word_lang( "price" ) . "</th>";
					if ( $rs->row["free"] == 1 )
					{
						$text_price = "";
					}

				}*/
				$sizebox .= "<form style='" . $sizebox_display . "' id='p" . $key . "'>" . $value;

				if ( $subscription_item ){

					$word_cart = pvs_word_lang( "download" );

					if ( $rs->row["free"] == 1 ) {
						$word_cart = pvs_word_lang( "free download" );
					}

					$sizebox .= "<div class=\"story-buttons\"><button id='item_button_cart' class='add_to_cart' type='button' onclick=\"add_download('" . get_query_var('pvs_page') . "'," .
					            $rs->row["id"] . "," . $rs->row["server1"] . ")\">" . $word_cart . "</button>";
				} else {
					$sizebox .= "<div class=\"story-buttons\"><button id='item_button_cart' class='send-button add_to_cart btn btn-danger btn-lg' type='button' onclick=\"add_cart2( event, 0," . $key . " )\">" .
					            pvs_word_lang( "add to cart" ) . "</button>";
				}
				if ( $pvs_global_settings[ 'lightboxes' ] ) {
					$sizebox .= '<a class="send-button" href="' . $pvs_theme_content[ 'add_to_favorite_link' ] . '"><span>' . pvs_word_lang( "ADD TO LIGHTBOX" ) . '</span></a>';
				}
				$sizebox .= "</div></form>";
				$sizebox_display = "display:none";
			}


		}
		$pvs_theme_content[ 'sizes' ] = $sizebox;
		//End. Show prices
	} else
	{
		$sizebox = "<div style='margin-bottom:6px;margin-top:15px' class='price_license'><a href='" .
			site_url() . "/license/'>" . pvs_word_lang( "license" ) .
			":</a></b> <input name='license' id='license1' value='1' style='margin-left:20px;margin-right:10px' onclick='apanel(1);' checked type='radio'><label for='license1'>" .
			pvs_word_lang( "rights managed" ) .
			"</label></div><div name='p1' id='p1' style='display:inline'><table class='table_cart' border='0' cellpadding='0' cellspacing='0'><tbody><tr><th>" .
			pvs_word_lang( "file" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th></tr>";

		$file_name = "";
		$sql = "select url from " . PVS_DB_PREFIX . "items where  id_parent=" . ( int )get_query_var('pvs_id') .
			" and price_id=" . $rs->row["rights_managed"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$file_name = $ds->row["url"];
		}

		if ( ! $flag_storage )
		{
			if ( $file_name != "" )
			{
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
					$folder . "/" . $file_name ) )
				{
					$video_filesize = filesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
						"/" . $folder . "/" . $file_name );
				}
			}
		} else
		{
			if ( isset( $remote_files[$file_name] ) )
			{
				$video_filesize = $remote_files[$file_name];
			} else
			{
				$video_filesize = 0;
			}
		}

		$sizebox .= "<tr><td>" . strtoupper( pvs_get_file_info( $file_name, "extention" ) ) .
			"</td><td>" . strval( pvs_price_format( $video_filesize / ( 1024 * 1024 ), 3 ) ) .
			" Mb</td></tr>";

		$sizebox .= "</tbody></table><div style='margin-top:15px'><input class='add_to_cart' type='button' value='" .
			pvs_word_lang( "calculate price" ) . "' onClick='rights_managed(" . $rs->row["id"] .
			")'></div></div>";

		$pvs_theme_content[ 'sizes' ] = $sizebox;
	}
} else {
	$sizebox = "<div style='margin-bottom:6px;margin-top:15px' class='price_license'><a href='" .
		site_url() . "/license/'>" . pvs_word_lang( "license" ) .
		":</a></b> <input name='license' id='license1' value='1' style='margin-left:20px;margin-right:10px' onclick='apanel(1);' checked type='radio'><label for='license1'>" .
		pvs_word_lang( "royalty free" ) .
		"</label></div><div name='p1' id='p1' style='display:inline'><table class='table_cart' border='0' cellpadding='0' cellspacing='0'><tbody><tr><th>" .
		pvs_word_lang( "file" ) . "</th><th>" . pvs_word_lang( "size" ) . "</th></tr>";

	$file_name = "";
	$sql = "select url from " . PVS_DB_PREFIX . "items where  id_parent=" . ( int )get_query_var('pvs_id') .
		" and shipped<>1";
	$ds->open( $sql );
	if ( ! $ds->eof )
	{
		$file_name = $ds->row["url"];
	}

	if ( ! $flag_storage )
	{
		if ( $file_name != "" )
		{
			if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
				$folder . "/" . $file_name ) )
			{
				$video_filesize = filesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
					"/" . $folder . "/" . $file_name );
			}
		}
	} else
	{
		if ( isset( $remote_files[$file_name] ) )
		{
			$video_filesize = $remote_files[$file_name];
		} else
		{
			$video_filesize = 0;
		}
	}

	$sizebox .= "<tr><td>" . strtoupper( pvs_get_file_info( $file_name, "extention" ) ) .
		"</td><td>" . strval( pvs_price_format( $video_filesize / ( 1024 * 1024 ), 3 ) ) .
		" Mb</td></tr>";

	$sizebox .= "</tbody></table><div style='margin-top:15px'><input class='add_to_cart' type='button' value='" .
		pvs_word_lang( "Contact us to get the price" ) . "' onClick=\"location.href='" .
		site_url() . "/contacts/?file_id=" . $rs->row["id"] . "'\"></div></div>";

	$pvs_theme_content[ 'sizes' ] = $sizebox;
}
?>