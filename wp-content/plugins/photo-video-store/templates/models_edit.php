<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

//Upload function


$swait = false;
if ( $pvs_global_settings["model"] == 1 ) {
	$sql = "select * from " . PVS_DB_PREFIX . "models where user='" . pvs_result( pvs_get_user_login () ) .
		"' and id_parent=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$id = ( int )$_GET["id"];

		$sql = "update " . PVS_DB_PREFIX . "models set name='" . pvs_result( $_POST["title"] ) .
			"',description='" . pvs_result( $_POST["description"] ) . "' where id_parent=" . ( int )
			$_GET["id"];
		$db->execute( $sql );

		$swait = pvs_model_upload( $id );
	}
}



//go to back
pvs_redirect_file( site_url() . "/models/", $swait );?>