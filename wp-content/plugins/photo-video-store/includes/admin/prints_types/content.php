<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_types" );

$user_fields = array();
$user_fields["title"] = "";
$user_fields["description"] = "";
$user_fields["price"] = 1;
$user_fields["priority"] = 1;
$user_fields["weight"] = 0.001;
$user_fields["option1"] = 0;
$user_fields["option2"] = 0;
$user_fields["option3"] = 0;
$user_fields["option4"] = 0;
$user_fields["option5"] = 0;
$user_fields["option6"] = 0;
$user_fields["option7"] = 0;
$user_fields["option8"] = 0;
$user_fields["option9"] = 0;
$user_fields["option10"] = 0;
$user_fields["option1_value"] = "";
$user_fields["option2_value"] = "";
$user_fields["option3_value"] = "";
$user_fields["option4_value"] = "";
$user_fields["option5_value"] = "";
$user_fields["option6_value"] = "";
$user_fields["option7_value"] = "";
$user_fields["option8_value"] = "";
$user_fields["option9_value"] = "";
$user_fields["option10_value"] = "";
$user_fields["photo"] = 1;
$user_fields["printslab"] = 1;
$user_fields["category"] = 0;
$user_fields["preview"] = 0;
$user_fields["resize"] = 0;
$user_fields["resize_min"] = $pvs_global_settings["thumb_width2"];
$user_fields["resize_max"] = $pvs_global_settings["prints_previews_width"];
$user_fields["resize_value"] = $pvs_global_settings["thumb_width2"];
$user_fields["in_stock"] = -1;

if ( isset( $_GET["id"] ) )
{
	$sql = "select * from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		$user_fields["title"] = $rs->row["title"];
		$user_fields["description"] = $rs->row["description"];
		$user_fields["price"] = $rs->row["price"];
		$user_fields["priority"] = $rs->row["priority"];
		$user_fields["weight"] = $rs->row["weight"];
		$user_fields["option1"] = $rs->row["option1"];
		$user_fields["option2"] = $rs->row["option2"];
		$user_fields["option3"] = $rs->row["option3"];
		$user_fields["option4"] = $rs->row["option4"];
		$user_fields["option5"] = $rs->row["option5"];
		$user_fields["option6"] = $rs->row["option6"];
		$user_fields["option7"] = $rs->row["option7"];
		$user_fields["option8"] = $rs->row["option8"];
		$user_fields["option9"] = $rs->row["option9"];
		$user_fields["option10"] = $rs->row["option10"];
		$user_fields["option1_value"] = $rs->row["option1_value"];
		$user_fields["option2_value"] = $rs->row["option2_value"];
		$user_fields["option3_value"] = $rs->row["option3_value"];
		$user_fields["option4_value"] = $rs->row["option4_value"];
		$user_fields["option5_value"] = $rs->row["option5_value"];
		$user_fields["option6_value"] = $rs->row["option6_value"];
		$user_fields["option7_value"] = $rs->row["option7_value"];
		$user_fields["option8_value"] = $rs->row["option8_value"];
		$user_fields["option9_value"] = $rs->row["option9_value"];
		$user_fields["option10_value"] = $rs->row["option10_value"];
		$user_fields["photo"] = $rs->row["photo"];
		$user_fields["printslab"] = $rs->row["printslab"];
		$user_fields["category"] = $rs->row["category"];
		$user_fields["preview"] = $rs->row["preview"];
		$user_fields["resize"] = $rs->row["resize"];
		$user_fields["resize_min"] = $rs->row["resize_min"];
		$user_fields["resize_max"] = $rs->row["resize_max"];
		$user_fields["resize_value"] = $rs->row["resize_value"];
		$user_fields["in_stock"] = $rs->row["in_stock"];
	}
}
?>

<script>
function change_quantity(value)
{
	if(value == -1)
	{
		$("#quantity").css("display","none");
	}
	else
	{
		$("#quantity").css("display","block");	
	}
}
</script>

<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>" class="btn btn-primary btn-sm btn-mini"><b><i class="fa fa-arrow-left"></i>&nbsp; <?php
echo pvs_word_lang( "back" )
?></a></div>




