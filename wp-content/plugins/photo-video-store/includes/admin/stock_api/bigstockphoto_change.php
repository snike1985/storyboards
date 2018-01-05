<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'bigstockphoto_id',
	'bigstockphoto_affiliate',
	'bigstockphoto_contributor',
	'bigstockphoto_category',
	'bigstockphoto_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('bigstockphoto_api', ( int )@$_POST['bigstockphoto_api']);
pvs_update_setting('bigstockphoto_pages', ( int )@$_POST['bigstockphoto_pages']);
pvs_update_setting('bigstockphoto_prints', ( int )@$_POST['bigstockphoto_prints']);
pvs_update_setting('bigstockphoto_files', ( int )@$_POST['bigstockphoto_files']);
?>
