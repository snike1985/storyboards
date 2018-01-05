<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_signup" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'change_fields' )
{
	include ( "change_fields.php" );
}

if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>






<h1><?php echo pvs_word_lang( "sign up" )?></h1>



<h4><?php echo pvs_word_lang( "Sign up fields" )?></h4>

	<form method="post">
	<input type="hidden" name="action" value="change_fields">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><b><?php echo pvs_word_lang( "title" )?>:</b></th>
	<th><b><?php echo pvs_word_lang( "priority" )?>:</b></th>	
	<th><b><?php echo pvs_word_lang( "required" )?>:</b></th>
	<th><b><?php echo pvs_word_lang( "columns" )?></b></th>
	<th><b><?php echo pvs_word_lang( "sign up" )?></b></th>
	<th><b><?php echo pvs_word_lang( "my profile" )?></b></th>
	</tr>
	</thead>
	
	<?php

$sql = "select * from " . PVS_DB_PREFIX .
	"users_fields   group by field_name order by columns,priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
?>
			<tr>
				<td><?php
	if ( $rs->row["required"] == 1 ) {
		echo ( "<b>" );
	}
?><?php echo pvs_word_lang( $rs->row["title"] )?><?php
	if ( $rs->row["required"] == 1 ) {
		echo ( "</b>" );
	}
?></td>
				<td><input name="priority<?php echo $rs->row["id"] ?>" type="text" value="<?php echo $rs->row["priority"] ?>" style="width:50px"></td>
				<td><input name="required<?php echo $rs->row["id"] ?>" type="checkbox" <?php
	if ( $rs->row["required"] == 1 ) {
		echo ( "checked" );
	}
?> value="1" <?php
	if ( $rs->row["field_name"] == "login" or $rs->row["field_name"] == "password" or
		$rs->row["field_name"] == "email" ) {
		echo ( "readonly onclick='return false'" );
	}
?>></td>
				<td>
					<select style="width:100px" name="columns<?php echo $rs->row["id"] ?>">
						<option value="0" <?php
	if ( $rs->row["columns"] == 0 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "left" )?></option>
						<option value="1" <?php
	if ( $rs->row["columns"] == 1 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "right" )?></option>
					</select>
				</td>
				<td><input name="signup<?php echo $rs->row["id"] ?>" <?php
	if ( $rs->row["signup"] == 1 ) {
		echo ( "checked" );
	}
?> type="checkbox" value="1" <?php
	if ( $rs->row["field_name"] == "login" or $rs->row["field_name"] == "password" or
		$rs->row["field_name"] == "email" ) {
		echo ( "readonly onclick='return false'" );
	}
?>></td>
				<td><input name="profile<?php echo $rs->row["id"] ?>" <?php
	if ( $rs->row["profile"] == 1 ) {
		echo ( "checked" );
	}
?> type="checkbox" value="1" <?php
	if ( $rs->row["field_name"] == "login" or $rs->row["field_name"] == "password" or
		$rs->row["field_name"] == "email" ) {
		echo ( "readonly onclick='return false'" );
	}
?>></td>
			</tr>
			<?php
	
	$rs->movenext();
}
?>
	
	</table>
	<br>
	<p><input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>"></p>
	</form><br>

<h4><?php echo pvs_word_lang( "customer agreement" );?></h4>



<form method="post">
<input type="hidden" name="action" value="change">

<select name="signup_terms" style="width:250px">
				<option value="0"><?php echo pvs_word_lang( "No" );?></option>
				<?php
		$sql = "select ID, post_title from " . $table_prefix .
			"posts where post_type = 'page' and post_status = 'publish' order by post_title";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$sel = "";
			if ( $ds->row["ID"] == $pvs_global_settings["signup_terms"] )
			{
				$sel = "selected";
			}
?>
					<option value="<?php
			echo $ds->row["ID"]
?>" <?php
			echo $sel
?>><?php
			echo $ds->row["post_title"]
?></option>
					<?php
			$ds->movenext();
		}
?>
			</select><br><br>
<input type="submit"  class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</form>




<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>