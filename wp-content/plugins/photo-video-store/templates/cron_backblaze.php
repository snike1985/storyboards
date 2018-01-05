<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "download_mimes.php" );

if ( $pvs_global_settings["backblaze"] == 0 ) {
	exit();
}

//amazon server
$backblaze_server = 0;

//Delete files massive
$delete_mass = array();

//Define all publications from the local server
$sql_local = "";
$sql = "select id from " . PVS_DB_PREFIX . "filestorage where types=3";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$backblaze_server = $rs->row["id"];
}

if ( $pvs_global_settings["backblaze_preview"] == '' or $pvs_global_settings["backblaze_files"] == '') {
	exit();
}

//Create containers
$bucket_files = $pvs_global_settings["backblaze_prefix"] . "-files";
$bucket_previews = $pvs_global_settings["backblaze_prefix"] . "-preview";
$bucket_files_id = $pvs_global_settings["backblaze_files"];
$bucket_previews_id = $pvs_global_settings["backblaze_preview"];




$account_id = $pvs_global_settings["backblaze_username"]; // Obtained from your B2 account page
$application_key = $pvs_global_settings["backblaze_api_key"]; // Obtained from your B2 account page
$credentials = base64_encode($account_id . ":" . $application_key);
$url = "https://api.backblazeb2.com/b2api/v1/b2_authorize_account";

$session = curl_init($url);

// Add headers
$headers = array();
$headers[] = "Accept: application/json";
$headers[] = "Authorization: Basic " . $credentials;
curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers

curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
$server_output = curl_exec($session);
curl_close ($session);
$results = json_decode($server_output);

if (!isset($results -> apiUrl) or !isset($results -> authorizationToken)) {
	exit();
}

$api_url = $results -> apiUrl ; // From b2_authorize_account call
$auth_token = $results -> authorizationToken; // From b2_authorize_account call


function pvs_backblaze_upload ($bucket_name, $bucket_id, $file_name,$my_file) {
	global $api_url;
	global $auth_token;
	global $results;
	global $mmtype;
	
	//Get upload URL
	$session = curl_init($api_url .  "/b2api/v1/b2_get_upload_url");

	// Add post fields
	$data = array("bucketId" => $bucket_id);
	$post_fields = json_encode($data);
	curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $auth_token;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up
	$results4 = json_decode($server_output);
	//echo($server_output);
	//Upload file
	$file_extention = pvs_get_file_info( $file_name, "extention" );
	$handle = fopen($my_file, 'r');
	$read_file = fread($handle,filesize($my_file));
	
	$upload_url = $results4->uploadUrl; // Provided by b2_get_upload_url
	$upload_auth_token = $results4->authorizationToken; // Provided by b2_get_upload_url
	$content_type = $mmtype[strtolower( $file_extention )];
	$sha1_of_file_data = sha1_file($my_file);
	
	$session = curl_init($upload_url);
	
	// Add read file as post field
	curl_setopt($session, CURLOPT_POSTFIELDS, $read_file); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $upload_auth_token;
	$headers[] = "X-Bz-File-Name: " . $file_name;
	$headers[] = "Content-Type: " . $content_type;
	$headers[] = "X-Bz-Content-Sha1: " . $sha1_of_file_data;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up
	$results5 = json_decode($server_output);
	//echo($server_output);
	
	$file_result = array();
	
	if (isset($results5->fileName)) {
		$file_result['url'] = $results->downloadUrl . '/file/' . $bucket_name . '/' . $results5->fileName;
		$file_result['id'] = $results5->fileId;
	} else {
		$file_result['url'] = '';
		$file_result['id'] = '';
	}
	return $file_result;
}


//Select all publications
$sql = "select id, media_id, title, data, published, server1, server2, url_jpg, url_png, url_gif, url_raw, url_tiff, url_eps  from " .
	PVS_DB_PREFIX . "media where published=1 and server2=0 order by data desc limit 0,5";

