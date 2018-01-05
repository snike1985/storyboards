<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_shipping" );

$sql = "delete from " . PVS_DB_PREFIX . "shipping where id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "shipping_regions where id_parent=" . ( int )
	$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "shipping_ranges where id_parent=" . ( int )
	$_GET["id"];
$db->execute( $sql );
?>
