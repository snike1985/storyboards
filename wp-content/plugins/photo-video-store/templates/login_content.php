<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<div id="login_content">
<table border="0" cellpadding="0" cellspacing="0" width="90%">
<tr valign="top">
<td style="width:50%">
	<div class='login_header'><h2><?php echo pvs_word_lang( "login" )?></h2></div>
	<form method='post' action='<?php echo (site_url( ) );?>/wp-login.php'>

	<div class="form_field">
	<span><?php echo pvs_word_lang( "user" )?>:</span>
	<input class='ibox form-control' type='text' name='log' style='width:100px;'>
	</div>
	
	<div class="form_field">
	<span><?php echo pvs_word_lang( "password" )?>:</span>
	<input class='ibox form-control' type='password' name='pwd' style='width:100px;'>
	</div>
	
	<div class="form_field">
	<input name="rememberme" type="checkbox" id="rememberme" value="forever"  /> <?php echo(pvs_word_lang("Remember me"));?>
	</div>
	
	<div class="form_field">
	<input class='isubmit' type='submit' value="<?php echo pvs_word_lang( "login" )?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo (pvs_get_page_url('forgot-password'));?>'><?php echo pvs_word_lang( "forgot password" )?>?</a>
	</div>
	
	</form>

	
	
	<div class='login_header' style="margin-top:30px"><h2><?php echo pvs_word_lang( "sign up" )?></h2></div>

	
	<div class="form_field">
	<input class='isubmit' type='button' onClick="location.href='<?php echo (pvs_get_page_url('signup'));?>'" value="<?php echo pvs_word_lang( "sign up" )?>">
	</div>
	
	
	
</td>
<td style="padding-left:30px;width:50%">
	<div class='login_header'><h2><?php echo pvs_word_lang( "login without signup" )?>:</h2></div>
	<?php echo pvs_get_social_networks();?>
	
	
	<?php
if ( $pvs_global_settings["site_guest"]) {
?>
	
		<script language="javascript">
 		function check_guest_email()
 		{
 			email=document.getElementById('guest_email').value;
			if(email.match (/^[0-9a-zA-Z\-_\.]+@[0-9a-zA-Z\-_\.]+\.[a-zA-Z]+$/))
			{
	return true;
			}
			else
			{
 	document.getElementById('guest_email').className = 'ibox_error';
 	document.getElementById('error_email').innerHTML = '<?php echo pvs_word_lang( "incorrect field" )?>';
 	return false;
 			}
 		}
 		
 		function pvs_show_captcha()
 		{
 			$("#captcha_box").slideDown("slow");
 		}
		</script>
		

		
		
		<div class='login_header' style="margin-top:30px"><h2><?php echo pvs_word_lang( "login as guest" )?></h2></div>
		
		<?php
		
	if ( isset( $_REQUEST["error"] ) ) {
		if ( $_REQUEST["error"] == "email" ) {
			echo ( "<p><b>" . pvs_word_lang( "Error. The email is already in use.") . "</b></p>" );
		}
		if ( $_REQUEST["error"] == "captcha" ) {
			echo ( "<p><b>" . pvs_word_lang( "Error. Incorrect Captcha.") . "</b></p>" );
		}
	}
?>
	
		<form method='post' action='<?php echo (site_url( ) );?>/check-guest/' onSubmit="return check_guest_email();">
	
		<div class="form_field">
		<span><?php echo pvs_word_lang( "e-mail" )?>:</span>
		<input class='ibox form-control' type='text' name='guest_email'  id='guest_email' style='width:150px;' onClick="pvs_show_captcha()" value=""><div id="error_email" class="error"></div>
		</div>
		<div class="form_field" <?php
	if ( ! isset( $_GET["error"] ) ) {
?>style="display:none"<?php
	}
?> id="captcha_box">
			<?php
	//Show captcha
	require_once ( PVS_PATH . 'includes/plugins/recaptcha/recaptchalib.php' );
	echo ( pvs_show_captcha() );?>
		</div>
	
		<div class="form_field">
		<input class='isubmit' type='submit' value='<?php echo pvs_word_lang( "OK" )?>'>
		</div>
	
		</form>
	<?php
}
?>
	
	
</td>
</tr>
</table>
</div>
