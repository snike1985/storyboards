<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$title = "";
$price = "";
$publication_title = "";
$prints_options = array();
$redirect_url = "";

for ( $i = 1; $i < 11; $i++ ) {
	$params["option" . $i . "_id"] = 0;
	$params["option" . $i . "_value"] = "";
}

if ( ( int )@$_REQUEST['id'] > 0 ) {
	//Files
	$params["item_id"] = ( int )@$_REQUEST['id'];
	$params["prints_id"] = 0;

	$sql = "select id_parent,name,price from " . PVS_DB_PREFIX . "items where id=" .
		$params["item_id"];
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$params["publication_id"] = $dr->row["id_parent"];
		$title = pvs_word_lang( $dr->row["name"] );
		$price = $dr->row["price"];
	}
} else
{
	//Prints
	$params["prints_id"] = -1 * @$_REQUEST['id'];
	$params["item_id"] = 0;

	$sql = "select itemid,title,price,printsid from " . PVS_DB_PREFIX .
		"prints_items where id_parent=" . $params["prints_id"];
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$params["publication_id"] = $dr->row["itemid"];
		$title = pvs_word_lang( $dr->row["title"] );

		$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
			PVS_DB_PREFIX . "prints where id_parent=" . $dr->row["printsid"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$sql = "select title from " . PVS_DB_PREFIX . "media where id=" . $dr->row["itemid"];
			$dd->open( $sql );
			if ( ! $dd->eof )
			{
				$print_info = pvs_get_print_preview_info( $dr->row["printsid"] );
				$redirect_url = pvs_print_url( $dr->row["itemid"], $dr->row["printsid"], $dd->
					row["title"], $print_info["preview"], 'site' );
			}

			$price = pvs_define_prints_price( $dr->row["price"], $ds->row["option1"], $ds->
				row["option1_value"], $ds->row["option2"], $ds->row["option2_value"], $ds->row["option3"],
				$ds->row["option3_value"], $ds->row["option4"], $ds->row["option4_value"], $ds->
				row["option5"], $ds->row["option5_value"], $ds->row["option6"], $ds->row["option6_value"],
				$ds->row["option7"], $ds->row["option7_value"], $ds->row["option8"], $ds->row["option8_value"],
				$ds->row["option9"], $ds->row["option9_value"], $ds->row["option10"], $ds->row["option10_value"] );

			$prints_content = "";

			for ( $i = 1; $i < 11; $i++ )
			{
				$prints_options[] = ( int )$ds->row["option" . $i];
				$params["option" . $i . "_id"] = ( int )$ds->row["option" . $i];
				$params["option" . $i . "_value"] = $ds->row["option" . $i . "_value"];

				if ( ( int )$ds->row["option" . $i] != 0 )
				{
					$sql = "select id,title,type,activ,required,property_name from " . PVS_DB_PREFIX .
						"products_options where activ=1 and id=" . $ds->row["option" . $i];
					$dn->open( $sql );
					if ( ! $dn->eof )
					{
						$prints_content .= "<div class='param'><b>" . pvs_word_lang( $dn->row["title"] ) .
							":</b><br>";

						if ( $dn->row["type"] == "colorpicker" )
						{
							$prints_content .= "<div id='colorpicker" . $dn->row["id"] .
								"' class='color_selector'><div style='background-color: " . $ds->row["option" .
								$i . "_value"] . "'></div></div>";

							$prints_content .= "<script>
				$(document).ready(function() {
				$('#colorpicker" . $dn->row["id"] . "').ColorPicker({
		color: '" . $ds->row["option" . $i . "_value"] . "',
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
		}
				});});</script><input type='hidden' id='property" . $i .
								"'  name='option" . $i . "' value='" . $ds->row["option" . $i . "_value"] . "'>";
						}

						if ( $dn->row["type"] == "selectform" )
						{
							$prints_content .= "<select name='option" . $i .
								"' class='ibox form-control'  style='width:300px'>";
						}

						if ( $dn->row["type"] == "colors" )
						{
							$prints_content .= "<div class='clearfix'>";
						}

						$sel = "selected";
						$sel2 = "checked";
						$sel3 = "";

						if ( $dn->row["type"] != "colorpicker" )
						{
							$sql = "select id,title,price,adjust,property_value from " . PVS_DB_PREFIX .
								"products_options_items where id_parent=" . $ds->row["option" . $i] .
								" order by id";
							$dd->open( $sql );
							while ( ! $dd->eof )
							{
								$property_value = $dd->row["title"];

								$sel = "";
								$sel2 = "";

								if ( $dn->row["type"] == "selectform" )
								{
									if ( $dd->row["title"] == $ds->row["option" . $i . "_value"] )
									{
										$sel = "selected";
									}

									$prints_content .= "<option value='" . $dd->row["title"] . "' " . $sel . ">" .
										pvs_word_lang( $property_value ) . "</option>";
								}
								if ( $dn->row["type"] == "radio" )
								{
									if ( $dd->row["title"] == $ds->row["option" . $i . "_value"] )
									{
										$sel2 = "checked";
									}

									$prints_content .= "<p><input name='option" . $i . "' type='radio' value='" . $dd->
										row["title"] . "' " . $sel2 . ">&nbsp;" . pvs_word_lang( $property_value ) .
										"&nbsp;&nbsp;</p>";
								}
								if ( $dn->row["type"] == "colors" )
								{
									if ( $dd->row["title"] == $ds->row["option" . $i . "_value"] )
									{
										$sel3 = "2";
									}

									$prints_content .= "<div id='color_" . $i . "_" . $dd->row["id"] .
										"' style='background-color:" . $dd->row["title"] . "' class='prints_colors" . $sel3 .
										"' onClick=\"change_color('" . $dd->row["title"] . "'," . $i . "," . $dd->row["id"] .
										")\">&nbsp;</div>";
								}

								$dd->movenext();
							}
						}

						if ( $dn->row["type"] == "selectform" )
						{
							$prints_content .= "</select>";
						}

						if ( $dn->row["type"] == "colors" )
						{
							$prints_content .= "</div><input type='hidden' id='property" . $i .
								"'  name='option" . $i . "' value='" . $ds->row["option" . $i . "_value"] . "'>";
						}

						$prints_content .= "</div>";
					}
				}
			}
		}
	}
}

