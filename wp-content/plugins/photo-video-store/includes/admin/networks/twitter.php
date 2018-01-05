<?php
//Check access
pvs_admin_panel_access( "settings_networks" );
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>





<p>
To enable Twitter authorization you should do the next:
</p>

<p>
1) Add <b>a new application</b> here:<br>
<a href="https://apps.twitter.com/">https://apps.twitter.com/</a>
</p>

<div class="list_steps">
<ul>

<li><b>Application Name:</b> Your site name
</li>


<li><b>Description:</b> Your site description
</li>

<li><b>Application Website:</b> <?php echo site_url()
?>
</li>


<li><b>Organization:</b> Your company name
</li>



<li><b>Callback URL:</b> <?php echo site_url()?>/check-twitter/
</li>

<li><b>Permission:</b> Read
</li>


</ul>
</div>



<p>
2) Click <b>Register application</b> and fill in the table:
</p>

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="title" value="twitter">
<input type="hidden" name="d" value="2">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='auth_twitter' value='1'  <?php
if ( $pvs_global_settings["auth_twitter"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Application ID:</span>
<input type='text' name='auth_twitter_key'  style="width:400px" value="<?php echo $pvs_global_settings["auth_twitter_key"] ?>">
</div>

<div class='admin_field'>
<span>Application secret:</span>
<input type='text' name='auth_twitter_secret'  style="width:400px" value="<?php echo $pvs_global_settings["auth_twitter_secret"] ?>">
</div>

<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>