<h1><?php
echo pvs_word_lang( "prints and products" )
?> &mdash; <?php
if ( ! isset( $_GET["id"] ) )
{
	echo ( pvs_word_lang( "add" ) . " " );
} else
{
	echo ( pvs_word_lang( "edit" ) . " " );
}
?></h1>





<div class="box box_padding">






<form method="post"  Enctype="multipart/form-data">
<input type="hidden" name="action" value="add">
<?php
if ( isset( $_GET["id"] ) )
{
	echo ( "<input type='hidden' name='id' value='" . $_GET["id"] . "'>" );
}
?>

<div class="subheader"><?php
echo pvs_word_lang( "common information" )
?></div>
<div class="subheader_text">

	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "title" )
?>:</span>
		<input type="text" name="title" value="<?php
echo $user_fields["title"]
?>" style="width:350px">
	</div>
	

	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "category" )
?>:</span>
		<select name="category" style="width:350px">
			<option value="0"></option>
			<?php
$sql = "select title,id from " . PVS_DB_PREFIX .
	"prints_categories order by priority";
$ds->open( $sql );
while ( ! $ds->eof )
{
	$sel = "";
	if ( $ds->row["id"] == $user_fields["category"] )
	{
		$sel = "selected";
	}
?>
				<option value="<?php
	echo $ds->row["id"]
?>" <?php
	echo $sel
?>><?php
	echo $ds->row["title"]
?></option>
				<?php
	$ds->movenext();
}
?>
		</select>
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "previews" )
?>:</span>
		<select name="preview" style="width:350px">
			<option value="0"></option>
			<?php
$sql = "select title,id from " . PVS_DB_PREFIX .
	"prints_previews order by title";
$ds->open( $sql );
while ( ! $ds->eof )
{
	$sel = "";
	if ( $ds->row["id"] == $user_fields["preview"] )
	{
		$sel = "selected";
	}
?>
				<option value="<?php
	echo $ds->row["id"]
?>" <?php
	echo $sel
?>><?php
	echo $ds->row["title"]
?></option>
				<?php
	$ds->movenext();
}
?>
		</select>
	</div>
	
	<script>
		function show_resize()
		{
			if($("#resize_print").prop("checked"))
			{
				$('#resize_fields').css("display","block");
			}
			else
			{
				$('#resize_fields').css("display","none");
			}
		}
	</script>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "Allow to resize and move a photo" )
?>:</span>
		<input type="checkbox" name="resize" id="resize_print" value="1" <?php
if ( $user_fields["resize"] == 1 )
{
	echo ( "checked" );
}
?> onClick="show_resize()">
	</div>
	
	<div id="resize_fields" style="display:<?php
if ( $user_fields["resize"] == 1 )
{
	echo ( "block" );
} else
{
	echo ( "none" );
}
?>">
		<div class='admin_field'>
			<span><?php
echo pvs_word_lang( "Resize min (px)" )
?>:</span>
			<input type="text" name="resize_min" value="<?php
echo $user_fields["resize_min"]
?>" style="width:150px">
		</div>	
		
		<div class='admin_field'>
			<span><?php
echo pvs_word_lang( "Resize max (px)" )
?>:</span>
			<input type="text" name="resize_max" value="<?php
echo $user_fields["resize_max"]
?>" style="width:150px">
		</div>	
		
		<div class='admin_field'>
			<span><?php
echo pvs_word_lang( "Resize default (px)" )
?>:</span>
			<input type="text" name="resize_value" value="<?php
echo $user_fields["resize_value"]
?>" style="width:150px">
		</div>	
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "description" )
?>:</span>
		<textarea name="description" style="width:350px;height:80px"><?php
echo $user_fields["description"]
?></textarea>
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "price" )
?>:</span>
		<input type="text" name="price" value="<?php
echo $user_fields["price"]
?>" style="width:150px">
	</div>	
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "quantity" )
?>:</span>
		<select id='quantity_type' name='quantity_type' class='form-control' onChange="change_quantity(this.value)" style="width:150px">
			<option value="-1" <?php
if ( $user_fields["in_stock"] == -1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "Unlimited" )
?></option>
			<option value="0" <?php
