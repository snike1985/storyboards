<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );



include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );


//Comment change
if ( @$_REQUEST["action"] == 'comments_change' )
{
	include ( "comments_change.php" );
}




//Delete
if ( @$_REQUEST["action"] == 'order_delete' )
{
	include ( "order_delete.php" );
}

//Restore
if ( @$_REQUEST["action"] == 'restore' )
{
	include ( "restore.php" );
}



//Content
if ( @$_REQUEST["action"] == 'order_content' or @$_REQUEST["action"] == 'restore'  or @$_REQUEST["action"] == 'comments_change'  ) {
	include ( "order_content.php" );	
} else {
?>



<a class="btn btn-success toright" href="<?php echo (site_url( ) );?>/orders-export-csv/"><i class="icon-th icon-white fa fa-file-text"></i>&nbsp; <?php echo pvs_word_lang( "export as csv file" )?></a>

<a class="btn btn-success toright" href="<?php echo (site_url( ) );?>/orders-export-xls/"><i class="icon-th-list icon-white fa fa-file-excel-o"> </i>&nbsp; <?php echo pvs_word_lang( "export as xls file" )?></a>



<h1><?php echo pvs_word_lang( "orders" )?></h1>




<script>

function pvs_order_status(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_order_status&id=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+value).innerHTML =data;
		}
	});
}

function pvs_order_shipping_status(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_order_shipping_status&id=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('shipping'+value).innerHTML =data;
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

	if ( $search_type == "id" ) {
		$com2 .= " and id=" . ( int )$search . " ";
	}
	if ( $search_type == "login" ) {
		$com2 .= " and user = '" . pvs_user_login_to_id( $search ) . "' ";
	}

}

if ( $pub_type == "approved" ) {
	$com2 .= " and status=1 ";
}
if ( $pub_type == "pending" ) {
	$com2 .= " and status=0 ";
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

$sql = "select * from " . PVS_DB_PREFIX . "orders where id>0 ";

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
?>>ID</option>

</select>
</div>












<div class="toleft">
<span><?php echo pvs_word_lang( "type" )?>:</span>
<select name="pub_type" style="width:100px" class="ft">
<option value="all"><?php echo pvs_word_lang( "all" )?></option>
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


<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('orders/index.php'), "&" . $var_search .
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



<form method="post" action="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="order_delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th>
<a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&<?php echo $var_search
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
<a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&<?php echo $var_search
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
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "subtotal" )?></b></th>
<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "discount" )?></b></th>
<?php
	}
?>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "shipping" )?></b></th>
<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "taxes" )?></b></th>
<?php
	}
?>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "total" )?></b></th>
<th><?php echo pvs_word_lang( "status" )?></b></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "shipping" )?></b></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "user" )?></b></th>
<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "Invoice" )?></th>
<?php
	}
?>	
</tr>
</thead>







<?php
	while ( ! $rs->eof ) {

		$method = "";
		if ( $pvs_global_settings["credits_currency"] ) {
			if ( $rs->row["credits"] == 1 )
			{
				$method = "credits";
			} else
			{
				$method = "currency";
			}
		}

		$cl = "success";
		if ( $rs->row["status"] != 1 ) {
			$cl = "danger";
		}

		$cl2 = "info";
		if ( $rs->row["shipped"] != 1 ) {
			$cl2 = "warning";
		}

		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_orders_id"] ) and ! isset( $_SESSION["admin_rows_orders" .
			$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_orders_id"] and $_SESSION["user_orders_id"] >
			0 ) {
			$cl3 = "<span class='label label-danger orders" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('orders" . $rs->row["id"] . "')\"";
		}
?>
<tr valign="top" <?php echo $cl_script
?>>
<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>


<td class="big">

<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&action=order_content&id=<?php echo $rs->row["id"] ?>"><b><?php echo pvs_word_lang( "order" )?> #<?php echo $rs->row["id"] ?></b></a> <?php echo $cl3
?></div>


</td>

