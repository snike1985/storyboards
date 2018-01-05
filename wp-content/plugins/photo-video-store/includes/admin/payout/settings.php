<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );
?>




<form method="post">
	<input type="hidden" name="action" value="settings_change">


	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Balance threshold for payout" )
?> (<?php
echo pvs_get_currency_code(1)
?>):</span>
	<input type="text" name="payout_limit" value="<?php
echo pvs_price_format( $pvs_global_settings["payout_limit"], 2 )
?>" class="form-control" style="width:100px"><br>
	</div>
	

	

	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "User may set balance threshold for payout" )
?>:</span>
	<input type="checkbox" name="payout_set" value="1" <?php
if ( $pvs_global_settings["payout_set"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "select action" )
?>:</span>
	<select name="payout_action" class="form-control" style="width:400px">
		<option value="0"><?php
echo pvs_word_lang( "Not to change current user's balance thresholds" )
?></option>
		<option value="1"><?php
echo pvs_word_lang( "Change current user's balance thresholds" )
?></option>
	</select>
	</div>
	

	


	
	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>



<br><br>

<form method="post">
	<input type="hidden" name="action" value="add">
	<input name="new" type="text" value="" style="width:200px;display:inline">&nbsp;<input type="submit" value="<?php
echo pvs_word_lang( "add" )
?>" class="btn btn-success" style="display:inline">
</form>
<br>

<?php
$sql = "select * from " . PVS_DB_PREFIX . "payout";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<form method="post">
	<input type="hidden" name="action" value="change">
 	<table class="wp-list-table widefat fixed striped posts">
 	<thead>
	<tr>
	<th><b><?php
	echo pvs_word_lang( "enabled" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "payment gateways" )
?>:</b></th>
<th><b><?php
	echo pvs_word_lang( "Key" )
?>:</b></th>
<th><b><?php
	echo pvs_word_lang( "delete" )
?>:</b></th>	
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr>
		<td><input name="activ<?php
		echo $rs->row["id"]
?>" type="checkbox" <?php
		if ( $rs->row["activ"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
		<td><input type="text" name="title<?php
		echo $rs->row["id"]
?>" value="<?php
		echo $rs->row["title"]
?>" style="width:250px"></td>
<td><input type="text" name="svalue<?php
		echo $rs->row["id"]
?>" value="<?php
		echo $rs->row["svalue"]
?>" style="width:250px"></td>
		<td><input name="delete<?php
		echo $rs->row["id"]
?>" type="checkbox"></td>
		</tr>
		<?php
		$rs->movenext();
	}
?>
	</table><br>
	<p><input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>"></p>
	</form><br>
	<?php
}
?>
