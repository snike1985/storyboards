<?php
/*
* jQuery File Upload Plugin PHP Example 5.14
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

if ( $pvs_global_settings["userupload"] == 0 ) {	
	exit();
}

$lphoto = 0;
$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_result( pvs_get_user_category () ) . "'";
$dn->open( $sql );
if ( ! $dn->eof and $dn->row["upload"] == 1 ) {
	$lphoto = $dn->row["photolimit"];
}

$tmp_folder = "user_" . get_current_user_id();
if ( ! file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder ) ) {
	mkdir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
}

include ( PVS_PATH . "/templates/upload_photo_jquery2.php" );

$upload_handler = new UploadHandler();

?>