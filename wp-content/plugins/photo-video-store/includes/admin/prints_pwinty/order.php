<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );

//Get Search
$search = "";
if ( isset( $_REQUEST["search"] ) )
{
	$search = pvs_result( $_REQUEST["search"] );
}

//Get Search type
$search_type = "";
if ( isset( $_REQUEST["search_type"] ) )
{
	$search_type = pvs_result( $_REQUEST["search_type"] );
}

//Get pub_type
$pub_type = "all";
if ( isset( $_REQUEST["pub_type"] ) )
{
	$pub_type = pvs_result( $_REQUEST["pub_type"] );
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) )
{
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
	$items . "&pub_type=" . $pub_type . "&d=2";

//Sort by date
$adate = 0;
if ( isset( $_REQUEST["adate"] ) )
{
	$adate = ( int )$_REQUEST["adate"];
}

//Sort by ID
$aid = 0;
if ( isset( $_REQUEST["aid"] ) )
{
	$aid = ( int )$_REQUEST["aid"];
}

//Sort by default
if ( $adate == 0 and $aid == 0 )
{
	$adate = 2;
}

//Add sort variable
$com = "";

if ( $adate != 0 )
{
	$var_sort = "&adate=" . $adate;
	if ( $adate == 1 )
	{
		$com = " order by data ";
	}
	if ( $adate == 2 )
	{
		$com = " order by data desc ";
	}
}

if ( $aid != 0 )
{
	$var_sort = "&aid=" . $aid;
	if ( $aid == 1 )
	{
		$com = " order by id ";
	}
	if ( $aid == 2 )
	{
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

if ( $search != "" )
{

	if ( $search_type == "id" )
	{
		$com2 .= " and id=" . ( int )$search . " ";
	}
	if ( $search_type == "login" )
	{
		$com2 .= " and user = '" . pvs_user_login_to_id( $search ) . "' ";
	}

}

if ( $pub_type == "approved" )
{
	$com2 .= " and status=1 ";
}
if ( $pub_type == "pending" )
{
	$com2 .= " and status=0 ";
}

//Item's quantity
$kolvo = $items;

//Pages quantity
$kolvo2 = PVS_PAGE_NUMBER;

//Page number
if ( ! isset( $_GET["str"] ) )
{
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

$n = 0;

$order_number = 0;
$sql = "select order_number from " . PVS_DB_PREFIX . "pwinty";
$rs->open( $sql );
if ( ! $rs->eof )
{
	$order_number = $rs->row["order_number"];
}

$sql = "select * from " . PVS_DB_PREFIX . "orders where status=1 and id>" . $order_number .
	" ";

$sql .= $com2 . $com;

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql .= $lm;

//echo($sql);
$rs->open( $sql );
?>
<div id="catalog_menu card">


<form method="post">
<input type="hidden" name="d" value="2">
<div class="toleft">
<span><?php
echo pvs_word_lang( "search" )
?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="ft" value="<?php
echo $search
?>" onClick="this.value=''">
<select name="search_type" style="width:100px;display:inline" class="ft">
<option value="login" <?php
if ( $search_type == "login" )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "login" )
?></option>
<option value="id" <?php
if ( $search_type == "id" )
{
	echo ( "selected" );
}
?>>ID</option>

</select>
</div>















<div class="toleft">
<span><?php
echo pvs_word_lang( "page" )
?>:</span>
<select name="items" style="width:80px" class="ft">
<?php
for ( $i = 0; $i < count( $items_mass ); $i++ )
{
	$sel = "";
	if ( $items_mass[$i] == $items )
	{
		$sel = "selected";
	}
?>
<option value="<?php
	echo $items_mass[$i]
?>" <?php
	echo $sel
?>><?php
	echo $items_mass[$i]
?></option>
<?php
}
?>

</select>
</div>

<div class="toleft">
<span>&nbsp;</span>
<input type="submit" class="btn btn-danger" value="<?php
echo pvs_word_lang( "search" )
?>">
</div>


<div class="toleft_clear"></div>
</form>


</div>



<?php

if ( ! $rs->eof )
{
?>



<script language="javascript">
function publications_select_all(sel_form)
{
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



<form method="post">
<input type="hidden" name="action" value="send">
<input type="hidden" name="d" value="2">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th>
<a href="<?php
	echo ( pvs_plugins_admin_url( 'prints_pwinty/index.php' ) );
?>&d=2&<?php
	echo $var_search
?>&aid=<?php
	if ( $aid == 2 )
	{
		echo ( 1 );
	} else
	{
		echo ( 2 );
	}
?>">ID</a> <?php
	if ( $aid == 1 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_up.gif" width="11" height="8"><?php
	}
?><?php
	if ( $aid == 2 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_down.gif" width="11" height="8"><?php
	}
?>
</th>
<th>
<a href="<?php
	echo ( pvs_plugins_admin_url( 'prints_pwinty/index.php' ) );
?>&d=2&<?php
	echo $var_search
?>&adate=<?php
	if ( $adate == 2 )
	{
		echo ( 1 );
	} else
	{
		echo ( 2 );
	}
?>"><?php
	echo pvs_word_lang( "date" )
?></a> <?php
	if ( $adate == 1 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_up.gif" width="11" height="8"><?php
	}
?><?php
	if ( $adate == 2 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_down.gif" width="11" height="8"><?php
	}
?>
</th>

<th><?php
	echo pvs_word_lang( "user" )
?></b></th>
<th><?php
	echo pvs_word_lang( "content" )
?></b></th>
<th><?php
	echo pvs_word_lang( "total" )
?></b></th>
<th>Sent to Pwinty</th>
</tr>
</thead>








<?php
	//Define necessary prints ids
	$prints_mas = array();
	$sql = "select print_id from " . PVS_DB_PREFIX . "pwinty_prints where activ=1";
	$ds->open( $sql );
	while ( ! $ds->eof )
	{
		$prints_mas[] = $ds->row["print_id"];
		$ds->movenext();
	}
	//End. Define necessary prints ids

	while ( ! $rs->eof )
	{
		$flag_prints = false;
		$content = "";
		$total = 0;

		$sql = "select item,price,quantity,option1_id,option1_value,option2_id,option2_value,option3_id,option3_value,printslab,printslab_id,prints from " .
			PVS_DB_PREFIX . "orders_content where prints=1 and id_parent=" . $rs->row["id"];
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			if ( $ds->row["prints"] == 1 )
			{
				if ( $ds->row["printslab"] != 1 )
				{
					$sql = "select printsid,itemid,title from " . PVS_DB_PREFIX .
						"prints_items where id_parent=" . $ds->row["item"];
					$dr->open( $sql );
					if ( ! $dr->eof and in_array( $dr->row["printsid"], $prints_mas ) )
					{
						$flag_prints = true;

						$content .= "<div style='margin-bottom:3px'><a href='<?php echo(pvs_plugins_admin_url('catalog/index.php'));
?>&action=content.php&id=" .
							$dr->row["itemid"] . "'>#" . $dr->row["itemid"] . "</a> &mdash; " . $ds->row["quantity"] .
							" x " . $dr->row["title"] . " <span class='gr'>(";

						for ( $i = 1; $i < 4; $i++ )
						{
							if ( $ds->row["option" . $i . "_id"] != 0 and $ds->row["option" . $i . "_value"] !=
								"" )
							{
								$sql = "select title from " . PVS_DB_PREFIX . "products_options where id=" . $ds->
									row["option" . $i . "_id"];
								$dn->open( $sql );
								if ( ! $dn->eof )
								{
									$content .= $dn->row["title"] . ": " . $ds->row["option" . $i . "_value"] . ". ";
								}
							}
						}

						$content .= ")</span></div>";

						$total += $ds->row["price"] * $ds->row["quantity"];
					}
				} else
				{
					$sql = "select id_parent,title from " . PVS_DB_PREFIX .
						"prints where id_parent=" . $ds->row["item"];
					$dr->open( $sql );
					if ( ! $dr->eof and in_array( $dr->row["id_parent"], $prints_mas ) )
					{
						$flag_prints = true;

						$gallery_id = 0;
						$sql = "select id_parent from " . PVS_DB_PREFIX . "galleries_photos where id=" .
							$ds->row["printslab_id"];
						$dn->open( $sql );
						if ( ! $dn->eof )
						{
							$gallery_id = $dn->row["id_parent"];
						}

						$content .= "<div style='margin-bottom:3px'><a href='<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=7&id=" .
							$gallery_id . "'>" . pvs_word_lang( "prints lab" ) . " #" . $ds->row["printslab_id"] .
							"</a> &mdash; " . $ds->row["quantity"] . " x " . $dr->row["title"] .
							" <span class='gr'>(";

						for ( $i = 1; $i < 4; $i++ )
						{
							if ( $ds->row["option" . $i . "_id"] != 0 and $ds->row["option" . $i . "_value"] !=
								"" )
							{
								$sql = "select title from " . PVS_DB_PREFIX . "products_options where id=" . $ds->
									row["option" . $i . "_id"];
								$dn->open( $sql );
								if ( ! $dn->eof )
								{
									$content .= $dn->row["title"] . ": " . $ds->row["option" . $i . "_value"] . ". ";
								}
							}
						}

						$content .= ")</span></div>";

						$total += $ds->row["price"] * $ds->row["quantity"];
					}
				}
			}

			$ds->movenext();
		}

		if ( $flag_prints )
		{
?>
		<tr valign="top">
		
			<td><input type="checkbox" name="sel<?php
			echo $rs->row["id"]
?>" id="sel<?php
			echo $rs->row["id"]
?>"></td>
			
			<td class="big"><div class="link_order"><a href="<?php
			echo ( pvs_plugins_admin_url( 'orders/index.php' ) );
?>&action=order_content&id=<?php
			echo $rs->row["id"]
?>"><b><?php
			echo pvs_word_lang( "order" )
?> #<?php
			echo $rs->row["id"]
?></b></a></div></td>
			
			<td class="gray"><?php
			echo date( date_format, $rs->row["data"] )
?></td>

			<td>
				<?php
			$sql = "select ID, user_login from " . $table_prefix . "users where ID=" . $rs->
				row["user"];
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				echo ( "<a href='" . pvs_plugins_admin_url( 'customers/index.php' ) .
					"&action=content&id=" . $ds->row["ID"] . "'>" . $ds->row["user_login"] . "</a>" );
			}
?>
			</td>
			
			<td><?php
			echo $content
?></td>
			
			<td><b><?php
			echo pvs_currency( 1 );
?><?php
			echo pvs_price_format( $total, 2 )
?> <?php
			echo pvs_currency( 2 );
?></b></td>
			
			<td>
				<?php
			$sql = "select data,pwinty_id from " . PVS_DB_PREFIX .
				"pwinty_orders where order_id=" . $rs->row["id"];
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				echo ( "<div class='gray'><b>" . pvs_word_lang( "date" ) . ":</b> " . date( date_format,
					$ds->row["data"] ) . "</div>" );

				echo ( "<div class='gray'><b>Pwinty order ID:</b> " . $ds->row["pwinty_id"] .
					"</div>" );
			} else
			{
				echo ( pvs_word_lang( "no" ) );
			}
?>
			</td>
		</tr>
		<?php
			
			$n++;
		}

		$rs->movenext();
	}
?>
</table>






<div style="padding:25px 0px 10px 5px;"><?php
	echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'prints_pwinty/index.php' ),
		"&d=2" . $var_search . $var_sort ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>

<div id="button_bottom_static">
	<div id="button_bottom_layout"></div>
	<div id="button_bottom">
		<input type="submit" class="btn btn-primary" value="Send to Pwinty">
	</div>
</div>
</form>