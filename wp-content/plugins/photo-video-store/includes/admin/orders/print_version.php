<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );
?>

<?php
$sql = "select * from " . PVS_DB_PREFIX . "orders where id=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {

	$method = "";
	if ( $pvs_global_settings["credits_currency"] ) {
		if ( $rs->row["credits"] == 1 ) {
			$method = "credits";
		} else {
			$method = "currency";
		}
	}
?>
	<html>
	<head>
	<title><?php echo pvs_word_lang( "order" )?> #<?php echo ( int )$_GET["id"] ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="container">
	<h1><?php echo pvs_word_lang( "order" )?> #<?php echo ( int )$_GET["id"] ?></h1>

	<table class="table table-striped" style="margin-bottom:30px">
		
		<tr>
			<th colspan="2"><b><?php echo pvs_word_lang( "order details" )?></b></th>
		</tr>
		<tr>
			<td width="20%"><b><?php echo pvs_word_lang( "date" )?>:</b></td>
			<td><?php echo date( date_format, $rs->row["data"] )?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "status" )?>:</b></td>
			<td><?php
	if ( $rs->row["status"] == 1 ) {
		echo ( pvs_word_lang( "approved" ) );
	} else {
		echo ( pvs_word_lang( "pending" ) );
	}
?>&nbsp;
			</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "shipping" )?>:</b></td>
			<td>
			<?php
	if ( $rs->row["shipping"] * 1 != 0 ) {
?>
				<?php
		if ( $rs->row["shipped"] == 1 ) {
			echo ( pvs_word_lang( "shipped" ) );
		} else {
			echo ( pvs_word_lang( "not shipped" ) );
		}
?>
				<?php
	} else {
		echo ( pvs_word_lang( "digital" ) );
	}
?>
			&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "subtotal" )?>:</b></td>
			<td><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["subtotal"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?>&nbsp;</td>
		</tr>
	<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "discount" )?>:</b></td>
			<td> <?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["discount"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?>&nbsp;</td>
		</tr>
	<?php
	}
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "shipping" )?>:</b></td>
			<td><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["shipping"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?>&nbsp;</td>
		</tr>
	<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
		if ( $rs->row["credits"] != 1 ) {
?>
			<tr>
				<td><b><?php
			echo pvs_word_lang( "taxes" )?>:</b></td>
				<td><?php
			echo pvs_currency( 1, true, $method );
?><?php
			echo pvs_price_format( $rs->row["tax"], 2 )?> <?php
			echo pvs_currency( 2, true, $method );
?></td>
			</tr>
		<?php
		} else {
?>
			<tr>
				<td><b><?php
			echo pvs_word_lang( "taxes" )?>:</b></td>
				<td>&mdash;</td>
			</tr>
		<?php
		}
	}
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "total" )?>:</b></td>
			<td><span class="price"><b><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["total"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></b></span>&nbsp;</td>
		</tr>
		</table>


		<table class="table table-striped" style="margin-bottom:30px">
		
		<tr>
			<td colspan="2"><b><?php echo pvs_word_lang( "billing address" )?></b></td>
		</tr>
		<tr>
			<td width="20%"><b><?php echo pvs_word_lang( "name" )?>:</b></td>
			<td><?php echo $rs->row["billing_firstname"] . " " . $rs->row["billing_lastname"] ?>&nbsp;</td>
		</tr>
		<tr valign="top">
			<td><b><?php echo pvs_word_lang( "address" )?>:</b></td>
			<td><?php echo str_replace( "\n", "<br>", $rs->row["billing_address"] )?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "city" )?>:</b></td>
			<td><?php echo $rs->row["billing_city"] ?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "state" )?>:</b></td>
			<td><?php echo $rs->row["billing_state"] ?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "zipcode" )?>:</b></td>
			<td><?php echo $rs->row["billing_zip"] ?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "country" )?>:</b></td>
			<td><?php echo $rs->row["billing_country"] ?>&nbsp;</td>
		</tr>
		
		
		
		
		</table>



		<table class="table table-striped" style="margin-bottom:30px">
		
		<tr>
			<td colspan="2"><b><?php echo pvs_word_lang( "shipping address" )?></b></td>
		</tr>
		<tr>
			<td width="20%"><b><?php echo pvs_word_lang( "name" )?>:</b></td>
			<td><?php echo $rs->row["shipping_firstname"] . " " . $rs->row["shipping_lastname"] ?>&nbsp;</td>
		</tr>
		<tr valign="top">
			<td><b><?php echo pvs_word_lang( "address" )?>:</b></td>
			<td><?php echo str_replace( "\n", "<br>", $rs->row["shipping_address"] )?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "city" )?>:</b></td>
			<td><?php echo $rs->row["shipping_city"] ?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "state" )?>:</b></td>
			<td><?php echo $rs->row["shipping_state"] ?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "zipcode" )?>:</b></td>
			<td><?php echo $rs->row["shipping_zip"] ?>&nbsp;</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "country" )?>:</b></td>
			<td><?php echo $rs->row["shipping_country"] ?>&nbsp;</td>
		</tr>
		
		
		
		
		</table>

	<?php echo( pvs_get_order_content( $rs->row["id"], "user", $method ) );
?>
</div>

</body>
</html>


<?php
	
}
?>