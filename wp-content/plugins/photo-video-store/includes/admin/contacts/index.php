<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "users_contacts" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>



<h1><?php echo pvs_word_lang( "contacts" )?>:</h1>



<?php
//Get Search
$search = "";
if ( isset( $_GET["search"] ) ) {
	$search = pvs_result( $_GET["search"] );
}
if ( isset( $_POST["search"] ) ) {
	$search = pvs_result( $_POST["search"] );
}

//Get Search type
$search_type = "";
if ( isset( $_GET["search_type"] ) ) {
	$search_type = pvs_result( $_GET["search_type"] );
}
if ( isset( $_POST["search_type"] ) ) {
	$search_type = pvs_result( $_POST["search_type"] );
}

//Items
$items = 30;
if ( isset( $_GET["items"] ) ) {
	$items = ( int )$_GET["items"];
}
if ( isset( $_POST["items"] ) ) {
	$items = ( int )$_POST["items"];
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

	if ( $search_type == "name" ) {
		$com2 .= " and name='" . pvs_result( $search ) . "' ";
	}
	if ( $search_type == "email" ) {
		$com2 .= " and email='" . pvs_result( $search ) . "' ";
	}
	if ( $search_type == "telephone" ) {
		$com2 .= " and telephone='" . pvs_result( $search ) . "' ";
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

$sql = "select id_parent,name,email,telephone,question,data,method from " .
	PVS_DB_PREFIX . "support where id_parent>0 ";

$sql .= $com2 . $com;

$rs->open( $sql );
$record_count = $rs->rc;

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql .= $lm;

//echo($sql);
$rs->open( $sql );?>
<div id="catalog_menu">


<form method="post">
<div class="toleft">
<span><?php echo pvs_word_lang( "search" )?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="ft" value="<?php echo $search
?>" onClick="this.value=''">
<select name="search_type" style="width:150px;display:inline" class="ft">
<option value="name" <?php
if ( $search_type == "name" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "name" )?></option>
<option value="email" <?php
if ( $search_type == "email" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "e-mail" )?></option>
<option value="telephone" <?php
if ( $search_type == "telephone" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "telephone" )?></option>

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


<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('contacts/index.php'), "&" . $var_search .
		$var_sort ) );?></div>

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



<form method="post" action="<?php echo(pvs_plugins_admin_url('contacts/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('contacts/index.php'));?>&<?php echo $var_search
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
<a href="<?php echo(pvs_plugins_admin_url('contacts/index.php'));?>&<?php echo $var_search
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
<th><?php echo pvs_word_lang( "name" )?></th>
<th><?php echo pvs_word_lang( "email" )?></th>
<th><?php echo pvs_word_lang( "telephone" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "contact method" )?></th>




<th width="35%"><?php echo pvs_word_lang( "content" )?></th>

</tr>
</thead>
<?php
	while ( ! $rs->eof ) {
		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_contacts_id"] ) and ! isset( $_SESSION["admin_rows_contacts" .
			$rs->row["id_parent"]] ) and $rs->row["id_parent"] > $_SESSION["user_contacts_id"] ) {
			$cl3 = "<span class='label label-danger contacts" . $rs->row["id_parent"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('contacts" . $rs->row["id_parent"] . "')\"";
		}
?>
<tr valign="top" <?php echo $cl_script
?>>
<td><input type="checkbox" name="sel<?php echo $rs->row["id_parent"] ?>" id="sel<?php echo $rs->row["id_parent"] ?>"></td>
<td class="hidden-phone hidden-tablet"><?php echo $rs->row["id_parent"] ?> <?php echo $cl3
?></td>
<td class="gray hidden-phone hidden-tablet"><?php echo pvs_show_time_ago( $rs->row["data"] )?></td>
<td><div class="link_user"><?php echo $rs->row["name"] ?></div></td>
<td><div class="link_email"><a href="mailto:<?php echo $rs->row["email"] ?>"><?php echo $rs->row["email"] ?></a></div></td>
<td><?php echo $rs->row["telephone"] ?></td>
<td class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( $rs->row["method"] )?></td>



<td><?php echo str_replace( "\n", "<br>", $rs->row["question"] )?></td>


</tr>
<?php
		$n++;
		$rs->movenext();
	}
?>
</table>


<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "delete" )?>"  style="margin:15px 0px 0px 6px;">






</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('contacts/index.php'), "&" . $var_search .
		$var_sort ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}

include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>