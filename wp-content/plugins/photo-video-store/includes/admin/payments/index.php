<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_payments" );


include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}
?>





<h1><?php echo pvs_word_lang( "payments" )?></h1>


<script>


</script>


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
	if ( $search_type == "from" ) {
		$com2 .= " and user='" . pvs_result( $search ) . "' ";
	}
	if ( $search_type == "id" ) {
		$com2 .= " and pid=" . ( int )$search . " ";
	}
	if ( $search_type == "ip" ) {
		$com2 .= " and tnumber='" . pvs_result( $search ) . "' ";
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

$sql = "select id_parent,user,data,total,ip,tnumber,ptype,pid,processor from " .
	PVS_DB_PREFIX . "payments where id_parent>0 ";

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
<option value="from" <?php
if ( $search_type == "from" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "user" )?></option>
<option value="id" <?php
if ( $search_type == "id" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "order" )?> ID</option>
<option value="transaction" <?php
if ( $search_type == "transaction" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "Transaction number" )?></option>
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


<div style="padding:0px 9px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('payments/index.php'), "&" . $var_search .
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



<form method="post" action="<?php echo(pvs_plugins_admin_url('payments/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('payments/index.php'));?>&<?php echo $var_search
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


<th><?php echo pvs_word_lang( "order" )?></th>
<th><?php echo pvs_word_lang( "Invoice" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "total" )?></th>
<th><?php echo pvs_word_lang( "user" )?></th>

<th><?php echo pvs_word_lang( "Payment method" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "Transaction number" )?></th>


<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "ip" )?></th>



</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {

		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_payments_id"] ) and ! isset( $_SESSION["admin_rows_payments" .
			$rs->row["id_parent"]] ) and $rs->row["id_parent"] > $_SESSION["user_payments_id"] and
			$_SESSION["user_payments_id"] > 0 ) {
			$cl3 = "<span class='label label-danger payments" . $rs->row["id_parent"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('payments" . $rs->row["id_parent"] .
				"')\"";
		}
?>
<tr valign="top" <?php echo $cl_script
?>>
<td><input type="checkbox" name="sel<?php echo $rs->row["id_parent"] ?>" id="sel<?php echo $rs->row["id_parent"] ?>"></td>
<td class="gray hidden-phone hidden-tablet"><?php echo date( datetime_format, $rs->row["data"] )?></td>

<td>
<?php
		if ( $rs->row["ptype"] == "order" ) {
?>
		<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&action=order_content&id=<?php
			echo $rs->row["pid"] ?>"><?php
			echo pvs_word_lang( "order" )?> #<?php
			echo $rs->row["pid"] ?></a> <?php echo $cl3
?></div>
	<?php
		}
		if ( $rs->row["ptype"] == "credits" ) {
?>
		<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>&search=<?php
			echo $rs->row["pid"] ?>&search_type=id"><?php
			echo pvs_word_lang( "credits" )?> #<?php
			echo $rs->row["pid"] ?></a> <?php echo $cl3
?></div>
	<?php
		}
		if ( $rs->row["ptype"] == "subscription" ) {
?>
		<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>&action=edit&id=<?php
			echo $rs->row["pid"] ?>"><?php
			echo pvs_word_lang( "subscription" )?> #<?php
			echo $rs->row["pid"] ?></a> <?php echo $cl3
?></div>
	<?php
		}
?>
</td>
<td>
<?php
		$sql = "select invoice_number from " . PVS_DB_PREFIX .
			"invoices where order_type='" . str_replace( "order", "orders", $rs->row["ptype"] ) .
			"' and order_id=" . $rs->row["pid"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
?>
	<a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>action=invoice&id=<?php
			echo $ds->row["invoice_number"] ?>"><i class="fa fa-file-pdf-o"></i>
	<?php
			echo "#" . $pvs_global_settings["invoice_prefix"] . $ds->row["invoice_number"] ?></a>
	<?php
		}
?>
</td>









<td class="hidden-phone hidden-tablet"><b><?php echo pvs_currency( 1, false );
?><?php echo pvs_price_format( $rs->row["total"], 2 )?>&nbsp;<?php echo pvs_currency( 2, false );
?></b></td>
<td>
<a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo pvs_user_login_to_id( $rs->row["user"] )?>"><?php
			echo $rs->row["user"] ?></a>
</td>
<td><?php echo @$pvs_payments[$rs->row["processor"]] ?></td>
<td><?php echo $rs->row["tnumber"] ?></td>
<td class="hidden-phone hidden-tablet"><div class="link_ip"><?php echo $rs->row["ip"] ?></div></td>

</tr>
<?php
		$n++;
		
		$rs->movenext();
	}
?>
</table>



<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "delete" )?>"  style="margin:15px 0px 0px 6px;">






</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('payments/index.php'), "&" . $var_search .
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