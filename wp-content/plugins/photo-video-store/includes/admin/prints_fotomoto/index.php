<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_fotomoto" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	pvs_update_setting('fotomoto_id', pvs_result( $_POST["fotomoto_id"] ));

	//Update settings
	pvs_get_settings();
}
?>






<h1><?php
echo pvs_word_lang( "Fotomoto prints service" )
?></h1>

<div class="box box_padding">

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">

<p><a href="http://www.fotomoto.com/">Fotomoto</a> is a print-on-demand e-commerce widget that integrates seamlessly into your existing website. Just add our code to your site, sit back, and start making money.</p>

<form method="post">
	<input type="hidden" name="action" value="change">

	<div class='admin_field'>
	<span>Fotomoto Store ID:</span>
	<input type="text" name="fotomoto_id" value="<?php
echo $pvs_global_settings["fotomoto_id"]
?>" style="width:350px"><br>
	</div>
	
	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>
</form>

</div>

<div class="subheader">How to integrate it</div>
<div class="subheader_text">

	<p>It is very simple. You should register your store at <a href="http://www.fotomoto.com/">fotomoto.com</a>, set the store ID and add <b>{FOTOMOTO}</b> code somewhere in the template on ftp:<br>
	
	<b>item_photo.tpl</b></p>

</div>

</div>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>