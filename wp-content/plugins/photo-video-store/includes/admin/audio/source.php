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
	<input type="hidden" name="action" value="source_add">
	<input name="new" type="text" value="" style="width:200px;display:inline"> <input type="submit" class="btn btn-success" value="<?php
echo pvs_word_lang( "add" )
?>" style="display:inline">
</form>
<br>



<?php
//������� ��������
if ( ! isset( $_GET["str"] ) )
{
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

//���������� �������� �� ��������
$kolvo = $pvs_global_settings["k_str"];

//���������� ������� �� ��������
$kolvo2 = PVS_PAGE_NUMBER;
?>











<?php
$n = 0;
$sql = "select * from " . PVS_DB_PREFIX . "audio_source order by name";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<form method="post">
	<input type="hidden" name="action" value="source_delete">
	<input type="hidden" name="d" value="1">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><b><?php
	echo pvs_word_lang( "name" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "delete" )
?>:</b></th>
	
	</tr>
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
	echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'audio/index.php' ),
		"&d=1" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>