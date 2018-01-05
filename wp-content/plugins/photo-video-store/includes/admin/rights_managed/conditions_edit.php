<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$conditions = "";
for ( $i = 0; $i < 7; $i++ )
{
	if ( $i != 0 )
	{
		$conditions .= "-";
	}

	if ( isset( $_REQUEST["condition" . $i] ) )
	{
		$conditions .= ( int )$_REQUEST["condition" . $i];
	} else
	{
		$conditions .= "0";
	}
}

$sql = "update " . PVS_DB_PREFIX . "rights_managed_structure set conditions='" .
	$conditions . "' where id=" . ( int )$_REQUEST["id_element"];
$db->execute( $sql );
?>