<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["fortumo_active"] ) {
 
	function check_signature( $params_array, $secret ) {
		ksort( $params_array );

		$str = '';
		foreach ( $params_array as $k => $v ) {
			if ( $k != 'sig' )
			{
				$str .= "$k=$v";
			}
		}
		$str .= $secret;
		$signature = md5( $str );

		return ( $params_array['sig'] == $signature );
	}

	// check that the request comes from Fortumo server
	/*
	if(!in_array($_SERVER['REMOTE_ADDR'],
	array('1.2.3.4', '2.3.4.5'))) {
	header("HTTP/1.0 403 Forbidden");
	die("Error: Unknown IP");
	}
	*/

	// check the signature
	$secret = $pvs_global_settings["fortumo_password"]; // insert your secret between ''
	if ( empty( $secret ) || ! check_signature( $_GET, $secret ) ) {
		header( "HTTP/1.0 404 Not Found" );
		die( "Error: Invalid signature" );
	}

	$sender = ( int )$_GET['sender']; //phone num.
	$amount = ( int )$_GET['amount']; //credit
	$cuid = ( int )$_GET['cuid']; //resource i.e. user
	$payment_id = $_GET['payment_id']; //unique id

	//hint: find or create payment by payment_id
	//additional parameters: operator, price, user_share, country

	if ( preg_match( "/completed/i", $_GET['status'] ) ) {
		// mark payment successful

		$sql = "select ID, user_login from " . $table_prefix . "users where ID=" . $cuid;
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$sql = "select tnumber from " . PVS_DB_PREFIX . "payments where tnumber='" .
				pvs_result( $payment_id ) . "' and processor='fortumo'";
			$dr->open( $sql );
			if ( $dr->eof )
			{
				$user_info = get_userdata( $rs->row['ID'] );
				$sql = "insert into " . PVS_DB_PREFIX .
					"credits_list (title,quantity,data,user,approved,payment,credits,expiration_date,subtotal,discount,taxes,total,billing_firstname,billing_lastname,billing_address,billing_city,billing_zip,billing_country) values ('" .
					$amount . " Credits','" . $amount . "'," . pvs_get_time( date( "H" ), date( "i" ),
					date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . ",'" . $rs->row["user_login"] .
					"',1,0,0,0," . ( float )$_GET['price'] . ",0,0," . ( float )$_GET['price'] .
					",'" .@$user_info -> first_name . "','" . @$user_info -> last_name . "','" . @$user_info -> first_address .
					"','" . @$user_info -> city . "','" . @$user_info -> zipcode . "','" . @$user_info -> country .
					"')";
				$db->execute( $sql );

				$sql = "select id_parent from " . PVS_DB_PREFIX . "credits_list where user='" .
					$rs->row["user_login"] . "' order by id_parent desc";
				$ds->open( $sql );
				$credits_id = $ds->row["id_parent"];
				$transaction_id = pvs_transaction_add( "fortumo", $payment_id, "credits", $credits_id );

				pvs_credits_approve( $credits_id, $transaction_id );
				pvs_send_notification( 'credits_to_user', $credits_id );
				pvs_send_notification( 'credits_to_admin', $credits_id );
			}
		}
	}

	// print out the reply
	echo ( 'OK' );
}
?>