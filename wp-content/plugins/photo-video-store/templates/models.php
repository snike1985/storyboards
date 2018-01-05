<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	
	exit();
}


include ( "profile_top.php" );?>


<input type="button" value="<?php echo pvs_word_lang( "add" )?> <?php echo pvs_word_lang( "model property release" )?>" class="profile_button" onClick="location.href='<?php echo (site_url( ) );?>/models-new/'">

<h1><?php echo pvs_word_lang( "models" )?></h1>






<?php
$sql = "select * from " . PVS_DB_PREFIX . "models where user='" . pvs_result( pvs_get_user_login () ) .
	"' order by name";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%" style="margin-top:15px">
	<tr>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "photo" )?></th>
	<th><?php echo pvs_word_lang( "title" )?></th>
	<th><?php echo pvs_word_lang( "edit" )?></th>
	<th><?php echo pvs_word_lang( "delete" )?></th>
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
		<td class='hidden-phone hidden-tablet'>
		<?php
		$photo = pvs_plugins_url() . "/assets/images/e.gif";
		if ( file_exists( pvs_upload_dir() . $rs->row["modelphoto"] ) ) {
			$photo = pvs_upload_dir('baseurl') . $rs->row["modelphoto"];
		}
?>
		<a href="<?php echo (site_url( ) );?>/models-content/?id=<?php echo $rs->row["id_parent"] ?>"><img src="<?php echo $photo
?>" border="0"></a>
		</td>
		<td><a href="<?php echo (site_url( ) );?>/models-content/?id=<?php echo $rs->row["id_parent"] ?>"><?php echo $rs->row["name"] ?></a></td>
		<td><div class="link_edit"><a href="<?php echo (site_url( ) );?>/models-content/?id=<?php echo $rs->row["id_parent"] ?>"><?php echo pvs_word_lang( "edit" )?></a></div></td>
		<td><div class="link_delete"><a href="<?php echo (site_url( ) );?>/models-delete/?id=<?php echo $rs->row["id_parent"] ?>" onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');"><?php echo pvs_word_lang( "delete" )?></a></div></td>
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