<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Check access
pvs_admin_panel_access( "catalog_catalog" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );



//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Photo delete
if ( @$_REQUEST["action"] == 'photo_delete' )
{
	include ( "photo_delete.php" );
}

//Filter change
if ( @$_REQUEST["action"] == 'filter_change' )
{
	include ( "filter_change.php" );
}

//Bulk photo upload
if ( @$_REQUEST["action"] == 'photo_upload' )
{
	include ( PVS_PATH . "includes/admin/bulk_upload/photo_upload.php" );
}

//Bulk photo java upload
if ( @$_REQUEST["action"] == 'photo_java_upload' )
{
	include ( PVS_PATH . "includes/admin/bulk_upload/photo_java_upload.php" );
}

//Bulk video upload
if ( @$_REQUEST["action"] == 'video_upload' )
{
	include ( PVS_PATH . "includes/admin/bulk_upload/video_upload.php" );
}

//Bulk audio upload
if ( @$_REQUEST["action"] == 'audio_upload' )
{
	include ( PVS_PATH . "includes/admin/bulk_upload/audio_upload.php" );
}

//Bulk vector upload
if ( @$_REQUEST["action"] == 'vector_upload' )
{
	include ( PVS_PATH . "includes/admin/bulk_upload/vector_upload.php" );
}

