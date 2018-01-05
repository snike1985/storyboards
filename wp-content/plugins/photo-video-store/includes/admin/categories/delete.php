<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_categories" );

$res_id = array();
$nlimit = 0;
pvs_get_included_categories( ( int )$_GET["id"] );
$res_id[] = ( int )$_GET["id"];

for ( $i = 0; $i < count( $res_id ); $i++ )
{
	if ( ! $demo_mode )
	{
		pvs_delete_category( $res_id[$i], 0 );
	}
}
?>