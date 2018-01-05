<?php
if ( ! defined( 'PVS_PATH' ) ) {
	echo("<b>Error. You should install/activate Photo Video Store plugin first! The theme doesn't work without the plugin.</b>");
}

get_header();

if ( defined( 'PVS_PATH' ) ) {
	if ( ! pvs_is_home_page () ) {
		?>
		<div class="container">
		<?php
	}

	require_once( PVS_PATH . 'templates/content.php' );

	if ( ! pvs_is_home_page () ) {
		?>
		</div>
		<?php
	}
}
get_footer();
?>