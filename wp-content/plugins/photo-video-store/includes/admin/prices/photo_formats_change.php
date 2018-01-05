<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_prices" );

$sql = "select * from " . PVS_DB_PREFIX . "photos_formats order by id";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sql = "update " . PVS_DB_PREFIX . "photos_formats set enabled=" . ( int )@$_POST[$rs->
		row["photo_type"]] . " where photo_type='" . $rs->row["photo_type"] . "'";
	$db->execute( $sql );

	$rs->movenext();
}
?>