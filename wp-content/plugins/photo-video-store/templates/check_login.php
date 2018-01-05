<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$login = pvs_result_strict( $_REQUEST['login'] );

if ( $_REQUEST['login'] == "" or ! preg_match( "/^[A-Za-z]{1,}[A-Za-z0-9]{4,}$/",
	$_REQUEST['login'] ) ) {
	echo ( "<span class='error'>" . pvs_word_lang( "incorrect field" ) . "</span>" );
} else
{
	$sql = "select user_login from " . $table_prefix . "users where user_login='" . $login .
		"'";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		echo ( "<span class='error'>" . pvs_word_lang( "Error: Username is already in use." ) . "</span>" );
	} else {
		echo ( "<span class='ok'>" . pvs_word_lang( "Ok. Username is available." ) . "</span>" );
	}
}

?>