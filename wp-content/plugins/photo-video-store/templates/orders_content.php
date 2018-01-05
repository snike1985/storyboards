<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );?>




<h1><?php echo pvs_word_lang( "order" )?> #<?php echo ( int )$_GET["id"] ?></h1>

<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">

<?php
$sql = "select * from " . PVS_DB_PREFIX . "orders where user=" . get_current_user_id() .
	" and id=" . ( int )$_GET["id"] . " order by data desc";
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
	
	<div class="row-fluid">
	<div class="span4 col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-right:20px">
	
	<div class="t" style="display:block"><div class="b"><div class="l"><div class="r"><div class="bl"><div class="br"><div class="tl"><div class="tr2" style="height:<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["credits_currency"] ) {
		echo ( 290 );
	} else {
		echo ( 450 );
	}
?>px">
	
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:220px">
			
			<tr>
	<th colspan="2"><?php echo pvs_word_lang( "order details" )?></th>
			</tr>
			<tr>
	<td><b><?php echo pvs_word_lang( "date" )?>:</b></td>
	<td><div class="link_date"><?php echo date( date_format, $rs->row["data"] )?></div></td>
			</tr>
			<tr>
	<td><b><?php echo pvs_word_lang( "status" )?>:</b></td>
	<td> 
		<?php
	if ( $rs->row["status"] == 1 ) {
		echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
	} else {
		echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
	}
?>
	</td>
			</tr>
			<tr>
	<td><b><?php echo pvs_word_lang( "shipped" )?>:</b></td>
	<td>
		<?php
	if ( $rs->row["shipped"] == 0 and $rs->row["shipping"] * 1 != 0 ) {
		echo ( "<div class='link_pending'>" . pvs_word_lang( "not shipped" ) . "</div>" );
	}
	if ( $rs->row["shipped"] == 1 and $rs->row["shipping"] * 1 != 0 ) {
		echo ( "<div class='link_approved'>" . pvs_word_lang( "shipped" ) . "</div>" );
	}
	if ( $rs->row["shipped"] == 0 and $rs->row["shipping"] * 1 == 0 ) {
		echo ( "&mdash;" );
	}
?>
	</td>
			</tr>
			<tr>
	<td><b><?php echo pvs_word_lang( "subtotal" )?>:</b></td>
	<td><?php echo pvs_currency( 1, true, $method );?><?php echo pvs_price_format( $rs->row["subtotal"], 2 )?> <?php echo pvs_currency( 2, true, $method );?></td>
			</tr>
			<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
	<tr>
		<td><b><?php echo pvs_word_lang( "discount" )?>:</b></td>
		<td> <?php echo pvs_currency( 1, true, $method );?><?php echo pvs_price_format( $rs->row["discount"], 2 )?> <?php echo pvs_currency( 2, true, $method );?></td>
	</tr>
			<?php
	}
?>
	<tr>
		<td><b><?php echo pvs_word_lang( "shipping" )?>:</b></td>
		<td><?php echo pvs_currency( 1, true, $method );?><?php echo pvs_price_format( $rs->row["shipping"], 2 )?> <?php echo pvs_currency( 2, true, $method );?></td>
	</tr>
			<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
	<tr>
		<td><b><?php echo pvs_word_lang( "taxes" )?>:</b></td>
		<td>
		<?php
		if ( ! $rs->row["credits"] ) {
?>
		<?php
			echo pvs_currency( 1, true, $method );?><?php
			echo pvs_price_format( $rs->row["tax"], 2 )?> <?php
			echo pvs_currency( 2, true, $method );?>
		<?php
		} else {
?>
			&mdash;
		<?php
		}
?>
		</td>
	</tr>
			<?php
	}
?>
	<tr>
		<td><b><?php echo pvs_word_lang( "total" )?>:</b></td>
		<td><span class="price"><b><?php echo pvs_currency( 1, true, $method );?><?php echo pvs_price_format( $rs->row["total"], 2 )?> <?php echo pvs_currency( 2, true, $method );?></b></span></td>
	</tr>
	</table>
	
	</div></div></div></div></div></div></div></div>
	
	
	</div>
	<div class="span4 col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-right:20px">
	
	
	<div class="t" style="display:block;"><div class="b"><div class="l"><div class="r"><div class="bl"><div class="br"><div class="tl"><div class="tr2" style="height:<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["credits_currency"] ) {
		echo ( 290 );
	} else {
		echo ( 450 );
	}
?>px">
	
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:220px">
			
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
	<div class="span4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
	
	
	
	
	<div class="t" style="display:block;"><div class="b"><div class="l"><div class="r"><div class="bl"><div class="br"><div class="tl"><div class="tr2" style="height:<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["credits_currency"] ) {
		echo ( 290 );
	} else {
		echo ( 450 );
	}
?>px">
	
	
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:220px">
			
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
	<br>
	
	
	
	
	<?php
	if ( $rs->row["comments"] != "" ) {
?>
	<div class="t" style="display:block;"><div class="b"><div class="l"><div class="r"><div class="bl"><div class="br"><div class="tl"><div class="tr2">
	
	
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home" style="width:795px">
			
			<tr>
	<th colspan="2"><?php echo pvs_word_lang( "comments" )?></th>
			</tr>
			<tr>
	<td colspan="2"><?php echo str_replace( "\n", "<br>", $rs->row["comments"] )?></td>
			</tr>
	</table>
	
	
	</div></div></div></div></div></div></div></div>
	<?php
	}
	echo( pvs_get_order_content( $rs->row["id"], "user", $method ) );
}

include ( "profile_bottom.php" );
?>