<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_comments" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "reviews";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id_parent"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "reviews where id_parent=" . $rs->row["id_parent"];
		$db->execute( $sql );
	}
	$rs->movenext();
}

?>
