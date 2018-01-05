<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );
?>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<p>
<b>Documentation:</b><br>
<a href="https://pixabay.com/api/docs/">pixabay.com/api/docs/</a>
</p>

</div>
<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

	<form method="post">
	<input type="hidden" name="action" value="change_pixabay">


	
	<div class='admin_field'>
	<span>Pixabay API:</span>
	<input type="checkbox" name="pixabay_api" value="1" <?php
if ( $pvs_global_settings["pixabay_api"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span>API Key:</span>
	<input type="text" name="pixabay_id" value="<?php
echo $pvs_global_settings["pixabay_id"]
?>" style="width:350px"><br>
	</div>
	


	
	<div class='admin_field'>
	<span>Pixabay <?php
echo pvs_word_lang( "categories" )
?>:</span>
	<select name="pixabay_category" style="width:350px">
		<option value="-1"></option>
		<?php
$pixabay_categories = array(
	'fashion',
	'nature',
	'backgrounds',
	'science',
	'education',
	'people',
	'feelings',
	'religion',
	'health',
	'places',
	'animals',
	'industry',
	'food',
	'computer',
	'sports',
	'transportation',
	'travel',
	'buildings',
	'business',
	'music' );
foreach ( $pixabay_categories as $key => $value )
{
	$sel = "";
	if ( $key == $pvs_global_settings["pixabay_category"] )
	{
		$sel = "selected";
	}
?>
			<option value='<?php
	echo $value
?>'  <?php
	echo $sel
?>><?php
	echo ucfirst( $value )
?></option>
			<?php
}
?>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Create internal pages for files" )
?>:</span>
	<input type="checkbox" name="pixabay_pages" value="1" <?php
if ( $pvs_global_settings["pixabay_pages"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "files" )
?>:</span>
	<input type="checkbox" name="pixabay_files" value="1" <?php
if ( $pvs_global_settings["pixabay_files"] )
{
	echo ( "checked" );
}
?>><br>
	</div>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Prints on Demand" )
?>:</span>
	<input type="checkbox" name="pixabay_prints" value="1" <?php
if ( $pvs_global_settings["pixabay_prints"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "by default" )
?>:</span>
	<select name="pixabay_show" style="width:350px">
		<option value="1" <?php
if ( $pvs_global_settings["pixabay_show"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "files" )
?></option>
		<option value="2" <?php
if ( $pvs_global_settings["pixabay_show"] == 2 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "prints" )
?></option>
	</select>
	</div>
	
	<div class='admin_field'>
	<input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>

</div>
