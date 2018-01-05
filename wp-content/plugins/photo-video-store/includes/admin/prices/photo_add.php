<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_prices" );

$sql = "insert into " . PVS_DB_PREFIX .
	"sizes (size,price,priority,title,license,watermark,jpg,png,gif,raw,tiff,eps) values (" . ( int )
	$_POST["size"] . "," . ( float )$_POST["price"] . "," . ( int )$_POST["priority"] .
	",'" . pvs_result( $_POST["title"] ) . "'," . ( int )$_POST["license"] . "," . ( int )
	@$_POST["watermark"] . "," . ( int )@$_POST["jpg"] . "," . ( int )@$_POST["png"] .
	"," . ( int )@$_POST["gif"] . "," . ( int )@$_POST["raw"] . "," . ( int )@$_POST["tiff"] .
	"," . ( int )@$_POST["eps"] . ")";
$db->execute( $sql );

//define id
$sql = "select id_parent from " . PVS_DB_PREFIX .
	"sizes order by id_parent desc";
$dr->open( $sql );
$id = $dr->row['id_parent'];

$items_count = 0;

if ( ( int )$_POST["addto"] == 1 )
{
	$sql = "select id,server1 from " . PVS_DB_PREFIX .
		"media where media_id=1 order by id";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$url = pvs_get_photo_file( $rs->row["id"] );

		if ( $url != "" )
		{
			$sql = "insert into " . PVS_DB_PREFIX .
				"items (id_parent,name,url,price,priority,shipped,price_id,watermark) values (" .
				$rs->row["id"] . ",'" . pvs_result( $_POST["title"] ) . "','" . $url .
				"'," . ( float )$_POST["price"] . "," . ( int )$_POST["priority"] . ",0," . $id .
				"," . ( int )@$_POST["watermark"] . ")";
			$db->execute( $sql );
		}

		$items_count++;
		$rs->movenext();
	}
}
?>