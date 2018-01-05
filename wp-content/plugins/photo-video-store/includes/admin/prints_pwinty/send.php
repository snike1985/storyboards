<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );

//The orders IDs must be sent to Pwinty
$pwinty_ids = array();

foreach ( $_POST as $key => $value )
{
	if ( preg_match( "/sel[0-9]+/", $key ) )
	{
		$id = str_replace( "sel", "", $key );
		$sql = "select order_id from " . PVS_DB_PREFIX . "pwinty_orders where order_id=" . ( int )
			$id;
		$ds->open( $sql );
		if ( $ds->eof )
		{
			$pwinty_ids[] = $id;
		}
	}
}
//End. The orders IDs must be sent to Pwinty

include ( "send_to_pwinty.php" );
?>