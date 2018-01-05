<?php
/***************************************************************************
*                                                                         																*
*   Copyright (c) 2006-2017 CMSaccount Inc. All rights reserved.     	   									*
*                                                                         																*
*   Photo Video Store script is a commercial software. Any distribution is strictly prohibited.     * 						   
*																																		*					  
*   Website: https://www.cmsaccount.com/																			*				  
*   E-mail: sales@cmsaccount.com  																					*					   
*   Support: https://www.cmsaccount.com/forum/	                          									*
*                                                                       															    *
****************************************************************************/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//The function shows a publication's category
function pvs_show_category( $id ) {
	global $db;
	global $ds;
	global $dr;
	$category_list = "";

	$sql = "select category_id from " . PVS_DB_PREFIX .
		"category_items where publication_id=" . ( int )$id;
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$sql = "select title,url from " . PVS_DB_PREFIX . "category where id=" .
			$ds->row["category_id"];
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$translate_results = pvs_translate_category( $ds->row["category_id"], $dr->row["title"],
				"", "" );

			if ( $category_list != "" )
			{
				$category_list .= ", ";
			}

			$category_list .= "<a href='" . site_url() . $dr->row["url"] . "'>" . $translate_results["title"] .
				"</a>";
		}
		$ds->movenext();
	}
	return $category_list;
}
//End. The function shows a publication's category

//The function shows a publication's rating
function pvs_show_rating( $id, $rating )
{
	global $db;
	global $ds;
	global $site_template_url;
	global $pvs_global_settings;
	global $_SESSION;
	global $pvs_theme_content;

	$item_rating = ( float )$rating;

	if ( ! is_user_logged_in() and $pvs_global_settings["auth_rating"] )
	{
		$rating_link = "<a href='" . site_url() . "/login/'>";
	} else
	{
		$sql = "select ip,id from " . PVS_DB_PREFIX . "voteitems where ip='" .
			pvs_result( $_SERVER["REMOTE_ADDR"] ) . "' and id=" . ( int )$id;
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$rating_link = "<a href='#'>";
		} else
		{
			$rating_link = "<a href=\"javascript:doVote('{vote}');\">";
		}
	}

	$rating_text = "<div id='votebox' name='votebox'>";

	for ( $j = 1; $j < 6; $j++ )
	{
		$tt = "2";

		if ( $j <= $item_rating or $j - $item_rating <= 0.25 )
		{
			$tt = "1";
		}

		if ( $j > $item_rating and $j - $item_rating > 0.25 and $j - $item_rating < 0.75 )
		{
			$tt = "3";
		}

		$rating_text .= "" . str_replace( "{vote}", strval( $j ), $rating_link ) .
			"<img src='{TEMPLATE_ROOT}images/rating" . $tt . ".gif' width='11' id='rating" .
			$j . "' onMouseover='mrating(" . $j . ");' onMouseout='mrating2(" . $item_rating .
			");'  height='11' class='rating' border='0'></a>";
	}

	$rating_text .= "</div>";

	$rating_text2 = "<script>
    			$(function() {
      				$('#star" . $id . "').raty({
      				score: " . $rating . ",
 					half: true,
  					number: 5,
  					click: function(score, evt) {
    					vote_rating(" . $id . ",score);
  					}
				});
    			});
				</script>
				<div id='star" . $id . "' style='display:inline'></div>";

	$pvs_theme_content[ 'item_rating' ] = $rating_text;
	$pvs_theme_content[ 'item_rating_new' ] = $rating_text2;

	return $rating_text;
}
//End. The function shows a publication's rating

