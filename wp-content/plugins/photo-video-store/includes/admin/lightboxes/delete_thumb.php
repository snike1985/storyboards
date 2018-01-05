<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_collections" );

if(file_exists(pvs_upload_dir() . "/content/categories/lightbox_" . ( int )@$_REQUEST["id"] . ".jpg")) {
	unlink(pvs_upload_dir() . "/content/categories/lightbox_" . ( int )@$_REQUEST["id"] . ".jpg");
}
?>