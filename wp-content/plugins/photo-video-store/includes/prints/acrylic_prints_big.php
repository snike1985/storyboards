<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$pvs_theme_content[ 'print_content' ] = '<div id="print_preview" class="acrylic_prints_big" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;width:' . $pvs_theme_content[ 'big_width_prints' ] . 'px;height:' . $pvs_theme_content[ 'big_height_prints' ] . 'px">
	<div class="acrylic_prints_big_left" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;background-position: 100% 0px;"></div>
	<div class="acrylic_prints_big_bottom" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;background-position: 0px 100%;"></div>
	<div class="acrylic_prints_big_shadow"></div>
	<div class="acrylic_prints_big_mounting1"></div>
	<div class="acrylic_prints_big_mounting2"></div>
	<div class="acrylic_prints_big_mounting3"></div>
	<div class="acrylic_prints_big_mounting4"></div>
</div>';
?>


