<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$id = @$_REQUEST['id'];
if ( isset( $_REQUEST['content'] ) ) {
	$content = @$_REQUEST['content'];
	$login = @$_REQUEST['login'];

	$sql = "insert into " . PVS_DB_PREFIX .
		"reviews (fromuser,content,data,itemid) values ('" . pvs_result_strict( $login ) .
		"','" . pvs_result( $content ) . "'," . pvs_get_time( date( "H" ), date( "i" ),
		date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . "," . ( int )$id . ")";
	$db->execute( $sql );
}

$sql = "select itemid,content,data,fromuser from " . PVS_DB_PREFIX .
	"reviews where itemid=" . ( int )$id . " order by data desc";
$rs->open( $sql );
$boxreviews = "";
if ( ! $rs->eof ) {
	$boxreviews .= "<table style='margin-bottom:20px'>";
	while ( ! $rs->eof ) {
		$boxuser = pvs_show_user_avatar( $rs->row["fromuser"], "login" );

		$boxreviews .= "<tr valign='top'><td rowspan='2' style='padding-right:20px;width:20%'>" .
			$boxuser . "</td><td class='datenews'>" . pvs_show_time_ago( $rs->row["data"] ) .
			"</td></tr><tr><td style='padding-bottom:15px'>" . str_replace( "\n", "<br>", $rs->
			row["content"] ) . "</td></tr>";
		$rs->movenext();
	}
	$boxreviews .= "</table>";
} else
{
	$boxreviews .= "<p>" . pvs_word_lang( "not found" ) . "</p>";
}

$boxadd = "";
if ( is_user_logged_in() ) {
	$boxadd = '<form name="reviewsadd" id="reviewsadd"   Enctype="multipart/form-data">
	<input type="hidden" name="id" value="' . $id . '">
	<input type="hidden" name="login" value="' . pvs_get_user_login () . '">
	
	<div class="form_field">
	<span><b>' . pvs_word_lang("new comment") . ':</b></span>
	<textarea name="content" class="form-control"></textarea>
	</div>
	
	
	<div class="form_field">
	<input class="btn btn-primary" type="button" onClick="reviews_add(\'reviewsadd\');" value="' . pvs_word_lang("add") . '">
	</div>
	</form>';
} else
{
	$boxadd = "<a href='" . site_url() . "/login/' class='btn btn-default'>" . pvs_word_lang( "add review" ) .
		"</a>";
}

$boxcontent = $boxreviews . $boxadd;

echo ( $boxcontent );

?>
