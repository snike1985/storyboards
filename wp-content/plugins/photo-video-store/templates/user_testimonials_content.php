<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$login = pvs_result_strict( $_REQUEST['login'] );

if ( isset( $_REQUEST['content'] ) and is_user_logged_in() ) {
	$content = @$_REQUEST['content'];
	$login = @$_REQUEST['login'];

	$sql = "insert into " . PVS_DB_PREFIX .
		"testimonials (touser,fromuser,content,data) values ('" . pvs_result_strict( $login ) .
		"','" . pvs_result( pvs_get_user_login () ) . "','" . pvs_result( $content ) .
		"'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) ) . ")";
	$db->execute( $sql );
}

$sql = "select id_parent,touser,fromuser,content,data from " . PVS_DB_PREFIX .
	"testimonials where touser='" . pvs_result($login) . "' order by data desc";
$rs->open( $sql );
$boxtestimonials = "";
if ( ! $rs->eof ) {
	$boxtestimonials .= "<table>";
	while ( ! $rs->eof ) {
		$boxuser = pvs_show_user_avatar( $rs->row["fromuser"], "login" );

		$boxtestimonials .= "<tr valign='top'><td rowspan='2' style='padding-right:20px;width:15%'>" .
			$boxuser . "</td><td class='datenews'>" . pvs_show_time_ago( $rs->row["data"] ) .
			"</td></tr><tr><td style='padding-bottom:15px'>" . str_replace( "\n", "<br>", $rs->
			row["content"] ) . "</td></tr>";
		$rs->movenext();
	}
	$boxtestimonials .= "</table>";
} else
{
	$boxtestimonials .= "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>";
}

$boxadd = "";
if ( is_user_logged_in() ) {
	$boxadd = '<form name="testimonialsadd" id="testimonialsadd" style="margin-bottom:25px"    Enctype="multipart/form-data">
<input type="hidden" name="login" value="' . $login . '">

<div class="form_field">
<span><b>' . pvs_word_lang("add a testimonial") . ':</b></span>
<textarea name="content" class="form-control"></textarea>
</div>

<div class="form_field">
<input class="btn btn-primary" type="button" onClick="testimonials_add(\'testimonialsadd\');" value="' . pvs_word_lang("add") . '">
</div>

</form>';
} else
{
	$boxadd = "<a href='" . site_url() . "/login/'>" . pvs_word_lang( "add review" ) . "</a>";
}

$boxcontent = "";
$boxcontent .= $boxadd;


$boxcontent .= $boxtestimonials;


echo ( $boxcontent );?>
