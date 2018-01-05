<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>
<h1><?php echo pvs_word_lang( "subscription" );?></h1>



<?php
$sql = "select title,user,data1,data2,bandwidth,bandwidth_limit,subscription,approved from " .
	PVS_DB_PREFIX . "subscription_list where user='" . pvs_result( pvs_get_user_login () ) .
	"' and data2>" . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
	date( "d" ), date( "Y" ) ) .
	" and bandwidth<bandwidth_limit and approved=1 order by data2 desc";
$ds->open( $sql );
if ( $ds->eof ) {
	include ( "subscription_new.php" );
}

include ( "subscription_status.php" );
include ( "profile_bottom.php" );
?>