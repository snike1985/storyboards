<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_catalog" );

$sql = "select server1,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps from " .
	PVS_DB_PREFIX . "media where id=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
		( int )$_GET["id"] . "/" . $rs->row["url_" . pvs_result( $_GET["file"] )] ) and
		$rs->row["url_" . pvs_result( $_GET["file"] )] != "" ) {
		@unlink( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . ( int )
			$_GET["id"] . "/" . $rs->row["url_" . pvs_result( $_GET["file"] )] );
	}

	$sql = "update " . PVS_DB_PREFIX . "media set url_" . pvs_result( $_GET["file"] ) .
		"='' where id=" . ( int )$_GET["id"];
	$db->execute( $sql );

}

?>

