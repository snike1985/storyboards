<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_invoices" );

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );


//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}


//Change
if ( @$_REQUEST["action"] == 'refund' )
{
	include ( "refund.php" );
}


//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}


//Invoice
if ( @$_REQUEST["action"] == 'invoice' ) {
	include ( "invoice.php" );	
} else {
	?>
	
	<script>
	function pvs_invoice_status(value) 
	{
		jQuery.ajax({
			type:'POST',
			url:ajaxurl,
			data:'action=pvs_invoice_status&id=' + value,
			success:function(data){
				if(data.charAt(data.length-1) == '0')
				{
					data = data.substring(0,data.length-1)
				}
				document.getElementById('status'+value).innerHTML =data;
			}
		});
	}
	</script>
	
	
	
	<h1><?php echo pvs_word_lang( "Invoices" )?></h1>
	
	
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
			$com = " order by id ";
		}
		if ( $adate == 2 ) {
			$com = " order by id desc ";
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
		if ( $search_type == "invoice" ) {
			$com2 .= " and invoice_number='" . ( int )$search . "' ";
		}
		if ( $search_type == "id" ) {
			$com2 .= " and order_id=" . ( int )$search . " ";
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
	
	$sql = "select id,invoice_number,order_id,order_type,status,refund from " .
		PVS_DB_PREFIX . "invoices where id>0 ";
	
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
	<option value="invoice" <?php
	if ( $search_type == "invoice" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "Invoice number" )?></option>
	<option value="id" <?php
	if ( $search_type == "id" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "order" )?> ID</option>
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
	
	
	<div style="padding:0px 9px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('invoices/index.php'), "&" . $var_search .
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
	
	
	
	<form method="post" action="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
	<input type="hidden" name="action" value="delete">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
	<th><?php echo pvs_word_lang( "Invoice number" )?></th>
	
	
	
	<th><?php echo pvs_word_lang( "order" )?></th>
	
	<th class="hidden-phone hidden-tablet">
	<a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&<?php echo $var_search
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
	
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "total" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "user" )?></th>
	<th><?php echo pvs_word_lang( "status" )?></th>
	<th></th>
	<th></th>
	<th></th>
	
	</tr>
	</thead>
	<?php
		
		while ( ! $rs->eof ) {
	
			$cl3 = "";
			$cl_script = "";
			if ( isset( $_SESSION["user_invoices_id"] ) and ! isset( $_SESSION["admin_rows_invoices" .
				$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_invoices_id"] and $_SESSION["user_invoices_id"] >
				0 ) {
				$cl3 = "<span class='label label-danger invoices" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
				$cl_script = "onMouseover=\"pvs_deselect_row('invoices" . $rs->row["id"] . "')\"";
			}
	?>
	<tr valign="top" <?php echo $cl_script
	?>>
	<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
	
	
	<td>
	<?php
			if ( $rs->row["refund"] == 1 ) {
				$link_class = " class='red'";
				$word_refund = pvs_word_lang( "Refund money" ) . ": ";
				$symbol_minus = "-";
			} else {
				$link_class = "";
				$word_refund = "";
				$symbol_minus = "";
			}
	?>
	
	<a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&action=invoice&id=<?php echo $rs->row["invoice_number"] ?>" <?php echo $link_class
	?>><i class="fa fa-file-pdf-o"></i>
	<?php
			if ( $rs->row["refund"] == 1 ) {
				echo ( "#" . $pvs_global_settings["credit_notes_prefix"] . $rs->row["invoice_number"] );
			} else {
				echo ( "#" . $pvs_global_settings["invoice_prefix"] . $rs->row["invoice_number"] );
			}
	?></a> <?php echo $cl3
	?></td>
	
	
	
	
	<td>
	<?php
			$order_date = 0;
			$order_total = 0;
			$order_user = 0;
	
			if ( $rs->row["order_type"] == "orders" ) {
				$sql = "select data,total,user from " . PVS_DB_PREFIX . "orders where id=" . $rs->
					row["order_id"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$order_date = $ds->row["data"];
					$order_total = $ds->row["total"];
					$order_user = $ds->row["user"];
				}
	?>
			<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('currency/index.php'));?>&action=order_content&id=<?php
				echo $rs->row["order_id"] ?>" <?php
				echo $link_class
	?>><?php
				echo $word_refund
	?><?php
				echo pvs_word_lang( "order" )?> #<?php
				echo $rs->row["order_id"] ?></a></div>
		<?php
			}
			if ( $rs->row["order_type"] == "credits" ) {
				$sql = "select data,total,user from " . PVS_DB_PREFIX .
					"credits_list where id_parent=" . $rs->row["order_id"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$order_date = $ds->row["data"];
					$order_total = $ds->row["total"];
					$order_user = pvs_user_login_to_id( $ds->row["user"] );
				}
	?>
			<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>&search=<?php
				echo $rs->row["order_id"] ?>&search_type=id" <?php
				echo $link_class
	?>><?php
				echo $word_refund
	?><?php
				echo pvs_word_lang( "credits" )?> #<?php
				echo $rs->row["order_id"] ?></a></div>
		<?php
			}
			if ( $rs->row["order_type"] == "subscription" ) {
				$sql = "select data1,total,user from " . PVS_DB_PREFIX .
					"subscription_list where id_parent=" . $rs->row["order_id"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$order_date = $ds->row["data1"];
					$order_total = $ds->row["total"];
					$order_user = pvs_user_login_to_id( $ds->row["user"] );
				}
	?>
			<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>&action=edit&id=<?php
				echo $rs->row["order_id"] ?>" <?php
				echo $link_class
	?>><?php
				echo $word_refund
	?><?php
				echo pvs_word_lang( "subscription" )?> #<?php
				echo $rs->row["order_id"] ?></a></div>
		<?php
			}
	?>
	</td>
	
	<td class="gray hidden-phone hidden-tablet"><?php echo date( datetime_format, $order_date )?></td>
	
	
	
	
	
	
	
	
	<td class="hidden-phone hidden-tablet"><b><?php echo $symbol_minus
	?><?php echo pvs_currency( 1, false );
	?><?php echo pvs_price_format( $order_total, 2 )?>&nbsp;<?php echo pvs_currency( 2, false );
	?></b></td>
	<td class="hidden-phone hidden-tablet">
	<?php
		$user_info = get_userdata( ( int )@$order_user );
		echo ( '<div><a href="' . pvs_plugins_admin_url('customers/index.php') . '&action=content&id=' . ( int )@$order_user .
			'"><i class="fa fa-user"></i> ' . @$user_info -> user_login . '</a></div>' );

		if ( @$user_info -> business )
		{
			echo ( '<div><small>' . pvs_word_lang( "business" ) . ' ' );

			if ( ( int )@$user_info -> vat_checked == 0 )
			{
				echo ( '<span class="label label-warning">' . pvs_word_lang( "Not checked" ) .
					'</span><br>' );
			}

			if ( ( int )@$user_info -> vat_checked == 1 )
			{
				echo ( '<span class="label label-success">' . pvs_word_lang( "Valid" ) .
					'</span><br>' );
			}

			if ( ( int )@$user_info -> vat_checked == -1 )
			{
				echo ( '<span class="label label-danger">' . pvs_word_lang( "Invalid" ) .
					'</span><br>' );
			}

			if ( ( int )@$user_info -> vat_checked_date != 0 )
			{
				echo ( pvs_word_lang( "Last check" ) . ': ' . pvs_show_time_ago( @$user_info -> vat_checked_date ) );
			}

			echo ( '</small></div>' );
		} else
		{
			echo ( '<div><small>' . pvs_word_lang( "individual" ) . '</small></div>' );
		}

		echo ( '<div style="margin-top:10px"><small>' . @$user_info -> country . ' ' );

		if ( ( int )@$user_info -> country_checked == 0 )
		{
			echo ( '<span class="label label-warning">' . pvs_word_lang( "Not checked" ) .
				'</span><br>' );
		}

		if ( ( int )@$user_info -> country_checked == 1 )
		{
			echo ( '<span class="label label-success">' . pvs_word_lang( "Valid" ) .
				'</span><br>' );
		}

		if ( ( int )@$user_info -> country_checked == -1 )
		{
			echo ( '<span class="label label-danger">' . pvs_word_lang( "Invalid" ) .
				'</span><br>' );
		}

		if ( ( int )@$user_info -> country_checked_date != 0 )
		{
			echo ( pvs_word_lang( "Last check" ) . ': ' . pvs_show_time_ago( @$user_info -> country_checked_date ) );
		}

		echo ( '</small></div>' );
	?>
	</td>
	<td class="hidden-phone hidden-tablet">
	<?php
			$cl = "success";
			if ( $rs->row["status"] != 1 ) {
				$cl = "danger";
			}
	?>
	
	<div id="status<?php echo $rs->row["id"] ?>" name="status<?php echo $rs->row["id"] ?>"><a href="javascript:pvs_invoice_status(<?php echo $rs->row["id"] ?>);"><span class="label label-<?php echo $cl
	?>"><?php
			if ( $rs->row["status"] == 1 ) {
				echo ( pvs_word_lang( "published" ) );
			} else {
				echo ( pvs_word_lang( "pending" ) );
			}
	?></span></a></div>
	</td>
	
	<td><a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&action=invoice&id=<?php echo $rs->row["invoice_number"] ?>&change=1"><i class="fa fa-edit"></i>
	<?php echo pvs_word_lang( "edit" )?></a></td>
	
	<td><a href="<?php echo (site_url( ) );?>/invoice-html/?id=<?php echo $rs->row["invoice_number"] ?>"><i class="fa fa-file-text"></i>
	HTML</a></td>
	<td><a href="<?php echo (site_url( ) );?>/invoice-pdf/?id=<?php echo $rs->row["invoice_number"] ?>"><i class="fa fa-file-pdf-o"></i>
	PDF</a></td>
	</tr>
	<?php
			$n++;
			
			$rs->movenext();
		}
	?>
	</table>
	
	
	
	<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "delete" )?>"  style="margin:15px 0px 0px 6px;">
	
	
	
	
	
	
	</form>
	<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('invoices/index.php'), "&" . $var_search .
			$var_sort ) );
	?></div>
	<?php
	} else
	{
		echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
	}
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>