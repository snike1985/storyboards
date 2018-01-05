<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>


<h1><?php echo pvs_word_lang( "prints lab" )?>

<?php
if ( isset( $_GET["id"] ) ) {
	echo ( " &mdash; " . pvs_word_lang( "edit gallery" ) );
	$sql = "select title from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_GET["id"] .
		" and user_id=" . get_current_user_id();
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$title = $rs->row["title"];
	} else {
		exit();
	}
	$com = "change";
	$com2 = "?id=" . ( int )$_GET["id"];
} else
{
	echo ( " &mdash; " . pvs_word_lang( "add new gallery" ) );
	$title = "";
	$description = "";
	$com = "add";
	$com2 = "";
}
?>
</h1>


<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/printslab-<?php echo $com
?>/<?php echo $com2
?>">


<div class="form_field">
	<span><b><?php echo pvs_word_lang( "title" )?>:</b></span>
	<input class='ibox form-control' name="title" type="text" style="width:300px" value="<?php echo $title
?>">
</div>


<?php
if ( isset( $_GET["id"] ) and ( int )$_GET["id"] > 0 ) {
	$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id_parent='" . ( int )
		$_GET["id"] . "' order by data desc";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%" style="margin-top:15px">
	<tr>
	<th><?php echo pvs_word_lang( "preview" )?></th>	
	<th><?php echo pvs_word_lang( "title" )?></th>
	<th><?php echo pvs_word_lang( "size" )?></th>
	<th><?php echo pvs_word_lang( "date" )?></th>
	<th><?php echo pvs_word_lang( "delete" )?></th>
	</tr>
	<?php
		$tr = 1;
		while ( ! $rs->eof ) {
?>
		<tr valign="top" <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
		<td><div class="t"><div class="b"><div class="l"><div class="r"><div class="bl"><div class="br"><div class="tl"><div class="tr2"><img src="<?php
			echo pvs_upload_dir('baseurl')?>/content/galleries/<?php
			echo $rs->row["id_parent"] ?>/thumb<?php
			echo $rs->row["id"] ?>.jpg"></div></div></div></div></div></div></div></div></td>		
		<td>
			<input type="text" name="title<?php
			echo $rs->row["id"] ?>" value="<?php
			echo $rs->row["title"] ?>" style="width:300px">
		</td>
		<td>
		<?php
			$img = pvs_upload_dir() . "/content/galleries/" . ( int )$_GET["id"] .
				"/" . $rs->row["photo"];
			if ( file_exists( $img ) )
			{
				echo ( pvs_get_exif( $img, true ) );
			}
?>
		</td>
		<td><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
		<td style="text-align:center"><input type="checkbox" name="delete<?php
			echo $rs->row["id"] ?>"></td>
		</tr>
		<?php
			$tr++;
			$rs->movenext();
		}
?>
	</table>
	<?php
	}
}
?>



<div class="form_field">
	<input class='isubmit' value="<?php echo pvs_word_lang( "save" )?>" name="subm" type="submit">
</div>

</form>






<?php
include ( "profile_bottom.php" );
?>