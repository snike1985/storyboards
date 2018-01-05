<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_models" );

//If the model is new
if ( isset( $_GET["id"] ) and ( int )$_GET["id"] != 0 )
{
	$sql = "update " . PVS_DB_PREFIX . "models set name='" . pvs_result( $_POST["name"] ) .
		"',description='" . pvs_result( $_POST["description"] ) . "',user='" .
		pvs_result( $_POST["user"] ) . "' where id_parent=" . ( int )$_GET["id"];
	$db->execute( $sql );

	$id = ( int )$_GET["id"];
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"models (name,user,description) values ('" . pvs_result( $_POST["name"] ) .
		"','" . pvs_result( $_POST["user"] ) . "','" . pvs_result( $_POST["description"] ) .
		"')";
	$db->execute( $sql );

	$id = 0;
	$sql = "select id_parent from " . PVS_DB_PREFIX . "models where user='" .
		pvs_result( $_POST["user"] ) . "' order by id_parent desc";
	$ds->open( $sql );
	if ( ! $ds->eof )
	{
		$id = $ds->row["id_parent"];
	}
}

//Upload files
$swait = pvs_model_upload( $id );
?>