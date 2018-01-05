<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_tax" );

$user_fields = array();
$user_fields["title"] = "";
$user_fields["rates_depend"] = 1;
$user_fields["enabled"] = 1;
$user_fields["price_include"] = 1;
$user_fields["rate_all"] = 10;
$user_fields["rate_all_type"] = 1;
$user_fields["regions"] = 0;
$user_fields["files"] = 1;
$user_fields["credits"] = 1;
$user_fields["subscription"] = 1;
$user_fields["prints"] = 1;
$user_fields["customer"] = 0;

if ( isset( $_GET["id"] ) )
{
	$sql = "select * from " . PVS_DB_PREFIX . "tax where id=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		$user_fields["title"] = $rs->row["title"];
		$user_fields["rates_depend"] = $rs->row["rates_depend"];
		$user_fields["enabled"] = $rs->row["enabled"];
		$user_fields["price_include"] = $rs->row["price_include"];
		$user_fields["rate_all"] = $rs->row["rate_all"];
		$user_fields["rate_all_type"] = $rs->row["rate_all_type"];
		$user_fields["regions"] = $rs->row["regions"];
		$user_fields["files"] = $rs->row["files"];
		$user_fields["credits"] = $rs->row["credits"];
		$user_fields["subscription"] = $rs->row["subscription"];
		$user_fields["prints"] = $rs->row["prints"];
		$user_fields["customer"] = $rs->row["customer"];
	}
}
?>


<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'tax/index.php' ) );
?>" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php
echo pvs_word_lang( "back" )
?></a></div>

<script language="javascript">
function publications_select_all()
{
	$("#regions_list2 input:checkbox").each(function(){this.checked = !this.checked && !this.disabled;});
}

function change_regions(value)
{
	if(value==0)
	{
		document.getElementById('regions_list').style.display='none';
	}
	else
	{
		document.getElementById('regions_list').style.display='block';
	}
}



</script>


<h1><?php
echo pvs_word_lang( "taxes" )
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




<form method="post"  Enctype="multipart/form-data" name="shipping_form" onsubmit="return check();">
<input type="hidden" name="action" value="add">
<?php
if ( isset( $_REQUEST["id"] ) )
{
	echo ( '<input type="hidden" name="id" value="' . ( int )$_REQUEST["id"] . '">' );
}
?>
<div class="subheader"><?php
echo pvs_word_lang( "common information" )
?></div>
<div class="subheader_text">


	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "enabled" )
?>:</span>
	<input type="checkbox" name="enabled" <?php
if ( $user_fields["enabled"] )
{
	echo ( "checked" );
}
?>>
	</div>

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
echo pvs_word_lang( "rates depend on" )
?>:</span>
		<select name="rates_depend" style="width:170px">
			<option value="1" <?php
if ( $user_fields["rates_depend"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "shipping address" )
?></option>
			<option value="2" <?php
if ( $user_fields["rates_depend"] == 2 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "billing address" )
?></option>
		</select>
	</div>
	
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "customers" )
?>:</span>
		<select name="customer" style="width:170px">
			<option value="0" <?php
if ( $user_fields["customer"] == 0 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "all" )
?></option>
			<option value="1" <?php
if ( $user_fields["customer"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "business" )
?></option>
			<option value="2" <?php
if ( $user_fields["customer"] == 2 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "individual" )
?></option>
		</select>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "cost" )
?>:</span>
	<input name="rate_all" type="text" style="width:50px;display:inline" value="<?php
echo $user_fields["rate_all"]
?>">&nbsp;<select name="rate_all_type" style="width:60px;display:inline">
		<option value="1" <?php
if ( $user_fields["rate_all_type"] == 1 )
{
	echo ( "selected" );
}
?>>%</option>
		<option value="2" <?php
if ( $user_fields["rate_all_type"] == 2 )
{
	echo ( "selected" );
}
?>>$</option>
		</select>
	</div>
	

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "price includes tax" )
?>:</span>
	<input type="checkbox" name="price_include" <?php
if ( $user_fields["price_include"] )
{
	echo ( "checked" );
}
?>>
	</div>

	

	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "files" )
?>:</span>
	<input type="checkbox" name="files" <?php
if ( $user_fields["files"] )
{
	echo ( "checked" );
}
?>>
	</div>
	

	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "credits" )
?>:</span>
	<input type="checkbox" name="credits" <?php
if ( $user_fields["credits"] )
{
	echo ( "checked" );
}
?>>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "subscription" )
?>:</span>
	<input type="checkbox" name="subscription" <?php
if ( $user_fields["subscription"] )
{
	echo ( "checked" );
}
?>>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "prints" )
?>:</span>
	<input type="checkbox" name="prints" <?php
if ( $user_fields["prints"] )
{
	echo ( "checked" );
}
?>>
	</div>

</div>
	


<div class="subheader"><?php
echo pvs_word_lang( "regions" )
?></div>
<div class="subheader_text">
	<input type="radio" name="regions" value="0" <?php
if ( ! $user_fields["regions"] )
{
	echo ( "checked" );
}
?> onClick="change_regions(0)">&nbsp;<?php
echo pvs_word_lang( "everywhere" )
?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="regions" value="1" <?php
if ( $user_fields["regions"] )
{
	echo ( "checked" );
}
?> onClick="change_regions(1)">&nbsp;<?php
echo pvs_word_lang( "regions" )
?>
	
	<div id="regions_list" style="display:<?php
if ( ! $user_fields["regions"] )
{
	echo ( "none" );
} else
{
	echo ( "block" );
}
?>">
		<?php
$regions_activ = array();
if ( isset( $_GET["id"] ) )
{
	$sql = "select country,state from " . PVS_DB_PREFIX .
		"tax_regions where id_parent=" . ( int )$_GET["id"];
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$regions_activ[$rs->row["country"]][$rs->row["state"]] = 1;
		$rs->movenext();
	}
}

$j = 0;
?>
			<div><input  type="checkbox" id="selector" name="selector" value="1" onClick="publications_select_all();">&nbsp;&nbsp;<b><?php
echo pvs_word_lang( "select all" )
?></b></div><div id="regions_list2">
			<?php
$sql = "select name,id from " . PVS_DB_PREFIX .
	"countries where activ=1 order by priority,name";
$dd->open( $sql );
while ( ! $dd->eof )
{
	$sel = "";
	if ( isset( $regions_activ[$dd->row["name"]][''] ) )
	{
		$sel = "checked";
	}
?>
				<div><input name="country<?php
	echo $dd->row["id"]
?>" type="checkbox" <?php
	echo $sel
?>>&nbsp;&nbsp;<?php
	echo $dd->row["name"]
?></div>
				<?php
	if ( isset( $mstates[$dd->row["name"]] ) )
	{
		foreach ( $mstates[$dd->row["name"]] as $key => $value )
		{
			$sel = "";
			if ( isset( $regions_activ[$dd->row["name"]][$value] ) )
			{
				$sel = "checked";
			}
?>
						<div style="margin-left:20px"><input name="state<?php
			echo $j
?>" type="checkbox" <?php
			echo $sel
?>>&nbsp;&nbsp;<?php
			echo $value
?></div>
						<?php
			$j++;
		}
	}
	$dd->movenext();
}
?>
		</div>
	</div>
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
