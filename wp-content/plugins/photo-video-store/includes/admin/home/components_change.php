<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_home" );

$sql = "update " . PVS_DB_PREFIX . "components set title='" . pvs_result( $_POST["title"] ) .
	"',content='" . pvs_result( $_POST["content"] ) . "',quantity=" . pvs_result( $_POST["quantity"] ) .
	",types='" . pvs_result( $_POST["types"] ) . "',category=" . pvs_result( $_POST["category"] ) .
	",user='" . pvs_result( $_POST["user"] ) . "',template=" . ( int )$_POST["ctemplate"] .
	" where id=" . ( int )$_GET["id"];
$db->execute( $sql );
?>