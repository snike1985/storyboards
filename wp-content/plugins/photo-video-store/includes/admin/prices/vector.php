<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_prices" );
?>



<div class="subheader"><?php
echo pvs_word_lang( "Add new price" )
?></div>
<div class="subheader_text">

<p>* You may add ANY vector type. You should use "," as separator. Example types: zip,psd</p>

<p>** Sometimes a file's price depends on a license. To avoid uploading the same file for the different licenses you should set one number > 0 in the fields. For example, you set "4" for price A and "4" for price B. A seller will upload only one file and it will be related with price A and price B. The file type of the prices must be the same. If the prices are not related you should set 0.</p>



<form method="post">
<input type="hidden" name="action" value="vector_add">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b><?php
echo pvs_word_lang( "title" )
?></b></th>
<th><b>*<?php
echo pvs_word_lang( "type" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "shipped" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "price" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "priority" )
?></b></th>
<th><b>**<?php
echo pvs_word_lang( "the same file" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "license" )
?></b></th>
<th><b><?php
echo pvs_word_lang( "settings" )
?></b></th>
</tr>
</thead>
<tr>
<td><input type="text" name="title" value="New price" style="width:100px"></td>
<td><input type="text" name="types" value="zip" style="width:100px"></td>
<td align="center"><input type="checkbox" name="shipped"></td>
<td><input type="text" name="price" value="1.00" style="width:50px"></td>
<td><input type="text" name="priority" value="0" style="width:50px"></td>
<td><input type="text" name="thesame" value="0" style="width:50px"></td>
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
<div class="alert">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php
	if ( $_GET["type"] == "add" )
	{
?>
<b>The vector type has been added successfully.</b>
<?php
	}
	if ( $_GET["type"] == "change" )
	{
?>
<b>The vector types have been changed successfully.</b>
<?php
	}
	if ( isset( $_GET["items_count"] ) )
	{
?>
<br><?php
		echo $_GET["items_count"]
?> vectors were changed.
<?php
	}
?>
</div>
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
<input type="hidden" name="action" value="vector_change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th style="width:60%"><b><?php
	echo pvs_word_lang( "title" )
?></b></th>
<th><b>*<?php
	echo pvs_word_lang( "type" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "price" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "priority" )
?></b></th>
<th><b>**<?php
	echo pvs_word_lang( "the same file" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "shipped" )
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
		$sql = "select * from " . PVS_DB_PREFIX . "vector_types where license=" . $rs->
			row["id_parent"] . " order by priority";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
?>
<tr>
<td><input type="text" name="title<?php
			echo $dr->row["id_parent"]
?>" value="<?php
			echo $dr->row["title"]
?>" style="width:200px"></td>
<td class="gray">
<?php
			if ( $dr->row["shipped"] != 1 )
			{
?>
<input type="text" name="types<?php
				echo $dr->row["id_parent"]
?>" value="<?php
				echo $dr->row["types"]
?>" style="width:50px">
<?php
			} else
			{
				echo ( pvs_word_lang( "shipped" ) );
?>
<input type="hidden" name="types<?php
				echo $dr->row["id_parent"]
?>" value="shipped">
<?php
			}
?>
</td>
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
<td><input type="text" name="thesame<?php
			echo $dr->row["id_parent"]
?>" value="<?php
			echo $dr->row["thesame"]
?>" style="width:50px"></td>
<td align="center"><input name="shipped<?php
			echo $dr->row["id_parent"]
?>" type="checkbox" <?php
			if ( $dr->row["shipped"] == 1 )
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