<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


$subscription_limit = $pvs_global_settings["subscription_limit"];
?>


<form method="post" action="<?php echo (site_url( ) );?>/billing/?type=subscription" style="margin-bottom:30px">
<table border="0" cellpadding="0" cellspacing="0"   class="profile_table" width="100%">
<tr>
<th colspan="2"><b><?php echo pvs_word_lang( "subscription" );?>:</b></th>
<th><b><?php echo pvs_word_lang( "price" );?>:</b></th>
<th><b><?php echo pvs_word_lang( "limit" );?> (<?php echo $subscription_limit;
?><?php
if ( $subscription_limit == "Bandwidth" ) {
	echo ( " Mb." );
}
?>)</b></th>
<th><b><?php echo pvs_word_lang( "daily limit" );?></b></th>
<th><b><?php echo pvs_word_lang( "content type" );?>:</b></th>
</tr>
<?php
$i = 0;
$tr = 0;
if ( isset( $subscription_upgrade ) ) {
	$sql = "select * from " . PVS_DB_PREFIX . "subscription " . $subscription_upgrade .
		" order by priority";
} else
{
	$sql = "select * from " . PVS_DB_PREFIX . "subscription order by priority";
}
$rs->open( $sql );
while ( ! $rs->eof ) {
?>
<tr <?php
	if ( $tr % 2 == 0 ) {
		echo ( "class='snd'" );
	}
?>>
<td align="center"><input name="subscription" type="radio" value="<?php echo $rs->row["id_parent"];
?>" <?php
	if ( $i == 0 ) {
		echo ( "checked" );
	}
?>></td>
<td><?php echo $rs->row["title"];
?></td>
<td><b><?php echo pvs_currency( 1, false );?><?php echo pvs_price_format( $rs->row["price"], 2 );?> <?php echo pvs_currency( 2, false );?></b></td>
<td><?php echo $rs->row["bandwidth"];
?></td>
<td class='hidden-phone hidden-tablet'>
<?php
	if ( $rs->row["bandwidth_daily"] != 0 ) {
?><?php echo $rs->row["bandwidth_daily"];
?><?php
	} else {
		echo ( pvs_word_lang( "no" ) );
	}
?>
</td>
<td><?php echo str_replace( "|", "&nbsp;+&nbsp;", $rs->row["content_type"] );?></td>
</tr>
<?php
	$i++;
	$tr++;
	$rs->movenext();
}
?>





</table>
<input type="hidden" name="tip" value="subscription">
<input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "buy" );?>" style="margin-top:3px">

</form>