//The function shows a publication's related items
function pvs_show_related_items( $id, $type )
{
	global $db;
	global $ds;
	global $keywords;
	global $titles;
	global $pvs_theme_content;
	global $pvs_global_settings;

	$pvs_theme_content[ 'flag_related' ] = false;
	$sqlkey = "";
	
	//Relate by the first keyword
	for ( $k = 0; $k < count($keywords); $k++ )
	{
		if ($k < 1) {
			if ( $sqlkey != "" )
			{
				$sqlkey .= " or ";
			}
	
			$sqlkey .= " keywords like '%" . $keywords[$k] . "%' ";
		}
	}


	if ( $sqlkey != "" )
	{
		$tt = 0;

		$count_random = 0;
		$limit_random = " limit 0," . $pvs_global_settings["related_items_quantity"];



		$protected_categories = pvs_get_password_protected();

		if ( $protected_categories != "" )
		{
			$sql = "select  id, media_id, title, server1, url, author, description from " .
				PVS_DB_PREFIX . "media where published=1 and id <> " . ( int )$id . " and (" . $sqlkey .
				")  and id not in (select publication_id from " .
			PVS_DB_PREFIX . "category_items where " . $protected_categories . ") " . $limit_random;
		} else
		{
			$sql = "select  id, media_id, title, server1, url, author, description from " .
				PVS_DB_PREFIX . "media where published=1 and id <> " . ( int )$id . " and (" . $sqlkey .
				") " . $limit_random;
		}

		$ds->open( $sql );

		if ( ! $ds->eof )
		{
			$item_content = "";

			while ( ! $ds->eof )
			{
				if ( $tt < $pvs_global_settings["related_items_quantity"] )
				{
					$item_text = $item_content;

					$preview_type = 1;
					if ( $ds->row["media_id"] == 2 or $ds->row["media_id"] == 3 )
					{
						$preview_type = 3;
					}

					$hoverbox_results = pvs_get_hoverbox( $ds->row["id"], pvs_media_type ($ds->row["media_id"]), $ds->row["server1"],
						$ds->row["title"], pvs_show_user_name( $ds->row["author"] ) );

					$preview = pvs_show_preview( $ds->row["id"], pvs_media_type ($ds->row["media_id"]), $preview_type, 1 );

					$related_id = $ds->row["id"];
					$related_title = $ds->row["title"];
					$related_description = $ds->row["description"];
					$related_url = pvs_item_url( $ds->row["id"], $ds->row["url"] );
					$related_preview = $hoverbox_results["flow_image"];
					$related_lightbox = $hoverbox_results["hover"];
					$related_width = $hoverbox_results["flow_width"];
					$related_height = $hoverbox_results["flow_height"];
					
					if ($type == 'show') {
						include(get_template_directory() . "/item_related.php");
					}
					
					if ( $pvs_global_settings["related_items"])
					{
						$pvs_theme_content[ 'flag_related' ] = true;
					}
				}
				$tt++;

				$ds->movenext();
			}
		}
	}
}
//End. The function shows a publication's related items

//The function shows related prints
function pvs_show_related_prints( $id, $print_id, $title, $type )
{
	global $pvs_theme_content;
	global $pvs_global_settings;
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$dt = new TMySQLQuery;
	$dt->connection = $db;
	$dx = new TMySQLQuery;
	$dx->connection = $db;

	$related_prints = '';
	$flag_related = false;
	$item_content = '';

	$prints_mass = array();

	$sql = "select id from " . PVS_DB_PREFIX .
		"prints_categories where active=1 order by priority";
	$dp->open( $sql );
	while ( ! $dp->eof )
	{
		$prints_mass[] = $dp->row["id"];
		$dp->movenext();
	}
	$prints_mass[] = 0;

	foreach ( $prints_mass as $key => $value )
	{
		$sql = "select id_parent,preview,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
			PVS_DB_PREFIX . "prints where category=" . $value . " and id_parent<>" . $print_id .
			" order by priority";
		$dp->open( $sql );
		while ( ! $dp->eof )
		{

			$sql = "select preview from " . PVS_DB_PREFIX . "prints_previews where id=" . $dp->
				row["preview"];
			$dx->open( $sql );
			if ( ! $dx->eof )
			{

				$sql_in_stock = "";
				if ( ! $pvs_global_settings["show_not_in_stock"] )
				{
					$sql_in_stock = " and (in_stock = -1 or in_stock > 0) ";
				}

				$sql = "select id_parent,title,	price from " . PVS_DB_PREFIX .
					"prints_items where itemid=" . ( int )$id . " and printsid=" . $dp->row["id_parent"] .
					$sql_in_stock;
				$dt->open( $sql );
				if ( ! $dt->eof )
				{
					$price = pvs_define_prints_price( $dt->row["price"], $dp->row["option1"], $dp->
						row["option1_value"], $dp->row["option2"], $dp->row["option2_value"], $dp->row["option3"],
						$dp->row["option3_value"], $dp->row["option4"], $dp->row["option4_value"], $dp->
						row["option5"], $dp->row["option5_value"], $dp->row["option6"], $dp->row["option6_value"],
						$dp->row["option7"], $dp->row["option7_value"], $dp->row["option8"], $dp->row["option8_value"],
						$dp->row["option9"], $dp->row["option9_value"], $dp->row["option10"], $dp->row["option10_value"] );
					$pvs_theme_content[ 'item_title' ] = pvs_word_lang( $dt->row["title"] );
					$pvs_theme_content[ 'price' ] = pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) . ' ' . pvs_currency( 2 );
					$related_print = pvs_show_print_preview( $id, $dp->row["id_parent"], true );
					$related_title = pvs_word_lang( $dt->row["title"] );
					$related_price = strval( pvs_currency( 1 ) ) . strval( pvs_price_format ( $price, 2, true ) ) . ' ' . strval( pvs_currency( 2 ) );
					$related_print_url = pvs_print_url( $id, $dp->row["id_parent"], $title, $dx->row["preview"], '' );
					
					if ($type == 'show') {
						include(get_template_directory() . "/item_related_prints.php");
					}
					
					$flag_related = true;
				}
			}
			$dp->movenext();
		}
	}

	$pvs_theme_content[ 'flag_related_prints' ] = $flag_related;
}
//End. The function shows related prints