if ( @$_REQUEST["action"] == 'edit' )
{
	include ( PVS_PATH . "includes/admin/categories/edit.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else if (@$_REQUEST["action"] == 'filter') {
	include ( "filter.php" );
} else if ((isset($_REQUEST["formaction"]) and $_REQUEST["formaction"] != 'delete_publication') and @$_REQUEST["step"] != 2) {
	
} else {

?>

<?php
if ( $pvs_global_settings["allow_vector"] ) {
?>
<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&type=vector"><i class="icon-picture icon-white fa fa-leaf"></i>&nbsp; <?php echo pvs_word_lang( "upload vector" )?></a>
<?php
}

if ( $pvs_global_settings["allow_audio"] ) {
?>
<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&type=audio"><i class="icon-music icon-white fa fa-music"></i>&nbsp; <?php echo pvs_word_lang( "upload audio" )?></a>
<?php
}

if ( $pvs_global_settings["allow_video"] ) {
?>
<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&type=video"><i class="icon-film icon-white fa fa-film"></i>&nbsp; <?php echo pvs_word_lang( "upload video" )?></a>
<?php
}

if ( $pvs_global_settings["allow_photo"] ) {
?>
<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&type=photo"><i class="icon-camera icon-white fa fa-photo"></i>&nbsp; <?php echo pvs_word_lang( "upload photo" )?></a>
<?php
}
?>

<h1><?php echo pvs_word_lang( "catalog" )?>:</h1>

<script language="javascript">

function bulk_action(value) {
document.getElementById("formaction").value=value;

document.getElementById("adminform").submit();
}


</script>


<?php
//Catalog view
$view = "grid";

if ( isset( $_COOKIE["view_setting"] ) ) {
	$view = pvs_result( $_COOKIE["view_setting"] );
}

if ( isset( $_REQUEST["view"] ) ) {
	$view = pvs_result( $_REQUEST["view"] );
}



//Get Search
$search = "";
if ( isset( $_REQUEST["search"] ) ) {
	$search = pvs_result( $_REQUEST["search"] );
}

//Get Search type
$search_type = "";
if ( isset( $_REQUEST["search_type"] ) ) {
	$search_type = pvs_result( $_REQUEST["search_type"] );
}

//Get category ID
$category_id = 0;
if ( isset( $_REQUEST["category_id"] ) ) {
	$category_id = ( int )$_REQUEST["category_id"];
}

//Get type
$type = "all";
if ( isset( $_REQUEST["type"] ) ) {
	$type = pvs_result( $_REQUEST["type"] );
}

//Get pub_type
$pub_type = "all";
if ( isset( $_REQUEST["pub_type"] ) ) {
	$pub_type = pvs_result( $_REQUEST["pub_type"] );
}

//Get pub_ctype
$pub_ctype = "all";
if ( isset( $_REQUEST["pub_ctype"] ) ) {
	$pub_ctype = pvs_result( $_REQUEST["pub_ctype"] );
}

//Get filter
$filter = "all";
if ( isset( $_REQUEST["filter"] ) ) {
	$filter = pvs_result( $_REQUEST["filter"] );
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type .
	"&category_id=" . $category_id . "&type=" . $type . "&items=" . $items .
	"&pub_type=" . $pub_type . "&pub_ctype=" . $pub_ctype . "&filter=" . $filter;

//Sort by title
$atitle = 0;
if ( isset( $_GET["atitle"] ) ) {
	$atitle = ( int )$_GET["atitle"];
}

//Sort by date
$adate = 0;
if ( isset( $_GET["adate"] ) ) {
	$adate = ( int )$_GET["adate"];
}

//Sort by downloads
$adownloads = 0;
if ( isset( $_GET["adownloads"] ) ) {
	$adownloads = ( int )$_GET["adownloads"];
}

//Sort by viewed
$aviewed = 0;
if ( isset( $_GET["aviewed"] ) ) {
	$aviewed = ( int )$_GET["aviewed"];
}

//Sort by ID
$aid = 0;
if ( isset( $_GET["aid"] ) ) {
	$aid = ( int )$_GET["aid"];
}

//Sort by default
if ( $atitle == 0 and $adate == 0 and $adownloads == 0 and $aviewed == 0 and $aid ==
	0 ) {
	$adate = 2;
}

//Add sort variable
$com = "";

if ( $atitle != 0 ) {
	$var_sort = "&atitle=" . $atitle;
	if ( $atitle == 1 ) {
		$com = " order by title ";
	}
	if ( $atitle == 2 ) {
		$com = " order by title desc ";
	}
}

if ( $adate != 0 ) {
	$var_sort = "&adate=" . $adate;
	if ( $adate == 1 ) {
		$com = " order by data ";
	}
	if ( $adate == 2 ) {
		$com = " order by data desc ";
	}
}

if ( $aviewed != 0 ) {
	$var_sort = "&aviewed=" . $aviewed;
	if ( $aviewed == 1 ) {
		$com = " order by viewed ";
	}
	if ( $aviewed == 2 ) {
		$com = " order by viewed desc ";
	}
}

if ( $adownloads != 0 ) {
	$var_sort = "&adownloads=" . $adownloads;
	if ( $adownloads == 1 ) {
		$com = " order by downloaded ";
	}
	if ( $adownloads == 2 ) {
		$com = " order by downloaded desc ";
	}
}

if ( $aid != 0 ) {
	$var_sort = "&aid=" . $aid;
	if ( $aid == 1 ) {
		$com = " order by id ";
	}
	if ( $aid == 2 ) {
		$com = " order by id desc ";
	}
}

//Types
$mass_types = array();
if ( $pvs_global_settings["allow_photo"] ) {
	$mass_types[] = "photo";
}
if ( $pvs_global_settings["allow_video"] ) {
	$mass_types[] = "video";
}
if ( $pvs_global_settings["allow_audio"] ) {
	$mass_types[] = "audio";
}
if ( $pvs_global_settings["allow_vector"] ) {
	$mass_types[] = "vector";
}

//Items on the page
$items_mass = array(
	10,
	20,
	30,
	50,
	75,
	100 );

//Search parameter
$com2 = "";

if ( $search != "" ) {
	if ( $search_type == "title" ) {
		$com2 .= " and (title like '%" . $search . "%' or description like '%" . $search .
			"%' or keywords like '%" . $search . "%') ";
	}
	if ( $search_type == "id" ) {
		$com2 .= " and id=" . ( int )$search . " ";
	}
	if ( $search_type == "author" ) {
		$com2 .= " and author = '" . $search . "' ";
	}
	if ( $search_type == "lightbox" ) {
		$lightbox_id = 0;
		$sql = "select id from " . PVS_DB_PREFIX . "lightboxes where title='" . $search .
			"'";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$lightbox_id = $dr->row["id"];
		}

		$com2 .= " and (id in (select item from " . PVS_DB_PREFIX .
			"lightboxes_files where id_parent=" . $lightbox_id . ")) ";
	}
	if ( $search_type == "collection" ) {
		$sql = "select id,types from " . PVS_DB_PREFIX . "collections where title='" . $search . "'";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			if ($dr->row["types"] == 0) {
				$com2 .= " and (id in ( select publication_id from " . PVS_DB_PREFIX . "category_items where category_id  in (select category_id from " . PVS_DB_PREFIX . "collections_items where collection_id=" . $dr->row["id"] . "))) ";			
			} else {
				$com2 .= " and (id in (select publication_id from " . PVS_DB_PREFIX . "collections_items where collection_id=" . $dr->row["id"] . ")) ";			
			}
		}
	}
}

if ( $category_id != 0 ) {
	$com2 .= " and (id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id=" . $category_id . ")) ";
}

if ( $pub_type == "featured" ) {
	$com2 .= " and (featured=1) ";
}

$sql_editorial = "";
if ( $pub_type == "editorial" ) {
	$sql_editorial .= " and (editorial=1) ";
}
if ( $pub_type == "free" ) {
	$com2 .= " and (free=1) ";
}
if ( $pub_type == "adult" ) {
	$com2 .= " and (adult=1) ";
}
if ( $pub_type == "exclusive" ) {
	$com2 .= " and (exclusive=1) ";
}
if ( $pub_type == "contacts" ) {
	$com2 .= " and (contacts=1) ";
}
if ( $pub_type == "exclusive_sold" ) {
	$com2 .= " and (exclusive=1 and published=-1) ";
}
if ( $pub_type == "approved" ) {
	$com2 .= " and (published=1) ";
}
if ( $pub_type == "pending" ) {
	$com2 .= " and (published=0) ";
}
if ( $pub_type == "declined" ) {
	$com2 .= " and (published=-1 and exclusive<>1) ";
}

if ( $pub_ctype != "all" ) {
	$com2 .= " and (content_type='" . $pub_ctype . "') ";
}

if ( $filter == "yes" ) {
	$sql = "select words from " . PVS_DB_PREFIX . "content_filter";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$words = explode( ",", $ds->row["words"] );
		$words_sql = "";
		for ( $i = 0; $i < count( $words ); $i++ ) {
			if ( $words_sql != "" )
			{
				$words_sql .= " or ";
			}
			if ( trim( $words[$i] ) != "" )
			{
				$words_sql .= " title like '%" . trim( $words[$i] ) .
					"%' or description like '%" . trim( $words[$i] ) . "%' or keywords  like '%" .
					trim( $words[$i] ) . "%' ";
			}
		}
		if ( $words_sql != "" ) {
			$com2 .= " and (" . $words_sql . ") ";
		}
	}
}

