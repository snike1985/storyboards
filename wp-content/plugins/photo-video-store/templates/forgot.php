<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>

<div class="page_internal">
<h1><?php echo pvs_word_lang( "forgot password" )?>:</h1>




<form method="POST" action="http://wpstore:8888/wp-login.php?action=lostpassword">

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "e-mail" )?>:</b></span>
	<input type="text" name="user_login" id="email" class="ibox form-control" value="" style="width:250px">
</div>

<div class="form_field">
	<input type="submit" value="<?php echo pvs_word_lang( "send" )?>"  class='isubmit'>
</div>

</form>

</div>