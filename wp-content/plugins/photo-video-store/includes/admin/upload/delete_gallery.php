<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );

$sql = "select id from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "delete from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_GET["id"];
	$db->execute( $sql );

	$sql = "delete from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" . ( int )
		$_GET["id"];
	$db->execute( $sql );

	if ( ( int )$_GET["id"] != 0 and file_exists( pvs_upload_dir() . "/content/galleries/" . ( int )$_GET["id"] ) ) {
		$dir = opendir( pvs_upload_dir() . "/content/galleries/" .
			( int )$_GET["id"] );
		while ( $file = readdir( $dir ) ) {
			if ( $file <> "." && $file <> ".." )
			{
				@unlink( pvs_upload_dir() . "/content/galleries/" . ( int )
					$_GET["id"] . "/" . $file );
			}
		}

		@rmdir( pvs_upload_dir() . "/content/galleries/" . ( int )
			$_GET["id"] );
	}
}
?>