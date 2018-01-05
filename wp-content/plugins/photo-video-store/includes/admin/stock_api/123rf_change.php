<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'rf123_id',
	'rf123_secret',
	'rf123_affiliate',
	'rf123_contributor',
	'rf123_category',
	'rf123_query',
	'rf123_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('rf123_api', ( int )@$_POST['rf123_api']);
pvs_update_setting('rf123_pages', ( int )@$_POST['rf123_pages']);
pvs_update_setting('rf123_prints', ( int )@$_POST['rf123_prints']);
pvs_update_setting('rf123_files', ( int )@$_POST['rf123_files']);
?>
