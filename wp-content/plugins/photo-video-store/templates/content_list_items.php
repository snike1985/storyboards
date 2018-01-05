<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$flag_empty = false;
$search_content = "";

$sql .= " " . $com . $lm;
//echo($sql."<br><br>");
$rs->open( $sql );
if ( ! $rs->eof ) {
	//Items for this category
	if ( $flow == 1 ) {
		if ( @$prints_flag )
		{
			$template_file = PVS_PATH . "includes/prints/" . $prints_preview . "_small.php";
			$show_print_title = true;
		} else
		{
			$template_file = get_stylesheet_directory() . "/item_list_flow.php";
		}
	} elseif ( $flow == 2 ) {
		$template_file = get_stylesheet_directory() . "/item_list_flow2.php";
	} else {
		$template_file = get_stylesheet_directory() . "/item_list.php";
	}

	while ( ! $rs->eof ) {
			$sql = "select id,media_id,title,data,published,description,viewed,keywords,rating as arating,downloaded,free,author,server1,url,rights_managed,featured from " .
				PVS_DB_PREFIX . "media where id=" . $rs->row["id"];

		$dd->open( $sql );
		if ( ! $dd->eof )
		{
			$translate_results = pvs_translate_publication( $rs->row["id"], $dd->row["title"],
				$dd->row["description"], $dd->row["keywords"] );

			//Define author
			$user_name = pvs_show_user_name( $dd->row["author"] );

			//Define url

			$item_url = pvs_item_url( $rs->row["id"], $dd->row["url"] );
			$pvs_theme_content[ 'item_url' ] = $item_url;
			$pvs_theme_content[ 'item_id' ] = $rs->row["id"];

			//Define preview
			$item_img = "";
			$item_lightbox = "";

			//Show photo
			if ( $rs->row["media_id"] == 1 )
			{
				$item_type = "photo";
				$pvs_theme_content[ 'class' ] = "1";
				$pvs_theme_content[ 'class2' ] = "fa-photo";
			}

			//Show video
			if ( $rs->row["media_id"] == 2 )
			{
				$item_type = "video";
				$pvs_theme_content[ 'class' ] = "2";
				$pvs_theme_content[ 'class2' ] = "fa-video-camera";
			}

			//Show audio
			if ( $rs->row["media_id"] == 3 )
			{
				$item_type = "audio";
				$pvs_theme_content[ 'class' ] = "3";
				$pvs_theme_content[ 'class2' ] = "fa-music";
			}

			//Show vector
			if ( $rs->row["media_id"] == 4 )
			{
				$item_type = "vector";
				$pvs_theme_content[ 'class' ] = "4";
				$pvs_theme_content[ 'class2' ] = "fa-cubes";
			}

			$pvs_theme_content[ 'item_img' ] = pvs_show_preview( $rs->row["id"], $item_type, 1, 1, $dd->row["server1"], $rs->row["id"] );

			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], $item_type, $dd-> row["server1"], $translate_results["title"], $user_name );
			$pvs_theme_content[ 'item_img2' ] = $hoverbox_results["flow_image"];
			$pvs_theme_content[ 'item_lightbox' ] = $hoverbox_results["hover"];

			if ( $flow == 1 or $flow == 2 )
			{
				$pvs_theme_content[ 'width' ] = $hoverbox_results["flow_width"];
				$pvs_theme_content[ 'height' ] = $hoverbox_results["flow_height"];
			}

			if ( $flow == 0 )
			{
				$pvs_theme_content[ 'width' ] = $hoverbox_results["width"];
				$pvs_theme_content[ 'height' ] = $hoverbox_results["height"];
			}

			$pvs_theme_content[ 'width_prints' ] = $hoverbox_results["flow_width"];
			$pvs_theme_content[ 'height_prints' ] = $hoverbox_results["flow_height"];

			$pvs_theme_content[ 'add_to_cart' ] = pvs_word_lang( "add to cart" );
			$pvs_theme_content[ 'cart_function' ] = "add";
			$pvs_theme_content[ 'cart_class' ] = "";
			
			if ( $dd->row["free"] != 1 and $dd->row["rights_managed"] == 0) {
				$pvs_theme_content[ 'cart' ] = true;
			} else {
				$pvs_theme_content[ 'cart' ] = false;
			}
			
			if ( $dd->row["rights_managed"] != 0 ) {
				$pvs_theme_content[ 'rights_managed' ] = true;
			} else {
				$pvs_theme_content[ 'rights_managed' ] = false;
			}
			
			$pvs_theme_content[ 'free_url' ] = '';
			if ( $dd->row["free"] == 1 ) {
				$pvs_theme_content[ 'free' ] = true;
				$sql = "select id from " . PVS_DB_PREFIX . "items where id_parent=" . $rs->row["id"] . " and shipped<>1 order by priority desc";
				$dn->open( $sql );
				if ( ! $dn->eof ) {
					$pvs_theme_content[ 'free_url' ] = site_url() . "/count/?id=" . $dn->row["id"] . "&id_parent=" . $rs->row["id"] . "&type=" . $item_type . "&server=" . $dd->row["server1"];
				}
			} else {
				$pvs_theme_content[ 'free' ] = false;
			}

			$pvs_theme_content[ 'featured' ] = $dd->row["featured"];

			if ( $dd->row["data"] + 3600 * 24 * 7 > pvs_get_time( date( "H" ), date( "i" ),
				date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) )
			{
				$flag_new = true;
			} else
			{
				$flag_new = false;
			}

			$pvs_theme_content[ 'new' ] = $flag_new;
			$pvs_theme_content[ 'print' ] = true;

			//Properties

			$pvs_theme_content[ 'item_published' ] = date( date_format, $dd->row["data"] );
			$pvs_theme_content[ 'item_viewed' ] = $dd->row["viewed"];
			$pvs_theme_content[ 'item_downloaded' ] = $dd->row["downloaded"];
			$pvs_theme_content[ 'item_id' ] = $rs->row["id"];
			$pvs_theme_content[ 'item_title' ] = $translate_results["title"];
			$pvs_theme_content[ 'item_description' ] = str_replace( "\r", "<br>", $translate_results["description"] );
			$pvs_theme_content[ 'item_keywords' ] = $translate_results["keywords"];


			//Prints
			if ( @$prints_flag and isset( $_REQUEST["print_id"] ) )
			{
				$sql = "select price from " . PVS_DB_PREFIX . "prints_items where itemid=" . $rs->
					row["id"] . " and printsid=" . ( int )$_REQUEST["print_id"];
				$dn->open( $sql );
				if ( ! $dn->eof )
				{
					$pvs_theme_content[ 'price' ] = pvs_currency( 1 ) . pvs_price_format( $dn->
						row["price"], 2, true ) . " " . pvs_currency( 2 );
				} else
				{
					$pvs_theme_content[ 'price' ] = "";
				}

				$pvs_theme_content[ 'print_url' ] = pvs_print_url( $rs->row["id"], ( int ) $_REQUEST["print_id"], $dd->row["title"], $prints_preview, "site" );
			}
			
			include($template_file);
			if ( @$prints_flag )
			{
				echo($pvs_theme_content[ 'print_content' ]);
			}
		}

		$n++;
		$rs->movenext();
	}
} else {
	//echo("<p><b>" . pvs_word_lang( "not found" ) . "</b></p>");
	$flag_empty = true;
}
?>