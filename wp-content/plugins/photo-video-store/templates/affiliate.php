<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}



$d = 1;
if ( isset( $_GET["d"] ) ) {
	$d = $_GET["d"];
}
if ( $d == "" ) {
	$d = 1;
}

include ( "profile_top.php" );

if ( $d == 1 ) {
	include ( "affiliate_balance.php" );
}

if ( $d == 2 ) {
	include ( "affiliate_earning.php" );
}

if ( $d == 3 ) {
	include ( "affiliate_payout.php" );
}

if ( $d == 4 ) {
	include ( "affiliate_settings.php" );
}

include ( "profile_bottom.php" );
?>