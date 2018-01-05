<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
$prints_flag = false;
$prints_title_flag = true;
$prints_preview = "";
$prints_title = "";

if ( ( int ) get_query_var('pvs_print_id') > 0 ) {
	if ( $pvs_global_settings["prints_previews"] ) {
		$print_info = pvs_get_print_preview_info( ( int ) get_query_var('pvs_print_id') );
		$prints_flag = $print_info["flag"];
		$prints_preview = $print_info["preview"];
		$prints_title = $print_info["title"];
	}
} else
{
	if ( $pvs_global_settings["printsonly"] and $pvs_global_settings["prints_previews"] ) {
		$prints_mass = array();

		$sql_prints = "select id from " . PVS_DB_PREFIX .
			"prints_categories where active=1 order by priority";
		$dr->open( $sql_prints );
		while ( ! $dr->eof ) {
			$prints_mass[] = $dr->row["id"];
			$dr->movenext();
		}
		$prints_mass[] = 0;

		foreach ( $prints_mass as $key => $value ) {
			$sql_prints = "select id_parent,title from " . PVS_DB_PREFIX .
				"prints where category=" . $value . " order by priority";
			$dd->open( $sql_prints );
			if ( ! $dd->eof )
			{
				$print_info = pvs_get_print_preview_info( ( int ) get_query_var('pvs_print_id') );
				$prints_flag = $print_info["flag"];
				$prints_preview = $print_info["preview"];
				$prints_title = $print_info["title"];
				$prints_title_flag = false;
				break;
			}
		}
	}
}

if ( pvs_is_home_page () and get_query_var('pvs_page') != 'category' and get_query_var('pvs_page') != 'lightbox' and get_query_var('pvs_page') != 'collection') {
	//Home page
	require_once( get_stylesheet_directory(). '/homepage.php' );
} else
{
	//Catalog pages
	if ( ! isset( $_GET["stock_api"] ) ) {
		if ( ! pvs_check_password( 0, get_query_var('pvs_id'), 0 ) ) {
			//Protected item
			$check_passsword_url = 'category-password';
			require_once( get_stylesheet_directory(). '/item_protected.php' );
		} else {
			include ( "content_js_listing.php" );

			//Show item list
			include ( "content_list.php" );
		}
	} else {
		include ( "content_js_stock.php" );

		if ( isset( $_GET["shutterstock"] ) ) {
			include ( "content_shutterstock.php" );
		}
		if ( isset( $_GET["fotolia"] ) ) {
			include ( "content_fotolia.php" );
		}
		if ( isset( $_GET["istockphoto"] ) ) {
			include ( "content_istockphoto.php" );
		}
		if ( isset( $_GET["depositphotos"] ) ) {
			include ( "content_depositphotos.php" );
		}
		if ( isset( $_GET["rf123"] ) ) {
			include ( "content_123rf.php" );
		}
		if ( isset( $_GET["bigstockphoto"] ) ) {
			include ( "content_bigstockphoto.php" );
		}
		if ( isset( $_GET["pixabay"] ) ) {
			include ( "content_pixabay.php" );
		}
	}
}
?>