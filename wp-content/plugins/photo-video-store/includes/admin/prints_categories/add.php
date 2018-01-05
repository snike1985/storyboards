<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printscategories" );

$sql = "insert into " . PVS_DB_PREFIX .
	"prints_categories (title,priority,active) values ('New',0,1)";
$db->execute( $sql );
?>
