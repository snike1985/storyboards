<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_prices" );

$photo_formats = array();
$sql = "select * from " . PVS_DB_PREFIX .
	"photos_formats where enabled=1 order by id";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$photo_formats[] = $rs->row["photo_type"];
	$rs->movenext();
}
?>


<div class="subheader"><?php
echo pvs_word_lang( "Add new price" )
?></div>
<div class="subheader_text">


<p>If you want to add an original size of a photo you need to set Max width/height = 0</p>



<form method="post">
<input type="hidden" name="action" value="photo_add">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b><?php
echo pvs_word_lang( "title" )
?></b></th>
<th><b>Max width/height</b></th>
<th><b><?php
echo pvs_word_lang( "price" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "file types" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "priority" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "license" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "watermark" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "settings" )
?></b></th>
</tr>
</thead>
<tr>
<td><input type="text" name="title" value="New price" style="width:150px"></td>
<td><input type="text" name="size" value="0" style="width:50px"></td>
<td><input type="text" name="price" value="1.00" style="width:50px"></td>
<td>
<?php
foreach ( $photo_formats as $key => $value )
{
?>
	<div style="margin-bottom:5px"><input type="checkbox" name="<?php
	echo $value
?>" value="1" checked>&nbsp;<?php
	echo $value
?></div>
	<?php
}
?>
</td>
<td><input type="text" name="priority" value="0" style="width:50px"></td>
<td>
<select name="license">
<?php
$sql = "select * from " . PVS_DB_PREFIX . "licenses order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
?>
<option value="<?php
	echo $rs->row["id_parent"]
?>"><?php
	echo $rs->row["name"]
?></option>
<?php
	$rs->movenext();
}
?>
</select>
</td>
<td>
<input type="checkbox" name="watermark">
</td>
<td>
<select name="addto">
<option value="0">Add to NEW publications only</option>
<option value="1">Add to ALL  publications</option>
</select>
</td>
</tr>
</table>
<br>
<p><input type="submit" class="btn btn-success" value="<?php
echo pvs_word_lang( "add" )
?>"></p>
</form>

<?php
if ( isset( $_GET["type"] ) )
{
?>
<p class="warning">
<?php
	if ( $_GET["type"] == "add" )
	{
?>
<b>The photo size has been added successfully.</b>
<?php
	}
	if ( $_GET["type"] == "change" )
	{
?>
<b>The photo sizes have been changed successfully.</b>
<?php
	}
	if ( isset( $_GET["items_count"] ) )
	{
?>
<br><?php
		echo $_GET["items_count"]
?> photos were changed.
<?php
	}
?>
</p>
<?php
}
?>
</div>


<div class="subheader"><?php
echo pvs_word_lang( "prices" )
?>:</div>
<div class="subheader_text">



<?php
$sql = "select * from " . PVS_DB_PREFIX . "licenses order by priority";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
<form method="post">
<input type="hidden" name="action" value="photo_change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th style="width:60%"><b><?php
	echo pvs_word_lang( "title" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "file types" )
?></b></th>
<th><b>Max width/height</b></th>
<th><b><?php
	echo pvs_word_lang( "price" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "priority" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "watermark" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
</tr>
</thead>
<?php
	while ( ! $rs->eof )
	{
?>
<tr class="snd">
<td colspan="7" class="big"><?php
		echo $rs->row["name"]
?></td>
</tr>
<?php
		$sql = "select * from " . PVS_DB_PREFIX . "sizes where license=" . $rs->row["id_parent"] .
			" order by priority";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
?>
<tr>
<td><input type="text" name="title<?php
			echo $dr->row["id_parent"]
?>" value="<?php
			echo $dr->row["title"]
?>" style="width:300px"></td>
<td>
<?php
			foreach ( $photo_formats as $key => $value )
			{
?>
	<div style="margin-bottom:5px"><input type="checkbox" name="<?php
				echo $value
?><?php
				echo $dr->row["id_parent"]
?>" value="1" <?php
				if ( $dr->row[$value] == 1 )
				{
					echo ( "checked" );
				}
?>>&nbsp;<?php
				echo $value
?></div>
	<?php
			}
?>
</td>
<td><input type="text" name="size<?php
			echo $dr->row["id_parent"]
?>" value="<?php
			echo $dr->row["size"]
?>" style="width:50px"></td>
<td><input type="text" name="price<?php
			echo $dr->row["id_parent"]
?>" value="<?php
			echo pvs_price_format( $dr->row["price"], 2 )
?>" style="width:50px"></td>
<td><input type="text" name="priority<?php
			echo $dr->row["id_parent"]
?>" value="<?php
			echo $dr->row["priority"]
?>" style="width:50px"></td>
<td align="center"><input type="checkbox" name="watermark<?php
			echo $dr->row["id_parent"]
?>" value="1" <?php
			if ( $dr->row["watermark"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
<td align="center"><input name="delete<?php
			echo $dr->row["id_parent"]
?>" type="checkbox"></td>
</tr>
<?php
			$dr->movenext();
		}
		$rs->movenext();
	}
?>

<tr class="snd">
<td colspan="7">
<select name="addto" style="width:250px">
<option value="0">Not to change OLD publications</option>
<option value="1">Change ALL  publications</option>
</select>
</td>
</tr>

</table>

<br>
<p><input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>"></p>
</form><br>
<?php
}
?>
</div>


<div class="subheader"><?php
echo pvs_word_lang( "file types" )
?>:</div>
<div class="subheader_text">
<a name="formats"></a>

<?php
$sql = "select * from " . PVS_DB_PREFIX . "photos_formats order by id";
$rs->open( $sql );
?>
<form method="post">
<input type="hidden" name="action" value="photo_formats">
<?php
while ( ! $rs->eof )
{
?>
	<div style="margin-bottom:5px"><input type="checkbox" name="<?php
	echo $rs->row["photo_type"]
?>" value="1" <?php
	if ( $rs->row["enabled"] == 1 )
	{
		echo ( "checked" );
	}
?>>&nbsp;<?php
	echo $rs->row["title"]
?></div>
	<?php
	$rs->movenext();
}
?>


<br>
<p><input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>"></p>
</form><br>


</div>
