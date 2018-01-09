<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<h1><?php echo pvs_word_lang( "my commission" )?> &mdash; <?php echo pvs_word_lang( "earning" )?></h1>

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

$sql = "select total,user,orderid,item,publication,types,data from " .
	PVS_DB_PREFIX . "commission where user=" . get_current_user_id() .
	" and total>0 order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border=0 cellpadding=0 cellspacing=0 class=profile_table width="100%">
	<tr>
	<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "preview" )?></b></th>
	<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "item" )?></b></th>
	<th><b><?php echo pvs_word_lang( "date" )?></b></th>
	<th><b><?php echo pvs_word_lang( "commission" )?></b></th>
	</tr>
	<?php
	$n = 0;
	$total = 0;
	$tr = 1;
	while ( ! $rs->eof ) {
		$idp = $rs->row["publication"];
		$userid = $rs->row["user"];
		$url = "";
		$title = "";

		if ( $rs->row["types"] != "prints_items" ) {
			$sql = "select id,title from " . PVS_DB_PREFIX .
				"media where id=" . $idp;
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$url = pvs_item_url( $dr->row["id"] );
				$title = $dr->row["title"];
			}
		} else {
			$sql = "select id_parent,title,itemid from " . PVS_DB_PREFIX . "prints_items where id_parent=" . $idp;
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$url = pvs_item_url( $dr->row["itemid"] );
				$title = $dr->row["title"];
			}
		}

		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
			<td class='hidden-phone hidden-tablet'>
			<?php
			if ( $rs->row["types"] != "prints_items" ) {
				$sql = "select title,media_id from " . PVS_DB_PREFIX . "media where id=" . $idp;
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$img_preview = "";
					if ( $dr->row["media_id"] == 1 )
					{
						$img_preview = pvs_show_preview( $idp, "photo", 1, 1, "", "" );
					}
					if ( $dr->row["media_id"] == 2 )
					{
						$img_preview = pvs_show_preview( $idp, "video", 1, 1, "", "" );
					}
					if ( $dr->row["media_id"] == 3 )
					{
						$img_preview = pvs_show_preview( $idp, "audio", 1, 1, "", "" );
					}
					if ( $dr->row["media_id"] == 4 )
					{
						$img_preview = pvs_show_preview( $idp, "vector", 1, 1, "", "" );
					}
				}
			} else {
				$sql = "select id_parent,title,itemid from " . PVS_DB_PREFIX . "prints_items where id_parent=" . $idp;
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$img_preview = pvs_show_preview( $dr->row['itemid'], "photo", 1, 1, "", "" );
				}	
			}
?>
		<div class="profile_home_preview" style="background:url('<?php
				echo $img_preview
?>')" onClick="location.href='<?php
				echo $url
?>'"></div>
			</td>
			<td class='hidden-phone hidden-tablet'>#<?php
			echo $idp
?> - <a href="<?php
			echo $url
?>"><?php
			echo $title
?></a></td>
			<td><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
			<td><span class="price"><b><?php
			echo pvs_currency( 1, false );?><?php
			echo pvs_price_format( $rs->row["total"] * $pvs_global_settings["payout_price"],
				2 )?> <?php
			echo pvs_currency( 2, false );?></b></span></td>
			</tr>
			<?php
		}
		$n++;
		$tr++;
		$total += $rs->row["total"] * $pvs_global_settings["payout_price"];
		$rs->movenext();
	}
?>
	</table>

	<p><b><?php echo pvs_word_lang( "total" )?>:</b> <span class="price"><b><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( $total, 2 )?> <?php echo pvs_currency( 2, false );?></b></span></p>

	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/commission/", "&d=2" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>