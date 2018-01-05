<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$id_parent = ( int )@$_REQUEST['id'];

$id = 0;
$sql = "select id from " . PVS_DB_PREFIX . "items where id_parent=" . $id_parent .
	" order by price";
$dr->open( $sql );
if ( ! $dr->eof ) {
	$id = $dr->row["id"];
}

$params["item_id"] = $id;
$params["prints_id"] = 0;

$params["publication_id"] = $id_parent;
$params["quantity"] = 1;

for ( $i = 1; $i < 11; $i++ ) {
	$params["option" . $i . "_id"] = 0;
	$params["option" . $i . "_value"] = "";
}

$params["rights_managed"] = 1;


pvs_shopping_cart_add( $params );


header( "location:" . site_url() . "/cart/" );
?>