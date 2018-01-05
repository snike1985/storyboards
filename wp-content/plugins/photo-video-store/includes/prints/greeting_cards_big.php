<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
$pvs_theme_content[ 'print_content' ] = '<div class="prints_top_mat">
	<div class="prints_bottom_mat">
		<div id="print_preview" class="prints_big img-responsive" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;width:' . $pvs_theme_content[ 'big_width_prints' ] . 'px;height:' . $pvs_theme_content[ 'big_height_prints' ] . 'px"></div>
	</div>
</div>';
?>

