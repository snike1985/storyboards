<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_lightboxes" );

$sql = "update " . PVS_DB_PREFIX . "lightboxes set title='" . pvs_result( $_POST["title"] ) .
	"',catalog=" . ( int )@$_POST["catalog"] . " where id=" . ( int )$_REQUEST["id"];
$db->execute( $sql );

//Upload photo
$photo = "";
$flag = true;

if ( preg_match( "/text/i", $_FILES["photo"]["type"] ) ) {
	$flag = false;
}
if ( ! preg_match( "/\.jpg$/i", $_FILES["photo"]["name"] ) ) {
	$flag = false;
}

$_FILES["photo"]['name'] = pvs_result_file( $_FILES["photo"]['name'] );

if ( $_FILES["photo"]['size'] > 0 and $_FILES["photo"]['size'] < 10048 * 1024 ) {
	if ( $flag == true ) {
		$photo = "/content/categories/lightbox_" . ( int )@$_REQUEST["id"] . ".jpg";
		move_uploaded_file( $_FILES["photo"]['tmp_name'], pvs_upload_dir() . $photo );

		//make thumb
		pvs_easyResize( pvs_upload_dir() . $photo, pvs_upload_dir() . $photo, 100, ( int )$pvs_global_settings["category_preview"] );
	}
}

?>
