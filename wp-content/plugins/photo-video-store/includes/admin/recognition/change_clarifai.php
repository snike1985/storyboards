<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_recognition" );

$param_settings = array(
	'clarifai_key',
	'clarifai_password',
	'clarifai_model',
	'clarifai_language' );

for ( $i = 0; $i < count( $param_settings ); $i++ )
{
	pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
}

pvs_update_setting('clarifai', ( int )@$_POST['clarifai']);
?>
