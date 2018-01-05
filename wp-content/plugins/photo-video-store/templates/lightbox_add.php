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

if ( is_user_logged_in() ) {
	$params["id"] = ( int )$_REQUEST["publication"];
	$params["user"] = get_current_user_id();

	$params["lightbox_name"] = "";
	if ( isset( $_REQUEST["new_lightbox"] ) ) {
		$params["lightbox_name"] = pvs_result( $_REQUEST["new"] );
	}

	$params["lightboxes"] = array();

	$sql = "select id_parent from " . PVS_DB_PREFIX . "lightboxes_admin where user=" . ( int )
		get_current_user_id();
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( isset( $_REQUEST["chk" . $rs->row["id_parent"]] ) ) {
			$params["lightboxes"][] = $rs->row["id_parent"];
		}
		$rs->movenext();
	}

	pvs_lightbox_add( $params );

	$GLOBALS['_RESULT'] = array( "result_code" => pvs_word_lang( "the file was added to the lightbox" ) );
} else
{
	$GLOBALS['_RESULT'] = array( "result_code" => pvs_word_lang( "You should login to use the option" ) );
}

?>