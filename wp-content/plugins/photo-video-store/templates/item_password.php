<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$sql = "select category_id from " . PVS_DB_PREFIX . "category_items where publication_id=" . ( int )$_POST["id_parent"];
$ds->open($sql);
while( !$ds->eof ) {
	$sql = "select id,password from " . PVS_DB_PREFIX .
		"category where id=" . $ds->row["category_id"];
	$rs->open( $sql );
	if ( $rs->row["password"] == $_POST["password"] ) {
		if ( ! isset( $_SESSION["cprotected"] ) ) {
			$_SESSION["cprotected"] = $ds->row["category_id"];
		} else {
			$_SESSION["cprotected"] .= "|" . $ds->row["category_id"];
		}
	}
	$ds->movenext();
}

header( "location:" . $_POST["back_url"] );
?>