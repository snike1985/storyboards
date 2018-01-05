<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_productsoptions" );

$user_fields = array();
$user_fields["title"] = "";
$user_fields["type"] = "selectform";
$user_fields["activ"] = 1;
$user_fields["required"] = 1;
$user_fields["description"] = "";
$user_fields["property_name"] = "";

$ranges_list = array();
$ranges_from = array();
$ranges_value = array();
$ranges_to = array();
$ranges_price = array();

if ( isset( $_GET["id"] ) )
{
	$sql = "select * from " . PVS_DB_PREFIX . "products_options where id=" . ( int )
		$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		$user_fields["title"] = $rs->row["title"];
		$user_fields["type"] = $rs->row["type"];
		$user_fields["activ"] = $rs->row["activ"];
		$user_fields["required"] = $rs->row["required"];
		$user_fields["description"] = $rs->row["description"];
		$user_fields["property_name"] = $rs->row["property_name"];

		$sql = "select * from " . PVS_DB_PREFIX .
			"products_options_items where id_parent=" . ( int )$_GET["id"] . " order by id";
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			while ( ! $ds->eof )
			{
				$ranges_list[] = count( $ranges_list );
				$ranges_from[] = $ds->row["title"];
				$ranges_value[] = $ds->row["property_value"];
				$ranges_to[] = $ds->row["adjust"];
				$ranges_price[] = $ds->row["price"];
				$ds->movenext();
			}
		} else
		{
			$ranges_list = array( 0, 1 );
			$ranges_from = array( 'New option 1', 'New option 2' );
			$ranges_value = array( '', '' );
			$ranges_to = array( 1, 1 );
			$ranges_price = array( 0, 0 );
		}
	}
} else
{
	$ranges_list = array( 0, 1 );
	$ranges_from = array( 'New option 1', 'New option 2' );
	$ranges_value = array( '', '' );
	$ranges_to = array( 1, 1 );
	$ranges_price = array( 0, 0 );
}

function build_rangers( $method )
{
	global $ranges_list;
	global $ranges_from;
	global $ranges_value;
	global $ranges_to;
	global $ranges_price;

	$res = "";

	for ( $i = 0; $i < count( $ranges_list ); $i++ )
	{
		$options = "";
		if ( $ranges_to[$i] == 1 )
		{
			$options = "<option value='1' selected>+</option><option value='-1'>-</option>";
		} else
		{
			$options = "<option value='1'>+</option><option value='-1' selected>-</option>";
		}

		$res .= "<tr id='tr" . $method . $ranges_list[$i] . "'>
					<td><input name='" . $method . $ranges_list[$i] . "_title' id='" . $method .
			$ranges_list[$i] . "_title' type='text' value='" . $ranges_from[$i] .
			"' style='width:150px;'></td>
					<td><input name='" . $method . $ranges_list[$i] . "_value' id='" . $method .
			$ranges_list[$i] . "_value' type='text' value='" . $ranges_value[$i] .
			"' style='width:150px;'></td>
					<td><select name='" . $method . $ranges_list[$i] . "_adjust' id='" . $method .
			$ranges_list[$i] . "_adjust' style='width:70px;'>" . $options . "</select></td>
					<td><input name='" . $method . "_price" . $ranges_list[$i] . "' id='" . $method .
			"_price" . $ranges_list[$i] . "' type='text' value='" . $ranges_price[$i] .
			"' style='width:50px;'></td>
					<td><input type='button' class='btn' value='" . pvs_word_lang( "delete" ) .
			"' style='width:70px' onClick=\"remove_range('" . $method . $ranges_list[$i] .
			"')\"></td>
				</tr>";
	}
	return $res;
}
?>


<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'products_options/index.php' ) );
?>" class="btn btn-primary btn-sm btn-mini"><b><i class="fa fa-arrow-left"></i>&nbsp; <?php
echo pvs_word_lang( "back" )
?></b></a></div>

<script language="javascript">
function publications_select_all(sel_form)
{
    if(sel_form.allrights.checked)
   	{
        $("input:checkbox", sel_form).attr("checked",true);
    }
    else
    {
        $("input:checkbox", sel_form).attr("checked",false);
    }
}







item_id=<?php
echo count( $ranges_list )
?>;
item_mass=new Array(
<?php
for ( $i = 0; $i < count( $ranges_list ); $i++ )
{
	if ( $i != 0 )
	{
		echo ( "," );
	}
	echo ( $ranges_list[$i] );
}
?>
);



function add_range(value)
{
	item_id++;
	item_mass[item_mass.length]=item_id;
	$("#ranges_"+value+" > tbody").append("<tr id='tr"+value+item_id+"'><td><input type='text' name='"+value+item_id+"_title'  id='"+value+item_id+"_title' value='New option' style='width:150px;'></td><td><input type='text' name='"+value+item_id+"_value'  id='"+value+item_id+"_value' value='' style='width:150px;'></td><td><select name='"+value+item_id+"_adjust' id='"+value+item_id+"_adjust' style='width:70px;'><option value='1' selected>+</option><option value='-1'>-</option></select></td><td><input type='text' name='"+value+"_price"+item_id+"' id='"+value+"_price"+item_id+"' value='0' style='width:50px;'></td><td><input type='button' class='btn' value='<?php
echo pvs_word_lang( "delete" )
?>' style='width:70px' onClick=\"remove_range('"+value+item_id+"')\"></td></tr>");
}

function remove_range(value)
{
	$('#tr'+value).remove();
}


</script>


<h1><?php
echo pvs_word_lang( "products options" )
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
echo pvs_word_lang( "Property ID" )
?>:</span>
		<input type="text" name="property_name" value="<?php
echo $user_fields["property_name"]
?>" style="width:350px">
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "description" )
?>:</span>
		<select name="description" style="width:350px">
			<option value="0"></option>
			<?php
