<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_coupons" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}


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


//Content
if ( @$_REQUEST["action"] == 'content' ) {
	include ( "content.php" );
} else if ( @$_REQUEST["action"] == 'new' ) {
	include ( "new.php" );	
} else {
	?>
	
	
	
	
	<a class="btn btn-success toright" href="<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>&action=new"><i class="icon-certificate icon-white fa fa-bookmark-o"></i> <?php echo pvs_word_lang( "coupons" )?></a>
	
	<h1><?php echo pvs_word_lang( "Coupons" )?>:</h1>
	
	
	
	<script>
	function pvs_coupon_status(value) 
	{
		jQuery.ajax({
			type:'POST',
			url:ajaxurl,
			data:'action=pvs_coupon_status&id=' + value,
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
	
	//Get credits type
	$coupon_type = 0;
	if ( isset( $_GET["coupon_type"] ) ) {
		$coupon_type = ( int )$_GET["coupon_type"];
	}
	if ( isset( $_POST["coupon_type"] ) ) {
		$coupon_type = ( int )$_POST["coupon_type"];
	}
	
	//Items
	$items = 30;
	if ( isset( $_REQUEST["items"] ) ) {
		$items = ( int )$_REQUEST["items"];
	}
	
	//Search variable
	$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
		$items . "&pub_type=" . $pub_type . "&coupon_type=" . $coupon_type;
	
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
			$com = " order by data2 ";
		}
		if ( $adate == 2 ) {
			$com = " order by data2 desc ";
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
	
		if ( $search_type == "code" ) {
			$com2 .= " and coupon_code='" . $search . "' ";
		}
		if ( $search_type == "login" ) {
			$com2 .= " and user = '" . $search . "' ";
		}
	
	}
	
	if ( $pub_type == "plus" ) {
		$com2 .= " and used=0 ";
	}
	if ( $pub_type == "minus" ) {
		$com2 .= " and used=1 ";
	}
	
	if ( $coupon_type != 0 ) {
		$com2 .= " and coupon_id=" . $coupon_type . " ";
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
	
	$sql = "select id_parent,title,user,data,data2,total,percentage,url,ulimit,tlimit,coupon_code,coupon_id,used from " .
		PVS_DB_PREFIX . "coupons where id_parent>0 ";
	
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
	<option value="code" <?php
	if ( $search_type == "code" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "code" )?></option>
	
	</select>
	</div>
	
	
	
	
	
	
	
	
	
	
	<div class="toleft">
	<span><?php echo pvs_word_lang( "type" )?>:</span>
	<select name="pub_type" style="width:200px" class="ft">
	<option value="all"><?php echo pvs_word_lang( "all" )?></option>
	<option value="plus" <?php
	if ( $pub_type == "plus" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "active" )?></option>
	<option value="minus" <?php
	if ( $pub_type == "minus" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "expired" )?></option>
	
	</select>
	</div>
	
	
	<div class="toleft">
	<span><?php echo pvs_word_lang( "types of coupons" )?>:</span>
	<select name="coupon_type" style="width:200px" class="ft">
	<option value="0"><?php echo pvs_word_lang( "all" )?></option>
	<?php
	$sql = "select id_parent,title from " . PVS_DB_PREFIX .
		"coupons_types where bonus=0";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$sel = "";
		if ( $coupon_type == $ds->row["id_parent"] ) {
			$sel = "selected";
		}
	?><option value="<?php echo $ds->row["id_parent"] ?>" <?php echo $sel
	?>><?php echo $ds->row["title"] ?></option><?php
		$ds->movenext();
	}
	?>
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
	
	
	<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('coupons/index.php'), "&" . $var_search .
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
	
	
	
	<form method="post" action="<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
	<input type="hidden" name="action" value="delete">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
	<th class="hidden-phone hidden-tablet">
	<a href=<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>&<?php echo $var_search
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
	<th><?php echo pvs_word_lang( "code" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "title" )?></th>
	<th><?php echo pvs_word_lang( "user" )?></th>
	
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "times usage" )?></th>
	<th class="hidden-phone hidden-tablet">
	<a href="<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>&<?php echo $var_search
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
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "expiration date" )?></th>
	
	<th><?php echo pvs_word_lang( "status" )?></th>
		
	</tr>
	</thead>
	<?php
		
		while ( ! $rs->eof ) {
			if ( $rs->row["data"] < pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
				date( "m" ), date( "d" ), date( "Y" ) ) ) {
				$sql = "update " . PVS_DB_PREFIX . "coupons set used=1 where id_parent=" . $rs->
					row["id_parent"];
				$db->execute( $sql );
	
				$rs->row["used"] = 1;
			}
	?>
	<tr valign="top">
	<td><input type="checkbox" name="sel<?php echo $rs->row["id_parent"] ?>" id="sel<?php echo $rs->row["id_parent"] ?>"></td>
	<td class="hidden-phone hidden-tablet"><?php echo $rs->row["id_parent"] ?></td>
	<td><a href="<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>&action=content&id=<?php echo $rs->row["id_parent"] ?>"><?php echo $rs->row["coupon_code"] ?></a></td>
	<td class="big hidden-phone hidden-tablet"><?php echo $rs->row["title"];
			if ( $rs->row["total"] != 0 or $rs->row["percentage"] != 0 ) {
				if ( $rs->row["total"] != 0 )
				{
					echo ( " - " . pvs_currency( 0 ) . $rs->row["total"] . " " . pvs_currency( 1 ) );
				}
				if ( $rs->row["percentage"] != 0 )
				{
					echo ( " - " . $rs->row["percentage"] . "%" );
				}
			}
	?>
	</td>
	
	<td><div class="link_user">
	<?php
			if ( $rs->row["user"] != "" ) {
	?>
	<a href="<?php
		echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
	?>&action=content&id=<?php
				echo $rs->row["user"]?>"><?php
				echo pvs_user_id_to_login( $rs->row["user"] )?></a>
	<?php
			} else {
	
				echo pvs_word_lang( "all" )?>
	
	<?php
			}
	?>
	</div>
	</td>
	
	<td class="hidden-phone hidden-tablet"><?php echo $rs->row["tlimit"] ?>(<?php echo $rs->row["ulimit"] ?>)</td>
	<td class="gray hidden-phone hidden-tablet"><?php echo date( date_format, $rs->row["data2"] )?></td>
	
	<td class="gray hidden-phone hidden-tablet"><?php echo date( date_format, $rs->row["data"] )?></td>
	
	<td>
	<?php
			$cl = "";
			if ( $rs->row["used"] == 1 ) {
				$cl = "class='red'";
			}
	?>
	<div id="status<?php echo $rs->row["id_parent"] ?>" name="status<?php echo $rs->row["id_parent"] ?>" class="link_status"><a href="javascript:pvs_coupon_status(<?php echo $rs->row["id_parent"] ?>);" <?php echo $cl
	?>><?php
			if ( $rs->row["used"] == 1 ) {
				echo ( pvs_word_lang( "expired" ) );
			} else {
				echo ( pvs_word_lang( "active" ) );
			}
	?></a></div>
	
	
	
	
	
	
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
	<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('coupons/index.php'), "&" . $var_search .
			$var_sort ) );
	?></div>
	<?php
	} else
	{
		echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
	}
}
?>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>