<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


$payout_accounts["paypal"] = "";
$payout_accounts["moneybookers"] = "";
$payout_accounts["dwolla"] = "";
$payout_accounts["qiwi"] = "";
$payout_accounts["webmoney"] = "";
$payout_accounts["bank"] = "";
$product_total = pvs_price_format( $_POST["total"], 2 );

$product_id = 0;
if ( $product_type = "payout_seller" ) {
	$sql = "select id from " . PVS_DB_PREFIX . "commission where user=" . ( int )$_POST["user"] .
		" and total<0 and gateway='" . pvs_result( $_POST["method"] ) .
		"' order by data desc";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$product_id = $dr->row["id"];
	}
}

if ( $product_type = "payout_affiliate" ) {
	$sql = "select data,aff_referal from " . PVS_DB_PREFIX .
		"affiliates_signups where aff_referal=" . ( int )$_POST["user"] .
		" and total<0 and gateway='" . pvs_result( $_POST["method"] ) .
		"' order by data desc";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$product_id = $dr->row["data"] . "-" . $dr->row["aff_referal"];
	}
}



$payout_accounts["paypal"] = get_user_meta( ( int )$_POST["user"], "paypal", true );
$payout_accounts["moneybookers"] = get_user_meta( ( int )$_POST["user"], "skrill", true );
$payout_accounts["dwolla"] = get_user_meta( ( int )$_POST["user"], "dwolla", true );
$payout_accounts["qiwi"] = get_user_meta( ( int )$_POST["user"], "qiwi", true );
$payout_accounts["webmoney"] = get_user_meta( ( int )$_POST["user"], "webmoney", true );
$payout_accounts["payson"] = get_user_meta( ( int )$_POST["user"], "payson", true );


$product_name = bloginfo('name') . ". Payout to " . pvs_user_id_to_login(( int )$_POST["user"]);


$page_header = "<html>
<body onLoad='document.process.submit()' bgcolor='#525151'>
<div style='margin:250px auto 0px auto;width:100px;background-color:#373737;border: #4a4a4a 4px solid;padding:20px;font: 15pt Arial;color:#ffffff'>" .
	pvs_word_lang( "loading" ) . "...<div><center><img src='" . pvs_plugins_url() .
	"/assets/images/upload_loading.gif'></center></div></div>";

$page_footer = "</body></html>";

if ( $_POST["method"] == "paypal" ) {
	echo ( $page_header );
?>
	<form method="post" name="process" id="process" action="https://www.paypal.com/cgi-bin/webscr">
		<input type="hidden" name="rm" value="2"/>
		<input type="hidden" name="cmd" value="_xclick"/>
		<input type="hidden" name="business" value="<?php echo $payout_accounts["paypal"] ?>"/>
		<input type="hidden" name="item_name" value="<?php echo $product_name
?>"/>
		<input type="hidden" name="item_number" value="<?php echo $product_id
?>"/>
		<input type="hidden" name="amount" value="<?php echo $product_total
?>"/>
		<input type="hidden" name="currency_code" value="<?php echo pvs_get_currency_code(1)
?>"/>
		<input type="hidden" name="notify_url" value=""/>
		<input type="hidden" name="return" value="<?php echo $link_back . "&t=1&id=" . $product_id
?>"/>
		<input type="hidden" name="cancel_return" value="<?php echo $link_back . "&t=2&id=" . $product_id
?>"/>
	</form>
	<?php echo ( $page_footer );
}

if ( $_POST["method"] == "skrill" ) {
	echo ( $page_header );
?>
	<form method="post" action="https://www.moneybookers.com/app/payment.pl"  name="process" id="process">
        <input type="hidden" name="pay_to_email" value="<?php echo $payout_accounts["moneybookers"] ?>" />
        <input type="hidden" name="language" value="EN" />
        <input type="hidden" name="amount" value="<?php echo $product_total
?>" />
        <input type="hidden" name="currency" value="<?php echo pvs_get_currency_code(1)
?>" />
        <input type="hidden" name="detail1_description" value="<?php echo $product_name
?>" />
        <input type="hidden" name="detail1_text" value="<?php echo $product_id
?>" />
        <input type="hidden" name="transaction_id" value="<?php echo $product_id
?>" />
        <input type="hidden" name="return_url" value="<?php echo $link_back . "&t=1&id=" . $product_id
?>" />
        <input type="hidden" name="cancel_url" value="<?php echo $link_back . "&t=2&id=" . $product_id
?>" />
    </form>
	<?php echo ( $page_footer );
}

if ( $_POST["method"] == "dwolla" and $payout_accounts["dwolla"] != "" and $pvs_global_settings['dwolla_password'] !=
	"" ) {
	include ( PVS_PATH . "includes/plugins/dwolla/dwolla.php" );
	$apiKey = $pvs_global_settings['dwolla_password'];
	$apiSecret = $pvs_global_settings['dwolla_password2'];
	$token = '';
	$pin = $pvs_global_settings['dwolla_password3'];

	$Dwolla = new DwollaRestClient();
	$Dwolla->setToken( $token );
	$transactionId = $Dwolla->send( $pin, $payout_accounts["dwolla"], $product_total,
		'', $product_name );
	if ( ! $transactionId ) {
		echo "Error: {$Dwolla->getError()} \n";
	} // Check for errors
	else {
		echo "Send transaction ID: {$transactionId} \n";
	} // Print Transaction ID
}

else if ( $_POST["method"] == "qiwi" ) {
	header( "location:https://w.qiwi.com/payment/transfer/form.action" );
	exit();
}

if ( $_POST["method"] == "webmoney" ) {
	echo ( $page_header );
?>
	<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" name="process" id="process">
		<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo pvs_price_format( $product_total, 2 )?>">
		<input type="hidden" name="LMI_PAYMENT_DESC" value="<?php echo $product_name
?>">
		<input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $product_id
?>">
		<input type="hidden" name="LMI_PAYEE_PURSE" value="<?php echo $payout_accounts["webmoney"] ?>">
		<input type="hidden" name="ptype" value="<?php echo $product_type
?>">
		<input type="hidden" name="LMI_SUCCESS_URL" value="<?php echo $link_back . "&t=1&id=" . $product_id
?>" />
       	<input type="hidden" name="LMI_FAIL_URL" value="<?php echo $link_back . "&t=2&id=" . $product_id
?>" />
	</form>
	<?php echo ( $page_footer );
}
?>
