<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_productsoptions" );

$id = 0;

$activ = 0;
$required = 0;
if ( isset( $_POST["activ"] ) )
{
	$activ = 1;
}
if ( isset( $_POST["required"] ) )
{
	$required = 1;
}

if ( isset( $_GET["id"] ) )
{
	$sql = "update " . PVS_DB_PREFIX . "products_options set title='" . pvs_result( $_POST["title"] ) .
		"',type='" . pvs_result( $_POST["type"] ) . "',activ=" . $activ . ",required=" .
		$required . ",description=" . ( int )@$_POST["description"] . ",property_name='" .
		pvs_result( $_POST["property_name"] ) . "' where id=" . ( int )$_GET["id"];
	$db->execute( $sql );

	$id = ( int )$_GET["id"];
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"products_options (title,type,activ,required,description,property_name) values ('" .
		pvs_result( $_POST["title"] ) . "','" . pvs_result( $_POST["type"] ) . "'," . $activ .
		"," . $required . "," . ( int )@$_POST["description"] . ",'" . pvs_result( $_POST["property_name"] ) .
		"')";
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX . "products_options where title='" .
		pvs_result( $_POST["title"] ) . "' order by id desc";
	$rs->open( $sql );
	$id = $rs->row["id"];
}

//Add ranges
if ( $id != 0 )
{
	$sql = "delete from " . PVS_DB_PREFIX .
		"products_options_items where id_parent=" . $id;
	$db->execute( $sql );

	$id_list = array();
	foreach ( $_POST as $key => $value )
	{
		if ( preg_match( "/options_price/i", $key ) )
		{
			$id_list[] = str_replace( "options_price", "", $key );
		}
	}
	for ( $i = 0; $i < count( $id_list ); $i++ )
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"products_options_items (id_parent,price,title,adjust,property_value) values (" .
			$id . "," . ( float )$_POST["options_price" . $id_list[$i]] . ",'" . pvs_result( $_POST["options" .
			$id_list[$i] . "_title"] ) . "'," . ( int )$_POST["options" . $id_list[$i] .
			"_adjust"] . ",'" . pvs_result( $_POST["options" . $id_list[$i] . "_value"] ) .
			"')";
		$db->execute( $sql );
	}
}
?>
