<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$pvs_rewrite_pages = pvs_rewrite('include');

foreach ( $pvs_rewrite_pages as $key => $value ) {
	if (get_query_var('pvs_page') == $key) {
		require_once( PVS_PATH . $value );
	}
}

if (get_query_var('pvs_page') == 'preview') {
	require_once( PVS_PATH . 'templates/preview.php' );
}

if (get_query_var('pvs_page') == 'photo') {
	require_once( PVS_PATH . 'templates/content_photo.php' );
}

if (get_query_var('pvs_page') == 'video') {
	require_once( PVS_PATH . 'templates/content_video.php' );
}

if (get_query_var('pvs_page') == 'audio') {
	require_once( PVS_PATH . 'templates/content_audio.php' );
}

if (get_query_var('pvs_page') == 'vector') {
	require_once( PVS_PATH . 'templates/content_vector.php' );
}

if (get_query_var('pvs_page') == 'print') {
	require_once( PVS_PATH . 'templates/content_print.php' );
}

if (get_query_var('pvs_page') == 'stockapi') {
	if ( (int) get_query_var('shutterstock') > 0) {
		require_once( PVS_PATH . 'templates/content_shutterstock.php' );
	}
	
	if ( (int) get_query_var('fotolia') > 0) {
		require_once( PVS_PATH . 'templates/content_fotolia.php' );
	}
	
	if ( (int) get_query_var('istockphoto') > 0) {
		require_once( PVS_PATH . 'templates/content_istockphoto.php' );
	}
	
	if ( (int) get_query_var('depositphotos') > 0) {
		require_once( PVS_PATH . 'templates/content_depositphotos.php' );
	}
	
	if ( (int) get_query_var('bigstockphoto') > 0) {
		require_once( PVS_PATH . 'templates/content_bigstockphoto.php' );
	}
	
	if ( (int) get_query_var('rf123') > 0) {
		require_once( PVS_PATH . 'templates/content_123rf.php' );
	}
	
	if ( (int) get_query_var('pixabay') > 0) {
		require_once( PVS_PATH . 'templates/content_pixabay.php' );
	}
}

if (get_query_var('pvs_page') == 'category' or get_query_var('pvs_page') == 'lightbox' or get_query_var('pvs_page') == 'collection') {
	require_once( PVS_PATH . 'templates/content.php' );
}

if (get_query_var('pvs_page') == 'user') {
	require_once( PVS_PATH . 'templates/user.php' );
}
?>