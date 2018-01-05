<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$video_player = '<script src="' . $player_video_root . '/assets/js/jwplayer/jwplayer.js"></script>
<script>jwplayer.key="ptjJrvi3YcZfpkwX0KQT7v11POQ7ql+ormMJMg==";</script>
<div id="players' . $player_video_id . '"></div>
<script>
var playerInstance = jwplayer("players' . $player_video_id . '");
playerInstance.setup({
    file: "' . $player_preview_video . '",
    image: "' . $player_preview_photo . '",
    width: ' . $player_video_width . ',
    height: ' . $player_video_height . ',
    title: "",
    description: ""
});
</script>';
?>