<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$pvs_theme_content[ 'print_content' ] = '<div id="print_preview" class="canvas_prints_big" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;width:' . $pvs_theme_content[ 'big_width_prints' ] . 'px;height:' . $pvs_theme_content[ 'big_height_prints' ] . 'px">
	<div class="canvas_prints_big_left" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;background-position: 100% 0px;"></div>
	<div class="canvas_prints_big_bottom" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;background-position: 0px 100%;"></div>
	<div class="canvas_prints_big_shadow"></div>
</div>';

?>

