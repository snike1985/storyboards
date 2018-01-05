<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );
?>

<?php
$d = 2;
if ( isset( $_GET["d"] ) ) {
	$d = $_GET["d"];
}
if ( $d == "" ) {
	$d = 2;
}
?>



<h1>
<?php
if ( $d == 2 ) {
	echo ( pvs_word_lang( "Credits" ) . " &mdash; " . pvs_word_lang( "balance" ) );
}
if ( $d == 1 ) {
	echo ( pvs_word_lang( "buy credits" ) );
}
?>
</h1>

<?php
if ( $d == 1 ) {
	if ( @$pvs_global_settings[ 'fortumo'] != "" ) {
		if ( ! isset( $_GET["type"] ) ) {
			include ( "credits_select.php" );
		} else {
			if ( $_GET["type"] == "mobile" )
			{
				include ( "credits_mobile.php" );
			} else
			{
				include ( "credits_buy.php" );
			}
		}
	} else {
		include ( "credits_buy.php" );
	}
}
if ( $d == 2 ) {
	include ( "credits_list.php" );
}
?>
<?php
include ( "profile_bottom.php" );
?>