//Item's quantity
$kolvo = $items;

//Pages quantity
$kolvo2 = PVS_PAGE_NUMBER;

//Page number
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

$n = 0;


$media_type = "";

if ( $type == "photo" ) {
	$media_type = " and media_id = 1 ";
}
if ( $type == "video" ) {
	$media_type = " and media_id = 2 ";
}
if ( $type == "audio" ) {
	$media_type = " and media_id = 3 ";
}
if ( $type == "vector" ) {
	$media_type = " and media_id = 4 ";
}

$sql = "select id, media_id, title ,data ,published,description,viewed,keywords,rating,downloaded,free,featured,author,server1,url,content_type,exclusive from " .
	PVS_DB_PREFIX . "media where id>0 " . $com2 . $sql_editorial.$media_type;

$sql .= $com;
if ( ! $pvs_global_settings["no_calculation"] ) {
	$rs->open( $sql );
	$record_count = $rs->rc;
} else
{
	$record_count = $pvs_global_settings["no_calculation_total"];
}

$flag_show_end = true;
if ( $pvs_global_settings["no_calculation"] ) {
	$flag_show_end = false;
}

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql .= $lm;

//echo($sql);
$rs->open( $sql );
?>
<div id="catalog_menu">


<form method="post" action="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>" style="margin:0px">
<div class="toleft">
<span><?php echo pvs_word_lang( "search" )?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="form-control" value="<?php echo $search
?>" onClick="this.value=''">
<select name="search_type" style="width:120px;display:inline" class="form-control">
<option value="id" <?php
if ( $search_type == "id" ) {
	echo ( "selected" );
}
?>>ID</option>
<option value="title" <?php
if ( $search_type == "title" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "title" )?></option>
<option value="author" <?php
if ( $search_type == "author" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "author" )?></option>
<option value="lightbox" <?php
if ( $search_type == "lightbox" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "lightboxes" )?></option>
<option value="collection" <?php
if ( $search_type == "collection" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "Collections" )?></option>
</select>
</div>




