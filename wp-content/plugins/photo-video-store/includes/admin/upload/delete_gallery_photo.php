<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );

$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id=" . ( int )
	$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "delete from " . PVS_DB_PREFIX . "galleries_photos where id=" . $rs->row["id"];
	$db->execute( $sql );

	@unlink( pvs_upload_dir() . "/content/galleries/" . ( int )
		$_GET["gallery_id"] . "/" . $rs->row["photo"] );
	@unlink( pvs_upload_dir() . "/content/galleries/" . ( int )
		$_GET["gallery_id"] . "/thumb" . $rs->row["id"] . ".jpg" );
}

$_GET["id"] = $_GET["gallery_id"];
?>