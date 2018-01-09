<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	
	exit();
}

//Zip library
include ( PVS_PATH .
	"includes/plugins/zip/pclzip.lib.php" );

$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_result( pvs_get_user_category () ) . "'";
$dn->open( $sql );
if ( ! $dn->eof and $dn->row["upload"] == 1 ) {
	$swait = false;

	//Upload function
	

	$tmp_folder = "user_" . get_current_user_id();

	$afiles = array();

	$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." ) {
			if ( preg_match( "/.zip$/i", $file ) )
			{
				$file = pvs_result_file( $file );
				$afiles[count( $afiles )] = $file;
			}
		}
	}
	closedir( $dir );
	sort( $afiles );
	reset( $afiles );

	//Examination
	if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () ) {
		$exam = 1;
	} else {
		$exam = 0;
	}

	//Upload set of photos
	if ( isset( $afiles ) ) {
		for ( $n = 0; $n < count( $afiles ); $n++ ) {
			$photo = "";

			$fileName = preg_replace( "/\.zip$/i", "", $afiles[$n] );
			$title = preg_replace( "/\.jpg$|\.jpeg$/i", "", str_replace( "_", "", $fileName ) );

			//free
			$free = 0;
			if ( isset( $_POST["free"] ) )
			{
				$free = 1;
			}

			//Examination
			if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () )
			{
				$exam = 1;
			} else
			{
				$exam = 0;
			}

			$pub_vars = array();
			$pub_vars["title"] = $title;
			$pub_vars["description"] = "";
			$pub_vars["keywords"] = "";
			$pub_vars["userid"] = get_current_user_id();

			if ( $pvs_global_settings["moderation"] )
			{
				$approved = 0;
			} else
			{
				$approved = 1;
			}

			$pub_vars["published"] = $approved;
			$pub_vars["viewed"] = 0;
			$pub_vars["data"] = pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
				date( "d" ), date( "Y" ) );
			$pub_vars["author"] = pvs_result( pvs_get_user_login () );
			$pub_vars["content_type"] = $pvs_global_settings["content_type"];
			$pub_vars["downloaded"] = 0;
			$pub_vars["model"] = 0;
			$pub_vars["examination"] = $exam;
			$pub_vars["server1"] = $site_server_activ;
			$pub_vars["free"] = $free;

			if ( $pvs_global_settings["google_coordinates"] )
			{
				$pub_vars["google_x"] = ( float )$_POST["google_x"];
				$pub_vars["google_y"] = ( float )$_POST["google_y"];
			} else
			{
				$pub_vars["google_x"] = 0;
				$pub_vars["google_y"] = 0;
			}

			if ( isset( $_POST["editorial"] ) )
			{
				$pub_vars["editorial"] = 1;
			} else
			{
				$pub_vars["editorial"] = 0;
			}

			if ( isset( $_POST["adult"] ) )
			{
				$pub_vars["adult"] = 1;
			} else
			{
				$pub_vars["adult"] = 0;
			}

			//Add a new photo to the database
			$id = pvs_publication_media_add(1);

			//Folder
			$folder = $id;

			//upload file for sale
			$archive = new PclZip( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
				"/" . $afiles[$n] );
			if ( $archive->extract( PCLZIP_OPT_PATH, pvs_upload_dir() .
				$site_servers[$site_server_activ] . "/" . $folder ) == true )
			{
				$ext = explode( ".", $fileName );
				$filename_old = "original." . strtolower( $ext[count( $ext ) - 1] );

				rename( pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/" .
					$filename_old, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder .
					"/" . $fileName );

				$sql = "update " . PVS_DB_PREFIX . "media set url_jpg='" . pvs_result( $fileName ) .
					"' where id=" . $id;
				$db->execute( $sql );

				//IPTC support
				pvs_publication_iptc_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/" . $fileName );

				//Rights managed
				if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] == 1 )
				{
					if ( isset( $_POST["rights_id"] ) )
					{
						$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )@$_POST["rights_id"] .
							" where id=" . $id;
						$db->execute( $sql );

						//Create photo sizes
						pvs_publication_photo_sizes_add( $id, $fileName, true, "rights_managed", ( int )
							@$_POST["rights_id"] );
					}
				} else
				{
					//Create photo sizes
					pvs_publication_photo_sizes_add( $id, $fileName, true );
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
			if ( $pvs_global_settings["prints_users"] )
			{
				pvs_publication_prints_add( $id, true );
			}

			//Models
			$sql = "delete from " . PVS_DB_PREFIX . "models_files where publication_id=" . $id;
			$db->execute( $sql );

			foreach ( $_POST as $key => $value )
			{
				if ( preg_match( "/model/i", $key ) )
				{
					$model_id = str_replace( "model", "", $key );

					if ( $model_id != "" )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"models_files (publication_id,model_id,models) value (" . $id . "," . ( int )$model_id .
							"," . ( int )$value . ")";
						$db->execute( $sql );
					}
				}
			}
		}
	}

	//Remove temp files
	pvs_remove_files_from_folder( $tmp_folder );

	if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () ) {
		$rurl = site_url() . "/upload/";
	} else {
		$rurl = site_url() . "/publications/?d=2&t=1";
	}

	pvs_redirect_file( $rurl, $swait );
}
?>