<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$video_player = '<link href="' . $player_video_root . '/assets/js/videojs/video-js.css" rel="stylesheet" type="text/css">
<script src="' . $player_video_root . '/assets/js/videojs/video.js"></script>
<script>
    videojs.options.flash.swf = "' . $player_video_root . '/assets/js/videojs/video-js.swf";
</script>
	
<video id="video_publication_preview" class="video-js vjs-default-skin" controls preload="auto" width="' . $player_video_width . '" height="' . $player_video_height . '"
      poster="' . $player_preview_photo . '"
      data-setup=\'{"techOrder": ["flash","html5" , "other supported tech"]}\'>
    <source src="' . $player_preview_video . '" type="video/mp4" />
</video>';


?>