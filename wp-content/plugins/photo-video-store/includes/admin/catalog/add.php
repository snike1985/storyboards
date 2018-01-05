<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Check access
pvs_admin_panel_access( "catalog_catalog" );

//Zip library
include ( PVS_PATH . "/includes/plugins/zip/pclzip.lib.php" );

$swait = false;

//If the category is new
$id = 0;
if ( isset( $_GET["id"] ) ) {
	$id = ( int )$_GET["id"];
}

//Get type
$type = "photo";
if ( isset( $_GET["type"] ) ) {
	$type = pvs_result( $_GET["type"] );
}

//Limits
$lvideo = 2048 * 1024 * 1000;
$lpreview = 2048 * 1024 * 1000;
$laudio = 2048 * 1024 * 1000;
$lvector = 2048 * 1024 * 1000;

$pub_vars = array();
$pub_vars["title"] = pvs_result( $_POST["title"] );
$pub_vars["description"] = pvs_result( $_POST["description"] );
$pub_vars["keywords"] = pvs_result( $_POST["keywords"] );
//$pub_vars["userid"]=pvs_user_login_to_id($_POST["author"]);
$pub_vars["userid"] = 0;
$pub_vars["published"] = (int) @ $_POST["published"];
$pub_vars["viewed"] = ( int )$_POST["viewed"];
$pub_vars["data"] = pvs_get_time( ( int )$_POST["data_hour"], ( int )$_POST["data_minute"],
	( int )$_POST["data_second"], ( int )$_POST["data_month"], ( int )$_POST["data_day"],
	( int )$_POST["data_year"] );
$pub_vars["author"] = pvs_result( $_POST["author"] );
$pub_vars["content_type"] = pvs_result( $_POST["content_type"] );
$pub_vars["downloaded"] = ( int )$_POST["downloaded"];

$pub_vars["vote_like"] = ( int )$_POST["vote_like"];
$pub_vars["vote_dislike"] = ( int )$_POST["vote_dislike"];

$pub_vars["examination"] = 0;

if ( $pvs_global_settings["google_coordinates"] ) {
	$pub_vars["google_x"] = ( float )$_POST["google_x"];
	$pub_vars["google_y"] = ( float )$_POST["google_y"];
} else
{
	$pub_vars["google_x"] = 0;
	$pub_vars["google_y"] = 0;
}

$pub_vars["server1"] = $site_server_activ;

$pub_vars["free"] = (int) @ $_POST["free"];
$pub_vars["featured"] = (int) @ $_POST["featured"];
$pub_vars["adult"] = (int) @ $_POST["adult"];
$pub_vars["contacts"] = (int) @ $_POST["contacts"];
$pub_vars["exclusive"] = (int) @ $_POST["exclusive"];
$pub_vars["editorial"] = (int) @ $_POST["editorial"];

$pub_vars["duration"] = 3600 * @$_POST["duration_hour"] + 60 * @$_POST["duration_minute"] + ( int ) @$_POST["duration_second"];
$pub_vars["format"] = pvs_result( @$_POST["format"] );
$pub_vars["ratio"] = pvs_result( @$_POST["ratio"] );
$pub_vars["rendering"] = pvs_result( @$_POST["rendering"] );
$pub_vars["frames"] = pvs_result( @$_POST["frames"] );
$pub_vars["holder"] = pvs_result( @$_POST["holder"] );
$pub_vars["usa"] = pvs_result( @$_POST["usa"] );
$pub_vars["source"] = pvs_result( @$_POST["source"] );



if ( $type == "photo" ) {
	if ( $id == 0 ) {
		$id = pvs_publication_media_add(1);
		$folder = $id;
		pvs_publication_photo_upload( $id );
		$swait = true;

		if ( $pvs_global_settings["prints"] ) {
			pvs_publication_prints_add( $id, false );
		}
	} else {
		pvs_publication_media_update( $id, 0 );
		pvs_price_update( $id, "photo" );
		$folder = $id;
		pvs_publication_photo_upload( $id );

		if ( $pvs_global_settings["prints"] ) {
			pvs_prints_update( $id );
		}
	}
}

