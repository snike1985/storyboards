<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

//Upload function


$com = "";
if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "common" ) {
	$com = " and buyer=1 ";
}
if ( pvs_get_user_type () == "seller" or pvs_get_user_type () ==
	"common" ) {
	$com = " and seller=1 ";
}
if ( pvs_get_user_type () == "affiliate" or pvs_get_user_type () ==
	"common" ) {
	$com = " and affiliate=1 ";
}

$sql = "select title,description,filesize from " . PVS_DB_PREFIX .
	"documents_types where enabled=1 " . $com . " and id=" . ( int )$_POST["document_type"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$_FILES["document_file"]['name'] = pvs_result_file( $_FILES["document_file"]['name'] );

	if ( $_FILES["document_file"]['size'] > 0 and $_FILES["document_file"]['size'] <
		$rs->row["filesize"] * 1024 * 1024 ) {
		$file_filename = pvs_get_file_info( $_FILES["document_file"]['name'], "filename" );
		$file_extention = strtolower( pvs_get_file_info( $_FILES["document_file"]['name'],
			"extention" ) );

		if ( ( $file_extention == "jpg" or $file_extention == "pdf" ) and ! preg_match( "/text/i",
			$_FILES["document_file"]['type'] ) ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"documents (id_parent,title,user_id,status,filename,data,comment) values (" . ( int )
				$_POST["document_type"] . ",'" . $rs->row["title"] . "'," . get_current_user_id() .
				",0,'" . $file_filename . "." . $file_extention . "'," . pvs_get_time( date( "H" ),
				date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . ",'')";
			$db->execute( $sql );

			$sql = "select id from " . PVS_DB_PREFIX . "documents where user_id=" . ( int )
				get_current_user_id() . " order by data desc";
			$ds->open( $sql );
			$id = $ds->row["id"];

			$img = "/content/users/doc_" . $id . "_" . $file_filename . "." . $file_extention;
			move_uploaded_file( $_FILES["document_file"]['tmp_name'], pvs_upload_dir() .
				$img );
		}
	}
}



pvs_redirect_file( site_url() . "/profile-about/", true );
?>