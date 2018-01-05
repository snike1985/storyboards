<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_admin_panel_access( "catalog_bulkupload" );

$swait = false;

$afiles = array();

$dir = opendir( pvs_upload_dir() . $pvs_global_settings["photopreupload"] );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." ) {
		if ( preg_match( "/.jpg$|.jpeg$/i", $file ) ) {
			$afiles[count( $afiles )] = $file;
		}
	}
}
closedir( $dir );
sort( $afiles );
reset( $afiles );

$photo_formats = array();
$sql = "select id,photo_type from " . PVS_DB_PREFIX .
	"photos_formats where enabled=1 and photo_type<>'jpg' order by id";
$dr->open( $sql );
while ( ! $dr->eof ) {
	$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
	$dr->movenext();
}

for ( $j = 0; $j < count( $afiles ); $j++ ) {
	if ( isset( $_POST["f" . $j] ) ) {
		$photo = "";

		if ( $_POST["file" . $j] != "" ) {
			$title = pvs_result( $_POST["title" . $j] );
			if ( $title == "" )
			{
				$ttl = explode( ".", $_POST["file" . $j] );
				$title = str_replace( "_", "", $ttl[0] );
			}

			$pub_vars = array();
			$pub_vars["title"] = $title;
			$pub_vars["description"] = pvs_result( $_POST["description" . $j] );
			$pub_vars["keywords"] = pvs_result( $_POST["keywords" . $j] );
			//$pub_vars["userid"]=pvs_user_login_to_id($_POST["author"]);
			$pub_vars["userid"] = 0;
			$pub_vars["published"] = 1;
			$pub_vars["viewed"] = 0;
			$pub_vars["data"] = pvs_get_time();
			$pub_vars["author"] = pvs_result( $_POST["author"] );
			$pub_vars["content_type"] = $pvs_global_settings["content_type"];
			$pub_vars["downloaded"] = 0;
			$pub_vars["model"] = 0;
			$pub_vars["examination"] = 0;
			$pub_vars["server1"] = $site_server_activ;
			$pub_vars["free"] = 0;

			$pub_vars["google_x"] = 0;
			$pub_vars["google_y"] = 0;
			$pub_vars["editorial"] = 0;
			$pub_vars["adult"] = 0;

			//Add a new photo to the database
			$id = pvs_publication_media_add(1);

			$folder = $id;

			$photo = $pvs_global_settings["photopreupload"] . pvs_result( $_POST["file" .
				$j] );

			//create thumbs and watermark
			if ( $photo != "" and preg_match( "/.jpg$|.jpeg$/i", $photo ) and ! file_exists
				( pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/thumb1.jpg" ) and ! $pvs_global_settings["upload_previews"] )
			{
				pvs_photo_resize( pvs_upload_dir() . $photo, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/thumb1.jpg", 1 );

				pvs_photo_resize( pvs_upload_dir() . $photo, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/thumb2.jpg", 2 );

				pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb2.jpg" );

				if ( $pvs_global_settings["prints"] and $pvs_global_settings["prints_previews"] and
					$pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
					$pvs_global_settings["thumb_width2"] )
				{
					pvs_photo_resize( pvs_upload_dir() . $photo, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder .
						"/thumb_print.jpg", 3 );
					pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/thumb_print.jpg" );
				}
			}

			//Other formats
			$filename = pvs_get_file_info( $_POST["file" . $j], "filename" );
			foreach ( $photo_formats as $key => $value )
			{
				$filecopy = "";

				if ( $value == "tiff" )
				{
					if ( file_exists( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" .
						$filename . ".tif" ) )
					{
						copy( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" . $filename .
							".tif", pvs_upload_dir() . $site_servers[$site_server_activ] .
							"/" . $folder . "/" . $filename . ".tif" );
						$filecopy = $filename . ".tif";
					}
					if ( file_exists( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" .
						$filename . ".tiff" ) )
					{
						copy( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" . $filename .
							".tiff", pvs_upload_dir() . $site_servers[$site_server_activ] .
							"/" . $folder . "/" . $filename . ".tiff" );
						$filecopy = $filename . ".tiff";
					}
				} else
				{
					if ( file_exists( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" .
						$filename . "." . $value ) )
					{
						copy( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" . $filename .
							"." . $value, pvs_upload_dir() . $site_servers[$site_server_activ] .
							"/" . $folder . "/" . $filename . "." . $value );
						$filecopy = $filename . "." . $value;
					}
				}

				if ( $filecopy != "" )
				{
					$sql = "update " . PVS_DB_PREFIX . "media set url_" . $value . "='" .
						pvs_result( $filecopy ) . "' where id=" . $id;
					$db->execute( $sql );
				}

				if ( isset( $_POST["remove"] ) and $filecopy != "" )
				{
					@unlink( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" . $filecopy );
				}
			}

			//create different dimensions
			if ( $photo != "" )
			{
				copy( pvs_upload_dir() . $photo, pvs_upload_dir() .
					$site_servers[$site_server_activ] . "/" . $folder . "/" . pvs_result( $_POST["file" .
					$j] ) );
				$file = $_POST["file" . $j];

				$sql = "update " . PVS_DB_PREFIX . "media set url_jpg='" . pvs_result( $_POST["file" .
					$j] ) . "' where id=" . $id;
				$db->execute( $sql );

				//Rights managed
				if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] == 1 )
				{
					if ( isset( $_POST["rights_id"] ) )
					{
						$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )@$_POST["rights_id"] .
							" where id=" . $id;
						$db->execute( $sql );

						//Create photo sizes
						pvs_publication_photo_sizes_add( $id, $file, false, "rights_managed", ( int )@$_POST["rights_id"] );
					}
				} else
				{
					//Create photo sizes
					pvs_publication_photo_sizes_add( $id, $file, false );
				}

				//Google coordinates
				$exif_info = @exif_read_data( pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/" . pvs_result( $_POST["file" . $j] ), 0, true );
				if ( isset( $exif_info["GPS"]["GPSLongitude"] ) and isset( $exif_info["GPS"]['GPSLongitudeRef'] ) and
					isset( $exif_info["GPS"]["GPSLatitude"] ) and isset( $exif_info["GPS"]['GPSLatitudeRef'] ) )
				{
					$lon = pvs_getGps( $exif_info["GPS"]["GPSLongitude"], $exif_info["GPS"]['GPSLongitudeRef'] );
					$lat = pvs_getGps( $exif_info["GPS"]["GPSLatitude"], $exif_info["GPS"]['GPSLatitudeRef'] );

					$sql = "update " . PVS_DB_PREFIX . "media set google_x=" . $lat . ",google_y=" .
						$lon . " where id=" . $id;
					$db->execute( $sql );
				}
			}

			//Prints
			if ( $pvs_global_settings["prints"] )
			{
				pvs_publication_prints_add( $id, false );
			}

			if ( isset( $_POST["remove"] ) and $photo != "" )
			{
				@unlink( pvs_upload_dir() . $photo );
			}
		}

	}
}
?>