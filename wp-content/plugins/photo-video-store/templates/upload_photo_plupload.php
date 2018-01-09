<?php
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

// Make sure file is not cached (as it happens for example on iOS devices)

header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-store, no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );

if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	exit;
}


$lphoto = 0;
$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_result( pvs_get_user_category () ) . "'";
$dn->open( $sql );
if ( ! $dn->eof and $dn->row["upload"] == 1 ) {
	$lphoto = $dn->row["photolimit"];
}

$tmp_folder = "user_" . get_current_user_id();

/*
if ( ! file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder ) ) {
	mkdir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
}
*/

// Settings
$targetDir = pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder;

// Get a file name
if ( isset( $_REQUEST["name"] ) ) {
	$fileName = $_REQUEST["name"];
} elseif ( ! empty( $_FILES ) ) {
	$fileName = $_FILES["file"]["name"];
} else
{
	$fileName = uniqid( "file_" );
}

$filePath = $targetDir . "/" . $fileName;

// Chunking might be enabled
$chunk = isset( $_REQUEST["chunk"] ) ? intval( $_REQUEST["chunk"] ) : 0;
$chunks = isset( $_REQUEST["chunks"] ) ? intval( $_REQUEST["chunks"] ) : 0;

// Open temp file
if ( ! $out = @fopen( "{$filePath}.part", $chunks ? "ab" : "wb" ) ) {
	die( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
}

if ( ! empty( $_FILES ) ) {
	if ( $_FILES["file"]["error"] || ! is_uploaded_file( $_FILES["file"]["tmp_name"] ) ) {
		die( '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}' );
	}

	// Read binary input stream and append it to temp file
	if ( ! $in = @fopen( $_FILES["file"]["tmp_name"], "rb" ) ) {
		die( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
	}
} else
{
	if ( ! $in = @fopen( "php://input", "rb" ) ) {
		die( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
	}
}

while ( $buff = fread( $in, 4096 ) ) {
	fwrite( $out, $buff );
}

@fclose( $out );
@fclose( $in );

// Check if file has been uploaded
if ( ! $chunks || $chunk == $chunks - 1 ) {
	// Strip the temp .part suffix off
	rename( "{$filePath}.part", $filePath );
}

// Return Success JSON-RPC response
die( '{"jsonrpc" : "2.0", "result" : null, "id" : "id"}' );

?>