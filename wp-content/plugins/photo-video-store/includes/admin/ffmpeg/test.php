<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

if ( @$_GET["action"] != 'generate' )
{
?>
	<p>Before using FFMPEG we strongly recommend you to test it.<br><br>
	There is a file <b><?php
	echo pvs_upload_dir( 'baseurl' )
?>/content/video.avi</b> on ftp. The script must create video and jpg previews for the video.</p>
	<input class="btn btn-primary" type="button" value="Generate video preview" onClick="location.href='<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&action=generate'">
<?php
} else
{
?>
	<h2>Result:</h2>
	<?php
	if ( $pvs_global_settings["ffmpeg_video_format"] == "flv" )
	{
		$flv = "/content/thumb.flv";
	} else
	{
		$flv = "/content/thumb.mp4";
	}
	if ( file_exists( pvs_upload_dir() . $flv ) )
	{
?>
			<p>The <b>video preview file</b> has been generated successfully.</p>
			<?php
			$player_video_id = 0;
			$player_video_root = pvs_plugins_url();
			$player_preview_video = pvs_upload_dir( 'baseurl' ) . $flv;
			$player_preview_photo = '';
			$player_video_width = $pvs_global_settings["ffmpeg_video_width"];
			$player_video_height = $pvs_global_settings["ffmpeg_video_height"];
			
			include(PVS_PATH . "includes/players/video_player.php");
			
			echo($video_player);
			
?>
			<br><br>
			<p><b>JPG photo preview:</b></p>
			<table border="0" cellpadding="2" cellspacing="0">
			<tr>
			<?php
		$dir = opendir( pvs_upload_dir() . "/content" );
		while ( $file = readdir( $dir ) )
		{
			if ( $file <> "." && $file <> ".." )
			{
				if ( preg_match( "/thumb/i", $file ) )
				{
					if ( preg_match( "/.jpg$/i", $file ) )
					{
?>
							<td><img src="<?php
						echo pvs_upload_dir( 'baseurl' )
?>/content/<?php
						echo $file
?>"></td>
							<?php
					}
				}
			}
		}
		closedir( $dir );
?>
			</tr>
			</table>
			<?php
	} else
	{
?>
			<div class="card">The error occured during the video preview convertation. Please make sure that FFMPEG installed on your server. Also you can <a href="http://www.cmsaccount.com/contacts/">contact the script developer</a> to resolve the problem.</div>
			<?php
	}
?>
	<br>
	<input class="btn btn-primary" type="button" value="Test once more" onClick="location.href='<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&action=generate'">
<?php
}
?>