$rs->open( $sql );
while ( ! $rs->eof ) {
	$storage_flag = true;

	$message_log = "";

	$publication_path = pvs_upload_dir(). pvs_server_url( $rs->
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
			echo($publication_path."/".$file."<br>");

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
				$file_upload_response = pvs_backblaze_upload ($bucket_previews, $bucket_previews_id, $new_filename,$publication_path . "/" . $file);

				$message_log .= "The file " . $file . " has been moved to Backblaze B2<br>";
				echo("The file " . $file . " has been moved to Backblaze B2<br>");

				if ( $file_upload_response['url'] != '' )
				{
					$uri = $file_upload_response['url'];
					$url = explode( "/" . $new_filename, $uri );

					$sql = "select id_parent from " . PVS_DB_PREFIX .
						"filestorage_files where id_parent=" . $rs->row["id"] .
						" and item_id=0 and filename1='" . $file . "'";
					$ds->open( $sql );
					if ( $ds->eof )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"filestorage_files (id_parent,item_id,url,filename1,filename2,filesize,server1,pdelete,width,height,file_id) values (" .
							$rs->row["id"] . ",0,'" . $url[0] . "','" . $file . "','" . $new_filename . "'," .
							filesize( $publication_path . "/" . $file ) . "," . $backblaze_server . ",0," . $width .
							"," . $height . ",'"  . pvs_result($file_upload_response['id']) . "')";
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

				$file_upload_response = pvs_backblaze_upload ($bucket_files, $bucket_files_id, $new_filename,$publication_path . "/" . $file);

				if ( $file_upload_response['url'] != '' )
				{
					$uri = $file_upload_response['url'];
					$url = explode( "/" . $new_filename, $uri );

					$message_log .= "The file " . $file . " has been moved to backblaze B2<br>";
					echo("The file " . $file . " has been moved to Backblaze B2<br>");

					if ( isset( $items_mass[$file] ) )
					{
						$sql = "select id_parent from " . PVS_DB_PREFIX .
							"filestorage_files where id_parent=" . $rs->row["id"] . " and item_id=" . $items_mass[$file];
						$ds->open( $sql );
						if ( $ds->eof or $items_mass[$file] == -1 )
						{
							$sql = "insert into " . PVS_DB_PREFIX .
								"filestorage_files (id_parent,item_id,url,filename1,filename2,filesize,server1,pdelete,width,height,file_id) values (" .
								$rs->row["id"] . "," . $items_mass[$file] . ",'" . $url[0] . "','" . $file .
								"','" . $new_filename . "'," . filesize( $publication_path . "/" . $file ) . "," .
								$backblaze_server . ",0," . $width . "," . $height . ",'"  . pvs_result($file_upload_response['id']) . "')";
							$db->execute( $sql );
						} else
						{
							$sql = "update " . PVS_DB_PREFIX . "filestorage_files set filename1='" . $file .
								"',filename2='" . $new_filename . "',url='" . $url[0] . "',filesize=" . filesize( $publication_path .
								"/" . $file ) . ",width=" . $width . ",height=" . $height . ",file_id ='"  . pvs_result($file_upload_response['id']) . "'  where id_parent=" .
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
		$sql = "update " . PVS_DB_PREFIX . "media set server2=" . $backblaze_server .
			" where id=" . $rs->row["id"];
		$db->execute( $sql );

		$message_log .= "The publication ID = " . $rs->row["id"] .
			" has been moved to the backblaze server.<br>";
	} else {
		$message_log .= "Error. The publication ID = " . $rs->row["id"] .
			" wasn't moved to the backblaze server.<br>";
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

$sql = "select filename2,item_id,filename1,id_parent,pdelete,file_id from " .
	PVS_DB_PREFIX . "filestorage_files where pdelete=1";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$delete_flag = true;

	$file_id = $rs->row["file_id"];  // The ID of the file you want to delete
	$file_name = $rs->row["filename2"]; // The file name of the file you want to delete
	
	$session = curl_init($api_url .  "/b2api/v1/b2_delete_file_version");
	
	// Add post fields
	$data = array("fileId" => $file_id, "fileName" => $file_name);
	$post_fields = json_encode($data);
	curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $auth_token;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up

	if ( $delete_flag ) {
		$sql = "delete from " . PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->
			row["id_parent"] . " and filename2='" . $rs->row["filename2"] . "'";
		$db->execute( $sql );
	}

	$rs->movenext();
}

$db->close();
?>