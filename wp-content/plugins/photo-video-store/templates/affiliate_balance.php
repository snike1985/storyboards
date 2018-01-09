<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<h1><?php echo pvs_word_lang( "affiliate" )?></h1>


<p>You should use the affiliate link:</p>

<div class="alert alert-warning" role="alert"><b><?php echo (site_url( ) );?>/?aff=<?php echo get_current_user_id() ?></b></div>

<p>Example:</p>

<div class="alert alert-warning" role="alert">&lt;a href="<b><?php echo (site_url( ) );?>/?aff=<?php echo get_current_user_id() ?></b>"&gt;Photo Stock Site&lt;/a&gt;</div>

<br>

<h2><?php echo pvs_word_lang( "stats" )?></h2>

<?php
$seller_qty = 0;
$seller_orders_qty = 0;
$seller_total = 0;
$buyer_qty = 0;
$buyer_orders_qty = 0;
$buyer_total = 0;

$sql = "select seller,buyer,userid from " . PVS_DB_PREFIX .
	"affiliates_stats where aff_referal=" . get_current_user_id();
$dr->open( $sql );
while ( ! $dr->eof ) {
	if ( $dr->row["seller"] == 1 ) {
		$seller_qty++;
		$sql = "select total from " . PVS_DB_PREFIX . "affiliates_signups where userid=" .
			$dr->row["userid"];
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$seller_total += $ds->row["total"];
			$seller_orders_qty++;
			$ds->movenext();
		}
	}
	if ( $dr->row["buyer"] == 1 ) {
		$buyer_qty++;
		$sql = "select total from " . PVS_DB_PREFIX . "affiliates_signups where userid=" .
			$dr->row["userid"];
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$buyer_total += $ds->row["total"];
			$buyer_orders_qty++;
			$ds->movenext();
		}
	}
	$dr->movenext();
}
?>
<table border=0 cellpadding=0 cellspacing=0 class=profile_table width="100%">
<tr>
<th><b><?php echo pvs_word_lang( "sign up" )?></b></th>
<th><b><?php echo pvs_word_lang( "quantity" )?></b></th>
<th><b><?php echo pvs_word_lang( "commission" )?></b></th>
<th><b><?php echo pvs_word_lang( "orders" )?></b></th>
<th><b><?php echo pvs_word_lang( "total" )?></b></th>
</tr>
<?php
	if ( $pvs_global_settings["userupload"] != 0 ) {
?>
<tr>
<td><?php echo pvs_word_lang( "seller" )?></td>
<td><?php echo $seller_qty
?></td>
<td><?php echo $user_info->aff_commission_seller ?>%</td>
<td><?php echo $seller_orders_qty
?></td>
<td><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( $seller_total, 2 )?> <?php echo pvs_currency( 2, false );?></td>
</tr>
<?php
	}
?>
<tr class="snd">
<td><?php echo pvs_word_lang( "buyer" )?></td>
<td><?php echo $buyer_qty
?></td>
<td><?php echo $user_info->aff_commission_buyer ?>%</td>
<td><?php echo $buyer_orders_qty
?></td>
<td><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( $buyer_total, 2 )?> <?php echo pvs_currency( 2, false );?></td>
</tr>
<tr>
<td><?php echo pvs_word_lang( "visits" )?></td>
<td><?php echo $user_info->aff_visits ?></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>


<br>

<h2><?php echo pvs_word_lang( "balance" )?></h2>

<table border=0 cellpadding=0 cellspacing=0 class=profile_table width="100%">
<tr>
<th><b><?php echo pvs_word_lang( "balance" )?></b></th>
<th><b><?php echo pvs_word_lang( "earning" )?></b></th>
<th><b><?php echo pvs_word_lang( "refund" )?></b></th>
</tr>

<tr>
<td>

<?php
$total = 0;
$sql = "select total from " . PVS_DB_PREFIX .
	"affiliates_signups where aff_referal=" . get_current_user_id() .
	" and status=1";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$total += $ds->row["total"];
	$ds->movenext();
}
?>
<span class="price"><b><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( $total, 2 )?> <?php echo pvs_currency( 2, false );?></b></span>


</td>
<td>
<?php
$total = 0;
$sql = "select total from " . PVS_DB_PREFIX .
	"affiliates_signups where total>0 and aff_referal=" . get_current_user_id() .
	" and status=1";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$total += $ds->row["total"];
	$ds->movenext();
}
?>
<b><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( $total, 2 )?> <?php echo pvs_currency( 2, false );?></b>
</td>
<td>
<?php
$total = 0;
$sql = "select total from " . PVS_DB_PREFIX .
	"affiliates_signups where total<0 and aff_referal=" . get_current_user_id() .
	" and status=1";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$total += $ds->row["total"];
	$ds->movenext();
}
?>
<b><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( ( -1 * $total ), 2 )?> <?php echo pvs_currency( 2, false );?></b>

</td>
</tr>
</table>


<?php
if ( $pvs_global_settings["credits"] ) {
?>
<p style="float:right"><small> 
1 Credit = <?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $pvs_global_settings["payout_price"], 2 )?> <?php echo pvs_currency( 2, false )?>

</small>
</p>
<?php
}
?>
