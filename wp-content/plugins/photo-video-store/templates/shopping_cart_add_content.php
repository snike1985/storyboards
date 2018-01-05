<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$box_shopping_cart = pvs_word_lang( "empty shopping cart" );
$box_shopping_cart_lite = pvs_word_lang( "empty shopping cart" );
$script_carts = "";
$script_carts_title = "";
$script_carts_description = "";
$script_carts_price = "";
$script_carts_qty = "";
$script_carts_url = "";
$script_carts_photo = "";
$script_carts_remove = "";
$script_carts_content_id = "";

$script_carts2 = "";
$script_carts_title2 = "";
$script_carts_description2 = "";
$script_carts_price2 = "";
$script_carts_qty2 = "";
$script_carts_url2 = "";
$script_carts_photo2 = "";
$script_carts_remove2 = "";
$script_carts_content_id2 = "";

$cart_id = pvs_shopping_cart_id();
$total = 0;
$quantity = 0;

$photo_formats = array();
$sql = "select id,photo_type from " . PVS_DB_PREFIX .
	"photos_formats where enabled=1 order by id";
$dr->open( $sql );
while ( ! $dr->eof ) {
	$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
	$dr->movenext();
}

$sql = "select id,item_id,prints_id,publication_id,quantity,option1_id,option1_value,option2_id,option2_value,option3_id,option3_value,option4_id,option4_value,option5_id,option5_value,option6_id,option6_value,option7_id,option7_value,option8_id,option8_value,option9_id,option9_value,option10_id,option10_value,rights_managed,printslab,stock,stock_type,stock_id,stock_url,stock_preview,stock_site_url,collection from " .
	PVS_DB_PREFIX . "carts_content where id_parent=" . $cart_id;
