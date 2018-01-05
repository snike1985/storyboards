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

$params["stock"] = 1;
$params["stock_type"] = pvs_result( $_REQUEST["stock_type"] );
$params["stock_id"] = ( int )$_REQUEST["stock_id"];
$params["stock_url"] = pvs_result( $_REQUEST["stock_url"] );
$params["stock_preview"] = pvs_result( $_REQUEST["stock_preview"] );
$params["stock_site_url"] = pvs_result( $_REQUEST["stock_site_url"] );

//Prints
$sql = "select id_parent,title,price,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,preview from " .
	PVS_DB_PREFIX . "prints where id_parent=" . ( int )$_REQUEST["print_id"];
$dr->open( $sql );
if ( ! $dr->eof ) {
	$params["prints_id"] = $dr->row["id_parent"];
	$title = $dr->row["title"];
	$price = $dr->row["price"];

	for ( $i = 1; $i < 11; $i++ ) {
		$prints_options[] = ( int )$dr->row["option" . $i];
	}
	$print_info = pvs_get_print_preview_info( ( int )$_REQUEST["print_id"] );
	$redirect_url = pvs_print_url( ( int )$_REQUEST["stock_id"], ( int )$_REQUEST["print_id"],
		pvs_result( $_REQUEST["stock_title"] ), $print_info["preview"], pvs_result( $_REQUEST["stock_type"] ) );
}

$params["item_id"] = 0;
$params["publication_id"] = $params["stock_id"];
$publication_title = @$mstocks[$params["stock_type"]];

$params["quantity"] = 1;

for ( $i = 1; $i < 11; $i++ ) {
	$params["option" . $i . "_id"] = 0;
	$params["option" . $i . "_value"] = "";
}

$cart_id = pvs_shopping_cart_add( $params );

$prints_content = "";
for ( $i = 0; $i < count( $prints_options ); $i++ ) {
	if ( $prints_options[$i] != 0 ) {
		//Default meaning
		$option_default = "";
		$sql = "select option" . ( $i + 1 ) . "_value from " . PVS_DB_PREFIX .
			"carts_content where id_parent=" . $cart_id . " and prints_id=" . $params["prints_id"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$option_default = $ds->row["option" . ( $i + 1 ) . "_value"];
		}

		$sql = "select title,type,activ,required from " . PVS_DB_PREFIX .
			"products_options where activ=1 and id=" . $prints_options[$i];
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$prints_content .= "<div class='param'><b>" . $dr->row["title"] . ":</b><br>";

			if ( $dr->row["type"] == "selectform" )
			{
				$prints_content .= "<select name='option" . $prints_options[$i] .
					"' style='width:150px'>";
			}

			$sql = "select id,title,price,adjust from " . PVS_DB_PREFIX .
				"products_options_items where id_parent=" . $prints_options[$i] . " order by id";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				$sel = "";
				$sel2 = "";

				if ( $option_default == $ds->row["title"] )
				{
					$sel = "selected";
				}
				$sel2 = "checked";

				if ( $dr->row["type"] == "selectform" )
				{
					$prints_content .= "<option value='" . $ds->row["title"] . "' " . $sel . ">" . $ds->
						row["title"] . "</option>";
				}
				if ( $dr->row["type"] == "radio" )
				{
					$prints_content .= "<input name='option" . $prints_options[$i] .
						"' type='radio' value='" . $ds->row["title"] . "' " . $sel2 . ">&nbsp;" . $ds->
						row["title"] . "&nbsp;&nbsp;";
				}

				$ds->movenext();
			}

			if ( $dr->row["type"] == "selectform" )
			{
				$prints_content .= "</select>";
			}

			$prints_content .= "</div>";
		}
	}
}

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
			<img src="' . $params["stock_preview"] . '" style="width:100px;">
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