<?php
//Check access
pvs_admin_panel_access( "settings_networks" );
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>
<p>
To enable google authorization you should do the next:
</p>
<p>
1) Add <b>a new application</b> here: API Access -> OAuth 2.0<br>
<a href="https://code.google.com/apis/console/">https://code.google.com/apis/console/</a>
</p>



<p><b>Callback URL:</b> <?php echo site_url();
?>/check-google/
</p>


<p>
2) Fill in the table:
</p>

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="title" value="google">
<input type="hidden" name="d" value="5">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='auth_google' value='1'  <?php
if ( $pvs_global_settings["auth_google"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Application ID:</span>
<input type='text' name='auth_google_key'  style="width:400px" value="<?php echo $pvs_global_settings["auth_google_key"] ?>">
</div>

<div class='admin_field'>
<span>Application secret:</span>
<input type='text' name='auth_google_secret'  style="width:400px" value="<?php echo $pvs_global_settings["auth_google_secret"] ?>">
</div>

<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>