<div class="toleft">
<span><?php echo pvs_word_lang( "category" )?>:</span>
<select name="category_id" style="width:240px" class="ft">
<option value="0"><?php echo pvs_word_lang( "all" )?></option>
<?php
$itg = "";
$nlimit = 0;
pvs_build_menu_admin( 0, $category_id, 2, 0 );
echo ( $itg );
?>

</select>
</div>

<div class="toleft">
<span><?php echo pvs_word_lang( "content" )?>:</span>
<select name="type" style="width:100px" class="ft">
<option value="all"><?php echo pvs_word_lang( "all" )?></option>
<?php
for ( $i = 0; $i < count( $mass_types ); $i++ ) {
	$sel = "";
	if ( $type == $mass_types[$i] ) {
		$sel = "selected";
	}
?>
<option value="<?php echo $mass_types[$i] ?>" <?php echo $sel
?>><?php echo pvs_word_lang( $mass_types[$i] )?></option>
<?php
}
?>

</select>
</div>




<div class="toleft">
<span><?php echo pvs_word_lang( "type" )?>:</span>
<select name="pub_type" style="width:170px" class="ft">
<option value="all"><?php echo pvs_word_lang( "all" )?></option>
<option value="free" <?php
if ( $pub_type == "free" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "free" )?></option>
<option value="featured" <?php
if ( $pub_type == "featured" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "featured" )?></option>
<option value="editorial" <?php
if ( $pub_type == "editorial" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "editorial" )?></option>
<?php
if ( $pvs_global_settings["adult_content"] ) {
?>
	<option value="adult" <?php
	if ( $pub_type == "adult" ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "adult content" )?></option>
	<?php
}

if ( $pvs_global_settings["exclusive_price"] ) {
?>
	<option value="exclusive" <?php
	if ( $pub_type == "exclusive" ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "exclusive price" )?></option>
	<option value="exclusive_sold" <?php
	if ( $pub_type == "exclusive_sold" ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "exclusive price" )?> - <?php echo pvs_word_lang( "sold" )?></option>
	<?php
}

if ( $pvs_global_settings["contacts_price"] ) {
?>
	<option value="contacts" <?php
	if ( $pub_type == "contacts" ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "contact us to get the price" )?></option>
	<?php
}
?>
<option value="approved" <?php
if ( $pub_type == "approved" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "approved" )?></option>
<option value="pending" <?php
if ( $pub_type == "pending" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "pending" )?></option>
<option value="declined" <?php
if ( $pub_type == "declined" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "declined" )?></option>
</select>
</div>


<div class="toleft">
<span><?php echo pvs_word_lang( "content type" )?>:</span>
<select name="pub_ctype" style="width:120px" class="ft">
<option value="all"><?php echo pvs_word_lang( "all" )?></option>
<?php
$sql = "select name from " . PVS_DB_PREFIX . "content_type order by priority";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$sel = "";
	if ( $pub_ctype == $ds->row["name"] ) {
		$sel = "selected";
	}
?>
	<option value="<?php echo $ds->row["name"] ?>" <?php echo $sel
?>><?php echo $ds->row["name"] ?></option>
	<?php
	$ds->movenext();
}
?>
</select>
</div>



<div class="toleft">
<span><a href="<?php
echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=filter"><?php echo pvs_word_lang( "filter" )?></a>:</span>
<select name="filter" style="width:70px" class="ft">
<option value="no" <?php
if ( $filter == "no" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "no" )?></option>
<option value="yes" <?php
if ( $filter == "yes" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "yes" )?></option>
</select>
</div>

<div class="toleft">
<span><?php echo pvs_word_lang( "item" )?>:</span>
<select name="items" style="width:70px" class="ft">
<?php
for ( $i = 0; $i < count( $items_mass ); $i++ ) {
	$sel = "";
	if ( $items_mass[$i] == $items ) {
		$sel = "selected";
	}
?>
<option value="<?php echo $items_mass[$i] ?>" <?php echo $sel
?>><?php echo $items_mass[$i] ?></option>
<?php
}
?>

