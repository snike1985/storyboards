<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_documents" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}
?>





<script>


function pvs_document_status(fid,fdo) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_document_status&fid=' + fid + '&fdo=' + fdo,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+fid).innerHTML = data;
		}
	});
}
</script>





<h1><?php echo pvs_word_lang( "Documents" )?>:</h1>







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

//Get Status
$status = 2;
if ( isset( $_REQUEST["status"] ) ) {
	$status = ( int )$_REQUEST["status"];
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
	$items . "&status=" . $status;

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
	$com2 .= " and user_id=" . pvs_user_login_to_id( $search ) . " ";
}

if ( $search_type != 0 ) {
	$com2 .= " and id_parent=" . ( int )$search_type . " ";
}

if ( $status != 2 ) {
	$com2 .= " and status=" . ( int )$status . " ";
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

$sql = "select id,title,status,comment,filename,data,user_id from " .
	PVS_DB_PREFIX . "documents where id>0 ";

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
	<span><?php echo pvs_word_lang( "login" )?>:</span>
	<input type="text" name="search" style="width:100px;display:inline" class="ft" value="<?php echo $search
?>" onClick="this.value=''">
</div>

<div class="toleft">
	<span><?php echo pvs_word_lang( "Documents types" )?>:</span>
	<select name="search_type" style="width:200px;display:inline" class="ft">
	<option value="0"><?php echo pvs_word_lang( "all" )?></option>
	<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"documents_types where enabled=1 order by priority";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$sel = "";
	if ( $search_type == $ds->row["id"] ) {
		$sel = "selected";
	}
?>
		<option value="<?php echo $ds->row["id"] ?>" <?php echo $sel
?>><?php echo $ds->row["title"] ?></option>
		<?php
	$ds->movenext();
}
?>
	</select>
</div>

<div class="toleft">
	<span><?php echo pvs_word_lang( "status" )?>:</span>
	<select name="status" style="width:150px;display:inline" class="ft">
	<option value="2"><?php echo pvs_word_lang( "all" )?></option>
	<option value="1" <?php
if ( $status == 1 ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "approved" )?></option>
	<option value="0" <?php
if ( $status == 0 ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "pending" )?></option>
	<option value="-1" <?php
if ( $status == -1 ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "declined" )?></option>

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


<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('documents/index.php'), "&" . $var_search .
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



<form method="post" action="<?php echo(pvs_plugins_admin_url('documents/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('documents/index.php'));?>&<?php echo $var_search
?>&aid=<?php
	if ( $aid == 2 ) {
		echo ( 1 );
	} else {
		echo ( 2 );
	}
?>">ID</a> <?php
	if ( $aid == 1 ) {
?><img src="<?php echo(pvs_plugins_url());?>/assets/images/sort_up.gif" width="11" height="8"><?php
	}
?><?php
	if ( $aid == 2 ) {
?><img src="<?php echo(pvs_plugins_url());?>/assets/images/sort_down.gif" width="11" height="8"><?php
	}
?>
</th>
<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('documents/index.php'));?>&<?php echo $var_search
?>&adate=<?php
	if ( $adate == 2 ) {
		echo ( 1 );
	} else {
		echo ( 2 );
	}
?>"><?php echo pvs_word_lang( "date" )?></a> <?php
	if ( $adate == 1 ) {
?><img src="<?php echo(pvs_plugins_url());?>/assets/images/sort_up.gif" width="11" height="8"><?php
	}
?><?php
	if ( $adate == 2 ) {
?><img src="<?php echo(pvs_plugins_url());?>/assets/images/sort_down.gif" width="11" height="8"><?php
	}
?>
</th>
<th><?php echo pvs_word_lang( "user" )?></th>
<th><?php echo pvs_word_lang( "Documents" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "file" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "size" )?></th>
<th><?php echo pvs_word_lang( "status" )?></th>




</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {
		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_documents_id"] ) and ! isset( $_SESSION["admin_rows_documents" .
			$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_documents_id"] ) {
			$cl3 = "<span class='label label-danger documents" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('documents" . $rs->row["id"] . "')\"";
		}

		$size = filesize( pvs_upload_dir() . "/content/users/doc_" .
			$rs->row["id"] . "_" . $rs->row["filename"] );
?>
<tr valign="top" <?php echo $cl_script
?>>
<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
<td class="hidden-phone hidden-tablet"><?php echo $rs->row["id"] ?> <?php echo $cl3
?></td>
<td class="gray hidden-phone hidden-tablet"><?php echo pvs_show_time_ago( $rs->row["data"] )?></td>
<td class="hidden-phone hidden-tablet"><div class="link_user">
<a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user_id"] )?></a>
</div>
</td>
<td><?php echo $rs->row["title"] ?></td>
<td class="hidden-phone hidden-tablet"><a href="<?php echo pvs_upload_dir('baseurl') . "/content/users/doc_" . $rs->row["id"] . "_" . $rs->row["filename"] ?>" target="blank"><?php echo $rs->row["filename"] ?></a></td>
<td class="hidden-phone hidden-tablet"><?php echo pvs_price_format( $size / ( 1024 * 1024 ), 3 ) . " Mb."
?></td>
<td>
<div id="status<?php echo $rs->row["id"] ?>">


<a href="javascript:pvs_document_status(<?php echo $rs->row["id"] ?>,1);" <?php
		if ( $rs->row["status"] != 1 ) {
?>class="gray"<?php
		}
?>><?php echo pvs_word_lang( "approved" )?></a><br>
<a href="javascript:pvs_document_status(<?php echo $rs->row["id"] ?>,0);" <?php
		if ( $rs->row["status"] != 0 ) {
?>class="gray"<?php
		}
?>><?php echo pvs_word_lang( "pending" )?></a><br>
<a href="javascript:pvs_document_status(<?php echo $rs->row["id"] ?>,-1);" <?php
		if ( $rs->row["status"] != -1 ) {
?>class="gray"<?php
		}
?>><?php echo pvs_word_lang( "declined" )?></a>



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
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('documents/index.php'), "&" . $var_search .
		$var_sort ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>