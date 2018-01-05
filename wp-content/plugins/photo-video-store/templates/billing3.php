<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );




if ( isset( $_POST["payment"] ) ) {
	$_SESSION["billing_payment"] = pvs_result( $_POST["payment"] );
} else {
	$_SESSION["billing_payment"] = '';
}
?>
	
<h1><?php echo pvs_word_lang( "buy " . pvs_result( $_SESSION["billing_type"] ) )?></h1>

<div class="login_header">

<div style="float:right;">[ <a href="<?php echo (site_url( ) );?>/<?php echo pvs_result( $_SESSION["billing_type"] )?>/?d=1"><?php echo pvs_word_lang( "change" )?></a> ]</div>	

<h2 style="margin-top:30px"><?php echo pvs_word_lang( "order" )?></h2></div>

<?php
include ( "billing_content.php" );?>
	
<?php
if ( ( $_SESSION["billing_type"] == "credits" and $pvs_global_settings["checkout_credits_billing"] ) or
	( $_SESSION["billing_type"] == "subscription" and $pvs_global_settings["checkout_subscription_billing"] ) ) {
?>


<div class="login_header">

<div style="float:right;">[ <a href="<?php echo (site_url( ) );?>/billing/"><?php echo pvs_word_lang( "change" )?></a> ]</div>	

<h2 style="margin-top:30px"><?php echo pvs_word_lang( "billing address" )?></h2>
</div>

<p>
<?php
	if ( $_SESSION["billing_firstname"] != "" or $_SESSION["billing_lastname"] != "" ) {
		echo ( $_SESSION["billing_firstname"] . " " . $_SESSION["billing_lastname"] .
			"<br>" );
	}
	if ( $_SESSION["billing_address"] != "" ) {
		echo ( $_SESSION["billing_address"] . "<br>" );
	}
	if ( $_SESSION["billing_city"] != "" or $_SESSION["billing_zip"] != "" or $_SESSION["billing_country"] !=
		"" ) {
		echo ( $_SESSION["billing_city"] . " " . $_SESSION["billing_state"] . " " . $_SESSION["billing_zip"] .
			", " . $_SESSION["billing_country"] . "<br>" );
	}
?>
</p>

<?php
}
?>

	
<div class="login_header">

<div style="float:right;">[ <a href="<?php echo (site_url( ) );?>/billing-payment/"><?php echo pvs_word_lang( "change" )?></a> ]</div>	


<h2 style="margin-top:30px"><?php echo pvs_word_lang( "Payment gateways" )?></h2>
</div>

<p>
<?php
if ( isset( $pvs_payments[$_SESSION["billing_payment"]] ) ) {
	echo ( $pvs_payments[$_SESSION["billing_payment"]] );
}
?>
</p>


<?php
$com = "";
if ( $_SESSION["billing_type"] == "credits" ) {
	$com = "types=2";
}
if ( $_SESSION["billing_type"] == "subscription" ) {
	$com = "types=3";
}

$disabled = "";
$mass = "";
$i = 0;

$sql = "select id,title,page_id from " . PVS_DB_PREFIX . "terms where " . $com .
	" order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
?>
	<div class="login_header">
		<h2 style="margin-top:30px"><?php echo pvs_word_lang( $rs->row["title"] )?></h2>
	</div>
	<iframe src="<?php echo (site_url( ) );?>/agreement/?id=<?php echo $rs->row["page_id"] ?>" frameborder="no" scrolling="yes" class="framestyle_seller" style="width:835px;height:150px"></iframe><br>
	<input name="terms<?php echo $rs->row["id"] ?>" id="terms<?php echo $rs->row["id"] ?>" type="checkbox" value="1" onClick="check_terms(<?php echo $rs->row["id"] ?>)"> <?php echo pvs_word_lang( "i agree" )?>
	
	<?php
	$mass .= "mass[" . $i . "]=" . $rs->row["id"] . ";";

	$i++;
	$disabled = "disabled";
	$rs->movenext();
}
if ( $disabled != "" ) {
?>
	<script>
		mass=new Array();	
		<?php echo $mass
?>
	
		function check_terms(value) {
			flag=true;	
			
			for(i=0;i<mass.length;i++)
			{
	if(document.getElementById("terms"+mass[i].toString()) && $("#terms"+mass[i].toString()).is(':checked')==false) {
		flag=false;
	}
			}

			if(flag)
			{
	document.getElementById('place_order').disabled=false;
			}
			else
			{
	document.getElementById('place_order').disabled=true;
			}
		}
	</script>
	<?php
}
?>




<form method="post" action="<?php echo (site_url( ) );?>/payment-process/">

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

<input type="hidden" name="payment" value="<?php echo $_SESSION["billing_payment"] ?>">

<input type="hidden" name="tip" value="<?php echo $_SESSION["billing_type"] ?>">


<?php
if ( isset( $_POST["telephone"] ) ) {
?>
<input type="hidden" name="telephone" value="<?php echo pvs_result( $_POST["telephone"] )?>">
<?php
}
?>

<?php
if ( isset( $_POST["bank"] ) ) {
?>
<input type="hidden" name="bank" value="<?php echo pvs_result( $_POST["bank"] )?>">
<?php
}
?>

<?php
if ( isset( $_POST["yandex_payments"] ) ) {
?>
<input type="hidden" name="yandex_payments" value="<?php echo pvs_result( $_POST["yandex_payments"] )?>">
<?php
}
?>

<?php
if ( isset( $_POST["moneyua_method"] ) ) {
?>
<input type="hidden" name="moneyua_method" value="<?php echo pvs_result( $_POST["moneyua_method"] )?>">
<?php
}
?>

<input id="place_order" class='isubmit' type="submit" value="<?php echo pvs_word_lang( "place order" )?>" style="margin-top:30px" <?php echo $disabled
?>>

</form>







<?php
include ( "profile_bottom.php" );
?>