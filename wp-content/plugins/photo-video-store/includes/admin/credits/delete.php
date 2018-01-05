<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_credits" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "credits_list";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id_parent"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "credits_list where id_parent=" . $rs->
			row["id_parent"];
		$db->execute( $sql );

		pvs_affiliate_delete_commission( $rs->row["id_parent"], "credits" );
	}
	$rs->movenext();
}

?>
