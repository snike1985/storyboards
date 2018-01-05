<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( pvs_get_user_type () == "" ) {
	s ?>
<h1><?php echo pvs_word_lang( "member area" );?></h1>

<p>You logged in for the first time. You should select who you are:</p>

<?php
	if ( @$_REQUEST["d"] == 1 ) {
		echo ( "<p><b>" . pvs_word_lang( "Error. The username already exists." ) . "</b></p>" );
	}
?>

<form method="post" action="<?php echo (site_url( ) );?>/profile-type-change/">

<?php
	if ( preg_match( "/^fb/i", pvs_get_user_login () ) ) {
?>
<div class="form_field">
	<span><?php echo ( pvs_word_lang( "login" ) );?>:</span>
	<input type="text" class="form-control" name="login" value="<?php echo ( pvs_get_user_login () );?>" style="width:200px">
</div>
<?php
	}
?>

<div class="form_field">
	<span><?php echo ( pvs_word_lang( "type" ) );?>:</span>
	<select  class="form-control" name="utype" style="width:200px">
		<option value="buyer" selected><?php echo pvs_word_lang( "buyer" );?></option>
		<?php
	if ( $pvs_global_settings["userupload"] == 1 ) {
?>
			<option value="seller"><?php echo pvs_word_lang( "seller" );?></option>
		<?php
	}
?>
		<?php
	if ( $pvs_global_settings["affiliates"] ) {
?>
			<option value="affiliate"><?php echo pvs_word_lang( "affiliate" );?></option>
		<?php
	}
?>
		<?php
	if ( $pvs_global_settings["common_account"] ) {
?>
			<option value="common"><?php echo pvs_word_lang( "common" );?></option>
		<?php
	}
?>
	</select>
</div>

<input type="submit" class="isubmit" value="<?php echo ( pvs_word_lang( "save" ) );?>">
</form>

<?php
	?>
<?php
}
?>















