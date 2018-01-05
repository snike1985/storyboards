<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

//Load categories:
$url = "api.bigstockphoto.com/2/" . $pvs_global_settings["bigstockphoto_id"] .
	"/categories/";

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

$data = curl_exec( $ch );
if ( ! curl_errno( $ch ) )
{
	$results = json_decode( $data );

	$sql = "delete from " . PVS_DB_PREFIX .
		"category_stock where stock = 'bigstockphoto'";
	$db->execute( $sql );

	foreach ( $results->data as $key => $value )
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"category_stock (id,title,stock) values (0,'" . $value->name .
			"','bigstockphoto')";
		$db->execute( $sql );
	}
}
?>
