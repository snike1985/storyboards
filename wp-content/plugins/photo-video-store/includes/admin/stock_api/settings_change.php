<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array( 'stock_default' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('site_api', ( int )@$_POST['site_api']);

unset( $_SESSION["stock_selected"] );
?>
