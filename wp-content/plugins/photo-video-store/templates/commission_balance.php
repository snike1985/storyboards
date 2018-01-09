<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<h1><?php echo pvs_word_lang( "my commission" )?> &mdash; <?php echo pvs_word_lang( "balance" )?></h1>




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
$sql = "select user,total from " . PVS_DB_PREFIX . "commission where user=" . ( int )
	get_current_user_id() . " and status=1";
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
$sql = "select user,total from " . PVS_DB_PREFIX .
	"commission where total>0 and user=" . get_current_user_id() .
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
$sql = "select user,total from " . PVS_DB_PREFIX .
	"commission where total<0 and user=" . get_current_user_id() .
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
<br>
<p><b><?php echo pvs_word_lang( "Balance threshold for payout" )?>:</b></p>

<?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $user_info->payout_limit, 2 )?> <?php echo pvs_currency( 2, false )?>
<br><br>



<?php
if ( $pvs_global_settings["credits"] ) {
?>
<p><b><?php echo pvs_word_lang( "price" )?>:</b></p>

1 Credit = <?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $pvs_global_settings["payout_price"], 2 )?> <?php echo pvs_currency( 2, false )?>


<br><br>
<?php
}
?>