<td class="gray hidden-phone hidden-tablet"><?php echo date( date_format, $rs->row["data"] )?></td>
<td class="hidden-phone hidden-tablet"><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["subtotal"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></td>
<?php
		if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
<td class="hidden-phone hidden-tablet"><?php
			echo pvs_currency( 1, true, $method );
?><?php
			echo pvs_price_format( $rs->row["discount"], 2 )?> <?php
			echo pvs_currency( 2, true, $method );
?></td>
<?php
		}
?>
<td class="hidden-phone hidden-tablet"><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["shipping"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></td>
<?php
		if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
	<td class="hidden-phone hidden-tablet">
	<?php
			if ( $rs->row["credits"] != 1 )
			{
?>
		<?php
				echo pvs_currency( 1, true, $method );
?><?php
				echo pvs_price_format( $rs->row["tax"], 2 )?> <?php
				echo pvs_currency( 2, true, $method );
?>
	<?php
			} else
			{
				echo ( "&mdash;" );
			}
?>
	</td>
<?php
		}
?>
<td class="hidden-phone hidden-tablet"><b><?php echo pvs_currency( 1, true, $method );
?><?php echo pvs_price_format( $rs->row["total"], 2 )?> <?php echo pvs_currency( 2, true, $method );
?></b></td>
<td><div id="status<?php echo $rs->row["id"] ?>" name="status<?php echo $rs->row["id"] ?>"><a href="javascript:pvs_order_status(<?php echo $rs->row["id"] ?>);" ><span class='label label-<?php echo $cl
?>'><?php
		if ( $rs->row["status"] == 1 ) {
			echo ( pvs_word_lang( "approved" ) );
		} else {
			echo ( pvs_word_lang( "pending" ) );
		}
?></span></a></div>
</td>
<td class="gray hidden-phone hidden-tablet">
<?php
		if ( $rs->row["shipping"] * 1 != 0 ) {
?>

<div id="shipping<?php
			echo $rs->row["id"] ?>" name="shipping<?php
			echo $rs->row["id"] ?>"><a href="javascript:pvs_order_shipping_status(<?php
			echo $rs->row["id"] ?>);"><span class='label label-<?php
			echo $cl2
?>'><?php
			if ( $rs->row["shipped"] == 1 )
			{
				echo ( pvs_word_lang( "shipped" ) );
			} else
			{
				echo ( pvs_word_lang( "not shipped" ) );
			}
?></span></a></div>
<?php
		} else {
			echo ( "&mdash;" );
		}
?>

</td>
<td class="hidden-phone hidden-tablet">
<div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user"] ) ?></a></div>
</td>

<?php
		if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
<td class="hidden-phone hidden-tablet">
<?php
			if ( $rs->row["credits"] != 1 )
			{
				$invoice_number = "";
				$link_class = "";

				$sql = "select invoice_number,refund from " . PVS_DB_PREFIX .
					"invoices where order_type='orders' and order_id=" . $rs->row["id"] .
					" order by id";
				$ds->open( $sql );
				while ( ! $ds->eof )
				{
					if ( $ds->row["refund"] == 1 )
					{
						$link_class = "class='red'";
						$invoice_number = "#" . $pvs_global_settings["credit_notes_prefix"] . $ds->row["invoice_number"];
						$word_refund = pvs_word_lang( "Refund money" ) . ": ";
					} else
					{
						$invoice_number = "#" . $pvs_global_settings["invoice_prefix"] . $ds->row["invoice_number"];
						$word_refund = "";
					}
?>
		<a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&action=invoice&id=<?php
					echo $ds->row["invoice_number"] ?>" <?php
					echo $link_class
?>><i class="fa fa-file-pdf-o"></i>
		 <?php
					echo $word_refund
?><?php
					echo $invoice_number
?></a><br>
		<?php
					$ds->movenext();
				}
			} else
			{
				echo ( "&mdash;" );
			}
?>


</td>
<?php
		}
?>


</tr>
<?php
		
		$n++;
		$rs->movenext();
	}
?>
</table>







<input type="submit" value="<?php echo pvs_word_lang( "delete" )?>" style="margin:10px 0px 0px 6px" class="btn btn-danger">


</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('orders/index.php'), "&" . $var_search .
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