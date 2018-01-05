<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$sql = "select id from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . ( int )$_REQUEST["collection"];
$dr->open( $sql );
if ( ! $dr->eof ) {

	$params["collection"] = ( int )$_REQUEST["collection"];
	$params["item_id"] = 0;
	$params["prints_id"] = 0;
	
	$params["publication_id"] = 0;
	$params["quantity"] = 1;
	
	for ( $i = 1; $i < 11; $i++ ) {
		$params["option" . $i . "_id"] = 0;
		$params["option" . $i . "_value"] = "";
	}
	
	pvs_shopping_cart_add( $params );
}


header( "location:" . site_url() . "/cart/" );
?>