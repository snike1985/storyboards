<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

// Enable full-blown error reporting. http://twitter.com/rasmus/status/7448448829
error_reporting( -1 );

// Set plain text headers
header( "Content-type: text/plain; charset=utf-8" );

// Include the SDK
require_once PVS_PATH . 'includes/plugins/amazon/sdk.class.php';



if ( $pvs_global_settings["amazon"] == 0 ) {
	exit();
}

//amazon server
$amazon_server = 0;

//Delete files massive
$delete_mass = array();

//Define all publications from the local server
$sql_local = "";
$sql = "select id from " . PVS_DB_PREFIX . "filestorage where types=2";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$amazon_server = $rs->row["id"];
}

if ( $amazon_server == 0 ) {
	exit();
}

//Create containers
$s3 = new AmazonS3();

// Create our new bucket in the US-West region.
if ( $pvs_global_settings["amazon_region"] == "REGION_US_E1" ) {
	$region = AmazonS3::REGION_US_E1;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_US_W1" ) {
	$region = AmazonS3::REGION_US_W1;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_EU_W1" ) {
	$region = AmazonS3::REGION_EU_W1;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_APAC_SE1" ) {
	$region = AmazonS3::REGION_APAC_SE1;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_APAC_NE1" ) {
	$region = AmazonS3::REGION_APAC_NE1;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_US_W2" ) {
	$region = AmazonS3::REGION_US_W2;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_EU_W2" ) {
	$region = AmazonS3::REGION_EU_W2;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_APAC_SE2" ) {
	$region = AmazonS3::REGION_APAC_SE2;
}
if ( $pvs_global_settings["amazon_region"] == "REGION_SA_E1" ) {
	$region = AmazonS3::REGION_SA_E1;
}

$bucket_files = $pvs_global_settings["amazon_prefix"] . "-files";
//$container_files = $s3->create_bucket($bucket_files,$region);

$bucket_previews = $pvs_global_settings["amazon_prefix"] . "-previews";
//$container_previews = $s3->create_bucket($bucket_previews,$region);

/*
if (!$container_files->isOK()) {
echo("Error. It is impossible to create the bucket '".$bucket_files."'");
exit();
}

if (!$container_previews->isOK()) {
echo("Error. It is impossible to create the bucket '".$bucket_previews."'");
exit();
}
*/

//Select all publications
$sql = "select id, media_id, title, data, published, server1, server2, url_jpg, url_png, url_gif, url_raw, url_tiff, url_eps from " .
	PVS_DB_PREFIX . "media where published=1 and server2=0 order by data desc limit 0,5";
