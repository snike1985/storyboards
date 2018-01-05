<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

//Load categories:
$url = "http://api.depositphotos.com?dp_apikey=" . $pvs_global_settings["depositphotos_id"] .
	"&dp_command=getCategoriesList";

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
		"category_stock where stock = 'depositphotos'";
	$db->execute( $sql );

	foreach ( $results->result as $key => $value )
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"category_stock (id,title,stock) values (" . $key . ",'" . $value .
			"','depositphotos')";
		$db->execute( $sql );
	}
}
?>
