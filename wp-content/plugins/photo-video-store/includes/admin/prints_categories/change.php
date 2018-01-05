<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printscategories" );

$sql = "select id,title,priority,active from " . PVS_DB_PREFIX .
	"prints_categories";
$rs->open( $sql );

while ( ! $rs->eof )
{
	$sql = "update " . PVS_DB_PREFIX . "prints_categories set title='" . pvs_result( $_POST["title" .
		$rs->row["id"]] ) . "',priority=" . ( int )$_POST["priority" . $rs->row["id"]] .
		",active=" . ( int )@$_POST["active" . $rs->row["id"]] . " where id=" . $rs->
		row["id"];
	$db->execute( $sql );

	$rs->movenext();
}
?>
