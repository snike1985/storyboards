<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_productsoptions" );

$sql = "delete from " . PVS_DB_PREFIX . "products_options where id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX .
	"products_options_items where id_parent=" . ( int )$_GET["id"];
$db->execute( $sql );
?>
