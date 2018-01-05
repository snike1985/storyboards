<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select id from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_REQUEST["id"] .
	" and user_id=" . get_current_user_id();
$rs->open( $sql );
if ( $rs->eof ) {
	exit();
}

$rights_managed = 0;

$params["prints_id"] = ( int )$_REQUEST["print_id"];
$params["item_id"] = 0;

$params["publication_id"] = ( int )$_REQUEST["photo"];
$params["quantity"] = ( int )@$_REQUEST['quantity'];

$params["x1"] = ( int )@$_REQUEST['print_x1'];
$params["y1"] = ( int )@$_REQUEST['print_y1'];
$params["x2"] = ( int )@$_REQUEST['print_x2'];
$params["y2"] = ( int )@$_REQUEST['print_y2'];
$params["print_width"] = ( int )@$_REQUEST['print_width'];
$params["print_height"] = ( int )@$_REQUEST['print_height'];

for ( $i = 1; $i < 11; $i++ ) {
	$params["option" . $i . "_id"] = 0;
	$params["option" . $i . "_value"] = "";
}

$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
	PVS_DB_PREFIX . "prints where id_parent=" . ( int )$_REQUEST["print_id"];
$ds->open( $sql );
if ( ! $ds->eof ) {
	for ( $i = 1; $i < 11; $i++ ) {
		$params["option" . $i . "_id"] = ( int )$ds->row["option" . $i];

		if ( $params["option" . $i . "_id"] != 0 and isset( $_REQUEST["property" . $i] ) ) {
			$params["option" . $i . "_value"] = pvs_result( $_REQUEST["property" . $i] );
		}
	}
}

$params["printslab"] = 1;

pvs_shopping_cart_add( $params );

header( "location:" . site_url() . "/cart/" );?>

