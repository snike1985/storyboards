<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Текущая страница
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

//Количество новостей на странице
$kolvo = $pvs_global_settings["k_str"];

//Количество страниц на странице
$kolvo2 = PVS_PAGE_NUMBER;

?>
<br>
<?php

$sql = "select id,title,description,photo,published,userid from " .
	PVS_DB_PREFIX . "category where userid>0 order by id desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<th class="hidden-phone hidden-tablet" style="width:20%"><?php echo pvs_word_lang( "preview" )?></th>
		<th><?php echo pvs_word_lang( "title" )?></th>
		<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "description" )?></th>
		<th><?php echo pvs_word_lang( "status" )?></th>
		<th><?php echo pvs_word_lang( "user" )?></th>
		<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "edit" )?></th>
		<th><?php echo pvs_word_lang( "delete" )?></th>
	</tr>
	</thead>
	<?php
	$n = 0;
	
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
			$preview = pvs_plugins_url() . "/assets/images/not_found.gif";
			if ( $rs->row["photo"] != "" and file_exists( pvs_upload_dir() . $rs->
				row["photo"] ) )
			{
				$preview = pvs_upload_dir('baseurl') . $rs->row["photo"];
			}

			$url = pvs_plugins_admin_url('categories/index.php') . "&action=content&id=" . $rs->row["id"];
?>
			<tr valign="top">
			<td class="hidden-phone hidden-tablet"><?php
			if ( $preview != "" )
			{
?><a href="<?php
				echo $url
?>"><img src="<?php
				echo $preview
?>" border="0"></a><?php
			}
?></td>
			<td><a href="<?php
			echo $url
?>"><?php
			echo $rs->row["title"] ?></a></td>
			<td class="hidden-phone hidden-tablet"><?php
			echo $rs->row["description"] ?></td>
			<td><div id="status<?php
			echo $rs->row["id"] ?>" name="status<?php
			echo $rs->row["id"] ?>">


			<a href="javascript:pvs_upload_moderation_category(<?php
			echo $rs->row["id"] ?>,1);" <?php
			if ( $rs->row["published"] != 1 )
			{
?>class="gray"<?php
			}
?>><?php
			echo pvs_word_lang( "approved" )?></a><br>
			<a href="javascript:pvs_upload_moderation_category(<?php
			echo $rs->row["id"] ?>,0);" <?php
			if ( $rs->row["published"] != 0 )
			{
?>class="gray"<?php
			}
?>><?php
			echo pvs_word_lang( "pending" )?></a><br>
			<a href="javascript:pvs_upload_moderation_category(<?php
			echo $rs->row["id"] ?>,-1);" <?php
			if ( $rs->row["published"] != -1 )
			{
?>class="gray"<?php
			}
?>><?php
			echo pvs_word_lang( "declined" )?></a>



			</div>
			</td>

			<td><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["userid"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["userid"] )?></a></td>

			<td class="hidden-phone hidden-tablet"><div class="link_edit"><a href='<?php
			echo $url
?>'><?php
			echo pvs_word_lang( "edit" )?></a></div></td>
			<td>	<div class="link_delete"><a href='<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&action=delete_category&id=<?php
			echo $rs->row["id"] ?>' onClick="return confirm('<?php
			echo pvs_word_lang( "delete" )?>?');"><?php
			echo pvs_word_lang( "delete" )?></a></div></td>
			</tr>
			<?php
		}
		
		$n++;
		$rs->movenext();
	}
?>
	</table>
	<br>
	<p><?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('upload/index.php'), "&d=1" ) );?></p>

<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>