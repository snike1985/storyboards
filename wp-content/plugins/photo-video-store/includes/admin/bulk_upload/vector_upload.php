<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Zip library
include ( PVS_PATH . "/includes/plugins/zip/pclzip.lib.php" );


$swait = false;

$upload_limit = 50;

$ids = array();
//Rights managed
$rights_managed = 0;

if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] == 1 ) {
	$sql = "select id from " . PVS_DB_PREFIX . "rights_managed where vector=1";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$ids[] = $ds->row["id"];
		$ds->movenext();
	}
	$rights_managed = 1;
} else
{
	$sql = "select id_parent from " . PVS_DB_PREFIX .
		"vector_types order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$ids[] = $ds->row["id_parent"];
		$ds->movenext();
	}
}

$n = 0;
$afiles = array();
$bfiles = array();

$dir = opendir( pvs_upload_dir() . $pvs_global_settings["vectorpreupload"] );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." && $file != "index.html" ) {
		if ( preg_match( "/.jpg$|.jpeg$/i", $file ) ) {
			//if(count($afiles)<$upload_limit)
			//{
			$afiles[count( $afiles )] = $file;
			//}
			$n++;
		} else {
			$bfiles[count( $bfiles )] = $file;
		}
	}
}
closedir( $dir );

sort( $afiles );
reset( $afiles );
sort( $bfiles );
reset( $bfiles );

if ( count( $afiles ) < $upload_limit ) {
	$upload_limit = count( $afiles );
}

for ( $j = 0; $j < $upload_limit; $j++ ) {
	$flag_upload = false;
	for ( $i = 0; $i < count( $ids ); $i++ ) {
		if ( isset( $_POST["file" . $ids[$i] . "_" . $j] ) and $_POST["file" . $ids[$i] .
			"_" . $j] != "" ) {
			$flag_upload = true;
		}
	}

	$vector = "";

	if ( $flag_upload == true ) {
		$title = pvs_result( $_POST["title" . $j] );
		if ( $title == "" ) {
			$title = "vector" . $j;
		}

		$pub_vars = array();
		$pub_vars["title"] = $title;
		$pub_vars["description"] = pvs_result( $_POST["description" . $j] );
		$pub_vars["keywords"] = pvs_result( $_POST["keywords" . $j] );
		//$pub_vars["userid"]=pvs_user_login_to_id($_POST["author"]);
		$pub_vars["userid"] = 0;
		$pub_vars["published"] = 1;
		$pub_vars["viewed"] = 0;
		$pub_vars["data"] = pvs_get_time();
		$pub_vars["author"] = pvs_result( $_POST["author"] );
		$pub_vars["content_type"] = $pvs_global_settings["content_type"];
		$pub_vars["downloaded"] = 0;
		$pub_vars["model"] = ( int )$_POST["model" . $j];
		$pub_vars["examination"] = 0;
		$pub_vars["server1"] = $site_server_activ;
		$pub_vars["free"] = 0;

		$pub_vars["google_x"] = 0;
		$pub_vars["google_y"] = 0;

		//Add a new vector to the database
		$id = pvs_publication_media_add(4);

		$folder = $id;

		$previewphoto = $pvs_global_settings["vectorpreupload"] . pvs_result( $_POST["previewphoto" .
			$j] );

		//Photo preview
		$fn = explode( ".", strtolower( $_POST["previewphoto" . $j] ) );
		if ( $_POST["previewphoto" . $j] != "" and ( $fn[count( $fn ) - 1] == "jpg" or $fn[count
			( $fn ) - 1] == "jpeg" ) ) {
			pvs_photo_resize( pvs_upload_dir() . $previewphoto, pvs_upload_dir(). $site_servers[$site_server_activ] . "/" . $folder . "/thumb1.jpg", 1 );

			pvs_photo_resize( pvs_upload_dir() . $previewphoto, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/thumb2.jpg", 2 );

			pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/thumb2.jpg" );

			pvs_publication_iptc_add( $id, pvs_upload_dir() . $previewphoto );

			copy( pvs_upload_dir() . $previewphoto, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder .
				"/thumb_original.jpg" );

			unlink( pvs_upload_dir() . $previewphoto );
		}

		//Upload zip preview
		$nf = explode( ".", $_POST["previewphoto" . $j] );
		if ( strtolower( $nf[count( $nf ) - 1] ) == "zip" ) {
			pvs_publication_zip_preview( $previewphoto );
		}

		//copy file for sale
		if ( $rights_managed == 0 ) {
			$sql = "select * from " . PVS_DB_PREFIX . "vector_types order by priority";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $ds->row["shipped"] != 1 )
				{
					if ( isset( $_POST["file" . $ds->row["id_parent"] . "_" . $j] ) and $_POST["file" .
						$ds->row["id_parent"] . "_" . $j] != "" )
					{
						$vector = $pvs_global_settings["vectorpreupload"] . pvs_result( $_POST["file" .
							$ds->row["id_parent"] . "_" . $j] );
						@copy( pvs_upload_dir() . $vector, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/" . pvs_result
							( $_POST["file" . $ds->row["id_parent"] . "_" . $j] ) );
						$file = $_POST["file" . $ds->row["id_parent"] . "_" . $j];

						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . $ds->row["title"] . "','" . pvs_result( $file ) . "'," . floatval( $ds->
							row["price"] ) . "," . $ds->row["priority"] . ",0," . $ds->row["id_parent"] .
							")";
						$db->execute( $sql );
					}
				} else
				{
					if ( isset( $_POST["file" . $ds->row["id_parent"] . "_" . $j] ) )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . $ds->row["title"] . "','" . pvs_result( $file ) . "'," . floatval( $ds->
							row["price"] ) . "," . $ds->row["priority"] . ",1," . $ds->row["id_parent"] .
							")";
						$db->execute( $sql );
					}
				}

				$ds->movenext();
			}
		} else {
			$flag_rights = false;

			$sql = "select id,price,title from " . PVS_DB_PREFIX .
				"rights_managed where vector=1";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( isset( $_POST["file" . $ds->row["id"] . "_" . $j] ) and $_POST["file" . $ds->
					row["id"] . "_" . $j] != "" and $flag_rights == false )
				{
					$vector = pvs_upload_dir() . pvs_result( $_POST["file" .
						$ds->row["id"] . "_" . $j] );

					@copy( pvs_upload_dir() . $vector, pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $folder . "/" . pvs_result
						( $_POST["file" . $ds->row["id"] . "_" . $j] ) );

					$file = $_POST["file" . $ds->row["id"] . "_" . $j];

					$sql = "insert into " . PVS_DB_PREFIX .
						"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
						",'" . $ds->row["title"] . "','" . pvs_result( $file ) . "'," . floatval( $ds->
						row["price"] ) . ",0,0," . $ds->row["id"] . ")";
					$db->execute( $sql );

					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )$ds->
						row["id"] . " where id=" . $id;
					$db->execute( $sql );

					$flag_rights = true;
				}

				$ds->movenext();
			}
		}
	}
}
?>