<?php
/*
* jQuery File Upload Plugin PHP Class 7.1.4
* https://github.com/blueimp/jQuery-File-Upload
*
* Copyright 2010, Sebastian Tschan
* https://blueimp.net
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/MIT
*/

if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$tmp_folder = "user_" . get_current_user_id();

$ftypes["jpg"] = 1;
$ftypes["jpeg"] = 1;
$ftypes["png"] = 1;
$ftypes["gif"] = 1;
$ftypes["raw"] = 1;
$ftypes["tif"] = 1;
$ftypes["tiff"] = 1;
$ftypes["eps"] = 1;
$ftypes["mp4"] = 1;
$ftypes["mp3"] = 1;
$ftypes["wmv"] = 1;
$ftypes["mov"] = 1;
$ftypes["flv"] = 1;
$ftypes["zip"] = 1;
$ftypes["swf"] = 1;
$filetypes = "";

if ( $pvs_global_settings["royalty_free"] == 1 ) {
	$types_tables = array(
		"audio_types",
		"video_types",
		"vector_types" );

	foreach ( $types_tables as $key => $value ) {
		$sql = "select types from " . PVS_DB_PREFIX . $value . " where shipped=0";
		$rs->open( $sql );
		while ( ! $rs->eof ) {
			$types = strtolower( str_replace( " ", "", $rs->row["types"] ) );
			$tp = explode( ",", $types );
			for ( $i = 0; $i < count( $tp ); $i++ )
			{
				if ( $tp[$i] != "" )
				{
					$ftypes[$tp[$i]] = 1;
				}
			}
			$rs->movenext();
		}
	}
}

if ( $pvs_global_settings["rights_managed"] == 1 ) {
	$sql = "select formats from " . PVS_DB_PREFIX . "rights_managed";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$types = strtolower( str_replace( " ", "", $rs->row["formats"] ) );
		$tp = explode( ",", $types );
		for ( $i = 0; $i < count( $tp ); $i++ ) {
			if ( $tp[$i] != "" )
			{
				$ftypes[$tp[$i]] = 1;
			}
		}
		$rs->movenext();
	}
}

foreach ( $ftypes as $key => $value ) {
	if ( $filetypes != "" ) {
		$filetypes .= "|";
	}
	$filetypes .= $key;
}

//echo($filetypes);

require ( 'upload_files_jquery2.php' );
$upload_handler = new UploadHandler();
?>
