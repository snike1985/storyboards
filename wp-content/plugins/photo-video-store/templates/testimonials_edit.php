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

$id = ( int )$_REQUEST["id"];

$sql = "select id_parent,fromuser,content from " . PVS_DB_PREFIX .
	"testimonials where fromuser='" . pvs_result( pvs_get_user_login () ) .
	"' and id_parent=" . $id;
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<div><textarea class='ibox form-control' name="content<?php echo $rs->row["id_parent"];
?>" id="content<?php echo $rs->row["id_parent"];
?>" style="width:300px;height:70px"><?php echo $rs->row["content"];
?></textarea></div>
<div><input class='isubmit' type="button" value="<?php echo pvs_word_lang( "save" );?>" onClick="change(<?php echo $rs->row["id_parent"];
?>);" style="margin-top:5px"></div>
<?php
}

?>