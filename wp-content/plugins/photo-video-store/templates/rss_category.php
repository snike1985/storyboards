<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

header( 'Content-Type: text/xml' );
$str = "";
$n = 0;

$sql = "select title,description from " . PVS_DB_PREFIX .
	"category where id_parent=" . ( int )$_GET["id"];
$ds->open( $sql );
if ( ! $ds->eof ) {

	$password_protected = pvs_get_password_protected();

	$category = " and id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id=" . ( int )$_GET["id"] . ") ";

	if ( $password_protected != '' ) {
		$category .= " and id not in (select publication_id from " .
			PVS_DB_PREFIX . "category_items where " . $password_protected . ") ";
	}

	$sql = "select id,title,data,description,published from " . PVS_DB_PREFIX .
		"media where published=1 " . $category . " order by data desc limit 10";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( $n < 10 ) {
			$content = $rs->row["description"];
			if ( strlen( $content ) > 0 )
			{
				$cont = explode( ".", $content );
				$content = $cont[0] . ".";
			}
			$str .= "<item><title>" . strip_tags( $rs->row["title"] ) .
				"</title><description>" . strip_tags( $content ) . "</description><link>" . site_url() .
				pvs_item_url( $rs->row["id"] ) . "</link><pubDate>" . date( "D, d M Y H:i:s", $rs->
				row["data"] ) . "</pubDate></item>";
		}
		$n++;
		$rs->movenext();
	}

	$str = "<?php xml version=\"1.0\" encoding=\"utf-8\"?><rss version=\"2.0\"><channel><title>" .
		$pvs_global_settings["site_name"] . " - Category - " . $ds->row["title"] .
		"</title><link>" . site_url() . pvs_category_url( ( int )$_GET["id"] ) .
		"</link><description>" . $ds->row["description"] .
		"</description><language>en</language>" . $str . "</channel></rss>";

}


echo ( $str );


?>