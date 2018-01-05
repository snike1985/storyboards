<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_creditstypes" );

$sql = "delete from " . PVS_DB_PREFIX . "credits where id_parent=" . ( int )$_GET["id"];
$db->execute( $sql );
?>
