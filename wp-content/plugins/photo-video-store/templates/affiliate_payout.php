<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>


<h1><?php echo pvs_word_lang( "affiliate" )?> &mdash; <?php echo pvs_word_lang( "refund" )?></h1>

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

$sql = "select total,data from " . PVS_DB_PREFIX .
	"affiliates_signups where total<0 and aff_referal=" . get_current_user_id() .
	" and status=1 order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table border=0 cellpadding=0 cellspacing=0 class=profile_table width="100%">
<tr>
<th><b><?php echo pvs_word_lang( "date" )?></b></th>
<th><b><?php echo pvs_word_lang( "refund" )?></b></th>
</tr>
<?php
	$n = 0;
	$tr = 1;
	$total = 0;
	while ( ! $rs->eof ) {

		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
<td><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
<td><span class="price"><b><?php
			echo pvs_currency( 1, false );?><?php
			echo pvs_price_format( ( -1 * $rs->row["total"] ), 2 )?> <?php
			echo pvs_currency( 2, false );?></b></span></td>
</tr>
<?php
		}
		$n++;
		$tr++;
		$total += $rs->row["total"];
		$rs->movenext();
	}
?>
</table>

<p><b><?php echo pvs_word_lang( "total" )?>:</b> <span class="price"><b><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( ( -1 * $total ), 2 )?> <?php echo pvs_currency( 2, false );?></b></span></p>


<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/affiliate/", "&d=3" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>