<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$type = "for me";

include ( "profile_top.php" );

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

<h1><?php echo pvs_word_lang( "reviews" );?> - <?php echo pvs_word_lang( "for me" );?></h1>

<?php
$n = 0;
$tr = 1;

$sql = "select " . PVS_DB_PREFIX . "media.id," . PVS_DB_PREFIX .
	"media.title," . PVS_DB_PREFIX . "media.author," . PVS_DB_PREFIX .
	"media.url," . PVS_DB_PREFIX . "media.server1," . PVS_DB_PREFIX .
	"reviews.id_parent as bid," . PVS_DB_PREFIX . "reviews.fromuser," .
	PVS_DB_PREFIX . "reviews.data as rdata," . PVS_DB_PREFIX .
	"reviews.content," . PVS_DB_PREFIX . "reviews.itemid from " . PVS_DB_PREFIX . "media," .
	PVS_DB_PREFIX . "reviews where " . PVS_DB_PREFIX . "media.author='" .
	pvs_result( pvs_get_user_login () ) . "' and " . PVS_DB_PREFIX .
	"media.id=" . PVS_DB_PREFIX . "reviews.itemid


 order by rdata desc


";

$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
	<tr>
	<th colspan="2"><?php echo pvs_word_lang( "item" );?>:</th>
	
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "user" );?>:</th>
	<th width="70%"><?php echo pvs_word_lang( "content" );?>:</th>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" );?></th>
	</tr>
	<?php
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
			<?php
			$sql = "select title,url,server1,media_id from " . PVS_DB_PREFIX . "media where id=" . $rs->
				row["itemid"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$item_title = $dr->row["title"];
				$item_url = $dr->row["url"];
				$item_img = "";
				if ( $dr->row["media_id"] == 1 )
				{
					$item_img = pvs_show_preview( $rs->row["itemid"], "photo", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				if ( $dr->row["media_id"] == 2 )
				{
						$item_img = pvs_show_preview( $rs->row["itemid"], "video", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				if ( $dr->row["media_id"] == 3 )
				{
						$item_img = pvs_show_preview( $rs->row["itemid"], "audio", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				if ( $dr->row["media_id"] == 4 )
				{
						$item_img = pvs_show_preview( $rs->row["itemid"], "vector", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				echo ( "<td><a href='" . $item_url . "'><img src='" . $item_img .
					"' width='70' border='0'></a></td>" );
				echo ( "<td class='hidden-phone hidden-tablet'><a href='" . $item_url . "'>" . $item_title .
					"</a></td>" );
			}
?>
			

			<td nowrap class='hidden-phone hidden-tablet'><?php
			echo pvs_show_user_avatar( $rs->row["fromuser"], "login" );?>
			</td>
			<td nowrap><div id="c<?php
			echo $rs->row["bid"];
?>" name="c<?php
			echo $rs->row["bid"];
?>"><?php
			echo str_replace( "\n", "<br>", $rs->row["content"] );?></div></td>
			<td nowrap class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo pvs_show_time_ago( $rs->row["rdata"] );?></div></td>
			</tr>
			<?php
		}
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
	</table>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, "/reviews-for-me/", "" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}

include ( "profile_bottom.php" );
?>