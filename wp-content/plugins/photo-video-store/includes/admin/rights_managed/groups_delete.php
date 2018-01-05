<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$sql = "delete from " . PVS_DB_PREFIX . "rights_managed_groups where id=" . ( int )
	$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX .
	"rights_managed_options where id_parent=" . ( int )$_GET["id"];
$db->execute( $sql );
?>
