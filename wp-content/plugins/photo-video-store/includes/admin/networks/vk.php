<?php
//Check access
pvs_admin_panel_access( "settings_networks" );
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>
<p>
To enable Vkontakte authorization you should do the next:
</p>
<p>
1) Add <b>a new application</b> here:<br>
<a href="http://vk.com/editapp?act=create">http://vk.com/editapp?act=create</a>
</p>




<ul>
<li><b>Type of application:</b> Web-site</li>
<li><b>Open API - Site URL:</b> <?php echo site_url()
?></li>



<li><b>Open API - Site Domain:</b> <?php echo str_replace( "http://", "", site_url() )?>
</li>

</ul>


<p>
2) Fill in the table:
</p>

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="title" value="vkontakte">
<input type="hidden" name="d" value="3">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='auth_vkontakte' value='1'  <?php
if ( $pvs_global_settings["auth_vkontakte"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Application ID:</span>
<input type='text' name='auth_vkontakte_key'  style="width:400px" value="<?php echo $pvs_global_settings["auth_vkontakte_key"] ?>">
</div>

<div class='admin_field'>
<span>Application secret:</span>
<input type='text' name='auth_vkontakte_secret'  style="width:400px" value="<?php echo $pvs_global_settings["auth_vkontakte_secret"] ?>">
</div>

<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>





