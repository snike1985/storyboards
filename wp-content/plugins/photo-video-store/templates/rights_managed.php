<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );


$title = pvs_word_lang( "rights managed" );
$price = 0;
$publication_title = "";
$publication_id = ( int )$_REQUEST["id"];



$sql = "select rights_managed,title from " . PVS_DB_PREFIX . "media where id=" . $publication_id;


$price_id = 0;
$dr->open( $sql );
if ( ! $dr->eof ) {
	$price_id = $dr->row["rights_managed"];
	$translate_results = pvs_translate_publication( $publication_id, $dr->row["title"], "", "" );
	$publication_title = $translate_results["title"];
}

unset( $_SESSION["rights_managed" . $publication_id] );
unset( $_SESSION["rights_managed_value" . $publication_id] );
$_SESSION["rights_managed" . $publication_id] = array();
$_SESSION["rights_managed_value" . $publication_id] = array();

if ( file_exists( pvs_upload_dir() . "/" .
	"rights_managed.tpl" ) ) {
	$cart_content = file_get_contents( pvs_upload_dir() . "/" .
		$site_template_url . "rights_managed.tpl" );
} else
{
	$cart_content = "Error. There is no the template: /tremplates/template[n]/rights_managed.tpl. You should upload it on ftp.";
}

$sql = "select price from " . PVS_DB_PREFIX . "rights_managed where id=" . $price_id;
$rs->open( $sql );
if ( ! $rs->eof ) {
	$price = $rs->row["price"];
}

$_SESSION["rights_managed_price" . $publication_id] = $price;

//Show thumb
$size_result = pvs_define_thumb_size( $publication_id );

$itg = "";
$nlimit = 0;
$flag_visible = true;
$first_step_id = 0;
pvs_build_rights_managed( $publication_id, 0, $price_id );

$rights_managed = $itg;



$cart_content = '<form id="cart_form" style="margin:0px" enctype="multipart/form-data">
<div id="lightbox_header">
	' . pvs_word_lang("Rights managed") . '
</div>
	
<div id="lightbox_content">
	<table border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
		<img src="' . $size_result["thumb"] . '" style="width:' . $size_result["width"] . 'px;height:' . $size_result["height"] . 'px">
	</td>
	<td style="padding-left:15px;">
		<h2>' . $publication_title . ' &mdash; #' . $publication_id . '</h2>
		' . $rights_managed . '
		<div style="margin-left:7px;display:none" id="price_box"><b>' . pvs_word_lang("Price") . ': <div id="rights_managed_price" style="display:inline" class="price">' . pvs_currency( 1 ) . pvs_price_format( $price,
	2 ) . " " . pvs_currency( 2 ) . '</div></b></div>
	</td>
	</tr>
	</table>
</div>
<div id="lightbox_footer" style="display:none">
	<input type="button" value="' . pvs_word_lang("Add to cart") . '" class="lightbox_button" onClick="location.href=\'' . site_url() . '/shopping-cart-add-rights-managed/?id=' . $publication_id . '\'" style="margin-left:153px;">
</div>
</form>';

$GLOBALS['_RESULT'] = array( "cart_content" => $cart_content );

?>