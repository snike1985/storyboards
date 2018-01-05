<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_messages" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "messages";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id_parent"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "messages where id_parent=" . $rs->row["id_parent"];
		$db->execute( $sql );
	}
	$rs->movenext();
}

?>
