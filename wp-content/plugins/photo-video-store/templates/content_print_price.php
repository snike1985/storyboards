<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

if ( isset( $_REQUEST["stock"] ) or isset( $_REQUEST["printslab"] ) ) {
	$sql = "select price,id_parent from " . PVS_DB_PREFIX .
		"prints where id_parent=" . ( int )@$_REQUEST["prints_id"];
} else
{
	$sql = "select price,printsid from " . PVS_DB_PREFIX .
		"prints_items where id_parent=" . ( int )@$_REQUEST["prints_id"];
}
$dq->open( $sql );
if ( ! $dq->eof ) {
	if ( isset( $_REQUEST["stock"] ) or isset( $_REQUEST["printslab"] ) ) {
		$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
			PVS_DB_PREFIX . "prints where photo=1 and id_parent=" . $dq->row["id_parent"];
	} else {
		$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
			PVS_DB_PREFIX . "prints where photo=1 and id_parent=" . $dq->row["printsid"];
	}
	$dd->open( $sql );
	if ( ! $dd->eof ) {
		$price = pvs_define_prints_price( $dq->row["price"], $dd->row["option1"],
			pvs_result( @$_REQUEST["property1"] ), $dd->row["option2"], pvs_result( @$_REQUEST["property2"] ),
			$dd->row["option3"], pvs_result( @$_REQUEST["property3"] ), $dd->row["option4"],
			pvs_result( @$_REQUEST["property4"] ), $dd->row["option5"], pvs_result( @$_REQUEST["property5"] ),
			$dd->row["option6"], pvs_result( @$_REQUEST["property6"] ), $dd->row["option7"],
			pvs_result( @$_REQUEST["property7"] ), $dd->row["option8"], pvs_result( @$_REQUEST["property8"] ),
			$dd->row["option9"], pvs_result( @$_REQUEST["property9"] ), $dd->row["option10"],
			pvs_result( @$_REQUEST["property10"] ) );

		if ( ( int )@$_REQUEST["content_id"] > 0 ) {
			$cart_id = pvs_shopping_cart_id();

			$sql = "select id from " . PVS_DB_PREFIX . "carts_content where id=" . ( int )@
				$_REQUEST["content_id"] . " and id_parent=" . ( int )$cart_id;
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
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
					@$_REQUEST["print_x2"] . ",y2=" . ( int )@$_REQUEST["print_y2"] . " where id=" . ( int )
					@$_REQUEST["content_id"];
				$db->execute( $sql );
			}
		}

		echo ( pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) . ' ' .
			pvs_currency( 2 ) );
	}
}

?>