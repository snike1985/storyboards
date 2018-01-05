<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printful" );
?>


<script language="javascript">
function publications_select_all(sel_form)
{
    if(sel_form.selector.checked)
   	{
        $("input:checkbox", sel_form).attr("checked",true);
    }
    else
    {
        $("input:checkbox", sel_form).attr("checked",false);
    }
}
</script>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">
<a href="https://www.theprintful.com"><b>Printful</b></a> print custom t-shirts, posters, canvas and other print products and send them to your customers.


</div>

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">


<form method="post">
<input type="hidden" name="action" value="change">

	<div class='admin_field'>
	<span>Printful API key:</span>
	<input type="text" name="printful_api" value="<?php
echo $pvs_global_settings["printful_api"]
?>" style="width:350px">
	</div>
	
	<div class='admin_field'>
	<span>Order ID:</span>
	<input type="text" name="printful_order_id" value="<?php
echo $pvs_global_settings["printful_order_id"]
?>" style="width:50px">
	<div class="smalltext">Starting with this ID the orders will be sent to Printful.</div>
	</div>
	
	<div class='admin_field'>
	<span>Mode:</span>
	<select name="printful_mode"  style="width:350px">
		<option value="noconfirm" <?php
if ( $pvs_global_settings["printful_mode"] == "noconfirm" )
{
	echo ( "selected" );
}
?>>Place order without confirmation (test mode)</option>
		<option value="confirm" <?php
if ( $pvs_global_settings["printful_mode"] == "confirm" )
{
	echo ( "selected" );
}
?>>Place order with confirmation (live mode)</option>
	</select>

	</div>
	
	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>
</form>

</div>





<div class="subheader"><?php
echo pvs_word_lang( "prints" )
?></div>
<div class="subheader_text">

<p>First you should associate <b>your prints products</b> with <b><a href="https://www.theprintful.com/products" target="blank">Printful Product IDs</a></b>.</p>



<p><b>Select product:</b></p>
<p><select style="width:300px" onChange="location.href='<?php
echo ( pvs_plugins_admin_url( 'prints_printful/index.php' ) );
?>&d=1&print_id='+this.value">
<option></option>
<?php
$sql = "select id_parent,title from " . PVS_DB_PREFIX .
	"prints order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sel = "";
	if ( @$_GET["print_id"] == $rs->row["id_parent"] )
	{
		$sel = "selected";
	}
?>
	<option value="<?php
	echo $rs->row["id_parent"]
?>" <?php
	echo $sel
?>><?php
	echo $rs->row["title"]
?></option>
	<?php
	$rs->movenext();
}
?>
</select></p>

<?php
if ( isset( $_GET["print_id"] ) )
{
	$sql = "select option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
		PVS_DB_PREFIX . "prints where id_parent=" . ( int )$_GET["print_id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
?>
		<form method="post"  id="adminform" name="adminform">
		<input type="hidden" name="action" value="change_prints">
		<input type="hidden" name="print_id" value="<?php
		echo ( int )$_GET["print_id"]
?>">
		<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
		<?php
		for ( $i = 1; $i < 11; $i++ )
		{
			if ( $rs->row["option" . $i] != 0 )
			{
				$sql = "select * from " . PVS_DB_PREFIX . "products_options where id=" . $rs->
					row["option" . $i];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					$sql = "select * from " . PVS_DB_PREFIX .
						"products_options_items where id_parent=" . $rs->row["option" . $i];
					$dr->open( $sql );
					while ( ! $dr->eof )
					{
						$print_values[] = $dr->row["title"];
						$dr->movenext();
					}

					$print_properties[$i . "_" . $rs->row["option" . $i]] = $print_values;
					unset( $print_values );
?>
					<th><?php
					echo $ds->row["title"]
?></th>
					<?php
				}
			}
		}
		//var_dump($print_properties);

?>
		<th>Printful ID</th>
		<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"> <?php
		echo pvs_word_lang( "delete" )
?></th>
		</tr>
		</thead>
		<tr>
		<?php
		foreach ( $print_properties as $key => $value )
		{
?>
				<td>
				<select name="newoption<?php
			echo $key
?>" class="ibox form-control" style="width:100px">
				<option value="0"></option>
				<?php
			foreach ( $value as $key2 => $value2 )
			{
?>
					<option value="<?php
				echo $value2
?>"><?php
				echo $value2
?></option>
					<?php
			}
?>
				</select>
				</td>
				<?php
		}
?>
		<td><input type="text" name="newprintful_id" value="0" class="ibox form-control" style="width:100px"></td>
		<td style="text-align:center"><?php
		echo pvs_word_lang( "new" )
?></td>
		</tr>
		<?php
		$sql = "select * from " . PVS_DB_PREFIX . "printful_prints where print_id=" . ( int )
			$_GET["print_id"] . " order by id";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
?>
			<tr>
			<?php
			foreach ( $print_properties as $key => $value )
			{
?>
				<td>
				<select name="option<?php
				echo $key
?>_<?php
				echo $ds->row["id"]
?>" class="ibox form-control" style="width:100px">
				<option value="0"></option>
				<?php
				foreach ( $value as $key2 => $value2 )
				{
					$sel = "";
					$ii = explode( "_", $key );
					if ( $value2 == @$ds->row["option" . $ii[0] . "_value"] )
					{
						$sel = "selected";
					}
?>
					<option value="<?php
					echo $value2
?>" <?php
					echo $sel
?>><?php
					echo $value2
?></option>
					<?php
				}
?>
				</select>
				</td>
				<?php
			}
?>
			
			<td><input type="text" name="printful_id<?php
			echo $ds->row["id"]
?>" value="<?php
			echo $ds->row["printful_id"]
?>" class="ibox form-control" style="width:100px"></td>
			<td style="text-align:center"><input type="checkbox" name="delete<?php
			echo $ds->row["id"]
?>" value="1"></td>
			</tr>
			<?php
			$ds->movenext();
		}
?>
		</table>
		<input type="submit" class="btn btn-primary" value="<?php
		echo pvs_word_lang( "save" )
?>" style="margin:10px 0px 20px 6px">
		</form>
		<?php
	}
}
?>

</div>