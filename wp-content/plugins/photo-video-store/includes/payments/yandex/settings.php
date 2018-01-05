<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_payments" );

if ( @$_REQUEST["action"] == 'change' )
{
	pvs_update_setting('yandex_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('yandex_account2', pvs_result( $_POST["account2"] ));
	pvs_update_setting('yandex_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('yandex_active', (int) @ $_POST["active"] );
	pvs_update_setting('yandex_test', (int) @ $_POST["test"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://money.yandex.ru"><b>Yandex.money</b></a> is Russian payments provider.</p>

<p>Вам нужно зарегистрироваться на  сайте <a href="https://kassa.yandex.ru/">kassa.yandex.ru</a> и пройти процедуру проверки.</p>


<p>Настроить:</p>
<ul>

<li>
	<b>Способ подключения к кассе:</b>
	<br>HTTP-протокол
</li>

<li>
	<b>checkURL и avisoURL:</b>
	<?php echo (site_url( ) );?>/payment-notification/?payment=yandex
</li>



<li>
	<b>Success URL:</b>
	<br><?php echo (site_url( ) );?>/payment-success/
</li>

<li>
	<b>Fail URL:</b>
	<br><?php echo (site_url( ) );?>/payment-fail/
</li>
</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Идентификатор контрагента (Shop ID):</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["yandex_account"] ?>">
</div>

<div class='admin_field'>
<span>Номер витрины контрагента:</span>
<input type='text' name='account2'  style="width:400px" value="<?php echo $pvs_global_settings["yandex_account2"] ?>">
</div>

<div class='admin_field'>
<span>Пароль магазина:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["yandex_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["yandex_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span>Режим тестирования:</span>
<input type='checkbox' name='test' value="1" <?php
	if ( $pvs_global_settings["yandex_test"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>