<?php
//Check access
pvs_admin_panel_access( "settings_networks" );
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>

<p>
1) To enable instagram authorization you should  add <b>a new application</b> here:<br>
<a href="http://instagram.com/developer/#">http://instagram.com/developer/</a>
</p>


<ul>

<li><b>Website:</b> <?php echo site_url()
?>
</li>


<li><b>Valid redirect URIs:</b> <?php echo site_url()
?>/check-instagram/
</li>

</ul>

</p>

<p>
2) Fill in the table:
</p>

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="title" value="instagram">
<input type="hidden" name="d" value="4">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='auth_instagram' value='1'  <?php
if ( $pvs_global_settings["auth_instagram"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Application ID:</span>
<input type='text' name='auth_instagram_key'  style="width:400px" value="<?php echo $pvs_global_settings["auth_instagram_key"] ?>">
</div>

<div class='admin_field'>
<span>Application secret:</span>
<input type='text' name='auth_instagram_secret'  style="width:400px" value="<?php echo $pvs_global_settings["auth_instagram_secret"] ?>">
</div>

<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>





