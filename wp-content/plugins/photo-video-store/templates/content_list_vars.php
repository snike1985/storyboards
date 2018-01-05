<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$id_parent = 0;

if (get_query_var('pvs_page') == 'lightbox') {
	$_REQUEST["lightbox"] = get_query_var('pvs_id');
} else if (get_query_var('pvs_page') == 'collection') {
	$_REQUEST["collection"] = get_query_var('pvs_id');
} else {
	$id_parent = get_query_var('pvs_id');
}

//Stock
if ( isset( $_SESSION["stock_selected"] ) and $_SESSION["stock_selected"] != "" and
	@$pvs_global_settings[$_SESSION["stock_selected"] . "_api"] ) {
	$stock = pvs_result( $_SESSION["stock_selected"] );
} else
{
	if ( @$pvs_global_settings[$pvs_global_settings["stock_default"] . "_api"] == 1 ) {
		$stock = $pvs_global_settings["stock_default"];
	} else {
		$stock = "site";
	}
}

$stock_remote = false;

if ( isset( $_REQUEST["stock"] ) and @$pvs_global_settings[$_REQUEST["stock"] .
	"_api"] ) {
	$stock = pvs_result( $_REQUEST["stock"] );
	$_SESSION["stock_selected"] = $stock;
}

foreach ( $mstocks as $key => $value ) {
	if ( ( int )$pvs_global_settings[$key . "_api"] == 1 and $key != 'site' ) {
		$stock_remote = true;
	}
}


