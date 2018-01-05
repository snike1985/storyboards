<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_commission" );

foreach ( $_POST as $key => $value ) {
	if ( preg_match( "/sel/", $key ) ) {
		$key_mass = explode( "sel", $key );
		$sql = "delete from " . PVS_DB_PREFIX . "commission where id=" . ( int )$key_mass[1];
		$db->execute( $sql );
	}
}

?>
