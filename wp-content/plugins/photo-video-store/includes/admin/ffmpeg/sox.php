<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );
?>


<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">
	<p><a href="http://sox.sourceforge.net/"><b>Sox</b></a> is a library which allows to generate <b> *.mp3 previews</b> for an audio file. You should ask your hosting support if your server supports the software. Otherwise you have to upload the video's previews separately.</p>
	
	<p>Sox is able to add a "<b>watermark</b>" for an audio file too.</p>
	
	<p>Sox must be installed with <b>mp3 files support</b>. The php function <b>exec()</b> must be enabled on the server.</p>
	
	<p>You can modify the sox command in the file: <b>/wp-content/plugins/photo-video-store/includes/functions/functions.php</b>, function: <b>pvs_generate_mp3()</b>.</p>
	
	<p>If something doesn't work you have to <a href="http://www.cmsaccount.com/contacts/"><b>contact the script developer</b></a> to set, test, change the exec command. It is an external software. Its functionality strongly depends on the server's settings. Sometimes it requires small adjustments.</p>
</div>

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
	<?php
include ( "settings_sox.php" );
?>
</div>

<div class="subheader"><?php
echo pvs_word_lang( "test" )
?></div>
<div class="subheader_text">
	<?php
include ( "test_sox.php" );
?>
</div>