</select>
</div>

<div class="toleft">
<span>&nbsp;</span>
<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "search" )?>">
</div>

<div class="toleft_clear"></div>
</form>


</div>

<div class="row">
	<div class="col-md-2">
		<div class="input-group" style="margin-top:18px">
		  <div class="input-group-btn">
			<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&view=table&str=<?php echo ( $str . "&" . $var_search . $var_sort );
?>" class="btn btn-<?php
if ( $view == 'table' ) {
	echo ( 'primary' );
} else
{
	echo ( 'default' );
}
?>"><i class="fa fa-th-list" aria-hidden="true"></i></a>
			<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&view=grid&str=<?php echo ( $str . "&" . $var_search . $var_sort );
?>" class="btn btn-<?php
if ( $view == 'grid' ) {
	echo ( 'primary' );
} else
{
	echo ( 'default' );
}
?>"><i class="fa fa-th" aria-hidden="true"></i></a>
		  </div>
		</div>
	</div>
	<div class="col-md-10">
		<div style="float:right;">
			<?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'catalog/index.php' ), "&" . $var_search .
	$var_sort, false, $flag_show_end ) );
?>
		</div>
	</div>
</div>

<script language="javascript">
function publications_select_all() {
    if($("#form_selector").prop("checked"))
   	{
        $("input:checkbox").attr("checked",true);
    }
    else
    {
        $("input:checkbox").attr("checked",false);
    }
}
</script>


<?php
if ( ! $rs->eof ) {
?>






<form method="post" action="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="edit">

<?php
	if ( $view == 'table' ) {
?>
	<br><table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th width="5%"><input type="checkbox"  id="form_selector" value="1" onClick="publications_select_all();"></th>
	<th width="5%" class="hidden-phone hidden-tablet">
	<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&<?php echo $var_search
?>&aid=<?php
		if ( $aid == 2 ) {
			echo ( 1 );
		} else {
			echo ( 2 );
		}
?>&view=table">ID</a> <?php
		if ( $aid == 1 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_up.gif" width="11" height="8"><?php
		}
?><?php
		if ( $aid == 2 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_down.gif" width="11" height="8"><?php
		}
?>
	</th>
	<th width="15%"><?php echo pvs_word_lang( "image" )?></th>
	<th width="10%" class="hidden-phone hidden-tablet">
	
	
	<?php echo pvs_word_lang( "title" )?>
	
	</th>
	
	<th class="hidden-phone hidden-tablet">
	<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&<?php echo $var_search
?>&adate=<?php
		if ( $adate == 2 ) {
			echo ( 1 );
		} else {
			echo ( 2 );
		}
?>&view=table"><?php echo pvs_word_lang( "date" )?></a> <?php
		if ( $adate == 1 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_up.gif" width="11" height="8"><?php
		}
?><?php
		if ( $adate == 2 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_down.gif" width="11" height="8"><?php
		}
?>
	
	</th>
	<th class="hidden-phone hidden-tablet">
	
	<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&<?php echo $var_search
?>&aviewed=<?php
		if ( $aviewed == 2 ) {
			echo ( 1 );
		} else {
			echo ( 2 );
		}
?>&view=table"><?php echo pvs_word_lang( "viewed" )?></a> <?php
		if ( $aviewed == 1 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_up.gif" width="11" height="8"><?php
		}
?><?php
		if ( $aviewed == 2 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_down.gif" width="11" height="8"><?php
		}
?>
	
	</th>
	<th class="hidden-phone hidden-tablet">
	
	<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&<?php echo $var_search
?>&adownloads=<?php
		if ( $adownloads == 2 ) {
			echo ( 1 );
		} else {
			echo ( 2 );
		}
?>&view=table"><?php echo pvs_word_lang( "downloads" )?></a> <?php
		if ( $adownloads == 1 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_up.gif" width="11" height="8"><?php
		}
?><?php
		if ( $adownloads == 2 ) {
?><img src="<?php
			echo pvs_plugins_url()?>/assets/images/sort_down.gif" width="11" height="8"><?php
		}
?>
	
	</th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "type" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "author" )?></th>
	<th></th>
	<th></th>
	<th></th>
	</tr>
	</thead>
	<?php
		while ( ! $rs->eof ) {
?>
		<tr valign="top">
		<td><input type="checkbox" name="sel<?php
			echo $rs->row["id"] ?>" id="sel<?php
			echo $rs->row["id"] ?>"></td>
		<td class="hidden-phone hidden-tablet"><?php
			echo $rs->row["id"] ?></td>
		<td class='preview_img'><?php
			//Define preview
			$generated = "";

			if ( pvs_media_type ($rs->row["media_id"]) == 'photo' )
			{
				$item_img = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"],
					$rs->row["id"] );
				$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "photo", $rs->row["server1"],
					"", "" );
			}
			if ( pvs_media_type ($rs->row["media_id"]) == 'video' )
			{
				if ( $pvs_global_settings["ffmpeg_cron"] )
				{
					$sql = "select data1 from " . PVS_DB_PREFIX . "ffmpeg_cron where id=" . $rs->
						row["id"] . " and data2=0";
					$ds->open( $sql );
					if ( ! $ds->eof )
					{
						$generated = pvs_word_lang( "Previews are being created. Queue number is" );

						$queue = 1;
						$sql = "select count(id) as queue_count from " . PVS_DB_PREFIX .
							"ffmpeg_cron where data1<" . $ds->row["data1"] . " and data2=0";
						$dr->open( $sql );
						if ( ! $dr->eof )
						{
							$queue = $dr->row["queue_count"];
						}

						$generated .= " <b>" . $queue . "</b>";
					}
				}

				$item_img = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
					$rs->row["id"] );
				$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "video", $rs->row["server1"],
					"", "" );
			}
			if ( pvs_media_type ($rs->row["media_id"]) == 'audio' )
			{
				$item_img = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
					$rs->row["id"] );
				$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "audio", $rs->row["server1"],
					"", "" );
			}
			if ( pvs_media_type ($rs->row["media_id"]) == 'vector' )
			{
				$item_img = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
					$rs->row["id"] );
				$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "vector", $rs->row["server1"],
					"", "" );
			}
