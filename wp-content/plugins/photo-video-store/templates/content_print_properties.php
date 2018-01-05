<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


$default_js_functions = "";
$prints_content = "";
$price = 0;
$quantity = 1;
$x1 = 0;
$y1 = 0;
$x2 = $default_width;
$y2 = $default_height;
$p_w = $default_width;
$p_h = $default_height;
$options_default = array();
for ( $i = 1; $i < 11; $i++ ) {
	$options_default[$i] = '';
}
$preloaded_frames = "";
$preloaded_tshirts = "";

if ( get_query_var('pvs_page') != 'stockapi' and ! isset( $printslab_flag ) ) {
	$sql = "select id_parent,price,itemid,printsid,in_stock from " . PVS_DB_PREFIX .
		"prints_items where itemid=" . ( int )@$id_parent . " and printsid=" . ( int ) get_query_var('pvs_print_id');
} else {
	if ( ! @$printslab_flag) {
		$sql = "select id_parent,price from " . PVS_DB_PREFIX .
		"prints where id_parent=" . ( int ) get_query_var('pvs_print_id');
	} else {
		$sql = "select id_parent,price from " . PVS_DB_PREFIX .
		"prints where id_parent=" . ( int ) $_GET["print_id"];
	}
}

$dq->open( $sql );
if ( ! $dq->eof ) {
	//Check cart
	$cart_id = pvs_shopping_cart_id();
	$content_id = 0;
	$cart_flag = false;
	if ( get_query_var('pvs_page') != 'stockapi' ) {
		$sql = "select id,x1,y1,x2,y2,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value,quantity from " .
			PVS_DB_PREFIX . "carts_content where id_parent = " . ( int )$cart_id .
			" and publication_id = " . ( int )@$id_parent . " and prints_id = " . $dq->row["id_parent"];
	} else {
		$sql = "select id,x1,y1,x2,y2,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value,quantity from " .
			PVS_DB_PREFIX . "carts_content where id_parent = " . ( int )$cart_id .
			" and publication_id = " . ( int )@$stock_id . " and stock_type = '" . $stock_type .
			"' and prints_id = " . $dq->row["id_parent"];
	}
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$cart_flag = true;
		$prints_content .= "<input type='hidden' name='content_id' value='" . $ds->row["id"] .
			"'>";
		$x1 = $ds->row["x1"];
		$y1 = $ds->row["y1"];
		$x2 = $ds->row["x2"];
		$y2 = $ds->row["y2"];
		$quantity = $ds->row["quantity"];
		$content_id = $ds->row["id"];

		for ( $i = 1; $i < 11; $i++ ) {
			$options_default[$i] = $ds->row["option" . $i . "_value"];
		}
	}

	$prints_content = "<input type='hidden' id='print_x1'  name='print_x1' value='" .
		$x1 . "'><input type='hidden' id='print_y1'  name='print_y1' value='" . $y1 .
		"'><input type='hidden' id='print_x2'  name='print_x2' value='" . $x2 .
		"'><input type='hidden' id='print_y2'  name='print_y2' value='" . $y2 .
		"'><input type='hidden'  name='print_width' value='" . $p_w .
		"'><input type='hidden' name='print_height' value='" . $p_h . "'>";

	$pvs_theme_content[ 'resize_min' ] = $resize_min;
	$pvs_theme_content[ 'resize_max' ] = $resize_max;

	if ( $cart_flag ) {
		$prints_content .= "<input type='hidden' name='content_id' value='" . $content_id .
			"'>";
		if ( $x2 - $x1 != 0 ) {
			$pvs_theme_content[ 'resize_value' ] = round( $iframe_width * $default_width / ( $x2 - $x1 ) );
		} else {
			$pvs_theme_content[ 'resize_value' ] = $resize_value;
		}
	} else {
		$pvs_theme_content[ 'resize_value' ] = $resize_value;
	}

	$prints_content .= "<input type='hidden' name='prints_id' value='" . $dq->row["id_parent"] .
		"'>";
		
	if ( ! @$printslab_flag) {
		$sql = "select price,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
		PVS_DB_PREFIX . "prints where photo=1 and id_parent=" . ( int ) get_query_var('pvs_print_id');
	} else {
		$sql = "select price,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
		PVS_DB_PREFIX . "prints where photo=1 and id_parent=" . ( int ) $_GET["print_id"];	
	}
	$dd->open( $sql );
	if ( ! $dd->eof ) {

		for ( $i = 1; $i < 11; $i++ ) {
			if ( ! $cart_flag )
			{
				$options_default[$i] = $dd->row["option" . $i . "_value"];
			}

			$price = pvs_define_prints_price( $dq->row["price"], $dd->row["option1"], $options_default[1],
				$dd->row["option2"], $options_default[2], $dd->row["option3"], $options_default[3],
				$dd->row["option4"], $options_default[4], $dd->row["option5"], $options_default[5],
				$dd->row["option6"], $options_default[6], $dd->row["option7"], $options_default[7],
				$dd->row["option8"], $options_default[8], $dd->row["option9"], $options_default[9],
				$dd->row["option10"], $options_default[10] );

			if ( ( int )$dd->row["option" . $i] != 0 )
			{
				$sql = "select id,title,type,activ,required,property_name,description from " .
					PVS_DB_PREFIX . "products_options where activ=1 and id=" . $dd->row["option" . $i];
				$dn->open( $sql );
				if ( ! $dn->eof )
				{
					$more_link = "";
					if ( ( int )$dn->row["description"] != 0 )
					{
						$more_link = '<a href="javascript:show_more(\'' . site_url() .
							'/popup/?id=' . $dn->row["description"] . '\')"><i class="fa fa-question-circle" aria-hidden="true"></i></a>';
					}

					$prints_content .= "<h4 style='margin:20px 0px 3px 0px;padding:0px'>" .
						pvs_word_lang( $dn->row["title"] ) . ": " . $more_link . "</h4>";

					$default_js_functions .= "change_option('" . $dn->row["property_name"] . "','" .
						$options_default[$i] . "');";

					if ( $dn->row["type"] == "colorpicker" )
					{
						$prints_content .= "<div id='colorpicker" . $dn->row["id"] .
							"' class='color_selector'><div style='background-color: " . $options_default[$i] .
							"'></div></div>";

						$prints_content .= "<script>
			$(document).ready(function() {
			$('#colorpicker" . $dn->row["id"] . "').ColorPicker({
				color: '" . $options_default[$i] . "',
				onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
				},
				onHide: function (colpkr,hex) {
		$(colpkr).fadeOut(500);
		return false;		
				},
				onChange: function (hsb, hex, rgb) {
		$('#colorpicker" . $dn->row["id"] .
							" div').css('backgroundColor', '#' + hex);
		$('#property" . $i . "').val('#' + hex);
		change_option('" . $dn->row["property_name"] . "','#' + hex);
		change_price();
				}
			});});</script><input type='hidden' id='property" . $i .
							"'  name='property" . $i . "' class='property_" . $dn->row["property_name"] .
							"' value='" . $dd->row["option" . $i . "_value"] . "'>";
					}

					if ( $dn->row["type"] == "selectform" )
					{
						$prints_content .= "<select name='property" . $i . "' onChange=\"change_option('" .
							$dn->row["property_name"] . "',this.value);change_price();\" class='ibox form-control property_" .
							$dn->row["property_name"] . "' style='width:300px'>";
					}

					if ( $dn->row["type"] == "colors" or $dn->row["type"] == "frame" or $dn->row["type"] ==
						"background" )
					{
						$prints_content .= "<div class='clearfix'>";
					}

					$sel = "selected";
					$sel2 = "checked";
					$sel3 = "";

					if ( $dn->row["type"] != "colorpicker" )
					{
						$sql = "select id,title,price,adjust,property_value from " . PVS_DB_PREFIX .
							"products_options_items where id_parent=" . $dd->row["option" . $i] .
							" order by id";
						$ds->open( $sql );
						while ( ! $ds->eof )
						{
							$property_value = pvs_word_lang( $ds->row["title"] );

							$flag_show = true;

							$sel = "";
							$sel2 = "";

							//Print size
							if ( $dn->row["property_name"] == "print_size" )
							{
								$value_array = explode( "cm", $property_value );
								if ( count( $value_array ) == 2 and $photo_size != 0 )
								{
									$property_value = $value_array[0];
									$property_value = round( $property_value * $default_width / $photo_size ) .
										"cm x " . round( $property_value * $default_height / $photo_size ) . "cm";
								}

								$value_array = explode( 'in', $property_value );
								if ( count( $value_array ) == 2 and $photo_size != 0 )
								{
									$property_value = $value_array[0];
									$property_value = round( $property_value * $default_width / $photo_size ) .
										'" x ' . round( $property_value * $default_height / $photo_size ) . '"';
								}

								if ( $photo_size < $ds->row["property_value"] )
								{
									$flag_show = false;
								}
							}
							//End. Print size

							if ( $flag_show )
							{
								if ( $dn->row["type"] == "selectform" )
								{
									if ( $ds->row["title"] == $options_default[$i] )
									{
										$sel = "selected";
									}

									$prints_content .= "<option value='" . $ds->row["title"] . "' " . $sel . ">" . $property_value .
										"</option>";
								}
								if ( $dn->row["type"] == "radio" )
								{
									if ( $ds->row["title"] == $options_default[$i] )
									{
										$sel2 = "checked";
									}

									$prints_content .= "<p><input class='property_" . $dn->row["property_name"] .
										"' onClick=\"change_option('" . $dn->row["property_name"] .
										"',this.value);change_price();\"  name='property" . $i .
										"' type='radio' value='" . $ds->row["title"] . "' " . $sel2 . ">&nbsp;" . $property_value .
										"&nbsp;&nbsp;</p>";
								}
								if ( $dn->row["type"] == "colors" )
								{
									if ( $ds->row["title"] == $options_default[$i] )
									{
										$sel3 = "2";
									}

									$prints_content .= "<div id='color_" . $i . "_" . $ds->row["id"] .
										"' style='background-color:" . $ds->row["title"] . "' class='prints_colors" . $sel3 .
										"' onClick=\"change_color('" . $ds->row["title"] . "'," . $i . "," . $ds->row["id"] .
										",'" . $dn->row["property_name"] . "');change_price();\">&nbsp;</div>";
								}
								if ( $dn->row["type"] == "frame" )
								{
									if ( $ds->row["title"] == $options_default[$i] )
									{
										$sel3 = "2";
									}

									$prints_content .= "<div id='frame_" . $i . "_" . $ds->row["id"] .
										"' style='background:url(" . pvs_plugins_url() . "/includes/prints/images/" . $ds->row["title"] .
										".jpg)' class='prints_frame" . $sel3 . "' onClick=\"change_frame('" . $ds->row["title"] .
										"'," . $i . "," . $ds->row["id"] . ",'" . $dn->row["property_name"] . "','" . $ds->
										row["property_value"] . "');change_price();\">&nbsp;<input type='hidden' id='frame_" .
										$ds->row["title"] . "_width' value='" . $ds->row["property_value"] . "'></div>";

									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_top_left.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_top_center.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_top_right.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_center_left.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_center_right.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_bottom_left.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_bottom_center.jpg');";
									$preloaded_frames .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "_bottom_right.jpg');";
								}
								if ( $dn->row["type"] == "background" )
								{
									if ( $ds->row["title"] == $options_default[$i] )
									{
										$sel3 = "2";
									}

									$prints_content .= "<div id='background_" . $i . "_" . $ds->row["id"] .
										"' style='background:url(" . pvs_plugins_url() . "/includes/prints/images/" . $ds->row["title"] .
										");background-position: center center;' class='prints_background" . $sel3 .
										"' onClick=\"change_background('" . $ds->row["title"] . "'," . $i . "," . $ds->
										row["id"] . ",'" . $dn->row["property_name"] . "','" . $ds->row["property_value"] .
										"');change_price();\"></div>";

									$preloaded_tshirts .= "\$.preloadImages('" . pvs_plugins_url() .
										"/includes/prints/images/" . $ds->row["title"] . "');";
								}
							}

							$ds->movenext();
						}
					}

					if ( $dn->row["type"] == "selectform" )
					{
						$prints_content .= "</select>";
					}

					if ( $dn->row["type"] == "colors" or $dn->row["type"] == "frame" or $dn->row["type"] ==
						"background" )
					{
						$prints_content .= "</div><input type='hidden' id='property" . $i .
							"'  name='property" . $i . "' class='property_" . $dn->row["property_name"] .
							"' value='" . $options_default[$i] . "'>";
					}
				}
			}
		}
	}
}

