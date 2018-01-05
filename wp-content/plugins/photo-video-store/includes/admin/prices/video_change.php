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
	$sql = "select * from " . PVS_DB_PREFIX . "video_types where license=" . $rs->
		row["id_parent"] . " order by priority";
	$dr->open( $sql );
	while ( ! $dr->eof )
	{
		$shipped = 0;
		if ( isset( $_POST["shipped" . $dr->row["id_parent"]] ) )
		{
			$shipped = 1;
			$_POST["types" . $dr->row["id_parent"]] = "shipped";
		}

		$sql = "update " . PVS_DB_PREFIX . "video_types  set title='" . pvs_result( $_POST["title" .
			$dr->row["id_parent"]] ) . "',types='" . pvs_result( $_POST["types" . $dr->row["id_parent"]] ) .
			"',price=" . ( float )$_POST["price" . $dr->row["id_parent"]] . ",priority=" . ( int )
			$_POST["priority" . $dr->row["id_parent"]] . ",thesame=" . ( int )$_POST["thesame" .
			$dr->row["id_parent"]] . ",shipped=" . $shipped . " where id_parent=" . $dr->
			row["id_parent"];
		$db->execute( $sql );

		if ( isset( $_POST["delete" . $dr->row["id_parent"]] ) )
		{
			$sql = "delete from " . PVS_DB_PREFIX . "video_types where id_parent=" . $dr->
				row["id_parent"];
			$db->execute( $sql );
		}

		if ( ( int )$_POST["addto"] == 1 )
		{
			$sql = "update " . PVS_DB_PREFIX . "items  set name='" . pvs_result( $_POST["title" .
				$dr->row["id_parent"]] ) . "',price=" . ( float )$_POST["price" . $dr->row["id_parent"]] .
				",priority=" . ( int )$_POST["priority" . $dr->row["id_parent"]] . ",shipped=" .
				$shipped . " where price_id=" . $dr->row["id_parent"];
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