//Current page
if ( ! isset( $_REQUEST["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_REQUEST["str"];
}

if ( ! isset( $_REQUEST["vd"] ) ) {
	$vd = $pvs_global_settings["sorting_catalog"];
} else
{
	$vd = $_REQUEST["vd"];
}

//Search by ID instead of keyword
if ( ( int )@$_REQUEST["search"] > 0 ) {
	$_REQUEST["item_id"] = ( int )@$_REQUEST["search"];
	$_REQUEST["search"] = '';
}

$search = "";

if (get_query_var('pvs_search') != '') {
	$_REQUEST["search"] = get_query_var('pvs_search');
}

if ( isset( $_REQUEST["search"] ) ) {
	$search = $_REQUEST["search"];
}

$search = pvs_remove_words( $search );

//Search history
if ( $search != "" and $pvs_global_settings["search_history"] ) {
	if ( ! isset( $_SESSION["search_query"] ) or $_SESSION["search_query"] !=
		pvs_result( $search ) ) {
		$sql = "insert into " . PVS_DB_PREFIX . "search_history (zapros,data) values ('" .
			pvs_result( $search ) . "'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
			date( "m" ), date( "d" ), date( "Y" ) ) . ")";
		$db->execute( $sql );
		$_SESSION["search_query"] = pvs_result( $search );
	}
}

$items = $pvs_global_settings["k_str"];
if ( isset( $_REQUEST["items"] ) ) {
	if ( $_REQUEST["items"] > 100 ) {
		$items = 100;
	} else {
		$items = ( int )$_REQUEST["items"];
	}
}

//Items per page
$kolvo = $items;

//Pages per page
$kolvo2 = PVS_PAGE_NUMBER;

$scripts_variables = array(
	"c",
	"portfolio",
	"user",
	"lightbox",
	"sphoto",
	"svideo",
	"saudio",
	"svector",
	"scontent",
	"acategory",
	"kw_list",
	"author",
	"item_id",
	"swatermark",
	"color",
	"orientation",
	"holder",
	"frames",
	"rendering",
	"ratio",
	"format",
	"format2",
	"source",
	"duration_video",
	"duration_audio",
	"editorial",
	"creative",
	"id_parent",
	"items",
	"search",
	"str",
	"sort",
	"vd",
	"category",
	"acategory",
	"adult",
	"flow",
	"autopaging",
	"royalty_free",
	"rights_managed",
	"content_type",
	"contacts",
	"exclusive",
	"showmenu",
	"publication_date",
	"print_id",
	"stock",
	"stock_type",
	"age",
	"gender",
	"ethnicity",
	"people_number",
	"model",
	"license",
	"language",
	"resolution",
	"album_title",
	"artists",
	"bmp",
	"genre",
	"instrumental",
	"instruments",
	"lyrics",
	"moods",
	"vocal_description",
	"compositions",
	"file_types",
	"graphical_styles",
	"license_models",
	"price",
	"collection" );

//The function builds all current variables list
function pvs_build_variables( $var_default, $var_default2, $show_phpfile = true,
	$var_default3 = '', $ajax = false ) {
	global $_REQUEST;
	global $scripts_variables;
	$result_vars = "";
	$ajax_vars = "";
	for ( $i = 0; $i < count( $scripts_variables ); $i++ ) {
		if ( $scripts_variables[$i] != $var_default and $scripts_variables[$i] != $var_default2 and
			$scripts_variables[$i] != $var_default3 and ( isset( $_POST[$scripts_variables[$i]] ) or
			isset( $_GET[$scripts_variables[$i]] ) ) ) {
			if ( $result_vars != "" )
			{
				$result_vars .= "&";
			}

			if ( $ajax_vars != "" )
			{
				$ajax_vars .= ",";
			}

			$result_vars .= $scripts_variables[$i] . "=" . pvs_result( $_REQUEST[$scripts_variables[$i]] );
			$ajax_vars .= $scripts_variables[$i] . ":'" . pvs_result( $_REQUEST[$scripts_variables[$i]] ) .
				"'";
		}
	}
	if ( $result_vars == "" ) {
		$result_vars = "search=";
	}
	if ( $ajax == false ) {
		if ( $show_phpfile ) {
			return site_url() . "/?" . $result_vars;
		} else {
			return "&" . $result_vars;
		}
	} else {
		return $ajax_vars;
	}
}
//End. The function builds all current variables list

//The function builds listing id cache
function pvs_build_listing_id() {
	global $_REQUEST;
	global $scripts_variables;
	$result_vars = "";

	for ( $i = 0; $i < count( $scripts_variables ); $i++ ) {
		$value = "";
		if ( isset( $_REQUEST[$scripts_variables[$i]] ) ) {
			$value = pvs_result( $_REQUEST[$scripts_variables[$i]] );
		}
		$result_vars .= $i . "-" . $value;
	}

	return md5( $result_vars );
}
//The function builds listing id cache

//Sql conditions
$com = "";
$com2 = "";


//File types
$mass_types = array();
if ( $pvs_global_settings["allow_photo"] ) {
	$mass_types["photo"] = 1;
}
if ( $pvs_global_settings["allow_video"] ) {
	$mass_types["video"] = 1;
}
if ( $pvs_global_settings["allow_audio"] ) {
	$mass_types["audio"] = 1;
}
if ( $pvs_global_settings["allow_vector"] ) {
	$mass_types["vector"] = 1;
}

if ( ! isset( $_REQUEST["sphoto"] ) ) {
	$mass_types["photo"] = 0;
}

if ( ! isset( $_REQUEST["svideo"] ) ) {
	$mass_types["video"] = 0;
}

if ( ! isset( $_REQUEST["saudio"] ) ) {
	$mass_types["audio"] = 0;
}

if ( ! isset( $_REQUEST["svector"] ) ) {
	$mass_types["vector"] = 0;
}






if ( isset( $_REQUEST["scontent"] ) ) {
	if ( $_REQUEST["scontent"] == "vector" ) {
		$mass_types["vector"] = 1;
	}
	if ( $_REQUEST["scontent"] == "audio" ) {
		$mass_types["audio"] = 1;
	}
	if ( $_REQUEST["scontent"] == "video" ) {
		$mass_types["video"] = 1;
	}
	if ( $_REQUEST["scontent"] == "photo" ) {
		$mass_types["photo"] = 1;
	}
}


$sformat = 0;
foreach ( $mass_types as $key => $value ) {
	$sformat += $value;
}
if ( $sformat == 0 ) {
	foreach ( $mass_types as $key => $value ) {
		$mass_types[$key] = 1;
	}
}

$sformat = 0;
foreach ( $mass_types as $key => $value ) {
	$sformat += $value;
}

$sql_type = '';
if ($sformat !=4) {
	foreach ( $mass_types as $key => $value ) {
		if ($value == 1) {
			if ($sql_type != '') {
				$sql_type .= ' or ';
			}
			if ($key == 'photo') {
				$sql_type .= ' media_id = 1 ';
			}
			if ($key == 'video') {
				$sql_type .= ' media_id = 2 ';
			}
			if ($key == 'audio') {
				$sql_type .= ' media_id = 3 ';
			}
			if ($key == 'vector') {
				$sql_type .= ' media_id = 4 ';
			}
		}
	}
	if ($sql_type != '') {
		$sql_type = ' and (' . $sql_type . ') ';
	}
}

//End. File types

//All Free Featured
$c = "all";
if ( isset( $_REQUEST["c"] ) ) {
	$c = pvs_result( $_REQUEST["c"] );
}

//Sorting
if ( $vd == "popular" ) {
	$com = " order by viewed desc";
}

if ( $vd == "date" ) {
	$com = " order by data desc";
}
if ( $vd == "new" ) {
	$com = " order by data desc";
}
if ( $vd == "rated" ) {
	$com = " order by rating desc";
}
if ( $vd == "downloaded" ) {
	$com = " order by downloaded desc";
}

//Flow
$flow = 0;

if ( $pvs_global_settings["fixed_width"] and $pvs_global_settings["catalog_view"] ==
	"fixed_width" ) {
	$flow = 1;
}

if ( $pvs_global_settings["fixed_height"] and $pvs_global_settings["catalog_view"] ==
	"fixed_height" ) {
	$flow = 2;
}

if ( isset( $_COOKIE["flow_setting"] ) ) {
	$flow = ( int )$_COOKIE["flow_setting"];
}

if ( isset( $_REQUEST["flow"] ) ) {
	$flow = ( int )$_REQUEST["flow"];
}

$flow_vars = pvs_build_variables( "str", "", true, "", true );

//Auto paging
if ( $pvs_global_settings["auto_paging_default"] ) {
	$autopaging = 1;
} else
{
	$autopaging = 0;
}

if ( $pvs_global_settings["auto_paging"] ) {
	if ( isset( $_COOKIE["autopaging_setting"] ) ) {
		$autopaging = ( int )$_COOKIE["autopaging_setting"];
	}

	if ( isset( $_REQUEST["autopaging"] ) ) {
		$autopaging = ( int )$_REQUEST["autopaging"];
	}
}

//Show search panel
if ( $pvs_global_settings["left_search_default"] ) {
	$showmenu = 1;
} else
{
	$showmenu = 0;
}

if ( isset( $_COOKIE["showmenu_setting"] ) ) {
	$showmenu = ( int )$_COOKIE["showmenu_setting"];
}

if ( isset( $_REQUEST["showmenu"] ) ) {
	$showmenu = ( int )$_REQUEST["showmenu"];
}

//Subcategories content
$category = "";
if ( $id_parent != 0 and ! isset( $_REQUEST["acategory"] ) ) {
	//Search all subcategories from the category
	$itg = "";
	$nlimit = 0;
	pvs_build_subcategories_query( ( int )$id_parent );

	$password_protected = pvs_get_password_protected();

	$category = " and id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id=" . ( int )$id_parent . $itg . ") ";

	if ( $password_protected != '' ) {
		$category .= " and id not in (select publication_id from " .
			PVS_DB_PREFIX . "category_items where " . $password_protected . ") ";
	}
}

//Searching
$sch = array();
if ( isset( $search ) and $search != "" ) {
	$sch = explode( " ", trim( pvs_result( $search ) ) );
}

foreach ( $_REQUEST as $key => $value ) {
	$tt = explode( "_", $key );
	if ( $tt[0] == "s" and isset( $tt[1] ) ) {
		$sch[count( $sch )] = pvs_result( $tt[1] );
	}
}

//Keywords massive
$kw_mass = array();
if ( isset( $_REQUEST["kw_list"] ) and $_REQUEST["kw_list"] != "" ) {
	$kw_mass = explode( "|", pvs_remove_words( pvs_result( $_REQUEST["kw_list"] ) ) );
	for ( $i = 0; $i < count( $kw_mass ); $i++ ) {
		$sch[] = $kw_mass[$i];
	}
}

$com_multilangual = "";

if ( count( $sch ) > 0 ) {
	if ( $com2 != "" ) {
		$com2 .= " and ";
	}

	$com2 .= "(";
	$com_multilangual = "(";
	$search = "";
	for ( $i = 0; $i < count( $sch ); $i++ ) {
		if ( $i != 0 ) {
			$com2 .= " and ";
		}
		if ( $i != 0 ) {
			$com_multilangual .= " and ";
		}

		//Slow query. With '%' and 'like' - faster
		//$com2.=" (title rlike '[[:<:]]".$sch[$i]."[[:>:]]' or description rlike '[[:<:]]".$sch[$i]."[[:>:]]' or keywords rlike '[[:<:]]".$sch[$i]."[[:>:]]') ";

		//Cirillic
		//$com2.=" (UCASE(title) like UCASE('%".$sch[$i]."%') or UCASE(description) like UCASE('%".$sch[$i]."%') or UCASE(keywords) like UCASE('%".$sch[$i]."%')) ";

		//Fast query
		//$com2.=" (title like '%".$sch[$i]."%' or description like '%".$sch[$i]."%' or keywords like '%".$sch[$i]."%') ";

		//Fast query. It searches without 'description'.
		$com2 .= " (title like '%" . $sch[$i] . "%' or keywords like '%" . $sch[$i] .
			"%') ";

		$com_multilangual .= " (title like '%" . $sch[$i] . "%' or keywords like '%" . $sch[$i] .
			"%' or description like '%" . $sch[$i] . "%') ";

		if ( $i != 0 ) {
			$search .= " ";
		}
		$search .= $sch[$i];
	}
	$com_multilangual .= ")";

	//Multilangual
	if ( $pvs_global_settings["multilingual_publications"] and $com_multilangual !=
		'' ) {
		$sql = "select id from " . PVS_DB_PREFIX . "translations where types=1 and " . $com_multilangual .
			" group by id order by id";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$multi_ids = "(";

			while ( ! $dr->eof )
			{
				if ( $multi_ids != '(' )
				{
					$multi_ids .= " or ";
				}

				$multi_ids .= "id=" . $dr->row["id"];

				$dr->movenext();
			}

			$multi_ids .= ")";

			$com2 .= " or " . $multi_ids;
		}
	}
	//End. Multilingual

	$com2 .= ")";

}

