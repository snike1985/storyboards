<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


$cart_id = pvs_shopping_cart_id();
$total = 0;
$tax_total = 0;
$quantity = 0;

function get_print_options( $print_id, $type, $print_width, $print_height ) {
	global $dq;
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$dt = new TMySQLQuery;
	$dt->connection = $db;
	$dw = new TMySQLQuery;
	$dw->connection = $db;

	$prints_content = "";

	if ( $type == "photo" ) {
		$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
			PVS_DB_PREFIX . "prints where photo=1 and id_parent=" . ( int )$print_id;
	}
	if ( $type == "printslab" ) {
		$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
			PVS_DB_PREFIX . "prints where printslab=1 and  id_parent=" . ( int )$print_id;
	}
	if ( $type == "stock" ) {
		$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
			PVS_DB_PREFIX . "prints where id_parent=" . ( int )$print_id;
	}
	$dp->open( $sql );
	if ( ! $dp->eof ) {
		for ( $i = 1; $i < 11; $i++ ) {
			if ( $dp->row["option" . $i] != 0 )
			{
				$sql = "select title,type,activ,required,property_name from " . PVS_DB_PREFIX .
					"products_options where activ=1 and id=" . $dp->row["option" . $i];
				$dt->open( $sql );
				if ( ! $dt->eof )
				{
					$prints_content .= "<div class='ttl' style='margin-top:15px'>" . pvs_word_lang( $dt->
						row["title"] ) . ":</div><div>";

					if ( $dt->row["type"] == "colorpicker" or $dt->row["type"] == "colors" )
					{
						$prints_content .= "<div class='clearfix'><div style='background-color:" . $dq->
							row["option" . $i . "_value"] .
							";cursor:default' class='prints_colors'>&nbsp;</div></div>";
					}

					if ( $dt->row["type"] == "background" )
					{
						$prints_content .= "<div class='clearfix'><div style='background:url(" .
							site_url() . "/templates/prints/images/" . $dq->row["option" . $i . "_value"] .
							");background-position:center center;cursor:default' class='prints_background'>&nbsp;</div></div>";
					}

					if ( $dt->row["type"] == "selectform" or $dt->row["type"] == "frame" )
					{
						$prints_content .= "<select onChange=\"cart_change_option(" . $dq->row["id"] .
							"," . $i . "," . $dp->row["option" . $i] . ",this.value)\" class='ibox form-control' style='width:250px'>";
					}

					$sql = "select id,title,price,adjust,property_value from " . PVS_DB_PREFIX .
						"products_options_items where id_parent=" . $dp->row["option" . $i] .
						" order by id";
					$dw->open( $sql );
					while ( ! $dw->eof )
					{
						$sel = "";
						$sel2 = "";

						if ( $dq->row["option" . $i . "_value"] == $dw->row["title"] )
						{
							$sel = "selected";
							$sel2 = "checked";
						}

						if ( $dt->row["type"] == "selectform" or $dt->row["type"] == "frame" )
						{
							if ( $dt->row["property_name"] == "print_size" )
							{
								if ( ( $print_width >= $dw->row["property_value"] or $print_width == 0 ) or ( $print_height >=
									$dw->row["property_value"] or $print_height == 0 ) )
								{
									if ( $print_width > $print_height )
									{
										$print_size = $print_width;
									} else
									{
										$print_size = $print_height;
									}

									$property_value = $dw->row["title"];

									$value_array = explode( "cm", $property_value );
									if ( count( $value_array ) == 2 and $print_size != 0 )
									{
										$property_value = $value_array[0];
										$property_value = round( $property_value * $print_width / $print_size ) .
											"cm x " . round( $property_value * $print_height / $print_size ) . "cm";
									}

									$value_array = explode( 'in', $property_value );
									if ( count( $value_array ) == 2 and $print_size != 0 )
									{
										$property_value = $value_array[0];
										$property_value = round( $property_value * $print_width / $print_size ) . '" x ' .
											round( $property_value * $print_height / $print_size ) . '"';
									}

									$prints_content .= "<option value='" . $dw->row["title"] . "' " . $sel . ">" . $property_value .
										"</option>";
								}
							} else
							{
								$prints_content .= "<option value='" . $dw->row["title"] . "' " . $sel . ">" .
									pvs_word_lang( $dw->row["title"] ) . "</option>";
							}
						}
						if ( $dt->row["type"] == "radio" )
						{
							$prints_content .= "<input onClick=\"cart_change_option(" . $dq->row["id"] . "," .
								$i . "," . $dp->row["option" . $i] . ",'" . $dw->row["title"] . "')\" name='option" .
								$dq->row["id"] . "_" . $dp->row["option" . $i] . "' type='radio' value='" . $dw->
								row["title"] . "' " . $sel2 . ">&nbsp;" . pvs_word_lang( $dw->row["title"] ) .
								"&nbsp;&nbsp;";
						}

						$dw->movenext();
					}

					if ( $dt->row["type"] == "selectform" or $dt->row["type"] == "frame" )
					{
						$prints_content .= "</select>";
					}

					$prints_content .= "</div>";
				}
			}
		}
	}
	return $prints_content;
}

