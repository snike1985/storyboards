<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );
?>
<form method="post">
	<input type="hidden" name="action" value="change">
<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "enabled" )
?>:</b></span>
	<input name="ffmpeg" type="checkbox" <?php
if ( $pvs_global_settings["ffmpeg"] == 1 )
{
	echo ( "checked" );
}
?>>
</div>


<div class="form_field">
	<span><b><?php
echo pvs_word_lang( "path" )
?>:</b></span>
	<input name="fpath" value="<?php
echo $pvs_global_settings["ffmpeg_path"]
?>" type="text" style="width:300"><br><span class="smalltext">Usually the path is /usr/local/bin/ffmpeg</span>
</div>


<div class="form_field">
	<span><b>Video preview format:</b></span>
	<select name="video_format">
		<option value="mp4" <?php
if ( $pvs_global_settings["ffmpeg_video_format"] == "mp4" )
{
	echo ( "selected" );
}
?>>MP4 (recommended)</option>
		<option value="flv" <?php
if ( $pvs_global_settings["ffmpeg_video_format"] == "flv" )
{
	echo ( "selected" );
}
?>>FLV</option>
	</select>
</div>

<div class="form_field">
	<span><b>Preview duration (sec):</b></span>
	<input name="duration" value="<?php
echo $pvs_global_settings["ffmpeg_duration"]
?>" type="text" style="width:97">
</div>


<div class="form_field">
	<span><b><?php
echo pvs_word_lang( "preview" )
?> <?php
echo pvs_word_lang( "video" )
?> <?php
echo pvs_word_lang( "size" )
?>:</b></span>
	<input name="video_width" value="<?php
echo $pvs_global_settings["ffmpeg_video_width"]
?>" type="text" style="width:70px;display:inline"> x <input name="video_height" value="<?php
echo $pvs_global_settings["ffmpeg_video_height"]
?>" type="text" style="width:70px;display:inline">
</div>


<div class="form_field">
	<span><b><?php
echo pvs_word_lang( "preview" )
?> <?php
echo pvs_word_lang( "photo" )
?> <?php
echo pvs_word_lang( "size" )
?>:</b></span>

	<input name="thumb_width" value="<?php
echo $pvs_global_settings["ffmpeg_thumb_width"]
?>" type="text" style="width:70px;display:inline"> x <input name="thumb_height" value="<?php
echo $pvs_global_settings["ffmpeg_thumb_height"]
?>" type="text" style="width:70px;display:inline">
</div>

<div class="form_field">
	<span><b>Amount of JPG thumbs:</b></span>
	<input name="frequency" value="<?php
echo $pvs_global_settings["ffmpeg_frequency"]
?>" type="text" style="width:97px">
</div>

<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "watermark" )
?>:</b></span>
	<input name="watermark" type="checkbox" value="1" <?php
if ( $pvs_global_settings["ffmpeg_watermark"] == 1 )
{
	echo ( "checked" );
}
?>>
</div>




<div class="form_field">
	<input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>">
</div>

</form>

