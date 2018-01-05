<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'shutterstock_id',
	'shutterstock_secret',
	'shutterstock_affiliate',
	'shutterstock_contributor',
	'shutterstock_category',
	'shutterstock_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('shutterstock_api', ( int )@$_POST['shutterstock_api']);
pvs_update_setting('shutterstock_pages', ( int )@$_POST['shutterstock_pages']);
pvs_update_setting('shutterstock_prints', ( int )@$_POST['shutterstock_prints']);
pvs_update_setting('shutterstock_files', ( int )@$_POST['shutterstock_files']);
?>
