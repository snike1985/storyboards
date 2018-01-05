<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_models" );

pvs_model_delete( ( int )$_GET["id"], "" );
?>