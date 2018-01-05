<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	$activ = 0;
	if ( isset( $_POST["activ"] ) )
	{
		$activ = 1;
	}
	
	pvs_update_setting('amazon', $activ);
	pvs_update_setting('amazon_prefix', pvs_result( $_POST["prefix"] ));
	pvs_update_setting('amazon_username', pvs_result( $_POST["username"] ));
	pvs_update_setting('amazon_api_key', pvs_result( $_POST["api_key"] ));
	pvs_update_setting('amazon_region', pvs_result( $_POST["region"] ));

	//Update settings
	pvs_get_settings();
}
?>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<p>
<a href="http://aws.amazon.com/s3/"><b>Amazon Simple Storage Service</b></a> provides a simple web services interface that can be used to store and retrieve any amount of data, at any time, from anywhere on the web.
</p>

<p>
All files are stored on the <b>local server first</b> and then they are moved<br> to the Amazon S3 <b>ONLY</b> by <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=5"><b>Cron script</b></a>. The files will not be moved on Amazon S3 if you don't run the cron script.
</p>

<p>The script creates in your Amazon S3 account <b>2 buckets:</b></p>

<p>
<b>[PREFIX]-files</b> - for the files.<br> 
<b>[PREFIX]-previews</b> - for the previews. 
</p>

<p>From time to time you can change the prefix to organize your file archive better. We recomment you to <b>test the process every time</b> when you change prefix name.</p>

<p>
You should check the <b>php.ini settings</b>:<br>
allow_url_fopen = On<br>
ignore_user_abort = On
</p>

</div>


<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

<form method="post">
<input type="hidden" name="action" value="change">
<div class='admin_field'>
<span>Amazon S3:</span>
<input type='checkbox' name='activ'   <?php
if ( $pvs_global_settings["amazon"] == 1 )
{
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Bucket's name prexif:</span>
<input type='text' name='prefix'  style="width:400px" value="<?php
echo $pvs_global_settings["amazon_prefix"]
?>">
</div>

<div class='admin_field'>
<span>Access Key ID:</span>
<input type='text' name='username'  style="width:400px" value="<?php
echo $pvs_global_settings["amazon_username"]
?>">
</div>

<div class='admin_field'>
<span>Secret Access Key:</span>
<input type='text' name='api_key'  style="width:400px" value="<?php
echo $pvs_global_settings["amazon_api_key"]
?>">
</div>

<div class='admin_field'>
<span>Region:</span>
<select name='region'  style="width:200px">
<?php
foreach ( $amazon_region as $key => $value )
{
	$sel = "";
	if ( $key == $pvs_global_settings["amazon_region"] )
	{
		$sel = "selected";
	}
?>
	<option value="<?php
	echo $key
?>" <?php
	echo $sel
?>><?php
	echo $value
?></option>
	<?php
}
?>
</select>
</div>



<div class='admin_field'>
<p><input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>"></p>
</div>

</form>

</div>
<div class="subheader">Test</div>
<div class="subheader_text">

<p>The script will upload <a href="<?php
echo ( pvs_plugins_url() . '/includes/admin/includes/img/' );
?>test.jpg">the file</a> on Amazon S3.</p>


<p>
<a class="button button-primary button-large" href="javascript:pvs_amazon_test()"><i class="icon-picture icon-arrow-right icon-white fa fa-upload"></i> Test Amazon S3 Now"</a>
</p>
<div id="amazon_result" class="card" style="display:none">

</div>




	<script>
	function pvs_amazon_test() 
	{
		jQuery.ajax({
			type:'POST',
			url:ajaxurl,
			data:'action=pvs_amazon_test',
			success:function(data){
				if(data.charAt(data.length-1) == '0')
				{
					data = data.substring(0,data.length-1)
				}
				$('#amazon_result').html(data);
				$('#amazon_result').css("display","block");
			}
		});
	}
	</script>
</div>

