<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );
$JsHttpRequest = new JsHttpRequest( $mtg );

$email = pvs_result( $_REQUEST['email'] );

if ( $_REQUEST['email'] == "" or ! preg_match( "/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\.A-Za-z0-9]{2,}/",
	$_REQUEST['email'] ) ) {
	echo ( "<span class='error'>" . pvs_word_lang( "incorrect field" ) . "</span>" );
} else
{
	$sql = "select user_email from " . $table_prefix . "users where user_email='" . $email .
		"'";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		echo ( "<span class='error'>" . pvs_word_lang( "Error: Email is already in use." ) . "</span>" );
	} else {
		echo ( "<span class='ok'>" . pvs_word_lang( "Ok. Email is available." ) . "</span>" );
	}
}
?>