<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}




//Generate preview for the photos

$sql = "select id,server1,url_jpg from " . PVS_DB_PREFIX .
	"media where media_id = 1 and id>" . $pvs_global_settings["cron_photos"] .
	" order by id limit 0,5";
$rs->open( $sql );

$photo_id = $pvs_global_settings["cron_photos"];
while ( ! $rs->eof ) {
	$sql = "select url from " . PVS_DB_PREFIX . "filestorage_files where id_parent=" .
		$rs->row["id"];
	$ds->open( $sql );
	if ( $ds->eof ) {
		if ( ! file_exists( pvs_upload_dir() . $site_servers[$rs->
			row["server1"]] . "/" . $rs->row["id"] . "/thumb1.jpg" ) and file_exists
			( pvs_upload_dir() . $site_servers[$rs->row["server1"]] .
			"/" . $rs->row["id"] . "/" . $rs->row["url_jpg"] ) ) {
			pvs_photo_resize( pvs_upload_dir() . $site_servers[$rs->
				row["server1"]] . "/" . $rs->row["id"] . "/" . $rs->row["url_jpg"], pvs_upload_dir() . $site_servers[$rs->row["server1"]] . "/" . $rs->row["id"] .
				"/thumb2.jpg", 2 );

			pvs_photo_resize( pvs_upload_dir() . $site_servers[$rs->
				row["server1"]] . "/" . $rs->row["id"] . "/thumb2.jpg", pvs_upload_dir() . $site_servers[$rs->row["server1"]] . "/" . $rs->row["id"] .
				"/thumb1.jpg", 1 );

			pvs_publication_watermark_add( $rs->row["id"], pvs_upload_dir() . $site_servers[$rs->row["server1"]] . "/" . $rs->row["id"] .
				"/thumb2.jpg" );

			echo ( "<p><img src='" . site_url() . $site_servers[$rs->row["server1"]] . "/" .
				$rs->row["id"] . "/thumb1.jpg'><br><small>Photo ID: " . $rs->row["id"] .
				"</small></p>" );
		}
	}

	$photo_id = $rs->row["id"];

	$rs->movenext();
}

$sql = "update " . PVS_DB_PREFIX . "settings set svalue=" . $photo_id .
	" where setting_key='cron_photos'";
$db->execute( $sql );

?>