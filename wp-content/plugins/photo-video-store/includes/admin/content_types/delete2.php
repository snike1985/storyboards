<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_content_types" );

$sql = "select id_parent,priority,name from " . PVS_DB_PREFIX .
	"content_type where id_parent=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof )
{

	$sql = "update " . PVS_DB_PREFIX . "media set content_type='" . pvs_result( $_POST["new_type"] ) .
		"' where content_type='" . $rs->row["name"] . "'";
	$db->execute( $sql );

	$sql = "delete from " . PVS_DB_PREFIX . "content_type where id_parent=" . ( int )
		$_GET["id"];
	$db->execute( $sql );
}
?>