$rs->open( $sql );
if ( ! $rs->eof ) {
	$box_shopping_cart =
		"<table border=0 cellpadding=3 cellspacing=1 class='tborder'><tr><td class='theader'><span class='smalltext'><b>ID</b></span></td><td class=theader><span class=smalltext><b>" .
		pvs_word_lang( "item" ) . "</b></td><td class=theader><span class=smalltext><b>" .
		pvs_word_lang( "price" ) .
		"</b></td><td class=theader><span class=smalltext><b>" . pvs_word_lang( "qty" ) .
		"</b></td></tr>";

	while ( ! $rs->eof ) {
		if ( $script_carts != "" )
		{
			$script_carts .= ",";
		}
		if ( $script_carts_title != "" )
		{
			$script_carts_title .= ",";
		}
		if ( $script_carts_description != "" )
		{
			$script_carts_description .= ",";
		}
		if ( $script_carts_price != "" )
		{
			$script_carts_price .= ",";
		}
		if ( $script_carts_qty != "" )
		{
			$script_carts_qty .= ",";
		}
		if ( $script_carts_url != "" )
		{
			$script_carts_url .= ",";
		}
		if ( $script_carts_photo != "" )
		{
			$script_carts_photo .= ",";
		}
		if ( $script_carts_remove != "" )
		{
			$script_carts_remove .= ",";
		}
		if ( $script_carts_content_id != "" )
		{
			$script_carts_content_id .= ",";
		}

		if ( $script_carts2 != "" )
		{
			$script_carts2 .= "||";
		}
		if ( $script_carts_title2 != "" )
		{
			$script_carts_title2 .= "||";
		}
		if ( $script_carts_description2 != "" )
		{
			$script_carts_description2 .= "||";
		}
		if ( $script_carts_price2 != "" )
		{
			$script_carts_price2 .= "||";
		}
		if ( $script_carts_qty2 != "" )
		{
			$script_carts_qty2 .= "||";
		}
		if ( $script_carts_url2 != "" )
		{
			$script_carts_url2 .= "||";
		}
		if ( $script_carts_photo2 != "" )
		{
			$script_carts_photo2 .= "||";
		}
		if ( $script_carts_remove2 != "" )
		{
			$script_carts_remove2 .= "||";
		}
		if ( $script_carts_content_id2 != "" )
		{
			$script_carts_content_id2 .= "||";
		}

		$script_carts .= $rs->row["publication_id"];
		$script_carts_remove .= "0";
		$script_carts_content_id .= $rs->row["id"];

		$script_carts2 .= $rs->row["publication_id"];
		$script_carts_remove2 .= "0";
		$script_carts_content_id2 .= $rs->row["id"];

		if ( (int) $rs->row["collection"] == 0 ) {
			if ( $rs->row["item_id"] > 0 )
			{
				//Download items
				$sql = "select id,name,price,id_parent,url,shipped from " . PVS_DB_PREFIX .
					"items where id=" . $rs->row["item_id"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$sql = "select id,media_id,title,server1,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps from " .
						PVS_DB_PREFIX . "media where id=" . ( int )$dr->row["id_parent"];
					$ds->open( $sql );
					if ( ! $ds->eof )
					{
						if ( $ds->row["media_id"] == 1 )
						{	
							$translate_results = pvs_translate_publication( $ds->row["id"], $ds->row["title"],
								"", "" );
							$title = $translate_results["title"];
							$folder = $ds->row["id"];
	
							$photo_files = array();
							foreach ( $photo_formats as $key => $value )
							{
								$photo_files[$value] = $ds->row["url_" . $value];
							}
	
							$sql = "select width,height from " . PVS_DB_PREFIX .
								"filestorage_files where id_parent=" . $ds->row["id"] . " and item_id<>0";
							$dq->open( $sql );
							if ( ! $dq->eof )
							{
								$photo_width = $dq->row["width"];
								$photo_height = $dq->row["height"];
							} else
							{
								if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
									$folder . "/" . $dr->row["url"] ) )
								{
									$size = getimagesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
										"/" . $folder . "/" . $dr->row["url"] );
									$photo_width = $size[0];
									$photo_height = $size[1];
								}
							}
	
							$rw = $photo_width;
							$rh = $photo_height;
	
							if ( $photo_width != 0 and $photo_height != 0 )
							{
								$sql = "select * from " . PVS_DB_PREFIX . "sizes where title='" . $dr->row["name"] .
									"'";
								$dq->open( $sql );
								if ( ! $dq->eof )
								{
									if ( $dq->row["size"] != 0 )
									{
										if ( $rw > $rh )
										{
											$rw = $dq->row["size"];
											if ( $rw != 0 )
											{
												$rh = round( $photo_height * $rw / $photo_width );
											}
										} else
										{
											$rh = $dq->row["size"];
											if ( $rh != 0 )
											{
												$rw = round( $photo_width * $rh / $photo_height );
											}
										}
									}
								}
							}
							$fl = "photos";
							$server1 = $ds->row["server1"];
							$preview = pvs_show_preview( $ds->row["id"], "photo", 1, 1, $ds->row["server1"],
								$ds->row["id"] );
							$script_carts_description .= "'" . $rw . "x" . $rh . "'";
							$script_carts_description2 .= "'" . $rw . "x" . $rh . "'";
						}

						if ( $ds->row["media_id"] == 2 )
						{
							$translate_results = pvs_translate_publication( $ds->row["id"], $ds->row["title"],
								"", "" );
							$title = $translate_results["title"];
							$folder = $ds->row["id"];
							$fl = "videos";
							$server1 = $ds->row["server1"];
							$preview = pvs_show_preview( $ds->row["id"], "video", 1, 1, $ds->row["server1"],
								$ds->row["id"] );
							$script_carts_description .= "'" . addslashes( pvs_word_lang( $dr->row["name"] ) ) .
								"'";
							$script_carts_description2 .= "'" . addslashes( pvs_word_lang( $dr->row["name"] ) ) .
								"'";
						}
	
						if ( $ds->row["media_id"] == 3 )
						{
							$translate_results = pvs_translate_publication( $ds->row["id"], $ds->row["title"],
								"", "" );
							$title = $translate_results["title"];
							$folder = $ds->row["id"];
							$fl = "audio";
							$server1 = $ds->row["server1"];
							$preview = pvs_show_preview( $ds->row["id"], "audio", 1, 1, $ds->row["server1"],
								$ds->row["id"] );
							$script_carts_description .= "'" . addslashes( pvs_word_lang( $dr->row["name"] ) ) .
								"'";
							$script_carts_description2 .= "'" . addslashes( pvs_word_lang( $dr->row["name"] ) ) .
								"'";
						}
	
						if ( $ds->row["media_id"] == 4 )
						{
							$translate_results = pvs_translate_publication( $ds->row["id"], $ds->row["title"],
								"", "" );
							$title = $translate_results["title"];
							$folder = $ds->row["id"];
							$fl = "vector";
							$server1 = $ds->row["server1"];
							$preview = pvs_show_preview( $ds->row["id"], "vector", 1, 1, $ds->row["server1"],
								$ds->row["id"] );
							$script_carts_description .= "'" . addslashes( pvs_word_lang( $dr->row["name"] ) ) .
								"'";
							$script_carts_description2 .= addslashes( pvs_word_lang( $dr->row["name"] ) );
						}
					}

					$script_carts_title .= "'#" . $dr->row["id_parent"] . " " . addslashes( $title ) .
						"'";
					$script_carts_photo .= "'" . $preview . "'";
					$script_carts_title2 .= "#" . $dr->row["id_parent"] . " " . addslashes( $title );
					$script_carts_photo2 .= $preview;
				}

				if ( $rs->row["rights_managed"] != "" )
				{
					$rights_managed_price = 0;
					$rights_mass = explode( "|", $rs->row["rights_managed"] );
					$rights_managed_price = $rights_mass[0];

					$box_shopping_cart .=
						"<tr><td class='tcontent'><span class='smalltext'><a href='" . pvs_item_url( $dr->
						row["id_parent"] ) . "'>" . $dr->row["id_parent"] .
						"</a></td><td class=tcontent><span class=smalltext>" . pvs_word_lang( "rights managed" ) .
						"</td><td class=tcontent><span class=smalltext><span class='price'>" .
						pvs_price_format( $rights_managed_price, 2, true ) .
						"</span></td><td class=tcontent><span class=smalltext>" . $rs->row["quantity"] .
						"</td></tr>";
					$total += $rights_managed_price;

					$script_carts_price .= $rights_managed_price;
					$script_carts_url .= "'" . pvs_item_url( $dr->row["id_parent"] ) . "'";
					$script_carts_price2 .= $rights_managed_price;
					$script_carts_url2 .= pvs_item_url( $dr->row["id_parent"] );
				} else
				{
					$sql = "select id,name,price,id_parent from " . PVS_DB_PREFIX .
						"items where id=" . $rs->row["item_id"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$box_shopping_cart .=
							"<tr><td class='tcontent'><span class='smalltext'><a href='" . pvs_item_url( $dr->
							row["id_parent"] ) . "'>" . $dr->row["id_parent"] .
							"</a></td><td class=tcontent><span class=smalltext>" . pvs_word_lang( $dr->row["name"] ) .
							"</td><td class=tcontent><span class=smalltext><span class='price'>" .
							pvs_price_format( $dr->row["price"], 2, true ) .
							"</span></td><td class=tcontent><span class=smalltext>" . $rs->row["quantity"] .
							"</td></tr>";
						$total += $dr->row["price"] * $rs->row["quantity"];

						$script_carts_price .= $dr->row["price"];
						$script_carts_url .= "'" . pvs_item_url( $dr->row["id_parent"] ) . "'";
						$script_carts_price2 .= $dr->row["price"];
						$script_carts_url2 .= pvs_item_url( $dr->row["id_parent"] );
					}
				}
			}

			if ( $rs->row["prints_id"] > 0 )
			{
				if ( ( int )$rs->row["stock"] == 0 )
				{
					if ( $rs->row["printslab"] <> 1 )
					{
						$sql = "select id_parent,title,price,itemid,printsid from " . PVS_DB_PREFIX .
							"prints_items where id_parent=" . $rs->row["prints_id"];
						$dr->open( $sql );
						if ( ! $dr->eof )
						{
							$price = pvs_define_prints_price( $dr->row["price"], $rs->row["option1_id"], $rs->
								row["option1_value"], $rs->row["option2_id"], $rs->row["option2_value"], $rs->
								row["option3_id"], $rs->row["option3_value"], $rs->row["option4_id"], $rs->row["option4_value"],
								$rs->row["option5_id"], $rs->row["option5_value"], $rs->row["option6_id"], $rs->
								row["option6_value"], $rs->row["option7_id"], $rs->row["option7_value"], $rs->
								row["option8_id"], $rs->row["option8_value"], $rs->row["option9_id"], $rs->row["option9_value"],
								$rs->row["option10_id"], $rs->row["option10_value"] );

							$box_shopping_cart .=
								"<tr><td class='tcontent'><span class='smalltext'><a href='" . pvs_item_url( $dr->
								row["itemid"] ) . "'>" . $dr->row["itemid"] .
								"</a></td><td  class=tcontent><span class=smalltext>" . pvs_word_lang( "prints" ) .
								": " . pvs_word_lang( $dr->row["title"] ) .
								"</td><td  class=tcontent><span class=smalltext><span class='price'>" .
								pvs_price_format( $price, 2, true ) .
								"</span></td><td class=tcontent><span class=smalltext>" . $rs->row["quantity"] .
								"</td></tr>";
							$total += $price * $rs->row["quantity"];

							$script_carts_price .= $price;

							$script_carts_price2 .= $price;

							$sql = "select id,title,server1 from " . PVS_DB_PREFIX .
								"media where id=" . ( int )$dr->row["itemid"];
							$ds->open( $sql );
							if ( ! $ds->eof )
							{
								$translate_results = pvs_translate_publication( $ds->row["id"], $ds->row["title"],
									"", "" );
								$title = $translate_results["title"];
								$folder = $ds->row["id"];
								$server1 = $ds->row["server1"];
								$preview = pvs_show_preview( $ds->row["id"], "photo", 1, 1, $ds->row["server1"],
									$ds->row["id"] );

								if ( @$pvs_global_settings["prints_previews"] )
								{
									$print_info = pvs_get_print_preview_info( $dr->row["printsid"] );
									if ( $print_info["flag"] )
									{
										$url = pvs_print_url( $dr->row["itemid"], $dr->row["printsid"], $ds->row["title"],
											$print_info["preview"], '' );
									} else
									{
										$url = pvs_item_url( $dr->row["itemid"] );
									}
								} else
								{
									$url = pvs_item_url( $dr->row["itemid"] );
								}

								$script_carts_url .= "'" . $url . "'";
								$script_carts_url2 .= $url;
							}

							$script_carts_title .= "'#" . $dr->row["itemid"] . " " . addslashes( $title ) .
								"'";
							$script_carts_photo .= "'" . $preview . "'";
							$script_carts_description .= "'" . addslashes( pvs_word_lang( $dr->row["title"] ) ) .
								"'";
							$script_carts_title2 .= "#" . $dr->row["itemid"] . " " . addslashes( $title );
							$script_carts_photo2 .= $preview;
							$script_carts_description2 .= addslashes( pvs_word_lang( $dr->row["title"] ) );

						}
					} else
					{
						$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
							"prints where id_parent=" . $rs->row["prints_id"];
						$dr->open( $sql );
						if ( ! $dr->eof )
						{
							$price = pvs_define_prints_price( $dr->row["price"], $rs->row["option1_id"], $rs->
								row["option1_value"], $rs->row["option2_id"], $rs->row["option2_value"], $rs->
								row["option3_id"], $rs->row["option3_value"], $rs->row["option4_id"], $rs->row["option4_value"],
								$rs->row["option5_id"], $rs->row["option5_value"], $rs->row["option6_id"], $rs->
								row["option6_value"], $rs->row["option7_id"], $rs->row["option7_value"], $rs->
								row["option8_id"], $rs->row["option8_value"], $rs->row["option9_id"], $rs->row["option9_value"],
								$rs->row["option10_id"], $rs->row["option10_value"] );

							$box_shopping_cart .=
								"<tr><td class='tcontent'><span class='smalltext'><a href='printslab.php'>" . $rs->
								row["publication_id"] . "</a></td><td  class=tcontent><span class=smalltext>" .
								pvs_word_lang( "prints" ) . ": " . pvs_word_lang( $dr->row["title"] ) .
								"</td><td  class=tcontent><span class=smalltext><span class='price'>" .
								pvs_price_format( $price, 2, true ) .
								"</span></td><td class=tcontent><span class=smalltext>" . $rs->row["quantity"] .
								"</td></tr>";
							$total += $price * $rs->row["quantity"];

							$script_carts_price .= $price;
							$script_carts_price2 .= $price;

							$sql = "select id,title,photo,id_parent from " . PVS_DB_PREFIX .
								"galleries_photos where id=" . ( int )$rs->row["publication_id"];
							$ds->open( $sql );
							if ( ! $ds->eof )
							{
								$title = $ds->row["title"];
								$preview = pvs_upload_dir('baseurl') . "/content/galleries/" . $ds->row["id_parent"] . "/thumb" .
									$ds->row["id"] . ".jpg";
								$url = "printslab_content.php?id=" . $ds->row["id_parent"];

								$script_carts_title .= "'#" . $ds->row["id"] . " " . addslashes( $title ) . "'";
								$script_carts_title2 .= "#" . $ds->row["id"] . " " . addslashes( $title );
							}

							$script_carts_url .= "'" . $url . "'";
							$script_carts_photo .= "'" . $preview . "'";
							$script_carts_description .= "'" . addslashes( pvs_word_lang( $dr->row["title"] ) ) .
								"'";
							$script_carts_url2 .= $url;
							$script_carts_photo2 .= $preview;
							$script_carts_description2 .= addslashes( pvs_word_lang( $dr->row["title"] ) );
						}
					}
				} else
				{
					$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
						"prints where id_parent=" . $rs->row["prints_id"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$price = pvs_define_prints_price( $dr->row["price"], $rs->row["option1_id"], $rs->
							row["option1_value"], $rs->row["option2_id"], $rs->row["option2_value"], $rs->
							row["option3_id"], $rs->row["option3_value"], $rs->row["option4_id"], $rs->row["option4_value"],
							$rs->row["option5_id"], $rs->row["option5_value"], $rs->row["option6_id"], $rs->
							row["option6_value"], $rs->row["option7_id"], $rs->row["option7_value"], $rs->
							row["option8_id"], $rs->row["option8_value"], $rs->row["option9_id"], $rs->row["option9_value"],
							$rs->row["option10_id"], $rs->row["option10_value"] );

						$box_shopping_cart .=
							"<tr><td class='tcontent'><span class='smalltext'><a href='" . $rs->row["stock_site_url"] .
							"'>" . @$mstocks[$rs->row["stock_type"]] . " #" . $rs->row["stock_id"] .
							"</a></td><td  class=tcontent><span class=smalltext>" . pvs_word_lang( "prints" ) .
							": " . pvs_word_lang( $dr->row["title"] ) .
							"</td><td  class=tcontent><span class=smalltext><span class='price'>" .
							pvs_price_format( $price, 2, true ) .
							"</span></td><td class=tcontent><span class=smalltext>" . $rs->row["quantity"] .
							"</td></tr>";
						$total += $price * $rs->row["quantity"];

						$script_carts_price .= $price;
						$script_carts_price2 .= $price;

						$title = @$mstocks[$rs->row["stock_type"]] . " #" . $rs->row["stock_id"];
						$preview = $rs->row["stock_preview"];
						$url = $rs->row["stock_site_url"];

						$script_carts_title .= "'" . addslashes( $title ) . "'";
						$script_carts_title2 .= addslashes( $title );

						$script_carts_url .= "'" . $url . "'";
						$script_carts_photo .= "'" . $preview . "'";
						$script_carts_description .= "'" . addslashes( pvs_word_lang( $dr->row["title"] ) ) .
							"'";
						$script_carts_url2 .= $url;
						$script_carts_photo2 .= $preview;
						$script_carts_description2 .= addslashes( pvs_word_lang( $dr->row["title"] ) );
					}
				}
			}
		} else {
			//Collection
			$sql = "select id, title, price, description from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . $rs->row["collection"];
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$price = $ds->row["price"];

				$box_shopping_cart .=
					"<tr><td class='tcontent'><span class='smalltext'><a href='" . pvs_collection_url( $ds->row["id"], $ds->row["title"] ) .
					"'>" . @$mstocks[$rs->row["stock_type"]] . " #" . $rs->row["stock_id"] .
					"</a></td><td  class=tcontent></td><td  class=tcontent><span class=smalltext><span class='price'>" .
					pvs_price_format( $price, 2, true ) .
					"</span></td><td class=tcontent><span class=smalltext>" . $rs->row["quantity"] .
					"</td></tr>";
				$total += $price * $rs->row["quantity"];

				$script_carts_price .= $price;
				$script_carts_price2 .= $price;
				
				$collection_result = pvs_show_collection_preview($ds->row["id"]);

				$title = pvs_word_lang("Collection") . ': ' . $ds->row["title"] . ' (' . pvs_count_files_in_collection($ds->row["id"]) . ')';
				$preview = $collection_result["photo"];
				$url = pvs_collection_url( $ds->row["id"], $ds->row["title"] );

				$script_carts_title .= "'" . addslashes( $title ) . "'";
				$script_carts_title2 .= addslashes( $title );

				$script_carts_url .= "'" . $url . "'";
				$script_carts_photo .= "'" . $preview . "'";
				$script_carts_description .= "'" . addslashes( $ds->row["description"] ) .
					"'";
				$script_carts_url2 .= $url;
				$script_carts_photo2 .= $preview;
				$script_carts_description2 .= addslashes( $ds->row["description"] );
			}
		}

		$quantity += $rs->row["quantity"];

		$script_carts_qty .= $rs->row["quantity"];
		$script_carts_qty2 .= $rs->row["quantity"];

		$rs->movenext();
	}

	$box_shopping_cart .= "</table><div class=smalltext style='margin-top:5'><b>" .
		pvs_word_lang( "total" ) . ":</b> " . pvs_currency( 1 ) . pvs_price_format( $total,
		2, true ) . " " . pvs_currency( 2 ) .
		"</div><div style='margin-top:5'><a href='" . site_url() .
		"/cart/' class='o'><b>" . pvs_word_lang( "view shopping cart" ) .
		"</b></a></div>";

	$box_shopping_cart_lite = "<a href='" . site_url() .
		"/cart/'>" . pvs_word_lang( "shopping cart" ) . "</a> " . $quantity .
		" (" . pvs_currency( 1 ) . pvs_price_format( $total, 2, true ) . " " .
		pvs_currency( 2 ) . ")";
}

