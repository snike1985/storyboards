<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_admin_panel_access( "catalog_upload" );

pvs_delete_category( ( int )$_GET["id"], 0 );
?>