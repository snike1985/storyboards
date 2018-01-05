<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$tags_result = "";

$api_credentials = array( 'key' => $pvs_global_settings["imagga_key"], 'secret' =>
		$pvs_global_settings["imagga_password"] );

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, 'https://api.imagga.com/v1/tagging?url=' . $_REQUEST["url"] .
	'&language=' . $_REQUEST["lang"] );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
curl_setopt( $ch, CURLOPT_HEADER, FALSE );
curl_setopt( $ch, CURLOPT_USERPWD, $api_credentials['key'] . ':' . $api_credentials['secret'] );

$response = curl_exec( $ch );
curl_close( $ch );

$json_response = json_decode( $response );

if ( isset( $json_response->results
{
	0}
->tags ) ) {
	foreach ( $json_response->results
	{
		0}
	->tags as $key => $value ) {
		if ( $tags_result != '' ) {
			$tags_result .= ',';
		}

		$tags_result .= $value->tag;
	}
}


echo ( $tags_result );?>