<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>


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


<form method="post" action="<?php echo (site_url( ) );?>/publications-edit/" style="margin:0px"  id="sellerform" name="sellerform">
<?php
//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql = "select id,title,description,published,userid,viewed,downloaded,data,server1,refuse_reason,url,exclusive from " .
	PVS_DB_PREFIX . "media where " .$table . " and (userid=" . get_current_user_id() .
	" or author='" . pvs_result( pvs_get_user_login () ) . "') " . $com . " " .
	$com2;
$rs->open( $sql );
$record_count = $rs->rc;

$sql2 = $sql . $lm;

$rs->open( $sql2 );

if ( ! $rs->eof ) {
?>
<table border="0" cellpadding="0" cellspacing="0" class="profile_table">
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.sellerform);"></th>
<th><?php echo pvs_word_lang( "preview" );?></th>

<th nowrap class='hidden-phone hidden-tablet'><a href="<?php echo (site_url( ) );?>/publications/?d=<?php echo $d;
?>&status=<?php echo $pstatus;
?><?php echo $varsort_id;
?>">ID</a> <?php
	if ( $pid == 1 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $pid == 2 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th nowrap class='hidden-phone hidden-tablet'><a href="<?php echo (site_url( ) );?>/publications/?d=<?php echo $d;
?>&status=<?php echo $pstatus;
?><?php echo $varsort_title;
?>"><?php echo pvs_word_lang( "title" );?></a>  <?php
	if ( $ptitle == 1 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $ptitle == 2 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th nowrap class='hidden-phone hidden-tablet'><a href="<?php echo (site_url( ) );?>/publications/?d=<?php echo $d;
?>&status=<?php echo $pstatus;
?><?php echo $varsort_viewed;
?>"><?php echo pvs_word_lang( "viewed" );?></a> <?php
	if ( $pviewed == 1 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $pviewed == 2 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th nowrap class='hidden-phone hidden-tablet'><a href="<?php echo (site_url( ) );?>/publications/?d=<?php echo $d;
?>&status=<?php echo $pstatus;
?><?php echo $varsort_downloads;
?>"><?php echo pvs_word_lang( "downloads" );?></a>  <?php
	if ( $pdownloads == 1 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $pdownloads == 2 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th nowrap class='hidden-phone hidden-tablet'><a href="<?php echo (site_url( ) );?>/publications/?d=<?php echo $d;
?>&status=<?php echo $pstatus;
?><?php echo $varsort_data;
?>"><?php echo pvs_word_lang( "date" );?></a>  <?php
	if ( $pdata == 1 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_up.gif"><?php
	}
?><?php
	if ( $pdata == 2 ) {
?><img src="<?php echo pvs_plugins_url();?>/assets/images/sort_down.gif"><?php
	}
?></th>

<th><?php echo pvs_word_lang( "status" );?></th>
<th></th>
</tr>
<?php
	$n = 0;
	$tr = 1;
	while ( ! $rs->eof ) {

		$url = pvs_item_url( $rs->row["id"], $rs->row["url"] );

		$generated = "";

		if ( $d == 2 ) {
			$delete_url = "photo";
			$preview = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
		}

		if ( $d == 3 ) {
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

			$delete_url = "video";
			$preview = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
		}

		if ( $d == 4 ) {
			$delete_url = "audio";
			$preview = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
		}

		if ( $d == 5 ) {
			$delete_url = "vector";
			$preview = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
		}

		$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], $delete_url, $rs->
			row["server1"], $rs->row["title"], pvs_show_user_name( pvs_get_user_login () ) );?>
<tr valign="top" <?php
		if ( $tr % 2 == 0 ) {
			echo ( "class='snd'" );
		}
?>>
<td>
<input type='checkbox' id='sel<?php echo $rs->row["id"];
?>' name='sel<?php echo $rs->row["id"];
?>'>
</td>
<td><?php
		if ( $preview != "" ) {
?><?php
			if ( $rs->row["published"] == 1 )
			{
?><a href="<?php
				echo $url;
?>"><?php
			}
?><img src="<?php
			echo $preview;
?>" border="0" <?php
			echo $hoverbox_results["hover"];
?>></a><?php
		}
?></td>
<td class='hidden-phone hidden-tablet'><?php echo $rs->row["id"];
?></td>
<td class='hidden-phone hidden-tablet'><?php
		if ( $rs->row["published"] == 1 ) {
?><a href="<?php
			echo $url;
?>"><?php
		}
?><b><?php echo $rs->row["title"];
?></b></a><br><small><?php echo $generated;
?></small></td>
<td class='hidden-phone hidden-tablet'><?php echo $rs->row["viewed"];
?></td>
<td class='hidden-phone hidden-tablet'><?php echo $rs->row["downloaded"];
?></td>
<td class='hidden-phone hidden-tablet'><div class="link_date"><?php echo date( date_format, $rs->row["data"] );?></div></td>
<td>
<?php
		if ( $rs->row["published"] == 1 ) {
			echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
		}
		if ( $rs->row["published"] == 0 ) {
			echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
		}
		if ( $rs->row["published"] == -1 and $rs->row["exclusive"] != 1 ) {
			echo ( "<div class='link_pending'>" . pvs_word_lang( "declined" ) . "</div>" );
			if ( $rs->row["refuse_reason"] != "" )
			{
				echo ( "<p><b>" . pvs_word_lang( "reason for rejection" ) . ":</b> " . $rs->row["refuse_reason"] .
					"</p>" );
			}
		}
		if ( $rs->row["published"] == -1 and $rs->row["exclusive"] == 1 ) {
			echo ( "<div class='link_approved'>" . pvs_word_lang( "sold" ) . "</div>" );
		}
?>
</td>

<td><div class="link_edit">
<a href='<?php
		if ( $d == 2 ) {
			echo ( site_url() . "/filemanager-photo/" );
		}
		if ( $d == 3 ) {
			echo ( site_url() . "/filemanager-video/" );
		}
		if ( $d == 4 ) {
			echo ( site_url() . "/filemanager-audio/" );
		}
		if ( $d == 5 ) {
			echo ( site_url() . "/filemanager-vector/" );
		}
?>?id=<?php echo $rs->row["id"];
?>&d=<?php echo $d;
?>&s=1'><?php echo pvs_word_lang( "edit" );?></div></a>
</td>
</tr>
<?php
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
</table>
<p>
<?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, site_url() . "/publications/",
		"&d=" . $d . "&status=" . $pstatus . $varsort ) );?>
</p>
<p>
<input type="hidden" name="formaction" id="formaction" value="edit">
<input type="hidden" name="return_url" value="<?php echo (site_url( ) );?>/publications/?str=1<?php echo "&d=" . $d . "&status=" . $pstatus . $varsort;
?>">

<input type="submit" class="isubmit" value="<?php echo pvs_word_lang( "edit" );?>" style="margin-top:30px" onClick="document.getElementById('formaction').value='edit'"><input type="submit" class="isubmit_orange" value="<?php echo pvs_word_lang( "delete" );?>*" style="margin-top:30px;margin-left:30px" onClick="document.getElementById('formaction').value='delete';return confirm('<?php echo pvs_word_lang( "delete" );?>?');">
</p>
</form>
<p>* - <?php echo pvs_word_lang( "it is impossible to remove approved files." );?></p>
<?php
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>

