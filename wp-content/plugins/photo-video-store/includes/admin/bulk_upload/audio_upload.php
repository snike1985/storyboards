<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_bulkupload" );


$swait = false;

$ids = array();
$rights_managed = 0;

if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] == 1 ) {
	$sql = "select id from " . PVS_DB_PREFIX . "rights_managed where audio=1";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$ids[] = $ds->row["id"];
		$ds->movenext();
	}
	$rights_managed = 1;
} else
{
	$sql = "select id_parent from " . PVS_DB_PREFIX .
		"audio_types order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$ids[] = $ds->row["id_parent"];
		$ds->movenext();
	}
}

for ( $j = 0; $j < $pvs_global_settings["bulk_upload"]; $j++ ) {
	$flag_upload = false;

	for ( $i = 0; $i < count( $ids ); $i++ ) {
		if ( isset( $_POST["file" . $ids[$i] . "_" . $j] ) and $_POST["file" . $ids[$i] .
			"_" . $j] != "" ) {
			$flag_upload = true;
		}
	}

	$audio = "";

	if ( $flag_upload == true ) {
		$title = pvs_result( $_POST["title" . $j] );

		if ( $title == "" ) {
			$title = "audio" . $j;
		}

		$duration = 0;
		$format = "";
		$source = "";
		$holder = "";
		if ( isset( $_POST["format"] ) ) {
			$format = pvs_result( $_POST["format"] );
		}
		if ( isset( $_POST["source"] ) ) {
			$source = pvs_result( $_POST["source"] );
		}
		if ( isset( $_POST["holder"] ) ) {
			$holder = pvs_result( $_POST["holder"] );
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
		$pub_vars["model"] = ( int )$_POST["model" . $j];
		$pub_vars["examination"] = 0;
		$pub_vars["server1"] = $site_server_activ;
		$pub_vars["free"] = 0;

		$pub_vars["duration"] = 3600 * $_POST["duration" . $j . "_hour"] + 60 * $_POST["duration" .
			$j . "_minute"] + ( int )$_POST["duration" . $j . "_second"];
		$pub_vars["format"] = $format;
		$pub_vars["source"] = $source;
		$pub_vars["holder"] = $holder;

		$pub_vars["google_x"] = 0;
		$pub_vars["google_y"] = 0;
		$pub_vars["adult"] = 0;

		//Add a new audio to the database
		$id = pvs_publication_media_add(3);

		$folder = $id;

		$previewaudio = $pvs_global_settings["audiopreupload"] . pvs_result( $_POST["previewaudio" .
			$j] );
		$previewphoto = $pvs_global_settings["audiopreupload"] . pvs_result( $_POST["previewphoto" .
			$j] );

		//copy file
		if ( $rights_managed == 0 ) {
			$sql = "select * from " . PVS_DB_PREFIX . "audio_types order by priority";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $ds->row["shipped"] != 1 )
				{
					if ( isset( $_POST["file" . $ds->row["id_parent"] . "_" . $j] ) and $_POST["file" .
						$ds->row["id_parent"] . "_" . $j] != "" )
					{
						$audio = $pvs_global_settings["audiopreupload"] . pvs_result( $_POST["file" .
							$ds->row["id_parent"] . "_" . $j] );
						copy( pvs_upload_dir() . $audio, pvs_upload_dir() .
							$site_servers[$site_server_activ] . "/" . $folder . "/" . pvs_result( $_POST["file" .
							$ds->row["id_parent"] . "_" . $j] ) );
						$file = $_POST["file" . $ds->row["id_parent"] . "_" . $j];

						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . $ds->row["title"] . "','" . pvs_result( $file ) . "'," . floatval( $ds->
							row["price"] ) . "," . $ds->row["priority"] . ",0," . $ds->row["id_parent"] .
							")";
						$db->execute( $sql );
					}
				} else
				{
					if ( isset( $_POST["file" . $ds->row["id_parent"] . "_" . $j] ) )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . $ds->row["title"] . "','" . pvs_result( $file ) . "'," . floatval( $ds->
							row["price"] ) . "," . $ds->row["priority"] . ",1," . $ds->row["id_parent"] .
							")";
						$db->execute( $sql );
					}
				}

				$ds->movenext();
			}
		} else {
			$flag_rights = false;

			$sql = "select id,price,title from " . PVS_DB_PREFIX .
				"rights_managed where audio=1";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( isset( $_POST["file" . $ds->row["id"] . "_" . $j] ) and $_POST["file" . $ds->
					row["id"] . "_" . $j] != "" and $flag_rights == false )
				{
					$video = $pvs_global_settings["audiopreupload"] . pvs_result( $_POST["file" .
						$ds->row["id"] . "_" . $j] );
					copy( pvs_upload_dir() . $video, pvs_upload_dir() .
						$site_servers[$site_server_activ] . "/" . $folder . "/" . pvs_result( $_POST["file" .
						$ds->row["id"] . "_" . $j] ) );

					$file = $_POST["file" . $ds->row["id"] . "_" . $j];

					$sql = "insert into " . PVS_DB_PREFIX .
						"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
						",'" . $ds->row["title"] . "','" . pvs_result( $file ) . "'," . floatval( $ds->
						row["price"] ) . ",0,0," . $ds->row["id"] . ")";
					$db->execute( $sql );

					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )$ds->
						row["id"] . " where id=" . $id;
					$db->execute( $sql );

					$flag_rights = true;
				}

				$ds->movenext();
			}
		}

		//Audio preview
		$fn = explode( ".", strtolower( $_POST["previewaudio" . $j] ) );
		if ( $_POST["previewaudio" . $j] != "" and $fn[count( $fn ) - 1] == "mp3" ) {
			$vp = $site_servers[$site_server_activ] . "/" . $folder . "/thumb." .
				$fn[count( $fn ) - 1];
			copy( pvs_upload_dir() . $previewaudio, pvs_upload_dir() . $vp );
		}

		//Photo preview
		$fn = explode( ".", strtolower( $_POST["previewphoto" . $j] ) );
		if ( $_POST["previewphoto" . $j] != "" and ( $fn[count( $fn ) - 1] == "jpg" or $fn[count
			( $fn ) - 1] == "jpeg" ) ) {
			$vp = $site_servers[$site_server_activ] . "/" . $folder . "/thumb." .
				$fn[count( $fn ) - 1];
			$vp_big = $site_servers[$site_server_activ] . "/" . $folder .
				"/thumb100." . $fn[count( $fn ) - 1];
			pvs_photo_resize( pvs_upload_dir() . $previewphoto, pvs_upload_dir() .
				$vp, 1 );

			pvs_photo_resize( pvs_upload_dir() . $previewphoto, pvs_upload_dir() .
				$vp_big, 2 );
		}
	}
}
?>