<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_catalog" );

$sql = "update " . PVS_DB_PREFIX . "content_filter set words='" . pvs_result( $_POST["filter"] ) .
	"'";
$db->execute( $sql );

?>

