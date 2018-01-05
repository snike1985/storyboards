<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_settings" );



pvs_update_setting('buyer_commission', ( float )$_POST["buyer"]);
pvs_update_setting('seller_commission', ( float )$_POST["seller"]);

if ( $_POST["addto"] == 1 ) {
	$sql="select ID from " . $table_prefix . "users";
	$ds->open($sql);
	while(!$ds->eof)
	{
		update_user_meta( $ds->row["ID"], 'aff_commission_buyer', ( float )$_POST["buyer"]);
		update_user_meta( $ds->row["ID"], 'aff_commission_seller', ( float )$_POST["seller"]);
		$ds->movenext();
	}
}

?>