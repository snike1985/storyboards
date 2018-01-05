<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_recognition" );
?>



<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
	<form method="post">
	<input type="hidden" name="action" value="change_imagga">
	
	<div class="form_field"> 
		<p><a href="https://imagga.com/" target="blank">Imagga</a> is an Image Recognition Platform-as-a-Service providing Image Tagging APIs for developers & businesses to build scalable, image intensive cloud apps.</p>
	</div>
	<div class="form_field"> 
		<span><b>Imagga:</b></span>
		<input name="imagga" type="checkbox" value="1" <?php
if ( $pvs_global_settings["imagga"] == 1 )
{
	echo ( "checked" );
}
?>>
	</div>

	<div class='admin_field'>
		<span>Client Id:</span>
		<input type="text" class="form-control" name="imagga_key" value="<?php
echo $pvs_global_settings["imagga_key"]
?>" style="width:400px">
	</div>
	
	<div class='admin_field'>
		<span>Client Secret:</span>
		<input type="text" class="form-control" name="imagga_password" value="<?php
echo $pvs_global_settings["imagga_password"]
?>" style="width:400px">
	</div>	
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "language" )
?>:</span>
		<?php
$imagga_languages["ar"] = "Arabic";
$imagga_languages["bg"] = "Bulgarian";
$imagga_languages["bs"] = "Bosnian";
$imagga_languages["en"] = "English";
$imagga_languages["ca"] = "Catalan";
$imagga_languages["cs"] = "Czech";
$imagga_languages["cy"] = "Welsh";
$imagga_languages["da"] = "Danish";
$imagga_languages["de"] = "German";
$imagga_languages["el"] = "Greek";
$imagga_languages["es"] = "Spanish";
$imagga_languages["et"] = "Estonian";
$imagga_languages["fa"] = "Persian";
$imagga_languages["fi"] = "Finnish";
$imagga_languages["fr"] = "French";
$imagga_languages["he"] = "Hebrew";
$imagga_languages["hi"] = "Hindi";
$imagga_languages["hr"] = "Croatian";
$imagga_languages["ht"] = "Haitian Creole";
$imagga_languages["hu"] = "Hungarian";
$imagga_languages["id"] = "Indonesian";
$imagga_languages["it"] = "Italian";
$imagga_languages["ja"] = "Japanese";
$imagga_languages["ko"] = "Korean";
$imagga_languages["lt"] = "Lithuanian";
$imagga_languages["lv"] = "Latvian";
$imagga_languages["ms"] = "Malay";
$imagga_languages["mt"] = "Maltese";
$imagga_languages["mww"] = "Hmong Daw";
$imagga_languages["nl"] = "Dutch";
$imagga_languages["no"] = "Norwegian";
$imagga_languages["otq"] = "Querétaro Otomi";
$imagga_languages["pl"] = "Polish";
$imagga_languages["pt"] = "Portuguese";
$imagga_languages["ro"] = "Romanian";
$imagga_languages["ru"] = "Russian";
$imagga_languages["sk"] = "Slovak";
$imagga_languages["sv"] = "Swedish";
$imagga_languages["sl"] = "Slovenian";
$imagga_languages["sr_cyrl"] = "Serbian - Cyrillic";
$imagga_languages["sr_latn"] = "Serbian - Latin";
$imagga_languages["th"] = "Thai";
$imagga_languages["tlh"] = "Klingon";
$imagga_languages["tlh_qaak"] = "Klingon (pIqaD)";
$imagga_languages["tr"] = "Turkish";
$imagga_languages["uk"] = "Ukrainian";
$imagga_languages["ur"] = "Urdu";
$imagga_languages["vi"] = "Vietnamese";
$imagga_languages["yua"] = "Yucatec Maya";
$imagga_languages["zh_chs"] = "Chinese Simplified";
$imagga_languages["zh_cht"] = "Chinese Traditional";
?>
		<select class="form-control" name="imagga_language" style="width:250px">
		<?php
foreach ( $imagga_languages as $key => $value )
{
	$sel = "";
	if ( $key == $pvs_global_settings["imagga_language"] )
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
?>
        </select>
	</div>
	
	<div class='admin_field'>
		<input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>
</div>



<div class="subheader"><?php
echo pvs_word_lang( "test" )
?></div>
<div class="subheader_text">
<?php
$photo =  pvs_plugins_url() . '/includes/admin/includes/img/test.jpg';
//$photo = "http://demo.photostorescript.com/content/test.jpg";
?>
	<img src="<?php
echo ( pvs_plugins_url() . '/includes/admin/includes/img/test.jpg' );
?>">
	<div id="keywords_box" style="display:none;">
		<textarea id="keywords" style="width:600px;height:200px;margin:20px 0px 20px 0px"></textarea>	
	</div>
	
	<input  class="btn btn-primary" type="button"  style="margin-top:8px;display:block" value="<?php
echo pvs_word_lang( "test" )
?>" onClick="get_imagga('<?php echo ( $photo ); ?>','keywords','<?php echo ( $pvs_global_settings["imagga_language"] ); ?>','')">
</div>


