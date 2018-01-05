<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );

$sql = "select id,media_id,title,description,published,userid,viewed,downloaded,data,server1,refuse_reason,exclusive,author from " .
	PVS_DB_PREFIX . "media where  ". $table . " and examination=0 and userid>0 " . $com . " " . $com2;
$rs->open( $sql );
$record_count = $rs->rc;

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;
$sql .= $lm;


$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><?php echo pvs_word_lang( "preview" )?></th>

<th nowrap class="hidden-phone hidden-tablet"><a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&d=<?php echo $d
?>&status=<?php echo $pstatus
?><?php echo $varsort_id
?>">ID</a> <?php
	if ( $pid == 1 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $pid == 2 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_down.gif"><?php
	}
?></th>



<th nowrap class="hidden-phone hidden-tablet"><a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&d=<?php echo $d
?>&status=<?php echo $pstatus
?><?php echo $varsort_title
?>"><?php echo pvs_word_lang( "title" )?></a>  <?php
	if ( $ptitle == 1 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $ptitle == 2 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th nowrap><a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&d=<?php echo $d
?>&status=<?php echo $pstatus
?><?php echo $varsort_user
?>"><?php echo pvs_word_lang( "user" )?></a>  <?php
	if ( $puser == 1 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $puser == 2 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_down.gif"><?php
	}
?></th>



<th nowrap class="hidden-phone hidden-tablet"><a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&d=<?php echo $d
?>&status=<?php echo $pstatus
?><?php echo $varsort_data
?>"><?php echo pvs_word_lang( "date" )?></a>  <?php
	if ( $pdata == 1 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $pdata == 2 ) {
?><img src="<?php echo(pvs_plugins_url());
?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th><?php echo pvs_word_lang( "status" )?></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "reason for rejection" )?></th>
<?php
	if ( $pvs_global_settings["model"] ) {
?>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "models" )?></th>
<?php
	}
?>

<th><?php echo pvs_word_lang( "delete" )?></th>
</tr>
</thead>
<?php
	while ( ! $rs->eof ) {
		$preview_url = pvs_plugins_admin_url('catalog/index.php') . "&action=content&id=" . $rs->row["id"];
		$preview_url2 = "";

		$generated = "";

		if ( pvs_media_type ($rs->row["media_id"]) == 'photo' ) {
			$delete_url = "2";
			$preview = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "photo", $rs->row["server1"],
				"", "" );

			//Define if the publication is remote
			$flag_storage = false;
			$remote_file = "";
			$remote_filename = "";
			$remote_extention = "";

			$sql = "select url,filename1,filename2,width,height,item_id from " .
				PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["id"] .
				" and item_id<>0";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_file = $ds->row["url"] . "/" . $ds->row["filename2"];
				$remote_filename = $ds->row["filename1"];
				$flag_storage = true;
			}

			if ( ! $flag_storage )
			{
				$sql = "select id,id_parent,url,price,price_id from " . PVS_DB_PREFIX .
					"items where id_parent=" . $rs->row["id"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$preview_url = pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->
						row["id"] . "/" . $dr->row["url"];
					$preview_url2 = pvs_upload_dir() . pvs_server_url( $rs->
						row["server1"] ) . "/" . $rs->row["id"] . "/" . $dr->row["url"];
				}
			} else
			{
				$preview_url = $remote_file;
				$preview_url2 = $preview_url;
			}

		}

		if ( pvs_media_type ($rs->row["media_id"]) == 'video'  ) {
			$delete_url = "3";
			$preview = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "video", $rs->row["server1"],
				"", "" );

			if ( $pvs_global_settings["ffmpeg_cron"] )
			{
				$sql = "select data1 from " . PVS_DB_PREFIX . "ffmpeg_cron where id=" . $rs->
					row["id"] . " and data2=0";
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$generated = pvs_word_lang( "Previews are being created. Queue number is" );

					$queue = 1;
					$sql = "select count(id) as queue_count from " . PVS_DB_PREFIX .
						"ffmpeg_cron where data1<" . $ds->row["data1"] . " and data2=0";
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$queue = $dr->row["queue_count"];
					}

					$generated .= " <b>" . $queue . "</b>";
				}
			}
		}

		if ( pvs_media_type ($rs->row["media_id"]) == 'audio'  ) {
			$delete_url = "4";
			$preview = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "audio", $rs->row["server1"],
				"", "" );
		}

		if ( pvs_media_type ($rs->row["media_id"]) == 'vector'  ) {
			$delete_url = "5";
			$preview = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "vector", $rs->row["server1"],
				"", "" );
		}

		$cl3 = "";
		$cl_script = "";
		if ( isset( $_SESSION["user_uploads_id"] ) and ! isset( $_SESSION["admin_rows_uploads" .
			$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_uploads_id"] ) {
			$cl3 = "<span class='label label-danger uploads" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
			$cl_script = "onMouseover=\"pvs_deselect_row('uploads" . $rs->row["id"] . "')\"";
		}
?>
<tr valign="top" <?php echo $cl_script
?>>
<td class='preview_img'><a href="<?php echo $preview_url
?>" target="blank"><img src="<?php echo $preview
?>" border="0" <?php echo $hoverbox_results["hover"] ?>></a></td>
<td class="hidden-phone hidden-tablet"><?php echo $rs->row["id"] ?></td>


<td class="hidden-phone hidden-tablet"><div class="link_file"><a href='<?php echo(pvs_plugins_admin_url('catalog/index.php'));
?>&action=content&id=<?php echo $rs->row["id"] ?>'><?php echo $rs->row["title"] ?></a> <?php echo $cl3
?></div><small><?php echo $generated
?></small></td>
<td><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo pvs_user_login_to_id( $rs->row["author"] )?>"><?php
			echo $rs->row["author"] ?></a></td>
<td class="gray hidden-phone hidden-tablet"><?php echo date( date_format, $rs->row["data"] )?></td>
<td>
<?php
		if ( $rs->row["published"] == -1 and $rs->row["exclusive"] == 1 ) {
?>
	<span class="label label-success"><?php
			echo pvs_word_lang( "sold" )?></span>
<?php
		} else {
?>
<div id="status<?php
			echo $rs->row["id"] ?>" name="status<?php
			echo $rs->row["id"] ?>">


<a href="javascript:pvs_upload_moderation(<?php
			echo $rs->row["id"] ?>,1);" <?php
			if ( $rs->row["published"] != 1 )
			{
				?>class="gray"<?php
			}
?>><?php
			echo pvs_word_lang( "approved" )?></a><br>
<a href="javascript:pvs_upload_moderation(<?php
			echo $rs->row["id"] ?>,0);" <?php
			if ( $rs->row["published"] != 0 )
			{
				?>class="gray"<?php
			}
?>><?php
			echo pvs_word_lang( "pending" )?></a><br>
<a href="javascript:pvs_upload_moderation(<?php
			echo $rs->row["id"] ?>,-1);" <?php
			if ( $rs->row["published"] != -1 )
			{
				?>class="gray"<?php
			}
