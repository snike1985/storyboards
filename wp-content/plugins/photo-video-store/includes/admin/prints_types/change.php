<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_types" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "prints";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$quantity = ( int )$_POST["quantity" . $rs->row["id_parent"]];
	if ( $_POST["quantity_type" . $rs->row["id_parent"]] == -1 )
	{
		$quantity = -1;
	}

	$sql = "update " . PVS_DB_PREFIX . "prints set title='" . pvs_result( $_POST["title" .
		$rs->row["id_parent"]] ) . "',priority=" . ( int )$_POST["priority" . $rs->row["id_parent"]] .
		",price=" . ( float )$_POST["price" . $rs->row["id_parent"]] . ",weight=" . ( float )
		$_POST["weight" . $rs->row["id_parent"]] . ",photo=" . ( int )@$_POST["photo" .
		$rs->row["id_parent"]] . ",printslab=" . ( int )@$_POST["printslab" . $rs->row["id_parent"]] .
		",preview=" . ( int )$_POST["preview" . $rs->row["id_parent"]] . ", in_stock=" .
		$quantity . " where id_parent=" . $rs->row["id_parent"];
	$db->execute( $sql );

	$rs->movenext();
}

if ( $_POST["addto"] == 1 )
{
	$sql = "select id_parent,price,in_stock from " . PVS_DB_PREFIX . "prints";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$sql = "update " . PVS_DB_PREFIX . "prints_items set price=" . pvs_price_format( $rs->
			row["price"], 2 ) . ", in_stock=" . $rs->row["in_stock"] . "  where printsid=" .
			$rs->row["id_parent"];
		$db->execute( $sql );

		$rs->movenext();
	}
}

if ( $_POST["addto"] == 2 )
{
	$sql = "select id from " . PVS_DB_PREFIX . "media where media_id=1";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$sql = "select * from " . PVS_DB_PREFIX . "prints where photo=1";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$sql = "select id_parent from " . PVS_DB_PREFIX . "prints_items where itemid=" .
				$rs->row["id"] . " and printsid=" . $ds->row["id_parent"];
			$dn->open( $sql );
			if ( $dn->eof )
			{
				$sql = "insert into " . PVS_DB_PREFIX .
					"prints_items (title,price,itemid,priority,printsid,in_stock) values ('" . $ds->
					row["title"] . "'," . pvs_price_format( $ds->row["price"], 2 ) . "," . $rs->row["id"] .
					"," . $ds->row["priority"] . "," . $ds->row["id_parent"] . "," . $ds->row["in_stock"] .
					")";
				$db->execute( $sql );
			} else
			{
				$sql = "update " . PVS_DB_PREFIX . "prints_items set title='" . $ds->row["title"] .
					"',price=" . pvs_price_format( $ds->row["price"], 2 ) . ",priority=" . $ds->row["priority"] .
					", in_stock=" . $ds->row["in_stock"] . " where itemid=" . $rs->row["id"] .
					" and printsid=" . $ds->row["id_parent"];
				$db->execute( $sql );
			}
			$ds->movenext();
		}
		$rs->movenext();
	}
}
?>