//echo($sql);
$rs->open( $sql );
while ( ! $rs->eof ) {
	$storage_flag = true;

	$message_log = "";

	$publication_path = pvs_upload_dir() . pvs_server_url( $rs->
		row["server1"] ) . "/" . $rs->row["id"];
	//echo($publication_path."<br>");

	//Define items for every publication
	$items_mass = array();
	if ( $rs->row["media_id"] == 1 ) {
		if ( $rs->row["url_jpg"] != "" )
		{
			$items_mass[$rs->row["url_jpg"]] = -1;
		}
		if ( $rs->row["url_png"] != "" )
		{
			$items_mass[$rs->row["url_png"]] = -1;
		}
		if ( $rs->row["url_gif"] != "" )
		{
			$items_mass[$rs->row["url_gif"]] = -1;
		}
		if ( $rs->row["url_raw"] != "" )
		{
			$items_mass[$rs->row["url_raw"]] = -1;
		}
		if ( $rs->row["url_tiff"] != "" )
		{
			$items_mass[$rs->row["url_tiff"]] = -1;
		}
		if ( $rs->row["url_eps"] != "" )
		{
			$items_mass[$rs->row["url_eps"]] = -1;
		}
	} else {
		$sql = "select id,url from " . PVS_DB_PREFIX . "items where id_parent=" . $rs->
			row["id"] . " and shipped<>1";
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			while ( ! $ds->eof )
			{
				if ( $ds->row["url"] != "" )
				{
					$items_mass[$ds->row["url"]] = $ds->row["id"];
				}
				$ds->movenext();
			}
		}
	}

	//View publication's folders
	$dir = opendir( $publication_path );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." && $file <> '.DS_Store' && $file <>
			'index.html' ) {
			//echo($publication_path."/".$file."<br>");

			$width = 0;
			$height = 0;
			if ( preg_match( "/\.jpg$/i", $file ) or preg_match( "/\.jpeg$/i", $file ) or
				preg_match( "/\.png$/i", $file ) or preg_match( "/\.gif$/i", $file ) )
			{
				$size = getimagesize( $publication_path . "/" . $file );
				$width = $size[0];
				$height = $size[1];
			}

			if ( preg_match( "/thumb/i", $file ) )
			{
				$new_filename = $rs->row["id"] . "_" . $file;
				$s3->batch()->create_object( $bucket_previews, $new_filename, array(
					'fileUpload' => $publication_path . "/" . $file,
					'acl' => AmazonS3::ACL_PUBLIC,
					) );

				$file_upload_response = $s3->batch()->send();

				$message_log .= "The file " . $file . " has been moved to Amazon S3<br>";

				if ( $file_upload_response->areOK() )
				{
					$uri = $s3->get_object_url( $bucket_previews, $new_filename );
					$url = explode( "/" . $new_filename, $uri );

					$sql = "select id_parent from " . PVS_DB_PREFIX .
						"filestorage_files where id_parent=" . $rs->row["id"] .
						" and item_id=0 and filename1='" . $file . "'";
					$ds->open( $sql );
					if ( $ds->eof )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"filestorage_files (id_parent,item_id,url,filename1,filename2,filesize,server1,pdelete,width,height) values (" .
							$rs->row["id"] . ",0,'" . $url[0] . "','" . $file . "','" . $new_filename . "'," .
							filesize( $publication_path . "/" . $file ) . "," . $amazon_server . ",0," . $width .
							"," . $height . ")";
						$db->execute( $sql );
					}
				} else
				{
					$storage_flag = false;
				}
			} else
			{
				//Define extention
				$file_mass = explode( ".", $file );
				$file_extention = $file_mass[count( $file_mass ) - 1];

				$new_filename = $rs->row["id"] . "_" . md5( pvs_create_password() . $rs->row["id"] .
					pvs_create_password() ) . "." . $file_extention;

				$s3->batch()->create_object( $bucket_files, $new_filename, array(
					'fileUpload' => $publication_path . "/" . $file,
					'acl' => AmazonS3::ACL_PUBLIC,
					) );

				$file_upload_response = $s3->batch()->send();

				if ( $file_upload_response->areOK() )
				{
					$uri = $s3->get_object_url( $bucket_files, $new_filename );
					$url = explode( "/" . $new_filename, $uri );

					$message_log .= "The file " . $file . " has been moved to Amazon S3<br>";

					if ( isset( $items_mass[$file] ) )
					{
						$sql = "select id_parent from " . PVS_DB_PREFIX .
							"filestorage_files where id_parent=" . $rs->row["id"] . " and item_id=" . $items_mass[$file];
						$ds->open( $sql );
						if ( $ds->eof or $items_mass[$file] == -1 )
						{
							$sql = "insert into " . PVS_DB_PREFIX .
								"filestorage_files (id_parent,item_id,url,filename1,filename2,filesize,server1,pdelete,width,height) values (" .
								$rs->row["id"] . "," . $items_mass[$file] . ",'" . $url[0] . "','" . $file .
								"','" . $new_filename . "'," . filesize( $publication_path . "/" . $file ) . "," .
								$amazon_server . ",0," . $width . "," . $height . ")";
							$db->execute( $sql );
						} else
						{
							$sql = "update " . PVS_DB_PREFIX . "filestorage_files set filename1='" . $file .
								"',filename2='" . $new_filename . "',url='" . $url[0] . "',filesize=" . filesize( $publication_path .
								"/" . $file ) . ",width=" . $width . ",height=" . $height . " where id_parent=" .
								$rs->row["id"] . " and item_id=" . $items_mass[$file];
							$db->execute( $sql );
						}
					}
				} else
				{
					$storage_flag = false;
				}
			}
		}
	}
	closedir( $dir );

	unset( $items_mass );

	$delete_mass[] = $rs->row["id"];

	if ( $storage_flag == true ) {
		$sql = "update " . PVS_DB_PREFIX . "media set server2=" . $amazon_server .
			" where id=" . $rs->row["id"];
		$db->execute( $sql );

		$message_log .= "The publication ID = " . $rs->row["id"] .
			" has been moved to the amazon server.<br>";
	} else {
		$message_log .= "Error. The publication ID = " . $rs->row["id"] .
			" wasn't moved to the amazon server.<br>";
	}

	//Logs
	$sql = "insert into " . PVS_DB_PREFIX .
		"filestorage_logs (publication_id,logs,data) values (" . $rs->row["id"] . ",'" .
		$message_log . "'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date
		( "m" ), date( "d" ), date( "Y" ) ) . ")";
	$db->execute( $sql );
	//echo($message_log);

	$rs->movenext();
}

//delete files from the local server
for ( $i = 0; $i < count( $delete_mass ); $i++ ) {
	pvs_delete_files( ( int )$delete_mass[$i], false );
}

//Delete removed files from the clouds server

$sql = "select filename2,item_id,filename1,id_parent,pdelete from " .
	PVS_DB_PREFIX . "filestorage_files where pdelete=1";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$delete_flag = true;

	if ( $rs->row["item_id"] == 0 ) {
		$s3->batch()->delete_object( $bucket_previews, $rs->row["filename2"] );
		$file_upload_response = $s3->batch()->send();
		if ( ! $file_upload_response->areOK() ) {
			$delete_flag = false;
		}
	} else {
		$s3->batch()->delete_object( $bucket_files, $rs->row["filename2"] );
		$file_upload_response = $s3->batch()->send();
		if ( ! $file_upload_response->areOK() ) {
			$delete_flag = false;
		}
	}

	if ( $delete_flag ) {
		$sql = "delete from " . PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->
			row["id"] . " and filename2='" . $rs->row["filename2"] . "'";
		$db->execute( $sql );
	}

	$rs->movenext();
}

?>