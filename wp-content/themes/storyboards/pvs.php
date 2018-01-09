<?php
if ( defined( 'PVS_PATH' ) ) {	
	if ( ! pvs_check_auth () ) {
		header( 'location: ' . site_url() . '/login/' );
		exit();
	}

	if ( pvs_is_show_header_footer () ) {
		include(PVS_PATH . 'includes/functions/header.php');	
		get_header(); 
		echo('<div class="dashboard-wrapper">');
	}
	
	require_once( PVS_PATH . 'templates/index.php' );
	
	if ( pvs_is_show_header_footer () ) {
		echo('</div>');
		get_footer();
	}
}
