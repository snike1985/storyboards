<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_audio" );

$sql = "select * from " . PVS_DB_PREFIX . "audio_fields order by priority";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<form method="post">
	<input type="hidden" name="action" value="fields_change">
	<input type="hidden" name="d" value="0">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><b><?php
	echo pvs_word_lang( "name" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "enable" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "required" )
?>:</b></th>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr>
		<input type="hidden" name="priority<?php
		echo $rs->row["id"]
?>" value="<?php
		echo $rs->row["priority"]
?>">
		<td class='big'><?php
		echo pvs_word_lang( $rs->row["name"] )
?></td>
		<td>
		<?php
		if ( $rs->row["always"] != 1 )
		{
?>
		<input type="checkbox" name="enable<?php
			echo $rs->row["id"]
?>" value="1" <?php
			if ( $rs->row["activ"] == 1 )
			{
				echo ( "checked" );
			}
?>>
		<?php
		} else
		{
?>
		<input type="hidden" name="enable<?php
			echo $rs->row["id"]
?>" value="1"><i class="fa fa-check-square-o" aria-hidden="true"></i>
		<?php
		}
?>
		</td>
		<td><input type="checkbox" name="required<?php
		echo $rs->row["id"]
?>" value="1" <?php
		if ( $rs->row["required"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
		</tr>
		<?php
		$rs->movenext();
	}
?>
	</table>
	
	<br>
	<p><input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>"></p></form>
	
	<?php
}
?>