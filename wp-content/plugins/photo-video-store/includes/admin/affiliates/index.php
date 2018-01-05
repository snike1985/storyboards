<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_stats" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}
?>





<h1><?php echo pvs_word_lang( "affiliates" )?>:</h1>








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

//Get pub_type
$pub_type = "all";
if ( isset( $_REQUEST["pub_type"] ) ) {
	$pub_type = pvs_result( $_REQUEST["pub_type"] );
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
	$items . "&pub_type=" . $pub_type;

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

	if ( $search_type == "id" ) {
		$com2 .= " and types_id=" . ( int )$search . " ";
	}
	if ( $search_type == "user" ) {
		$com2 .= " and userid = " . pvs_user_login_to_id( $search ) . " ";
	}
	if ( $search_type == "affiliate" ) {
		$com2 .= " and aff_referal = " . pvs_user_login_to_id( $search ) . " ";
	}

}

if ( $pub_type == "order" ) {
	$com2 .= " and types='orders' ";
}
if ( $pub_type == "credits" ) {
	$com2 .= " and types='credits' ";
}
if ( $pub_type == "subscription" ) {
	$com2 .= " and types='subscription' ";
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

$sql = "select userid,types,types_id,rates,total,data,aff_referal from " .
	PVS_DB_PREFIX . "affiliates_signups where total>0 ";

$sql .= $com2 . $com;
//echo($sql);
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
<option value="affiliate" <?php
if ( $search_type == "affiliate" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "affiliate" )?></option>
<option value="user" <?php
if ( $search_type == "user" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "user" )?></option>
<option value="id" <?php
if ( $search_type == "id" ) {
	echo ( "selected" );
}
?>>Order ID</option>

</select>
</div>










<div class="toleft">
<span><?php echo pvs_word_lang( "type" )?>:</span>
<select name="pub_type" style="width:150px" class="ft">
<option value="all"><?php echo pvs_word_lang( "all" )?></option>
<option value="order" <?php
if ( $pub_type == "order" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "order" )?></option>
<option value="credits" <?php
if ( $pub_type == "credits" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "credits" )?></option>
<option value="subscription" <?php
if ( $pub_type == "subscription" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "subscription" )?></option>

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


<div style="padding: 0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('affiliates/index.php'), "&" . $var_search .
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


<form method="post" action="<?php echo(pvs_plugins_admin_url('affiliates/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th><?php echo pvs_word_lang( "affiliate" )?></th>
<th><?php echo pvs_word_lang( "total" )?></th>
<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('affiliates/index.php'));?>&<?php echo $var_search
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
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "title" )?></th>
<th><?php echo pvs_word_lang( "user" )?></th>




	
</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {
?>
<tr valign="top">


<td><input type="checkbox" name="sel<?php echo $rs->row["userid"] ?>_<?php echo $rs->row["data"] ?>_<?php echo $rs->row["types_id"] ?>"></td>

<td><div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["aff_referal"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["aff_referal"] )?></a></div></td>
<td><span class="price"><b><?php echo pvs_currency( 1, true, "credit" );
?><?php echo pvs_price_format( $rs->row["total"], 2 )?> <?php echo pvs_currency( 2, true, "credit" );
?></b></span> (<?php echo $rs->row["rates"] ?>%)</td>
<td class="gray hidden-phone hidden-tablet"><?php echo date( date_format, $rs->row["data"] )?></td>
<td class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( $rs->row["types"] )?> #<?php echo $rs->row["types_id"] ?></td>
<td>

<div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["userid"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["userid"] )?></a></div>


</td>





</tr>
<?php
		
		$n++;
		$rs->movenext();
	}
?>
</table>



<input type="submit" value="<?php echo pvs_word_lang( "delete" )?>" style="margin:10px 0px 0px 6px" class="btn btn-danger">


</form>


<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('affiliates/index.php'), "&" . $var_search .
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