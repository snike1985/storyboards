<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_signup" );

$sql = "select * from " . PVS_DB_PREFIX .
	"users_fields group by field_name order by columns,priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sql = "update " . PVS_DB_PREFIX . "users_fields set required=" . ( int )@$_POST["required" .
		$rs->row["id"]] . ",signup=" . ( int )@$_POST["signup" . $rs->row["id"]] .
		",profile=" . ( int )@$_POST["profile" . $rs->row["id"]] . ",priority=" . ( int )
		$_POST["priority" . $rs->row["id"]] . ",columns=" . ( int )$_POST["columns" . $rs->
		row["id"]] . "  where id=" . $rs->row["id"];
	$db->execute( $sql );

	$rs->movenext();
}

?>