?>
		<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id"] ?>"><img src="<?php
			echo $item_img
?>" border="0" <?php
			echo $hoverbox_results["hover"] ?>></a>
		</td>
		<td class="hidden-phone hidden-tablet"><div class="link_file"><a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id"] ?>"><?php
			echo $rs->row["title"] ?></a></div><small><?php
			echo $generated
?></small></td>
		<td class="hidden-phone hidden-tablet gray"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
		<td class="hidden-phone hidden-tablet"><?php
			echo $rs->row["viewed"] ?></td>
		<td class="hidden-phone hidden-tablet"><a href="<?php echo(pvs_plugins_admin_url('downloads/index.php'));?>&search=<?php
			echo $rs->row["id"] ?>&search_type=file"><?php
			echo $rs->row["downloaded"] ?></a></td>
		<td class="hidden-phone hidden-tablet">
		<?php
			echo ( pvs_word_lang( pvs_media_type ($rs->row["media_id"]) ) );
		?>
		</td>
		
		<td class="hidden-phone hidden-tablet"><div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo pvs_user_login_to_id( $rs->row["author"] )?>"><?php
			echo $rs->row["author"] ?></a></div></td>
		<td>
			<?php
			if ( $rs->row["published"] == 1 )
			{
?>
				<div class="link_preview"><a href="<?php
				echo pvs_item_url( $rs->row["id"], $rs->row["url"] )?>"><?php
				echo pvs_word_lang( "preview" )?></a></div>
			<?php
			}
			if ( $rs->row["published"] == 0 )
			{
?>
				<span class="label label-important"><?php
				echo pvs_word_lang( "pending" )?></span>
			<?php
			}
			if ( $rs->row["published"] == -1 and $rs->row["exclusive"] == 0 )
			{
?>
				<span class="label label-inverse"><?php
				echo pvs_word_lang( "declined" )?></span>
			<?php
			}
			if ( $rs->row["published"] == -1 and $rs->row["exclusive"] == 1 )
			{
?>
				<span class="label label-success"><?php
				echo pvs_word_lang( "sold" )?></span>
			<?php
			}
