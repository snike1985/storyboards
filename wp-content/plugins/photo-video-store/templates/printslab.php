<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
include ( "profile_top.php" );?>



<input type="button" value="<?php echo pvs_word_lang( "add new gallery" )?>" class="profile_button" onClick="location.href='<?php echo (site_url( ) );?>/printslab-content/'">

<h1><?php echo pvs_word_lang( "upload your photos and order prints" )?></h1>



<?php
$sql = "select * from " . PVS_DB_PREFIX . "galleries where user_id='" . ( int )
	get_current_user_id() . "' order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%" style="margin-top:15px">
	<tr>
	<th><?php echo pvs_word_lang( "title" )?></th>
	<th><?php echo pvs_word_lang( "date" )?></th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
	</tr>
	<?php
	$tr = 1;
	while ( ! $rs->eof ) {
?>
		<tr valign="top" <?php
		if ( $tr % 2 == 0 ) {
			echo ( "class='snd'" );
		}
?>>
		<td><b><?php echo $rs->row["title"] ?></b><br><small>[&nbsp;<?php
		$sql = "select count(id) as count_id from " . PVS_DB_PREFIX .
			"galleries_photos where id_parent=" . $rs->row["id"];
		$ds->open( $sql );
		echo ( $ds->row["count_id"] . "&nbsp;" . pvs_word_lang( "photos" ) );?>&nbsp;]</small>
		</td>

		<td><div class="link_date"><?php echo date( date_format, $rs->row["data"] )?></div></td>
		<td><input type="button" onClick="location.href='<?php echo (site_url( ) );?>/printslab-upload/?id=<?php echo $rs->row["id"] ?>'" class="isubmit" value="<?php echo pvs_word_lang( "upload" )?> <?php echo pvs_word_lang( "photos" )?>"></td>
		<td><input type="button" onClick="location.href='<?php echo (site_url( ) );?>/printslab-order/?id=<?php echo $rs->row["id"] ?>'" class="isubmit_orange" value="<?php echo pvs_word_lang( "order prints" )?>"></td>
		<td><div class="link_edit"><a href="<?php echo (site_url( ) );?>/printslab-content/?id=<?php echo $rs->row["id"] ?>"><?php echo pvs_word_lang( "edit" )?></a></div></td>
		
		<td><div class="link_delete"><a href="<?php echo (site_url( ) );?>/printslab-delete/?id=<?php echo $rs->row["id"] ?>" onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');"><?php echo pvs_word_lang( "delete" )?></a></div></td>
		</tr>
		<?php
		$tr++;
		$rs->movenext();
	}
?>
	</table>
<?php
} else
{
?>
	<b><?php echo pvs_word_lang( "not found" )?></b>
<?php
}

include ( "profile_bottom.php" );
?>