<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'depositphotos_id',
	'depositphotos_affiliate',
	'depositphotos_contributor',
	'depositphotos_category',
	'depositphotos_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('depositphotos_api', ( int )@$_POST['depositphotos_api']);
pvs_update_setting('depositphotos_pages', ( int )@$_POST['depositphotos_pages']);
pvs_update_setting('depositphotos_prints', ( int )@$_POST['depositphotos_prints']);
pvs_update_setting('depositphotos_files', ( int )@$_POST['depositphotos_files']);
?>
