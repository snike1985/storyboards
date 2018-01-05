<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_support" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Delete post
if ( @$_REQUEST["action"] == 'delete_post' )
{
	include ( "delete_post.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
	?>
	
	
	
	
	
	<h1><?php echo pvs_word_lang( "support" )?>:</h1>
	
	
	<script>
	
	function pvs_support_status(value) 
	{
		jQuery.ajax({
			type:'POST',
			url:ajaxurl,
			data:'action=pvs_support_status&id=' + value,
			success:function(data){
				if(data.charAt(data.length-1) == '0')
				{
					data = data.substring(0,data.length-1)
				}
				document.getElementById('status'+value).innerHTML = data;
			}
		});
	}
	
	
	
	</script>
	
	
	<script src="<?php echo pvs_plugins_url()?>/assets/js/raty/jquery.raty.min.js"></script>
	
	<script>
		$(function() {
		  $.fn.raty.defaults.path = '<?php echo pvs_plugins_url()?>/assets/js/raty/img';
	
		  $('.star').raty({ score: 3 });
		  
		});
	</script>
	
	
	
	<?php
	//Get Search
	$search = "";
	if ( isset( $_REQUEST["search"] ) ) {
		$search = pvs_result( $_REQUEST["search"] );
	}
	
	
	//Items
	$items = 30;
	if ( isset( $_REQUEST["items"] ) ) {
		$items = ( int )$_REQUEST["items"];
	}
	
	//Search variable
	$var_search = "search=" . $search . "&items=" . $items;
	
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
	
		$com2 .= " and user_id='" . pvs_user_login_to_id( $search ) . "' ";
	
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
	
	$sql = "select id,id_parent,admin_id,user_id,subject,message,data,viewed_admin,viewed_user,rating,closed from " .
		PVS_DB_PREFIX . "support_tickets where id_parent=0 ";
	
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
	<span><?php echo pvs_word_lang( "user" )?>:</span>
	<input type="text" name="search" style="width:200px" class="ft" value="<?php echo $search
	?>" onClick="this.value=''">
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
	
	
	<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('support/index.php'), "&" . $var_search .
			$var_sort ) );
	?></div>
	
	
	
	
	
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th class="hidden-phone hidden-tablet">
	<a href="<?php echo(pvs_plugins_admin_url('support/index.php'));?>&<?php echo $var_search
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
	<th width="35%"><?php echo pvs_word_lang( "subject" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "rating" )?></th>
	<th class="hidden-phone hidden-tablet">
	<a href="<?php echo(pvs_plugins_admin_url('support/index.php'));?>&<?php echo $var_search
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
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "user" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "status" )?></th>
	
	
	
	<th></th>
	
	</tr>
	</thead>
	<?php
		
	
		while ( ! $rs->eof ) {
			$new_messages = 0;
			$total_messages = 1;
			$rating = 0;
			$rating_count = 0;
	
			if ( $rs->row["viewed_admin"] == 0 ) {
				$new_messages++;
			}
	
			$sql = "select id,viewed_admin,admin_id,rating,user_id from " . PVS_DB_PREFIX .
				"support_tickets where id_parent=" . $rs->row["id"];
			$ds->open( $sql );
			while ( ! $ds->eof ) {
				if ( $ds->row["viewed_admin"] == 0 and $ds->row["admin_id"] == 0 )
				{
					$new_messages++;
				}
	
				if ( $ds->row["admin_id"] != 0 and $ds->row["rating"] != 0 )
				{
					$rating += $ds->row["rating"];
					$rating_count++;
				}
	
				$total_messages++;
				$ds->movenext();
			}
	
			if ( $new_messages > 0 ) {
				$style = "badge-important";
			} else {
				$style = "";
			}
	?>
	<tr valign="top" 
	<?php
			if ( $new_messages > 0 ) {
				echo ( "class='snd2 danger'" );
			} else {
	
			}
	?>
	>
	<td class="hidden-phone hidden-tablet"><?php echo $rs->row["id"] ?></td>
	<td><span class="badge <?php echo $style
	?>"><?php echo $total_messages
	?></span> <a href="<?php echo(pvs_plugins_admin_url('support/index.php'));?>&action=content&id=<?php echo $rs->row["id"] ?>"><?php echo $rs->row["subject"] ?></a></td>
	<td class="hidden-phone hidden-tablet">
	<?php
			if ( $rating_count != 0 ) {
				$rating = $rating / $rating_count;
			}
	?>
	<script>
					$(function() {
						$('#star<?php echo $rs->row["id"] ?>').raty({
						score: <?php echo $rating
	?>,
						half: true,
						number: 5,
						readOnly   : true
					});
					});
					</script>
					<div id="star<?php echo $rs->row["id"] ?>" style="margin-top:7px"></div>
	</td>
	<td class="gray hidden-phone hidden-tablet"><?php echo pvs_show_time_ago( $rs->row["data"] )?></td>
	<td class="hidden-phone hidden-tablet"><div class="link_user"><a href="<?php
		echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
	?>&action=content&id=<?php
				echo $rs->row["user_id"]?>"><?php
				echo pvs_user_id_to_login( $rs->row["user_id"] )?></a></div></td>
	<td class="hidden-phone hidden-tablet">
	
	<?php
			$cl = "";
			if ( $rs->row["closed"] != 1 ) {
				$cl = "class='red'";
			}
	?>
	
	<div id="status<?php echo $rs->row["id"] ?>" name="status<?php echo $rs->row["id"] ?>" class="link_status"><a href="javascript:pvs_support_status(<?php echo $rs->row["id"] ?>);" <?php echo $cl
	?>><?php
			if ( $rs->row["closed"] == 1 ) {
				echo ( pvs_word_lang( "closed" ) );
			} else {
				echo ( pvs_word_lang( "in progress" ) );
			}
	?></a></div>
	
						
	</td>
	
	
	
	<td><div class="link_delete"><a href="<?php echo(pvs_plugins_admin_url('support/index.php'));?>&action=delete&id=<?php echo $rs->row["id"] ?>&<?php echo $var_search . $var_sort
	?>"  onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');"><?php echo pvs_word_lang( "delete" )?></a></div></td>
	</tr>
	<?php
			$n++;
			
			$rs->movenext();
		}
	?>
	</table>
	
	
	
	
	<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('support/index.php'), "&" . $var_search .
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