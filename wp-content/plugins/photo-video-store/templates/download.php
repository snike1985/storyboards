<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "download_mimes.php" );


//Order photo download
if ( isset( $_GET["f"] ) ) {
	$sql = "select id_parent,link,data,tlimit,ulimit,publication_id,collection_id from " .
		PVS_DB_PREFIX . "downloads where link='" . pvs_result_strict( $_GET["f"] ) .
		"' and data>" . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
		date( "d" ), date( "Y" ) ) . " and tlimit<ulimit+1";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		if ( (int) $ds->row["collection_id"] == 0) {
			$sql = "update " . PVS_DB_PREFIX . "downloads set tlimit=tlimit+1 where link='" . pvs_result_strict( $_GET["f"] ) . "'";
			$db->execute( $sql );
	
			$publication_id = $ds->row["publication_id"];
			$publication_item = $ds->row["id_parent"];
	
			$sql = "select media_id,server1 from " . PVS_DB_PREFIX . "media where id=" . $publication_id;
			$rs->open( $sql );
			if ( ! $rs->eof ) {
				if ( $rs->row["media_id"] == 1 )
				{
					$publication_type = "photo";
				}
				if ( $rs->row["media_id"] == 2 )
				{
					$publication_type = "video";
				}
				if ( $rs->row["media_id"] == 3 )
				{
					$publication_type = "audio";
				}
				if ( $rs->row["media_id"] == 4 )
				{
					$publication_type = "vector";
					
				}
				$publication_server = $rs->row["server1"];
			}
			$download_regime = "order";
			include ( "download_process.php" );
		} else {
			$sql = "update " . PVS_DB_PREFIX . "downloads set tlimit=tlimit+1 where link='" . pvs_result_strict( $_GET["f"] ) . "'";
			$db->execute( $sql );
		
			$sql = "select id, title, price, description from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . (int)$ds->row["collection_id"];
			$dd->open( $sql );
			if ( ! $dd->eof ) {
				$download_regime = "collection";
				$collection_id = (int)$ds->row["collection_id"];
				include ( "download_process.php" );
			}
		}
	} else {
		echo ( pvs_word_lang( "expired" ) );
	}
	exit();
}
//End. Order photo download



//define folder and filename
$flag = false;
$uu = explode( "/", $_GET["u"] );
$publication_id = ( int )$uu[count( $uu ) - 2];
$publication_file = pvs_result( $uu[count( $uu ) - 1] );
$publication_extention = pvs_get_file_info( $publication_file, "extention" );

//define if the publication is remote storage
$flag_storage = false;
$remote_file = "";
$remote_filename = "";
$remote_extention = "";

if ( pvs_is_remote_storage() ) {
	$sql = "select url,filename1,filename2,width,height,item_id from " .
		PVS_DB_PREFIX . "filestorage_files where id_parent=" . $publication_id .
		" and filename1='" . $publication_file . "'";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$remote_file = $dr->row["url"] . "/" . $dr->row["filename2"];
		$remote_filename = $dr->row["filename1"];
		$flag_storage = true;
	}

	if ( $flag_storage ) {
		$remote_ext = explode( ".", $remote_file );
		$remote_extention = strtolower( $remote_ext[count( $remote_ext ) - 1] );
	}
}

//Define content folder
$server1 = 1;

$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . $publication_id;
$rs->open( $sql );
if ( ! $rs->eof ) {
	$server1 = $rs->row["server1"];
}

//Show thumbs
if ( preg_match( "/thumb|thumbnail|model|avatar|users|blog|categories|xml/", $_GET["u"] ) ) {
	$flag = true;
}



//Show files in admin panel
if ( pvs_is_user_admin () ) {
	$flag = true;
}

//Show own files of a photographer
if ( is_user_logged_in() ) {
	$sql = "select id from " . PVS_DB_PREFIX . "media where id=" . $publication_id .
		" and (userid=" . get_current_user_id() . " or author='" . pvs_result( pvs_get_user_login () ) .
		"')";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$flag = true;
	}
}

if ( $flag == true ) {
	if ( ! $flag_storage ) {
		if ( isset( $mmtype[strtolower( $publication_extention )] ) ) {
			header( "Content-Type:" . $mmtype[strtolower( $publication_extention )] );
			header( "Content-Disposition: attachment; filename=" . str_replace( " ", "%20",
				$publication_file ) );
			pvs_readfile_chunked( pvs_upload_dir() . pvs_server_url( $server1 ) . "/" . $publication_id .
				"/" . $publication_file );
		}
	} else {
		if ( isset( $mmtype[$remote_extention] ) ) {
			header( "Content-Type:" . $mmtype[$remote_extention] );
			header( "Content-Disposition: attachment; filename=" . $remote_filename );
			@readfile( $remote_file );
			exit();
		}
	}

	exit();
} else
{
	header( "Content-Type: image/gif" );
	readfile( PVS_PATH .  'assets/images/access_denied.gif' );
	exit();
}
?>