//User portfolio
if ( isset( $_REQUEST["portfolio"] ) and isset( $_REQUEST["user"] ) ) {
	$sql = "select user_login from " . $table_prefix . "users where  ID=" . ( int )
		$_REQUEST["user"];
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		if ( $com2 != "" ) {
			$com2 .= " and ";
		}
		$com2 .= " author='" . $dr->row["user_login"] . "' ";
	}
}

//Author
if ( isset( $_REQUEST["author"] ) and $_REQUEST["author"] != '' ) {
	if ( $com2 != "" ) {
		$com2 .= " and ";
	}
	$com2 .= " author='" . pvs_result_strict( $_REQUEST["author"] ) . "' ";
}

//User lightbox
if ( isset( $_REQUEST["lightbox"] ) ) {
	if ( $com2 != "" ) {
		$com2 .= " and ";
	}
	$com2 .= " (id in (select item from " . PVS_DB_PREFIX .
		"lightboxes_files where id_parent=" . ( int )$_REQUEST["lightbox"] . ")) ";
}

//Collection
if ( isset( $_REQUEST["collection"] ) ) {
	if ( $com2 != "" ) {
		$com2 .= " and ";
	}
	$sql = "select types from " . PVS_DB_PREFIX .  "collections where active = 1 and id=" . (int)$_REQUEST["collection"] . " order by title";
	$ds->open($sql);
	if (!$ds->eof) {
		if ($ds->row["types"] == 1) {
				$com2 .= " (id in (select publication_id from " . PVS_DB_PREFIX . "collections_items where collection_id=" . ( int )$_REQUEST["collection"] . ")) ";		
		} else {
			$password_protected = pvs_get_password_protected();
		
			$category = " and id in (select publication_id from " . PVS_DB_PREFIX .
				"category_items where category_id in (select category_id from " . PVS_DB_PREFIX . "collections_items where collection_id=" . ( int )$_REQUEST["collection"] . ")) ";
		
			if ( $password_protected != '' ) {
				$category .= " and id not in (select publication_id from " .
					PVS_DB_PREFIX . "category_items where " . $password_protected . ") ";
			}		
		}
	}
}

