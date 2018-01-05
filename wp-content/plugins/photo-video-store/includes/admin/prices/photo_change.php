<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_prices" );

$sql = "select * from " . PVS_DB_PREFIX . "licenses order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sql = "select * from " . PVS_DB_PREFIX . "sizes where license=" . $rs->row["id_parent"] .
		" order by priority";
	$dr->open( $sql );
	while ( ! $dr->eof )
	{
		$sql = "update " . PVS_DB_PREFIX . "sizes  set title='" . pvs_result( $_POST["title" .
			$dr->row["id_parent"]] ) . "',size=" . ( int )$_POST["size" . $dr->row["id_parent"]] .
			",price=" . ( float )$_POST["price" . $dr->row["id_parent"]] . ",priority=" . ( int )
			$_POST["priority" . $dr->row["id_parent"]] . ",watermark=" . ( int )@$_POST["watermark" .
			$dr->row["id_parent"]] . ",jpg=" . ( int )@$_POST["jpg" . $dr->row["id_parent"]] .
			",png=" . ( int )@$_POST["png" . $dr->row["id_parent"]] . ",gif=" . ( int )@$_POST["gif" .
			$dr->row["id_parent"]] . ",raw=" . ( int )@$_POST["raw" . $dr->row["id_parent"]] .
			",tiff=" . ( int )@$_POST["tiff" . $dr->row["id_parent"]] . ",eps=" . ( int )@$_POST["eps" .
			$dr->row["id_parent"]] . " where id_parent=" . $dr->row["id_parent"];
		$db->execute( $sql );

		if ( isset( $_POST["delete" . $dr->row["id_parent"]] ) )
		{
			$sql = "delete from " . PVS_DB_PREFIX . "sizes where id_parent=" . $dr->row["id_parent"];
			$db->execute( $sql );
		}

		if ( ( int )$_POST["addto"] == 1 )
		{
			$sql = "update " . PVS_DB_PREFIX . "items  set name='" . pvs_result( $_POST["title" .
				$dr->row["id_parent"]] ) . "',price=" . ( float )$_POST["price" . $dr->row["id_parent"]] .
				",priority=" . ( int )$_POST["priority" . $dr->row["id_parent"]] . ",watermark=" . ( int )
				@$_POST["watermark" . $dr->row["id_parent"]] . " where price_id=" . $dr->row["id_parent"];
			$db->execute( $sql );

			if ( isset( $_POST["delete" . $dr->row["id_parent"]] ) )
			{
				$sql = "delete from " . PVS_DB_PREFIX . "items where price_id=" . $dr->row["id_parent"];
				$db->execute( $sql );
			}
		}

		$dr->movenext();
	}
	$rs->movenext();
}
?>