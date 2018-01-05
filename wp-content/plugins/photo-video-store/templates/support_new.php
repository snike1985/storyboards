<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>

<h1><?php echo pvs_word_lang( "open a support request" );?></h1>

<script>
	form_fields=new Array("subject","message");
	fields_emails=new Array(0,0);
	error_message="<?php echo pvs_word_lang( "Incorrect field" );?>";
</script>
<script src="<?php echo pvs_plugins_url();
?>/assets/jquery.qtip-1.0.0-rc3.min.js"></script>

<form method="post" action="<?php echo (site_url( ) );?>/support-add/" onSubmit="return my_form_validate();">

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "subject" );?>:</b></span>
	<input type="text" class="ibox form-control" style="width:300px" name="subject" id="subject" value="">
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "content" );?>:</b></span>
	<textarea class="ibox form-control" style="width:600px;height:250px" name="message" id="message"></textarea>
</div>



<div class="form_field">
	<input type="submit" class="isubmit" value="<?php echo pvs_word_lang( "send" );?>">
</div>
	
</form>


<?php
include ( "profile_bottom.php" );
?>