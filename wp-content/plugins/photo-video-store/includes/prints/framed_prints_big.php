<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
$pvs_theme_content[ 'print_content' ] = '<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td id="frame_top_left"></td>
	<td id="frame_top_center"></td>
	<td id="frame_top_right"></td>
</tr>
<tr>
	<td id="frame_center_left"></td>
	<td id="frame_center_center">
		<div class="prints_top_mat">
			<div class="prints_bottom_mat">
				<div id="print_preview" class="prints_big" style="background:url(\'' . $pvs_theme_content[ 'image' ] . '\');background-size:cover;width:' . $pvs_theme_content[ 'big_width_prints' ] . 'px;height:' . $pvs_theme_content[ 'big_height_prints' ] . 'px"></div>
			</div>
		</div>
	</td>
	<td id="frame_center_right"></td>
</tr>
<tr>
	<td id="frame_bottom_left"></td>
	<td id="frame_bottom_center"></td>
	<td id="frame_bottom_right"></td>
</tr>
</table>';
?>
