<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<h1><?php echo pvs_word_lang( "affiliate" )?> &mdash; <?php echo pvs_word_lang( "payout method" )?></h1>

<form method="post" action="<?php echo (site_url( ) );?>/affiliate-change/">
<?php
if ( $pvs_global_settings["payout_set"] ) {

$payout_limit = (int)@$user_info  -> payout_limit;

if ($payout_limit == 0) {
	$payout_limit = $pvs_global_settings["payout_limit"];
}
?>
		<div class="form_field">
		<span><?php echo pvs_word_lang( "Set your balance threshold for payout" )?> (<?php echo pvs_get_currency_code(1)
?>):</span>
		<input class="ibox form-control" type="text" name="payout_limit" value="<?php echo pvs_price_format( $payout_limit, 2 )?>" style="width:100px">	
		</div>
		<?php
}

	$sql = "select * from " . PVS_DB_PREFIX . "payout where activ=1";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		while ( ! $ds->eof ) {
?>
			<div class="form_field">
	<span><?php
			echo $ds->row["title"] ?>:</span>
		<input class="ibox form-control" type="text" name="payout<?php
				echo $ds->row["id"] ?>" value="<?php echo get_user_meta( get_current_user_id(), $ds->row["svalue"], true );?>" style="width:230px">
			</div>		
			<?php
			$ds->movenext();
		}
?>
		<input type="submit" value="<?php echo pvs_word_lang( "save" )?>" class="isubmit">
		
		<?php
	}
?>
</form>