$sql = "select title from " . PVS_DB_PREFIX . "media where id=" . $params["publication_id"];
$dr->open( $sql );
if ( ! $dr->eof ) {
	$translate_results = pvs_translate_publication( $params["publication_id"], $dr->
		row["title"], "", "" );
	$publication_title = $translate_results["title"];
}

$params["quantity"] = 1;

$cart_id = pvs_shopping_cart_add( $params );


//Show thumb
$size_result = pvs_define_thumb_size( $params["publication_id"] );



$sql = "select id from " . PVS_DB_PREFIX . "carts_content where id_parent=" . $cart_id .
	" and item_id=" . $params["item_id"] . " and prints_id=" . $params["prints_id"];
$ds->open( $sql );
$sql2 = $sql;
if ( ! $ds->eof ) {
	$content_id = $ds->row["id"];
}	else {
	$content_id = '';
}



$cart_content = '<form id="cart_form" style="margin:0px" enctype="multipart/form-data">
<div id="lightbox_header">
	' . pvs_word_lang("The item has been added to the cart") . '
</div>
	
<div id="lightbox_content">
	<table border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
			<img src="' . $size_result["thumb"] . '" width="' . $size_result["width"] . '" height="' . $size_result["height"] . '" style="width:' . $size_result["width"] . 'px;height:' . $size_result["height"] . 'px">
	</td>
	<td style="padding-left:15px">
		<h2>' . $publication_title . ' &mdash; #' . $params["publication_id"] . '</h2>
		<div class="param"><b>' . pvs_word_lang("Type") . ':</b> ' . $title . '</div>
		<div class="param"><b>' . pvs_word_lang("price") . ':</b> <span class="price">' . pvs_currency( 1 ) . pvs_price_format( $price,
	2 ) . " " . pvs_currency( 2 ) . '</span></div>
		' . @$prints_content . '
	</td>
	</tr>
	</table>
</div>

<div id="lightbox_footer">
	<input type="hidden" name="item_id" value="' . $params["item_id"] . '">
	<input type="hidden" name="prints_id" value="' . $params["prints_id"] . '">
	<input type="hidden" name="content_id" value="' . $content_id . '">
	<input type="button" value="' . pvs_word_lang("Checkout") . '" class="lightbox_button2" onClick="pvs_shopping_cart_add(\'' . site_url() . '/\',1)">
	<input type="button" value="' . pvs_word_lang("Continue shopping") . '" class="lightbox_button" onClick="pvs_shopping_cart_add(\'' . site_url() . '/\',0)">
</div>
</form>';

include ( "shopping_cart_add_content.php" );
$GLOBALS['_RESULT'] = array(
	"box_shopping_cart" => $box_shopping_cart,
	"box_shopping_cart_lite" => $box_shopping_cart_lite,
	"cart_content" => $cart_content,
	"redirect_url" => $redirect_url );

?>