//Prints
if ( isset( $_REQUEST["print_id"] ) ) {
	$sql_in_stock = "";
	if ( ! $pvs_global_settings["show_not_in_stock"] ) {
		$sql_in_stock = " and (in_stock = -1 or in_stock > 0) ";
	}

	$sql = "select itemid from " . PVS_DB_PREFIX . "prints_items where printsid=" . ( int )
		$_REQUEST["print_id"] . $sql_in_stock;

	if ( $com2 != "" ) {
		$com2 .= " and ";
	}
	$com2 .= " (id in (" . $sql . ")) ";
}

//Free or featured
if ( $c == "featured" ) {
	if ( $com2 != "" ) {
		$com2 .= " and ";
	}
	$com2 .= "featured=1";
}

if ( $c == "free" ) {
	if ( $com2 != "" ) {
		$com2 .= " and ";
	}
	$com2 .= "free=1";
}

//Royalty free and Rights managed
$license_sql = "";

if ( isset( $_REQUEST["royalty_free"] ) ) {
	$royalty_free = 1;
} else
{
	$royalty_free = 0;
}

if ( isset( $_REQUEST["rights_managed"] ) ) {
	$rights_managed = 1;
} else
{
	$rights_managed = 0;
}

if ( $royalty_free == 0 and $rights_managed == 0 ) {
	$royalty_free = 1;
	$rights_managed = 1;
}

