<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );
?>

<?php
foreach ( $_POST as $key => $value ) {
	if ( preg_match( "/billing/", $key ) ) {
		$_SESSION[$key] = $value;
	}
}
?>


<h1><?php echo pvs_word_lang( "buy " . pvs_result( $_SESSION["billing_type"] ) )?></h1>

<div class="login_header">

<div style="float:right;">[ <a href="<?php echo (site_url( ) );?>/<?php echo pvs_result( $_SESSION["billing_type"] )?>/?d=1"><?php echo pvs_word_lang( "change" )?></a> ]</div>	

<h2 style="margin-top:30px"><?php echo pvs_word_lang( "order" )?></h2></div>

<?php
include ( "billing_content.php" );?>
	
	
<div class="login_header">
<h2 style="margin-top:30px"><?php echo pvs_word_lang( "select payment method" )?></h2>
</div>

<form method="post" action="<?php echo (site_url( ) );?>/billing-confirm/">

<?php
if ( $_SESSION["billing_type"] == "credits" ) {
?>
<input type="hidden" name="credits" value="<?php echo $_SESSION["billing_id"] ?>">
<?php
}
?>
<?php
if ( $_SESSION["billing_type"] == "subscription" ) {
?>
<input type="hidden" name="subscription" value="<?php echo $_SESSION["billing_id"] ?>">
<?php
}
?>


<script>
	function show_additional_fields(x) {
		<?php
if ( $pvs_global_settings["qiwi_account"] != "" ) {
?>
			if(x=="qiwi")
			{
	$("#qiwi_telephone").slideDown("slow");
			}
			else
			{
	$("#qiwi_telephone").slideUp("slow");
			}
		<?php
}
?>
		<?php
if ( $pvs_global_settings["yandex_account"] != "" ) {
?>
			if(x=="yandex")
			{
	$("#yandex_payments").slideDown("slow");
			}
			else
			{
	$("#yandex_payments").slideUp("slow");
			}
		<?php
}
?>
		<?php
if ( $pvs_global_settings["targetpay_account"] != "" ) {
?>
			if(x=="targetpay")
			{
	$("#targetpay_banks").slideDown("slow");
			}
			else
			{
	$("#targetpay_banks").slideUp("slow");
			}
		<?php
}
?>
		<?php
if ( $pvs_global_settings["moneyua_account"] != "" ) {
?>
			if(x=="moneyua")
			{
	$("#moneyua_method").slideDown("slow");
			}
			else
			{
	$("#moneyua_method").slideUp("slow");
			}
		<?php
}
?>
	}

</script>



<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
<tr>
<th width="50"></th>
<th><b><?php echo pvs_word_lang( "payments" )?>:</b></th>
</tr>
<?php
$sel = false;

foreach ( $pvs_payments as $key => $value ) {
	if ( (int)@$pvs_global_settings[ $key . '_active' ] == 1 and ($key != "fortumo" or ($key == "fortumo" and $_SESSION["billing_type"] == "credits")) and $key != "jvzoo" ) {
?>
	<tr>
	<td align="center" width="50"><input name="payment" type="radio" value="<?php echo $key
?>" <?php
		if ( $sel == false ) {
			echo ( "checked" );
		}
?> onClick="show_additional_fields('<?php echo $key
?>')">
	</td>
	<td>
	<?php echo $value
?>
	<?php
		if ( $key == "qiwi" ) {
?>
		<div id="qiwi_telephone" style="display:<?php
			if ( $sel == false )
			{
				echo ( "block" );
			} else
			{
				echo ( "none" );
			}
?>;margin-top:5px;"><b><?php
			echo pvs_word_lang( "telephone" )?></b> <small>(Example: +79061234560)</small><br><input type="text" name="telephone" value="" class="ibox form-control" style="width:150px;margin-top:2px;"></div>
		<?php
		}
		if ( $key == "yandex" ) {
?>
		<div id="yandex_payments" style="display:<?php
			if ( $sel == false )
			{
				echo ( "block" );
			} else
			{
				echo ( "none" );
			}
?>;margin-top:5px;">
		<select name="yandex_payments" style="width:400px;" class="ibox form-control">
			<?php
			foreach ( $site_yandex_payments as $key => $value )
			{
?><option value="<?php
				echo $key
?>"><?php
				echo $value
?></option><?php
			}
?>
		</select>
		</div>
		<?php
		}
		if ( $key == "targetpay" ) {
?>
		<div id="targetpay_banks" style="display:<?php
			if ( $sel == false )
			{
				echo ( "block" );
			} else
			{
				echo ( "none" );
			}
?>;margin-top:5px;"><b><?php
			echo pvs_word_lang( "banks" )?></b><br><select name="bank" class="ibox form-control" style="width:250px;margin-top:2px;">
<script src="https://www.targetpay.com/ideal/issuers-nl.js"></script>
</select></div>
		<?php
		}
?>
	<?php
		if ( $key == "moneyua" ) {
?>
		<div id="moneyua_method" style="display:<?php
			if ( $sel == false )
			{
				echo ( "block" );
			} else
			{
				echo ( "none" );
			}
?>;margin-top:5px;">
			<select name="moneyua_method" style="width:200px;" class="ibox form-control">
	<option value="16">VISA/MASTER Card</option>
	<option value="1">wmz</option>
	<option value="2">wmr</option>
	<option value="3">wmu</option>
	<option value="5">Yandex.Money</option>
	<option value="9">nsmep</option>
	<option value="14">Terminals</option>
	<option value="15">liqpay-USD</option>
	<option value="16">liqpay-UAH</option>
	<option value="17">Privat24-UAH</option>
	<option value="18">Privat24-USD</option>
			</select>
		</div>
		<?php
		}
?>
	</td>
	</tr>
	<?php
		$sel = true;
	}
}
?>



</table>
<input type="hidden" name="tip" value="<?php echo $_SESSION["billing_type"] ?>">
<input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "next step" )?>" style="margin-top:30px">

</form>



<?php
include ( "profile_bottom.php" );
?>