?>
		</td>
		<td><div class="link_edit"><a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id"] ?>"><?php
			echo pvs_word_lang( "edit" )?></a></div></td>
		<td><div class="link_delete"><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=delete&id=<?php
			echo $rs->row["id"] ?>&<?php
			echo $var_search . $var_sort
?>"  onClick="return confirm('<?php
			echo pvs_word_lang( "delete" )?>?');"><?php
			echo pvs_word_lang( "delete" )?></a></div></td>
		</tr>
		<?php
			$n++;
			$rs->movenext();
		}
?>
	</table>
	<?php
	} else {
		if ( ! $rs->eof ) {
?>
		<div style="margin:10px 0px 10px 0px"><input type="checkbox"  id="form_selector" value="1" onClick="publications_select_all();"> <?php echo(pvs_word_lang("Select all"));
?></div><div class="row">
		<?php
			while ( ! $rs->eof )
			{
?>
			<div class="col-md-3" style="height:300px">
				<?php
				//Define preview
				$icon = "";

				if ( pvs_media_type ($rs->row["media_id"]) == 'photo' )
				{
					$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "photo", $rs->row["server1"],
						"", "" );
					$icon = '<i class="icon-camera icon-white fa fa-photo"></i>';
				}
				if ( pvs_media_type ($rs->row["media_id"]) == 'video' )
				{
					$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "video", $rs->row["server1"],
						"", "" );
					$icon = '<i class="icon-film icon-white fa fa-film"></i>';
				}
				if ( pvs_media_type ($rs->row["media_id"]) == 'audio' )
				{
					$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "audio", $rs->row["server1"],
						"", "" );
					$icon = '<i class="icon-music icon-white fa fa-music"></i>';
				}
				if ( pvs_media_type ($rs->row["media_id"]) == 'vector' )
				{
					$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "vector", $rs->row["server1"],
						"", "" );
					$icon = '<i class="icon-picture icon-white fa fa-leaf"></i>';
				}

?>
				
				<div style="background:url('<?php
				echo $hoverbox_results["flow_image"] ?>');background-size:cover;background-repeat:no-repeat;background-position:center center;height:200px;cursor:pointer" onClick="location.href='<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
				echo $rs->row["id"] ?>'" <?php
				echo $hoverbox_results["hover"] ?>>
				</div>
				<div class="catalog_id"><input type="checkbox" name="sel<?php
			echo $rs->row["id"] ?>" id="sel<?php
			echo $rs->row["id"] ?>"> <?php
				echo $icon . ' ' . $rs->row["id"] ?></div>
				<div class="catalog_title"><a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
				echo $rs->row["id"] ?>"><?php
				echo substr($rs->row["title"], 0, 45) ?></a></div>
				<div class="catalog_grid">
					<?php
				if ( $rs->row["published"] == 1 )
				{
?>
						<a href="<?php
					echo pvs_item_url( $rs->row["id"], $rs->row["url"] )?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
					<?php
				}
				if ( $rs->row["published"] == 0 )
				{
?>
						<span class="label label-danger"><?php
					echo pvs_word_lang( "pending" )?></span>
					<?php
				}
				if ( $rs->row["published"] == -1 and $rs->row["exclusive"] == 0 )
				{
?>
						<span class="label label-warning"><?php
					echo pvs_word_lang( "declined" )?></span>
					<?php
				}
				if ( $rs->row["published"] == -1 and $rs->row["exclusive"] == 1 )
				{
?>
						<span class="label label-success"><?php
					echo pvs_word_lang( "sold" )?></span>
					<?php
				}
?>
					<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
				echo $rs->row["id"] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
					<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=delete&id=<?php
				echo $rs->row["id"] ?>&<?php
				echo $var_search . $var_sort
?>"  onClick="return confirm('<?php
				echo pvs_word_lang( "delete" )?>?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</div>
			</div>
			<?php
				$n++;

				if ( $n % 4 == 0 )
				{
					echo ( "</div>	<div class='row'>" );
				}

				$rs->movenext();
			}
?>
		</div>
		<?php
		}
	}
?>


<div style="padding-top:30px;float:right"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2,pvs_plugins_admin_url( 'catalog/index.php' ), "&" . $var_search .
		$var_sort, false, $flag_show_end ) );
