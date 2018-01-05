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
	pvs_update_setting('ccbill_account', pvs_result( $_POST["ccbill_account"] ));
	pvs_update_setting('ccbill_subaccount', pvs_result( $_POST["ccbill_subaccount"] ));
	pvs_update_setting('ccbill_password', pvs_result( $_POST["ccbill_password"] ));
	pvs_update_setting('ccbill_form', pvs_result( $_POST["ccbill_form"] ));
	pvs_update_setting('ccbill_active', (int) @ $_POST["ccbill_active"] );
	pvs_update_setting('ccbill_flexform', (int) @ $_POST["ccbill_flexform"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<ul>

<li>At <b>ccBill merchant account</b> (<a href="https://webadmin.ccbill.com/">https://webadmin.ccbill.com/</a>) go to <b>QuickLinks -> Account Setup -> Account Admin</b></li>


<li>Choose an existing <b>Subaccount</b>, or create new one.</li>


<li>Create a new <b>Form</b> with <b>Dinamic pricing</b></li>


<li>Go to <b>Modify Subaccount -> Advanced</b> and set:<br> 
    <b>Approval Post URL:</b><br>
     <a href="<?php echo site_url( )?>/payment-notification/?payment=ccbill"><?php echo site_url( )?>/payment-notification/?payment=ccbill</a><br>
    <b>Denial Post URL:</b><br>
     <a href="<?php echo site_url( )?>/payment-fail/"><?php echo site_url( )?>/payment-fail/</a></li>


</ul>
<br>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Account number:</span>
<input type='text' name='ccbill_account'  style="width:400px" value="<?php echo $pvs_global_settings["ccbill_account"] ?>">
</div>

<div class='admin_field'>
<span>Subaccount number:</span>
<input type='text' name='ccbill_subaccount'  style="width:400px" value="<?php echo $pvs_global_settings["ccbill_subaccount"] ?>">
</div>

<div class='admin_field'>
<span>Form ID:</span>
<input type='text' name='ccbill_form'  style="width:400px" value="<?php echo $pvs_global_settings["ccbill_form"] ?>">
</div>

<div class='admin_field'>
<span>Salt/Encription Key:</span>
<input type='text' name='ccbill_password'  style="width:400px" value="<?php echo $pvs_global_settings["ccbill_password"] ?>">
</div>

<div class='admin_field'>
<span>Flex form:</span>
<input type='checkbox' name='ccbill_flexform' value="1" <?php
if ( $pvs_global_settings["ccbill_flexform"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>


<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='ccbill_active' value="1" <?php
if ( $pvs_global_settings["ccbill_active"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>