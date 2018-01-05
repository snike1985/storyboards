<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


?>




<form method="post" action="<?php echo (site_url( ) );?>/billing/?type=credits">
<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
<tr>
<th width="50"></th>
<th><b><?php echo pvs_word_lang( "credits" )?></b></th>
<th><b><?php echo pvs_word_lang( "price" )?></b></th>
</tr>
<?php
$i = 0;
$tr = 1;
$sql = "select * from " . PVS_DB_PREFIX . "credits order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
?>
<tr <?php
	if ( $tr % 2 == 0 ) {
		echo ( "class='snd'" );
	}
?>>
<td align="center"><input name="credits" type="radio" value="<?php echo $rs->row["id_parent"] ?>" <?php
	if ( $i == 0 ) {
		echo ( "checked" );
	}
?>></td>
<td><?php echo $rs->row["quantity"] ?></td>
<td>
<span class="price"><?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $rs->row["price"], 2 )?> <?php echo pvs_currency( 2, false )?></span>&nbsp;&nbsp;&nbsp;<span class="smalltext">(<?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $rs->row["price"] / $rs->row["quantity"], 2 )?><?php echo pvs_currency( 2, false )?>/credit)</span>
</td>
</tr>
<?php
	$i++;
	$tr++;
	$rs->movenext();
}
?>

</table>
<input type="hidden" name="tip" value="credits">
<input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "buy" )?>" style="margin-top:10px">

</form>