if ( $royalty_free == 1 and $rights_managed == 0 ) {
	$license_sql = " and rights_managed=0";
}

if ( $royalty_free == 0 and $rights_managed == 1 ) {
	$license_sql = " and rights_managed<>0";
}

//Category
if ( isset( $_REQUEST["category_name"] ) ) {
	$sql = "select id from " . PVS_DB_PREFIX . "category where title like '%" .
		pvs_result( $_REQUEST["category_name"] ) . "%'";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$_REQUEST["acategory"] = $dr->row["id"];
		$id_parent = $dr->row["id"];
	}
}

if ( isset( $_REQUEST["acategory"] ) and $_REQUEST["acategory"] != "" and $_REQUEST["acategory"] !=
	0 ) {
	//Search all subcategories from the category
	$itg = "";
	$nlimit = 0;
	pvs_build_subcategories_query( ( int )$_REQUEST["acategory"] );

	$password_protected = pvs_get_password_protected();

	$category = " and id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id=" . ( int )$_REQUEST["acategory"] . $itg .
		") ";

	if ( $password_protected != '' ) {
		$category .= " and id not in (select publication_id from " .
			PVS_DB_PREFIX . "category_items where " . $password_protected . ") ";
	}
}

//item id
$item_id = "";
if ( isset( $_REQUEST["item_id"] ) and $_REQUEST["item_id"] != "" ) {
	$item_id = " and id=" . ( int )$_REQUEST["item_id"];
}

//Content type
$content_type = "";
if ( isset( $_REQUEST["content_type"] ) and $_REQUEST["content_type"] != "" ) {
	$content_type = " and content_type='" . pvs_result( $_REQUEST["content_type"] ) .
		"'";
}

