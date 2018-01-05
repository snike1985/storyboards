<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_models" );

if ( ! isset( $_GET["type"] ) )
{
	pvs_model_delete_file( ( int )$_GET["id"], "photo", "" );
} else
{
	pvs_model_delete_file( ( int )$_GET["id"], "file", "" );
}
?>