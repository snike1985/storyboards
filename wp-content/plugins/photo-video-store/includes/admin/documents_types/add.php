<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );

$sql = "insert into " . PVS_DB_PREFIX .
	"documents_types (title,description,enabled,buyer,seller,affiliate,filesize,priority) values ('New document','Document description',0,0,0,0,2,1)";
$db->execute( $sql );
?>