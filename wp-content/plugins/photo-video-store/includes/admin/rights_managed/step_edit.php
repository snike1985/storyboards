<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$sql = "update " . PVS_DB_PREFIX . "rights_managed_structure set title='" .
	pvs_result( $_REQUEST["title"] ) . "' where types=0 and id=" . ( int )$_REQUEST["id_element"];
$db->execute( $sql );
?>