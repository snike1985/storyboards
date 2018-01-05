<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );
?>
<form method="post">
	<input type="hidden" name="action" value="ratio_add">
	<input name="new" type="text" value="" style="width:200px;display:inline"> <input name="width" type="text" value="4" style="width:50px;display:inline">&nbsp;:&nbsp;<input name="height" type="text" value="3" style="width:50px;display:inline">&nbsp;<input type="submit" class="btn btn-success" value="<?php
echo pvs_word_lang( "add" )
?>" style="display:inline">
</form>
<br>


<?php
//Текущая страница
if ( ! isset( $_GET["str"] ) )
{
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

//Количество новостей на странице
$kolvo = $pvs_global_settings["k_str"];

//Количество страниц на странице
$kolvo2 = PVS_PAGE_NUMBER;
?>















<?php
$n = 0;
$sql = "select * from " . PVS_DB_PREFIX . "video_ratio order by name";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<form method="post">
	<input type="hidden" name="action" value="ratio_delete">
	<input type="hidden" name="d" value="2">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th colspan="2"><b><?php
	echo pvs_word_lang( "name" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "delete" )
?>:</b></th>
	
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str )
		{
?>
			<tr>	
			<td><input type="text" name="title<?php
			echo $rs->row["id"]
?>" value="<?php
			echo $rs->row["name"]
?>" style="width:250px"></td>	
			<td><input type="text" name="width<?php
			echo $rs->row["id"]
?>" value="<?php
			echo $rs->row["width"]
?>" style="width:50px;display:inline"> : <input type="text" name="height<?php
			echo $rs->row["id"]
?>" value="<?php
			echo $rs->row["height"]
?>" style="width:50px;display:inline"></td>
			<td><input type="checkbox" id="m<?php
			echo $rs->row["id"]
?>" name="m<?php
			echo $rs->row["id"]
?>" value="1"></td>
			</tr>	
			<?php
		}
		$n++;
		$rs->movenext();
	}
?>
	</table>
	
	<br>
	<p><input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>"></p></form>
	
	<?php
	echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'video/index.php' ),
		"&d=2" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>