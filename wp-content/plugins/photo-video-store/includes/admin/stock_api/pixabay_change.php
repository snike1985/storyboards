<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$param_settings = array(
	'pixabay_id',
	'pixabay_category',
	'pixabay_show' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('pixabay_api', ( int )@$_POST['pixabay_api']);
pvs_update_setting('pixabay_pages', ( int )@$_POST['pixabay_pages']);
pvs_update_setting('pixabay_prints', ( int )@$_POST['pixabay_prints']);
pvs_update_setting('pixabay_files', ( int )@$_POST['pixabay_files']);
?>
