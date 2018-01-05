<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


include ( "JsHttpRequest.php" );?>
<?php
$JsHttpRequest = new JsHttpRequest( $mtg );

$id = ( int )$_REQUEST["id"];

$prints_content = file_get_contents( pvs_upload_dir() . "/" .
	$site_template_url . "prints_preview.tpl" );

$sql = "select title,description from " . PVS_DB_PREFIX .
	"prints where id_parent=" . $id;
$rs->open( $sql );
if ( ! $rs->eof ) {
	$prints_content = str_replace( "{TITLE}", $rs->row["title"], $prints_content );
	$prints_content = str_replace( "{DESCRIPTION}", $rs->row["description"], $prints_content );

	$preview_items = "";

	if ( file_exists( pvs_upload_dir() .
		"/content/prints/product" . $id . "_1_big.jpg" ) ) {
		$preview_items .= "<img src='" . site_url() . "/content/prints/product" . $id .
			"_1_big.jpg'>";
	}

	if ( file_exists( pvs_upload_dir() .
		"/content/prints/product" . $id . "_2_big.jpg" ) ) {
		$preview_items .= "<img src='" . site_url() . "/content/prints/product" . $id .
			"_2_big.jpg'>";
	}

	if ( file_exists( pvs_upload_dir() .
		"/content/prints/product" . $id . "_3_big.jpg" ) ) {
		$preview_items .= "<img src='" . site_url() . "/content/prints/product" . $id .
			"_3_big.jpg'>";
	}

	if ( $preview_items != "" ) {
		$preview_items = "<div id='galleria'>" . $preview_items .
			"</div><script> Galleria.loadTheme('" . pvs_plugins_url() .
			"/includes/plugins/galleria/themes/classic/galleria.classic.js'); Galleria.run('#galleria');</script>";
	}

	$prints_content = str_replace( "{IMAGE}", $preview_items, $prints_content );

}
$GLOBALS['_RESULT'] = array( "prints_content" => $prints_content );

?>