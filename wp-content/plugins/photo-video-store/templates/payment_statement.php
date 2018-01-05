<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<h2><?php echo pvs_word_lang( "purchase statement" )?></h2>
<?php
if ( isset( $_REQUEST["product_id"] ) and isset( $_REQUEST["product_type"] )) {
	$flag = false;
	$billing_info = array();
	$shipping_info = array();
	$order_info = array();

	$user_sql = "";
	if ( ! pvs_is_user_admin () ) {
		if ( $_REQUEST["product_type"] == "order" ) {
			$user_sql = " user=" . get_current_user_id() . " and ";
		}
		if ( $_REQUEST["product_type"] == "credits" ) {
			$user_sql = " user='" . pvs_result( pvs_get_user_login () ) . "' and ";
		}
		if ( $_REQUEST["product_type"] == "subscription" ) {
			$user_sql = " user='" . pvs_result( pvs_get_user_login () ) . "' and ";
		}
	}

	if ( $_REQUEST["product_type"] == "order" ) {

		$sql = "select id,shipping_firstname,shipping_lastname,shipping_address,shipping_country,shipping_city,shipping_state,shipping_zip,billing_firstname,billing_lastname,billing_address,billing_country,billing_city,billing_zip,billing_state,user,total,data,credits from " .
			PVS_DB_PREFIX . "orders where " . $user_sql . " id=" . ( int )$_REQUEST["product_id"];
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$flag = true;

			$order_info["id"] = $rs->row["id"];
			$order_info["user"] = pvs_user_id_to_login( $rs->row["user"] );
			$order_info["name"] = pvs_word_lang( "order" );
			$order_info["total"] = $rs->row["total"];
			$order_info["date"] = date( date_format, $rs->row["data"] );
			$order_info["credits"] = $rs->row["credits"];

			$billing_info["billing_firstname"] = $rs->row["billing_firstname"];
			$billing_info["billing_lastname"] = $rs->row["billing_lastname"];
			$billing_info["billing_address"] = $rs->row["billing_address"];
			$billing_info["billing_country"] = $rs->row["billing_country"];
			$billing_info["billing_city"] = $rs->row["billing_city"];
			$billing_info["billing_zip"] = $rs->row["billing_zip"];
			$billing_info["billing_state"] = $rs->row["billing_state"];

			$shipping_info["shipping_firstname"] = $rs->row["shipping_firstname"];
			$shipping_info["shipping_lastname"] = $rs->row["shipping_lastname"];
			$shipping_info["shipping_address"] = $rs->row["shipping_address"];
			$shipping_info["shipping_country"] = $rs->row["shipping_country"];
			$shipping_info["shipping_city"] = $rs->row["shipping_city"];
			$shipping_info["shipping_zip"] = $rs->row["shipping_zip"];
			$shipping_info["shipping_state"] = $rs->row["shipping_state"];
		}
	}
	if ( $_REQUEST["product_type"] == "credits" ) {
		$sql = "select id_parent,billing_firstname,billing_lastname,billing_address,billing_country,billing_city,billing_zip,billing_state,title,user,data,total  from " .
			PVS_DB_PREFIX . "credits_list where " . $user_sql . " id_parent=" . ( int )$_REQUEST["product_id"];
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$flag = true;

			$order_info["id"] = $rs->row["id_parent"];
			$order_info["user"] = $rs->row["user"];
			$order_info["name"] = pvs_word_lang( "credits" ) . ": " . $rs->row["title"];
			$order_info["total"] = $rs->row["total"];
			$order_info["date"] = date( date_format, $rs->row["data"] );
			$order_info["credits"] = 0;

			$billing_info["billing_firstname"] = $rs->row["billing_firstname"];
			$billing_info["billing_lastname"] = $rs->row["billing_lastname"];
			$billing_info["billing_address"] = $rs->row["billing_address"];
			$billing_info["billing_country"] = $rs->row["billing_country"];
			$billing_info["billing_city"] = $rs->row["billing_city"];
			$billing_info["billing_zip"] = $rs->row["billing_zip"];
			$billing_info["billing_state"] = $rs->row["billing_state"];

			$shipping_info["shipping_firstname"] = "";
			$shipping_info["shipping_lastname"] = "";
			$shipping_info["shipping_address"] = "";
			$shipping_info["shipping_country"] = "";
			$shipping_info["shipping_city"] = "";
			$shipping_info["shipping_zip"] = "";
			$shipping_info["shipping_state"] = "";
		}
	}
	if ( $_REQUEST["product_type"] == "subscription" ) {
		$sql = "select id_parent,billing_firstname,billing_lastname,billing_address,billing_country,billing_city,billing_zip,billing_state,title,user,data1,total from " .
			PVS_DB_PREFIX . "subscription_list where " . $user_sql . " id_parent=" . ( int )
			$_REQUEST["product_id"];
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$flag = true;

			$order_info["id"] = $rs->row["id_parent"];
			$order_info["user"] = $rs->row["user"];
			$order_info["name"] = pvs_word_lang( "subscription" ) . ": " . $rs->row["title"];
			$order_info["total"] = $rs->row["total"];
			$order_info["date"] = date( date_format, $rs->row["data1"] );
			$order_info["credits"] = 0;

			$billing_info["billing_firstname"] = $rs->row["billing_firstname"];
			$billing_info["billing_lastname"] = $rs->row["billing_lastname"];
			$billing_info["billing_address"] = $rs->row["billing_address"];
			$billing_info["billing_country"] = $rs->row["billing_country"];
			$billing_info["billing_city"] = $rs->row["billing_city"];
			$billing_info["billing_zip"] = $rs->row["billing_zip"];
			$billing_info["billing_state"] = $rs->row["billing_state"];

			$shipping_info["shipping_firstname"] = "";
			$shipping_info["shipping_lastname"] = "";
			$shipping_info["shipping_address"] = "";
			$shipping_info["shipping_country"] = "";
			$shipping_info["shipping_city"] = "";
			$shipping_info["shipping_zip"] = "";
			$shipping_info["shipping_state"] = "";
		}
	}

	if ( $flag ) {
?>
		
		<?php
		if ( ! isset( $_REQUEST["print"] ) ) {
?>
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%;margin-bottom:30px">
			<tr valign="top">
			<td width="33%">
			<h4><?php
			echo bloginfo('name') ?></h4>
			</td>
			<td style="width:33%">
			<?php
			echo str_replace( "\n", "<br>", $pvs_global_settings["company_address"] )?>
			</td>
			<td width="33%">
			</td>
			</tr>
			</table>
			<?php
		}
?>
		
		
		
		<table border="0" cellpadding="0" cellspacing="0" class="payment_table" style="width:100%">
		<tr valign="top">
		<th style="width:33%"><?php echo pvs_word_lang( "billing information" )?></th>
		<th style="width:33%"><?php echo pvs_word_lang( "payment information" )?></th>
		<th style="width:33%"><?php echo pvs_word_lang( "order information" )?></th>
		</tr>

		<tr valign="top">
		<td>
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table2  table table-striped">
			<tr>
			<td><b><?php echo pvs_word_lang( "name" )?>:</b></td>
			<td><?php echo $billing_info["billing_firstname"] ?></td>
			</tr>
			
			<tr>
			<td><b><?php echo pvs_word_lang( "last name" )?>:</b></td>
			<td><?php echo $billing_info["billing_lastname"] ?></td>
			</tr>
			
			<tr>
			<td><b><?php echo pvs_word_lang( "address" )?>:</b	></td>
			<td><?php echo str_replace( "\n", "<br>", $billing_info["billing_address"] )?></td>
			</tr>
			
			<tr>
			<td><b><?php echo pvs_word_lang( "city" )?>:</b></td>
			<td><?php echo $billing_info["billing_city"] ?></td>
			</tr>
			
			<tr>
			<td><b><?php echo pvs_word_lang( "state" )?>:</b></td>
			<td><?php echo $billing_info["billing_state"] ?></td>
			</tr>
			
			<tr>
			<td><b><?php echo pvs_word_lang( "zipcode" )?>:</b></td>
			<td><?php echo $billing_info["billing_zip"] ?></td>
			</tr>
			
			<tr>
			<td><b><?php echo pvs_word_lang( "country" )?>:</b></td>
			<td><?php echo $billing_info["billing_country"] ?></td>
			</tr>
			</table>
		</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table2 table table-striped">
			<?php
		$sql = "select id_parent,user,data,total,ip,tnumber,ptype,pid,processor from " .
			PVS_DB_PREFIX . "payments where pid=" . ( int )$_REQUEST["product_id"];
		$rs->open( $sql );
		if ( ! $rs->eof ) {
?>
	<tr>
	<td><b><?php
			echo pvs_word_lang( "type" )?>:</b></td>
	<td>
	<?php
			if ( isset( $pvs_payments[$rs->row["processor"]] ) )
			{
				echo ( $pvs_payments[$rs->row["processor"]] );
			}
?>
	</td>
	</tr>
	<?php
			if ( $rs->row["tnumber"] != "" )
			{
?>
		<tr>
		<td><b><?php
				echo pvs_word_lang( "transaction id" )?>:</b></td>
		<td><?php
				echo $rs->row["tnumber"] ?></td>
		</tr>
		<?php
			}
		}
?>
			<tr>
			<td><b><?php echo pvs_word_lang( "total" )?>:</b></td>
			<td>
			<?php
		if ( $_REQUEST["product_type"] == "subscription" or $_REQUEST["product_type"] ==
			"credits" or ( ! $pvs_global_settings["credits"] and $_REQUEST["product_type"] ==
			"order" ) ) {
			echo ( pvs_currency( 1, false ) . pvs_price_format( $order_info["total"], 2 ) .
				" " . pvs_currency( 2, false ) );
		} else {
			if ( $pvs_global_settings["credits_currency"] and $pvs_global_settings["credits"] )
			{
				if ( $order_info["credits"] == 0 )
				{
					echo ( pvs_currency( 1, false ) . pvs_price_format( $order_info["total"], 2 ) .
						" " . pvs_currency( 2, false ) );
				} else
				{
					echo ( pvs_price_format( $order_info["total"], 2 ) . " " . pvs_word_lang( "credits" ) );
				}
			} else
			{
				echo ( pvs_currency( 1, true ) . pvs_price_format( $order_info["total"], 2 ) .
					" " . pvs_currency( 2, true ) );
			}
		}
?>
			</td>
			</tr>
			</table>
		</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table2 table table-striped">
			<tr>
			<td><b><?php echo pvs_word_lang( "login" )?>:</b></td>
			<td><?php echo $order_info["user"] ?></td>
			</tr>
			<tr>
			<td><b><?php echo pvs_word_lang( "order" )?> ID:</b></td>
			<td><?php echo $order_info["id"] ?></td>
			</tr>
			<tr>
			<td><b><?php echo pvs_word_lang( "title" )?>:</b></td>
			<td><?php echo $order_info["name"] ?></td>
			</tr>
			<tr>
			<td><b><?php echo pvs_word_lang( "date" )?>:</b></td>
			<td><?php echo $order_info["date"] ?></td>
			</tr>
			</table>
		</td>
		</tr>
		</table>
		
		<?php
	}
?>
<br><br>
<h2><?php echo pvs_word_lang( "order" )?></h2>
<?php echo pvs_show_order_content( $_REQUEST["product_type"], $_REQUEST["product_id"] )?>
<?php
}
?>

