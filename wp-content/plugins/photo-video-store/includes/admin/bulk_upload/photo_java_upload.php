<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_bulkupload" );

//Zip library
include ( PVS_PATH. "includes/plugins/zip/pclzip.lib.php" );

$swait = false;



$tmp_folder = "user_" . get_current_user_id();

$afiles = array();

$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." ) {
		if ( preg_match( "/.zip$/i", $file ) ) {
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
		$photo = "";

		$fileName = preg_replace( "/\.zip$/i", "", $afiles[$n] );
		$title = preg_replace( "/\.jpg$|\.jpeg$/i", "", str_replace( "_", "", $fileName ) );

		$pub_vars = array();
		$pub_vars["title"] = $title;
		$pub_vars["description"] = "";
		$pub_vars["keywords"] = "";
		$pub_vars["userid"] = pvs_user_login_to_id( $_POST["author"] );
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

		//Folder
		$folder = $id;

		//upload file for sale
		$archive = new PclZip( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
			"/" . $afiles[$n] );
		if ( $archive->extract( PCLZIP_OPT_PATH, pvs_upload_dir() .
			$site_servers[$site_server_activ] . "/" . $folder ) == true ) {
			$ext = explode( ".", $fileName );
			$filename_old = "original." . strtolower( $ext[count( $ext ) - 1] );

			copy( pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/" .
				$filename_old, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder .
				"/" . $fileName );

			$sql = "update " . PVS_DB_PREFIX . "media set url_jpg='" . pvs_result( $fileName ) .
				"' where id=" . $id;
			$db->execute( $sql );

			//IPTC support
			pvs_publication_iptc_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/" . $fileName );

			//Create photo sizes
			pvs_publication_photo_sizes_add( $id, $fileName, false );

			//Rights managed
			if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] == 1 )
			{
				if ( isset( $_POST["rights_id"] ) )
				{
					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )@$_POST["rights_id"] .
						" where id=" . $id;
					$db->execute( $sql );

					//Create photo sizes
					pvs_publication_photo_sizes_add( $id, $fileName, false, "rights_managed", ( int )
						@$_POST["rights_id"] );
				}
			} else
			{
				//Create photo sizes
				pvs_publication_photo_sizes_add( $id, $fileName, false );
			}

			pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/thumb2.jpg" );

			if ( $pvs_global_settings["prints"] and $pvs_global_settings["prints_previews"] and
				$pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
				$pvs_global_settings["thumb_width2"] )
			{
				pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb_print.jpg" );
			}
		}

		//prints
		if ( $pvs_global_settings["prints_users"] ) {
			pvs_publication_prints_add( $id, false );
		}
	}
}

//Remove temp files
$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." ) {
		@unlink( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $file );
	}
}

?>