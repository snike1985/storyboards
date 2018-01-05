<?php
//Check access
pvs_admin_panel_access( "settings_networks" );
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>

<p>
To enable Facebook authorization:
</p>
<p>
1) You should add <b>a new application "Facebook login"</b> here:<br>
<a href="https://developers.facebook.com/apps/">https://developers.facebook.com/apps/</a>
</p>


<p>
2) Set the correct site URL:<br>
<b><?php echo site_url()
?></b>

</p>

<p>
3) And copy the application's keys in the form below:
</p>

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="title" value="facebook">
<input type="hidden" name="d" value="1">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='auth_facebook' value='1'  <?php
if ( $pvs_global_settings["auth_facebook"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Application ID:</span>
<input type='text' name='auth_facebook_key'  style="width:400px" value="<?php echo $pvs_global_settings["auth_facebook_key"] ?>">
</div>

<div class='admin_field'>
<span>Application secret:</span>
<input type='text' name='auth_facebook_secret'  style="width:400px" value="<?php echo $pvs_global_settings["auth_facebook_secret"] ?>">
</div>

<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>





