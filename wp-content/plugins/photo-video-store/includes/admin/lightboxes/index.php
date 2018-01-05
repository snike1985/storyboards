<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_lightboxes" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );


//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
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
} else {
?>

<h1><?php echo pvs_word_lang( "lightboxes" )?></h1>



<?php
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

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
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
		$com = " order by id_parent ";
	}
	if ( $aid == 2 ) {
		$com = " order by id_parent desc ";
	}
}

$com = " order by catalog desc,title";

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

	if ( $search_type == "user" ) {
		$sql = "select id_parent from " . PVS_DB_PREFIX . "lightboxes_admin where user=" .
			pvs_user_login_to_id( pvs_result( $search ) );
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			while ( ! $rs->eof )
			{
				if ( $com2 != "" )
				{
					$com2 .= " or ";
				}
				$com2 .= " id=" . $rs->row["id_parent"] . " ";
				$rs->movenext();
			}
			$com2 = " and (" . $com2 . ") ";
		}
	}
	if ( $search_type == "lightbox" ) {
		$com2 .= " and title like '%" . pvs_result( $search ) . "%' ";
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

$sql = "select id,title,catalog from " . PVS_DB_PREFIX .
	"lightboxes where id>0 ";

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


<form method="post">
<div class="toleft">
<span><?php echo pvs_word_lang( "search" )?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="ft" value="<?php echo $search
?>" onClick="this.value=''">
<select name="search_type" style="width:150px;display:inline" class="ft">
<option value="lightbox" <?php
if ( $search_type == "lightbox" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "lightboxes" )?></option>
<option value="user" <?php
if ( $search_type == "user" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "user" )?></option>


</select>
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


<div style="padding:0px 9px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('lightboxes/index.php'), "&" . $var_search .
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



<form method="post" action="<?php echo(pvs_plugins_admin_url('lightboxes/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>



<th><?php echo pvs_word_lang( "title" )?></th>
<th><?php echo pvs_word_lang( "files" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "administrators" )?></th>
<th></th>

</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {
		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_lightboxes_id"] ) and ! isset( $_SESSION["admin_rows_lightboxes" .
			$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_lightboxes_id"] ) {
			$cl3 = "<span class='label label-danger lightboxes" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('lightboxes" . $rs->row["id"] . "')\"";
		}
?>
<tr valign="top" <?php echo $cl_script
?>>
<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
<td><div class="link_lightbox"><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&search=<?php echo $rs->row["title"] ?>&search_type=lightbox"><?php echo $rs->row["title"] ?></a> 
<?php
		if ( $rs->row["catalog"] == 1 ) {
?>&nbsp;&nbsp;&nbsp;<span class="label label-warning"><?php
			echo pvs_word_lang( "visible in catalog" )?></span><?php
		}
?> <?php echo $cl3
?></div></td>
<td><div class="link_file">
<a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&search=<?php echo $rs->row["title"] ?>&search_type=lightbox"><?php echo pvs_count_files_in_lightbox($rs->row["id"]); 
?></a></div>
</td>
<td class="hidden-phone hidden-tablet"><div class="link_user">
<?php
		$lightbox_admin = "";
		$sql = "select user,user_owner from " . PVS_DB_PREFIX .
			"lightboxes_admin where id_parent=" . $rs->row["id"] .
			" order by user_owner desc";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
			$user_name = "";
			$sql = "select user_login from " . $table_prefix . "users where ID=" . $dr->
				row["user"];
			$dn->open( $sql );
			if ( ! $dn->eof )
			{
				$user_name = $dn->row["user_login"];
			}

			if ( $lightbox_admin != "" )
			{
				$lightbox_admin .= ", ";
			}

			if ( $dr->row["user_owner"] == 1 )
			{
				$lightbox_admin .= "<a href='" . pvs_plugins_admin_url('customers/index.php') . "&action=content&id=" . $dr->row["user"] .
					"'><b>" . $user_name . "</b></a>";
			} else
			{
				$lightbox_admin .= "<a href='" . pvs_plugins_admin_url('customers/index.php') . "&action=content&id=" . $dr->row["user"] .
					"'>" . $user_name . "</a>";
			}

			$dr->movenext();
		}
		echo ( $lightbox_admin );
?>
</div>
</td>


<td>
<div class="link_edit">
<a href="<?php echo(pvs_plugins_admin_url('lightboxes/index.php'));?>&action=content&id=<?php echo $rs->row["id"] ?>"><?php echo pvs_word_lang( "edit" )?></a>
</div>
</td>


</tr>
<?php
		$n++;
		
		$rs->movenext();
	}
?>
</table>


<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "delete" )?>"  style="margin:15px 0px 0px 6px;">






</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('lightboxes/index.php'), "&" . $var_search .
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