<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


if ( ! isset( $_REQUEST["content_id"] ) ) {
	for ( $i = 1; $i < 11; $i++ ) {
		$params["option" . $i . "_id"] = 0;
		$params["option" . $i . "_value"] = "";
	}

	if ( @$_REQUEST['prints_id'] != 0 ) {
		//Prints
		$params["prints_id"] = ( int )@$_REQUEST['prints_id'];
		$params["item_id"] = 0;
		$params["quantity"] = ( int )@$_REQUEST['quantity'];
		$params["x1"] = ( int )@$_REQUEST['print_x1'];
		$params["y1"] = ( int )@$_REQUEST['print_y1'];
		$params["x2"] = ( int )@$_REQUEST['print_x2'];
		$params["y2"] = ( int )@$_REQUEST['print_y2'];
		$params["print_width"] = ( int )@$_REQUEST['print_width'];
		$params["print_height"] = ( int )@$_REQUEST['print_height'];
		$params["stock"] = ( int )@$_REQUEST["stock"];
		$params["stock_type"] = pvs_result( @$_REQUEST["stock_type"] );
		$params["stock_id"] = ( int )@$_REQUEST["stock_id"];
		$params["stock_url"] = pvs_result( @$_REQUEST["stock_url"] );
		$params["stock_preview"] = pvs_result( @$_REQUEST["stock_preview"] );
		$params["stock_site_url"] = pvs_result( @$_REQUEST["stock_site_url"] );

		if ( $params["stock"] == 1 ) {
			$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
				"prints where id_parent=" . $params["prints_id"];
		} else {
			$sql = "select itemid,title,price,printsid from " . PVS_DB_PREFIX .
				"prints_items where id_parent=" . $params["prints_id"];
		}
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			if ( $params["stock"] == 1 )
			{
				$params["publication_id"] = $params["stock_id"];
			} else
			{
				$params["publication_id"] = $dr->row["itemid"];
			}

			if ( $params["stock"] == 1 )
			{
				$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
					PVS_DB_PREFIX . "prints where id_parent=" . $dr->row["id_parent"];
			} else
			{
				$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
					PVS_DB_PREFIX . "prints where id_parent=" . $dr->row["printsid"];
			}
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				for ( $i = 1; $i < 11; $i++ )
				{
					$params["option" . $i . "_id"] = ( int )$ds->row["option" . $i];

					if ( $params["option" . $i . "_id"] != 0 and isset( $_REQUEST["property" . $i] ) )
					{
						$params["option" . $i . "_value"] = pvs_result( $_REQUEST["property" . $i] );
					}
				}
			}
		}

		pvs_shopping_cart_add( $params );
	}
} else
{
	$cart_id = pvs_shopping_cart_id();

	$sql = "select id from " . PVS_DB_PREFIX . "carts_content where id=" . ( int )@
		$_REQUEST["content_id"] . " and id_parent=" . ( int )$cart_id;
	$ds->open( $sql );
	if ( ! $ds->eof ) {

		if ( ( int )@$_REQUEST["quantity"] > 0 ) {
			$sql = "update " . PVS_DB_PREFIX . "carts_content set option1_value='" .
				pvs_result( @$_REQUEST["property1"] ) . "',option2_value='" . pvs_result( @$_REQUEST["property2"] ) .
				"',option3_value='" . pvs_result( @$_REQUEST["property3"] ) .
				"',option4_value='" . pvs_result( @$_REQUEST["property4"] ) .
				"',option5_value='" . pvs_result( @$_REQUEST["property5"] ) .
				"',option6_value='" . pvs_result( @$_REQUEST["property6"] ) .
				"',option7_value='" . pvs_result( @$_REQUEST["property7"] ) .
				"',option8_value='" . pvs_result( @$_REQUEST["property8"] ) .
				"',option9_value='" . pvs_result( @$_REQUEST["property9"] ) .
				"',option10_value='" . pvs_result( @$_REQUEST["property10"] ) . "',x1=" . ( int )
				@$_REQUEST["print_x1"] . ",y1=" . ( int )@$_REQUEST["print_y1"] . ",x2=" . ( int )
				@$_REQUEST["print_x2"] . ",y2=" . ( int )@$_REQUEST["print_y2"] . ",quantity=" . ( int )
				@$_REQUEST["quantity"] . " where id=" . ( int )@$_REQUEST["content_id"];
			$db->execute( $sql );
		} else {
			$sql = "delete from " . PVS_DB_PREFIX . "carts_content where id=" . ( int )@$_REQUEST["content_id"];
			$db->execute( $sql );
		}
	}
}


header( "location:" . site_url() . "/cart/" );?>