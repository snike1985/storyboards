<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$xls_content = "";
$html_content = "<html><body><table border='1'>";

function xlsBOF() {
	global $xls_content;
	$xls_content .= pack( "ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0 );
	return;
}

function xlsEOF() {
	global $xls_content;
	$xls_content .= pack( "ss", 0x0A, 0x00 );
	return;
}

function xlsWriteNumber( $Row, $Col, $Value ) {
	global $xls_content;
	$xls_content .= pack( "sssss", 0x203, 14, $Row, $Col, 0x0 );
	$xls_content .= pack( "d", $Value );
	return;
}

function xlsWriteLabel( $Row, $Col, $Value ) {
	global $xls_content;
	$L = strlen( $Value );
	$xls_content .= pack( "ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L );
	$xls_content .= $Value;
	return;
}

$export_file = "downloads_" . pvs_get_user_login () . ".xls";

header( 'Pragma: public' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' ); // HTTP/1.1
header( 'Cache-Control: pre-check=0, post-check=0, max-age=0' ); // HTTP/1.1
header( "Pragma: no-cache" );
header( "Expires: 0" );
header( 'Content-Transfer-Encoding: utf8' );
header( 'Content-Type: application/vnd.ms-excel;' );
header( 'Content-Disposition: attachment; filename="' . $export_file . '"' );

/*
xlsBOF(); 

xlsWriteLabel(0,0,"File");
xlsWriteLabel(0,1,"Date");
xlsWriteLabel(0,2,"Order");
xlsWriteLabel(0,3,"Price");
xlsWriteLabel(0,4,"Download");
*/

$html_content .= "<tr><th>File</th><th>Date</th><th>Order</th><th>Price</th><th>Download</th></tr>";

$n = 1;

$sql = "select * from " . PVS_DB_PREFIX . "downloads where user_id=" . get_current_user_id() .
	" order by data desc";
$rs->open( $sql );

while ( ! $rs->eof ) {

	$preview = "";
	$preview_size = "";

	$sql = "select server1,title,media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )
			$rs->row["publication_id"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		if ( pvs_media_type ($ds->row["media_id"]) == 'photo' )
		{
			$preview = pvs_show_preview( $rs->row["publication_id"], "photo", 1, 1, $ds->
				row["server1"], $rs->row["publication_id"] );
			$preview_title = $ds->row["title"];
			$preview_class = 1;
	
			$image_width = 0;
			$image_height = 0;
			$image_filesize = 0;
			$flag_storage = false;
	
			if ( pvs_is_remote_storage() ) {
				$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
					PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["publication_id"];
				$ds->open( $sql );
				while ( ! $ds->eof )
				{
					if ( $ds->row["item_id"] != 0 )
					{
						$image_width = $ds->row["width"];
						$image_height = $ds->row["height"];
						$image_filesize = $ds->row["filesize"];
					}
	
					$flag_storage = true;
					$ds->movenext();
				}
			}
	
			$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
				row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof ) {
				if ( ! $flag_storage )
				{
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
						$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
					{
						$size = @getimagesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
							"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
						$image_width = $size[0];
						$image_height = $size[1];
						$image_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
							"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
					}
				}
	
				$sql = "select size from " . PVS_DB_PREFIX . "sizes where id_parent=" . $dr->
					row["price_id"];
				$dn->open( $sql );
				if ( ! $dn->eof )
				{
					if ( $dn->row["size"] != 0 and $image_width != 0 and $image_height != 0 )
					{
						if ( $image_width > $image_height )
						{
							$image_height = round( $image_height * $dn->row["size"] / $image_width );
							$image_width = $dn->row["size"];
						} else
						{
							$image_width = round( $image_width * $dn->row["size"] / $image_height );
							$image_height = $dn->row["size"];
						}
						$image_filesize = 0;
					}
				}
			}
	
			$preview_size = "<br>" . $image_width . "x" . $image_height;
			if ( $image_filesize != 0 ) {
				$preview_size .= " " . strval( pvs_price_format( $image_filesize / ( 1024 * 1024 ),
					3 ) ) . " Mb.";
			}
		}
	}
	
	if ( pvs_media_type ($ds->row["media_id"]) == 'video' )
	{
		$preview = pvs_show_preview( $rs->row["publication_id"], "video", 1, 1, $ds->
			row["server1"], $rs->row["publication_id"] );
		$preview_title = $ds->row["title"];
		$preview_class = 2;

		$flag_storage = false;
		$file_filesize = 0;

		if ( pvs_is_remote_storage() ) {
			$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["publication_id"] .
				" and item_id=" . $rs->row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$file_filesize = $dr->row["filesize"];
				$flag_storage = true;
			}
		}

		if ( ! $flag_storage ) {
			$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
				row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
					$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
				{
					$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
						"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
				}
			}
		}

		$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
			1024 ), 3 ) ) . " Mb.";
	}

	if ( pvs_media_type ($ds->row["media_id"]) == 'audio' )
	{
		$preview = pvs_show_preview( $rs->row["publication_id"], "audio", 1, 1, $ds->
			row["server1"], $rs->row["publication_id"] );
		$preview_title = $ds->row["title"];
		$preview_class = 3;

		$flag_storage = false;
		$file_filesize = 0;

		if ( pvs_is_remote_storage() ) {
			$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["publication_id"] .
				" and item_id=" . $rs->row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$file_filesize = $dr->row["filesize"];
				$flag_storage = true;
			}
		}

		if ( ! $flag_storage ) {
			$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
				row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
					$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
				{
					$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
						"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
				}
			}
		}

		$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
			1024 ), 3 ) ) . " Mb.";
	}

	if ( pvs_media_type ($ds->row["media_id"]) == 'vector' )
	{
		$preview = pvs_show_preview( $rs->row["publication_id"], "vector", 1, 1, $ds->
			row["server1"], $rs->row["publication_id"] );
		$preview_title = $ds->row["title"];
		$preview_class = 4;

		$flag_storage = false;
		$file_filesize = 0;

		if ( pvs_is_remote_storage() ) {
			$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["publication_id"] .
				" and item_id=" . $rs->row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$file_filesize = $dr->row["filesize"];
				$flag_storage = true;
			}
		}

		if ( ! $flag_storage ) {
			$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
				row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
					$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
				{
					$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
						"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
				}
			}
		}

		$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
			1024 ), 3 ) ) . " Mb.";
	}

	$item_name = "";
	$sql = "select name from " . PVS_DB_PREFIX . "items where id=" . ( int )$rs->
		row["id_parent"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$item_name = "<br><b>" . $ds->row["name"] . "</b>";
	}

	$html_content .= "<tr>";
	$html_content .= "<td>" . strip_tags( "#" . $rs->row["publication_id"] . " " . $item_name .
		" (" . $preview_size . ")" ) . "</td>";
	$html_content .= "<td>" . date( date_format, ( $rs->row["data"] - $pvs_global_settings["download_expiration"] *
		3600 * 24 ) ) . "</td>";

	//xlsWriteLabel($n,0,strip_tags("#".$rs->row["publication_id"]." ".$item_name." (".$preview_size.")"));
	//xlsWriteLabel($n,1,date(date_format,($rs->row["data"]-$pvs_global_settings["download_expiration"]*3600*24)));

	$price = 0;

	if ( $rs->row["order_id"] != 0 ) {
		//xlsWriteLabel($n,2,"Order #".$rs->row["order_id"]);
		$html_content .= "<td>Order #" . $rs->row["order_id"] . "</td>";

		$sql = "select price from " . PVS_DB_PREFIX . "orders_content where id_parent=" .
			$rs->row["order_id"] . " and item=" . $rs->row["id_parent"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$price = $ds->row["price"];
		}
	} elseif ( $rs->row["subscription_id"] != 0 ) {
		//xlsWriteLabel($n,2,"Subscription #".$rs->row["subscription_id"]);
		$html_content .= "<td>Subscription #" . $rs->row["subscription_id"] . "</td>";

		$sql = "select price from " . PVS_DB_PREFIX . "items where id=" . $rs->row["id_parent"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$price = $ds->row["price"];
		}
	} else {
		//xlsWriteLabel($n,2,"Free");
		$html_content .= "<td>Free</td>";
	}

	//xlsWriteLabel($n,3,pvs_currency(1,false).pvs_price_format($price,2)." ".pvs_currency(2,false));
	$html_content .= "<td>" . pvs_currency( 1, false ) . pvs_price_format( $price, 2 ) .
		" " . pvs_currency( 2, false ) . "</td>";

	if ( $rs->row["tlimit"] > $rs->row["ulimit"] or $rs->row["data"] < pvs_get_time
		( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) ) {
		xlsWriteLabel( $n, 4, "Expired" );
		$html_content .= "<td>Expired</td>";
	} else {
		xlsWriteLabel( $n, 4, site_url() . "/download/?f=" . $rs->row["link"] );
		$html_content .= "<td>" . site_url() . "/download/?f=" . $rs->row["link"] .
			"</td>";
	}
	$n++;
	$rs->movenext();
}

//xlsEOF();

$html_content .= "</table></body></html>";

//echo($xls_content);
echo ( $html_content );

?>
