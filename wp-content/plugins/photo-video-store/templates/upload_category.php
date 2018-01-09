<?php
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

$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_result( pvs_get_user_category () ) . "'";
$dn->open( $sql );
if ( ! $dn->eof and $dn->row["category"] == 1 ) {

	$sql = "select id_parent,upload from " . PVS_DB_PREFIX .
		"category where id=" . ( int )$_POST["id_parent"];
	$ds->open( $sql );
	if ( ! $ds->eof and $ds->row["upload"] == 1 ) {
		//If the category is new
		$id = 0;
		if ( isset( $_GET["id"] ) ) {
			$id = ( int )$_GET["id"];
		}
		$_POST["creation_date"] = pvs_get_time();
		$_POST["activation_date"] = pvs_get_time();
		$_POST["expiration_date"] = 0;
		$approved = 1;

		if ( $pvs_global_settings["moderation"] ) {
			$approved = 0;
		}

		if ( $id != ( int )$_POST["id_parent"] ) {
			$swait = pvs_add_update_category( $id, get_current_user_id(), 1, $approved );
		} else {
			$swait = false;
		}

		if ( $id != 0 ) {
			pvs_category_url( $id );
		}

		pvs_redirect_file( site_url() . "/publications/?d=1&t=1", $swait );
	}
}
?>