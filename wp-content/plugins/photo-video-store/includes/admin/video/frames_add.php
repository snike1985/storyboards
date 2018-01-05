<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );

$sql = "insert into " . PVS_DB_PREFIX . "video_frames (name) values ('" .
	pvs_result( $_POST["new"] ) . "')";
$db->execute( $sql );
?>