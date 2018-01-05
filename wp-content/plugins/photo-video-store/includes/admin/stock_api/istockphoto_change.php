<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'istockphoto_id',
	'istockphoto_secret',
	'istockphoto_contributor',
	'istockphoto_query',
	'istockphoto_site',
	'istockphoto_affiliate',
	'istockphoto_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('istockphoto_api', ( int )@$_POST['istockphoto_api']);
pvs_update_setting('istockphoto_pages', ( int )@$_POST['istockphoto_pages']);
pvs_update_setting('istockphoto_prints', ( int )@$_POST['istockphoto_prints']);
pvs_update_setting('istockphoto_files', ( int )@$_POST['istockphoto_files']);
?>
