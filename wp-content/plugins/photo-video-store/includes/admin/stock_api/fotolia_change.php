<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'fotolia_id',
	'fotolia_contributor',
	'fotolia_query',
	'fotolia_category',
	'fotolia_account',
	'fotolia_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('fotolia_api', ( int )@$_POST['fotolia_api']);
pvs_update_setting('fotolia_pages', ( int )@$_POST['fotolia_pages']);
pvs_update_setting('fotolia_prints', ( int )@$_POST['fotolia_prints']);
pvs_update_setting('fotolia_files', ( int )@$_POST['fotolia_files']);
?>
