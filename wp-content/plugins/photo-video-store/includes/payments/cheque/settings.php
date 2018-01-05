<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_payments" );

if ( @$_REQUEST["action"] == 'change' )
{
	pvs_update_setting('cheque_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('cheque_account2', pvs_result( $_POST["account2"] ));
	pvs_update_setting('cheque_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>



<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "title" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["cheque_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "description" )?>:</span>
<select name="account2" style="width:250px">
				<option value="0"></option>
				<?php
		$sql = "select ID, post_title from " . $table_prefix .
			"posts where post_type = 'page' and post_status = 'publish' order by post_title";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$sel = "";
			if ( $ds->row["ID"] == $pvs_global_settings["cheque_account2"] )
			{
				$sel = "selected";
			}
?>
					<option value="<?php
			echo $ds->row["ID"]
?>" <?php
			echo $sel
?>><?php
			echo $ds->row["post_title"]
?></option>
					<?php
			$ds->movenext();
		}
?>
			</select>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["cheque_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>