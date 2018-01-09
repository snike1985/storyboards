<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select * from " . PVS_DB_PREFIX . "payout where activ=1";
$ds->open( $sql );
while ( ! $ds->eof ) {
	update_user_meta( get_current_user_id(), $ds->row["svalue"], pvs_result( @$_POST["payout" . $ds->row["id"]] ));
	$ds->movenext();
}

if ( $pvs_global_settings["payout_set"] ) {
	update_user_meta( get_current_user_id(), "payout_limit", ( float )@$_POST["payout_limit"]);
}

header( "location:" . site_url() . "/commission/?d=4" );
?>