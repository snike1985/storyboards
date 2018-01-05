<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


$preview_file = pvs_upload_dir() . '/content' . get_query_var('pvs_folder') . '/' . get_query_var('pvs_id') . '/thumb' . get_query_var('pvs_file') . '.' . get_query_var('pvs_ext');


include ( "download_mimes.php" );

if ( file_exists($preview_file) and  isset( $mmtype[strtolower( get_query_var('pvs_ext') )] ) ) {
	header( "Content-Type:" . $mmtype[strtolower( get_query_var('pvs_ext') )] );
	header( "Content-Disposition: inline; filename=" . urlencode( get_query_var('pvs_filename') . '-' . get_query_var('pvs_id') . '.' . get_query_var('pvs_ext') ) );
	pvs_readfile_chunked( $preview_file );
}
?>