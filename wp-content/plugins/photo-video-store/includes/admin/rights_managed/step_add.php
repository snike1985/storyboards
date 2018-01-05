<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$sql = "insert into " . PVS_DB_PREFIX .
	"rights_managed_structure (id_parent,types,title,adjust,price,price_id,group_id,option_id,conditions,collapse) values (0,0,'" .
	pvs_result( $_REQUEST["title"] ) . "','',0," . ( int )$_REQUEST["id"] .
	",0,0,'',0)";
$db->execute( $sql );
?>