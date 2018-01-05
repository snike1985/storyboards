<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_collections" );

$active = 0;
if( isset($_POST["active"]) ) {
	$active = 1;
}

//If the category is new
if ( isset( $_GET["id"] ) and ( int )$_GET["id"] != 0 ) {
	$sql = "update " . PVS_DB_PREFIX . "collections set title='" . pvs_result( $_POST["title"] ) . "',description='" . pvs_result( $_POST["description"] ) . "', active=" . $active . ", types=" . ( int )$_POST["types"] . ", price=" . ( float ) $_POST["price"] . " where id=" . ( int )$_GET["id"];
	$db->execute( $sql );
} else
{
	$sql = "insert into " . PVS_DB_PREFIX . "collections (title, description, active, types, price) values ('" . pvs_result( $_POST["title"] ) . "','" . pvs_result( $_POST["description"] ) . "'," .  $active . "," .  ( int ) $_POST["types"] . "," .  ( float ) $_POST["price"] . ")";
	$db->execute( $sql );
}

if (( int ) $_POST["types"] == 0) {
	$sql = "delete from " . PVS_DB_PREFIX . "collections_items where  collection_id=" . ( int )@$_GET["id"];
	$db->execute( $sql );
	
	$sql = "select id from " . PVS_DB_PREFIX . "category";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( isset( $_POST["category" . $rs->row["id"]] ) ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"collections_items (collection_id, category_id, publication_id) values (" . ( int )@$_GET["id"] . ", " . $rs->row["id"] .
				", 0)";
			$db->execute( $sql );
		}
		$rs->movenext();
	}
}

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
		$photo = "/content/categories/collection_" . ( int )@$_GET["id"] . ".jpg";
		move_uploaded_file( $_FILES["photo"]['tmp_name'], pvs_upload_dir() . $photo );

		//make thumb
		pvs_easyResize( pvs_upload_dir() . $photo, pvs_upload_dir() . $photo, 100, ( int )$pvs_global_settings["category_preview"] );
	}
}
?>