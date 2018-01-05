<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_exam" );

$sql = "delete from " . PVS_DB_PREFIX . "examinations where id=" . ( int )$_GET["id"];
$db->execute( $sql );

?>