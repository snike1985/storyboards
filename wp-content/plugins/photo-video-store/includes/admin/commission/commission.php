<?php
//Check access
pvs_admin_panel_access( "orders_commission" );
?>















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

//Get commission type
$commission_type = "";
if ( isset( $_GET["commission_type"] ) ) {
	$commission_type = pvs_result( $_GET["commission_type"] );
}
if ( isset( $_POST["commission_type"] ) ) {
	$commission_type = pvs_result( $_POST["commission_type"] );
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
$var_search = "&d=1&search=" . $search . "&search_type=" . $search_type .
	"&items=" . $items . "&pub_type=" . $pub_type . "&commission_type=" . $commission_type;

//Sort by date
$adate = 2;
if ( isset( $_GET["adate"] ) ) {
	$adate = ( int )$_GET["adate"];
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
		$com2 .= " and orderid=" . ( int )$search . " ";
	}
	if ( $search_type == "login" ) {
		$com2 .= " and user = " . pvs_user_login_to_id( $search );
	}
	if ( $search_type == "id_file" ) {
		$com2 .= " and publication = '" . ( int )$search . "' ";
	}

}

if ( $pub_type == "plus" ) {
	$com2 .= " and total>0 ";
}
if ( $pub_type == "minus" ) {
	$com2 .= " and total<0 ";
}

if ( $commission_type == "order" ) {
	$com2 .= " and description='order' ";
}
if ( $commission_type == "subscription" ) {
	$com2 .= " and description='subscription' ";
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

$sql = "select id,total,user,orderid,item,publication,types,data,gateway,description from " .
	PVS_DB_PREFIX . "commission where status=1 ";

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


<form method="post" action="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&d=1" style="margin:0px">
<div class="toleft">
<span><?php echo pvs_word_lang( "search" )?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="ft" value="<?php echo $search
?>" onClick="this.value=''">
<select name="search_type" style="width:100px;display:inline" class="ft">
<option value="login" <?php
if ( $search_type == "login" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "login" )?></option>
<option value="id" <?php
if ( $search_type == "id" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "order" )?> ID</option>
<option value="id_file" <?php
if ( $search_type == "id_file" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "file" )?> ID</option>

</select>
</div>










<div class="toleft">
<span><?php echo pvs_word_lang( "total" )?>:</span>
<select name="pub_type" style="width:150px" class="ft">
<option value="all"><?php echo pvs_word_lang( "all" )?></option>
<option value="plus" <?php
if ( $pub_type == "plus" ) {
	echo ( "selected" );
}
?>>+ <?php echo pvs_word_lang( "earning" )?></option>
<option value="minus" <?php
if ( $pub_type == "minus" ) {
	echo ( "selected" );
}
?>>- <?php echo pvs_word_lang( "refund" )?></option>
</select>
</div>


<div class="toleft">
<span><?php echo pvs_word_lang( "type" )?>:</span>
<select name="commission_type" style="width:200px" class="ft">
<option value=""><?php echo pvs_word_lang( "all" )?></option>
<option value="order" <?php
if ( $commission_type == "order" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "order" )?></option>
<option value="subscription" <?php
if ( $commission_type == "subscription" ) {
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


<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('commission/index.php'), "&" . $var_search .
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



<form method="post" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="commission_delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th><?php echo pvs_word_lang( "order" )?> ID</th>
<th><?php echo pvs_word_lang( "seller" )?></th>
<th><?php
	if ( $commission_type != "minus" ) {
		echo ( pvs_word_lang( "commission" ) );
	}
?><?php
	if ( $commission_type == "" ) {
		echo ( " / " );
	}
?><?php
	if ( $commission_type != "plus" ) {
		echo ( pvs_word_lang( "refund" ) );
	}
?></th>



<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&<?php echo $var_search
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


<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "file" )?> ID</th>


</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {

		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_commission_id"] ) and ! isset( $_SESSION["admin_rows_commission" .
			$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_commission_id"] ) {
			$cl3 = "<span class='label label-danger commission" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('commission" . $rs->row["id"] .
				"')\"";
		}
?>
<tr valign="top" <?php echo $cl_script
?>>
<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
<td>
<?php
		if ( $rs->row["total"] > 0 ) {
			if ( $rs->row["description"] == "subscription" )
			{
?>
		<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>&action=edit&id=<?php
				echo $rs->row["orderid"] ?>"><?php
				echo pvs_word_lang( "subscription" )?> # <?php
				echo $rs->row["orderid"] ?></a> <?php echo $cl3
?></div>
		<?php
			} else
			{
?>
		<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&action=order_content&id=<?php
				echo $rs->row["orderid"] ?>"><?php
				echo pvs_word_lang( "order" )?> # <?php
				echo $rs->row["orderid"] ?></a> <?php echo $cl3
?></div>
		<?php
			}
		} else {
			echo ( "<div class='link_payout'>" . pvs_word_lang( "refund" ) . "</div>" );
		}
?>
</td>

<td><div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user"] )?></a></div></td>

<td><span class="price"><b><?php echo pvs_currency( 1, true, "credit" );
?><?php echo pvs_price_format( $rs->row["total"], 2 )?> <?php echo pvs_currency( 2, true, "credit" );
?></b></span></td>


<td class="gray hidden-phone hidden-tablet"><?php echo date( date_format, $rs->row["data"] )?></td>

<td class="hidden-phone hidden-tablet">
<?php
		if ( $rs->row["total"] > 0 ) {
			if ($rs->row["types"] == 'prints_items') {
				?>
				<div class="link_file"><a href="<?php echo(pvs_plugins_admin_url('prints/index.php'));?>&action=content&id=<?php
				echo $rs->row["publication"] ?>"><?php
				echo pvs_word_lang('prints') ?> #<?php
				echo $rs->row["publication"] ?></a></div>
				<?php
			} else {
				?>
				<div class="link_file"><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
				echo $rs->row["publication"] ?>"><?php
				echo pvs_word_lang('file') ?> #<?php
				echo $rs->row["publication"] ?></a></div>
				<?php			
			}
		} else {
?>
	&mdash;
	<?php
		}
?>
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
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('commission/index.php'), "&" . $var_search .
		$var_sort ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>































