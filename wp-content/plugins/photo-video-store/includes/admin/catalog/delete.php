<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Check access
pvs_admin_panel_access( "catalog_catalog" );

if ( ! $demo_mode ) {
	pvs_publication_delete( ( int )$_GET["id"] );
}
?>