$photo_formats = array();
if ( $pvs_global_settings["allow_photo"] ) {
	$sql = "select id,photo_type from " . PVS_DB_PREFIX .
		"photos_formats where enabled=1 order by id";
	$dr->open( $sql );
	while ( ! $dr->eof ) {
		$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
		$dr->movenext();
	}
}

if ( $pvs_global_settings["prints"] ) {
	$prints_mass = array();

	$sql = "select id from " . PVS_DB_PREFIX .
		"prints_categories where active=1 order by priority";
	$dr->open( $sql );
	while ( ! $dr->eof ) {
		$prints_mass[] = $dr->row["id"];
		$dr->movenext();
	}
	$prints_mass[] = 0;
}

$sql = "select id,item_id,prints_id,publication_id,quantity,option1_id,option1_value,option2_id,option2_value,option3_id,option3_value,option4_id,option4_value,option5_id,option5_value,option6_id,option6_value,option7_id,option7_value,option8_id,option8_value,option9_id,option9_value,option10_id,option10_value,rights_managed,printslab,stock,stock_type,stock_id,stock_url,stock_preview,stock_site_url,print_width,print_height,collection from " .
	PVS_DB_PREFIX . "carts_content where id_parent=" . $cart_id;
$dq->open( $sql );
if ( ! $dq->eof ) {
?>
		<table border="0" cellpadding="8" cellspacing="0"  class='table_cart2' style="width:100%">
		<tr>
		<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "item" );?></b></td>
		<th><b><?php echo pvs_word_lang( "title" );?></b></th>
		<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "price" );?></b></th>
		<th><b><?php echo pvs_word_lang( "qty" );?></b></th>
		<th></th>
		</tr>
	<?php
	while ( ! $dq->eof ) {
		if ( (int) $dq->row["collection"] == 0 ) {
			if ( $dq->row["item_id"] > 0 ) {
				//Download items
				$sql = "select id,name,price,id_parent,url,shipped from " . PVS_DB_PREFIX .
					"items where id=" . $dq->row["item_id"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$sql = "select id, media_id, title,server1,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps from " .
						PVS_DB_PREFIX . "media where id=" . ( int )$dr->row["id_parent"];
					$rs->open( $sql );
					if ( ! $rs->eof )
					{
						$translate_results = pvs_translate_publication( $rs->row["id"], $rs->row["title"],
							"", "" );
						$title = $translate_results["title"];
						$folder = $rs->row["id"];
						$server1 = $rs->row["server1"];
						$url = pvs_item_url( $rs->row["id"] );
						$fl = "photos";
						
						if ( $rs->row["media_id"] == 1) {
							$photo_files = array();
							foreach ( $photo_formats as $key => $value )
							{
								$photo_files[$value] = $rs->row["url_" . $value];
							}
		
							$sql = "select width,height from " . PVS_DB_PREFIX .
								"filestorage_files where id_parent=" . $rs->row["id"] . " and item_id<>0";
							$ds->open( $sql );
							if ( ! $ds->eof )
							{
								$photo_width = $ds->row["width"];
								$photo_height = $ds->row["height"];
							} else
							{
								if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
									$folder . "/" . $dr->row["url"] ) )
								{
									$size = getimagesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
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
								$ds->open( $sql );
								if ( ! $ds->eof )
								{
									if ( $ds->row["size"] != 0 )
									{
										if ( $rw > $rh )
										{
											$rw = $ds->row["size"];
											if ( $rw != 0 )
											{
												$rh = round( $photo_height * $rw / $photo_width );
											}
										} else
										{
											$rh = $ds->row["size"];
											if ( $rh != 0 )
											{
												$rw = round( $photo_width * $rh / $photo_height );
											}
										}
									}
								}
							}
							$fl = "photos";
							$preview = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"], $rs->row["id"] );
						}
						
						if ( $rs->row["media_id"] == 2) {
							$fl = "videos";
							$preview = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
								$rs->row["id"] );
						}
	
						if ( $rs->row["media_id"] == 3) {
							$fl = "audio";
							$preview = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
							$rs->row["id"] );
						}
	
						if ( $rs->row["media_id"] == 4) {
							$fl = "vector";
							$preview = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
							$rs->row["id"] );
						}
					}
	?>
			<tr valign="top"  class='tr_cart'>
			<td class='hidden-phone hidden-tablet'><a href="<?php
					echo $url;
	?>"><img src="<?php
					echo $preview;
	?>" border="0"></a></td>
			<td><a href="<?php
					echo $url;
	?>"><?php
					echo $title;
	?></a><div class="gr">ID: <?php
					echo $dr->row["id_parent"];
	?></div>
			<?php
					if ( $dq->row["rights_managed"] != "" )
					{
	?>
				<div class="ttl"><b><?php
						echo pvs_word_lang( "rights managed" );?>:</b></div>
				<ul>
				<?php
						$rights_managed_price = 0;
						$rights_mass = explode( "|", $dq->row["rights_managed"] );
						for ( $i = 0; $i < count( $rights_mass ); $i++ )
						{
							if ( $i == 0 )
							{
								$rights_managed_price = $rights_mass[$i];
							} else
							{
								$rights_mass2 = explode( "-", $rights_mass[$i] );
								if ( isset( $rights_mass2[0] ) and isset( $rights_mass2[1] ) )
								{
									$sql = "select title from " . PVS_DB_PREFIX .
										"rights_managed_structure where id=" . ( int )$rights_mass2[0] . " and  types=1";
									$ds->open( $sql );
									if ( ! $ds->eof )
									{
	?><li><b><?php
										echo pvs_word_lang( $ds->row["title"] );?>:</b> <?php
									}
	
									$sql = "select title from " . PVS_DB_PREFIX .
										"rights_managed_structure where id=" . ( int )$rights_mass2[1] . " and  types=2";
									$ds->open( $sql );
									if ( ! $ds->eof )
									{
	?><?php
										echo pvs_word_lang( $ds->row["title"] );?></li><?php
									}
								}
							}
						}
						$total += $rights_managed_price;
	?>
				</ul>
			<?php
					} else
					{
	?>
				<div class="ttl"><?php
						echo pvs_word_lang( "file" );?>:</div><select style="width:320px" class='ibox form-control' onChange="cart_add(<?php
						echo $dq->row["id"];
	?>,this.value);">
				<?php
						$sql = "select id_parent,name from " . PVS_DB_PREFIX .
							"licenses order by priority";
						$ds->open( $sql );
						while ( ! $ds->eof )
						{
							if ( $fl == "photos" )
							{
								$sql = "select id_parent,title,size,jpg,png,gif,raw,tiff,eps from " .
									PVS_DB_PREFIX . "sizes where license=" . $ds->row["id_parent"] .
									" order by priority";
							}
							if ( $fl == "videos" )
							{
								$sql = "select id_parent,title from " . PVS_DB_PREFIX .
									"video_types where license=" . $ds->row["id_parent"] . " order by priority";
							}
							if ( $fl == "audio" )
							{
								$sql = "select id_parent,title from " . PVS_DB_PREFIX .
									"audio_types where license=" . $ds->row["id_parent"] . " order by priority";
							}
							if ( $fl == "vector" )
							{
								$sql = "select id_parent,title from " . PVS_DB_PREFIX .
									"vector_types where license=" . $ds->row["id_parent"] . " order by priority";
							}
							$dd->open( $sql );
							while ( ! $dd->eof )
							{
								if ( $fl == "photos" )
								{
									$flag_format = false;
									foreach ( $photo_formats as $key => $value )
									{
										if ( $photo_files[$value] != "" and $dd->row[$value] == 1 )
										{
											$flag_format = true;
										}
									}
	
									if ( ( ( $photo_width >= $photo_height and $dd->row["size"] <= $photo_width ) or
										( $photo_width < $photo_height and $dd->row["size"] <= $photo_height ) ) and $flag_format )
									{
										$flag_size = true;
									} else
									{
										$flag_size = false;
									}
								} else
								{
									$flag_size = true;
								}
	
								$sql = "select id,name,url,price from " . PVS_DB_PREFIX .
									"items where price_id=" . $dd->row["id_parent"] . " and id_parent=" . $dr->row["id_parent"] .
									" and price<>0 order by priority";
								$dn->open( $sql );
								if ( ! $dn->eof and $flag_size )
								{
									$chk = "";
									if ( $dn->row["id"] == $dq->row["item_id"] )
									{
										$chk = "selected";
									}
	?>
					<option value='<?php
									echo $dn->row["id"];
	?>' <?php
									echo $chk;
	?>><?php
									echo pvs_word_lang( $ds->row["name"] );?> - <?php
									echo pvs_word_lang( $dn->row["name"] );?></option>
				<?php
								}
								$dd->movenext();
							}
							$ds->movenext();
						}
	?>
				</select>
			<?php
						$total += $dr->row["price"] * $dq->row["quantity"];
					}
	?>
			</td>
			<td class='hidden-phone hidden-tablet'><span class="price"><b><?php
					echo pvs_currency( 1 );?>
			<?php
					if ( $dq->row["rights_managed"] != "" )
					{
	?>
				<?php
						echo pvs_price_format( $rights_managed_price, 2, true );?>
			<?php
					} else
					{
	?>
				<?php
						echo pvs_price_format( $dr->row["price"], 2, true );?>
			<?php
					}
	?>
			&nbsp;<?php
					echo pvs_currency( 2 );?></b></span>
			
			<?php
					if ( $pvs_global_settings["taxes_cart"] and ( ! $pvs_global_settings["credits"] or
						$pvs_global_settings["credits_currency"] ) )
					{
						$taxes_info = array();
						if ( $dr->row["shipped"] != 1 )
						{
							if ( $dq->row["rights_managed"] != "" )
							{
								pvs_order_taxes_calculate( $rights_managed_price, false, "order" );
							} else
							{
								pvs_order_taxes_calculate( $dr->row["price"], false, "order" );
							}
						} else
						{
							pvs_order_taxes_calculate( $dr->row["price"], false, "prints" );
						}
	
						if ( $taxes_info["total"] != 0 )
						{
							echo ( "<div><small><b>" . $taxes_info["text"] . ": " . pvs_currency( 1, false ) .
								$taxes_info["total"] . " " . pvs_currency( 2, false ) . "</b></small></div>" );
							$tax_total += $taxes_info["total"];
						}
					}
	?>
			</td>
			<td><?php
					if ( $dr->row["shipped"] != 1 )
					{
	?>1<?php
					} else
					{
	?>
	
			<select class='ibox form-control' onChange="cart_change(<?php
						echo $dq->row["id"];
	?>,this.value);" style="width:80px">
			<?php
						for ( $j = 1; $j < 100; $j++ )
						{
							if ( $j == $dq->row["quantity"] )
							{
								$sel = "selected";
							} else
							{
								$sel = "";
							}
	?>
					<option value="<?php
							echo $j;
	?>" <?php
							echo $sel;
	?>><?php
							echo $j;
	?></option>
				<?php
						}
	?>
			</select>
			<?php
					}
	?></td>
			<td><i class="fa fa-trash" aria-hidden="true"></i> <a href="#" onClick="cart_delete(<?php
					echo $dq->row["id"];
	?>);"><?php
					echo pvs_word_lang( "delete" );?></a></td>
			</tr>
			<?php
				}
			}
	
			if ( $dq->row["prints_id"] > 0 ) {
				if ( ( int )$dq->row["stock"] == 0 )
				{
					if ( $dq->row["printslab"] <> 1 )
					{
						//Prints items
						$sql = "select id_parent,title,price,itemid,printsid,in_stock from " .
							PVS_DB_PREFIX . "prints_items where id_parent=" . $dq->row["prints_id"];
						$dr->open( $sql );
						if ( ! $dr->eof )
						{
							$folder = "";
	
							$sql = "select id,title,server1 from " . PVS_DB_PREFIX .
								"media where id=" . ( int )$dr->row["itemid"];
							$rs->open( $sql );
							if ( ! $rs->eof )
							{
								$translate_results = pvs_translate_publication( $rs->row["id"], $rs->row["title"],
									"", "" );
								$title = $translate_results["title"];
								$folder = $rs->row["id"];
								$server1 = $rs->row["server1"];
	
								if ( $pvs_global_settings["prints_previews"] )
								{
									$print_info = pvs_get_print_preview_info( $dr->row["printsid"] );
									if ( $print_info["flag"] )
									{
										$url = pvs_print_url( $dr->row["itemid"], $dr->row["printsid"], $rs->row["title"],
											$print_info["preview"], '' );
									} else
									{
										$url = pvs_item_url( $dr->row["itemid"] );
									}
	
									$preview = pvs_show_print_preview( $rs->row["id"], $dr->row["printsid"] );
								} else
								{
									$url = pvs_item_url( $dr->row["itemid"] );
									$preview = '<a href="' . $url . '"><img src="' . pvs_show_preview( $rs->row["id"],
										"photo", 1, 1, $rs->row["server1"], $rs->row["id"] ) . '"></a>';
								}
							}
	?>
					<tr valign="top"   class='tr_cart'>
					<td><?php
							echo $preview;
	?></td>
					<td><a href="<?php
							echo $url;
	?>"><?php
							echo $title;
	?></a><div class="gr">ID: <?php
							echo $dr->row["itemid"];
	?></div>
					<?php
							foreach ( $prints_mass as $key => $value )
							{
								$sql = "select id_parent from " . PVS_DB_PREFIX . "prints where category=" . $value .
									" and photo=1 order by priority";
								$dd->open( $sql );
								while ( ! $dd->eof )
								{
									$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
										"prints_items where itemid=" . ( int )$dr->row["itemid"] . " and printsid=" . $dd->
										row["id_parent"] . " order by priority";
									$ds->open( $sql );
									if ( ! $ds->eof )
									{
										$chk = "";
										if ( $dq->row["prints_id"] == $ds->row["id_parent"] )
										{
											$chk = "selected";
											echo ( "<b>" . pvs_word_lang( $ds->row["title"] ) . "</b>" );
										}
									}
									$dd->movenext();
								}
							}
							echo ( get_print_options( $dr->row["printsid"], "photo", $dq->row["print_width"],
								$dq->row["print_height"] ) );
	
							$price = pvs_define_prints_price( $dr->row["price"], $dq->row["option1_id"], $dq->
								row["option1_value"], $dq->row["option2_id"], $dq->row["option2_value"], $dq->
								row["option3_id"], $dq->row["option3_value"], $dq->row["option4_id"], $dq->row["option4_value"],
								$dq->row["option5_id"], $dq->row["option5_value"], $dq->row["option6_id"], $dq->
								row["option6_value"], $dq->row["option7_id"], $dq->row["option7_value"], $dq->
								row["option8_id"], $dq->row["option8_value"], $dq->row["option9_id"], $dq->row["option9_value"],
								$dq->row["option10_id"], $dq->row["option10_value"] );?>
					</td>
					<td class='hidden-phone hidden-tablet'><span class="price"><b><?php
							echo pvs_currency( 1 );?><?php
							echo pvs_price_format( $price, 2, true );?> <?php
							echo pvs_currency( 2 );?></b></span>
					
					<?php
							if ( $pvs_global_settings["taxes_cart"] and ( ! $pvs_global_settings["credits"] or
								$pvs_global_settings["credits_currency"] ) )
							{
								$taxes_info = array();
								pvs_order_taxes_calculate( $price, false, "prints" );
	
								if ( $taxes_info["total"] != 0 )
								{
									echo ( "<div><small><b>" . $taxes_info["text"] . ": " . pvs_currency( 1, false ) .
										pvs_price_format( $taxes_info["total"] * $dq->row["quantity"], 2 ) . " " .
										pvs_currency( 2, false ) . "</b></small></div>" );
									$tax_total += $taxes_info["total"] * $dq->row["quantity"];
								}
							}
	?>
					
					
					</td>
					<td>
					<div class="input-group" style="width:110px">
			  <span class="input-group-btn">
				<a href="javascript:cart_change(<?php
							echo $dq->row["id"];
	?>,-1,<?php
							echo $dr->row["in_stock"];
	?>)" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-minus" aria-hidden="true"></i></a>
			  </span>
			  <input id="qty<?php
							echo $dq->row["id"];
	?>" type="text" class="form-control" value="<?php
							echo ( $dq->row["quantity"] );?>" style="padding-left:7px;padding-right:7px">
			  <span class="input-group-btn">
				<a href="javascript:cart_change(<?php
							echo $dq->row["id"];
	?>,1,<?php
							echo $dr->row["in_stock"];
	?>)" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-plus" aria-hidden="true"></i></a>
			  </span>     
					</div>		
					</td>
					<td><i class="fa fa-trash" aria-hidden="true"></i> <a href="#" onClick="cart_delete(<?php
							echo $dq->row["id"];
	?>);"><?php
							echo pvs_word_lang( "delete" );?></a></td>
					</tr>
					<?php
							$total += $price * $dq->row["quantity"];
						}
					} else
					{
						//Printslab items
						$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
							"prints where printslab=1 and id_parent=" . $dq->row["prints_id"];
						$dr->open( $sql );
						if ( ! $dr->eof )
						{
							$sql = "select id,title,photo,id_parent from " . PVS_DB_PREFIX .
								"galleries_photos where id=" . ( int )$dq->row["publication_id"];
							$rs->open( $sql );
							if ( ! $rs->eof )
							{
								$title = $rs->row["title"];
								$url = site_url() . "/printslab-content/?id=" . $rs->row["id_parent"];
								$photo = "/content/galleries/" . $rs->row["id_parent"] . "/thumb" .
									$rs->row["id"] . ".jpg";
	
								if ( file_exists( pvs_upload_dir() . "/content/galleries/" .
									$rs->row["id_parent"] . "/thumb" . $rs->row["id"] . "_2.jpg" ) )
								{
									$photo = "/content/galleries/" . $rs->row["id_parent"] . "/thumb" .
										$rs->row["id"] . "_2.jpg";
								}
	
								if ( $pvs_global_settings["prints_previews"] )
								{
									$preview = pvs_show_print_preview_printslab( $dr->row["id_parent"], $rs->row["title"],
										$url, $photo );
								} else
								{
									$preview = "<a href='" . $url . "'><img src='" . $photo . "'></a>";
								}
							}
	?>
					<tr valign="top"   class='tr_cart'>
					<td><?php
							echo $preview;
	?></td>
					<td><a href="<?php
							echo $url;
	?>"><?php
							echo $title;
	?></a><div class="gr"><?php
							echo pvs_word_lang( "prints lab" );?> ID: <?php
							echo $dq->row["publication_id"];
	?></div>
					<?php
							foreach ( $prints_mass as $key => $value )
							{
								$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
									"prints where printslab=1 and category=" . $value . " order by priority";
								$ds->open( $sql );
								while ( ! $ds->eof )
								{
									$chk = "";
									if ( $dq->row["prints_id"] == $ds->row["id_parent"] )
									{
										$chk = "selected";
										echo ( "<b>" . pvs_word_lang( $ds->row["title"] ) . "</b>" );
									}
									$ds->movenext();
								}
							}
							echo ( get_print_options( $dq->row["prints_id"], "printslab", $dq->row["print_width"],
								$dq->row["print_height"] ) );
	
							$price = pvs_define_prints_price( $dr->row["price"], $dq->row["option1_id"], $dq->
								row["option1_value"], $dq->row["option2_id"], $dq->row["option2_value"], $dq->
								row["option3_id"], $dq->row["option3_value"], $dq->row["option4_id"], $dq->row["option4_value"],
								$dq->row["option5_id"], $dq->row["option5_value"], $dq->row["option6_id"], $dq->
								row["option6_value"], $dq->row["option7_id"], $dq->row["option7_value"], $dq->
								row["option8_id"], $dq->row["option8_value"], $dq->row["option9_id"], $dq->row["option9_value"],
								$dq->row["option10_id"], $dq->row["option10_value"] );?>
					</td>
					<td class='hidden-phone hidden-tablet'><span class="price"><b><?php
							echo pvs_currency( 1 );?><?php
							echo pvs_price_format( $price, 2, true );?> <?php
							echo pvs_currency( 2 );?></b></span>
					
					<?php
							if ( $pvs_global_settings["taxes_cart"] and ( ! $pvs_global_settings["credits"] or
								$pvs_global_settings["credits_currency"] ) )
							{
								$taxes_info = array();
								pvs_order_taxes_calculate( $price, false, "prints" );
	
								if ( $taxes_info["total"] != 0 )
								{
									echo ( "<div><small><b>" . $taxes_info["text"] . ": " . pvs_currency( 1, false ) .
										pvs_price_format( $taxes_info["total"] * $dq->row["quantity"], 2 ) . " " .
										pvs_currency( 2, false ) . "</b></small></div>" );
									$tax_total += $taxes_info["total"] * $dq->row["quantity"];
								}
							}
	?>			
					
					</td>
					<td>
			<div class="input-group" style="width:110px">
			  <span class="input-group-btn">
				<a href="javascript:cart_change(<?php
							echo $dq->row["id"];
	?>,-1,-1)" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-minus" aria-hidden="true"></i></a>
			  </span>
			  <input id="qty<?php
							echo $dq->row["id"];
	?>" type="text" class="form-control" value="<?php
							echo ( $dq->row["quantity"] );?>" style="padding-left:7px;padding-right:7px">
			  <span class="input-group-btn">
				<a href="javascript:cart_change(<?php
							echo $dq->row["id"];
	?>,1,-1)" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-plus" aria-hidden="true"></i></a>
			  </span>     
			</div>
					</td>
					<td><i class="fa fa-trash" aria-hidden="true"></i> <a href="#" onClick="cart_delete(<?php
							echo $dq->row["id"];
	?>);"><?php
							echo pvs_word_lang( "delete" );?></a></td>
					</tr>
					<?php
							$total += $price * $dq->row["quantity"];
						}
					}
				} else
				{
					//Prints stock
					$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
						"prints where id_parent=" . $dq->row["prints_id"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$title = @$mstocks[$dq->row["stock_type"]] . " #" . $dq->row["stock_id"];
						$photo = $dq->row["stock_preview"];
						$print_info_cart = pvs_get_print_preview_info( $dq->row["prints_id"] );
						$url = pvs_print_url( $dq->row["stock_id"], $dr->row["id_parent"], $dr->row["title"],
							$print_info_cart['preview'], $dq->row["stock_type"] );
	
						if ( $pvs_global_settings["prints_previews"] )
						{
							$preview = pvs_show_print_preview_stock( $dr->row["id_parent"], $dr->row["title"],
								$dq->row["stock_type"], $dq->row["stock_id"], $photo );
						} else
						{
							$preview = "<a href='" . $url . "'><img src='" . $photo . "'></a>";
						}
	?>
				<tr valign="top"   class='tr_cart'>
				<td><?php
						echo $preview;
	?></td>
				<td><a href="<?php
						echo $url;
	?>"><?php
						echo $title;
	?></a><br>
				<?php
						foreach ( $prints_mass as $key => $value )
						{
							$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
								"prints where printslab=1 and category=" . $value . " order by priority";
							$ds->open( $sql );
							while ( ! $ds->eof )
							{
								$chk = "";
								if ( $dq->row["prints_id"] == $ds->row["id_parent"] )
								{
									$chk = "selected";
									echo ( "<b>" . pvs_word_lang( $ds->row["title"] ) . "<b>" );
								}
								$ds->movenext();
							}
						}
						echo ( get_print_options( $dq->row["prints_id"], "stock", $dq->row["print_width"],
							$dq->row["print_height"] ) );
	
						$price = pvs_define_prints_price( $dr->row["price"], $dq->row["option1_id"], $dq->
							row["option1_value"], $dq->row["option2_id"], $dq->row["option2_value"], $dq->
							row["option3_id"], $dq->row["option3_value"], $dq->row["option4_id"], $dq->row["option4_value"],
							$dq->row["option5_id"], $dq->row["option5_value"], $dq->row["option6_id"], $dq->
							row["option6_value"], $dq->row["option7_id"], $dq->row["option7_value"], $dq->
							row["option8_id"], $dq->row["option8_value"], $dq->row["option9_id"], $dq->row["option9_value"],
							$dq->row["option10_id"], $dq->row["option10_value"] );?>
				</td>
				<td class='hidden-phone hidden-tablet'><span class="price"><b><?php
						echo pvs_currency( 1 );?><?php
						echo pvs_price_format( $price, 2, true );?> <?php
						echo pvs_currency( 2 );?></b></span>
				
				<?php
						if ( $pvs_global_settings["taxes_cart"] and ( ! $pvs_global_settings["credits"] or
							$pvs_global_settings["credits_currency"] ) )
						{
							$taxes_info = array();
							pvs_order_taxes_calculate( $price, false, "prints" );
	
							if ( $taxes_info["total"] != 0 )
							{
								echo ( "<div><small><b>" . $taxes_info["text"] . ": " . pvs_currency( 1, false ) .
									pvs_price_format( $taxes_info["total"] * $dq->row["quantity"], 2 ) . " " .
									pvs_currency( 2, false ) . "</b></small></div>" );
								$tax_total += $taxes_info["total"] * $dq->row["quantity"];
							}
						}
	?>			
				
				</td>
				<td>
					<div class="input-group" style="width:110px">
					  <span class="input-group-btn">
			<a href="javascript:cart_change(<?php
						echo $dq->row["id"];
	?>,-1,-1)" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-minus" aria-hidden="true"></i></a>
					  </span>
					  <input id="qty<?php
						echo $dq->row["id"];
	?>" type="text" class="form-control" value="<?php
						echo ( $dq->row["quantity"] );?>" style="padding-left:7px;padding-right:7px">
					  <span class="input-group-btn">
			<a href="javascript:cart_change(<?php
						echo $dq->row["id"];
	?>,1,-1)" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-plus" aria-hidden="true"></i></a>
					  </span>     
					</div>
				</td>
				<td><i class="fa fa-trash" aria-hidden="true"></i> <a href="#" onClick="cart_delete(<?php
						echo $dq->row["id"];
	?>);"><?php
						echo pvs_word_lang( "delete" );?></a></td>
				</tr>
				<?php
						$total += $price * $dq->row["quantity"];
					}
				}
			}
		} else {
			//Collection
			$sql = "select id, title, price, description from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . $dq->row["collection"];
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				?>
				<tr valign="top">
					<td>
					<?php
						$collection_result = pvs_show_collection_preview($ds->row["id"]);
					?>
					<a href="<?php echo(pvs_collection_url( $ds->row["id"], $ds->row["title"] ));?>"><img src="<?php echo($collection_result["photo"]);?>" style="max-width:<?php echo($pvs_global_settings["thumb_width"]);?>px;max-height:<?php echo($pvs_global_settings["thumb_width"]);?>px"></a>
					</td>
					<td><a href="<?php echo(pvs_collection_url( $ds->row["id"], $ds->row["title"] ));?>"><?php echo(pvs_word_lang("Collection"));?>: <?php echo($ds->row["title"] . ' (' . pvs_count_files_in_collection($ds->row["id"]) . ')');?></a><br><?php echo($ds->row["description"]);?></td>
					<td>
					<span class="price"><b><?php
						echo pvs_currency( 1 );?><?php
						echo pvs_price_format( $ds->row["price"], 2, true );?> <?php
						echo pvs_currency( 2 );?></b></span>
				
					<?php
						if ( $pvs_global_settings["taxes_cart"] and ( ! $pvs_global_settings["credits"] or
							$pvs_global_settings["credits_currency"] ) )
						{
							$taxes_info = array();
							pvs_order_taxes_calculate( $ds->row["price"], false, "prints" );
	
							if ( $taxes_info["total"] != 0 )
							{
								echo ( "<div><small><b>" . $taxes_info["text"] . ": " . pvs_currency( 1, false ) .
									pvs_price_format( $taxes_info["total"] * $dq->row["quantity"], 2 ) . " " .
									pvs_currency( 2, false ) . "</b></small></div>" );
								$tax_total += $taxes_info["total"] * $dq->row["quantity"];
							}
						}
					?>			
					</td>
					<td><?php echo($dq->row["quantity"]);?></td>
					<td><i class="fa fa-trash" aria-hidden="true"></i> <a href="#" onClick="cart_delete(<?php echo $dq->row["id"]; ?>);"><?php echo pvs_word_lang( "delete" );?></a></td>
				</tr>
				<?php
				$total += $ds->row["price"] * $dq->row["quantity"];
			}
		}
		$quantity += $dq->row["quantity"];
		$dq->movenext();
	}
