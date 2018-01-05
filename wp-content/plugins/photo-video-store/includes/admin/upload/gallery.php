<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );

?>


   <script>
    $(function() {
        $('.photo_preview a').lightBox();
    });
    </script>


<?php
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

$sql = "select title, description from " . PVS_DB_PREFIX . "galleries where id=" . ( int )
	$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	echo ( "<h2>" . $rs->row["title"] . "</h2>" );
}

$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" . ( int )
	$_GET["id"] . " order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<br><table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "preview" )?></th>
		<th><?php echo pvs_word_lang( "title" )?></th>
		<th><?php echo pvs_word_lang( "size" )?></th>
		<th><?php echo pvs_word_lang( "delete" )?></th>
	</tr>
	</thead>
	<?php
	$n = 0;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr valign="top">
			<td class="hidden-phone hidden-tablet"><div  class="photo_preview"><a href="<?php
			echo pvs_upload_dir('baseurl')?>/content/galleries/<?php
			echo $rs->row["id_parent"] ?>/<?php
			echo $rs->row["photo"] ?>"><img src="<?php
			echo pvs_upload_dir('baseurl')?>/content/galleries/<?php
			echo $rs->row["id_parent"] ?>/thumb<?php
			echo $rs->row["id"] ?>.jpg" border="0"></a></div></td>
			<td><?php
			echo $rs->row["title"] ?></td>
			
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

			<td>	<div class="link_delete"><a href='<?php echo(pvs_plugins_admin_url('upload/index.php'));?>&action=delete_gallery_photo&d=7&id=<?php
			echo $rs->row["id"] ?>&gallery_id=<?php
			echo ( int )$_GET["id"] ?>' onClick="return confirm('<?php
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
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('upload/index.php'), "&d=7&id=" . ( int ) $_GET["id"] ) );
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>