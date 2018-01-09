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

//Upload function


$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_result( pvs_get_user_category () ) . "'";
$dn->open( $sql );
if ( ! $dn->eof and $dn->row["upload"] == 1 ) {
	$lphoto = $dn->row["photolimit"];

	$photo = "";
	$swait = false;

	//free
	$free = 0;
	if ( isset( $_POST["free"] ) ) {
		$free = 1;
	}

	//Examination
	if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () ) {
		$exam = 1;
	} else {
		$exam = 0;
	}

	$pub_vars = array();
	$pub_vars["title"] = pvs_result( $_POST["title"] );
	$pub_vars["description"] = pvs_result( $_POST["description"] );
	$pub_vars["keywords"] = pvs_result( $_POST["keywords"] );
	$pub_vars["userid"] = get_current_user_id();

	if ( $pvs_global_settings["moderation"] ) {
		$approved = 0;
	} else {
		$approved = 1;
	}

	$pub_vars["published"] = $approved;
	$pub_vars["viewed"] = 0;
	$pub_vars["data"] = pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
		date( "d" ), date( "Y" ) );
	$pub_vars["author"] = pvs_result( pvs_get_user_login () );
	$pub_vars["content_type"] = $pvs_global_settings["content_type"];
	$pub_vars["downloaded"] = 0;
	$pub_vars["model"] = 0;
	$pub_vars["examination"] = $exam;
	$pub_vars["server1"] = $site_server_activ;
	$pub_vars["free"] = $free;

	if ( $pvs_global_settings["google_coordinates"] ) {
		$pub_vars["google_x"] = ( float )$_POST["google_x"];
		$pub_vars["google_y"] = ( float )$_POST["google_y"];
	} else {
		$pub_vars["google_x"] = 0;
		$pub_vars["google_y"] = 0;
	}

	if ( isset( $_POST["editorial"] ) ) {
		$pub_vars["editorial"] = 1;
	} else {
		$pub_vars["editorial"] = 0;
	}

	if ( isset( $_POST["adult"] ) ) {
		$pub_vars["adult"] = 1;
	} else {
		$pub_vars["adult"] = 0;
	}

	if ( isset( $_GET["id"] ) ) {
		$id = ( int )$_GET["id"];
		$sql = "select downloaded,viewed,data,content_type,published from " .
			PVS_DB_PREFIX . "media where id=" . $id;
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$pub_vars["downloaded"] = $rs->row["downloaded"];
			$pub_vars["viewed"] = $rs->row["viewed"];
			$pub_vars["data"] = $rs->row["data"];
			$pub_vars["content_type"] = $rs->row["content_type"];
			//$pub_vars["published"]=$rs->row["published"];
		}
		//Update a photo into the database
		pvs_publication_media_update( $id, get_current_user_id() );
		pvs_price_update( $id, "photo" );
		$folder = $id;
		pvs_publication_photo_upload( $id );

		pvs_item_url( $id );
	}

	//Folder
	$folder = $id;

	//upload file for sale
	if ( isset( $_GET["id"] ) ) {
		pvs_price_update( ( int )$_GET["id"], "photo" );
	}

	//Prints
	if ( $pvs_global_settings["prints_users"] ) {
		if ( isset( $_GET["id"] ) ) {
			pvs_prints_update( ( int )$_GET["id"] );
		}
	}

	//Models
	$sql = "delete from " . PVS_DB_PREFIX . "models_files where publication_id=" . ( int )
		$_GET["id"];
	$db->execute( $sql );

	foreach ( $_POST as $key => $value ) {
		if ( preg_match( "/model/i", $key ) ) {
			$model_id = str_replace( "model", "", $key );

			if ( $model_id != "" )
			{
				$sql = "insert into " . PVS_DB_PREFIX .
					"models_files (publication_id,model_id,models) value (" . ( int )$_GET["id"] .
					"," . ( int )$model_id . "," . ( int )$value . ")";
				$db->execute( $sql );
			}
		}
	}

	if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () ) {
		$rurl = site_url() . "/upload/";
	} else {
		$rurl = site_url() . "/publications/?d=2&t=1";
	}

	//go to back
	header( "location:" . $rurl );
}

?>