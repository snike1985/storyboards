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
<a href="https://developers.shutterstock.com/">developers.shutterstock.com</a>
</p>

</div>
<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

	<form method="post">
	<input type="hidden" name="action" value="change_shutterstock">

	
	<div class='admin_field'>
	<span>Shutterstock API:</span>
	<input type="checkbox" name="shutterstock_api" value="1" <?php
if ( $pvs_global_settings["shutterstock_api"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span>Client ID:</span>
	<input type="text" name="shutterstock_id" value="<?php
echo $pvs_global_settings["shutterstock_id"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Client Secret:</span>
	<input type="text" name="shutterstock_secret" value="<?php
echo $pvs_global_settings["shutterstock_secret"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Affiliate URL:</span>
	<input type="text" name="shutterstock_affiliate" value="<?php
echo $pvs_global_settings["shutterstock_affiliate"]
?>" style="width:350px"><br>
	<small>Shutterstock uses Impact Radius affiliate program. You will get an affiliate link like that:<br>http://shutterstock.7eer.net/c/202194/42119/1305<br>You have to set it as Affiliate URL</small>
	</div>
	
	<div class='admin_field'>
	<span>Shutterstock <?php
echo pvs_word_lang( "Contributor" )
?>:</span>
	<input type="text" name="shutterstock_contributor" value="<?php
echo $pvs_global_settings["shutterstock_contributor"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Shutterstock <?php
echo pvs_word_lang( "categories" )
?>:</span>
	<select name="shutterstock_category" style="width:350px">
		<option value="-1"></option>
		<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"category_stock where stock='shutterstock' order by title";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sel = "";
	if ( $rs->row["id"] == $pvs_global_settings["shutterstock_category"] )
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
?>&d=2&action=shutterstock_categories" class="btn btn-default" style="margin-top:2px"><i class="fa fa-refresh"></i> <?php
echo pvs_word_lang( "refresh" )
?></a>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Create internal pages for files" )
?>:</span>
	<input type="checkbox" name="shutterstock_pages" value="1" <?php
if ( $pvs_global_settings["shutterstock_pages"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "files" )
?>:</span>
	<input type="checkbox" name="shutterstock_files" value="1" <?php
if ( $pvs_global_settings["shutterstock_files"] )
{
	echo ( "checked" );
}
?>><br>
	</div>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Prints on Demand" )
?>:</span>
	<input type="checkbox" name="shutterstock_prints" value="1" <?php
if ( $pvs_global_settings["shutterstock_prints"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "by default" )
?>:</span>
	<select name="shutterstock_show" style="width:350px">
		<option value="1" <?php
if ( $pvs_global_settings["shutterstock_show"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "files" )
?></option>
		<option value="2" <?php
if ( $pvs_global_settings["shutterstock_show"] == 2 )
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
