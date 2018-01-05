<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

unset( $_SESSION["checkout_method"] );

header( "location:" . site_url() . "/checkout/" );

?>



