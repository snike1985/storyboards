<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_networks" );

pvs_update_setting('auth_' . pvs_result( $_POST["title"] ), ( int )@$_POST["auth_" .
	pvs_result( $_POST["title"] )]);
pvs_update_setting('auth_' . pvs_result( $_POST["title"] ) . '_key', pvs_result( $_POST["auth_" .
	pvs_result( $_POST["title"] ) . "_key"] ));
pvs_update_setting('auth_' . pvs_result( $_POST["title"] ) . '_secret', pvs_result( $_POST["auth_" .
	pvs_result( $_POST["title"] ) . "_secret"] ) );

//Update settings
pvs_get_settings();
?>