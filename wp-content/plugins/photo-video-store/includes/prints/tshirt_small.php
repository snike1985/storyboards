<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
$pvs_theme_content[ 'print_content' ] = '<div class="home_box" style="border:0">
	
	<div class="tshirt_small" style="background:url(\'' . pvs_plugins_url() . '/includes/prints/images/tshirt.png\');" onClick="location.href=\'' . $pvs_theme_content[ 'print_url' ] . '\'">
		<a href="' . $pvs_theme_content[ 'print_url' ] . '"><img src="' . $pvs_theme_content[ 'item_img2' ] . '"></a>
	</div>';
	
if ( @$show_print_title == true) {
	$pvs_theme_content[ 'print_content' ] .= '<div class="acrylic_prints_title">
		<a href="' . $pvs_theme_content[ 'print_url' ] . '">' . $pvs_theme_content[ 'item_title' ] . '</a>
		<div class="price">' . $pvs_theme_content[ 'price' ] . '</div>
	</div>';
}

$pvs_theme_content[ 'print_content' ] .= '</div>';
?>