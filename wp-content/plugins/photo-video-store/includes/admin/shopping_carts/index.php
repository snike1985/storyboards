<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_carts" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Remove all
if ( @$_REQUEST["action"] == 'remove_all' )
{
	include ( "remove_all.php" );
}
?>



<a class="btn btn-danger toright" href="<?php echo(pvs_plugins_admin_url('shopping_carts/index.php'));?>&action=remove_all"><i class="icon-trash icon-white fa fa-remove"></i> <?php echo pvs_word_lang( "remove all" )?></a>

<h1><?php echo pvs_word_lang( "shopping carts" )?></h1>





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
	if ( $search_type == "from" ) {
		$com2 .= " and user_id=" . pvs_user_login_to_id( pvs_result( $search ) ) . " ";
	}
	if ( $search_type == "id" ) {
		$com2 .= " and order_id=" . ( int )$search . " ";
	}
	if ( $search_type == "ip" ) {
		$com2 .= " and ip='" . pvs_result( $search ) . "' ";
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

$sql = "select id,session_id,data,user_id,order_id,ip from " . PVS_DB_PREFIX .
	"carts where id>0 ";

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
<option value="ip" <?php
if ( $search_type == "ip" ) {
	echo ( "selected" );
}
?>>IP</option>
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


<div style="padding:0px 9px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('shopping_carts/index.php'), "&" . $var_search .
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



<form method="post" action="<?php echo(pvs_plugins_admin_url('shopping_carts/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th class="hidden-phone hidden-tablet">
<a href="index.php?<?php echo $var_search
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
<th><?php echo pvs_word_lang( "user" )?></th>

<th width="50%"><?php echo pvs_word_lang( "content" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "total" )?></th>

<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "ip" )?></th>



