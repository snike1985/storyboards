<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

include ( "content_js_items.php" );

if ( pvs_check_password_publication( get_query_var('pvs_id') ) ) {
	$check_passsword_url = 'item-password';
	require_once( get_stylesheet_directory(). '/item_protected.php' );
} else {
	$sql = "update " . PVS_DB_PREFIX . "media set viewed=viewed+1 where id_parent=" . ( int )get_query_var('pvs_id');
	$db->execute( $sql );
	
	$sql = "select id,title,data,published,description,featured,keywords,author,viewed,userid,watermark,free,downloaded,rating,server1,google_x,google_y,url,editorial,rights_managed,vote_like,vote_dislike,contacts,exclusive,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps,content_type from " .
		PVS_DB_PREFIX . "media where published=1 and id=" . ( int )get_query_var('pvs_id');
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( ! file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
			$rs->row["id"] ) ) {
			mkdir( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] );
		}
	
		$translate_results = pvs_translate_publication( $rs->row["id"], $rs->row["title"],
			$rs->row["description"], $rs->row["keywords"] );
	
		$photo_formats = array();
		$sql = "select id,photo_type from " . PVS_DB_PREFIX .
			"photos_formats where enabled=1 order by id";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
			$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
			$dr->movenext();
		}
	
		$photo_files = array();
		foreach ( $photo_formats as $key => $value ) {
			if ( $rs->row["url_" . $value] != "" )
			{
				$photo_files[$value] = $rs->row["url_" . $value];
				$image_width[$value] = 0;
				$image_height[$value] = 0;
				$image_filesize[$value] = 0;
			}
		}
	
		$flag_storage = false;
		$folder = $rs->row["id"];
		$remote_thumb_width = 0;
		$remote_thumb_height = 0;
	
		if ( pvs_is_remote_storage() ) {
			$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
				PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["id"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				$ext = strtolower( pvs_get_file_info( $ds->row["filename1"], "extention" ) );
				if ( $ext == "jpeg" )
				{
					$ext = "jpg";
				}
				if ( $ext == "tif" )
				{
					$ext = "tiff";
				}
	
				if ( $ds->row["item_id"] != 0 )
				{
					$image_width[$ext] = $ds->row["width"];
					$image_height[$ext] = $ds->row["height"];
					$image_filesize[$ext] = $ds->row["filesize"];
				}
				if ( preg_match( "/thumb2/", $ds->row["filename1"] ) )
				{
					$remote_thumb_width = $ds->row["width"];
					$remote_thumb_height = $ds->row["height"];
				}
				$flag_storage = true;
				$ds->movenext();
			}
		}
	
		if ( ! $flag_storage ) {
			foreach ( $photo_files as $key => $value )
			{
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
					$folder . "/" . $value ) )
				{
					$size = @getimagesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
						"/" . $folder . "/" . $value );
					$image_width[$key] = ( int )$size[0];
					$image_height[$key] = ( int )$size[1];
					$image_filesize[$key] = filesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
						"/" . $folder . "/" . $value );
				}
			}
		}
	
		$default_width = 0;
		$default_height = 0;
		$default_filesize = 0;
	
		foreach ( $photo_files as $key => $value ) {
			$pvs_theme_content[ 'photo_width' ] = $image_width[$key];
			$pvs_theme_content[ 'photo_height' ] = $image_height[$key];
			$photo_size = strval( pvs_price_format( $image_filesize[$key] / ( 1024 * 1024 ),
				3 ) ) . " Mb.";
			$pvs_theme_content[ 'photo_size' ] = $photo_size;
	
			if ( $image_width[$key] >= $image_height[$key] )
			{
				if ( $image_width[$key] > $default_width or $default_width == 0 )
				{
					$default_width = $image_width[$key];
					$default_height = $image_height[$key];
					$default_filesize = $image_filesize[$key];
				}
			} else
			{
				if ( $image_height[$key] < $default_height or $default_height == 0 )
				{
					$default_width = $image_width[$key];
					$default_height = $image_height[$key];
					$default_filesize = $image_filesize[$key];
				}
			}
	
			foreach ( $photo_files as $key => $value )
			{
				if ( $key == "raw" )
				{
					$image_width[$key] = $default_width;
					$image_height[$key] = $default_height;
				}
			}
		}
	
		$kk = 0;
		$fl = false;
	
		//Photo previews
		$preview = pvs_show_preview( $rs->row["id"], "photo", 2, 0, $rs->row["server1"],
			$rs->row["id"] );
	
		$preview_url = pvs_show_preview( $rs->row["id"], "photo", 2, 1, $rs->row["server1"],
			$rs->row["id"] );
	
		$preview_url2 = str_replace(pvs_upload_dir('baseurl'), pvs_upload_dir(), pvs_show_preview( $rs->row["id"], "photo", 2, 1, $rs->row["server1"], $rs->row["id"], false ));
	
		$pvs_theme_content[ 'share_title' ] = urlencode( $translate_results["title"] );
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_item_url( $rs->row["id"], $rs->row["url"] ) );
		$pvs_theme_content[ 'share_image' ] = urlencode( site_url() . $preview_url );
		$pvs_theme_content[ 'share_description' ] = urlencode( $translate_results["description"] );
	
		if ( ! $pvs_global_settings["zoomer"] or preg_match( "/icon_photo/", $preview_url ) ) {
			if ( ! preg_match( "/icon_photo/", $preview_url ) )
			{
				$pvs_theme_content[ 'image' ] = "<img src='" . $preview_url . "' class='img-responsive'>";
			} else
			{
				$pvs_theme_content[ 'image' ] = "";
			}
		} else {
			if ( ! $flag_storage )
			{
				$sz = getimagesize( $preview_url2 );
				$iframe_width = $sz[0];
				$iframe_height = $sz[1];
			} else
			{
				$iframe_width = $remote_thumb_width;
				$iframe_height = $remote_thumb_height;
			}
	
			$pvs_theme_content[ 'image' ] = "<iframe width=" . $iframe_width .
				" height=" . $iframe_height . " src='" . site_url() .
				"/content-photo-preview/?id=" . get_query_var('pvs_id') . "&width=" . $iframe_width .
				"&height=" . $iframe_height .
				"' frameborder='no' scrolling='no' class='hidden-xs hidden-sm hidden-phone hidden-md-down'></iframe><img src='" .
				$preview_url . "' class='img-responsive hidden-md hidden-lg hidden-desktop hidden-tablet hidden-md-up'>";
		}
	
		//Show download sample
		$pvs_theme_content[ 'downloadsample' ] = $preview_url;
		//$pvs_theme_content[ 'downloadsample' ] = site_url()."/sample/?id=".$rs->row["id"];
	
		$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
			".js'></script>";
	
		$pvs_theme_content[ 'flag_downloadsample' ] = 0;
		if ( $pvs_global_settings["download_sample"] and ! preg_match( "/icon_photo/", $preview_url ) ) {
			$pvs_theme_content[ 'flag_downloadsample' ] = 1;
		}
	
		//Texts
		$pvs_theme_content[ 'title' ] = $translate_results["title"];
		$pvs_theme_content[ 'url' ] = site_url() . $rs->row["url"];
		$pvs_theme_content[ 'published' ] = date( date_format, $rs->row["data"] );
		$pvs_theme_content[ 'license' ] = site_url() . "/license/";
	
		//Show category
		$pvs_theme_content[ 'category' ] = pvs_show_category( $rs->row["id"] );
	
		$pvs_theme_content[ 'flag_editorial' ] = $rs->row["editorial"];
		$pvs_theme_content[ 'flag_exclusive' ] = $rs->row["exclusive"];
	
		//Show rating
		pvs_show_rating( get_query_var('pvs_id'), $rs->row["rating"] );
	
		$pvs_theme_content[ 'downloads' ] = $rs->row["downloaded"];
		$pvs_theme_content[ 'viewed' ] = $rs->row["viewed"];
		$pvs_theme_content[ 'description' ] = str_replace( "\r", "<br>", $translate_results["description"] );
	
		$pvs_theme_content[ 'like' ] = ( int )$rs->row["vote_like"];
		$pvs_theme_content[ 'dislike' ] = ( int )$rs->row["vote_dislike"];
	
		//Show next/previous navigation
		pvs_show_navigation( get_query_var('pvs_id'), "photos" );
	
		//Show author
		pvs_show_author( $rs->row["author"] );
	
		//Show community tools
		pvs_show_community();
	
		//Show google map
		pvs_show_google_map( $rs->row["google_x"], $rs->row["google_y"] );
	
		//Show EXIF info
		pvs_show_exif( get_query_var('pvs_id') );
		
		//Show color
		pvs_show_colors( get_query_var('pvs_id'), "photo" );
	
		//Show keywords
		$keywords = array();
		$titles = explode( " ", pvs_remove_words( $translate_results["title"] ) );
		pvs_show_keywords( get_query_var('pvs_id'), "photo" );
	
		//Show tell a friend
		$pvs_theme_content[ 'tell_a_friend_link' ] = site_url() . "/tell-a-friend/?id_parent=" . ( int )get_query_var('pvs_id');
	
		//Show favorite buttons
		pvs_show_favorite( get_query_var('pvs_id') );
	
		if ( is_user_logged_in() ) {
			$pvs_theme_content[ 'mail_link' ] = site_url() . "/messages-new/?user=" . $rs->row["author"];
		} else {
			$pvs_theme_content[ 'mail_link' ] = site_url() . "/login/";
		}
	
		//Show related items
		pvs_show_related_items( get_query_var('pvs_id'), "check" );
	
		$sql = "select id_parent,itemid from " . PVS_DB_PREFIX . "reviews where itemid=" . ( int )
			get_query_var('pvs_id');
		$dr->open( $sql );
		$pvs_theme_content[ 'reviews' ] = pvs_word_lang( "reviews" ) . "(" . strval( $dr->rc ) . ")";
		
		$pvs_theme_content[ 'id' ] = get_query_var('pvs_id');
	
		//Content type
		$pvs_theme_content[ 'content_type' ] = "<a href='" . site_url() . "/?content_type=" . $rs->row["content_type"] . "'>" . $rs->row["content_type"] . "</a>";
	
		//Prints
		$prints_label = "";
		$prints_content = "";
	
		if ( $pvs_global_settings["prints"] ) {
			$print_buy_checked = "checked";
			$prints_display = "none";
			if ( $pvs_global_settings["printsonly"] )
			{
				$prints_display = "block";
			}
	
			$prints_label = "<input type='radio' name='license' id='prints_label' style='margin-left:20px;margin-right:10px'  onClick='apanel(0);'><label for='prints_label' >" .
				pvs_word_lang( "prints and products" ) . "</label>";
	
			$prints_content .= "<div name='p0' id='p0' style='display:" . $prints_display .
				"'><table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th>" .
				pvs_word_lang( "title" ) . "</th><th>" . pvs_word_lang( "price" ) . "</th><th>" .
				pvs_word_lang( "buy" ) . "</th></tr>";
	
			$sql = "select id,title from " . PVS_DB_PREFIX .
				"prints_categories where active=1 order by priority";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$prints_content .= "<tr><td colspan='3'><b>" . pvs_word_lang( $dd->row["title"] ) .
					"</b></th></td>";
	
				$sql = "select id_parent,title,price,priority,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
					PVS_DB_PREFIX . "prints where photo=1 and category=" . $dd->row["id"] .
					" order by priority";
				$dn->open( $sql );
				while ( ! $dn->eof )
				{
					$sql = "select id_parent,title,price,printsid from " . PVS_DB_PREFIX .
						"prints_items where itemid=" . ( int )get_query_var('pvs_id') . " and printsid=" . $dn->row["id_parent"] .
						" and (in_stock =- 1 or in_stock>0) order by priority";
					$dr->open( $sql );
					while ( ! $dr->eof )
					{
						$prints_preview = "";
						if ( file_exists( pvs_upload_dir() .
							"/content/prints/product" . $dr->row["printsid"] . "_1_big.jpg" ) or file_exists
							( pvs_upload_dir() . "/content/prints/product" . $dr->row["printsid"] .
							"_2_big.jpg" ) or file_exists( pvs_upload_dir() .
							"/content/prints/product" . $dr->row["printsid"] . "_3_big.jpg" ) )
						{
							$prints_preview = "<a href='javascript:show_prints_preview(" . $dr->row["printsid"] .
								");'>";
						}
	
						$price = pvs_define_prints_price( $dr->row["price"], $dn->row["option1"], $dn->
							row["option1_value"], $dn->row["option2"], $dn->row["option2_value"], $dn->row["option3"],
							$dn->row["option3_value"], $dn->row["option4"], $dn->row["option4_value"], $dn->
							row["option5"], $dn->row["option5_value"], $dn->row["option6"], $dn->row["option6_value"],
							$dn->row["option7"], $dn->row["option7_value"], $dn->row["option8"], $dn->row["option8_value"],
							$dn->row["option9"], $dn->row["option9_value"], $dn->row["option10"], $dn->row["option10_value"] );
	
						$prints_content .= "<tr class='tr_cart' id='tr_cart" . $dr->row["id_parent"] .
							"'><td width='60%' onClick='xprint(" . $dr->row["id_parent"] . ");'>" . $prints_preview .
							pvs_word_lang( $dr->row["title"] ) . "</td><td onClick='xprint(" . $dr->row["id_parent"] .
							");' ><span class='price'>" . pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) .
							" " . pvs_currency( 2 ) . "</span></td><td onClick='xprint(" . $dr->row["id_parent"] .
							");'><input type='radio'  id='cartprint' name='cartprint' value='-" . $dr->row["id_parent"] .
							"' " . $print_buy_checked . "></td></tr>";
	
						$print_buy_checked = "";
	
						$dr->movenext();
					}
	
					$dn->movenext();
				}
				$dd->movenext();
			}
	
			$prints_content .= "</table><input class='add_to_cart' type='button' onclick=\"add_cart(1)\" value='" .
				pvs_word_lang( "add to cart" ) . "'></div>";
		}
		//End Prints
	
		$photo_dpi = ( int )$pvs_global_settings["resolution_dpi"];
		if ( $photo_dpi <= 0 ) {
			$photo_dpi = 72;
		}
		$size_photo = "px";
	
		if ( $rs->row["contacts"] == 0 ) {
			//Show prices and prints
			if ( $rs->row["rights_managed"] == 0 )
			{
				$sizebox = "";
	
				if ( ( $pvs_global_settings["subscription"] and
					pvs_user_subscription( pvs_get_user_login (), get_query_var('pvs_id') ) ) or $rs->row["free"] ==
					1 or $pvs_global_settings["subscription_only"] )
				{
					$subscription_item = true;
				} else
				{
					$subscription_item = false;
				}
	
				$sizebox_labels = "";
				$sizeboxes = array();
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
					$folder ) )
				{
					$sql = "select id_parent,name from " . PVS_DB_PREFIX .
						"licenses order by priority";
					$dd->open( $sql );
					$sizebox_labels_checked = "checked";
					$sizebox_buy_checked = "";
					$ncount = 0;
					while ( ! $dd->eof )
					{
						$flag_license = true;
	
						$sql = "select id_parent,title,size,jpg,png,gif,raw,tiff,eps from " .
							PVS_DB_PREFIX . "sizes where license=" . $dd->row["id_parent"] .
							" order by priority";
						$dr->open( $sql );
	
						while ( ! $dr->eof )
						{
							$sql = "select id,name,url,price from " . PVS_DB_PREFIX .
								"items where price_id=" . $dr->row["id_parent"] . " and id_parent=" . get_query_var('pvs_id') .
								" order by priority";
							$ds->open( $sql );
							while ( ! $ds->eof )
							{
								if ( $flag_license )
								{
									$sizeboxes[$dd->row["id_parent"]] = "";
									$sizebox_labels .= "<input type='radio' name='license' id='license" . $dd->row["id_parent"] .
										"' value='" . $dd->row["id_parent"] .
										"' style='margin-left:20px;margin-right:10px'  onClick='apanel(" . $dd->row["id_parent"] .
										");' " . $sizebox_labels_checked . "><label for='license" . $dd->row["id_parent"] .
										"' >" . pvs_word_lang( $dd->row["name"] ) . "</label>";
									$sizebox_labels_checked = "";
									$flag_license = false;
								}
	
								$photo_width = $default_width;
								$photo_height = $default_height;
								$photo_filesize = 0;
								$photo_nojpg = 0;
								foreach ( $photo_files as $key => $value )
								{
									if ( $dr->row[$key] == 1 )
									{
										if ( $key != "jpg" and $key != "gif" and $key != "png" )
										{
											$photo_nojpg++;
										}
	
										if ( $image_width[$key] >= $image_height[$key] )
										{
											if ( ( $image_width[$key] < $photo_width or $photo_width == 0 ) and $image_width[$key] !=
												0 )
											{
												$photo_width = $image_width[$key];
												$photo_height = $image_height[$key];
												$photo_filesize = $image_filesize[$key];
											}
										} else
										{
											if ( ( $image_height[$key] < $photo_height or $photo_height == 0 ) and $image_height[$key] !=
												0 )
											{
												$photo_width = $image_width[$key];
												$photo_height = $image_height[$key];
												$photo_filesize = $image_filesize[$key];
											}
										}
									}
								}
	
								if ( $photo_width != 0 and $photo_height != 0 )
								{
									$rw = $photo_width;
									$rh = $photo_height;
	
									if ( $dr->row["size"] != 0 )
									{
										if ( $rw > $rh )
										{
											$rw = $dr->row["size"];
											if ( $rw != 0 )
											{
												$rh = round( $photo_height * $rw / $photo_width );
											}
										} else
										{
											$rh = $dr->row["size"];
											if ( $rh != 0 )
											{
												$rw = round( $photo_width * $rh / $photo_height );
											}
										}
										$dpi = $photo_dpi;
									} else
									{
										$dpi = $photo_dpi;
									}
								}
	
								if ( $size_photo == "cm" )
								{
									$rw = pvs_price_format( $rw * 2.54 / $dpi, 1 );
									$rh = pvs_price_format( $rh * 2.54 / $dpi, 1 );
								}
	
								$subscription_link = "";
	
								if ( $ncount == 0 )
								{
									$sizebox_buy_checked = "checked";
								} else
								{
									$sizebox_buy_checked = "";
								}
	
								$bt = "<input type='radio'  id='cart' name='cart' value='" . $ds->row["id"] .
									"' " . $sizebox_buy_checked . ">";
	
								$flag_format = false;
								foreach ( $photo_formats as $key => $value )
								{
									if ( $rs->row["url_" . $value] != "" and $dr->row[$value] == 1 )
									{
										$flag_format = true;
									}
								}
	
								if ( ( ( ( $photo_width >= $photo_height and $dr->row["size"] <= $photo_width ) or
									( $photo_width < $photo_height and $dr->row["size"] <= $photo_height ) ) or $photo_nojpg >
									0 ) and $flag_format )
								{
									if ( $ds->row["price"] != 0 )
									{
										$price_text = pvs_currency( 1 ) . pvs_price_format( $ds->row["price"], 2, true ) .
											" " . pvs_currency( 2 );
									} else
									{
										$price_text = pvs_word_lang( "free download" );
									}
	
									$content_price = "<td nowrap onClick='xcart(" . $ds->row["id"] .
										");'><span class='price'>" . $price_text . "</span></td>";
	
									if ( $rs->row["free"] == 1 )
									{
										$content_price = "";
									}
	
									$inches_string = pvs_price_format( $rw / $dpi, 1 ) . "&quot;&nbsp;x&nbsp;" .
										pvs_price_format( $rh / $dpi, 1 ) . "&quot;&nbsp;@&nbsp;" . $dpi . "&nbsp;dpi";
	
									//$inches_string=pvs_price_format($rw*2.54/$dpi,1)."cm&nbsp;x&nbsp;".pvs_price_format($rh*2.54/$dpi,1)."cm&nbsp;@&nbsp;".$dpi."&nbsp;dpi";
	
									$formats = "";
									foreach ( $photo_formats as $key => $value )
									{
										if ( $dr->row[$value] == 1 and $rs->row["url_" . $value] != "" )
										{
											if ( $formats != "" )
											{
												$formats .= ", ";
											}
											$formats .= strtoupper( $value );
										}
									}
	
									$sizeboxes[$dd->row["id_parent"]] .= "<tr class='tr_cart' id='tr_cart" . $ds->
										row["id"] . "'><td onClick='xcart(" . $ds->row["id"] . ");'>" . pvs_word_lang( $ds->
										row["name"] ) . $subscription_link . "</td><td onClick='xcart(" . $ds->row["id"] .
										");' class='hidden-xs hidden-sm'>" . $formats . "</td><td onClick='xcart(" . $ds->
										row["id"] . ");' class='hidden-xs hidden-sm'><div class='item_pixels'>" . $rw .
										"&nbsp;x&nbsp;" . $rh . "&nbsp;" . $size_photo .
										"</div><div class='item_inches' style='display:none'>" . $inches_string .
										"</div></td>" . $content_price . "<td onClick='xcart(" . $ds->row["id"] . ");'>" .
										$bt . "</td></tr>";
								}
	
								$ds->movenext();
							}
							$ncount++;
							$dr->movenext();
						}
						$dd->movenext();
					}
	
					$sizebox_display = "inline";
					foreach ( $sizeboxes as $key => $value )
					{
						if ( $value != "" )
						{
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
	
							$value = "<table border='0' cellpadding='0' cellspacing='0' class='table_cart'><tr valign='top'><th width='20%'>" .
								pvs_word_lang( "title" ) . "</th><th width='20%' class='hidden-xs hidden-sm'>" .
								pvs_word_lang( "type" ) . "</th><th class='hidden-xs hidden-sm'><a href=\"javascript:show_size('" .
								$key . "');\" id='link_size1_" . $key . "' class='link_pixels'>" . pvs_word_lang( "pixels" ) .
								"</a>&nbsp;<a href=\"javascript:show_size('" . $key . "');\" id='link_size2_" .
								$key . "' class='link_inches'>" . pvs_word_lang( "inches" ) . "</a></th>" . $text_price .
								"<th>" . $word_buy . "</th></tr>" . $value . "</table>";
						}
						$sizebox .= "<div name='p" . $key . "' id='p" . $key . "' style='display:" . $sizebox_display .
							"'>" . $value . "</div>";
						$sizebox_display = "none";
					}
	
					if ( $pvs_global_settings["printsonly"] )
					{
						$sizebox = $prints_content;
					} else
					{
						$sizebox = "<div style='margin-bottom:6px;margin-top:15px' class='price_license'><a href='" .
							site_url() . "/license/'>" . pvs_word_lang( "license" ) . ":</a></b> " .
							$sizebox_labels . $prints_label . "</div>" . $sizebox . $prints_content;
	
						if ( $subscription_item )
						{
							$word_cart = pvs_word_lang( "download" );
							if ( $rs->row["free"] == 1 )
							{
								$word_cart = pvs_word_lang( "free download" );
							}
	
							$sizebox .= "<input id='item_button_cart' class='add_to_cart' type='button' onclick=\"add_download('photo'," .
								$rs->row["id"] . "," . $rs->row["server1"] . ")\" value='" . $word_cart .
								"'>";
						} else
						{
							$sizebox .= "<input id='item_button_cart' class='add_to_cart' type='button' onclick=\"add_cart(0)\" value='" .
								pvs_word_lang( "add to cart" ) . "'><h2 style='margin-top:20px'>" .
								pvs_word_lang( "files" ) . ":</h2>";
	
							foreach ( $photo_files as $key => $value )
							{
								$sizebox .= "<p><b>" . strtoupper( $key ) . ":</b> ";
	
								if ( $key == "jpg" or $key == "gif" or $key == "png" )
								{
									$sizebox .= $image_width[$key] . "x" . $image_height[$key] . "px&nbsp@&nbsp;";
								}
								$sizebox .= strval( pvs_price_format( $image_filesize[$key] / ( 1024 * 1024 ), 3 ) ) .
									" Mb.";
	
								$sizebox .= "</p>";
							}
						}
					}
				}
				//End show prices and prints
			} else
			{
				$sizebox = "<div style='margin-bottom:6px;margin-top:15px' class='price_license'><a href='" .
					site_url() . "/license/'>" . pvs_word_lang( "license" ) .
					":</a></b> <input name='license' id='license1' value='1' style='margin-left:20px;margin-right:10px' onclick='apanel(1);' checked type='radio'><label for='license1'>" .
					pvs_word_lang( "rights managed" ) . "</label>" . $prints_label .
					"</div><div name='p1' id='p1' style='display:inline'><table class='table_cart' border='0' cellpadding='0' cellspacing='0'><tbody><tr><th>" .
					pvs_word_lang( "file" ) . "</th><th>" . pvs_word_lang( "pixels" ) . "</th><th>" .
					pvs_word_lang( "size" ) . "</th></tr>";
	
				foreach ( $photo_files as $key => $value )
				{
					$sizebox .= "<tr><td>" . strtoupper( $key ) . "</td><td> " . $image_width[$key] .
						"x" . $image_height[$key] . "px</td><td>" . strval( pvs_price_format( $image_filesize[$key] /
						( 1024 * 1024 ), 3 ) ) . " Mb</td></tr>";
				}
	
				$sizebox .= "</tbody></table><div style='margin-top:15px'><input class='add_to_cart' type='button' value='" .
					pvs_word_lang( "calculate price" ) . "' onClick='rights_managed(" . $rs->row["id"] .
					")'></div></div>" . $prints_content;
			}
		} else {
			$sizebox = "<div style='margin-bottom:6px;margin-top:15px' class='price_license'><a href='" .
				site_url() . "/license/'>" . pvs_word_lang( "license" ) .
				":</a></b> <input name='license' id='license1' value='1' style='margin-left:20px;margin-right:10px' onclick='apanel(1);' checked type='radio'><label for='license1'>" .
				pvs_word_lang( "Contact us to get the price" ) . "</label>" . $prints_label .
				"</div><div name='p1' id='p1' style='display:inline'><table class='table_cart' border='0' cellpadding='0' cellspacing='0'><tbody><tr><th>" .
				pvs_word_lang( "file" ) . "</th><th>" . pvs_word_lang( "pixels" ) . "</th><th>" .
				pvs_word_lang( "size" ) . "</th></tr>";
	
			foreach ( $photo_files as $key => $value )
			{
				$sizebox .= "<tr><td>" . strtoupper( $key ) . "</td><td> " . $image_width[$key] .
					"x" . $image_height[$key] . "px</td><td>" . strval( pvs_price_format( $image_filesize[$key] /
					( 1024 * 1024 ), 3 ) ) . " Mb</td></tr>";
			}
	
			$sizebox .= "</tbody></table><div style='margin-top:15px'><input class='add_to_cart' type='button' value='" .
				pvs_word_lang( "Contact us to get the price" ) . "' onClick=\"location.href='" .
				site_url() . "/contacts/?file_id=" . $rs->row["id"] . "'\"></div></div>" .
				$prints_content;
		}
	
		$pvs_theme_content[ 'sizes' ] = $sizebox;
	
		require_once( get_stylesheet_directory(). '/item_photo.php' );
	}
}

?>