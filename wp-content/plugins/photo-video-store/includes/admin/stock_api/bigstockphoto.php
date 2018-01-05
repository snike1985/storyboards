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
<a href="https://www.bigstockphoto.com/partners/">https://www.bigstockphoto.com/partners/</a>
</p>

</div>
<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

	<form method="post">
	<input type="hidden" name="action" value="change_bigstockphoto">


	
	<div class='admin_field'>
	<span>Bigstockphoto API:</span>
	<input type="checkbox" name="bigstockphoto_api" value="1" <?php
if ( $pvs_global_settings["bigstockphoto_api"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span>API Account ID:</span>
	<input type="text" name="bigstockphoto_id" value="<?php
echo $pvs_global_settings["bigstockphoto_id"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Affiliate URL:</span>
	<input type="text" name="bigstockphoto_affiliate" value="<?php
echo $pvs_global_settings["bigstockphoto_affiliate"]
?>" style="width:650px"><br>
	<small>You can use the syntax in the affiliate link:<br>{URL} - URL of the publication page on bigstockphoto. You redirect visitors to the URL with your affiliate link.<br>{URL_ENCODED} - encoded publication URL<br>{ID} - publication ID on bigstockphoto.<br><br>
	<b>Example:</b> Bigstockphoto uses Impact Radius affiliate program. You will get an affiliate link like that:<br> http://bigstock.7eer.net/c/202194/42119/1305</br> You should set Affiliate URL:<br>
	http://bigstock.7eer.net/c/202194/42119/1305?u={URL_ENCODED}
	</small>
	</div>
	
	<div class='admin_field'>
	<span>Bigstockphoto <?php
echo pvs_word_lang( "Contributor" )
?>:</span>
	<input type="text" name="bigstockphoto_contributor" value="<?php
echo $pvs_global_settings["bigstockphoto_contributor"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<span>Bigstockphoto <?php
echo pvs_word_lang( "categories" )
?>:</span>
	<select name="bigstockphoto_category" style="width:350px">
		<option value="-1"></option>
		<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"category_stock where stock='bigstockphoto' order by title";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sel = "";
	if ( $rs->row["title"] == $pvs_global_settings["bigstockphoto_category"] )
	{
		$sel = "selected";
	}
?>
			<option value="<?php
	echo $rs->row["title"]
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
?>&d=6&action=bigstockphoto_categories" class="btn btn-default" style="margin-top:2px"><i class="fa fa-refresh"></i> <?php
echo pvs_word_lang( "refresh" )
?></a>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Create internal pages for files" )
?>:</span>
	<input type="checkbox" name="bigstockphoto_pages" value="1" <?php
if ( $pvs_global_settings["bigstockphoto_pages"] )
{
	echo ( "checked" );
}
?>><br>
	</div>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "files" )
?>:</span>
	<input type="checkbox" name="bigstockphoto_files" value="1" <?php
if ( $pvs_global_settings["bigstockphoto_files"] )
{
	echo ( "checked" );
}
?>><br>
	</div>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Prints on Demand" )
?>:</span>
	<input type="checkbox" name="bigstockphoto_prints" value="1" <?php
if ( $pvs_global_settings["bigstockphoto_prints"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "by default" )
?>:</span>
	<select name="bigstockphoto_show" style="width:350px">
		<option value="1" <?php
if ( $pvs_global_settings["bigstockphoto_show"] == 1 )
{
	echo ( "selected" );
}
?>><?php
echo pvs_word_lang( "files" )
?></option>
		<option value="2" <?php
if ( $pvs_global_settings["bigstockphoto_show"] == 2 )
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
