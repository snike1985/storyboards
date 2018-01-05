<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_subscription" );

$sql = "select user_login from " . $table_prefix . "users where user_login='" . pvs_result( $_POST["user"] ) . "'";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$user_info = get_userdata( pvs_user_login_to_id($_POST["user"]) );

	$sql = "select id_parent,title,price,days,content_type,bandwidth,priority,bandwidth_daily from " .
		PVS_DB_PREFIX . "subscription where id_parent=" . ( int )$_POST["subscription"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$subtotal = $ds->row["price"];
		$discount = 0;
		$taxes = 0;
		$total = $subtotal + $taxes - $discount;

		$sql = "insert into " . PVS_DB_PREFIX .
			"subscription_list (title,data1,data2,user,approved,bandwidth,bandwidth_limit,subscription,subtotal,discount,taxes,total,billing_firstname,billing_lastname,billing_address,billing_city,billing_zip,billing_country,bandwidth_daily,bandwidth_daily_limit,bandwidth_date) values ('" .
			$ds->row["title"] . "'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
			date( "m" ), date( "d" ), date( "Y" ) ) . "," . ( pvs_get_time( date( "H" ),
			date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) + 3600 * 24 *
			$ds->row["days"] ) . ",'" . pvs_result( $_POST["user"] ) . "',1,0," . $ds->row["bandwidth"] .
			"," . ( int )$_POST["subscription"] . "," . $subtotal . "," . $discount . "," .
			$taxes . "," . $total . ",'" . @$user_info -> first_name . "','" . @$user_info -> last_name .
			"','" . @$user_info -> address . "','" . @$user_info -> city . "','" .@$user_info -> zipcode .
			"','" . @$user_info -> country . "',0," . $ds->row["bandwidth_daily"] . ",0)";
		$db->execute( $sql );
	}
}

?>
