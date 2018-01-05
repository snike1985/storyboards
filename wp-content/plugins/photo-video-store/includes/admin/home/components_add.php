<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_home" );

$sql = "insert into " . PVS_DB_PREFIX .
	"components (title,content,quantity,types,category,user,template) values ('" .
	pvs_result( $_POST["title"] ) . "','" . pvs_result( $_POST["content"] ) . "'," .
	pvs_result( $_POST["quantity"] ) . ",'" . pvs_result( $_POST["types"] ) . "'," .
	pvs_result( $_POST["category"] ) . ",'" . pvs_result( $_POST["user"] ) . "'," . ( int )
	$_POST["ctemplate"] . ")";
$db->execute( $sql );
?>