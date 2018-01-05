<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "JsHttpRequest.php" );?>
<?php
$JsHttpRequest = new JsHttpRequest( $mtg );

$friend = pvs_result_strict( $_REQUEST["friend"] );

if ( $friend != pvs_get_user_login () ) {
	$sql = "select friend1,friend2 from " . PVS_DB_PREFIX .
		"friends where friend1='" . pvs_result( pvs_get_user_login () ) .
		"' and friend2='" . $friend . "'";
	$rs->open( $sql );
	if ( $rs->eof ) {
		$sql = "insert into " . PVS_DB_PREFIX . "friends (friend1,friend2) values ('" .
			pvs_result( pvs_get_user_login () ) . "','" . $friend . "')";
		$db->execute( $sql );
	}
}

?>
<a href="javascript:delete_friend('<?php echo $friend
?>')"><?php echo pvs_word_lang( "delete from friends" )?></a>