$sql = "select ID, post_title from " . $table_prefix .
	"posts where post_type = 'page' and post_status = 'publish' order by post_title";
$ds->open( $sql );
while ( ! $ds->eof )
{
	$sel = "";
	if ( $ds->row["ID"] == $rs->row["page_id"] )
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
		</select>
	</div>
	

	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "type" )
?>:</span>
	<select name="type" style="width:150px">
		<option value="selectform" <?php
if ( $user_fields["type"] == "selectform" )
{
	echo ( "selected" );
}
?>>Select form</option>
		<option value="radio" <?php
if ( $user_fields["type"] == "radio" )
{
	echo ( "selected" );
}
?>>Radio buttons</option>
		<option value="colorpicker" <?php
if ( $user_fields["type"] == "colorpicker" )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "Color picker" )
?></option>
		<option value="colors" <?php
if ( $user_fields["type"] == "colors" )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "List of colors" )
?></option>
		<option value="frame" <?php
if ( $user_fields["type"] == "frame" )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "Frame" )
?></option>
		<option value="background" <?php
if ( $user_fields["type"] == "background" )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "Background" )
?></option>
	</select>
	</div>
	
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "enabled" )
?>:</span>
	<input type="checkbox" name="activ" <?php
if ( $user_fields["activ"] )
{
	echo ( "checked" );
}
?>>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "required" )
?>:</span>
	<input type="checkbox" name="required" <?php
if ( $user_fields["required"] )
{
	echo ( "checked" );
}
?>>
	</div>

</div>
	

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
	<div class='admin_field'>
		<table border="0" cellpadding="0" cellspacing="0" class="ranges" id="ranges_options">
			<tbody>
				<tr>
					<td style='width:150px;'><b><?php
echo pvs_word_lang( "title" )
?>*:</b></td>
					<td style='width:150px;'><b><?php
echo pvs_word_lang( "Value" )
?>**:</b></td>
					<td style='width:50px;'></td>
					<td style='width:70px;'><b><?php
echo pvs_word_lang( "price" )
?>:</b></td>
					<td></td>
				</tr>
				<?php
echo build_rangers( "options" )
?>
			</tbody>
		</table>
		<input type="button" value="<?php
echo pvs_word_lang( "add" )
?>" class="btn" onClick="add_range('options')">
	</div>
	
	<?php
if ( $user_fields["property_name"] == 'print_size' )
{
?>
		<div 	class='admin_field'>
			<p>* - Possible formats: 40cm or 19in. The second parameter will be calculated according to photo's proportion. For example: 40cm x 30cm or 16" x 9"</p>
			<p>** - Minimum photo's size (width or height) in pixels for a print. For example: if a photo is 3000x2000px and minimum is 4000 the print size will be unavailable for the image.</p>
		</div>
		<?php
}

if ( $user_fields["property_name"] == 'orientation_case' )
{
?>
		<div 	class='admin_field'>
			<p>* - Possible variants: Vertical, Horizontal Right, Horizontal Left. If you want to translate them you should add the values in the language file.</p>
		</div>
		<?php
}

if ( $user_fields["property_name"] == 'print_frame' )
{
?>
		<div 	class='admin_field'>
			<p>* - To add a new print's frame you should upload the file into the directory <b><?php
	echo pvs_plugins_url()
?>/includes/prints/images/</b>:<br>
			frameN.jpg - preview<br>
			frameN_top_right.jpg<br>
			frameN_top_left.jpg<br>
			frameN_top_center.jpg<br>
			frameN_center_right.jpg<br>
			frameN_center_left.jpg<br>
			frameN_bottom_right.jpg<br>
			frameN_bottom_left.jpg<br>
			frameN_bottom_center.jpg
			</p>
			<p>** - Frame size. Possible formats: 2cm or 1".</p>
		</div>
		<?php
}

if ( $user_fields["property_name"] == 'print_mounting' )
{
?>
		<div 	class='admin_field'>
			<p>* - Possible variants: Hanging Wire, Aluminum Mounting. If you want to translate them you should add the values in the language file.</p>
		</div>
		<?php
}

if ( $user_fields["property_name"] == 'tshirt_color' )
{
?>
		<div 	class='admin_field'>
			<p>* - To add a new t-shirt's color you should upload the file into the directory <b><?php
	echo pvs_plugins_url()
?>/includes/prints/images/</b>:<br>
			tshirt_color.png.
			</p>
		</div>
		<?php
}

if ( $user_fields["property_name"] == 'print_wrap' )
{
?>
		<div 	class='admin_field'>
			<p>* - Possible variants: No Wrap - Rolled In A Tube, White Sides, Black Sides, Mirrored Sides. If you want to translate them you should add the values in the language file.</p>
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
