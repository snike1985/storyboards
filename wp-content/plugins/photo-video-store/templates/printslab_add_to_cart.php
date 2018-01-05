<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select id from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_POST["gallery_id"] .
	" and user_id=" . get_current_user_id();
$rs->open( $sql );
if ( $rs->eof ) {
	exit();
}

$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" . ( int )
	$_POST["gallery_id"];
$dn->open( $sql );
while ( ! $dn->eof ) {
	if ( isset( $_POST["sel" . $dn->row["id"]] ) ) {
		$rights_managed = 0;

		$params["prints_id"] = ( int )$_POST["prints" . $dn->row["id"]];
		$params["item_id"] = 0;

		$params["publication_id"] = $dn->row["id"];
		$params["quantity"] = 1;

		for ( $i = 1; $i < 11; $i++ ) {
			$params["option" . $i . "_id"] = 0;
			$params["option" . $i . "_value"] = "";
		}

		for ( $i = 1; $i < 11; $i++ ) {
			foreach ( $_POST as $key => $value )
			{
				if ( preg_match( "/option" . $dn->row["id"] . "_" . ( int )$_POST["prints" . $dn->
					row["id"]] . "_" . $i . "_/i", $key ) )
				{
					$params["option" . $i . "_id"] = strval( str_replace( "option" . $dn->row["id"] .
						"_" . ( int )$_POST["prints" . $dn->row["id"]] . "_" . $i . "_", "", $key ) );
					$params["option" . $i . "_value"] = pvs_result( $value );
				}
			}
		}

		$params["printslab"] = 1;

		pvs_shopping_cart_add( $params );
	}
	$dn->movenext();
}

header( "location:" . site_url() . "/cart/" );?>

