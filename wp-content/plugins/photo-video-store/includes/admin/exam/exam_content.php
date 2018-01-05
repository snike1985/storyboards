<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_exam" );
?>

<div class="back"><a href="<?php echo(pvs_plugins_admin_url('exam/index.php'));
?>" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "seller examination" )?> # <?php echo $_GET["id"] ?></h1>

<?php
$userid = 0;
$sql = "select * from " . PVS_DB_PREFIX . "examinations where id=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$userid = $rs->row["user"];
?>	
	<div class="box box_padding">
	
	<form method="post">
	<input type="hidden" name="action" value="change">
	<div class="form_field">
	<span><b><?php echo pvs_word_lang( "user" )?>:</b></span>
	<div class="link_user">
	<?php 
				$sql="select ID, user_login from " . $table_prefix . "users where ID=" . $rs->row["user"];
				$ds->open($sql);
				if(!$ds->eof)
				{
					echo("<a href='" . pvs_plugins_admin_url('customers/index.php') . "&action=content&id=".$ds->row["ID"]."'>".$ds->row["user_login"]."</a>");
				}
	?>
	</div>
	</div>
	
	<div class="form_field">
	<span><b><?php echo pvs_word_lang( "date" )?>:</b></span>
	<?php echo date( date_format, $rs->row["data"] )?>
	</div>
	
	<div class="form_field">
	<span><b><?php echo pvs_word_lang( "status" )?>:</b></span>
	<select name="status" style="width:150px">
	<option value="0" <?php
	if ( $rs->row["status"] == 0 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "pending" )?></option>
	<option value="1" <?php
	if ( $rs->row["status"] == 1 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "approved" )?></option>
	<option value="2" <?php
	if ( $rs->row["status"] == 2 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "declined" )?></option>
	</select>
	</div>
	
	<div class="form_field">
	<span><b><?php echo pvs_word_lang( "comments" )?>:</b></span>
	<textarea name="comments" style="width:400px;height:150px"><?php echo $rs->row["comments"] ?></textarea>
	</div>
	
	<div class="form_field">
	<input type="submit" value="<?php echo pvs_word_lang( "save" )?>" class="btn btn-primary">
	</div>
	</form>
<?php
}
?>

<br><br>

<?php
$exam_flag = false;
$sql = "select id, server1, media_id from " . PVS_DB_PREFIX . "media where examination=1 and userid=" . ( int )$userid . " order by id";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$n = 0;
?>
	<div class="box3"><?php
	echo pvs_word_lang( pvs_media_type ($rs->row["media_id"]) );
?>:</div>
	<table border='0' cellpadding='0' cellspacing='0' style="margin-bottom:25px">
	<tr valign='top'>
	<?php
	while ( ! $rs->eof ) {
		$exam_flag = true;

		if ( pvs_media_type ($rs->row["media_id"]) == 'photo' )
		{
			$sql = "select url from " . PVS_DB_PREFIX . "items where id_parent=" . $rs->row["id"];
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$preview_url = pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] . "/" . $ds->row["url"];
			} else
			{
				$dir = opendir( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] );
				while ( $file = readdir( $dir ) )
				{
					if ( $file <> "." && $file <> ".." )
					{
						if ( preg_match( "/.jpg$|.jpeg$/i", $file ) and ! preg_match( "/thumb/i", $file ) )
						{
							$preview_url = pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->
								row["id"] . "/" . $file;
						}
					}
				}
			}
		}

		if ( pvs_media_type ($rs->row["media_id"]) != 'photo' )
		{
			$preview_url = pvs_plugins_admin_url('catalog/index.php') . 'action=content&id=' . $rs->row["id"];
		}

		if ( pvs_media_type ($rs->row["media_id"]) == 'photo' )
		{
			$thumb = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "photo", $rs->row["server1"],
				"", "" );
		}
		if ( pvs_media_type ($rs->row["media_id"]) == 'video' )
		{
			$thumb = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "video", $rs->row["server1"],
				"", "" );
		}
		if ( pvs_media_type ($rs->row["media_id"]) == 'audio' )
		{
			$thumb = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "audio", $rs->row["server1"],
				"", "" );
		}
		if ( pvs_media_type ($rs->row["media_id"]) == 'vector' )
		{
			$thumb = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
				$rs->row["id"] );
			$hoverbox_results = pvs_get_hoverbox( $rs->row["id"], "vector", $rs->row["server1"],
				"", "" );
		}

		if ( $n % 4 == 0 )
		{
			echo ( "</tr><tr valign='top'>" );
		}
?>
		<td style="padding:0px 10px 10px 0px">
		<div style="margin-bottom:3px"><a href="<?php
		echo $preview_url
?>" target="blank"><img src="<?php
		echo $thumb
?>" border="0" <?php
		echo $hoverbox_results["hover"] ?>></a></div>
		<div style="margin-bottom:3px" class="smalltext"><b>ID:</b> <?php
		echo $rs->row["id"] ?> <a href="<?php echo(pvs_plugins_admin_url('exam/index.php'));
?>&action=delete_file&id=<?php
		echo ( $rs->row["id"] );
?>&exam_id=<?php
		echo ( ( int )$_GET["id"] );
?>" class="btn btn-default btn-xs"><i class="fa fa-times" aria-hidden="true"></i> <?php
		echo ( pvs_word_lang( "delete" ) );
?></a></div>
		</td>
		<?php
		$n++;
		$rs->movenext();
	}
?>
	</tr>
	</table>
	<?php
}
?>

</div>
