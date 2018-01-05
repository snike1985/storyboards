<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_downloads" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Restore
if ( @$_REQUEST["action"] == 'restore' )
{
	include ( "restore.php" );
}

?>





<h1><?php echo pvs_word_lang( "downloads" )?></h1>





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

$type = "";
if ( isset( $_REQUEST["type"] ) ) {
	$type = pvs_result( $_REQUEST["type"] );
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
	$items . "&type=" . $type;

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
	if ( $search_type == "user" ) {
		$com2 .= " and user_id=" . pvs_user_login_to_id( pvs_result( $search ) ) . " ";
	}
	if ( $search_type == "order" ) {
		$com2 .= " and order_id=" . ( int )$search . " ";
	}
	if ( $search_type == "subscription" ) {
		$com2 .= " and subscription_id=" . ( int )$search . " ";
	}
	if ( $search_type == "file" ) {
		$com2 .= " and publication_id=" . ( int )$search . " ";
	}
}

if ( $type != "" ) {
	if ( $type == "order" ) {
		$com2 .= " and order_id>0 ";
	}
	if ( $type == "subscription" ) {
		$com2 .= " and subscription_id>0 ";
	}
	if ( $type == "free" ) {
		$com2 .= " and order_id=0 and subscription_id=0 ";
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

$sql = "select * from " . PVS_DB_PREFIX . "downloads where id>0 ";

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
<option value="user" <?php
if ( $search_type == "user" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "user" )?></option>
<option value="order" <?php
if ( $search_type == "order" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "order" )?> ID</option>
<option value="subscription" <?php
if ( $search_type == "subscription" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "subscription" )?> ID</option>
<option value="file" <?php
if ( $search_type == "file" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "item" )?> ID</option>
</select>
</div>




<div class="toleft">
<span><?php echo pvs_word_lang( "type" )?>:</span>
<select name="type" style="width:200px;display:inline" class="ft">
<option value="all" <?php
if ( $type == "all" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "all" )?></option>
<option value="order" <?php
if ( $type == "order" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "order" )?></option>
<option value="subscription" <?php
if ( $type == "subscription" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "subscription" )?></option>
<option value="free" <?php
if ( $type == "free" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "free download" )?></option>
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


<div style="padding:0px 9px 15px 6px"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('downloads/index.php'), "&" . $var_search .
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



<form method="post" action="<?php echo(pvs_plugins_admin_url('downloads/index.php'));?>" style="margin:0px"  id="adminform" name="adminform">
<input type="hidden" name="action" value="delete">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>


<th colspan="2"><?php echo pvs_word_lang( "file" )?></th>

<th class="hidden-phone hidden-tablet">
<a href="<?php echo(pvs_plugins_admin_url('downloads/index.php'));?>&<?php echo $var_search
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

<th><?php echo pvs_word_lang( "price" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "download" )?></th>



</tr>
</thead>
<?php
	
	while ( ! $rs->eof ) {
		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_downloads_id"] ) and ! isset( $_SESSION["admin_rows_downloads" .
			$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_downloads_id"] ) {
			$cl3 = "<span class='label label-danger downloads" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('downloads" . $rs->row["id"] . "')\"";
		}
		if ((int)$rs->row["collection_id"] == 0) { 
			$preview = "";
			$preview_size = "";
	
			$sql = "select server1,title,media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )
				$rs->row["publication_id"];
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				if ( pvs_media_type ($ds->row["media_id"]) == 'photo' )
				{
					$preview = pvs_show_preview( $rs->row["publication_id"], "photo", 1, 1, $ds->
						row["server1"], $rs->row["publication_id"] );
					$preview_title = $ds->row["title"];
					$preview_class = 1;
		
					$image_width = 0;
					$image_height = 0;
					$image_filesize = 0;
					$flag_storage = false;
		
					if ( pvs_is_remote_storage() )
					{
						$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
							PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["publication_id"];
						$ds->open( $sql );
						while ( ! $ds->eof )
						{
							if ( $ds->row["item_id"] != 0 )
							{
								$image_width = $ds->row["width"];
								$image_height = $ds->row["height"];
								$image_filesize = $ds->row["filesize"];
							}
		
							$flag_storage = true;
							$ds->movenext();
						}
					}
		
					$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
						row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						if ( ! $flag_storage )
						{
							if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
								$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
							{
								$size = @getimagesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
									"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
								$image_width = $size[0];
								$image_height = $size[1];
								$image_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
									"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
							}
						}
		
						$sql = "select size from " . PVS_DB_PREFIX . "sizes where id_parent=" . $dr->
							row["price_id"];
						$dn->open( $sql );
						if ( ! $dn->eof )
						{
							if ( $dn->row["size"] != 0 and $image_width != 0 and $image_height != 0 )
							{
								if ( $image_width > $image_height )
								{
									$image_height = round( $image_height * $dn->row["size"] / $image_width );
									$image_width = $dn->row["size"];
								} else
								{
									$image_width = round( $image_width * $dn->row["size"] / $image_height );
									$image_height = $dn->row["size"];
								}
								$image_filesize = 0;
							}
						}
					}
		
					$preview_size = "<br>" . $image_width . "x" . $image_height;
					if ( $image_filesize != 0 )
					{
						$preview_size .= " " . strval( pvs_price_format( $image_filesize / ( 1024 * 1024 ),
							3 ) ) . " Mb.";
					}
				}
			}
	
			if ( pvs_media_type ($ds->row["media_id"]) == 'video' ) {
				$preview = pvs_show_preview( $rs->row["publication_id"], "video", 1, 1, $ds->
					row["server1"], $rs->row["publication_id"] );
				$preview_title = $ds->row["title"];
				$preview_class = 2;
	
				$flag_storage = false;
				$file_filesize = 0;
	
				if ( pvs_is_remote_storage() )
				{
					$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
						"filestorage_files where id_parent=" . $rs->row["publication_id"] .
						" and item_id=" . $rs->row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$file_filesize = $dr->row["filesize"];
						$flag_storage = true;
					}
				}
	
				if ( ! $flag_storage )
				{
					$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
						row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
							$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
						{
							$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
								"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
						}
					}
				}
	
				$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
					1024 ), 3 ) ) . " Mb.";
			}
	
			if ( pvs_media_type ($ds->row["media_id"]) == 'audio' )
			{
				$preview = pvs_show_preview( $rs->row["publication_id"], "audio", 1, 1, $ds->
					row["server1"], $rs->row["publication_id"] );
				$preview_title = $ds->row["title"];
				$preview_class = 3;
	
				$flag_storage = false;
				$file_filesize = 0;
	
				if ( pvs_is_remote_storage() )
				{
					$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
						"filestorage_files where id_parent=" . $rs->row["publication_id"] .
						" and item_id=" . $rs->row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$file_filesize = $dr->row["filesize"];
						$flag_storage = true;
					}
				}
	
				if ( ! $flag_storage )
				{
					$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
						row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
							$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
						{
							$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
								"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
						}
					}
				}
	
				$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
					1024 ), 3 ) ) . " Mb.";
			}
	
			if ( pvs_media_type ($ds->row["media_id"]) == 'vector' )
			{
				$preview = pvs_show_preview( $rs->row["publication_id"], "vector", 1, 1, $ds->
					row["server1"], $rs->row["publication_id"] );
				$preview_title = $ds->row["title"];
				$preview_class = 4;
	
				$flag_storage = false;
				$file_filesize = 0;
	
				if ( pvs_is_remote_storage() )
				{
					$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
						"filestorage_files where id_parent=" . $rs->row["publication_id"] .
						" and item_id=" . $rs->row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$file_filesize = $dr->row["filesize"];
						$flag_storage = true;
					}
				}
	
				if ( ! $flag_storage )
				{
					$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
						row["id_parent"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
							$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
						{
							$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
								"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
						}
					}
				}
	
				$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
					1024 ), 3 ) ) . " Mb.";
			}
	
			$item_name = "";
			$sql = "select name from " . PVS_DB_PREFIX . "items where id=" . ( int )$rs->
				row["id_parent"];
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$item_name = "<br><b>" . $ds->row["name"] . "</b>";
			}
	?>
				<tr valign="top" <?php echo $cl_script ?>>
					<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
					<td><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php echo $rs->row["publication_id"] ?>"><img src="<?php echo $preview
	?>"></a> </td>
					<td><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php echo $rs->row["publication_id"] ?>"><b>#<?php echo $rs->row["publication_id"] ?></b></a>  <?php echo $cl3
	?><?php echo $item_name
	?><?php echo $preview_size
	?></td>
					
					<td><?php echo date( date_format, ( $rs->row["data"] - $pvs_global_settings["download_expiration"] *
				3600 * 24 ) )?></td>
					<td>
						<?php
			$price = 0;
	
			if ( $rs->row["order_id"] != 0 ) {
				echo ( "<a href='" . pvs_plugins_admin_url('orders/index.php') . "&action=order_content&id=" . $rs->row["order_id"] . "'>" .
					pvs_word_lang( "order" ) . "&nbsp;#" . $rs->row["order_id"] . "</a>" );
	
				$sql = "select price from " . PVS_DB_PREFIX . "items where id=" . $rs->row["id_parent"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$price = $ds->row["price"];
				}
			} elseif ( $rs->row["subscription_id"] != 0 ) {
				echo ( "<a href='" . pvs_plugins_admin_url('subscription_list/index.php') . "&action=content&id=" . $rs->row["subscription_id"] .
					"'>" . pvs_word_lang( "subscription" ) .
					"&nbsp;#" . $rs->row["subscription_id"] . "</a>" );
	
				$sql = "select price from " . PVS_DB_PREFIX . "items where id=" . $rs->row["id_parent"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$price = $ds->row["price"];
				}
			} else {
				echo ( pvs_word_lang( "free" ) );
			}
	?>
					</td>
					<td><div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user_id"] )?></a></div></td>
					<td><span class="price"><?php echo pvs_currency( 1, true );
