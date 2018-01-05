<?php
/**
 * Zruseni predautorizace platby na strane GoPay
 */

require_once('../config.php');

require_once('../../api/gopay_helper.php');
require_once('../../api/gopay_soap.php');

try {

	// ID platby, u ktere ma byt zrusena predautorizace - vytvoreni pomoci metody createPreAutorizedPayment (viz gopay_soap.php)
	$paymentSessionId = 3000000001;
	GopaySoap::voidAuthorization($paymentSessionId,
								(float)GOID,
								SECURE_KEY);

} catch (Exception $e) {
	
	if ($e->getMessage() == GopayHelper::CALL_RESULT_ACCEPTED) {
		// Zruseni predautorizace platby bylo zarazeno ke zpracovani. Po urcite dobe je nutne dotazat stav platby, zda je jiz platba dokoncena

	} else {
		// Osetreni chyby v pripade chybneho zruseni predautorizace
		exit;
	}

}
?>