//The function shows related prints for stocks
function pvs_show_related_prints_stock( $print_id, $title, $stock, $stock_id, $stock_preview )
{
	global $pvs_theme_content;
	global $pvs_global_settings;
	global $site_template_url;
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$dx = new TMySQLQuery;
	$dx->connection = $db;

	$related_prints = '';
	$flag_related = false;
	$item_content = '';

	$prints_mass = array();

	$sql = "select id from " . PVS_DB_PREFIX .
		"prints_categories where active=1 order by priority";
	$dp->open( $sql );
	while ( ! $dp->eof )
	{
		$prints_mass[] = $dp->row["id"];
		$dp->movenext();
	}
	$prints_mass[] = 0;

	foreach ( $prints_mass as $key => $value )
	{
		$sql = "select id_parent,price,title,preview,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value from " .
			PVS_DB_PREFIX . "prints where category=" . $value . " and id_parent<>" . $print_id .
			" order by priority";
		$dp->open( $sql );
		while ( ! $dp->eof )
		{

			$sql = "select preview from " . PVS_DB_PREFIX . "prints_previews where id=" . $dp->
				row["preview"];
			$dx->open( $sql );
			if ( ! $dx->eof )
			{
				$price = pvs_define_prints_price( $dp->row["price"], $dp->row["option1"], $dp->
					row["option1_value"], $dp->row["option2"], $dp->row["option2_value"], $dp->row["option3"],
					$dp->row["option3_value"], $dp->row["option4"], $dp->row["option4_value"], $dp->
					row["option5"], $dp->row["option5_value"], $dp->row["option6"], $dp->row["option6_value"],
					$dp->row["option7"], $dp->row["option7_value"], $dp->row["option8"], $dp->row["option8_value"],
					$dp->row["option9"], $dp->row["option9_value"], $dp->row["option10"], $dp->row["option10_value"] );
				$pvs_theme_content[ 'item_title' ] = pvs_word_lang( $dp->row["title"] );
				$pvs_theme_content[ 'price' ] = pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) . ' ' . pvs_currency( 2 );
				$related_print = pvs_show_print_preview_stock( $dp->row["id_parent"], $title, $stock, $stock_id, $stock_preview, true );
				$related_title = pvs_word_lang( $dp->row["title"] );
				$related_price = pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) . ' ' . pvs_currency( 2 );
				$related_print_url = pvs_print_url( $stock_id, $dp->row["id_parent"], $title, $dx->row["preview"], $stock );

				include(get_template_directory() . "/item_related_prints.php");
				$flag_related = true;
			}
			$dp->movenext();
		}
	}
}
//End. The function shows related prints for stocks

//The function shows a publication's add to favorite button
function pvs_show_favorite( $id )
{
	global $db;
	global $dr;
	global $pvs_theme_content;

	$pvs_theme_content[ 'add_to_favorite_link' ] = "javascript:show_lightbox(" . ( int )$id . ",'" . site_url() . "')";
}
//End. The function shows a publication's add to favority button

//The function shows a publication's author
function pvs_show_author( $author )
{
	global $db;
	global $dr;
	global $pvs_theme_content;

	$boxauthor = pvs_show_user_avatar( $author, "login" );
	$pvs_theme_content[ 'portfolio_link' ] = site_url() . "/index.php?user=" .
		pvs_user_login_to_id( $author ) . "&portfolio=1";

	$pvs_theme_content[ 'author' ] = $boxauthor;
}
//End. The function shows a publication's author

