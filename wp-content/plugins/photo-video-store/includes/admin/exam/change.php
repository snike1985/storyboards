<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_exam" );

$sql = "select * from " . PVS_DB_PREFIX . "examinations where id=" . ( int )$_GET["id"];
$ds->open( $sql );
if ( ! $ds->eof ) {
	$sql = "update " . PVS_DB_PREFIX . "examinations set status=" . ( int )$_POST["status"] .
		",comments='" . pvs_result( trim($_POST["comments"]) ) . "' where id=" . ( int )$_GET["id"];
	$db->execute( $sql );

	if ( ( int )$_POST["status"] == 1 ) {
		update_user_meta( $ds->row["user"], 'examination', 1);

		$sql = "update " . PVS_DB_PREFIX . "media set examination=0 where userid=" . $ds->
			row["user"];
		$db->execute( $sql );

	} else {
		update_user_meta( $ds->row["user"], 'examination', 0);

		$sql = "update " . PVS_DB_PREFIX . "media set examination=1 where userid=" . $ds->
			row["user"];
		$db->execute( $sql );
	}

	pvs_send_notification( 'exam_to_seller', $ds->row["user"], $ds->row["id"], "",
		"" );
}

?>