if ( $user_fields["in_stock"] >= 0 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "Value" )
?></option>
		</select>
		<input type="text"  id='quantity' name='quantity' value="<?php
if ( $user_fields["in_stock"] >= 0 )
{
	echo ( $user_fields["in_stock"] );
} else
{
	echo ( 0 );
}
?>"  style="width:150px;margin-top:3px;<?php
if ( $user_fields["in_stock"] == -1 )
{
	echo ( "display:none" );
}
?>">
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "weight" )
?> (<?php
echo $pvs_global_settings["weight"]
?>):</span>
		<input type="text" name="weight" value="<?php
echo $user_fields["weight"]
?>" style="width:150px">
	</div>	
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "priority" )
?>:</span>
		<input type="text" name="priority" value="<?php
echo $user_fields["priority"]
?>" style="width:150px">
	</div>	
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "photo" )
?>:</span>
		<input type="checkbox" name="photo" value="1" <?php
if ( $user_fields["photo"] == 1 )
{
	echo ( "checked" );
}
?>>
	</div>	
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "prints lab" )
?>:</span>
		<input type="checkbox" name="printslab" value="1" <?php
if ( $user_fields["printslab"] == 1 )
{
	echo ( "checked" );
}
?>>
	</div>	
	



</div>
	

<div class="subheader"><?php
echo pvs_word_lang( "products options" )
?></div>
<div class="subheader_text">

	<?php
for ( $i = 1; $i < 11; $i++ )
{
?>
	<div class='admin_field'>
		<table>
		<tr>
		<th><?php
	echo pvs_word_lang( "property" )
?> <?php
	echo $i
?>:</th>
		<th style="padding-left:30px"><?php
	echo pvs_word_lang( "value" )
?> <?php
	echo $i
?>:</th>
		</tr>
		<tr>
		<td>
		<select name="option<?php
	echo $i
?>" style="width:250px">
			<option value="0"></option>
			<?php
	$sql = "select id,title from " . PVS_DB_PREFIX .
		"products_options order by title";
	$ds->open( $sql );
	while ( ! $ds->eof )
	{
		$sel = "";
		if ( $user_fields["option" . $i] == $ds->row["id"] )
		{
			$sel = "selected";
		}
?>
					<option value="<?php
		echo $ds->row["id"]
?>" <?php
		echo $sel
?>><?php
		echo $ds->row["title"]
?></option>
					<?php
		$ds->movenext();
	}
?>
		</select>
		</td>
		<td style="padding-left:30px">
			<input type="text" name="option_value<?php
	echo $i
?>" value="<?php
	echo $user_fields["option" . $i . "_value"]
?>" style="width:300px">
		</td>
		</tr>
		</table>
	</div>	
	<?php
}
?>
	

	
</div>

<div class="subheader"><?php
echo pvs_word_lang( "photo" )
?></div>
<div class="subheader_text">
<?php
for ( $i = 1; $i < 6; $i++ )
{
?>
	<div class='admin_field'>
		<span><?php
	echo pvs_word_lang( "photo" )
?> <?php
	echo $i
?>:</span>
		<input type="file" style="width:250px" name="photo<?php
	echo $i
?>">
		<?php
	if ( isset( $_GET["id"] ) and file_exists( pvs_upload_dir() .
		"/content/prints/product" . ( int )$_GET["id"] . "_" . $i . "_big.jpg" ) )
	{
?>
			<div style='padding-top:3px'><div id='preview' style='display:inline'><a href="<?php
		echo pvs_upload_dir( 'baseurl' ) . "/content/prints/product" . ( int )$_GET["id"] .
			"_" . $i . "_big.jpg"
?>" class="btn btn-default"><?php
		echo pvs_word_lang( "preview" )
?></a></div>&nbsp;&nbsp;&nbsp;
			<a href='<?php
		echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>&action=delete_photo&id=<?php
		echo $_GET["id"]
?>&type=<?php
		echo $i
?>' class="btn btn-default"><?php
		echo pvs_word_lang( "delete" )
?></a></div>
		<?php
	}
?>
	</div>
<?php
}
?>	

</div>


<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>">
		</div>
	</div>




</form>

</div>
