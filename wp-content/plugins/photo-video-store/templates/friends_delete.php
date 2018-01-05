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

$friend = pvs_result_strict( $_REQUEST["friend"] );

$sql = "delete from " . PVS_DB_PREFIX . "friends where friend1='" . pvs_result( pvs_get_user_login () ) .
	"' and friend2='" . $friend . "'";
$db->execute( $sql );


?>
<a href="javascript:add_friend('<?php echo $friend
?>')"><?php echo pvs_word_lang( "add to friends" )?></a>