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

if ( ! $pvs_global_settings["prints_lab"] ) {
	exit;
}

$lphoto = $pvs_global_settings["prints_lab_filesize"];

$tmp_folder = "user_" . get_current_user_id();
pvs_create_temp_folder();

require ( 'upload_photo_jquery2.php' );
$upload_handler = new UploadHandler();
?>