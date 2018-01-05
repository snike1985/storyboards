<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_subscription" );

$content_type = "";
$sql = "select * from " . PVS_DB_PREFIX . "content_type order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( $content_type != "" and isset( $_POST["type" . $rs->row["id_parent"]] ) )
	{
		$content_type .= "|";
	}
	if ( isset( $_POST["type" . $rs->row["id_parent"]] ) )
	{
		$content_type .= $rs->row["name"];
	}
	$rs->movenext();
}

$recurring = 0;
if ( isset( $_POST["recurring"] ) )
{
	$recurring = 1;
}

$sql = "insert into " . PVS_DB_PREFIX .
	"subscription (title,price,days,content_type,bandwidth,priority,recurring,bandwidth_daily) values ('" .
	pvs_result( $_POST["title"] ) . "'," . pvs_result( $_POST["price"] ) . "," . ( int )
	$_POST["days"] . ",'" . $content_type . "'," . ( int )$_POST["bandwidth"] .
	",0," . $recurring . "," . ( int )$_POST["bandwidth_daily"] . ")";
$db->execute( $sql );
?>