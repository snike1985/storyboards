<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_languages" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	$sql = "update " . PVS_DB_PREFIX . "languages set activ=0,display=0";
	$db->execute( $sql );

	$sql = "update " . PVS_DB_PREFIX . "languages set activ=1 where name='" .
		pvs_result( $_POST["language"] ) . "'";
	$db->execute( $sql );

	$sql = "select * from " . PVS_DB_PREFIX . "languages";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		if ( isset( $_POST[str_replace( " ", "_", strtolower( $rs->row["name"] ) )] ) )
		{
			$sql = "update " . PVS_DB_PREFIX . "languages set display=1 where name='" . $rs->
				row["name"] . "'";
			$db->execute( $sql );
		}

		$rs->movenext();
	}
}
?>


<h1><?php
echo pvs_word_lang( "languages" )
?></h1>



<form method="post">
<input type="hidden" name="action" value="change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th></th>
<th style="width:80%"><b><?php
echo pvs_word_lang( "language" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "display" )
?></b></th>
</tr>
</thead>
<?php
$sql = "select * from " . PVS_DB_PREFIX . "languages order by activ desc, name";
$rs->open( $sql );
while ( ! $rs->eof )
{

	$lng3 = strtolower( $rs->row["name"] );
	if ( $lng3 == "chinese traditional" )
	{
		$lng3 = "chinese";
	}
	if ( $lng3 == "chinese simplified" )
	{
		$lng3 = "chinese";
	}
	if ( $lng3 == "afrikaans formal" )
	{
		$lng3 = "afrikaans";
	}
	if ( $lng3 == "afrikaans informal" )
	{
		$lng3 = "afrikaans";
	}
?>
<tr>
<td><input type="radio" name="language" value="<?php
	echo $rs->row["name"]
?>" <?php
	if ( $rs->row["activ"] == 1 )
	{
		echo ( "checked" );
	}
?>></td>
<td class="big"><img src="<?php
	echo ( pvs_plugins_url() . '/includes/admin/includes/img/languages/' );
?><?php
	echo $lng3
?>.gif" width="18" height="12">&nbsp;<?php
	echo $rs->row["name"]
?></td>
<td><input type="checkbox" name="<?php
	echo str_replace( " ", "_", strtolower( $rs->row["name"] ) )
?>" value="1" <?php
	if ( $rs->row["display"] == 1 )
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


<p><input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>"></p>
</form>













<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>