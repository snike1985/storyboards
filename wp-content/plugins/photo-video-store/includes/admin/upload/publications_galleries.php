<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );


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

$sql = "select * from " . PVS_DB_PREFIX . "galleries order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<br><table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "preview" )?></th>
		<th><?php echo pvs_word_lang( "title" )?></th>
		<th><?php echo pvs_word_lang( "user" )?></th>
		<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "edit" )?></th>
		<th><?php echo pvs_word_lang( "delete" )?></th>
	</tr>
	</thead>
	<?php
	$n = 0;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
			$gallery_count = 0;
			$gallery_photo_default = "";
			$sql = "select id from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" .
				$rs->row["id"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				$gallery_count++;
				$gallery_photo_default = $ds->row["id"];

				$ds->movenext();
			}

			if ( $gallery_photo_default != "" )
			{
				$gallery_photo = pvs_upload_dir('baseurl') . "/content/galleries/" . $rs->row["id"] . "/thumb" .
					$gallery_photo_default . ".jpg";
			} else
			{
				$gallery_photo = pvs_plugins_url() . "/assets/images/not_found.gif";
			}

			$url = pvs_plugins_admin_url('upload/index.php') . "&d=7&id=" . $rs->row["id"];
?>
			<tr valign="top">
			<td class="hidden-phone hidden-tablet"><a href="<?php
			echo $url
?>"><img src="<?php
			echo $gallery_photo
?>" border="0"></a></td>
			<td><?php
			echo $rs->row["title"] ?> [ <a href='<?php
			echo $url
?>'><?php
			echo $gallery_count
?> <?php
			echo pvs_word_lang( "photos" )?></a> ]<br>
			

			
			</td>


			<td><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user_id"] )?></a></td>

			<td class="hidden-phone hidden-tablet"><div class="link_edit"><a href='<?php
			echo $url
?>'><?php
			echo pvs_word_lang( "edit" )?></a></div></td>
			<td>	<div class="link_delete"><a href='<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&action=delete_gallery&d=6&id=<?php
			echo $rs->row["id"] ?>' onClick="return confirm('<?php
			echo pvs_word_lang( "delete" )?>?');"><?php
			echo pvs_word_lang( "delete" )?></a></div></td>
			</tr>
			<?php
			$n++;
		}
		$rs->movenext();
	}
?>
	</table>
	<br>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('upload/index.php'), "&d=6" ) );
} else
{
	echo ( "<br><p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>