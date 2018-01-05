<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );
?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="change_sox">
<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "enabled" )
?>:</b></span>
	<input name="sox" type="checkbox" value="1" <?php
if ( $pvs_global_settings["sox"] == 1 )
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
echo $pvs_global_settings["sox_path"]
?>" type="text" style="width:300"><br><span class="smalltext">Usually the path is /usr/local/bin/sox</span>
</div>


<div class="form_field">
	<span><b>Library for mp3 preview generation:</b></span>
	<select name="library">
		<option value="sox" <?php
if ( $pvs_global_settings["sox_library"] == "sox" )
{
	echo ( "selected" );
}
?>>Sox</option>
		<option value="ffmpeg" <?php
if ( $pvs_global_settings["sox_library"] == "ffmpeg" )
{
	echo ( "selected" );
}
?>>FFMPEG</option>
	</select>
</div>

<div class="form_field">
	<span><b>Preview duration (sec):</b></span>
	<input name="duration" value="<?php
echo $pvs_global_settings["sox_duration"]
?>" type="text" style="width:97">
</div>



<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "watermark" )
?> (*.mp3):</b></span>
	<input name="watermark_enable" type="checkbox" value="1" <?php
if ( $pvs_global_settings["sox_watermark"] == 1 )
{
	echo ( "checked" );
}
?>>  <span class="smalltext" style="display:inline">Only for Sox. It doesn't work for ffmpeg</span><br>
	<input type="file" name="watermark">
	<?php
if ( $pvs_global_settings["sox_watermark_file"] != "" and file_exists( pvs_upload_dir
	() . "/content/watermark.mp3" ) )
{
?>
	<script src="<?php
	echo pvs_plugins_url()
?>/assets/js/mediaelementjs/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="<?php
	echo pvs_plugins_url()
?>/assets/js/mediaelementjs/mediaelementplayer.min.css" />
	<div style="margin-top:5px"><audio id="player2" src="<?php
	echo pvs_upload_dir( 'baseurl' ) . $pvs_global_settings["sox_watermark_file"]
?>" type="audio/mp3" controls="controls">		
	</audio></div>	

	<script>
		$('audio,video').mediaelementplayer();
	</script>
	
	
		<div style="margin-top:5px"><a href="<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=1&action=sox_delete" class="btn btn-mini btn-default"><?php
	echo pvs_word_lang( "delete" )
?></a></div>
	<?php
}
?>
</div>



<div class="form_field">
	<input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>">
</div>

</form>