if ( @$cart_flag ) {
	$default_js_functions .= "show_print_cart_default();";
} else
{
	$default_js_functions .= "show_print_default();";
}

//Quantity
$in_stock = -1;
$in_stock_text = "";
if ( isset( $dq->row["in_stock"] ) ) {
	$in_stock = $dq->row["in_stock"];

	if ( $dq->row["in_stock"] == -1 ) {
		$in_stock_text = pvs_word_lang( "In stock" );
	} elseif ( $dq->row["in_stock"] == 0 ) {
		$in_stock_text = '<font style="color:red">' . pvs_word_lang( "Not in stock" ) .
			'</font><script>$(document).ready(function() {$(".add_to_cart").css("display","none")});</script>';
	} else {
		if ( $pvs_global_settings["show_in_stock"] ) {
			$in_stock_text = pvs_word_lang( "In stock" ) . ": <b>" . $dq->row["in_stock"] .
				"</b>";
		} else {
			$in_stock_text = pvs_word_lang( "In stock" );
		}
	}
}

$prints_content .= "<h4 style='margin:20px 0px 3px 0px;padding:0px'>" .
	pvs_word_lang( "quantity" ) . ":</h4>";
if ( $in_stock != 0 ) {
	$prints_content .= '<div class="input-group" style="width:110px">
				  <span class="input-group-btn">
		<a href="javascript:quantity_change(-1,' . $in_stock .
		')" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-minus" aria-hidden="true"></i></a>
				  </span>
				  <input id="quantity"  name="quantity" type="text" class="form-control" value="' .
		$quantity . '" style="padding-left:7px;padding-right:7px">
				  <span class="input-group-btn">
		<a href="javascript:quantity_change(1,' . $in_stock .
		')" class="btn btn-default" style="padding-left:10px;padding-right:10px"><i class="fa fa-plus" aria-hidden="true"></i></a>
				  </span>     
				</div><div style="margin-top:5px">' . $in_stock_text . '</div>';
} else
{
	$prints_content .= $in_stock_text;
}

$pvs_theme_content[ 'properties' ] = $prints_content;
$pvs_theme_content[ 'preloaded_frames' ] = $preloaded_frames;
$pvs_theme_content[ 'preloaded_tshirts' ] = $preloaded_tshirts;
$pvs_theme_content[ 'default_js_functions' ] = $default_js_functions;
$pvs_theme_content[ 'price' ] = pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) . ' ' . pvs_currency( 2 );

if ( @$cart_flag ) {
	$pvs_theme_content[ 'add_to_cart' ] = pvs_word_lang( "in your cart" );
} else
{
	$pvs_theme_content[ 'add_to_cart' ] = pvs_word_lang( "add to cart" );
}
?>