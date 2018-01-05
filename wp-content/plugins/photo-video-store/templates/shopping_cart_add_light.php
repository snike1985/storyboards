<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$id_parent = ( int )@$_REQUEST['id'];

$rights_managed = 0;
$url = "";

//If rights_managed
$sql = "select rights_managed from " . PVS_DB_PREFIX . "media where id=" . $id_parent;
$ds->open( $sql );
if ( ! $ds->eof ) {
	if ( $ds->row["rights_managed"] > 0 ) {
		$rights_managed = 1;
		$url = pvs_item_url( $id_parent );
	}
}


//If not rights_managed
if ( $rights_managed == 0 ) {
	$id = 0;
	$sql = "select id from " . PVS_DB_PREFIX . "items where id_parent=" . $id_parent .
		" and price<>0 order by price";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$id = $dr->row["id"];
	}
	if ( $pvs_global_settings["printsonly"] ) {
		$printsid = "";
		$sql = "select id_parent from " . PVS_DB_PREFIX . "prints where photo=1";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
			if ( $printsid != "" )
			{
				$printsid .= " or ";
			}
			$printsid .= "printsid=" . $dr->row["id_parent"];
			$dr->movenext();
		}

		if ( $printsid != "" ) {
			$printsid = " and (" . $printsid . ")";
		}

		$sql = "select id_parent from " . PVS_DB_PREFIX . "prints_items where itemid=" .
			$id_parent . $printsid . " order by price";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$id = $dr->row["id_parent"];
		}
	}

	if ( ! $pvs_global_settings["printsonly"] ) {
		//Files
		$params["item_id"] = $id;
		$params["prints_id"] = 0;
	} else {
		//Prints
		$params["prints_id"] = $id;
		$params["item_id"] = 0;
	}

	$params["publication_id"] = $id_parent;
	$params["quantity"] = 1;

	for ( $i = 1; $i < 11; $i++ ) {
		$params["option" . $i . "_id"] = 0;
		$params["option" . $i . "_value"] = "";
	}

	pvs_shopping_cart_add( $params );
}

include ( "shopping_cart_add_content.php" );
$GLOBALS['_RESULT'] = array(
	"box_shopping_cart" => $box_shopping_cart,
	"box_shopping_cart_lite" => $box_shopping_cart_lite,
	"rights_managed" => $rights_managed,
	"url" => $url );

?>