<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["goemerchant_active"] ) {
	exit();
}
pvs_show_payment_page( 'header', true );
?>
<h1><?php echo pvs_word_lang( "payment" )?> - GoEMerchant</h1>

<?php
$test_mode = true;
if ( isset( $_SERVER["HTTPS"] ) and $_SERVER["HTTPS"] == "on" ) {
	$test_mode = false;
}

if ( $test_mode ) {
	echo ( "<div class='warning'>Error. The payment method requires a secure ssl connection. The transaction will be in <b>TEST MODE</b>. Please not to use valid credit card details!</div>" );
}
?>

<p>
<?php


//Check if Total is correct
if ( ! pvs_check_order_total( $product_total, $product_type, $product_id ) ) {
	exit();
}
?>
<h2><?php echo pvs_word_lang( "order" )?>:</h2>

<?php echo pvs_show_order_content( $product_type, $product_id )?>




<div class='login_header'><h2 style="margin-top:30px"><?php echo pvs_word_lang( "credit card" )?>:</h2></div>


<script language="javascript">


function check_cvv() {
	cvv_flag=false;
	cvv=document.getElementById('cvv').value
	if(cvv*1>0) {
		document.getElementById('error_cvv').innerHTML="";
		cvv_flag=true;
	}
	else {
		document.getElementById('error_cvv').innerHTML="<span class='error'>Error. Incorrect CVV code. I must be 3 digits!</span>";
		cvv_flag=false;
	}
	return cvv_flag;
}

function check_date() {
	date_flag=false;
	date_month=document.getElementById('card_month').value
	date_year=document.getElementById('card_year').value
	if(date_year == <?php echo date( "Y" )?> && date_month< <?php echo date( "m" )?>) {
		document.getElementById('error_date').innerHTML="<span class='error'>Error. Invalid credit cart expiration date!</span>";
		date_flag=false;
	}
	else {
		document.getElementById('error_date').innerHTML="";
		date_flag=true;
	}
	return date_flag;
}


function check_number() {
	number_flag=false;
	card_number=document.getElementById('card_number').value
	card_type=document.getElementById('card_type').value

	if(card_type=="Visa") {
		re=/4(?:[0-9]{12}|[0-9]{15})/ig
		if(card_number.match(re)) {
			number_flag=true;
		}
		else
		{
			number_flag=false;
		}
	}
	
	
	if(card_type=="MasterCard") {
		re=/5[1-5][0-9]{14}/ig
		if(card_number.match(re)) {
			number_flag=true;
		}
		else
		{
			number_flag=false;
		}
	}
	
	
	if(card_type=="Discover") {
		re=/6011[0-9]{12}/ig
		if(card_number.match(re)) {
			number_flag=true;
		}
		else
		{
			number_flag=false;
		}
	}
	
	
	if(card_type=="Amex") {
		re=/3[47][0-9]{13}/ig
		if(card_number.match(re)) {
			number_flag=true;
		}
		else
		{
			number_flag=false;
		}
	}
	
	
	if(number_flag) {
		document.getElementById('error_card_number').innerHTML="";
	}
	else {
		document.getElementById('error_card_number').innerHTML="<span class='error'>Error. Invalid card number!</span>";
	}
	return number_flag;
}



function check() {
	flag=false;
	flag1=check_number();
	flag2=check_cvv();
	flag3=check_date();
	if(flag1 && flag2 && flag3) {
		flag=true;
	}
	return flag;
}

</script>


<form action="<?php echo (site_url( ) );?>/payment-notification/?payment=goemerchant" method="POST" name="orderform" onsubmit="return check();">

<input type="hidden" name="product_id" value="<?php echo $product_id
?>">
<input type="hidden" name="product_name" value="<?php echo $product_name
?>">
<input type="hidden" name="product_total" value="<?php echo $product_total
?>">
<input type="hidden" name="product_type" value="<?php echo $product_type
?>">

<div style="margin-bottom:12px">
<div><b>Type of credit card:</b></div>
<div>
<select name="card_type" id="card_type" style="width:200px" class="ibox form-control" onChange="check_number();">
<option value="Visa">Visa</option>
<option value="MasterCard">MasterCard</option>
<option value="Discover">Discover</option>
<option value="Amex">Amex</option>
<option value="Maestro">Maestro</option>
<option value="Solo">Solo</option>
</select>
</div>
</div>

<div style="margin-bottom:12px">
<div><b>Credit card number:</b></div>
<div><input type="text" name="card_number" id="card_number" style="width:200px" class="ibox form-control" onChange="check_number();"></div>
<div id="error_card_number" name="error_card_number"></div>
</div>

<div style="margin-bottom:12px">
<div><b>Credit card expiration date:</b></div>
<div>
<select name="card_month" id="card_month" style="width:70px;display:inline" class="ibox form-control"  onChange="check_date();">
<?php
for ( $i = 1; $i < 13; $i++ ) {
	if ( $i < 10 ) {
		$ii = "0" . $i;
	} else {
		$ii = strval( $i );
	}
	$sel = "";
	if ( date( "m" ) == $ii ) {
		$sel = "selected";
	}
?>
	<option value="<?php echo $ii
?>" <?php echo $sel
?>><?php echo $ii
?></option>
	<?php
}
?>
</select>
<select name="card_year" id="card_year" style="width:120px;display:inline" class="ibox form-control" onChange="check_date();">
<?php
for ( $i = date( "Y" ); $i < date( "Y" ) + 10; $i++ ) {
?>
	<option value="<?php echo $i
?>"><?php echo $i
?></option>
	<?php
}
?>
</select>
</div>
<div id="error_date" name="error_date"></div>
</div>

<div style="margin-bottom:12px">
<div><b>CVV code:</b></div>
<div><input type="text" name="cvv" id="cvv" style="width:100px" class="ibox form-control" onChange="check_cvv();"></div>
<div id="error_cvv" name="error_cvv"></div>
</div>

<input type="submit" class="isubmit" value="<?php echo pvs_word_lang( "Pay Now" )?>">

</form>



<?php

pvs_show_payment_page( 'footer', true );
?>