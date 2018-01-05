<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printscategories" );

$sql = "delete from " . PVS_DB_PREFIX . "prints_categories where id=" . ( int )
	$_GET["id"];
$db->execute( $sql );
?>
