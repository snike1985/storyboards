<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );?>

<h1><?php echo pvs_word_lang( "coupons" )?></h1>



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

$sql = "select id_parent,title,user,data2,total,	percentage,url,used,orderid,data,ulimit,tlimit,coupon_id,coupon_code from " .
	PVS_DB_PREFIX . "coupons where user='" . pvs_result( pvs_get_user_login () ) .
	"' and used=0 and data>" . pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
	date( "m" ), date( "d" ), date( "Y" ) ) . " order by used,data2 desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table border="0" cellpadding="0" cellspacing="0"  class="profile_table" style="width:100%">
<tr>
<th><?php echo pvs_word_lang( "code" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "title" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "setup date" )?></th>
<th><?php echo pvs_word_lang( "expiration date" )?></th>
<th><?php echo pvs_word_lang( "discount" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "limit of usage" )?></th>
</tr>
<?php
	$n = 0;
	$tr = 1;
	while ( ! $rs->eof ) {
		if ( $rs->row["data"] < pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
			date( "m" ), date( "d" ), date( "Y" ) ) or $rs->row["ulimit"] == $rs->row["tlimit"] ) {
			$sql = "update " . PVS_DB_PREFIX . "coupons set used=1 where id_parent=" . $rs->
				row["id_parent"];
			$db->execute( $sql );
		}

		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
<td><div class="link_coupon"><?php
			echo $rs->row["coupon_code"] ?></div></td>
<td class='hidden-phone hidden-tablet'><?php
			echo $rs->row["title"] ?></td>
<td class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo date( date_format, $rs->row["data2"] )?></div></td>
<td><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
<td>
<?php
			if ( $rs->row["total"] > 0 )
			{
				echo ( pvs_currency( 1 ) . $rs->row["total"] . " " . pvs_currency( 2 ) );
			}
			if ( $rs->row["percentage"] > 0 )
			{
				echo ( $rs->row["percentage"] . "%" );
			}

?>
</td>
<td class='hidden-phone hidden-tablet'><?php
			echo $rs->row["tlimit"] ?>(<?php
			echo $rs->row["ulimit"] ?>)</td>



</tr>
<?php
		}
		$tr++;
		$rs->movenext();
	}
?>
</table>
<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/coupons/", "&d=1" ) );
} else
{
?>
<p><?php echo pvs_word_lang( "not found" )?>.</p>
<?php
}

include ( "profile_bottom.php" );
?>