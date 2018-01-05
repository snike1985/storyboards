<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_subscription" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "subscription_list";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id_parent"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "subscription_list where id_parent=" . $rs->
			row["id_parent"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "downloads where subscription_id=" . $rs->
			row["id_parent"];
		$db->execute( $sql );

		pvs_affiliate_delete_commission( $rs->row["id_parent"], "subscription" );
	}
	$rs->movenext();
}

?>
