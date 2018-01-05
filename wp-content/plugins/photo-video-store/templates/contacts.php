<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<div class="page_internal">
<h1><?php echo pvs_word_lang( "contacts" );?>:</h1>

<?php

//Send
if ( @$_REQUEST["action"] == 'send' )
{
	//Check captcha
	require_once ( PVS_PATH . 'includes/plugins/recaptcha/recaptchalib.php' );
	$flag = pvs_check_captcha();
	
	if ( $flag ) {
		$sql = "insert into " . PVS_DB_PREFIX .
			"support (name,email,telephone,method,question,data) values ('" . pvs_result( $_POST["name"] ) .
			"','" . pvs_result( $_POST["email"] ) . "','" . pvs_result( $_POST["telephone"] ) .
			"','" . pvs_result( $_POST["method"] ) . "','" . pvs_result( $_POST["question"] ) .
			"'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
			date( "Y" ) ) . ")";
		$db->execute( $sql );
	
		pvs_send_notification( 'contacts_to_admin' );
		pvs_send_notification( 'contacts_to_user' );

		echo ("<p><b>" . pvs_word_lang( "sent" ) . "</b></p>");
	} else
	{
		echo ( pvs_word_lang( "<p><b>Error. Incorrect captcha.</b></p>" ) );
	}
} else {


?>



<script>
	form_fields=new Array("name","email","question","rn1");
	fields_emails=new Array(0,1,0,0);
	error_message="<?php echo pvs_word_lang( "Incorrect field" );?>";
</script>
<script src="<?php echo pvs_plugins_url();
?>/assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<?php
if ( isset( $_GET["d"] ) ) {
	echo ( pvs_word_lang( "<p><b>Error. Incorrect captcha.</b></p>" ) );
}

$question = "";
if ( isset( $_GET["file_id"] ) ) {
	$question = pvs_word_lang( "I would like to purchase the file" ) . " #" . ( int )
		$_GET["file_id"];
}
?>


<form method="post" action="<?php echo (site_url( ) );?>/contacts/" onSubmit="return my_form_validate();">
<input type="hidden" name="action" value="send">
<div class="form_field">
<span><b><?php echo pvs_word_lang( "full name" );?></b></span>
<input type="text" name="name" id="name" class="ibox form-control" value="" style="width:250px">
</div>

<div class="form_field">
<span><b><?php echo pvs_word_lang( "e-mail" );?></b></span>
<input type="text" name="email" id="email" class="ibox form-control" style="width:250px" value="">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "telephone" );?>:</span>
<input type="text" name="telephone" class="ibox form-control" style="width:250px">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "contact method" );?>:</span>
<select name="method" class="ibox form-control" style="width:250px"><option value="by e-mail""><?php echo pvs_word_lang( "by e-mail" );?><option value="by phone""><?php echo pvs_word_lang( "by phone" );?></select>
</div>

<div class="form_field">
<span><b><?php echo pvs_word_lang( "question" );?>:</b></span>
<textarea name="question" id="question" class="ibox form-control" style="width:500px;height:150px"><?php echo $question;
?></textarea>
</div>


<div class="form_field">
<?php
//Show captcha
require_once ( PVS_PATH . 'includes/plugins/recaptcha/recaptchalib.php' );
echo ( pvs_show_captcha() );?>
</div>

<div class="form_field">
<input type="submit" value="<?php echo pvs_word_lang( "send" );?>" class="isubmit">
</div>

</form>
<?php }?>

</div>
