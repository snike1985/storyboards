<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_categories" );

//If the category is new
$id = 0;
if ( isset( $_GET["id"] ) )
{
	$id = ( int )$_GET["id"];
}

if ( $id != ( int )$_POST["id_parent"] or $id == 0 )
{
	$swait = pvs_add_update_category( $id, 0, 0, 0 );
} else
{
	$swait = false;
}

if ( $id != 0 )
{
	pvs_category_url( $id );
}
?>