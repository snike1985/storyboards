<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select id from " . PVS_DB_PREFIX . "galleries where user_id=" . ( int )
	get_current_user_id() . " and id=" . ( int )$_POST["gallery_id"];
$rs->open( $sql );
if ( $rs->eof ) {
	exit();
}

$lphoto = $pvs_global_settings["prints_lab_filesize"];

//Upload function


$tmp_folder = "user_" . get_current_user_id();

$afiles = array();

$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." ) {
		if ( preg_match( "/.jpg$|.jpeg$/i", $file ) and ! preg_match( "/thumb/i", $file ) ) {
			$file = pvs_result_file( $file );
			$afiles[count( $afiles )] = $file;
		}
	}
}
closedir( $dir );
sort( $afiles );
reset( $afiles );

//Upload set of photos
if ( isset( $afiles ) ) {
	for ( $n = 0; $n < count( $afiles ); $n++ ) {
		$gallery_folder = ( int )$_POST["gallery_id"];
		if ( ! file_exists( pvs_upload_dir() . "/content/galleries/" . $gallery_folder ) ) {
			mkdir( pvs_upload_dir() . "/content/galleries/" . $gallery_folder );
			@copy( pvs_upload_dir() . "/content/index.html", pvs_upload_dir() .
				"/content/galleries/" . $gallery_folder . "/index.html" );
		}

		$fileName = preg_replace( "/\.jpg$/i", "", $afiles[$n] );
		$title = str_replace( "_", "", $fileName );

		if ( filesize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" .
			$afiles[$n] ) > 0 ) {
			$size = getimagesize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
				"/" . $afiles[$n], $info );
			$wd1 = $pvs_global_settings["thumb_width"];
			$wd2 = $pvs_global_settings["prints_previews_width"];
			if ( isset( $size[1] ) )
			{
				if ( $size[0] < $size[1] )
				{
					$wd1 = $size[0] * $pvs_global_settings["thumb_width"] / $size[1];
					$wd2 = $size[0] * $pvs_global_settings["prints_previews_width"] / $size[1];
				}
			}

			if ( isset( $info["APP13"] ) )
			{
				$iptc = iptcparse( $info["APP13"] );

				if ( isset( $iptc["2#005"][0] ) and $iptc["2#005"][0] != "" )
				{
					$title = pvs_result( $iptc["2#005"][0] );
				}
			}

			$photo_path = pvs_upload_dir() . "/content/galleries/" . $gallery_folder .
				"/thumb_" . $afiles[$n];
			@copy( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $afiles[$n],
				$photo_path );

			$sql = "insert into " . PVS_DB_PREFIX .
				"galleries_photos (id_parent,title,photo,data) values (" . ( int )$_POST["gallery_id"] .
				",'" . $title . "','thumb_" . $afiles[$n] . "'," . pvs_get_time( date( "H" ),
				date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . ")";
			$db->execute( $sql );

			$sql = "update " . PVS_DB_PREFIX . "galleries set data=" . pvs_get_time( date( "H" ),
				date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . " where id=" . ( int )
				$_POST["gallery_id"];
			$db->execute( $sql );

			$sql = "select id from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" . ( int )
				$_POST["gallery_id"] . " order by id desc";
			$rs->open( $sql );
			$photo_id = $rs->row["id"];

			pvs_easyResize( $photo_path, pvs_upload_dir() .
				"/content/galleries/" . $gallery_folder . "/thumb" . $photo_id . ".jpg", 100, $wd1 );

			if ( $pvs_global_settings["prints_previews"] )
			{
				pvs_easyResize( $photo_path, pvs_upload_dir() .
					"/content/galleries/" . $gallery_folder . "/thumb" . $photo_id . "_2.jpg", 100,
					$wd2 );
			}
		}
	}
}

pvs_remove_files_from_folder( $tmp_folder );

pvs_redirect_file( site_url() . "/printslab/", true );

?>