<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_audio" );

$sql = "insert into " . PVS_DB_PREFIX . "audio_format (name) values ('" .
	pvs_result( $_POST["new"] ) . "')";
$db->execute( $sql );
?>