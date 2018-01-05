<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["epaykkbkz_active"] ) {
	require_once ( PVS_PATH . "includes/plugins/epaykkbkz/kkb.utils.php" );
	$self = $_SERVER['PHP_SELF'];
	$path1 = PVS_PATH . 'includes/plugins/epaykkbkz/config.txt'; // Путь к файлу настроек config.dat
	$order_id = $product_id; // Порядковый номер заказа - преобразуется в формат "000001"
	
	// Шифр валюты  - 840-USD, 398-Tenge
	if ( pvs_get_currency_code(1) == "KZT" ) {
		$currency_id = "398";
	} elseif ( pvs_get_currency_code(1) == "USD" ) {
		$currency_id = "840";
	} else
	{
		$currency_id = "398";
	}
	
	$amount = $product_total; // Сумма платежа
	$content = process_request( $order_id, $currency_id, $amount, $path1 ); // Возвращает подписанный и base64 кодированный XML документ для отправки в банк
	
	?>
	
	
	   
	   <?php
	   $user_info = get_userdata(get_current_user_id());
	if ( @$user_info -> user_email != "" ) {
	?>
			<form name="process" id="process"  method="post" action="https://epay.kkb.kz/jsp/process/logon.jsp">
			<input type="hidden" name="email" size=50 maxlength=50  value="<?php echo @$user_info -> user_email ?>">
	   <?php
	} else
	{
	?>
			<form  method="post" action="https://epay.kkb.kz/jsp/process/logon.jsp">
			Email: <input type="text" name="email" size=50 maxlength=50  value=""><br>
			<input type="submit"  value="<?php echo pvs_word_lang( "pay now" )?>" >
	   <?php
	}
	?>
	   <input type="hidden" name="Signed_Order_B64" value="<?php echo $content; ?>">
	   <input type="hidden" name="Language" value="eng">
	   <input type="hidden" name="BackLink" value="<?php echo (site_url( ) );?>/payment-success/">
	   <input type="hidden" name="FailureBackLink" value="<?php echo (site_url( ) );?>/payment-fail/">
	   <input type="hidden" name="PostLink" value="<?php echo (site_url( ) );?>/payment-notification/?payment=epaykkbkz">
	</form>
	<?php
}

pvs_show_payment_page( 'footer' );
?>