<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_customers" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}


//Delete photo
if ( @$_REQUEST["action"] == 'delete_photo' )
{
	include ( "delete_photo.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}


//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
	?>
	
	
	
	
	<a class="btn btn-success toright" href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content"><i class="icon-user icon-white"></i> <?php echo pvs_word_lang( "add" )?></a>
	
	<h1><?php echo pvs_word_lang( "customers" )?>:</h1>
	

	
	
	
	
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
	
	//Sort by title
	$atitle = 0;
	if ( isset( $_GET["atitle"] ) ) {
		$atitle = ( int )$_GET["atitle"];
	}
	
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
	if ( $atitle == 0 and $adate == 0 and $aid == 0 ) {
		$adate = 2;
	}
	
	//Add sort variable
	$com = "";
	
	if ( $atitle != 0 ) {
		$var_sort = "&atitle=" . $atitle;
		if ( $atitle == 1 ) {
			$com = " order by user_login ";
		}
		if ( $atitle == 2 ) {
			$com = " order by user_login desc ";
		}
	}
	
	if ( $adate != 0 ) {
		$var_sort = "&adate=" . $adate;
		if ( $adate == 1 ) {
			$com = " order by user_registered ";
		}
		if ( $adate == 2 ) {
			$com = " order by user_registered desc ";
		}
	}
	
	if ( $aid != 0 ) {
		$var_sort = "&aid=" . $aid;
		if ( $aid == 1 ) {
			$com = " order by ID ";
		}
		if ( $aid == 2 ) {
			$com = " order by ID desc ";
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
			$com2 .= " and (display_name like '%" . $search . "%' ) ";
		}
		if ( $search_type == "id" ) {
			$com2 .= " and ID=" . ( int )$search . " ";
		}
		if ( $search_type == "login" ) {
			$com2 .= " and user_login = '" . $search . "' ";
		}
		if ( $search_type == "email" ) {
			$com2 .= " and user_email = '" . $search . "' ";
		}
	}
	
	if ( $pub_type == "buyer" ) {
		$com2 .= " and utype='buyer' ";
	}
	if ( $pub_type == "seller" ) {
		$com2 .= " and utype='seller' ";
	}
	if ( $pub_type == "affiliate" ) {
		$com2 .= " and utype='affiliate' ";
	}
	if ( $pub_type == "common" ) {
		$com2 .= " and utype='common' ";
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
	
	$sql = "select ID, user_login, user_email, user_registered, display_name from " . $table_prefix . "users where ID>0 ";
	
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
	<option value="name" <?php
	if ( $search_type == "name" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "name" )?></option>
	<option value="email" <?php
	if ( $search_type == "email" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "email" )?></option>
	</select>
	</div>
	
	
	
	
	
	
	
	
	
	
	<div class="toleft">
	<span><?php echo pvs_word_lang( "type" )?>:</span>
	<select name="pub_type" style="width:100px" class="ft">
	<option value="all"><?php echo pvs_word_lang( "all" )?></option>
	<option value="buyer" <?php
	if ( $pub_type == "buyer" ) {
		echo ( "selected" );
	}
	?>><?php echo pvs_word_lang( "buyer" )?></option>
	<?php
	if ( $pvs_global_settings["userupload"] == 1 ) {
	?>
	<option value="seller" <?php
		if ( $pub_type == "seller" ) {
			echo ( "selected" );
		}
	?>><?php echo pvs_word_lang( "seller" )?></option>
	<?php
	}
	
	if ( $pvs_global_settings["affiliates"] ) {
	?>
	<option value="affiliate" <?php
		if ( $pub_type == "affiliate" ) {
			echo ( "selected" );
		}
	?>><?php echo pvs_word_lang( "affiliate" )?></option>
	<?php
	}
	
	if ( $pvs_global_settings["common_account"] ) {
	?>
	<option value="common" <?php
		if ( $pub_type == "common" ) {
			echo ( "selected" );
		}
	?>><?php echo pvs_word_lang( "common" )?></option>
	<?php
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
	
	
	<div style="padding:0px 0px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('customers/index.php'), "&" . $var_search .
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
	
	
	
	<form method="post" action="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
	<input type="hidden" name="action" value="delete">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
	<th class="hidden_original"></th>
	<th class="hidden-phone hidden-tablet">
	<a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&<?php echo $var_search
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
	
	<th style="width:10%">
	
	
	<a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&<?php echo $var_search
	?>&atitle=<?php
		if ( $atitle == 1 ) {
			echo ( 2 );
		} else {
			echo ( 1 );
		}
	?>"><?php echo pvs_word_lang( "login" )?></a> <?php
		if ( $atitle == 1 ) {
	?><img src="<?php echo(pvs_plugins_url());?>/assets/images/sort_up.gif" width="11" height="8"><?php
		}
	?><?php
		if ( $atitle == 2 ) {
	?><img src="<?php echo(pvs_plugins_url());?>/assets/images/sort_down.gif" width="11" height="8"><?php
		}
	?>
	
	</th>
	
	
	<th class="hidden-phone hidden-tablet" style="width:10%"><?php echo pvs_word_lang( "E-mail" )?></ht>
	
	<th class="hidden-phone hidden-tablet" style="width:10%">
	<a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&<?php echo $var_search
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
	
	
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "type" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "authorization" )?></th>
	<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "preview" )?></th>
	
	<th><?php echo pvs_word_lang( "edit" )?></th>
	</tr>
	</thead>
	<?php
		
		while ( ! $rs->eof ) {
			$cl3 = "";
			$cl_script = "";
			if ( isset( $_SESSION["user_users_id"] ) and ! isset( $_SESSION["admin_rows_users" .
				$rs->row["ID"]] ) and $rs->row["ID"] > $_SESSION["user_users_id"] ) {
				$cl3 = "<span class='label label-danger users" . $rs->row["ID"] . "'>" . pvs_word_lang("new") . "</span>";
				$cl_script = "onMouseover=\"pvs_deselect_row('users" . $rs->row["ID"] . "')\"";
			}
	
			$user_info = get_userdata($rs->row["ID"]);
	?>
	<tr <?php echo $cl_script
	?>>
	<td><input type="checkbox" name="sel<?php echo $rs->row["ID"] ?>" id="sel<?php echo $rs->row["ID"] ?>"></td>
	<td class="hidden_original"><?php echo get_avatar($rs->row["ID"])
	?></td>
	<td class="hidden-phone hidden-tablet"><?php echo $rs->row["ID"] ?></td>
	
	
	<td><div><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php echo $rs->row["ID"] ?>"><b><?php echo $rs->row["user_login"] ?></b></a> <?php echo $cl3
	?></div></td>
	<td class="hidden-phone hidden-tablet">
		<?php
			if ( $rs->row["user_email"] != "" ) {
	?>
			<div class="link_email"><a href="mailto:<?php
				echo $rs->row["user_email"] ?>"><?php
				echo $rs->row["user_email"] ?></a></div>
		<?php
			} else {
				echo ( "&mdash;" );
			}
	?>
	</td>
	<td class="gray hidden-phone hidden-tablet"><?php echo $rs->row["user_registered"] ?></td>
	
	<td class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( pvs_get_user_type ($rs->row["ID"]) )?></td>
	<td class="hidden-phone hidden-tablet">
	<?php
			if ( @$user_info -> authorization == "site" or  @$user_info -> authorization == "") {
				echo ( pvs_word_lang( "website" ) );
			} else {
				if ( @$user_info -> authorization == "twitter" )
				{
					echo ( "<a href='http://www.twitter.com/" . $rs->row["user_login"] . "'>Twitter</a>" );
				}
				if ( preg_match( "/facebook/i", @$user_info -> authorization ) )
				{
					if ( preg_match( "/^fb/i", $rs->row["user_login"] ) )
					{
						echo ( "<a href='https://www.facebook.com/app_scoped_user_id/" . str_replace( "fb",
							"", $rs->row["user_login"] ) . "'>Facebook</a>" );
					} elseif ( preg_match( "/^facebook/i", @$user_info -> authorization ) )
					{
						echo ( "<a href='https://www.facebook.com/app_scoped_user_id/" . str_replace( "facebook",
							"", @$user_info -> authorization ) . "'>Facebook</a>" );
					} else
					{
						echo ( "Facebook" );
					}
				}
				if ( @$user_info -> authorization == "vk" )
				{
					echo ( "<a href='http://vk.com/id" . str_replace( "vk", "", $rs->row["user_login"] ) .
						"'>Vkontakte</a>" );
				}
				if ( @$user_info -> authorization == "instagram" )
				{
					echo ( "<a href='http://instagram.com/" . str_replace( "instagram_", "", $rs->
						row["login"] ) . "'>Instagram</a>" );
				}
				if ( @$user_info -> authorization == "yandex" )
				{
					echo ( "Yandex" );
				}
				if ( @$user_info -> authorization == "google" )
				{
					echo ( "Google" );
				}
			}
	?>
	</td>
	
	<td class="hidden-phone hidden-tablet"><div class="link_preview"><a href="<?php echo pvs_user_url( $rs->row["ID"] );?>"><?php echo pvs_word_lang( "preview" )?></a></div></td>
	
	<td><div class="link_edit"><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php echo $rs->row["ID"] ?>"><?php echo pvs_word_lang( "edit" )?></a></div></td>
	</tr>
	<?php
			$n++;
			
			$rs->movenext();
		}
	?>
	</table>
	
	
	<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "delete" )?>"  style="margin:15px 0px 0px 6px;">
	
	
	
	
	
	
	</form>
	<div style="padding:25px 0px 0px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('customers/index.php'), "&" . $var_search .
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