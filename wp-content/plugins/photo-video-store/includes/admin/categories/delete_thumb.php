<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_categories" );

$sql = "select id,photo from " . PVS_DB_PREFIX . "category where id=" . ( int )
	$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof )
{
	if ( $rs->row["photo"] != "" and file_exists( pvs_upload_dir() . $rs->row["photo"] ) )
	{
		unlink( pvs_upload_dir() . $rs->row["photo"] );
	}

	$sql = "update " . PVS_DB_PREFIX . "category set photo='' where id=" . ( int )$_GET["id"];
	$db->execute( $sql );
}
?>