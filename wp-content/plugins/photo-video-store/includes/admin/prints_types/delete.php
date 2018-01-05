<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_types" );

$sql = "delete from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "prints_items where printsid=" . ( int )
	$_GET["id"];
$db->execute( $sql );

//Delete photos
for ( $i = 1; $i < 6; $i++ )
{
	if ( file_exists( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] .
		"_" . $i . "_big.jpg" ) )
	{
		unlink( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] . "_" .
			$i . "_big.jpg" );
	}

	if ( file_exists( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] .
		"_" . $i . "_small.jpg" ) )
	{
		unlink( pvs_upload_dir() . "/content/prints/product" . ( int )$_GET["id"] . "_" .
			$i . "_small.jpg" );
	}
}
?>
