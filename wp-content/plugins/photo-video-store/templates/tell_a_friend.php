<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$id = @$_REQUEST['id'];

if ( isset( $_REQUEST['email'] ) ) {
	$rn1 = @$_REQUEST['rn1'];
	$rn2 = @$_REQUEST['rn2'];
	$boxtell = "<p><b>" . pvs_word_lang( "sent" ) . "</b></p>";

	$rn = array(
		"d3w5",
		"26wy",
		"g3z9",
		"a4n8",
		"7fq2",
		"5n6s",
		"g6mz",
		"6ct9",
		"v8z2",
		"b43j" );
	if ( $rn[( int )$rn2] == strtolower( $rn1 ) ) {
		$url = site_url() . pvs_item_url( ( int )$_REQUEST["id"] );

		if ( preg_match( "/@/", $_REQUEST["email"] ) and preg_match( "/@/", $_REQUEST["email2"] ) ) {
			pvs_send_notification( 'tell_a_friend', $url );
		} else {
			$boxtell = "<p><b>" . pvs_word_lang( "error happened" ) . "</b></p>";
		}
	} else {
		$boxtell = "<p><b>" . pvs_word_lang( "error happened" ) . "</b></p>";
	}

} else
{
	$rr = rand( 0, 9 );
	
	$boxtell = '<form name="telladd" id="telladd"  Enctype="multipart/form-data">
	<input type="hidden" name="id" value="' . $id . '">
	
	<div class="form_field">
	<span>' . pvs_word_lang('your name') . ':</span>
	<input class="form-control" type="text" name="name" class="form-control" value="">
	</div>
	
	<div class="form_field">
	<span>' . pvs_word_lang('your e-mail') . ':</span>
	<input class="form-control" type="text" name="email" class="form-control">
	</div>
	
	<div class="form_field">
	<span>' . pvs_word_lang('friend name') . ':</span>
	<input class="form-control" type="text" name="name2" class="form-control">
	</div>
	
	<div class="form_field">
	<span>' . pvs_word_lang('friend e-mail') . ':</span>
	<input class="form-control" type="text" name="email2" class="form-control">
	</div>
	
	<div class="form_field">
	<img src="' . pvs_plugins_url() . '/assets/images/c' . $rr . '.gif" width="80" height="30">
	<input class="form-control" name="rn1" type="text" value="" style="width:80px"><input name="rn2" type="hidden" value="' . $rr . '">
	</div>
	
	<div class="form_field">
	<input class="btn btn-primary" type="button" onClick="tell_add(\'telladd\');" value="' . pvs_word_lang('send') . '">
	</div>
	
	</form>';
}
echo ( $boxtell );

?>
