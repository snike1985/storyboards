<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>
<?php
$product_name = "";
$product_total = 0;

if ( $_SESSION["billing_type"] == "credits" ) {
	$sql = "select price,title,days from " . PVS_DB_PREFIX .
		"credits where id_parent=" . ( int )$_SESSION["billing_id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$product_name = $rs->row["title"];
		$product_total = $rs->row["price"];
	}
}

if ( $_SESSION["billing_type"] == "subscription" ) {
	$sql = "select price,title from " . PVS_DB_PREFIX .
		"subscription where id_parent=" . ( int )$_SESSION["billing_id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$product_name = $rs->row["title"];
		$product_total = $rs->row["price"];
	}
}

$product_subtotal = $product_total;
$product_discount = 0;
$product_shipping = 0;
$product_tax = 0;

//Taxes
$taxes_info = array();
pvs_order_taxes_calculate( $product_subtotal, false, $_SESSION["billing_type"] );
$taxes_text = "(" . $taxes_info["text"] . ")";
$product_tax = $taxes_info["total"];

//Discount
$discount_text = "";
if ( isset( $_SESSION["coupon_code"] ) ) {
	$discount_info = array();
	pvs_order_discount_calculate( $_SESSION["coupon_code"], $product_subtotal );
	$product_discount = $discount_info["total"];
	$discount_text = $discount_info["text"];
}

$product_total = $product_subtotal + $product_shipping + $product_tax * $taxes_info["included"] -
	$product_discount;

$_SESSION["product_total"] = $product_total;
$_SESSION["product_subtotal"] = $product_subtotal;
$_SESSION["product_tax"] = $product_tax;
$_SESSION["product_discount"] = $product_discount;
?>




<table border='0' cellpadding='0' cellspacing='0' class='profile_table' width='100%'>
<tr>
<th width='50%'><b><?php echo pvs_word_lang( "Items" )?></b></th>
<th><b><?php echo pvs_word_lang( "quantity" )?></b></th>
<th><b><?php echo pvs_word_lang( "price" )?></b></th>
<th><b><?php echo pvs_word_lang( "total" )?></b></th>
</tr>


<tr>
<td><b><?php echo $product_name
?></b></td>
<td>1</td>
<td><?php echo pvs_currency( 1, false ) . pvs_price_format( $product_subtotal, 2 ) . " " .
	pvs_currency( 2, false )?></td>
<td><?php echo pvs_currency( 1, false ) . pvs_price_format( $product_subtotal, 2 ) . " " .
	pvs_currency( 2, false )?></td>
</tr>

<tr>
	<td><b><?php echo pvs_word_lang( "subtotal" )?></b></td>
	<td></td>
	<td></td>
	<td><?php echo pvs_currency( 1, false ) . pvs_price_format( $product_subtotal, 2 ) . " " .
	pvs_currency( 2, false )?></td>
	</tr>
	<tr>
	<td><b><?php echo pvs_word_lang( "discount" ) . $discount_text
?></b></td>
	<td></td>
	<td></td>
	<td><?php echo pvs_currency( 1, false ) . pvs_price_format( $product_discount, 2 ) . " " .
	pvs_currency( 2, false )?></td>
	</tr>
	<tr>
	<td><b><?php echo pvs_word_lang( "taxes" )?> <?php echo $taxes_text
?></b></td>
	<td></td>
	<td></td>
	<td><?php echo pvs_currency( 1, false ) . pvs_price_format( $product_tax, 2 ) . " " .
	pvs_currency( 2, false )?></td>
	</tr>
	<tr class="snd">
	<td><b><?php echo pvs_word_lang( "total" )?></b></td>
	<td></td>
	<td></td>
	<td><?php echo pvs_currency( 1, false ) . pvs_price_format( $product_total, 2 ) . " " .
	pvs_currency( 2, false )?></td>
	</tr>

	</tr>
	</table>