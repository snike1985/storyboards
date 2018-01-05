<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}




$sql = "select a.id,a.generation,a.data2,a.data1,b.id,b.server1,b.userid,b.media_id from " .
	PVS_DB_PREFIX . "ffmpeg_cron a," . PVS_DB_PREFIX .
	"media b where a.data2=0 and b.id=a.id and b.media_id = 2 order by a.data1 limit 0,5";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$server1 = $rs->row["server1"];
	$userid = $rs->row["userid"];

	$url = "";
	$url2 = "";
	$sql = "select price_id,url from " . PVS_DB_PREFIX . "items where id_parent=" .
		$rs->row["id"] . " and shipped=0";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		if ( $ds->row["url"] != "" ) {
			$url2 = $ds->row["url"];

			if ( $ds->row["price_id"] == $rs->row["generation"] )
			{
				$url = $ds->row["url"];
			}
		}
		$ds->movenext();
	}

	if ( $url == "" ) {
		$url = $url2;
	}

	if ( $url != "" and file_exists( pvs_upload_dir() . $site_servers[$server1] .
		"/" . $rs->row["id"] . "/" . $url ) ) {
		pvs_generate_video_preview( pvs_upload_dir() . $site_servers[$server1] .
			"/" . $rs->row["id"] . "/" . $url, 0, 0 );

		$sql = "update " . PVS_DB_PREFIX . "ffmpeg_cron set data2=" . pvs_get_time( date
			( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) .
			" where id=" . $rs->row["id"];
		$db->execute( $sql );

		if ( $userid == 0 or $pvs_global_settings["moderation"] == 0 ) {
			$sql = "update " . PVS_DB_PREFIX . "videos set published=1 where id_parent=" . $rs->
				row["id"];
			$db->execute( $sql );
		}

		echo ( "<p>Previews for video ID#" . $rs->row["id"] .
			" have been generated.</p>" );
	}

	$rs->movenext();
}

?>
