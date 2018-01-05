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
<a href="http://developers.gettyimages.com/">http://developers.gettyimages.com</a>
</p>

</div>
<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

	<form method="post">
	<input type="hidden" name="action" value="change_istockphoto">


	
	<div class='admin_field'>
	<span>Gettyimages API:</span>
	<input type="checkbox" name="istockphoto_api" value="1" <?php
if ( $pvs_global_settings["istockphoto_api"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span>Gettyimages Key:</span>
	<input type="text" name="istockphoto_id" value="<?php
echo $pvs_global_settings["istockphoto_id"]
?>" style="width:450px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Gettyimages Secret:</span>
	<input type="text" name="istockphoto_secret" value="<?php
echo $pvs_global_settings["istockphoto_secret"]
?>" style="width:450px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Gettyimages <?php
echo pvs_word_lang( "Contributor" )
?>:</span>
	<input type="text" name="istockphoto_contributor" value="<?php
echo $pvs_global_settings["istockphoto_contributor"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "keywords" )
?> (<?php
echo pvs_word_lang( "by default" )
?>):</span>
	<input type="text" name="istockphoto_query" value="<?php
echo $pvs_global_settings["istockphoto_query"]
?>" style="width:350px"><br>
	<small>It is required. Otherwise the default listing will be empty.</small>
	</div>
	

	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Create internal pages for files" )
?>:</span>
	<input type="checkbox" name="istockphoto_pages" value="1" <?php
if ( $pvs_global_settings["istockphoto_pages"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span>Affiliate link:</span>
	<input type="text" name="istockphoto_affiliate" value="<?php
echo $pvs_global_settings["istockphoto_affiliate"]
?>" style="width:350px"><br>
	<small><a href="http://www.gettyimagesaffiliates.com/programs-3/" target="blank">Gettyimages affiliate program</a> uses Linkconnector or Performancehorizon services. First you should register there and get the affiliate link.<br>You can use the syntax in the affiliate link:<br>{URL} - URL of the publication page on Gettyimages or iStockphoto. You redirect visitors to the URL with your aff link.<br>{URL_ENCODED} - encoded publication URL<br>{ID} - publication ID on Gettyimages.</small>
	</div>
	
	<div class='admin_field'>
	<span>Redirect visitors to:</span>
	<select name="istockphoto_site" style="width:350px">
		<option value="gettyimages" <?php
if ( $pvs_global_settings["istockphoto_site"] == 'gettyimages' )
{
	echo ( "selected" );
}
?>>Gettyimages</option>
		<option value="istockphoto" <?php
if ( $pvs_global_settings["istockphoto_site"] == 'istockphoto' )
{
	echo ( "selected" );
}
?>>Istockphoto</option>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "files" )
?>:</span>
	<input type="checkbox" name="istockphoto_files" value="1" <?php
if ( $pvs_global_settings["istockphoto_files"] )
{
	echo ( "checked" );
}
?>><br>
	</div>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Prints on Demand" )
?>:</span>
	<input type="checkbox" name="istockphoto_prints" value="1" <?php
if ( $pvs_global_settings["istockphoto_prints"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "by default" )
?>:</span>
	<select name="istockphoto_show" style="width:350px">
		<option value="1" <?php
if ( $pvs_global_settings["istockphoto_show"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "files" )
?></option>
		<option value="2" <?php
if ( $pvs_global_settings["istockphoto_show"] == 2 )
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
