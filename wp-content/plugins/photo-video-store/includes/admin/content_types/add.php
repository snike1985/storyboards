<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_content_types" );

$sql = "insert into " . PVS_DB_PREFIX . "content_type (priority,name) values (" . ( int )
	$_POST["priority"] . ",'" . pvs_result( $_POST["title"] ) . "')";
$db->execute( $sql );
?>
