<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


if ( isset( $_SERVER["HTTP_REFERER"] ) and ! preg_match( "/language/i", $_SERVER["HTTP_REFERER"] ) ) {
	header( "location:" . $_SERVER["HTTP_REFERER"] );
} else
{
	header( "location:" . site_url() . "/" );
}
?>