<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_support" );

$sql = "delete from " . PVS_DB_PREFIX . "support_tickets where id=" . ( int )$_GET["id"] .
	" or id_parent=" . ( int )$_GET["id"];
$db->execute( $sql );

?>
