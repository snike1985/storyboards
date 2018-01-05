<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_lightboxes" );

$sql = "select id from " . PVS_DB_PREFIX . "lightboxes";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "lightboxes where id=" . $rs->row["id"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "lightboxes_admin where id_parent=" . $rs->
			row["id"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "lightboxes_files where id_parent=" . $rs->
			row["id"];
		$db->execute( $sql );
		
		if(file_exists(pvs_upload_dir() . "/content/categories/lightbox_" . $rs->row["id"] . ".jpg")) {
			unlink(pvs_upload_dir() . "/content/categories/lightbox_" . $rs->row["id"] . ".jpg");
		}
	}
	$rs->movenext();
}

?>
