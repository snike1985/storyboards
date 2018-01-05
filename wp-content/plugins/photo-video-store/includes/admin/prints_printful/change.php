<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printful" );

pvs_update_setting('printful_api', pvs_result( $_POST["printful_api"] ));
pvs_update_setting('printful_order_id', ( int )$_POST["printful_order_id"]);
pvs_update_setting('printful_mode', pvs_result( $_POST["printful_mode"] ) );
?>