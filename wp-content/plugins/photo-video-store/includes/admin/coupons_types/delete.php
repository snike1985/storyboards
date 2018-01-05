<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_couponstypes" );

$sql = "delete from " . PVS_DB_PREFIX . "coupons_types  where id_parent=" . ( int )
	$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "coupons  where coupon_id=" . ( int )$_GET["id"];
$db->execute( $sql );
?>