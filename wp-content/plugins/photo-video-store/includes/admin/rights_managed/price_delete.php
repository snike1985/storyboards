<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$sql = "delete from " . PVS_DB_PREFIX . "rights_managed where id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX .
	"rights_managed_structure where price_id=" . ( int )$_GET["id"];
$db->execute( $sql );
?>