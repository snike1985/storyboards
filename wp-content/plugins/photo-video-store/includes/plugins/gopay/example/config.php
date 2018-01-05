<?php
define('GOID', $pvs_global_settings["gopay_account"]);
define('SECURE_KEY', $pvs_global_settings["gopay_password"]);

/*
 * defaultni jazykova mutace platebni brany GoPay
 */
define('LANG', 'cs');

/*
 * URL eshopu - pro urceni absolutnich cest 
 */
define('HTTP_SERVER', site_url( ));

define('SUCCESS_URL', HTTP_SERVER . '/payment-success/');
define('FAILED_URL', HTTP_SERVER . '/payment-fail/');

/*
 * URL skriptu volaneho pri navratu z platebni brany
 */
define('CALLBACK_URL', HTTP_SERVER . '/payment-notification/?payment=gopay');

/*
 * URL skriptu vytvarejiciho platbu na GoPay
 */
define('ACTION_URL', HTTP_SERVER . '/payment/gopay/');

/**
 *  Volba Testovaciho ci Provozniho prostredi
 *  Testovaci prostredi - GopayConfig::TEST
 *  Provozni prostredi  - GopayConfig::PROD
 */
require_once(dirname(__FILE__) . "/../api/gopay_config.php");

if($pvs_global_settings["gopay_test"]) {
	GopayConfig::init(GopayConfig::TEST);
}
else
{
	GopayConfig::init(GopayConfig::PROD);
}
?>