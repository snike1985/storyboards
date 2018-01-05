<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );

pvs_update_setting('payout_limit', ( float )$_POST["payout_limit"]);
pvs_update_setting('payout_set', ( int )@$_POST["payout_set"]);

if ( $_POST["payout_action"] == 1 )
{
	$sql="select ID from " . $table_prefix . "users";
	$ds->open($sql);
	while(!$ds->eof)
	{
		update_user_meta( $ds->row["ID"], 'payout_limit', ( float )$_POST["payout_limit"]);

		$ds->movenext();
	}
}
?>