<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_tax" );

$sql = "delete from " . PVS_DB_PREFIX . "tax where id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "tax_regions where id_parent=" . ( int )
	$_GET["id"];
$db->execute( $sql );
?>