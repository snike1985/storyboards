<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["zombaio_active"] ) {
	exit();
}


//Check access
if ( @$_GET["ZombaioGWPass"] != $pvs_global_settings["zombaio_password"] ) {
	header( "HTTP/1.0 401 Unauthorized" );
	echo "<h1>Zombaio Gateway 1.1</h1><h3>Authentication failed.</h3>";
	exit;
}

if ( $pvs_global_settings["zombaio_account"] != "" ) {
	if ( @$_GET["Action"] == "user.addcredits" ) {
		$sql = "select id_parent from " . PVS_DB_PREFIX .
			"credits_list where approved=0 and id_parent=" . ( int )$_GET["Identifier"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			pvs_credits_approve( ( int )$_GET["Identifier"], pvs_result( $_GET["TransactionID"] ) );
			pvs_send_notification( 'credits_to_user', ( int )$_GET["Identifier"] );
			pvs_send_notification( 'credits_to_admin', ( int )$_GET["Identifier"] );
		}
	}
}

echo ( "OK" );
?>