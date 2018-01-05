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
	<input type="hidden" name="action" value="change_clarifai">
	
	<div class="form_field"> 
		<p><a href="https://clarifai.com/" target="blank">Clarifai</a> automatically tags all your images and video so you can quickly organize, manage, and search through your content.</p>
	</div>
	<div class="form_field"> 
		<span><b>Clarifai:</b></span>
		<input name="clarifai" type="checkbox" value="1" <?php
if ( $pvs_global_settings["clarifai"] == 1 )
{
	echo ( "checked" );
}
?>>
	</div>

	<div class='admin_field'>
		<span>Client Id:</span>
		<input type="text" class="form-control" name="clarifai_key" value="<?php
echo $pvs_global_settings["clarifai_key"]
?>" style="width:400px">
	</div>
	
	<div class='admin_field'>
		<span>Client Secret:</span>
		<input type="text" class="form-control" name="clarifai_password" value="<?php
echo $pvs_global_settings["clarifai_password"]
?>" style="width:400px">
	</div>
	
	<div class='admin_field'>
		<span>Default model:</span>
		<?php
$clarifai_models = array(
	"general-v1.3",
	"general-v1.1",
	"nsfw-v1.0",
	"weddings-v1.0",
	"travel-v1.0",
	"food-items-v1.0" );
?>
		<select class="form-control" name="clarifai_model" style="width:250px">
              <?php
for ( $i = 0; $i < count( $clarifai_models ); $i++ )
{
	$sel = "";
	if ( $clarifai_models[$i] == $pvs_global_settings["clarifai_model"] )
	{
		$sel = "selected";
	}
?>
              		<option value="<?php
	echo $clarifai_models[$i]
?>" <?php
	echo $sel
?>><?php
	echo $clarifai_models[$i]
?></option>
              		<?php
}
?>
        </select>
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "language" )
?>:</span>
		<?php
$clarifai_languages["ar"] = "Arabic (ar)";
$clarifai_languages["bn"] = "Bengali (bn)";
$clarifai_languages["da"] = "Danish (da)";
$clarifai_languages["de"] = "German (de)";
$clarifai_languages["en"] = "English (en)";
$clarifai_languages["es"] = "Spanish (es)";
$clarifai_languages["fi"] = "Finnish (fi)";
$clarifai_languages["fr"] = "French (fr)";
$clarifai_languages["hi"] = "Hindi (hi)";
$clarifai_languages["hu"] = "Hungarian (hu)";
$clarifai_languages["it"] = "Italian (it)";
$clarifai_languages["ja"] = "Japanese (ja)";
$clarifai_languages["ko"] = "Korean (ko)";
$clarifai_languages["nl"] = "Dutch (nl)";
$clarifai_languages["no"] = "Norwegian (no)";
$clarifai_languages["pa"] = "Punjabi (pa)";
$clarifai_languages["pl"] = "Polish (pl)";
$clarifai_languages["pt"] = "Portuguese (pt)";
$clarifai_languages["ru"] = "Russian (ru)";
$clarifai_languages["sv"] = "Swedish (sv)";
$clarifai_languages["tr"] = "Turkish (tr)";
$clarifai_languages["zh"] = "Chinese Simplified (zh)";
$clarifai_languages["zh-TW"] = "Chinese Traditional (zh-TW)";
?>
		<select class="form-control" name="clarifai_language" style="width:250px">
		<?php
foreach ( $clarifai_languages as $key => $value )
{
	$sel = "";
	if ( $key == $pvs_global_settings["clarifai_language"] )
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
        <small>Only for general-v1.3 model.</small>
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
//$photo = "http://demo.photostorescript.com/content/test.mp4";
?>
	<img src="<?php
echo ( pvs_plugins_url() . '/includes/admin/includes/img/test.jpg' );
?>">
	<div id="keywords_box" style="display:none;">
		<textarea id="keywords" style="width:600px;height:200px;margin:20px 0px 20px 0px"></textarea>	
	</div>
	<input  class="btn btn-primary" type="button" style="margin-top:8px;display:block" value="<?php
echo pvs_word_lang( "test" )
?>" onClick="get_clarifai('<?php
echo ( $photo );
?>','keywords','<?php
echo $pvs_global_settings["clarifai_language"]
?>')">
</div>


