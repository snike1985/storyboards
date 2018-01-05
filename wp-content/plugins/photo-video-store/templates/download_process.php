<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

//Define if the publication is remote
$flag_storage = false;

$file_redirect = array();
$file_redirect_original = array();
$file_name = array();
$file_name_original = array();
$file_extention = array();
$file_filesize = array();
$file_width = array();
$file_height = array();
$file_size = array();

include ( PVS_PATH . "includes/plugins/zip/pclzip.lib.php" );

if ( !isset($collection_id)) {
	//Subscription limit
	$subscription_limit = $pvs_global_settings["subscription_limit"];
	
	if ( pvs_is_remote_storage() ) {
		$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
			PVS_DB_PREFIX . "filestorage_files where id_parent=" . ( int )$publication_id .
			" and item_id<>0";
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			$ext = strtolower( pvs_get_file_info( $ds->row["filename1"], "extention" ) );
	
			if ( $publication_type == "photo" ) {
				$file_redirect[$ext] = $ds->row["url"] . "/" . $ds->row["filename2"];
				$file_redirect_original[$ext] = $ds->row["url"] . "/" . $ds->row["filename2"];
				$file_name[$ext] = $ds->row["filename1"];
				$file_name_original[$ext] = pvs_get_file_info( $ds->row["filename1"], "filename" );
				$file_extention[$ext] = pvs_get_file_info( $ds->row["filename1"], "extention" );
				$file_width[$ext] = $ds->row["width"];
				$file_height[$ext] = $ds->row["height"];
				$file_size[$ext] = $ds->row["filesize"];
			} else {
				$item_ids = array();
				$sql = "select id from " . PVS_DB_PREFIX . "items where url='" . $ds->row["filename1"] .
					"' and id_parent=" . ( int )$publication_id;
				$dr->open( $sql );
				while ( ! $dr->eof )
				{
					$item_ids[] = $dr->row["id"];
					$dr->movenext();
				}
	
				if ( $ds->row["item_id"] == ( int )$publication_item or in_array( ( int )$publication_item,
					$item_ids ) )
				{
					$file_redirect[$ext] = $ds->row["url"] . "/" . $ds->row["filename2"];
					$file_redirect_original[$ext] = $ds->row["url"] . "/" . $ds->row["filename2"];
					$file_name[$ext] = $ds->row["filename1"];
					$file_name_original[$ext] = pvs_get_file_info( $ds->row["filename1"], "filename" );
					$file_extention[$ext] = pvs_get_file_info( $ds->row["filename1"], "extention" );
					$file_size[$ext] = $ds->row["filesize"];
				}
			}
	
			$flag_storage = true;
			$ds->movenext();
		}
	}

	
	$sql = "select id,id_parent,url,price,price_id,watermark from " . PVS_DB_PREFIX .
		"items where id=" . ( int )$publication_item;
	$dr->open( $sql );
	
	$flag_free = false;
	
	if ( ! $dr->eof ) {
	
		if ( $publication_type == "photo" ) {
			$sql = "select free,server1,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps,rights_managed from " .
				PVS_DB_PREFIX . "media where id=" . ( int )$publication_id;

			$photo_formats = array();
			$sql2 = "select id,photo_type from " . PVS_DB_PREFIX .
				"photos_formats where enabled=1 order by id";
			$ds->open( $sql2 );
			while ( ! $ds->eof )
			{
				$photo_formats[$ds->row["id"]] = $ds->row["photo_type"];
				$ds->movenext();
			}
		} else {
			$sql = "select free,server1,rights_managed from " . PVS_DB_PREFIX . 
				"media where id=" . ( int )$publication_id;
		}
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			if ( ( $rs->row["free"] == 1 or $dr->row["price"] == 0 ) and $download_regime ==
				"subscription" )
			{
				if ( $pvs_global_settings["auth_freedownload"] )
				{
					$flag_free = pvs_create_free_downloads_link( ( int )$publication_item, ( int )$publication_id );

					if ( $flag_free )
					{
						$sql = "update " . PVS_DB_PREFIX .
							"media set downloaded=downloaded+1 where id=" . ( int )$publication_id;
						$db->execute( $sql );
					} else
					{
						header( "location:" . site_url() . "/download-limit/" );
						exit();
					}
				} else
				{
					$flag_free = true;

					$sql = "update " . PVS_DB_PREFIX . 
						"media set downloaded=downloaded+1 where id=" . ( int )$publication_id;
					$db->execute( $sql );
				}
			}

			$publication_server = $rs->row["server1"];
			$publication_rights_managed = $rs->row["rights_managed"];

			if ( $publication_type == "photo" )
			{
				$photo_files = array();
				foreach ( $photo_formats as $key => $value )
				{
					if ( $rs->row["url_" . $value] != "" )
					{
						$photo_files[$value] = $rs->row["url_" . $value];
					}
				}
			}
		}
	
		if ( ! $flag_storage ) {
			if ( $publication_type == "photo" ) {
				if ( $publication_rights_managed == 0 )
				{
					$sql = "select jpg,png,gif,raw,tiff,eps from " . PVS_DB_PREFIX .
						"sizes where id_parent='" . $dr->row["price_id"] . "'";
					$rs->open( $sql );
					if ( ! $rs->eof )
					{
						foreach ( $photo_formats as $key => $value )
						{
							if ( $rs->row[$value] == 1 and isset( $photo_files[$value] ) )
							{
								$file_redirect[$key] = pvs_upload_dir() . pvs_server_url( ( int )
									$publication_server ) . "/" . ( int )$publication_id . "/" . $photo_files[$value];
								$file_redirect_original[$key] = $file_redirect[$key];
								$file_name[$key] = $photo_files[$value];
								$file_name_original[$key] = pvs_get_file_info( $file_name[$key], "filename" );
								$file_extention[$key] = pvs_get_file_info( $file_name[$key], "extention" );
								$file_filesize[$key] = filesize( $file_redirect[$key] );
							}
						}
					}
				} else
				{
					foreach ( $photo_formats as $key => $value )
					{
						if ( isset( $photo_files[$value] ) )
						{
							$file_redirect[$key] = pvs_upload_dir() . pvs_server_url( ( int )
								$publication_server ) . "/" . ( int )$publication_id . "/" . $photo_files[$value];
							$file_redirect_original[$key] = $file_redirect[$key];
							$file_name[$key] = $photo_files[$value];
							$file_name_original[$key] = pvs_get_file_info( $file_name[$key], "filename" );
							$file_extention[$key] = pvs_get_file_info( $file_name[$key], "extention" );
							$file_filesize[$key] = filesize( $file_redirect[$key] );
						}
					}
				}
			} else {
			
				$file_redirect[0] = pvs_upload_dir() . pvs_server_url( ( int )
					$publication_server ) . "/" . ( int )$publication_id . "/" . $dr->row["url"];
				$file_redirect_original[0] = $file_redirect[0];
				$file_name[0] = $dr->row["url"];
				$file_name_original[0] = pvs_get_file_info( $file_name[0], "filename" );
				$file_extention[0] = pvs_get_file_info( $file_name[0], "extention" );
				$file_filesize[0] = filesize( $file_redirect[0] );
			}
		} else {
			if ( $publication_type == "photo" ) {
				if ( $publication_rights_managed == 0 )
				{
					$sql = "select jpg,png,gif,raw,tiff,eps from " . PVS_DB_PREFIX .
						"sizes where id_parent='" . $dr->row["price_id"] . "'";
					$rs->open( $sql );
					if ( ! $rs->eof )
					{
						foreach ( $photo_formats as $key => $value )
						{
							if ( $rs->row[$value] != 1 )
							{
								if ( $value == "jpg" )
								{
									unset( $file_redirect["jpeg"] );
									unset( $file_name["jpeg"] );
									unset( $file_name_original["jpeg"] );
									unset( $file_extention["jpeg"] );
									unset( $file_width["jpeg"] );
									unset( $file_height["jpeg"] );
									unset( $file_size["jpeg"] );
								} elseif ( $value == "tiff" )
								{
									unset( $file_redirect["tif"] );
									unset( $file_name["tif"] );
									unset( $file_name_original["tif"] );
									unset( $file_extention["tif"] );
									unset( $file_width["tif"] );
									unset( $file_height["tif"] );
									unset( $file_size["tif"] );
								}
	
								unset( $file_redirect[$value] );
								unset( $file_name[$value] );
								unset( $file_name_original[$value] );
								unset( $file_extention[$value] );
								unset( $file_width[$value] );
								unset( $file_height[$value] );
								unset( $file_size[$value] );
							}
						}
					}
				}
			}
		}
	
		//Subscription or free files
		if ( $download_regime == "subscription" ) {
			$subscription_plus = 0;
			if ( $subscription_limit == "Credits" ) {
				$subscription_plus = $dr->row["price"];
			}
			if ( $subscription_limit == "Downloads" ) {
				$subscription_plus = 1;
			}
			if ( $subscription_limit == "Bandwidth" ) {
				$subscription_plus = 0;
				foreach ( $file_filesize as $key => $value )
				{
					$subscription_plus += $value / ( 1024 * 1024 );
				}
			}
	
			if ( ( $pvs_global_settings["subscription"] and
				pvs_user_subscription( pvs_get_user_login (), ( int )$publication_id ) and
				pvs_bandwidth_user( pvs_get_user_login (), 0 ) + $subscription_plus <=
				pvs_bandwidth_user( pvs_get_user_login (), 1 ) ) or $flag_free ) {
				if ( ! $flag_free and $download_regime == "subscription" )
				{
					$flag_bandwidth_add = pvs_downloads_create_subscription( ( int )$publication_item,
						( int )$publication_id );
					if ( $flag_bandwidth_add )
					{
						pvs_bandwidth_add( pvs_get_user_login (), $subscription_plus );
						pvs_commission_subscription_add( pvs_result( pvs_get_user_login () ), ( int )
							$publication_id, ( int )$publication_item );
					}
				}
			} else {
				header( "location:" . site_url() . "/subscription/" );
				exit();
			}
		}
		//End Subscription or free files
	
		if ( $publication_type == "photo" ) {
			$sql = "select size,watermark,jpg,png,gif,raw,tiff,eps from " . PVS_DB_PREFIX .
				"sizes where id_parent='" . $dr->row["price_id"] . "'";
			$rs->open( $sql );
			if ( ! $rs->eof ) {
				$width = $rs->row["size"];
	
				foreach ( $file_redirect as $key => $value )
				{
					if ( $width != 0 or ( $width == 0 and $dr->row["watermark"] == 1 and $dr->row["price"] ==
						0 ) )
					{
						if ( strtolower( $file_extention[$key] ) == "jpg" or strtolower( $file_extention[$key] ) ==
							"jpeg" or strtolower( $file_extention[$key] ) == "gif" or strtolower( $file_extention[$key] ) ==
							"png" )
						{
							$file_redirect[$key] = pvs_upload_dir() . pvs_server_url( ( int )
								$publication_server ) . "/" . ( int )$publication_id . "/photo_" . $rs->row["size"] .
								"." . $file_extention[$key];
							$file_name[$key] = "photo_" . $rs->row["size"] . "." . $file_extention[$key];
	
							if ( ! $flag_storage )
							{
								$size = getimagesize( $file_redirect_original[$key], $info );
	
								if ( $size[1] > $size[0] )
								{
									$width = round( $size[0] * $width / $size[1] );
								}
	
								$height = round( $width * $size[1] / $size[0] );
	
								if ( $width == 0 )
								{
									$width = $size[0];
									$height = $size[1];
								}
	
								$flag_resize = false;
								if ( ! file_exists( $file_redirect[$key] ) or $dr->row["watermark"] == 1 )
								{
									@pvs_easyResize( $file_redirect_original[$key], $file_redirect[$key], 100, $width );
									$flag_resize = true;
								}
	
								$file_name_original[$key] .= "-ID" . ( int )$publication_id . "-" . $width . "x" .
									$height;
	
								if ( $rs->row["watermark"] == 1 )
								{
	
									if ( $pvs_global_settings["watermark_photo"] != "" and file_exists( pvs_upload_dir() .
										$pvs_global_settings["watermark_photo"] ) and $flag_resize )
									{
										pvs_watermark( $file_redirect[$key], pvs_upload_dir() . $pvs_global_settings["watermark_photo"] );
									}
	
									$file_name_original[$key] .= "-watermarked";
								}
	
								if ( isset( $info['APP13'] ) )
								{
									$content = iptcembed( $info['APP13'], $file_redirect[$key] );
									$fw = fopen( $file_redirect[$key], 'wb' );
									fwrite( $fw, $content );
									fclose( $fw );
								}
	
								pvs_set_dpi( $file_redirect[$key] );
							} else
							{
								if ( $file_height[$key] > $file_width[$key] and $file_height[$key] != 0 )
								{
									$width = round( $file_width[$key] * $width / $file_height[$key] );
								}
	
								if ( $width == 0 )
								{
									$width = $file_width[$key];
									$height = $file_height[$key];
								}
	
								$flag_resize = false;
								if ( ! file_exists( $file_redirect[$key] ) or $dr->row["watermark"] == 1 )
								{
									@pvs_easyResize( $file_redirect_original[$key], $file_redirect[$key], 100, $width );
									$flag_resize = true;
								}
	
								$height = round( $width * $file_height[$key] / $file_width[$key] );
	
								$file_name_original[$key] .= "-ID" . ( int )$publication_id . "-" . $width . "x" .
									$height;
	
								if ( $rs->row["watermark"] == 1 )
								{
									if ( $pvs_global_settings["watermark_photo"] != "" and file_exists( pvs_upload_dir() .
										$pvs_global_settings["watermark_photo"] ) and $flag_resize )
									{
										pvs_watermark( $file_redirect[$key], pvs_upload_dir() . $pvs_global_settings["watermark_photo"] );
									}
	
									$file_name_original[$key] .= "-watermarked";
								}
							}
						}
					}
				}
			}
		}
	
		if ( count( $file_redirect ) == 0 ) {
			echo ( "expired" );
			exit();
		}
	
		//Zip if more than one file
		if ( count( $file_redirect ) > 1 ) {
			$result_path = pvs_upload_dir() . pvs_server_url( ( int )$publication_server ) .
				"/" . ( int )$publication_id . "/archive-ID" . ( int )$publication_id . "-" . ( int )
				$publication_item . ".zip";
			$result_filename = "archive-ID" . ( int )$publication_id . "-" . ( int )$publication_item;
			$result_extention = "zip";
	
			if ( $flag_storage ) {
				foreach ( $file_redirect as $key => $value )
				{
					copy( $value, pvs_upload_dir() . pvs_server_url( ( int )$publication_server ) .
						"/" . ( int )$publication_id . "/" . $file_name[$key] );
					$file_redirect[$key] = pvs_upload_dir() . pvs_server_url( ( int )
						$publication_server ) . "/" . ( int )$publication_id . "/" . $file_name[$key];
				}
			}
	
			$archive = new PclZip( $result_path );
			$archive->create( $file_redirect, PCLZIP_OPT_ADD_PATH, $result_filename,
				PCLZIP_OPT_REMOVE_PATH, pvs_upload_dir() . pvs_server_url( ( int )
				$publication_server ) . "/" . ( int )$publication_id );
		} else {
			foreach ( $file_redirect as $key => $value ) {
				$result_path = $value;
				$result_filename = $file_name_original[$key];
				$result_extention = $file_extention[$key];
			}
		}
	
		header( "Content-Type:" . $mmtype[strtolower( $result_extention )] );
		header( "Content-Disposition: attachment; filename=" . str_replace( " ", "%20",
			$result_filename ) . "." . $result_extention );
		pvs_readfile_chunked( $result_path );
		//readfile($result_path);
	
		if ( $flag_storage ) {
			$dir = opendir( pvs_upload_dir() . pvs_server_url( ( int )
				$publication_server ) . "/" . ( int )$publication_id );
			while ( $file = readdir( $dir ) ) {
				if ( $file <> "." && $file <> ".." )
				{
					unlink( pvs_upload_dir() . pvs_server_url( ( int )$publication_server ) .
						"/" . ( int )$publication_id . "/" . $file );
				}
			}
		}
	}
} else {
	//Collection
	
	$sql = "select id, title, price, description,types from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . (int)$collection_id;
	$ds->open( $sql );
	if ( ! $ds->eof ) {	
		$collection_files = array();
		$collection_filenames = array();
		
		$result_folder = pvs_upload_dir() . "/content/categories/collection-" . $ds->row["id"] . "-" . pvs_result_strict( $_GET["f"] );
		$result_path = $result_folder . ".zip";
		$result_filename = "collection-" . $ds->row["id"] . "-" . pvs_result_strict( $_GET["f"] );
		$result_extention = "zip";
	
		if ($ds->row["types"] == 1) {
				$com = " and id in (select publication_id from " . PVS_DB_PREFIX . "collections_items where collection_id=" . ( int )$collection_id . ") ";		
		} else {
			$password_protected = pvs_get_password_protected();
		
			$com = " and id in (select publication_id from " . PVS_DB_PREFIX .
				"category_items where category_id in (select category_id from " . PVS_DB_PREFIX . "collections_items where collection_id=" . ( int )$collection_id. ")) ";
		
			if ( $password_protected != '' ) {
				$com .= " and id not in (select publication_id from " .
					PVS_DB_PREFIX . "category_items where " . $password_protected . ") ";
			}		
		}
	
	
		$sql = "select id,server1,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps,media_id from " . PVS_DB_PREFIX . "media where published = 1 " . $com;
		
		$rs->open($sql);
		while (!$rs->eof) {
			if ($rs->row['media_id'] == 1) {
				$ext_array = array ('jpg', 'png', 'gif', 'raw' , 'tiff',  'eps');
				for ( $i = 0; $i < count($ext_array); $i++ ) {
					if ($rs->row["url_" . $ext_array[$i]] != '' and file_exists(pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] . "/" . $rs->row["url_" . $ext_array[$i]])) {
						$collection_files[$rs->row["id"] . '_'  . $ext_array[$i]] = pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] . "/" . $rs->row["url_" . $ext_array[$i]];
						$collection_filenames[$rs->row["id"] . '_'  . $ext_array[$i]] = $rs->row["url_" . $ext_array[$i]];
					} else {
						if ( pvs_is_remote_storage() ) {
							$sql = "select url,filename1,filename2,width,height,item_id,filesize from " . PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["id"] . " and item_id<>0";
							$dn->open( $sql );
							while ( ! $dn->eof ) {
								if (! file_exists ($result_folder)) {
									mkdir( $result_folder);
								}
								
								if (! file_exists ($result_folder . "/" . $rs->row["id"])) {
									mkdir( $result_folder . "/" . $rs->row["id"]);
								}
								
								@copy($dn->row["url"] . "/" . $dn->row["filename2"], $result_folder . "/" . $rs->row["id"] . "/" . $dn->row["filename1"]);
							
								$collection_files[$rs->row["id"] . '_'  . $ext_array[$i]] = $result_folder . "/" . $rs->row["id"] . "/" . $dn->row["filename1"];
								$collection_filenames[$rs->row["id"] . '_'  . $ext_array[$i]] = $dn->row["filename1"];
								$dn->movenext();
							}
						}
					}
				}
			} else {
				$sql = "select id,url from " . PVS_DB_PREFIX . "items where shipped<>1 and id_parent=" . $rs->row["id"];
				$dr->open( $sql );
				if (!$dr->eof) {
					if (file_exists(pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] . "/" . $dr->row["url"])) {
						$collection_files[$rs->row["id"] . '_'  . $dr->row["id"]] = pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] . "/" . $dr->row["url"];
						$collection_filenames[$rs->row["id"] . '_'  . $dr->row["id"]] = $dr->row["url"];
					} else {	
						if ( pvs_is_remote_storage() ) {
							$sql = "select url,filename1,filename2,width,height,item_id,filesize from " . PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["id"] . " and item_id<>0";
							$dn->open( $sql );
							while ( ! $dn->eof ) {	
								if (! file_exists ($result_folder)) {
									mkdir( $result_folder);
								}	
								
								if (! file_exists ($result_folder . "/" . $rs->row["id"])) {
									mkdir( $result_folder . "/" . $rs->row["id"]);
								}
							
								@copy($dn->row["url"] . "/" . $dn->row["filename2"], $result_folder . "/" . $rs->row["id"] . "/" . $dn->row["filename1"]);
							
								$collection_files[$rs->row["id"] . '_'  . $dr->row["id"]] = $result_folder . "/" . $rs->row["id"] . "/" . $dn->row["filename1"];
								$collection_filenames[$rs->row["id"] . '_'  . $dr->row["id"]] = $dn->row["filename1"];								
								$dn->movenext();
							}
						}
					}
				}
			}
			$rs->movenext();
		}
		
		if ( count( $collection_files ) == 0 ) {
			echo ( "expired" );
			exit();
		} else {
			
			$archive = new PclZip( $result_path );
			
			if (! file_exists ($result_folder)) {
				$archive->create( $collection_files, PCLZIP_OPT_ADD_PATH, $result_filename, PCLZIP_OPT_REMOVE_PATH, pvs_upload_dir() . "" );
			} else {
				$archive->create( $collection_files, PCLZIP_OPT_ADD_PATH, $result_filename, PCLZIP_OPT_REMOVE_PATH, $result_folder );			
			}
			
			header( "Content-Type:" . $mmtype[strtolower( $result_extention )] );
			header( "Content-Disposition: attachment; filename=" . str_replace( " ", "%20", $result_filename ) . "." . $result_extention );
			pvs_readfile_chunked( $result_path );
			
			if (file_exists ($result_path)) {
				@unlink( $result_path );
			}
			
			if (file_exists ($result_folder)) {
				$dir = opendir( $result_folder );
				while ( $file = readdir( $dir ) ) {
					if ( $file <> "." && $file <> ".." )
					{
						if ( is_file( $result_folder . "/" . $file ) )
						{
							@unlink( $result_folder . "/" . $file );
						}
						if ( is_dir( $result_folder . "/" . $file ) )
						{
							$dir2 = opendir( $result_folder . "/" . $file );
							while ( $file2 = readdir( $dir2 ) )
							{
								if ( $file2 <> "." && $file2 <> ".." )
								{
									if ( is_file( $result_folder . "/" . $file . "/" . $file2 ) )
									{
										@unlink( $result_folder . "/" . $file . "/" . $file2 );
									}
								}
							}
							rmdir( $result_folder . "/" . $file );
						}
					}
				}	
				rmdir( $result_folder);
			}
		}
	}
}
?>