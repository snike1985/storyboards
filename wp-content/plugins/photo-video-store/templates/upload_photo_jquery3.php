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

$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_result( pvs_get_user_category () ) . "'";
$dn->open( $sql );
if ( ! $dn->eof and $dn->row["upload"] == 1 ) {
	$lphoto = $dn->row["photolimit"];

	$swait = false;

	//Upload function
	

	$tmp_folder = "user_" . get_current_user_id();

	$afiles = array();

	$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." ) {
			if ( preg_match( "/.jpg$|.jpeg$/i", $file ) and ! preg_match( "/thumb/i", $file ) )
			{
				$file = pvs_result_file( $file );
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

	//free
	$free = 0;
	if ( isset( $_POST["free"] ) ) {
		$free = 1;
	}

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

			$fileName = preg_replace( "/\.jpg$/i", "", $afiles[$n] );
			$title = str_replace( "_", "", $fileName );

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
			if ( filesize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" .
				$afiles[$n] ) > 0 )
			{
				$photo = $site_servers[$site_server_activ] . "/" . $folder . "/" . $afiles[$n];
				$size = getimagesize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
					"/" . $afiles[$n] );

				//Copy original photo
				@copy( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $afiles[$n],
					pvs_upload_dir() . $photo );

				$sql = "update " . PVS_DB_PREFIX . "media set url_jpg='" . pvs_result( $afiles[$n] ) .
					"' where id=" . $id;
				$db->execute( $sql );

				//Copy thumb1
				if ( file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
					"/thumbnail/" . $afiles[$n] ) )
				{
					@copy( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
						"/thumbnail/" . $afiles[$n], pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/thumb1.jpg" );
				} else
				{
					pvs_photo_resize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
						"/" . $afiles[$n], pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/thumb1.jpg", 1 );
				}

				//Copy thumb2
				pvs_photo_resize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
					"/" . $afiles[$n], pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb2.jpg", 2 );

				pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb2.jpg" );

				//Print thumb
				if ( $pvs_global_settings["prints"] and $pvs_global_settings["prints_previews"] and
					$pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
					$pvs_global_settings["thumb_width2"] )
				{
					pvs_photo_resize( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
						"/" . $afiles[$n], pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/thumb_print.jpg", 3 );
					pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/thumb_print.jpg" );
				}

				//Other formats
				$filename = pvs_get_file_info( $afiles[$n], "filename" );
				foreach ( $photo_formats as $key => $value )
				{
					$filecopy = "";

					if ( $value == "tiff" )
					{
						if ( file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
							"/" . $filename . ".tif" ) )
						{
							copy( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $filename .
								".tif", pvs_upload_dir() . $site_servers[$site_server_activ] .
								"/" . $folder . "/" . $filename . ".tif" );
							$filecopy = $filename . ".tif";
						}
						if ( file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
							"/" . $filename . ".tiff" ) )
						{
							copy( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $filename .
								".tiff", pvs_upload_dir() . $site_servers[$site_server_activ] .
								"/" . $folder . "/" . $filename . ".tiff" );
							$filecopy = $filename . ".tiff";
						}
					} else
					{
						if ( file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
							"/" . $filename . "." . $value ) )
						{
							copy( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $filename .
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
				}

				$swait = true;
			}

			if ( $photo != "" )
			{
				//IPTC support
				pvs_publication_iptc_add( $id, pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
					"/" . $afiles[$n] );

				//Rights managed
				if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] == 1 )
				{
					if ( isset( $_POST["rights_id"] ) )
					{
						$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )@$_POST["rights_id"] .
							" where id=" . $id;
						$db->execute( $sql );

						//Create photo sizes
						pvs_publication_photo_sizes_add( $id, $afiles[$n], false, "rights_managed", ( int )
							@$_POST["rights_id"] );
					}
				} else
				{
					//Create photo sizes
					pvs_publication_photo_sizes_add( $id, $afiles[$n], false );
				}
			}

			//prints
			if ( $pvs_global_settings["prints_users"] )
			{
				pvs_publication_prints_add( $id, false );
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
			//End. Models

			//End upload files
		}
	}

	pvs_remove_files_from_folder( $tmp_folder );

	if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () ) {
		$rurl = site_url() . "/upload/";
	} else {
		$rurl = site_url() . "/publications/?d=2&t=1";
	}

	pvs_redirect_file( $rurl, $swait );
}
?>