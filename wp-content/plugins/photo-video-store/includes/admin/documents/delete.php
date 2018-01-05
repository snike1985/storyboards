<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_documents" );

$sql = "select id,filename from " . PVS_DB_PREFIX . "documents";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "documents where id=" . $rs->row["id"];
		$db->execute( $sql );

		if ( $rs->row["filename"] != '' and file_exists( pvs_upload_dir() . "/content/users/doc_" . $rs->row["id"] . "_" . $rs->row["filename"] ) ) {
			unlink( pvs_upload_dir() . "/content/users/doc_" . $rs->row["id"] . "_" . $rs->row["filename"] );
		}
	}
	$rs->movenext();
}

?>
