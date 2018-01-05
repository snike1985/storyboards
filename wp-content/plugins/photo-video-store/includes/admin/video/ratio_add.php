<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );

$sql = "insert into " . PVS_DB_PREFIX .
	"video_ratio (name,width,height) values ('" . pvs_result( $_POST["new"] ) . "'," . ( int )
	$_POST["width"] . "," . ( int )$_POST["height"] . ")";
$db->execute( $sql );
?>