?></div>






<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">


<div id="actions">
	<input type="hidden" name="formaction" id="formaction" value="delete_publication">
	<input type="submit" class="btn btn-danger" onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');" value="<?php echo pvs_word_lang( "delete" )?>" >&nbsp;&nbsp;<?php echo pvs_word_lang( "or" )?>&nbsp;&nbsp;<div class="btn-group dropup">
    <a class="btn btn-primary" href="#"><?php echo pvs_word_lang( "select action" )?></a>
    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
    <ul class="dropdown-menu">
    		<li><a href="javascript:bulk_action('change_publication');"><i class="icon-edit"></i> <?php echo pvs_word_lang( "edit" )?></a></li>
    		
    		<li><a href="javascript:bulk_action('bulk_change_publication');"><i class="icon-tasks"></i> <?php echo pvs_word_lang( "Bulk change titles, keywords, description" )?></a></li>
    		
    		<li><a href="javascript:bulk_action('bulk_keywords_publication');"><i class="icon-tags"></i> <?php echo pvs_word_lang( "Bulk add/remove keywords" )?></a></li>
			
			<?php
	if ( $pvs_global_settings["allow_photo"] ) {
?>
				<li><a href="javascript:bulk_action('thumbs_publication');"><i class="icon-refresh"></i> <?php echo pvs_word_lang( "regenerate thumbs" )?></a></li>
			<?php
	}
?>
			
			<li><a href="javascript:bulk_action('content_publication');"><i class="icon-th"></i> <?php echo pvs_word_lang( "change content type" )?></a></li>
			
			<li><a href="javascript:bulk_action('move_publication');"><i class="icon-share-alt"></i> <?php echo pvs_word_lang( "move to category" )?></a></li>
			<li><a href="javascript:bulk_action('move_collection');"><i class="icon-share-alt"></i> <?php echo pvs_word_lang( "Assign to collection" )?></a></li>
			
			<li><a href="javascript:bulk_action('regenerate_urls');"><i class="icon-repeat"></i> <?php echo pvs_word_lang( "regenerate urls" )?></a></li>
			
			
			<li><a href="javascript:bulk_action('free_publication');"><i class="icon-download-alt"></i> <?php echo pvs_word_lang( "change files to free/paid" )?></a></li>
			
			<li><a href="javascript:bulk_action('featured_publication');"><i class="icon-thumbs-up"></i> <?php echo pvs_word_lang( "change files to featured" )?></a></li>
			
			<?php
	if ( $pvs_global_settings["allow_photo"] ) {
?>
				<li><a href="javascript:bulk_action('editorial_publication');"><i class="icon-picture"></i> <?php echo pvs_word_lang( "change photos to editorial" )?></a></li>
			<?php
	}
?>
			
			<?php
	if ( $pvs_global_settings["adult_content"] ) {
?>
				<li><a href="javascript:bulk_action('adult_publication');"><i class="icon-user"></i> <?php echo pvs_word_lang( "change files to adult" )?></a></li>
			<?php
	}
?>
			
			<?php
	if ( $pvs_global_settings["exclusive_price"] ) {
?>
				<li><a href="javascript:bulk_action('exclusive_publication');"><i class="icon-gift"></i> <?php echo pvs_word_lang( "change files to exclusive" )?></a></li>
			<?php
	}
?>
			
			<?php
	if ( $pvs_global_settings["contacts_price"] ) {
?>
				<li><a href="javascript:bulk_action('contacts_publication');"><i class="icon-envelope"></i> <?php echo pvs_word_lang( "change files to 'contact us to get the price'" )?></a></li>
			<?php
	}
?>
			
			<li><a href="javascript:bulk_action('approve_publication');"><i class="icon-ok"></i> <?php echo pvs_word_lang( "approve" )?>/<?php echo pvs_word_lang( "decline" )?></a></li>
			
			<?php
	if ( $pvs_global_settings["rights_managed"] ) {
?>
				<li><a href="javascript:bulk_action('rights_managed');"><i class="icon-list-alt"></i> <?php echo pvs_word_lang( "change rights-managed price" )?></a></li>
			<?php
	}
?>
    </ul>
    </div>
	
	
</div>


		</div>
	</div>

</form>

<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>

<?php
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>