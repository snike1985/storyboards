<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( isset( $_POST["PHPSESSID"] ) ) {
	session_id( $_POST["PHPSESSID"] );
}


$image_id = isset( $_GET["id"] ) ? $_GET["id"] : false;

if ( $image_id === false ) {
	header( "HTTP/1.1 500 Internal Server Error" );
	echo "No ID";
	exit( 0 );
}

if ( ! is_array( $_SESSION["file_info"] ) || ! isset( $_SESSION["file_info"][$image_id] ) ) {
	header( "HTTP/1.1 404 Not found" );
	exit( 0 );
}

$tmp_folder = "user_" . get_current_user_id();

header( "Content-type: image/jpeg" );
header( "Content-length: " . filesize( pvs_upload_dir() .
	"/content/" . $tmp_folder . "/" . $_SESSION["file_info"][$image_id] .
	"_thumb1.jpg" ) );

readfile( pvs_upload_dir() . "/content/" . $tmp_folder .
	"/" . $_SESSION["file_info"][$image_id] . "_thumb1.jpg" );
exit( 0 );

?>