?>><?php
			echo pvs_word_lang( "declined" )?></a>



</div>
<?php
		}
?>
</td>
<td class="hidden-phone hidden-tablet">

<div id="reason<?php echo $rs->row["id"] ?>" style="margin-bottom:5px;display:none">
<textarea id="reason_text<?php echo $rs->row["id"] ?>" class="ibox form-control" style="width:200px;height:60px;margin-bottom:3px">
<?php echo $rs->row["refuse_reason"] ?>
</textarea>
<input type="button" onClick="pvs_refuse_reason(<?php echo $rs->row["id"] ?>)" class="btn btn-default" value="<?php echo pvs_word_lang( "save" )?>">
</div>


<div id="reason_edit<?php echo $rs->row["id"] ?>">
<div id="reason_content<?php echo $rs->row["id"] ?>"><?php echo $rs->row["refuse_reason"] ?></div>
<a href="javascript:reason_open(<?php echo $rs->row["id"] ?>)"><?php echo pvs_word_lang( "edit" )?></a>

</div>
</td>
<?php
		if ( $pvs_global_settings["model"] ) {
?>
<td class="hidden-phone hidden-tablet">
<?php
			$sql = "select publication_id,model_id,models from " . PVS_DB_PREFIX .
				"models_files where publication_id=" . $rs->row["id"];
			$dn->open( $sql );
			while ( ! $dn->eof )
			{
				$sql = "select name from " . PVS_DB_PREFIX . "models where id_parent=" . $dn->
					row["model_id"];
				$dd->open( $sql );
				if ( ! $dd->eof )
				{
					if ( $dn->row["models"] == 0 )
					{
						$model_type = pvs_word_lang( "Model release" ) . ": ";
					} else
					{
						$model_type = pvs_word_lang( "Property release" ) . ": ";
					}
?>
		<a href="<?php echo(pvs_plugins_admin_url('models/index.php'));?>&action=content&id=<?php
					echo $dn->row["model_id"] ?>"><?php
					echo $model_type
?><?php
					echo $dd->row["name"] ?></a><br>
		<?php
				}
				$dn->movenext();
			}
?>
</td>
<?php
		}
?>


<td>
<div class="link_delete"><a href='<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&action=delete&d=<?php echo $delete_url
?>&id=<?php echo $rs->row["id"] ?>' onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');"><?php echo pvs_word_lang( "delete" )?></a></div>
</td>
</tr>
<?php
		$rs->movenext();
	}
?>
</table>
<br>
<?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('upload/index.php'), "&d=" . $d .
		"&status=" . $pstatus . $varsort ) );
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>