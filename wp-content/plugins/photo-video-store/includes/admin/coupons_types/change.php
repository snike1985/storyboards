<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_couponstypes" );

$sql = "select id_parent,title,days,total,percentage,url,events,ulimit,bonus from " .
	PVS_DB_PREFIX . "coupons_types";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( $_POST["discount_type" . $rs->row["id_parent"]] == "total" )
	{
		$com = ",percentage=0";
	}
	if ( $_POST["discount_type" . $rs->row["id_parent"]] == "percentage" )
	{
		$com = ",total=0";
	}

	$sql = "update " . PVS_DB_PREFIX . "coupons_types set title='" . pvs_result( $_POST["title" .
		$rs->row["id_parent"]] ) . "',days=" . ( int )$_POST["days" . $rs->row["id_parent"]] .
		"," . pvs_result( $_POST["discount_type" . $rs->row["id_parent"]] ) . "=" . ( float )
		$_POST["discount" . $rs->row["id_parent"]] . $com . ",events='" . pvs_result( $_POST["events" . $rs->
		row["id_parent"]] ) . "',ulimit=" . ( int )$_POST["ulimit" . $rs->row["id_parent"]] .
		",bonus=" . ( float )$_POST["bonus" . $rs->row["id_parent"]] .
		" where id_parent=" . $rs->row["id_parent"];
	$db->execute( $sql );
	$rs->movenext();
}
?>