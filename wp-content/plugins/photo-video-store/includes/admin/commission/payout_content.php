<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>


<h1><?php echo pvs_word_lang( "refund" )?></h1>


<form method="post" action="<?php echo $url
?>">
<div class="form_field">
	<span><?php echo pvs_word_lang( "total" )?>:</span>
	<input type="text" name="total" style="width:300px" value="1.00">
</div>

<div class="form_field">
	<span><?php echo pvs_word_lang( "description" )?>:</span>
	<textarea name="description" style="width:300px;height:40px"></textarea>
</div>

<div class="form_field">
	<span><?php echo pvs_word_lang( "user" )?>:</span>
	<select name="user" style="width:300px">
	<option value=""></option>
	<?php
$sql="select ID, user_login from " . $table_prefix . "users order by user_login";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$sel = "";
	if ( isset( $_GET["user"] ) and $_GET["user"] == $ds->row["ID"] ) {
		$sel = "selected";
	}
?>
		<option value="<?php echo $ds->row["ID"] ?>" <?php echo $sel
?>><?php echo $ds->row["user_login"] ?></option>
		<?php
	$ds->movenext();
}
?>
	</select>
</div>


<div class="form_field">
<span><?php echo pvs_word_lang( "payout method" )?>:</span>
<?php
$sql = "select * from " . PVS_DB_PREFIX . "payout where activ=1";
$ds->open( $sql );
while ( ! $ds->eof ) {
	$sel = "";
	if ( isset( $_GET["method"] ) and $_GET["method"] == $ds->row["svalue"] ) {
		$sel = "checked";
	}

	$payout_method = get_user_meta( (int)$_GET["user"], $ds->row["svalue"], true );
	
	if ( $payout_method != "")
	{
?>
							<div style="margin-bottom:5px"><input type="radio" name="method" value="<?php
		echo $ds->row["svalue"] ?>" <?php
		echo $sel
?>>&nbsp;&nbsp;<div style="display:inline;" class="text_<?php
		echo $ds->row["svalue"] ?>" ><?php
		echo str_replace( " account", "", $ds->row["title"] )?></div>&nbsp;&nbsp;<font class="small_text">[<?php
		echo $payout_method ?>]</font></div>
						<?php
	}
	$ds->movenext();
}
?>
<div style="margin-bottom:5px"><input type="radio" name="method" value="other" <?php
if ( isset( $_GET["method"] ) and $_GET["method"] == "other" ) {
	echo ( "checked" );
}
?>>&nbsp;&nbsp;<div style="display:inline;" class="text_other" >Other</div></div>
</div>



<div class="form_field">
	<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "pay now" )?>">
</div>
</form>
