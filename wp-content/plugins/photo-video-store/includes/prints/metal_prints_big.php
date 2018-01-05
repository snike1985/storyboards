<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
$pvs_theme_content[ 'print_content' ] = '<div id="print_preview" class="metal_prints_big" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;width:' . $pvs_theme_content[ 'big_width_prints' ] . 'px;height:' . $pvs_theme_content[ 'big_height_prints' ] . 'px">
	<div class="metal_prints_big_left"></div>
	<div class="metal_prints_big_bottom"></div>
	<div class="metal_prints_big_shadow"></div>
</div>';
?>


