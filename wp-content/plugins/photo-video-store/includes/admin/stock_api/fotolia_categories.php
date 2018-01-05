<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

$auth = base64_encode( $pvs_global_settings["fotolia_id"] . ":" );

//Load categories:
$url = 'http://api.fotolia.com/Rest/1/search/getCategories1';

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Basic ' . $auth ) );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

$data = curl_exec( $ch );
if ( ! curl_errno( $ch ) )
{
	$results = json_decode( $data );

	$sql = "delete from " . PVS_DB_PREFIX . "category_stock where stock = 'fotolia'";
	$db->execute( $sql );

	foreach ( $results as $key => $value )
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"category_stock (id,title,stock) values (" . $value->id . ",'" . $value->name .
			"','fotolia')";
		$db->execute( $sql );
	}
}
?>
