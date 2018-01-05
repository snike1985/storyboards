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
	$sql = "insert into " . PVS_DB_PREFIX .
		"models  (name,description,user) values ('" . pvs_result( $_POST["title"] ) .
		"','" . pvs_result( $_POST["description"] ) . "','" . pvs_result( pvs_get_user_login () ) .
		"')";
	$db->execute( $sql );

	$id = 0;
	$sql = "select id_parent from " . PVS_DB_PREFIX . "models where user='" .
		pvs_result( pvs_get_user_login () ) . "' order by id_parent desc";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$id = $ds->row["id_parent"];
	}

	$swait = pvs_model_upload( $id );
}



//go to back
pvs_redirect_file( site_url() . "/models/", $swait );?>