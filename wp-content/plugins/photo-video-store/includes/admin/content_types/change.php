<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_content_types" );

$sql = "select id_parent,priority,name from " . PVS_DB_PREFIX .
	"content_type order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( pvs_result( $_POST["title" . $rs->row["id_parent"]] ) != $rs->row["name"] )
	{
		$sql = "update " . PVS_DB_PREFIX . "media set content_type='" . pvs_result( $_POST["title" .
			$rs->row["id_parent"]] ) . "' where content_type='" . $rs->row["name"] . "'";
		$db->execute( $sql );
	}

	$sql = "update " . PVS_DB_PREFIX . "content_type set name='" . pvs_result( $_POST["title" .
		$rs->row["id_parent"]] ) . "',priority=" . ( int )$_POST["priority" . $rs->row["id_parent"]] .
		" where id_parent=" . $rs->row["id_parent"];
	$db->execute( $sql );
	$rs->movenext();
}
?>