//Publication date
$publication_date = "";
if ( isset( $_REQUEST["publication_date"] ) and $_REQUEST["publication_date"] !=
	"" ) {
	$pub_date = explode( "/", pvs_result( $_REQUEST["publication_date"] ) );
	if ( count( $pub_date ) == 3 ) {
		$publication_date = " and data<" . pvs_get_time( 23, 59, 59, ( int )$pub_date[0],
			( int )$pub_date[1], ( int )$pub_date[2] ) . " and data>" . pvs_get_time( 0, 0,
			1, ( int )$pub_date[0], ( int )$pub_date[1], ( int )$pub_date[2] );
	}
}

//Adult
$adult_sql = "";
if ( isset( $_REQUEST["adult"] ) ) {
	$adult_sql = " and adult<>1";
}

//Contact Us price
$contacts_sql = "";
if ( isset( $_REQUEST["contacts"] ) ) {
	$contacts_sql = " and contacts=1";
}

//Exclusive price
$exclusive_sql = "";
if ( isset( $_REQUEST["exclusive"] ) ) {
	$exclusive_sql = " and exclusive=1";
}

//Watermark
$wtr = "";
if ( isset( $_POST["swatermark"] ) ) {
	$wtr = "and watermark=" . ( int )$_POST["swatermark"];
}

//Color
$color = "";
if ( isset( $_REQUEST["color"] ) and $_REQUEST["color"] != "" ) {
	$color_hex = pvs_result($_REQUEST["color"]);
	$red = hexdec(substr($color_hex,0,2));
	$green = hexdec(substr($color_hex,2,2));
	$blue = hexdec(substr($color_hex,4,2));
	$color_interval = 10;

	$color .= " and id in (select publication_id from " . PVS_DB_PREFIX . "colors where  red > " . ($red - $color_interval) . " and red < " . ($red + $color_interval) . " and green > " . ($green - $color_interval) . " and green < " . ($green + $color_interval) . " and blue > " . ($blue - $color_interval) . " and blue < " . ($blue + $color_interval) . ") ";
}

//Orientation
$orientation = "";
if ( isset( $_REQUEST["orientation"] ) and ( ( int )$_REQUEST["orientation"] ==
	0 or ( int )$_REQUEST["orientation"] == 1 ) ) {
	$orientation = " and orientation=" . ( int )$_REQUEST["orientation"];
}

//Copyright holder
$holder = "";
if ( isset( $_REQUEST["holder"] ) and $_REQUEST["holder"] != "" ) {
	$holder = " and holder='" . pvs_result_strict( $_REQUEST["holder"] ) . "'";
}

//Frames
$frames = "";
if ( isset( $_REQUEST["frames"] ) and $_REQUEST["frames"] != "" ) {
	$frames = " and frames='" . pvs_result_strict( $_REQUEST["frames"] ) . "'";
}

//Rendering
$rendering = "";
if ( isset( $_REQUEST["rendering"] ) and $_REQUEST["rendering"] != "" ) {
	$rendering = " and rendering='" . pvs_result_strict( $_REQUEST["rendering"] ) .
		"'";
}

//Ratio
$ratio = "";
if ( isset( $_REQUEST["ratio"] ) and $_REQUEST["ratio"] != "" ) {
	$ratio = " and ratio='" . pvs_result_strict( $_REQUEST["ratio"] ) . "'";
}

//Format video
$format = "";
if ( isset( $_REQUEST["format"] ) and $_REQUEST["format"] != "" ) {
	$format = " and format='" . pvs_result_strict( $_REQUEST["format"] ) . "'";
}

//Format audio
$format2 = "";
if ( isset( $_REQUEST["format2"] ) and $_REQUEST["format2"] != "" ) {
	$format2 = " and format='" . pvs_result_strict( $_REQUEST["format2"] ) . "'";
}

//Source
$source = "";
if ( isset( $_REQUEST["source"] ) and $_REQUEST["source"] != "" ) {
	$source = " and source='" . pvs_result_strict( $_REQUEST["source"] ) . "'";
}

