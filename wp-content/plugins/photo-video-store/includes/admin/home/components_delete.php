<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_home" );

$sql = "delete from " . PVS_DB_PREFIX . "components where id=" . ( int )$_GET["id"];
$db->execute( $sql );
?>