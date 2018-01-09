<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


if ( isset( $_GET["d"] ) ) {
	$d = ( int )$_GET["d"];
} else
{
	$d = 1;
}

include ( "profile_top.php" );

if ( $d == 1 ) {
	include ( "commission_balance.php" );
}
if ( $d == 2 ) {
	include ( "commission_earning.php" );
}
if ( $d == 3 ) {
	include ( "commission_payout.php" );
}
if ( $d == 4 ) {
	include ( "commission_settings.php" );
}

include ( "profile_bottom.php" );

?>