<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


if ( isset( $_GET["id"] ) ) {
	$sql = "select invoice_number,order_id,order_type,comments,refund from " .
		PVS_DB_PREFIX . "invoices where invoice_number=" . ( int )$_GET["id"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$flag = false;
		$billing_info = array();
		$shipping_info = array();
		$order_info = array();

		$user_sql = "";
		if ( is_user_logged_in() and ! pvs_is_user_admin () ) {
			if ( $ds->row["order_type"] == "orders" )
			{
				$user_sql = " user=" . get_current_user_id() . " and ";
			}
			if ( $ds->row["order_type"] == "credits" )
			{
				$user_sql = " user='" . pvs_result( pvs_user_id_to_login( get_current_user_id()) ) . "' and ";
			}
			if ( $ds->row["order_type"] == "subscription" )
			{
				$user_sql = " user='" . pvs_result( pvs_user_id_to_login( get_current_user_id()) ) . "' and ";
			}
		}

		if ( $ds->row["order_type"] == "orders" ) {

			$sql = "select id,shipping_firstname,shipping_lastname,shipping_address,shipping_country,shipping_city,shipping_state,shipping_zip,billing_firstname,billing_lastname,billing_address,billing_country,billing_city,billing_zip,billing_state,user,total,data,credits,billing_company,billing_business,billing_vat from " . PVS_DB_PREFIX . "orders where " .
				$user_sql . " id=" . $ds->row["order_id"];
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
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
				$order_info["company"] = $rs->row["billing_company"];
				$order_info["business"] = $rs->row["billing_business"];
				$order_info["vat"] = $rs->row["billing_vat"];

				$shipping_info["shipping_firstname"] = $rs->row["shipping_firstname"];
				$shipping_info["shipping_lastname"] = $rs->row["shipping_lastname"];
				$shipping_info["shipping_address"] = $rs->row["shipping_address"];
				$shipping_info["shipping_country"] = $rs->row["shipping_country"];
				$shipping_info["shipping_city"] = $rs->row["shipping_city"];
				$shipping_info["shipping_zip"] = $rs->row["shipping_zip"];
				$shipping_info["shipping_state"] = $rs->row["shipping_state"];
			}
		}
		if ( $ds->row["order_type"] == "credits" ) {
			$sql = "select id_parent,billing_firstname,billing_lastname,billing_address,billing_country,billing_city,billing_zip,billing_state,title,user,data,total,billing_company,billing_business,billing_vat  from " .
				PVS_DB_PREFIX . "credits_list where " . $user_sql . " id_parent=" . $ds->row["order_id"];
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
				$flag = true;

				$order_info["id"] = pvs_word_lang( "credits" ) . "-" . $rs->row["id_parent"];
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
				$order_info["company"] = $rs->row["billing_company"];
				$order_info["business"] = $rs->row["billing_business"];
				$order_info["vat"] = $rs->row["billing_vat"];

				$shipping_info["shipping_firstname"] = "";
				$shipping_info["shipping_lastname"] = "";
				$shipping_info["shipping_address"] = "";
				$shipping_info["shipping_country"] = "";
				$shipping_info["shipping_city"] = "";
				$shipping_info["shipping_zip"] = "";
				$shipping_info["shipping_state"] = "";
			}
		}
		if ( $ds->row["order_type"] == "subscription" ) {
			$sql = "select id_parent,billing_firstname,billing_lastname,billing_address,billing_country,billing_city,billing_zip,billing_state,title,user,data1,total,billing_company,billing_business,billing_vat from " .
				PVS_DB_PREFIX . "subscription_list where " . $user_sql . " id_parent=" . $ds->
				row["order_id"];
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
				$flag = true;

				$order_info["id"] = pvs_word_lang( "subscription" ) . "-" . $rs->row["id_parent"];
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
				$order_info["company"] = $rs->row["billing_company"];
				$order_info["business"] = $rs->row["billing_business"];
				$order_info["vat"] = $rs->row["billing_vat"];

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
			if ( file_exists( pvs_upload_dir() . "/content/invoice_logo.jpg" ) )
			{
				$invoice_logo =  pvs_upload_dir('baseurl') . "/content/invoice_logo.jpg";
			} else
			{
				$invoice_logo =  pvs_plugins_url() . "/assets/images/e.gif";
			}

			$invoice_company_name = $pvs_global_settings["company_name"];
			$invoice_company_address1 = $pvs_global_settings["company_address1"];
			$invoice_company_address2 = $pvs_global_settings["company_address2"];

			if ( $pvs_global_settings["company_vat_number"] != "" )
			{
				$invoice_company_vat = "<b>EU VAT Reg No:</b> " . $pvs_global_settings["company_vat_number"];
			} else
			{
				$invoice_company_vat = "";
			}

			if ( $ds->row["refund"] )
			{
				$invoice = pvs_word_lang( "Credit notes" );
				$invoice_paid =  pvs_plugins_url() . "/assets/images/refund_stamp.jpg";
				$invoice_number = $pvs_global_settings["credit_notes_prefix"] . ( int )$_GET["id"];
				$invoice_amount = "-" . pvs_currency( 1, false ) . pvs_price_format( $order_info["total"], 2 ) . " " . pvs_currency( 2, false );
				$invoice_items = pvs_show_order_content( $ds->row["order_type"], $ds->row["order_id"], "-" );
			} else
			{
				$invoice = pvs_word_lang( "Invoice" );
				$invoice_paid =  pvs_plugins_url() . "/assets/images/paid_stamp.jpg";
				$invoice_number = $pvs_global_settings["invoice_prefix"] . ( int )$_GET["id"];
				$invoice_amount = pvs_currency( 1, false ) . pvs_price_format( $order_info["total"], 2 ) . " " . pvs_currency( 2, false );
				$invoice_items = pvs_show_order_content( $ds->row["order_type"], $ds->row["order_id"], "" );
			}

			$invoice_date = $order_info["date"];
			$invoice_order_number= $order_info["id"];
			$invoice_text = $ds->row["comments"];

			if ( @$order_info["business"] == 1 )
			{
				$invoice_client_name = $order_info["company"];
				$invoice_client_vat = pvs_word_lang( "VAT number" ) . ": " . $order_info["vat"];
			} else
			{
				$invoice_client_name = $billing_info["billing_firstname"] . " " . $billing_info["billing_lastname"];
				$invoice_client_vat = "";
			}

			$invoice_client_address = str_replace( "\n", "<br>", $billing_info["billing_address"] );

			$transaction_info = '';
			$transaction_flag = false;

			$sql = "select id_parent,user,data,total,ip,tnumber,ptype,pid,processor from " .
				PVS_DB_PREFIX . "payments where pid=" . $ds->row["order_id"];
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
				$transaction_flag = true;

				if ( isset( $pvs_payments[$rs->row["processor"]] ) )
				{
					$transaction_info = pvs_word_lang( "Payment received via" ) . ' ' . $pvs_payments[$rs->
						row["processor"]];
				}

				if ( $rs->row["tnumber"] != "" )
				{
					$transaction_info .= "(" . pvs_word_lang( "transaction id" ) . ": " . $rs->row["tnumber"] .
						")";
				}
			}

			$invoice_payment = $transaction_info;

			$invoice_payment_flag = $transaction_flag;

			include( PVS_PATH. "includes/invoice/invoice.php" );
		}
	}
}
?>