</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {
?>
<tr valign="top">
<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
<td class="gray hidden-phone hidden-tablet"><?php echo date( datetime_format, $rs->row["data"] )?></td>

<td>
<?php
		if ( $rs->row["order_id"] != 0 ) {
?>
		<div class="link_order"><a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&action=order_content&id=<?php
			echo $rs->row["order_id"] ?>"><?php
			echo pvs_word_lang( "order" )?> #<?php
			echo $rs->row["order_id"] ?></a></div>
	<?php
		} else {
?>
		<div class="link_status"><?php
			echo pvs_word_lang( "not finished" )?></div>
	<?php
		}
?>
</td>
<td>
<?php
		if ( $rs->row["user_id"] != 0 ) {
?>
		<div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user_id"] )?></a></div>
	<?php
		} else {
			echo ( "&mdash;" );
		}
?>
</td>






<td>
	<?php
		$total = 0;
		$sql = "select id,item_id,prints_id,publication_id,quantity,option1_id,option1_value,option2_id,option2_value,option3_id,option3_value,option4_id,option4_value,option5_id,option5_value,option6_id,option6_value,option7_id,option7_value,option8_id,option8_value,option9_id,option9_value,option10_id,option10_value,rights_managed,printslab,stock,stock_type,stock_id,stock_url,stock_preview,stock_site_url,collection from " .
			PVS_DB_PREFIX . "carts_content where id_parent=" . $rs->row["id"];
		$dr->open( $sql );
		while ( ! $dr->eof ) {
			if ( (int) $dr->row["collection"] == 0 ) {
				if ( $dr->row["item_id"] > 0 )
				{
					if ( $dr->row["rights_managed"] != "" )
					{
						$rights_managed_price = 0;
						$rights_mass = explode( "|", $dr->row["rights_managed"] );
						$rights_managed_price = $rights_mass[0];
	
						$sql = "select id,price,name from " . PVS_DB_PREFIX . "items where id=" . $dr->
							row["item_id"];
						$ds->open( $sql );
						if ( ! $ds->eof )
						{
	?>
								<div style="margin-bottom:3px"><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
							echo $dr->row["publication_id"] ?>">#<?php
							echo $dr->row["publication_id"] ?></a> &mdash; <?php
							echo $dr->row["quantity"] ?> x <?php
							echo $ds->row["name"] ?>  &mdash; <?php
							echo pvs_currency( 1 );
?><?php
							echo pvs_price_format( $rights_managed_price, 2, true )?>&nbsp;<?php
							echo pvs_currency( 2 );
?></div>
							<?php
						}
	
						$total += $rights_managed_price;
					} else
					{
						$sql = "select id,price,name from " . PVS_DB_PREFIX . "items where id=" . $dr->
							row["item_id"];
						$ds->open( $sql );
						if ( ! $ds->eof )
						{
	?>
								<div style="margin-bottom:3px"><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
							echo $dr->row["publication_id"] ?>">#<?php
							echo $dr->row["publication_id"] ?></a> &mdash; <?php
							echo $dr->row["quantity"] ?> x <?php
							echo $ds->row["name"] ?>  &mdash; <?php
							echo pvs_currency( 1 );
?><?php
							echo pvs_price_format( $ds->row["price"], 2, true )?>&nbsp;<?php
							echo pvs_currency( 2 );
?></div>
							<?php
							$total += $ds->row["price"];
						}
					}
				}
	
				if ( $dr->row["prints_id"] > 0 )
				{
					if ( ( int )$dr->row["stock"] == 0 )
					{
						if ( $dr->row["printslab"] != 1 )
						{
							$sql = "select id_parent,price,title from " . PVS_DB_PREFIX .
								"prints_items where id_parent=" . $dr->row["prints_id"];
							$ds->open( $sql );
							if ( ! $ds->eof )
							{
								$price = pvs_define_prints_price( $ds->row["price"], $dr->row["option1_id"], $dr->
									row["option1_value"], $dr->row["option2_id"], $dr->row["option2_value"], $dr->
									row["option3_id"], $dr->row["option3_value"], $dr->row["option4_id"], $dr->row["option4_value"],
									$dr->row["option5_id"], $dr->row["option5_value"], $dr->row["option6_id"], $dr->
									row["option6_value"], $dr->row["option7_id"], $dr->row["option7_value"], $dr->
									row["option8_id"], $dr->row["option8_value"], $dr->row["option9_id"], $dr->row["option9_value"],
									$dr->row["option10_id"], $dr->row["option10_value"] );
?>
								<div style="margin-bottom:3px"><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
								echo $dr->row["publication_id"] ?>">#<?php
								echo $dr->row["publication_id"] ?></a> &mdash; <?php
								echo $dr->row["quantity"] ?> x <?php
								echo $ds->row["title"] ?> 
							
								<span class="gr">(<?php
								for ( $i = 1; $i < 11; $i++ )
								{
									if ( $dr->row["option" . $i . "_id"] != 0 and $dr->row["option" . $i . "_value"] !=
										"" )
									{
										$sql = "select title from " . PVS_DB_PREFIX . "products_options where id=" . $dr->
											row["option" . $i . "_id"];
										$dn->open( $sql );
										if ( ! $dn->eof )
										{
	?><?php
											echo $dn->row["title"] ?>: <?php
											echo $dr->row["option" . $i . "_value"] ?>.<?php
										}
									}
								}
	?>)</span> 
							
								&mdash; <?php
								echo pvs_currency( 1 );
?><?php
								echo pvs_price_format( $price, 2, true )?>&nbsp;<?php
								echo pvs_currency( 2 );
?></div>
								<?php
								$total += $price * $dr->row["quantity"];
							}
						} else
						{
							$sql = "select id_parent,price,title from " . PVS_DB_PREFIX .
								"prints where id_parent=" . $dr->row["prints_id"];
							$ds->open( $sql );
							if ( ! $ds->eof )
							{
								$price = pvs_define_prints_price( $ds->row["price"], $dr->row["option1_id"], $dr->
									row["option1_value"], $dr->row["option2_id"], $dr->row["option2_value"], $dr->
									row["option3_id"], $dr->row["option3_value"], $dr->row["option4_id"], $dr->row["option4_value"],
									$dr->row["option5_id"], $dr->row["option5_value"], $dr->row["option6_id"], $dr->
									row["option6_value"], $dr->row["option7_id"], $dr->row["option7_value"], $dr->
									row["option8_id"], $dr->row["option8_value"], $dr->row["option9_id"], $dr->row["option9_value"],
									$dr->row["option10_id"], $dr->row["option10_value"] );
	
								$gallery_id = 0;
								$sql = "select id_parent from " . PVS_DB_PREFIX . "galleries_photos where id=" .
									$dr->row["publication_id"];
								$dn->open( $sql );
								if ( ! $dn->eof )
								{
									$gallery_id = $dn->row["id_parent"];
								}
	?>
								<div style="margin-bottom:3px"><a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&d=7&id=<?php
								echo $gallery_id
	?>">#<?php
								echo $dr->row["publication_id"] ?></a> &mdash; <?php
								echo $dr->row["quantity"] ?> x <?php
								echo $ds->row["title"] ?> 
							
								<span class="gr">(<?php
								for ( $i = 1; $i < 11; $i++ )
								{
									if ( $dr->row["option" . $i . "_id"] != 0 and $dr->row["option" . $i . "_value"] !=
										"" )
									{
										$sql = "select title from " . PVS_DB_PREFIX . "products_options where id=" . $dr->
											row["option" . $i . "_id"];
										$dn->open( $sql );
										if ( ! $dn->eof )
										{
	?><?php
											echo $dn->row["title"] ?>: <?php
											echo $dr->row["option" . $i . "_value"] ?>.<?php
										}
									}
								}
	?>)</span> 
							
								&mdash; <?php
								echo pvs_currency( 1 );
?><?php
								echo pvs_price_format( $price, 2, true )?>&nbsp;<?php
								echo pvs_currency( 2 );
?></div>
								<?php
								$total += $price * $dr->row["quantity"];
							}
						}
					} else
					{
						$sql = "select id_parent,price,title from " . PVS_DB_PREFIX .
							"prints where id_parent=" . $dr->row["prints_id"];
						$ds->open( $sql );
						if ( ! $ds->eof )
						{
							$price = pvs_define_prints_price( $ds->row["price"], $dr->row["option1_id"], $dr->
								row["option1_value"], $dr->row["option2_id"], $dr->row["option2_value"], $dr->
								row["option3_id"], $dr->row["option3_value"], $dr->row["option4_id"], $dr->row["option4_value"],
								$dr->row["option5_id"], $dr->row["option5_value"], $dr->row["option6_id"], $dr->
								row["option6_value"], $dr->row["option7_id"], $dr->row["option7_value"], $dr->
								row["option8_id"], $dr->row["option8_value"], $dr->row["option9_id"], $dr->row["option9_value"],
								$dr->row["option10_id"], $dr->row["option10_value"] );
	
							$title = @$mstocks[$dr->row["stock_type"]] . " #" . $dr->row["stock_id"];
							$preview = $dr->row["stock_preview"];
							$url = $dr->row["stock_site_url"];
	?>
							<div style="margin-bottom:3px"><a href="<?php
							echo $url
	?>"><?php
							echo $title
	?></a> &mdash; <?php
							echo $dr->row["quantity"] ?> x <?php
							echo $ds->row["title"] ?> 
						
							<span class="gr">(<?php
							for ( $i = 1; $i < 11; $i++ )
							{
								if ( $dr->row["option" . $i . "_id"] != 0 and $dr->row["option" . $i . "_value"] !=
									"" )
								{
									$sql = "select title from " . PVS_DB_PREFIX . "products_options where id=" . $dr->
										row["option" . $i . "_id"];
									$dn->open( $sql );
									if ( ! $dn->eof )
									{
	?><?php
										echo $dn->row["title"] ?>: <?php
										echo $dr->row["option" . $i . "_value"] ?>.<?php
									}
								}
							}
	?>)</span> 
						
							&mdash; <?php
							echo pvs_currency( 1 );
?><?php
							echo pvs_price_format( $price, 2, true )?>&nbsp;<?php
							echo pvs_currency( 2 );
?></div>
							<?php
							$total += $price * $dr->row["quantity"];
						}
					}
				}
			} else {
				//Collection
				$sql = "select id, title, price, description from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . $dr->row["collection"];
				$ds->open( $sql );
				if ( ! $ds->eof ) {
					$price = $ds->row["price"];
	
					$title = pvs_word_lang("Collection") . ': ' . $ds->row["title"] . ' (' . pvs_count_files_in_collection($ds->row["id"]) . ')';
					$url = pvs_collection_url( $ds->row["id"], $ds->row["title"] );

					?>
						<div style="margin-bottom:3px"><a href="<?php echo $url ?>"><?php
						echo $title ?></a> x <?php
						echo $dr->row["quantity"] ?>
					
						&mdash; <?php
						echo pvs_currency( 1 );
?><?php
						echo pvs_price_format( $price, 2, true )?>&nbsp;<?php
						echo pvs_currency( 2 );
?></div>
						<?php	
						
					$total += $price * $dr->row["quantity"];
				}			
			}
			$dr->movenext();
		}
?>
</td>
<td class="hidden-phone hidden-tablet"><b><?php echo pvs_currency( 1 );
?><?php echo pvs_price_format( $total, 2, true )?>&nbsp;<?php echo pvs_currency( 2 );
?></b></td>
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
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('shopping_carts/index.php'), "&" . $var_search .
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