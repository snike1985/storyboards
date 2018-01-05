<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_productsoptions" );

$sql = "select id from " . PVS_DB_PREFIX . "products_options order by title";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$activ = 0;
	if ( isset( $_POST["activ" . $rs->row["id"]] ) )
	{
		$activ = 1;
	}

	$sql = "update " . PVS_DB_PREFIX . "products_options set activ=" . $activ .
		" where id=" . $rs->row["id"];
	$db->execute( $sql );

	$rs->movenext();
}
?>