?><?php echo pvs_price_format( $price, 2 )?> <?php echo pvs_currency( 2, true );
?></span></td>
					<td>
						<?php
			if ( $rs->row["tlimit"] > $rs->row["ulimit"] or $rs->row["data"] < pvs_get_time
				( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) ) {
				echo ( pvs_word_lang( "expired" ) . " - <a href='" . pvs_plugins_admin_url('downloads/index.php') . "&action=restore&id=" . $rs->row["id"] .
					"'>" . pvs_word_lang( "restore link" ) . "</a>" );
			} else {
	?>
							<a href="<?php
				echo site_url()?>/download/?f=<?php
				echo $rs->row["link"] ?>"><b><?php
				echo pvs_word_lang( "link" )?></b></a><br>
							<?php
				echo pvs_word_lang( "downloads" )?>: <?php
				echo $rs->row["tlimit"] ?>(<?php
				echo $rs->row["ulimit"] ?>)
							<?php
			}
	?>
					</td>
				</tr>
				<?php
				} else {
					$sql = "select id, title, price, description from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . (int)$rs->row["collection_id"];
					$dd->open( $sql );
					if ( ! $dd->eof ) {
						$collection_result = pvs_show_collection_preview($dd->row["id"]);
	?>
				<tr valign="top" <?php echo $cl_script
	?>>
					<td><input type="checkbox" name="sel<?php echo $rs->row["id"] ?>" id="sel<?php echo $rs->row["id"] ?>"></td>
					<td><a href="<?php echo(pvs_plugins_admin_url('collections/index.php'));?>&action=content&id=<?php echo $rs->row["collection_id"] ?>"><img src="<?php echo $collection_result["photo"]; ?>" style="max-width:<?php echo $pvs_global_settings["thumb_width"]; ?>px;max-height:<?php echo $pvs_global_settings["thumb_width"]; ?>px"></a></td>
					<td><a href="<?php echo(pvs_plugins_admin_url('collections/index.php'));?>&action=content&id=<?php echo $rs->row["collection_id"] ?>"><b><?php echo pvs_word_lang("Collection"); ?>: <?php echo $dd->row["title"]; ?> (<?php echo pvs_count_files_in_collection($dd->row["id"]); ?>)</b></a> <?php echo $cl3
	?></td>
					
					<td><?php echo date( date_format, ( $rs->row["data"] - $pvs_global_settings["download_expiration"] *
				3600 * 24 ) )?></td>
					<td>
						<?php
			if ( $rs->row["order_id"] != 0 ) {
				echo ( "<a href='" . pvs_plugins_admin_url('orders/index.php') . "&action=order_content&id=" . $rs->row["order_id"] . "'>" .
					pvs_word_lang( "order" ) . "&nbsp;#" . $rs->row["order_id"] . "</a>" );
			}
	?>
					</td>
					<td><div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user_id"] )?></a></div></td>
					<td><span class="price"><?php echo pvs_currency( 1, true );
?><?php echo pvs_price_format( $dd->row["price"], 2 )?> <?php echo pvs_currency( 2, true );
?></span></td>
					<td>
						<?php
			if ( $rs->row["tlimit"] > $rs->row["ulimit"] or $rs->row["data"] < pvs_get_time
				( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) ) {
				echo ( pvs_word_lang( "expired" ) . " - <a href='" . pvs_plugins_admin_url('downlaods/index.php') . "&action=restore&id=" . $rs->row["id"] .
					"'>" . pvs_word_lang( "restore link" ) . "</a>" );
			} else {
	?>
							<a href="<?php
				echo site_url()?>/download/?f=<?php
				echo $rs->row["link"] ?>"><b><?php
				echo pvs_word_lang( "link" )?></b></a><br>
							<?php
				echo pvs_word_lang( "downloads" )?>: <?php
				echo $rs->row["tlimit"] ?>(<?php
				echo $rs->row["ulimit"] ?>)
							<?php
			}
	?>
					</td>
				</tr>	
					<?php
					}
				}
		

		$rs->movenext();
	}
?>
</table>


<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "delete" )?>"  style="margin:15px 0px 0px 6px;">






</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('downloads/index.php'), "&" . $var_search .
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