<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_search" );

$sql = "delete from " . PVS_DB_PREFIX . "search_history";
$db->execute( $sql );

?>
