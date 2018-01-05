<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$photo = 0;
$video = 0;
$audio = 0;
$vector = 0;

if ( isset( $_POST["photo"] ) )
{
	$photo = 1;
}
if ( isset( $_POST["video"] ) )
{
	$video = 1;
}
if ( isset( $_POST["audio"] ) )
{
	$audio = 1;
}
if ( isset( $_POST["vector"] ) )
{
	$vector = 1;
}

if ( isset( $_GET["id"] ) )
{
	$sql = "update " . PVS_DB_PREFIX . "rights_managed set title='" . pvs_result( $_POST["title"] ) .
		"',formats='" . pvs_result( $_POST["formats"] ) . "',price='" . ( float )$_POST["price"] .
		"',photo=" . $photo . ",video=" . $video . ",audio=" . $audio . ",vector=" . $vector .
		" where id=" . ( int )$_GET["id"];
	$db->execute( $sql );

	$id = ( int )$_GET["id"];
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"rights_managed (title,price,formats,photo,video,audio,vector) values ('" .
		pvs_result( $_POST["title"] ) . "'," . ( float )$_POST["price"] . ",'" .
		pvs_result( $_POST["formats"] ) . "'," . $photo . "," . $video . "," . $audio .
		"," . $vector . ")";
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX . "rights_managed where title='" .
		pvs_result( $_POST["title"] ) . "' order by id desc";
	$rs->open( $sql );
	$id = $rs->row["id"];

	$sql = "insert into " . PVS_DB_PREFIX .
		"rights_managed_structure (id_parent,types,title,adjust,price,price_id,group_id,option_id,conditions,collapse) values (0,0,'Step 1','',0," .
		$id . ",0,0,'',0)";
	$db->execute( $sql );
}
?>