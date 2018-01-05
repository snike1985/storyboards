<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_types" );

if ( isset( $_GET["id"] ) and isset( $_GET["type"] ) )
{
	if ( file_exists( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] .
		"_" . ( int )$_GET["type"] . "_big.jpg" ) )
	{
		unlink( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] . "_" .
			( int )$_GET["type"] . "_big.jpg" );
	}

	if ( file_exists( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] .
		"_" . ( int )$_GET["type"] . "_small.jpg" ) )
	{
		unlink( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] . "_" .
			( int )$_GET["type"] . "_small.jpg" );
	}
}
?>
