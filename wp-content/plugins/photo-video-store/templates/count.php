<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "download_mimes.php" );
if ( ! is_user_logged_in() and $pvs_global_settings["auth_freedownload"] ) {
	exit();
}

if (pvs_is_rights_managed(( int )$_GET["id_parent"])) {
	exit();
}

$publication_id = ( int )$_GET["id_parent"];
$publication_item = ( int )$_GET["id"];
$publication_type = pvs_result( $_GET["type"] );
$publication_server = ( int )@$_GET["server"];
$download_regime = "subscription";

include ( "download_process.php" );?>