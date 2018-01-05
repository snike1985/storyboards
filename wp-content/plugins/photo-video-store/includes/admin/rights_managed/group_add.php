<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$sql = "select id,title from " . PVS_DB_PREFIX .
	"rights_managed_groups where id=" . ( int )$_REQUEST["group"];
$rs->open( $sql );
if ( ! $rs->eof )
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"rights_managed_structure (id_parent,types,title,adjust,price,price_id,group_id,option_id,conditions,collapse) values (" . ( int )
		$_REQUEST["step"] . ",1,'" . $rs->row["title"] . "','',0," . ( int )$_REQUEST["id"] .
		"," . $rs->row["id"] . ",0,'',0)";
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX .
		"rights_managed_structure where title='" . $rs->row["title"] .
		"' and id_parent=" . ( int )$_REQUEST["step"] . " order by id desc";
	$ds->open( $sql );
	$id = $ds->row["id"];

	$sql = "select * from " . PVS_DB_PREFIX .
		"rights_managed_options where id_parent=" . ( int )$_REQUEST["group"];
	$ds->open( $sql );
	while ( ! $ds->eof )
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"rights_managed_structure (id_parent,types,title,adjust,price,price_id,group_id,option_id,conditions,collapse) values (" .
			$id . ",2,'" . $ds->row["title"] . "','" . $ds->row["adjust"] . "'," . $ds->row["price"] .
			"," . ( int )$_REQUEST["id"] . "," . $rs->row["id"] . "," . $ds->row["id"] .
			",'',0)";
		$db->execute( $sql );

		$ds->movenext();
	}
}
?>