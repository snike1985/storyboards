<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_admin_panel_access( "catalog_collections" );

$sql = "select id from " . PVS_DB_PREFIX . "collections where id = ". (int) $_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "delete from " . PVS_DB_PREFIX . "collections where id=" . $rs->row["id"];
	$db->execute( $sql );

	$sql = "delete from " . PVS_DB_PREFIX . "collections_items where collection_id=" . $rs->row["id"];
	$db->execute( $sql );
	
	if(file_exists(pvs_upload_dir() . "/content/categories/collection_" . ( int )@$_GET["id"] . ".jpg")) {
		unlink(pvs_upload_dir() . "/content/categories/collection_" . ( int )@$_GET["id"] . ".jpg");
	}
}


?>
