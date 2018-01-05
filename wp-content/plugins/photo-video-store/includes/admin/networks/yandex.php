<?php
//Check access
pvs_admin_panel_access( "settings_networks" );
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}?>
<p>
To enable Yandex authorization you should do the next:
</p>
<p>
1) Add <b>a new application</b> here:<br>
<a href="https://oauth.yandex.ru/client/new">https://oauth.yandex.ru/client/new</a>
</p>



<p><b>Права: API Яндекс.Паспорта</b></p>
<ul>
<li>Доступ к адресу электронной почты</li>
<li>Доступ к дате рождения</li>
<li>Доступ к логину, имени и фамилии, полу</li>
<li>Доступ к портрету пользователя</li>
</ul>


<p><b>Callback URL:</b> <?php echo site_url();
?>/check-yandex/
</p>




<p>
2) Fill in the table:
</p>

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="title" value="yandex">
<input type="hidden" name="d" value="6">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='auth_yandex' value='1'  <?php
if ( $pvs_global_settings["auth_yandex"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Application ID:</span>
<input type='text' name='auth_yandex_key'  style="width:400px" value="<?php echo $pvs_global_settings["auth_yandex_key"] ?>">
</div>

<div class='admin_field'>
<span>Application secret:</span>
<input type='text' name='auth_yandex_secret'  style="width:400px" value="<?php echo $pvs_global_settings["auth_yandex_secret"] ?>">
</div>

<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>





