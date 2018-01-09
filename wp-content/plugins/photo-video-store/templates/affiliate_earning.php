<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<h1><?php echo pvs_word_lang( "affiliate" )?> &mdash; <?php echo pvs_word_lang( "earning" )?></h1>

<?php
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

$kolvo = $pvs_global_settings["k_str"];

$kolvo2 = PVS_PAGE_NUMBER;

$sql = "select userid,types,types_id,rates,total,data from " . PVS_DB_PREFIX .
	"affiliates_signups where aff_referal=" . get_current_user_id() .
	" and total>0 order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table border=0 cellpadding=0 cellspacing=0 class=profile_table width="100%">
<tr>
<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "title" )?></b></th>
<th><b><?php echo pvs_word_lang( "date" )?></b></th>
<th><b><?php echo pvs_word_lang( "commission" )?></b></th>
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
<td class='hidden-phone hidden-tablet'><div class="link_order"><?php
			echo pvs_word_lang( $rs->row["types"] )?> # <?php
			echo $rs->row["types_id"] ?></div></td>
<td><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
<td><span class="price"><b><?php
			echo pvs_currency( 1, false );?><?php
			echo pvs_price_format( $rs->row["total"] * $pvs_global_settings["payout_price"],
				2 )?> <?php
			echo pvs_currency( 2, false );?></b></span> (<?php
			echo $rs->row["rates"] ?>%)</td>
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


<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/affiliate/", "&d=2" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>