<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$sql = "select collapse from " . PVS_DB_PREFIX .
	"rights_managed_structure where id=" . ( int )$_REQUEST["price"];
$rs->open( $sql );
if ( ! $rs->eof )
{
	if ( $rs->row["collapse"] == 0 )
	{
		$collapse = 1;
	} else
	{
		$collapse = 0;
	}

	$sql = "update " . PVS_DB_PREFIX . "rights_managed_structure set collapse=" . $collapse .
		" where id=" . ( int )$_REQUEST["price"];
	$db->execute( $sql );
}
?>