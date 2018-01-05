<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_checkout" );

$sql = "insert into " . PVS_DB_PREFIX .
	"terms (types,title,priority,page_id) values (1,'New terms and conditions','1','0')";
$db->execute( $sql );
?>



