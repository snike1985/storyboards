<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_checkout" );

$sql = "select * from " . PVS_DB_PREFIX . "terms";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( isset( $_POST["delete" . $rs->row["id"]] ) )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "terms where id=" . $rs->row["id"];
		$db->execute( $sql );
	} else
	{
		$sql = "update " . PVS_DB_PREFIX . "terms set title='" . pvs_result( $_POST["title" .
			$rs->row["id"]] ) . "',types=" . ( int )$_POST["types" . $rs->row["id"]] .
			",priority=" . ( int )$_POST["priority" . $rs->row["id"]] . ",page_id=" . ( int )
			$_POST["page_id" . $rs->row["id"]] . " where id=" . $rs->row["id"];
		$db->execute( $sql );
	}

	$rs->movenext();
}
?>