if ( $type == "video" ) {
	if ( $id == 0 ) {
		$id = pvs_publication_media_add(2);
		$folder = $id;
		pvs_publication_files_upload( $id, "video" );
		$swait = true;
	} else {
		pvs_publication_media_update( $id, 0 );
		pvs_price_update( $id, "video" );
		$folder = $id;
		pvs_publication_files_upload( $id, "video" );
	}
}

if ( $type == "audio" ) {
	if ( $id == 0 ) {
		$id = pvs_publication_media_add(3);
		$folder = $id;
		pvs_publication_files_upload( $id, "audio" );
		$swait = true;
	} else {
		pvs_publication_media_update( $id, 0 );
		pvs_price_update( $id, "audio" );
		$folder = $id;
		pvs_publication_files_upload( $id, "audio" );

	}
}

if ( $type == "vector" ) {
	if ( $id == 0 ) {
		$id = pvs_publication_media_add(4);
		$folder = $id;
		pvs_publication_files_upload( $id, "vector" );
		$swait = true;
	} else {
		pvs_publication_media_update( $id, 0 );
		pvs_price_update( $id, "vector" );
		$folder = $id;
		pvs_publication_files_upload( $id, "vector" );
	}
}


if ( $id != 0 ) {
	pvs_item_url( $id );
}

//Models
$sql = "delete from " . PVS_DB_PREFIX . "models_files where publication_id=" . $id;
$db->execute( $sql );

foreach ( $_POST as $key => $value ) {
	if ( preg_match( "/model/i", $key ) ) {
		$model_id = str_replace( "model", "", $key );

		if ( $model_id != "" ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"models_files (publication_id,model_id,models) value (" . $id . "," . ( int )$model_id .
				"," . ( int )$value . ")";
			$db->execute( $sql );
		}
	}
}
//End. Models

//Update translation
if ( $pvs_global_settings["multilingual_publications"] ) {
	$sql = "delete from " . PVS_DB_PREFIX . "translations where id=" . $id;
	$db->execute( $sql );
}

foreach ( $_POST as $key => $value ) {
	if ( preg_match( "/translate/i", $key ) ) {
		$temp_mass = explode( "_", $key );
		if ( isset( $temp_mass[1] ) and isset( $temp_mass[2] ) ) {
			$sql = "select id from " . PVS_DB_PREFIX . "translations where id=" . $id .
				" and lang='" . pvs_result( $temp_mass[2] ) . "'";
			$dr->open( $sql );
			if ( $dr->eof )
			{
				$sql = "insert into " . PVS_DB_PREFIX .
					"translations (id,title,keywords,description,lang,types) values (" . $id .
					",'','','','" . pvs_result( $temp_mass[2] ) . "',1)";
				$db->execute( $sql );
			}

			$sql = "update " . PVS_DB_PREFIX . "translations set " . pvs_result( $temp_mass[1] ) .
				"='" . pvs_result( $value ) . "' where id=" . $id . " and lang='" . pvs_result( $temp_mass[2] ) .
				"'";
			$db->execute( $sql );
		}
	}
}
//End. Update translation

//Collections
if ( $pvs_global_settings["collections"] ) {
	$sql = "delete from " . PVS_DB_PREFIX . "collections_items where category_id=0 and publication_id=" . $id;
	$db->execute( $sql );
	
	$sql = "select id from " . PVS_DB_PREFIX . "collections where types=1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if (isset($_POST["collection" . $rs->row["id"]])) {
			$sql = "insert into " . PVS_DB_PREFIX . "collections_items (publication_id, category_id, collection_id) values (" . $id . ", 0, " . $rs->row["id"] . ")";
			$db->execute( $sql );
		}
		$rs->movenext();
	}
}
//End. Collections
?>