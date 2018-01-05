<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_credits" );

$sql = "select user_login from " . $table_prefix . "users where user_login='" . pvs_result( $_POST["user"] ) .
	"'";
$dd->open( $sql );
if ( ! $dd->eof ) {
	if ( ( float )$_POST["quantity"] > 0 ) {
		$expiration_date = 0;
		if ( ( int )$_POST["days"] > 0 ) {
			$expiration_date = pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
				date( "d" ), date( "Y" ) ) + 3600 * 24 * $_POST["days"];
		}

		$sql = "insert into " . PVS_DB_PREFIX .
			"credits_list (title,data,user,quantity,approved,payment,credits,expiration_date) values ('" .
			pvs_result( $_POST["title"] ) . "'," . pvs_get_time( date( "H" ), date( "i" ),
			date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . ",'" . $dd->row["user_login"] .
			"'," . ( float )$_POST["quantity"] . ",1,0,0," . $expiration_date . ")";
		$db->execute( $sql );
	}

}
?>