//Duration video
$duration_video = "";
$duration_video1 = 0;
$duration_video2 = 1800;
if ( isset( $_REQUEST["duration_video"] ) and $_REQUEST["duration_video"] != "" ) {
	$duration_mass = explode( " - ", pvs_result( $_REQUEST["duration_video"] ) );
	if ( isset( $duration_mass[0] ) and isset( $duration_mass[1] ) ) {
		$duration_video1 = ( int )$duration_mass[0];
		$duration_video2 = ( int )$duration_mass[1];
		$duration_video = " and duration>" . ( ( int )$duration_mass[0] - 1 ) .
			" and duration<" . ( ( int )$duration_mass[1] + 1 );
	}
}

//Duration audio
$duration_audio = "";
$duration_audio1 = 0;
$duration_audio2 = 1800;
if ( isset( $_REQUEST["duration_audio"] ) and $_REQUEST["duration_audio"] != "" ) {
	$duration_mass = explode( " - ", pvs_result( $_REQUEST["duration_audio"] ) );
	if ( isset( $duration_mass[0] ) and isset( $duration_mass[1] ) ) {
		$duration_audio1 = ( int )$duration_mass[0];
		$duration_audio2 = ( int )$duration_mass[1];
		$duration_audio = " and duration>" . ( ( int )$duration_mass[0] - 1 ) .
			" and duration<" . ( ( int )$duration_mass[1] + 1 );
	}
}

//Price
$price_min = 0;
$price_max = ( int )$pvs_global_settings["max_price"];
if ( isset( $_REQUEST["price"] ) and $_REQUEST["price"] != "" ) {
	$price_mass = explode( " - ", pvs_result( $_REQUEST["price"] ) );

	if ( isset( $price_mass[0] ) and isset( $price_mass[1] ) and ( $price_mass[0] !=
		0 or $price_mass[1] != ( int )$pvs_global_settings["max_price"] ) ) {
		$price_min = ( int )$price_mass[0];
		$price_max = ( int )$price_mass[1];

		$price_check = array();

		if ( ( int )@$_REQUEST["print_id"] > 0 ) {
			$sql = "select itemid from " . PVS_DB_PREFIX . "prints_items where printsid=" . ( int )
				$_REQUEST["print_id"] . " and  price>" . ( $price_min - 1 ) . " and price<" . ( $price_max +
				1 );
		} else {
			$sql = "select id_parent from " . PVS_DB_PREFIX . "items where price>" . ( $price_min -
				1 ) . " and price<" . ( $price_max + 1 );
		}

		if ( $com2 != "" ) {
			$com2 .= " and ";
		}
		$com2 .= " (id in (" . $sql . ")) ";
	}
}

//Editorial and Creative
$editorial = "checked";
$creative = "checked";
$editorial_sql = "";
if ( isset( $_REQUEST["editorial"] ) and ! isset( $_REQUEST["creative"] ) ) {
	$editorial = "checked";
	$creative = "";
	$editorial_sql = " and editorial=1 ";
}

if ( isset( $_REQUEST["creative"] ) and ! isset( $_REQUEST["editorial"] ) ) {
	$creative = "checked";
	$editorial = "";
	$editorial_sql = " and editorial=0 ";
}

if ( $category == '' ) {
	$password_protected = pvs_get_password_protected();

	if ( $password_protected != '' ) {
		$category = " and (id not in (select publication_id from " .
			PVS_DB_PREFIX . "category_items where " . $password_protected . ")) ";
	}
}

//Limit
$lm = "";

$n = 0;

if ( $com2 != "" ) {
	$com2 = " and " . $com2;
}

$sql_mass = array();

//Query for the search

$sql = "select id,media_id from " .
	PVS_DB_PREFIX . "media where published=1 " . $sql_type . $wtr . $category . $color . $orientation .
	$item_id . $content_type . $publication_date . $editorial_sql . $adult_sql . $contacts_sql .
	$exclusive_sql . $license_sql . $com2;



