<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "orders_orders" );

?>
<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">

<div class="back"><a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>" class="btn btn-mini btn-default"><i class="icon-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>


<a class="btn btn-success toright" href="<?php echo (site_url( ) );?>/orders-print-version/?id=<?php echo $_GET["id"] ?>"><i class="icon-print icon-white fa fa-print"></i>&nbsp; <?php echo pvs_word_lang( "print version" )?></a>


<h1><?php echo pvs_word_lang( "order" )?> #<?php echo $_GET["id"] ?></h1>



<script>

function pvs_order_status(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_order_status&id=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+value).innerHTML =data;
		}
	});
}

function pvs_order_shipping_status(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_order_shipping_status&id=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('shipping'+value).innerHTML =data;
		}
	});
}

</script>












<?php
$sql = "select * from " . PVS_DB_PREFIX . "orders where id=" . ( int )$_GET["id"] .
	" order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$cl = "success";
	if ( $rs->row["status"] != 1 ) {
		$cl = "danger";
	}

	$cl2 = "info";
	if ( $rs->row["shipped"] != 1 ) {
		$cl2 = "warning";
	}

	$method = "";
	if ( $pvs_global_settings["credits_currency"] ) {
		if ( $rs->row["credits"] == 1 ) {
			$method = "credits";
		} else {
			$method = "currency";
		}
	}
?>

	<div class="row-fluid" style="margin:20px 0px 20px 0px">
		<div class="span4 col-md-4 nopadding" style="padding:0px 5px 0px 0px">

		<div class="table_t" style="display:block"><div class="table_b"><div class="table_l"><div class="table_r"><div class="table_bl"><div class="table_br"><div class="table_tl"><div class="table_tr" style="height:<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["credits_currency"] ) {
		echo ( 320 );
	} else {
		echo ( 390 );
	}
?>px;">

		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:90%">
		
		<tr>
			<th colspan="2"><?php echo pvs_word_lang( "order details" )?></th>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "date" )?>:</b></td>
			<td><div class="link_date"><?php echo date( date_format, $rs->row["data"] )?></div></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "status" )?>:</b></td>
			<td><div id="status<?php echo $rs->row["id"] ?>" name="status<?php echo $rs->row["id"] ?>"><a href="javascript:pvs_order_status(<?php echo $rs->row["id"] ?>);"><span class='label label-<?php echo $cl
?>'><?php
	if ( $rs->row["status"] == 1 ) {
		echo ( pvs_word_lang( "approved" ) );
	} else {
		echo ( pvs_word_lang( "pending" ) );
	}
?></span></a></div>
			</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "shipping" )?>:</b></td>
			<td>
				<?php
	if ( $rs->row["shipping"] * 1 != 0 ) {
?>
						<div id="shipping<?php echo $rs->row["id"] ?>" name="status<?php echo $rs->row["id"] ?>"><a href="javascript:pvs_order_shipping_status(<?php echo $rs->row["id"] ?>);"><span class='label label-<?php echo $cl2
?>'><?php
		if ( $rs->row["shipped"] == 1 ) {
			echo ( pvs_word_lang( "shipped" ) );
		} else {
			echo ( pvs_word_lang( "not shipped" ) );
		}
?></span></a></div>
						<?php
	} else {
		echo ( "<span class='label label-default'>" . pvs_word_lang( "digital" ) .
			"</span>" );
	}
?>
			</td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "subtotal" )?>:</b></td>
			<td><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["subtotal"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></td>
		</tr>
	<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "discount" )?>:</b></td>
			<td> <?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["discount"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></td>
		</tr>
	<?php
	}
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "shipping" )?>:</b></td>
			<td><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["shipping"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></td>
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
?></b></span></td>
		</tr>
	</table>
	</div></div></div></div></div></div></div></div>

	</div>
	<div class="span4 col-md-4 nopadding" style="padding:0px 5px 0px 5px">

	<div class="table_t" style="display:block"><div class="table_b"><div class="table_l"><div class="table_r"><div class="table_bl"><div class="table_br"><div class="table_tl"><div class="table_tr" style="height:<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["credits_currency"] ) {
		echo ( 320 );
	} else {
		echo ( 390 );
	}
?>px">

	<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:90%">
		
		<tr>
			<th colspan="2"><?php echo pvs_word_lang( "billing address" )?></th>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "name" )?>:</b></td>
			<td><?php echo $rs->row["billing_firstname"] . " " . $rs->row["billing_lastname"] ?></td>
		</tr>
		<tr valign="top">
			<td><b><?php echo pvs_word_lang( "address" )?>:</b></td>
			<td><?php echo str_replace( "\n", "<br>", $rs->row["billing_address"] )?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "city" )?>:</b></td>
			<td><?php echo $rs->row["billing_city"] ?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "state" )?>:</b></td>
			<td><?php echo $rs->row["billing_state"] ?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "zipcode" )?>:</b></td>
			<td><?php echo $rs->row["billing_zip"] ?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "country" )?>:</b></td>
			<td><?php echo $rs->row["billing_country"] ?></td>
		</tr>
		
		
		

	</table>
	</div></div></div></div></div></div></div></div>


	</div>
	<div class="span4 col-md-4 nopadding" style="padding:0px 0px 0px 5px">

	<div class="table_t" style="display:block"><div class="table_b"><div class="table_l"><div class="table_r"><div class="table_bl"><div class="table_br"><div class="table_tl"><div class="table_tr" style="height:<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["credits_currency"] ) {
		echo ( 320 );
	} else {
		echo ( 390 );
	}
?>px">


	<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:90%">
		
		<tr>
			<th colspan="2"><?php echo pvs_word_lang( "shipping address" )?></th>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "name" )?>:</b></td>
			<td><?php echo $rs->row["shipping_firstname"] . " " . $rs->row["shipping_lastname"] ?></td>
		</tr>
		<tr valign="top">
			<td><b><?php echo pvs_word_lang( "address" )?>:</b></td>
			<td><?php echo str_replace( "\n", "<br>", $rs->row["shipping_address"] )?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "city" )?>:</b></td>
			<td><?php echo $rs->row["shipping_city"] ?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "state" )?>:</b></td>
			<td><?php echo $rs->row["shipping_state"] ?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "zipcode" )?>:</b></td>
			<td><?php echo $rs->row["shipping_zip"] ?></td>
		</tr>
		<tr>
			<td><b><?php echo pvs_word_lang( "country" )?>:</b></td>
			<td><?php echo $rs->row["shipping_country"] ?></td>
		</tr>		
	</table>


	</div></div></div></div></div></div></div></div>


	</div>
	</div>

<div style="clear:both"></div>
	<br>
<?php
echo( pvs_get_order_content( $rs->row["id"], "admin", $method ) );
?>
	
	<br>
	<h2><?php echo pvs_word_lang( "comments" )?>:</h2>
	<form method="post" action="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&action=comments_change&id=<?php echo ( int )$_GET["id"] ?>">
	<div class="admin_field">
	<textarea name="comments" style="width:600px;height:150px;"><?php echo $rs->row["comments"] ?></textarea>
	</div>
	<div class="admin_field">
	<input type="submit" value="<?php echo pvs_word_lang( "save" )?>" class="btn btn-primary">
	</div>
	</form>
<?php
}
?>