//The function shows a publication's keywords
function pvs_show_keywords( $id, $type )
{
	global $db;
	global $rs;
	global $dr;
	global $pvs_theme_content;
	global $keywords;
	global $pvs_global_settings;
	global $site_template_url;
	global $translate_results;

	$kw = "";
	$kw_lite = "";
	if ( $translate_results["keywords"] != "" )
	{
		$keywords = explode( ",", str_replace( ";", ",", $translate_results["keywords"] ) );
		for ( $i = 0; $i < count( $keywords ); $i++ )
		{
			$keywords[$i] = trim( $keywords[$i] );
			if ( $keywords[$i] != "" )
			{
				$kw .= "<div style='margin-bottom:3px'><input type='checkbox' name='s_" .
					str_replace( " ", "_", $keywords[$i] ) . "'>&nbsp;<a href='" . site_url() .
					"/?search=" . $keywords[$i] . "'>" . $keywords[$i] . "</a></div>";
				//$kw_lite .= "<a href='" . site_url() . "/?search=" . $keywords[$i] . "' class='kw'>" . $keywords[$i] . "</a> ";
				$kw_lite .= "<a href='" . site_url() . "/keyword/" . urlencode($keywords[$i]) . "/' class='kw'>" . $keywords[$i] . "</a> ";
			}
		}
	}

	if ( $kw != "" )
	{
		$pvs_theme_content[ 'keywords' ] =  "<form method='get' action='" .
			site_url() . "/' style='margin:0px'>" . $kw . "<input type='submit' value='" .
			pvs_word_lang( "search" ) . "'></form>";
		$pvs_theme_content[ 'keywords_lite' ] = $kw_lite;
	} else
	{
		$pvs_theme_content[ 'keywords' ] =  '';
		$pvs_theme_content[ 'keywords_lite' ] =  '';
	}

}
//End. The function shows a publication's keywords

//The function shows a publication's community tools
function pvs_show_community()
{
	global $pvs_theme_content;
	global $pvs_global_settings;
	global $db;
	global $rs;
	global $dn;

	$models_list = "";
	$flag1 = pvs_word_lang( "no" );
	$flag2 = pvs_word_lang( "no" );

	$sql = "select models from " . PVS_DB_PREFIX .
		"models_files where publication_id=" . $rs->row["id"];
	$dn->open( $sql );
	while ( ! $dn->eof )
	{
		if ( $dn->row["models"] == 0 )
		{
			$flag1 = pvs_word_lang( "yes" );
		} else
		{
			$flag2 = pvs_word_lang( "yes" );
		}
		$dn->movenext();
	}

	$models_list .= "<span><b>" . pvs_word_lang( "Model release" ) . ":</b> " . $flag1 .
		"</span>";
	$models_list .= "<span><b>" . pvs_word_lang( "Property release" ) . ":</b> " . $flag2 .
		"</span>";

	$pvs_theme_content[ 'model' ] =  $models_list;

	$flag_model = false;
	if ( $pvs_global_settings["model"] and $pvs_global_settings["show_model"] )
	{
		$flag_model = true;
	}
	$pvs_theme_content[ 'flag_model' ] =  $flag_model;

	if ( isset( $_SERVER["HTTP_REFERER"] ) and $_SERVER["HTTP_REFERER"] != "" )
	{
		$pvs_theme_content[ 'link_back' ] =  $_SERVER["HTTP_REFERER"];
	}

	$flag_back = false;
	if ( isset( $_SERVER["HTTP_REFERER"] ) and $_SERVER["HTTP_REFERER"] != "" )
	{
		$flag_back = true;
	}
	$pvs_theme_content[ 'flag_back' ] =  $flag_back;

}
//End. The function shows a publication's community tools

//The function shows Google map
function pvs_show_google_map( $x, $y )
{
	global $pvs_theme_content;
	global $pvs_global_settings;

	$pvs_theme_content[ 'google_x' ] =  $x;
	$pvs_theme_content[ 'google_y' ] =  $y;

	$flag_google = false;
	if ( $pvs_global_settings["google_coordinates"] and ( float )$x != 0 and ( float )
		$y != 0 )
	{
		$flag_google = true;
	}
	$pvs_theme_content[ 'flag_google' ] =  $flag_google;
}
//End. The function shows Google map

//The function shows EXIF info
function pvs_show_exif( $id )
{
	global $pvs_theme_content;  
	global $pvs_global_settings;
	global $flag_storage;

	$flag_exif = false;
	if ( $pvs_global_settings["exif"] and ! $flag_storage )
	{
		$flag_exif = true;
	}
	$pvs_theme_content[ 'flag_exif' ] =  $flag_exif;
}
//End. The function shows EXIF info