//Lite query for the result count
$sql_simple = "select count(*) as count_rows from " .
	PVS_DB_PREFIX . "media where published=1 " . $sql_type . $wtr . $category . $color . $orientation .
	$item_id . $content_type . $publication_date . $editorial_sql . $adult_sql . $contacts_sql .
	$exclusive_sql . $license_sql . $com2;


//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;


$record_count = 0;
$paging_text = "";
if ( $stock == 'site' ) {
	$record_count = 0;
	if ( ! $pvs_global_settings["no_calculation"] ) {
		$rs->open( $sql_simple );
		if ( ! $rs->eof )
		{
			$record_count += $rs->row["count_rows"];
		}
	} else {
		$record_count = $pvs_global_settings["no_calculation_total"];
	}

	$flag_show_end = true;
	if ( $pvs_global_settings["no_calculation"] ) {
		$flag_show_end = false;
	}

	$paging_text = pvs_paging( $record_count, $str, $kolvo, $kolvo2, site_url() . "/", pvs_build_variables( "str", "", false ), false, $flag_show_end );
}



//Sort menu
$vars_sort = pvs_build_variables( "vd", "" );
$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";
$mass_sort["downloaded"] = pvs_word_lang( "most downloaded" );
$mass_sort["popular"] = pvs_word_lang( "most popular" );
$mass_sort["date"] = pvs_word_lang( "date" );
$mass_sort["rated"] = pvs_word_lang( "top rated" );
foreach ( $mass_sort as $key => $value ) {
	$sel = "";
	if ( $key == $vd ) {
		$sel = "selected";
	}
	$sortmenu .= "<option value='" . $vars_sort . "&vd=" . $key . "' " . $sel . ">" .
		$value . "</option>";
}
$sortmenu .= "</select>";
//End. Sort menu

//Content menu
$cmenu = array(
	"all",
	"featured",
	"free" );
$vars_contentmenu = pvs_build_variables( "c", "" );
$contentmenu = "<select onChange='location.href=this.value' style='width:110px' class='form-control'>";
for ( $i = 0; $i < count( $cmenu ); $i++ ) {
	$sel = "";
	if ( $c == $cmenu[$i] ) {
		$sel = " selected ";
	}

	$contentmenu .= "<option value='" . $vars_contentmenu . "&c=" . $cmenu[$i] .
		"' " . $sel . ">" . pvs_word_lang( $cmenu[$i] ) . "</option>";
}
$contentmenu .= "</select>";
//End. Content menu

//Items menu
$citems = array(
	10,
	20,
	30,
	50,
	100 );
$vars_itemsmenu = pvs_build_variables( "items", "str" );
$itemsmenu = "<select onChange='location.href=this.value' style='width:60px' class='form-control'>";
for ( $i = 0; $i < count( $citems ); $i++ ) {
	$sel = "";
	if ( $items == $citems[$i] ) {
		$sel = " selected ";
	}

	$itemsmenu .= "<option value='" . $vars_itemsmenu . "&items=" . $citems[$i] .
		"&str=1' " . $sel . ">" . $citems[$i] . "</option>";
}
$itemsmenu .= "</select>";
//End. Items menu

//Lightboxes menu
$lightboxesmenu = "<ul>";
$sql3 = "select id,title from " . PVS_DB_PREFIX .
	"lightboxes where catalog=1 order by title";
$ds->open( $sql3 );
while ( ! $ds->eof ) {
	$lightboxesmenu .= "<li><a href='" . pvs_lightbox_url( $ds->row["id"], $ds->row["title"] ) .
		"'>" . $ds->row["title"] . "</a></li>";
	$ds->movenext();
}
$lightboxesmenu .= "</ul>";
//End. Lightboxes menu

//Prints
if ( isset( $_REQUEST["print_id"] ) and ( int )$_REQUEST["print_id"] > 0 and $pvs_global_settings["prints_previews"] ) {
	$print_info = pvs_get_print_preview_info( ( int )$_REQUEST["print_id"] );
	$prints_flag = $print_info["flag"];
	$prints_preview = $print_info["preview"];
	$prints_title = $print_info["title"];
}

if ( @$prints_flag ) {
	$flow = 1;
}
//End. Prints.

?>