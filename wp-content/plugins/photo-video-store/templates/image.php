<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header( "Content-type: image/jpg" );

//Define photo
if ( @$_REQUEST["width"] <= $pvs_global_settings["thumb_width2"] + 300 and @$_REQUEST["height"] <=
	$pvs_global_settings["thumb_height2"] + 300 ) {
	//Define types


	$sql = "select server1,id,url_jpg,url_png,url_gif,media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )@$_REQUEST["id"];


	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$flag_storage = false;
		$file_url = "";
		$file_width = 0;
		$file_height = 0;
		$file_url_vector = "";
		$file_width_vector = 0;
		$file_height_vector = 0;
		$file_url_thumb = "";

		if ( pvs_is_remote_storage() ) {
			$sql = "select url,filename2,filename1,width,height,item_id from " .
				PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["id"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $ds->row["item_id"] != 0 )
				{
					$file_url = $ds->row["url"] . "/" . $ds->row["filename2"];
					$file_width = $ds->row["width"];
					$file_height = $ds->row["height"];
				}

				if ( $ds->row["item_id"] == 0 and preg_match( "/thumb2/", $ds->row["filename1"] ) )
				{
					$file_url_thumb = $ds->row["url"] . "/" . $ds->row["filename2"];
				}

				if ( $ds->row["filename1"] == "thumb_original.jpg" )
				{
					$file_url_vector = $ds->row["url"] . "/" . $ds->row["filename2"];
					$file_width_vector = $ds->row["width"];
					$file_height_vector = $ds->row["height"];
				}

				$flag_storage = true;
				$ds->movenext();
			}
		}

		$afile = "";
		if ( $rs->row["media_id"] == 1 ) {
			if ( $rs->row["url_jpg"] != "" )
			{
				$afile = $rs->row["url_jpg"];
			} elseif ( $rs->row["url_png"] != "" )
			{
				$afile = $rs->row["url_png"];
			} elseif ( $rs->row["url_gif"] != "" )
			{
				$afile = $rs->row["url_gif"];
			} else
			{
				$dir = opendir( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] );
				while ( $file = readdir( $dir ) )
				{
					if ( $file <> "." && $file <> ".." )
					{
						if ( preg_match( "/.jpg$|.jpeg$|.png$|.gif$/i", $file ) and ! preg_match( "/thumb/",
							$file ) and ! preg_match( "/photo_[0-9]+/", $file ) )
						{
							$afile = $file;
						}
					}
				}
				closedir( $dir );
			}
		} else {
			$afile = "thumb_original.jpg";
		}

		$fextention = strtolower( pvs_get_file_info( $afile, "extention" ) );

		if ( $afile != "" or $flag_storage ) {
			if ( $flag_storage )
			{
				if ( $rs->row["media_id"] == 1 )
				{
					$img_sourse = $file_url;
					$size[0] = $file_width;
					$size[1] = $file_height;
				} else
				{
					$img_sourse = $file_url_vector;
					$size[0] = $file_width_vector;
					$size[1] = $file_height_vector;
				}
			} else
			{
				$img_sourse = pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
					"/" . $rs->row["id"] . "/" . $afile;
				$size = getimagesize( $img_sourse );
			}
			$png_file = pvs_upload_dir() . $pvs_global_settings["watermark_photo"];

			if ( $_REQUEST["z"] < 16 )
			{
				$resize_method = strtolower( $pvs_global_settings["image_resize"] );

				if ( $resize_method == "imagemagick" and ! class_exists( 'Imagick' ) )
				{
					$resize_method = "gd";
				}

				if ( $resize_method == "gd" )
				{
					if ( $fextention == "jpg" or $fextention == "jpeg" )
					{
						$im_in = ImageCreateFromJPEG( $img_sourse );
					}
					if ( $fextention == "png" )
					{
						$im_in = ImageCreateFromPNG( $img_sourse );
					}
					if ( $fextention == "gif" )
					{
						$im_in = ImageCreateFromGIF( $img_sourse );
					}

					$im_out = imagecreatetruecolor( $_REQUEST["width"], $_REQUEST["height"] );
				}

				$w1 = round( $size[0] / $_REQUEST["z"] );
				$h1 = round( $size[1] / $_REQUEST["z"] );

				$k1 = $size[0] / $_REQUEST["width"];
				$k2 = $size[1] / $_REQUEST["height"];

				$xn = round( $k1 * ( $_REQUEST["x1"] + $_REQUEST["x0"] ) );
				$yn = round( $k2 * ( $_REQUEST["y1"] + $_REQUEST["y0"] ) );

				if ( $xn + $w1 > $size[0] )
				{
					$xn = $size[0] - $w1;
				}
				if ( $yn + $h1 > $size[1] )
				{
					$yn = $size[1] - $h1;
				}

				if ( $resize_method == "gd" )
				{
					if ( $fextention == "jpg" or $fextention == "jpeg" )
					{
						pvs_fastimagecopyresampled( $im_out, $im_in, 0, 0, $xn, $yn, $_REQUEST["width"], $_REQUEST["height"],
							$w1, $h1 );
					}

					if ( $fextention == "png" )
					{
						imagefill( $im_out, 0, 0, imagecolorallocate( $im_out, 255, 255, 255 ) );
						imagealphablending( $im_out, TRUE );
						imagecopy( $im_out, $im_in, 0, 0, 0, 0, $size[0], $size[1] );
						imagecopyresampled( $im_out, $im_in, 0, 0, $xn, $yn, $_REQUEST["width"], $_REQUEST["height"],
							$w1, $h1 );
					}

					if ( $fextention == "gif" )
					{
						$transparency = imagecolortransparent( $im_in );
						if ( $transparency >= 0 )
						{
							$transparent_color = imagecolorsforindex( $im_in, $transparency );
							$transparency = imagecolorallocate( $im_out, $transparent_color['red'], $transparent_color['green'],
								$transparent_color['blue'] );
							imagefill( $im_out, 0, 0, $transparency );
							imagecolortransparent( $im_out, $transparency );
						}
						imagecopyresampled( $im_out, $im_in, 0, 0, $xn, $yn, $_REQUEST["width"], $_REQUEST["height"],
							$w1, $h1 );
					}
				} else
				{
					$image = new Imagick( $img_sourse );
					$image->cropImage( $w1, $h1, $xn, $yn );
					$image->resizeImage( $_REQUEST["width"], $_REQUEST["height"], Imagick::FILTER_LANCZOS,
						0.8 );
				}
				if ( $resize_method == "gd" )
				{
					if ( file_exists( $png_file ) and preg_match( "/png$/i", $png_file ) )
					{
						$im1 = imagecreatefrompng( $png_file );
						$sz = array( $_REQUEST["width"], $_REQUEST["height"] );
						$wz = getimagesize( $png_file );

						$px = 0;
						$py = 0;
						if ( $wz[0] < $sz[0] and $wz[1] < $sz[1] )
						{
							if ( $pvs_global_settings["watermark_position"] == 1 )
							{
								$px = 0;
								$py = 0;
							} elseif ( $pvs_global_settings["watermark_position"] == 2 )
							{
								$px = ( $sz[0] - $wz[0] ) / 2;
								$py = 0;
							} elseif ( $pvs_global_settings["watermark_position"] == 3 )
							{
								$px = $sz[0] - $wz[0];
								$py = 0;
							} elseif ( $pvs_global_settings["watermark_position"] == 4 )
							{
								$px = 0;
								$py = ( $sz[1] - $wz[1] ) / 2;
							} elseif ( $pvs_global_settings["watermark_position"] == 5 )
							{
								$px = ( $sz[0] - $wz[0] ) / 2;
								$py = ( $sz[1] - $wz[1] ) / 2;
							} elseif ( $pvs_global_settings["watermark_position"] == 6 )
							{
								$px = $sz[0] - $wz[0];
								$py = ( $sz[1] - $wz[1] ) / 2;
							} elseif ( $pvs_global_settings["watermark_position"] == 7 )
							{
								$px = 0;
								$py = $sz[1] - $wz[1];
							} elseif ( $pvs_global_settings["watermark_position"] == 8 )
							{
								$px = ( $sz[0] - $wz[0] ) / 2;
								$py = $sz[1] - $wz[1];
							} else
							{
								$px = $sz[0] - $wz[0];
								$py = $sz[1] - $wz[1];
							}
						}
						imagecopy( $im_out, $im1, $px, $py, 0, 0, $wz[0], $wz[1] );
					}

					ImageJPEG( $im_out );
				} else
				{
					if ( file_exists( $png_file ) and preg_match( "/png$/i", $png_file ) )
					{
						$watermark_image = new Imagick();
						$watermark_image->readImage( $png_file );

						$iWidth = $image->getImageWidth();
						$iHeight = $image->getImageHeight();
						$wWidth = $watermark_image->getImageWidth();
						$wHeight = $watermark_image->getImageHeight();

						/*
						if ($iHeight < $wHeight || $iWidth < $wWidth) 
						{
						$watermark_image->scaleImage($iWidth, $iHeight);
						$wWidth = $watermark_image->getImageWidth();
						$wHeight = $watermark_image->getImageHeight();
						}
						*/

						$sz = array( $iWidth, $iHeight );
						$wz = array( $wWidth, $wHeight );

						$px = 0;
						$py = 0;
						if ( $wz[0] < $sz[0] and $wz[1] < $sz[1] )
						{
							if ( $pvs_global_settings["watermark_position"] == 1 )
							{
								$px = 0;
								$py = 0;
							} elseif ( $pvs_global_settings["watermark_position"] == 2 )
							{
								$px = ( $sz[0] - $wz[0] ) / 2;
								$py = 0;
							} elseif ( $pvs_global_settings["watermark_position"] == 3 )
							{
								$px = $sz[0] - $wz[0];
								$py = 0;
							} elseif ( $pvs_global_settings["watermark_position"] == 4 )
							{
								$px = 0;
								$py = ( $sz[1] - $wz[1] ) / 2;
							} elseif ( $pvs_global_settings["watermark_position"] == 5 )
							{
								$px = ( $sz[0] - $wz[0] ) / 2;
								$py = ( $sz[1] - $wz[1] ) / 2;
							} elseif ( $pvs_global_settings["watermark_position"] == 6 )
							{
								$px = $sz[0] - $wz[0];
								$py = ( $sz[1] - $wz[1] ) / 2;
							} elseif ( $pvs_global_settings["watermark_position"] == 7 )
							{
								$px = 0;
								$py = $sz[1] - $wz[1];
							} elseif ( $pvs_global_settings["watermark_position"] == 8 )
							{
								$px = ( $sz[0] - $wz[0] ) / 2;
								$py = $sz[1] - $wz[1];
							} else
							{
								$px = $sz[0] - $wz[0];
								$py = $sz[1] - $wz[1];
							}
						}

						$image->compositeImage( $watermark_image, imagick::COMPOSITE_OVER, $px, $py );
					}
					echo ( $image );
				}
			} else
			{
				if ( $flag_storage )
				{
					readfile( $file_url_thumb );
				} else
				{
					readfile( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
						"/" . $rs->row["id"] . "/thumb2.jpg" );
				}
			}
		}
	}
}

?>