?>
	<tr class="total">
	<td colspan="6"><b><?php echo pvs_word_lang( "total" );?>:</b> <span class="price"><b><?php echo pvs_currency( 1 );?><?php echo pvs_price_format( $total, 2, true );?> <?php echo pvs_currency( 2 );?></b></span>
	
	<?php
	if ( $pvs_global_settings["taxes_cart"] and ( ! $pvs_global_settings["credits"] or
		$pvs_global_settings["credits_currency"] ) ) {
		if ( $tax_total != 0 ) {
			echo ( "&nbsp;&nbsp;&nbsp;&nbsp;<small><b>" . pvs_word_lang( "taxes" ) . ": " .
				pvs_currency( 1, false ) . pvs_price_format( $tax_total, 2 ) . " " .
				pvs_currency( 2, false ) . "</b></small>" );
		}
	}
?>
	</td>
	</tr>
	</table><input class='isubmit btn' type="button" value="<?php echo pvs_word_lang( "checkout" );?>" onClick="location.href='<?php echo site_url();
?>/checkout/'" style="margin-top:5px;margin-left:10px">&nbsp;&nbsp;&nbsp;<input class='isubmit_orange btn' type="button" value="<?php echo pvs_word_lang( "clear cart" );?>" onClick="cart_clear(<?php echo $cart_id;
?>)" style="margin-top:5px;margin-left:10px">
	<?php
} else
{
	echo ( pvs_word_lang( "empty shopping cart" ) );
}
?>