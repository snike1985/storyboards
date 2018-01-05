<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );
?>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<p>
<b>Documentation:</b><br>
<a href="https://www.fotolia.com/Services/API/">https://www.fotolia.com/Services/API</a>
</p>


</div>
<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

	<form method="post">
	<input type="hidden" name="action" value="change_fotolia">


	
	<div class='admin_field'>
	<span>Fotolia API:</span>
	<input type="checkbox" name="fotolia_api" value="1" <?php
if ( $pvs_global_settings["fotolia_api"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span>Fotolia API Key:</span>
	<input type="text" name="fotolia_id" value="<?php
echo $pvs_global_settings["fotolia_id"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Your Fotolia ID:</span>
	<input type="text" name="fotolia_account" value="<?php
echo $pvs_global_settings["fotolia_account"]
?>" style="width:350px"><br>
	<small>To build a correct affiliate link.</small>
	</div>
	
	<div class='admin_field'>
	<span>Fotolia <?php
echo pvs_word_lang( "Contributor" )
?> ID:</span>
	<input type="text" name="fotolia_contributor" value="<?php
echo $pvs_global_settings["fotolia_contributor"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "keywords" )
?> (<?php
echo pvs_word_lang( "by default" )
?>):</span>
	<input type="text" name="fotolia_query" value="<?php
echo $pvs_global_settings["fotolia_query"]
?>" style="width:350px"><br>
	<small>It is required. Otherwise the default listing will be empty.</small>
	</div>
	
	<div class='admin_field'>
	<span>Fotolia <?php
echo pvs_word_lang( "categories" )
?>:</span>
	<select name="fotolia_category" style="width:350px">
		<option value="-1"></option>
		<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"category_stock where stock='fotolia' order by title";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sel = "";
	if ( $rs->row["id"] == $pvs_global_settings["fotolia_category"] )
	{
		$sel = "selected";
	}
?>
			<option value="<?php
	echo $rs->row["id"]
?>" <?php
	echo $sel
?>><?php
	echo $rs->row["title"]
?></option>
			<?php
	$rs->movenext();
}
?>
	</select>
	<a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=3&action=fotolia_categories" class="btn btn-default" style="margin-top:2px"><i class="fa fa-refresh"></i> <?php
echo pvs_word_lang( "refresh" )
?></a>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Create internal pages for files" )
?>:</span>
	<input type="checkbox" name="fotolia_pages" value="1" <?php
if ( $pvs_global_settings["fotolia_pages"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "files" )
?>:</span>
	<input type="checkbox" name="fotolia_files" value="1" <?php
if ( $pvs_global_settings["fotolia_files"] )
{
	echo ( "checked" );
}
?>><br>
	</div>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Prints on Demand" )
?>:</span>
	<input type="checkbox" name="fotolia_prints" value="1" <?php
if ( $pvs_global_settings["fotolia_prints"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "by default" )
?>:</span>
	<select name="fotolia_show" style="width:350px">
		<option value="1" <?php
if ( $pvs_global_settings["fotolia_show"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "files" )
?></option>
		<option value="2" <?php
if ( $pvs_global_settings["fotolia_show"] == 2 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "prints" )
?></option>
	</select>
	</div>


	
	<div class='admin_field'>
	<input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>

</div>
