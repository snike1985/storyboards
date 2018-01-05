<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_creditstypes" );

$sql = "insert into " . PVS_DB_PREFIX .
	"credits (title,quantity,price,priority,days) values ('" . pvs_result( $_POST["title"] ) .
	"'," . ( int )$_POST["quantity"] . "," . ( float )$_POST["price"] . "," . ( int )
	$_POST["priority"] . "," . ( int )$_POST["days"] . ")";
$db->execute( $sql );
?>
