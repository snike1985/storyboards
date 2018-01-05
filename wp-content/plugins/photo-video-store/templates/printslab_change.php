<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "update " . PVS_DB_PREFIX . "galleries set title='" . pvs_result( $_POST["title"] ) .
	"' where user_id=" . get_current_user_id() . " and id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "select id from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_GET["id"] .
	" and user_id=" . get_current_user_id();
$ds->open( $sql );
if ( ! $ds->eof ) {

	$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id_parent='" . ( int )
		$_GET["id"] . "' order by data";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( isset( $_POST["delete" . $rs->row["id"]] ) ) {
			$sql = "delete from " . PVS_DB_PREFIX . "galleries_photos where id=" . $rs->row["id"];
			$db->execute( $sql );

			@unlink( pvs_upload_dir() . "/content/galleries/" . ( int )
				$_GET["id"] . "/" . $rs->row["photo"] );
			@unlink( pvs_upload_dir() . "/content/galleries/" . ( int )
				$_GET["id"] . "/thumb" . $rs->row["id"] . ".jpg" );
			@unlink( pvs_upload_dir() . "/content/galleries/" . ( int )
				$_GET["id"] . "/thumb" . $rs->row["id"] . "_2.jpg" );
		} else {
			$sql = "update " . PVS_DB_PREFIX . "galleries_photos set title='" . pvs_result( $_POST["title" .
				$rs->row["id"]] ) . "'  where id=" . $rs->row["id"];
			$db->execute( $sql );
		}
		$rs->movenext();
	}
}

header( "location:" . site_url() . "/printslab/" );?>

