<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$id = ( int )$_GET["id"];

if ( $id != 0 ) {
	//Check
	$sql = "select id_parent,user_owner from " . PVS_DB_PREFIX .
		"lightboxes_admin where user=" . get_current_user_id() .
		" and id_parent=" . $id . " and  user_owner=1";
	$rs->open( $sql );
	if ( $rs->eof ) {
		exit();
	}

	//Update the lightbox
	$sql = "update " . PVS_DB_PREFIX . "lightboxes set title='" . pvs_result( $_POST["title"] ) .
		"',description='" . pvs_result( $_POST["description"] ) . "' where id=" . $id;
	$db->execute( $sql );
} else
{
	//Add a new lightbox
	$sql = "insert into " . PVS_DB_PREFIX .
		"lightboxes (title,description) values ('" . pvs_result( $_POST["title"] ) .
		"','" . pvs_result( $_POST["description"] ) . "')";
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX . "lightboxes where title='" .
		pvs_result( $_POST["title"] ) . "' order by id desc";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$id = $dr->row["id"];

		$sql = "insert into " . PVS_DB_PREFIX .
			"lightboxes_admin (id_parent,user,user_owner) values (" . $dr->row["id"] . "," .
			get_current_user_id() . ",1)";
		$db->execute( $sql );
	}
}

//Remove administrators
$sql = "delete from " . PVS_DB_PREFIX . "lightboxes_admin where id_parent=" . $id .
	" and user_owner<>1";
$db->execute( $sql );

//Add administrators
foreach ( $_POST as $key => $value ) {
	if ( preg_match( "/user/i", $key ) ) {
		$user_id = intval( str_replace( "user", "", $key ) );
		if ( $user_id != 0 ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"lightboxes_admin (id_parent,user,user_owner) values (" . $id . "," . $user_id .
				",0)";
			$db->execute( $sql );
		}
	}
}



header( "location:" . site_url() . "/my-favorite-list/" );?>