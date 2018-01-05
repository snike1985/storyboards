<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_countries" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"countries (name,priority,activ) values ('" . pvs_result( $_POST["country"] ) .
		"',1,1)";
	$db->execute( $sql );
}

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	$sql = "select * from " . PVS_DB_PREFIX . "countries";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$sql = "update " . PVS_DB_PREFIX . "countries set priority=" . ( int )$_POST["priority" .
			$rs->row["id"]] . ",activ=" . ( int )@$_POST["country" . $rs->row["id"]] .
			" where id=" . $rs->row["id"];
		$db->execute( $sql );

		$rs->movenext();
	}
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	$sql = "delete from " . PVS_DB_PREFIX . "countries where id=" . ( int )$_GET["id"];
	$db->execute( $sql );
}
?>

<script language="javascript">
function select_all_countries()
{
	$('#form_countries input:checkbox').each(function(){this.checked = !this.checked;});
}

function select_all_eucountries()
{
	$("input:checkbox").attr("checked",false);
	$('input.eu:checkbox').prop('checked','checked');
}
</script>

<h1><?php
echo pvs_word_lang( "Countries" )
?></h1>
<p>

<form method="post"  style="margin-bottom:20px;float:right">
<input type="hidden" name="action" value="add">
<input name="country" type="text" value="" style="width:200px;display:inline">&nbsp;<input type="submit" class="button button-secondary button-large" value="<?php
echo pvs_word_lang( "add" )
?>" style="display:inline">
</form>

<a href="javascript:select_all_countries()" class="button button-secondary button-small"><i class="fa fa-check-square"></i>&nbsp; 
 <?php
echo pvs_word_lang( "select all" )
?>/<?php
echo pvs_word_lang( "deselect all" )
?></a>&nbsp;&nbsp;
<a href="javascript:select_all_eucountries()" class="button button-secondary button-small"><i class="fa fa-check-circle"></i>&nbsp; <?php
echo pvs_word_lang( "Select EU Countries" )
?></a>
</p><br>



<form method="post" id="form_countries">
<input type="hidden" name="action" value="change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b><?php
echo pvs_word_lang( "active" )
?></b></th>
<th style="width:50%"><b><?php
echo pvs_word_lang( "country" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "priority" )
?></b></th>
<th></th>
</tr>
</thead>
<?php
$sql = "select * from " . PVS_DB_PREFIX . "countries order by priority,name";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$eu = "";
	if ( in_array( $rs->row["name"], $mcountry_eu ) )
	{
		$eu = "class='eu'";
	}
?>
<tr>
<td><input type="checkbox" name="country<?php
	echo $rs->row["id"]
?>" <?php
	if ( $rs->row["activ"] == 1 )
	{
		echo ( "checked" );
	}
?> value="1" <?php
	echo $eu
?>></td>
<td><?php
	echo $rs->row["name"]
?></td>
<td><input type="text" name="priority<?php
	echo $rs->row["id"]
?>" value="<?php
	echo $rs->row["priority"]
?>"></td>
<td><a href='<?php
	echo ( pvs_plugins_admin_url( 'countries/index.php' ) );
?>&action=delete&id=<?php
	echo $rs->row["id"]
?>'><?php
	echo pvs_word_lang( "delete" )
?></a></td>
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