<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );
?>

<p>You can set the search in the different media databases.</p>

	<form method="post">
	<input type="hidden" name="action" value="change_settings">

	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Default media stock" )
?>:</span>

	<select name="stock_default" style="width:200px">
		<?php
foreach ( $mstocks as $key => $value )
{
	if ( $pvs_global_settings[$key . "_api"] )
	{
		$sel = "";
		if ( $pvs_global_settings["stock_default"] == $key )
		{
			$sel = "selected";
		}
?>
				<option value="<?php
		echo $key
?>" <?php
		echo $sel
?>><?php
		echo $value
?></option>
				<?php
	}
}
?>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Show site stock" )
?>:</span>
	<input type="checkbox" name="site_api" value="1" <?php
if ( $pvs_global_settings["site_api"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	




	
	<div class='admin_field'>
	<input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>

