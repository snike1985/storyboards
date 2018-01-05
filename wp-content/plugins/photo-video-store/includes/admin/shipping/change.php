<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_shipping" );

$sql = "select id from " . PVS_DB_PREFIX . "shipping order by title";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$activ = 0;
	if ( isset( $_POST["activ" . $rs->row["id"]] ) )
	{
		$activ = 1;
	}

	$sql = "update " . PVS_DB_PREFIX . "shipping set title='" . pvs_result( $_POST["title" .
		$rs->row["id"]] ) . "',shipping_time='" . pvs_result( $_POST["shipping_time" . $rs->
		row["id"]] ) . "',activ=" . $activ . " where id=" . $rs->row["id"];
	$db->execute( $sql );

	$rs->movenext();
}
?>
