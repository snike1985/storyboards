<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

//Check
$sql = "select id_parent,user_owner from " . PVS_DB_PREFIX .
	"lightboxes_admin where user=" . get_current_user_id() .
	" and id_parent=" . ( int )$_GET["id"] . " and  user_owner=1";
$rs->open( $sql );
if ( $rs->eof ) {
	exit();
}

$sql = "delete from " . PVS_DB_PREFIX . "lightboxes where id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "lightboxes_admin where id_parent=" . ( int )
	$_GET["id"];
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "lightboxes_files where id_parent=" . ( int )
	$_GET["id"];
$db->execute( $sql );



header( "location:" . site_url() . "/my-favorite-list/" );?>