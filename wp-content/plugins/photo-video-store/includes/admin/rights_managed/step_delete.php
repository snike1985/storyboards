<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$nlimit = 0;
pvs_delete_rights_managed_admin( ( int )$_REQUEST["id_element"] );
?>