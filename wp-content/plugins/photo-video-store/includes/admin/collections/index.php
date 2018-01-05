<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_collections" );

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

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

//Delete thumb
if ( @$_REQUEST["action"] == 'delete_thumb' )
{
	include ( "delete_thumb.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>

<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'collections/index.php' ) );
?>&action=content"><i class="icon-print icon-white fa fa-plus"></i>&nbsp; <?php echo pvs_word_lang( "add" )?></a>
<h1><?php echo pvs_word_lang( "Collections" )?></h1>

<script>
function pvs_collection_status(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_collection_status&id=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			$('#status' + value).html(data);
		}
	});
}
</script>


<?php
//Get Search
$search = "";
if ( isset( $_REQUEST["search"] ) ) {
	$search = pvs_result( $_REQUEST["search"] );
}





//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}


//Search variable
$var_search = "search=" . $search . "&items=" .
	$items;

//Sort by date
$adate = 0;
if ( isset( $_GET["adate"] ) ) {
	$adate = ( int )$_GET["adate"];
}

//Sort by ID
$aid = 0;
if ( isset( $_GET["aid"] ) ) {
	$aid = ( int )$_GET["aid"];
}

//Sort by default
if ( $adate == 0 and $aid == 0 ) {
	$adate = 2;
}

//Add sort variable
$com = "";

if ( $adate != 0 ) {
	$var_sort = "&adate=" . $adate;
	if ( $adate == 1 ) {
		$com = " order by data ";
	}
	if ( $adate == 2 ) {
		$com = " order by data desc ";
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

$com = " order by title";

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
	$com2 .= " and title like '%" . pvs_result( $search ) . "%' ";
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

$sql = "select id,title,description,active,types,price from " . PVS_DB_PREFIX .
	"collections where id>0 ";

$sql .= $com2 . $com;

$rs->open( $sql );
$record_count = $rs->rc;

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql .= $lm;

//echo($sql);
$rs->open( $sql );
?>
<div id="catalog_menu">


<form method="post" action="<?php
			echo ( pvs_plugins_admin_url( 'collections/index.php' ) );
?>" style="margin:0px">
<div class="toleft">
<span><?php echo pvs_word_lang( "search" )?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="ft" value="<?php echo $search
?>" onClick="this.value=''">
</div>

















<div class="toleft">
<span><?php echo pvs_word_lang( "page" )?>:</span>
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



<?php
if ( ! $rs->eof ) {
?>


<div style="padding:0px 9px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('collections/index.php'), "&" . $var_search .
		$var_sort ) );
?></div>

<script language="javascript">
function publications_select_all(sel_form) {
    if(sel_form.selector.checked)
   	{
        $("input:checkbox", sel_form).attr("checked",true);
    }
    else
    {
        $("input:checkbox", sel_form).attr("checked",false);
    }
}
</script>



<form method="post"  id="adminform" name="adminform">
<input type="hidden" name="action" value="change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><?php echo pvs_word_lang( "title" )?></th>
<th><?php echo pvs_word_lang( "price" )?></th>
<th><?php echo pvs_word_lang( "files" )?></th>
<th><?php echo pvs_word_lang( "status" )?></th>
<th></th>
<th></th>
</tr>
</thead>
<?php
	while ( ! $rs->eof ) {
?>
<tr valign="top">
<td>
<input type="text" name="title<?php echo $rs->row["id"]; ?>" value="<?php echo $rs->row["title"]; ?>">
</td>
<td>
<input type="text" name="price<?php echo $rs->row["id"]; ?>" value="<?php echo $rs->row["price"]; ?>" style="width:100px">
</td>
<td><div class="link_file">
<a href="<?php
	echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&search=<?php echo $rs->row["title"] ?>&search_type=collection"><?php echo pvs_count_files_in_collection($rs->row["id"]);
?></a></div>
</td>
<td>

<?php
$cl = "success";
if ( $rs->row["active"] != 1 ) {
	$cl = "danger";
}
?>
<div id="status<?php
			echo $rs->row["id"] ?>" name="status<?php
			echo $rs->row["id"] ?>"><a href="javascript:pvs_collection_status(<?php
			echo $rs->row["id"] ?>);"><span class="label label-<?php
			echo $cl
?>"><?php
			if ( $rs->row["active"] == 1 ) {
				echo ( pvs_word_lang( "active" ) );
			} else {
				echo ( pvs_word_lang( "pending" ) );
			}
?></span></a></div>
</td>


<td>
<div class="link_edit">
<a href="<?php
			echo ( pvs_plugins_admin_url( 'collections/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id"]
?>"><?php echo pvs_word_lang( "edit" )?></a>
</div>
</td>
<td>
<div class="link_delete">
<a href="<?php
			echo ( pvs_plugins_admin_url( 'collections/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id"]
?>" onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');"><?php echo pvs_word_lang( "delete" )?></a>
</div>
</td>


</tr>
<?php
		$n++;
		$rs->movenext();
	}
?>
</table>


<input type="submit" class="btn btn-success" value="<?php echo pvs_word_lang( "save" )?>"  style="margin:15px 0px 0px 6px;">






</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('collections/index.php'), "&" . $var_search .
		$var_sort ) );
?></div>
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