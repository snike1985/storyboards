<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$audio_player = '<script src="' . $player_audio_root . '/assets/js/mediaelementjs/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="' . $player_audio_root . '/assets/js/mediaelementjs/mediaelementplayer.min.css" />
<audio id="player2" src="' . $player_preview_audio . '" type="audio/mp3" controls="controls">		
</audio>	
<script>
$("audio,video").mediaelementplayer();
</script>';
?>