$script_carts = "<script>
cart_mass=new Array();
cart_mass = [" . $script_carts . "];
cart_title=new Array();
cart_title=[" . $script_carts_title . "];
cart_price=new Array();
cart_price=[" . $script_carts_price . "];
cart_qty=new Array();
cart_qty=[" . $script_carts_qty . "];
cart_url=new Array();
cart_url=[" . $script_carts_url . "];
cart_photo=new Array();
cart_photo=[" . $script_carts_photo . "];
cart_description=new Array();
cart_description=[" . $script_carts_description . "];
cart_remove=new Array();
cart_remove=[" . $script_carts_remove . "];
cart_content_id=new Array();
cart_content_id=[" . $script_carts_content_id . "];
</script><input type='hidden' id='list_cart_mass' value=\"" . $script_carts2 .
	"\"><input type='hidden' id='list_cart_title' value=\"" . $script_carts_title2 .
	"\"><input type='hidden' id='list_cart_price' value=\"" . $script_carts_price2 .
	"\"><input type='hidden' id='list_cart_qty' value=\"" . $script_carts_qty2 . "\"><input type='hidden' id='list_cart_url' value=\"" .
	$script_carts_url2 . "\"><input type='hidden' id='list_cart_photo' value=\"" . $script_carts_photo2 .
	"\"><input type='hidden' id='list_cart_description' value=\"" . $script_carts_description2 .
	"\"><input type='hidden' id='list_cart_remove' value=\"" . $script_carts_remove2 .
	"\"><input type='hidden' id='list_cart_content_id' value=\"" . $script_carts_content_id2 .
	"\">";

$box_shopping_cart .= $script_carts;
$box_shopping_cart_lite .= $script_carts;
?>