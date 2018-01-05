<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["jvzoo_active"] ) {
	function jvzipnVerification() {
		global $pvs_global_settings;
		global $_POST;
	
		$secretKey = $pvs_global_settings["jvzoo_password"];
		$pop = "";
		$ipnFields = array();
		foreach ( $_POST AS $key => $value ) {
			if ( $key == "cverify" ) {
				continue;
			}
			$ipnFields[] = $key;
		}
		sort( $ipnFields );
		foreach ( $ipnFields as $field ) {
			// if Magic Quotes are enabled $_POST[$field] will need to be
			// un-escaped before being appended to $pop
			$pop = $pop . $_POST[$field] . "|";
		}
		$pop = $pop . $secretKey;
		if ( 'UTF-8' != mb_detect_encoding( $pop ) ) {
			$pop = mb_convert_encoding( $pop, "UTF-8" );
		}
		$calcedVerify = sha1( $pop );
		$calcedVerify = strtoupper( substr( $calcedVerify, 0, 8 ) );
		return $calcedVerify == $_POST["cverify"];
	}
	
	/*
	$_REQUEST["cproditem"] = 2;
	$_REQUEST["ctransreceipt"] = "jvzoo12345";
	$_REQUEST["ccustemail"] = "test@jvzoo.com";
	$_REQUEST["ccustname"] = "John Smith";
	*/
	
	if ( jvzipnVerification() ) {
		$sql = "select subscription,credits from " . PVS_DB_PREFIX .
			"gateway_jvzoo where product_id='" . pvs_result( $_REQUEST["cproditem"] ) . "'";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			//Subscription
			if ( $dr->row["subscription"] > 0 ) {
				$product_type = "subscription";
	
				$sql = "select * from " . PVS_DB_PREFIX . "subscription where id_parent=" . ( int )
					$dr->row["subscription"];
				$dd->open( $sql );
				if ( ! $dd->eof )
				{
					$sql = "select title from " . PVS_DB_PREFIX . "subscription_list where title='" .
						$dd->row["title"] . "  #" . pvs_result( $_REQUEST["ctransreceipt"] ) . "'";
					$dq->open( $sql );
					if ( $dq->eof )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"subscription_list (title,data1,data2,user,approved,bandwidth,bandwidth_limit,subscription,subtotal,discount,taxes,total,billing_firstname,billing_lastname,billing_address,billing_city,billing_zip,billing_country,recurring,payments,bandwidth_daily,bandwidth_daily_limit,bandwidth_date,taxes_id,billing_company,billing_vat,billing_business) values ('" .
							$dd->row["title"] . "  #" . pvs_result( $_REQUEST["ctransreceipt"] ) . "'," .
							pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
							date( "Y" ) ) . "," . ( pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
							date( "m" ), date( "d" ), date( "Y" ) ) + 3600 * 24 * $dd->row["days"] ) . ",'" .
							pvs_result( $_REQUEST["ccustemail"] ) . "',0,0," . $dd->row["bandwidth"] . "," . ( int )
							$dr->row["subscription"] . "," . $dd->row["price"] . ",0,0," . $dd->row["price"] .
							",'" . pvs_result( $_REQUEST["ccustname"] ) . "','','','','',''," . $dd->row["recurring"] .
							",0,0," . $dd->row["bandwidth_daily"] . ",0,0,'','',0)";
						$db->execute( $sql );
					}
	
					$sql = "select id_parent,title from " . PVS_DB_PREFIX .
						"subscription_list where title='" . $dd->row["title"] . "  #" . pvs_result( $_REQUEST["ctransreceipt"] ) .
						"'";
					$dq->open( $sql );
					if ( ! $dq->eof )
					{
						$id = $dq->row["id_parent"];
					}
				}
			}
	
			//Credits
			if ( $dr->row["credits"] > 0 ) {
				$product_type = "credits";
	
				$sql = "select * from " . PVS_DB_PREFIX . "credits where id_parent=" . ( int )$dr->
					row["credits"];
				$dd->open( $sql );
				if ( ! $dd->eof )
				{
					$sql = "select title from " . PVS_DB_PREFIX . "credits_list where title='" . $dd->
						row["title"] . "  #" . pvs_result( $_REQUEST["ctransreceipt"] ) . "'";
					$dq->open( $sql );
					if ( $dq->eof )
					{
						$expiration_date = 0;
						if ( $dd->row["days"] > 0 )
						{
							$expiration_date = pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
								date( "d" ), date( "Y" ) ) + 3600 * 24 * $dd->row["days"];
						}
	
						$sql = "insert into " . PVS_DB_PREFIX .
							"credits_list (title,data,user,quantity,approved,payment,credits,expiration_date,subtotal,discount,taxes,total,billing_firstname,billing_lastname,billing_address,billing_city,billing_zip,billing_country,billing_state,taxes_id,billing_company,billing_vat,billing_business) values ('" .
							$dd->row["title"] . "  #" . pvs_result( $_REQUEST["ctransreceipt"] ) . "'," .
							pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
							date( "Y" ) ) . ",'" . pvs_result( $_REQUEST["ccustemail"] ) . "','" . $dd->row["quantity"] .
							"',0,0," . ( int )$dr->row["credits"] . "," . $expiration_date . "," . $dd->row["price"] .
							",0,0," . $dd->row["price"] . ",'" . pvs_result( $_REQUEST["ccustname"] ) .
							"','','','','','','',0,'','',0)";
						$db->execute( $sql );
					}
	
					$sql = "select id_parent,title from " . PVS_DB_PREFIX .
						"credits_list where title='" . $dd->row["title"] . "  #" . pvs_result( $_REQUEST["ctransreceipt"] ) .
						"'";
					$dq->open( $sql );
					if ( ! $dq->eof )
					{
						$id = $dq->row["id_parent"];
					}
				}
			}
	
			//Add a new user
			$sql = "select ID,user_login from " . $table_prefix. "users where  where user_email='" .
				pvs_result( $_REQUEST["ccustemail"] ) . "'";
			$rs->open( $sql );
			if ( $rs->eof ) {
				$params["login"] = pvs_result( $_REQUEST["ccustemail"] );
				$params["password"] = md5( pvs_create_password() );
				$params["name"] = pvs_result( $_REQUEST["ccustname"] );
				$params["country"] = '';
				$params["telephone"] = '';
				$params["address"] = '';
				$params["email"] = pvs_result( $_REQUEST["ccustemail"] );
				$params["data1"] = pvs_get_time();
				$params["ip"] = pvs_result( $_SERVER["REMOTE_ADDR"] );
				$params["accessdenied"] = 0;
				$params["lastname"] = '';
				$params["city"] = '';
				$params["state"] = '';
				$params["zipcode"] = '';
				$params["category"] = $pvs_global_settings["userstatus"];
				$params["website"] = '';
				$params["utype"] = 'buyer';
				$params["company"] = '';
				$params["newsletter"] = 0;
				$params["examination"] = 1;
				$params["authorization"] = 'site';
				$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
				$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
				$params["aff_visits"] = 0;
				$params["aff_signups"] = 0;
				$params["aff_referal"] = ( int )@$_COOKIE["aff"];
				$params["business"] = 0;
				$params["vat"] = '';
				$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
				$params["avatar"] = '';
				$params["photo"] = '';
				$params["description"] = '';
				$params["paypal"] = '';
				$params["moneybookers"] = '';
				$params["passport"] = '';
				$params["dwolla"] = '';
				$params["webmoney"] = '';
				$params["qiwi"] = '';
				$params["bank_account"] = '';
				$params["bank_name"] = '';
				$params["downloads"] = 0;
				$params["downloads_date"] = 0;
				$params["payson"] = '';
				$params["country_checked"] = 0;
				$params["country_checked_date"] = 0;
				$params["vat_checked"] = 0;
				$params["vat_checked_date"] = 0;
				$params["rating"] = 0;
	
				$id = pvs_add_user( $params );
	
				$sql = "select ID,user_login from " . $table_prefix. "users where user_email='" .
					pvs_result( $_REQUEST["ccustemail"] ) . "'";
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$_POST["guest_email"] = pvs_result( $_REQUEST["ccustemail"] );
					pvs_send_notification( 'signup_guest', pvs_result( $_REQUEST["ccustemail"] ), $password );
					pvs_send_notification( 'signup_to_admin', $ds->row["ID"] );
	
					//insert the coupon for new user
					pvs_coupons_add( pvs_result( $_REQUEST["ccustemail"] ), "New Signup" );
				}
			}
	
			//Add a transaction
			$transaction_id = pvs_transaction_add( "jvzoo", pvs_result( $_REQUEST["ctransreceipt"] ),
				$product_type, $id );
	
			//Approve credits
			if ( $product_type == "credits" and ! pvs_is_order_approved( $id, 'credits' )  ) {
				pvs_credits_approve( $id, $transaction_id );
				pvs_send_notification( 'credits_to_user', $id );
				pvs_send_notification( 'credits_to_admin', $id );
			}
	
			//Approve subscription
			if ( $product_type == "subscription" and ! pvs_is_order_approved( $id, 'subscription' )  ) {
				pvs_subscription_approve( $id );
				pvs_send_notification( 'subscription_to_user', $id );
				pvs_send_notification( 'subscription_to_admin', $id );
			}
		}
	}
	
	echo ( 200 );
}
?>