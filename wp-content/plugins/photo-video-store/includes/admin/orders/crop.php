<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "orders_orders" );

if ( $_REQUEST["photo"] != "" ) {
	$img_sourse = pvs_result( $_REQUEST["photo"] );
	$file_name = pvs_get_file_info( $img_sourse, "filename" );
	$file_extention = strtolower( pvs_get_file_info( $img_sourse, "extention" ) );

	$print_width = ( int )$_REQUEST["x2"] - ( int )$_REQUEST["x1"];
	$print_height = ( int )$_REQUEST["y2"] - ( int )$_REQUEST["y1"];

	if ( $file_extention == "jpg" or $file_extention == "jpeg" ) {

		header( "Content-Type:image/jpeg" );


		$im_in = ImageCreateFromJPEG( $img_sourse );
		$im_out = imagecreatetruecolor( $print_width, $print_height );
		imagecopy( $im_out, $im_in, 0, 0, ( int )$_REQUEST["x1"], ( int )$_REQUEST["y1"], ( int )
			$_REQUEST["width"], ( int )$_REQUEST["height"] );

		ImageJPEG( $im_out );
		ImageDestroy( $im_in );
		ImageDestroy( $im_out );
	}
	if ( $file_extention == "png" ) {

		header( "Content-Type:image/png" );


		$im_in = ImageCreateFromPNG( $img_sourse );
		$im_out = imagecreatetruecolor( $print_width, $print_height );

		imagealphablending( $im_out, false );
		imagesavealpha( $im_out, true );
		$transparent = imagecolorallocatealpha( $im_out, 255, 255, 255, 127 );

		imagecopy( $im_out, $im_in, 0, 0, ( int )$_REQUEST["x1"], ( int )$_REQUEST["y1"], ( int )
			$_REQUEST["width"], ( int )$_REQUEST["height"] );

		ImagePNG( $im_out );
		ImageDestroy( $im_in );
		ImageDestroy( $im_out );
	}
	if ( $file_extention == "gif" ) {

		header( "Content-Type:image/gif" );


		$im_in = ImageCreateFromGIF( $img_sourse );
		$im_out = imagecreatetruecolor( $print_width, $print_height );
		imagecopy( $im_out, $im_in, 0, 0, ( int )$_REQUEST["x1"], ( int )$_REQUEST["y1"], ( int )
			$_REQUEST["width"], ( int )$_REQUEST["height"] );

		ImageGIF( $im_out );
		ImageDestroy( $im_in );
		ImageDestroy( $im_out );
	}
}


?>