//The function shows next/previous navigation
function pvs_show_navigation( $id, $type, $print_id = 0, $print_type = '' )
{
	global $db;
	global $dr;
	global $pvs_theme_content;
	$navigation = "";
	$previous_link = "";
	$next_link = "";

	$com_print = '';

	if ( $print_id != 0 )
	{
		$com_print .= ' and (id in (select itemid from " . PVS_DB_PREFIX . "prints_items where printsid=' . ( int )
			$print_id . ')) ';
	}

	$sql = "select id,title from " . PVS_DB_PREFIX .
		"media where id < " . ( int )$id .
		$com_print . " and published=1 and id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id in (select category_id from " . PVS_DB_PREFIX .
		"category_items where publication_id=" . $id . ")) order by id desc";
	$dr->open( $sql );
	if ( ! $dr->eof )
	{
		if ( $print_id != 0 )
		{
			$navigation .= "<a href='" . pvs_print_url( $dr->row["id"], $print_id, $dr->
				row["title"], $print_type, '' ) . "' class='previous_link'>&#171; " .
				pvs_word_lang( "Previous" ) . "</a>";
			$previous_link = pvs_print_url( $dr->row["id"], $print_id, $dr->row["title"],
				$print_type, '' );
		} else
		{
			$navigation .= "<a href='" . pvs_item_url( $dr->row["id"] ) .
				"' class='previous_link'>&#171; " . pvs_word_lang( "Previous" ) . "</a>";
			$previous_link = pvs_item_url( $dr->row["id"] );
		}
	}

	$sql = "select id,title from " . PVS_DB_PREFIX .
		"media where id > " . ( int )$id .
		$com_print . " and published=1 and id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id in (select category_id from " . PVS_DB_PREFIX .
		"category_items where publication_id=" . $id . ")) order by id desc";
	$dr->open( $sql );
	if ( ! $dr->eof )
	{
		if ( $print_id != 0 )
		{
			$navigation .= " <a href='" . pvs_print_url( $dr->row["id"], $print_id, $dr->
				row["title"], $print_type, '' ) . "' class='next_link'>" . pvs_word_lang( "Next" ) .
				"&#187; </a>";
			$next_link = pvs_print_url( $dr->row["id"], $print_id, $dr->row["title"],
				$print_type, '' );
		} else
		{
			$navigation .= " <a href='" . pvs_item_url( $dr->row["id"] ) .
				"' class='next_link'>" . pvs_word_lang( "Next" ) . "&#187; </a>";
			$next_link = pvs_item_url( $dr->row["id"] );
		}
	}

	$pvs_theme_content[ 'navigation' ] =  $navigation;
	$pvs_theme_content[ 'previous_link' ] =  $previous_link;
	$pvs_theme_content[ 'next_link' ] =  $next_link;

	$flag_previous = false;
	if ( $previous_link != "" )
	{
		$flag_previous = true;
	}

	$flag_next = false;
	if ( $next_link != "" )
	{
		$flag_next = true;
	}

	$pvs_theme_content[ 'flag_previous' ] =  $flag_previous;
	$pvs_theme_content[ 'flag_next' ] =  $flag_next;

}
//End. The function shows next/previous navigation


//The function shows a publication's related items
function pvs_show_colors( $id, $type ) {
	global $db;
	global $dd;
	global $rs;
	global $pvs_theme_content;
	global $pvs_global_settings;

	$colors ='';
	$flag_colors = false;
	$colors_count = 0;

	if ($pvs_global_settings['show_colors']) {
		$sql = "select color from " . PVS_DB_PREFIX . "colors where publication_id = " . $id . " order by priority";
		$dd -> open($sql);
		
		if ($dd->eof) {
			$img = str_replace(pvs_upload_dir('baseurl'), pvs_upload_dir(), pvs_show_preview( $rs->row["id"], "photo", 1, 1, $dd->row["server1"], $rs->row["id"], false ));

			pvs_define_color($rs->row["id"], $img, $pvs_global_settings["colors_number"]);
			
			$dd -> open($sql);
		}

		while (!$dd->eof) {
			if ($colors_count < $pvs_global_settings['colors_number']) {
				//$colors .= '<a href="' . site_url() . '/?color=' . $dd->row['color'] . '&sphoto=1" class="btn" style="background-color:#' . $dd->row['color'] . ';width:10px"></a>&nbsp;';
				$colors .= '<a href="' . site_url() . '/?color=' . $dd->row['color'] . '&s' . $type . '=1" style="background-color:#' . $dd->row['color'] . ';width:10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>&nbsp;';
			}
			$colors_count ++;
			$dd -> movenext();
		}	
	
		if ($colors != '') {
			$flag_colors = true;
		}
	}
	
	$pvs_theme_content[ 'colors' ] = $colors;
	$pvs_theme_content[ 'flag_colors' ] = $flag_colors;
}
?>