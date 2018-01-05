<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

if ( @$_GET["action"] != 'generate_sox' )
{
?>
	<p>Before using Sox we strongly recommend you to test it.<br><br>
	There is a file <b><?php
	echo pvs_upload_dir( 'baseurl' )
?>/content/sound.mp3</b> on ftp. The script must create *.mp3 preview for the audio.</p>
	<input class="btn btn-primary" type="button" value="Generate mp3 preview" onClick="location.href='<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=1&action=generate_sox'">
<?php
} else
{
?>
	<h2>Result:</h2>
	<?php
	$mp3 = pvs_upload_dir( 'baseurl' ) . "/content/sox_preview.mp3";

	if ( file_exists( pvs_upload_dir() . "/content/sox_preview.mp3" ) )
	{
?>
			<p>The <b>audio preview file</b> has been generated successfully.</p>
			<script src="<?php
		echo pvs_plugins_url()
?>/assets/js/mediaelementjs/mediaelement-and-player.min.js"></script>
			<link rel="stylesheet" href="<?php
		echo pvs_plugins_url()
?>/assets/js/mediaelementjs/mediaelementplayer.min.css" />
			<div style="margin-top:5px"><audio id="player2" src="<?php
		echo $mp3
?>" type="audio/mp3" controls="controls">		
			</audio></div>	

			<script>
				$('audio,video').mediaelementplayer();
			</script>
			<?php
	} else
	{
?>
			<div class="card">The error occured during the audio preview convertation. Please make sure that Sox or FFMPEG installed on your server. Also you can <a href="http://www.cmsaccount.com/contacts/">contact the script developer</a> to resolve the problem.</div>
			<?php
	}
?>
	<br>
	<input class="btn btn-primary" type="button" value="Test once more" onClick="location.href='<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=1&action=generate_sox'">
<?php
}
?>