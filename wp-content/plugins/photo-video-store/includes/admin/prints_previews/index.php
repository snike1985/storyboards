<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printspreviews" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>


<h1><?php
echo pvs_word_lang( "Prints previews" )
?></h1>




<p>Dinamic prints previews are based on HTML+CSS and transparent *.png mockups.<br>You could edit print's templates into <b>/templates/prints/</b> directory.</p>
<form method="post">
	<input type="hidden" name="action" value="change">
<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "enabled" )
?>:</b></span>
	<input name="prints_previews" type="checkbox" value="1" <?php
if ( $pvs_global_settings["prints_previews"] == 1 )
{
	echo ( "checked" );
}
?>>
</div>
<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "Create big *.jpg thumbs for print's zoomer" )
?>:</b></span>
	<input name="prints_previews_thumb" type="checkbox" value="1" <?php
if ( @$pvs_global_settings["prints_previews_thumb"] == 1 )
{
	echo ( "checked" );
}
?>>
	<small> Check it only if you use a zoomer to resize a photo in the print's preview. The script has to generate the big thumbs first.</small>
</div>
<div class="form_field"> 
	<span><b><?php
echo pvs_word_lang( "Print's thumb's width" )
?> (px):</b></span>
	<input name="prints_previews_width" type="text" value="<?php
echo ( int )@$pvs_global_settings["prints_previews_width"]
?>" class="form-control" style="width:200px">
	<small>It should be more than photo's big thumb's width.</small>
</div>
<div class="form_field"> 
	<input type="submit" value="<?php
echo pvs_word_lang( "save" )
?>" class="btn btn-primary">
</div>
</form>




<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>