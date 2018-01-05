<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_content_types" );

$flag = false;

//Count files.
$count_types = 0;
$content_name = "";
$content_select = "";

$sql = "select id_parent,priority,name from " . PVS_DB_PREFIX .
	"content_type order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( ( int )$_GET["id"] == $rs->row["id_parent"] )
	{
		$content_name = $rs->row["name"];

		$sql = "select count(id) as count_types from " . PVS_DB_PREFIX .
			"media where content_type='" . $rs->row["name"] . "' group by content_type";
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$count_types += $ds->row["count_types"];
		}
	} else
	{
		$content_select .= "<option value='" . $rs->row["name"] . "'>" . $rs->row["name"] .
			"</option>";
	}
	$rs->movenext();
}
?>










<h1><?php
echo pvs_word_lang( "content type" )
?>:</h1>



<p><b><?php
echo $count_types
?></b> files have <b>"<?php
echo $content_name
?>"</b> content type which you want to remove.</p>

<p>You should select other content type for the files:</p>

<form method="post">
<input type="hidden" name="action" value="delete2">
<input type="hidden" name="id" value="<?php
echo $_GET["id"]
?>">
<select name="new_type" style="width:200px">
<?php
echo $content_select
?>
</select><br><br>
<p><input type="submit" value="<?php
echo pvs_word_lang( "delete" )
?>" class="button button-primary button-large"></p>
</form>


