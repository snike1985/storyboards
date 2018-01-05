<html>
	<head>
    	<title>GoPay - testovací skript</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
	
		Pokud se u kterékoliv položky zobrazuje stav "CHYBA", zašlete nám kompletní výpis či přímo printscreen obrazovky.
		<br><br>
  		<?php

  		$targetGoId = !empty($_POST["targetGoId"]) ? $_POST["targetGoId"] : null;
  		$secureKey = !empty($_POST["secureKey"]) ? $_POST["secureKey"] : null;

  		$admin = !empty($_GET["admin"]) ? $_GET["admin"] : false;
  		GopayTester::setAdmin($admin);

		GopayTester::runTest($targetGoId, $secureKey);
  		?>
  		<br><br>
  		
  		Testovací platba
  		<form method="POST">
			GoID: <input type="text" name="targetGoId"><br>
			Secret: <input type="text" name="secureKey"><br>
			<input type="submit" name="testCreatePayment" value="Vytvořit platbu">
  		</form>
  		<br><br>

  		<?php
  		GopayTester::showPhpinfo()
  		?>
	</body>
</html>

<?php
class GopayTester {

	static $admin = false;

	const test_wsdl_ssl    = "https://testgw.gopay.cz/axis/EPaymentServiceV2?wsdl"; // URL na testovaci WSDL na SSL kanale
	const test_wsdl_nonssl = "http://testgw.gopay.cz/axis/EPaymentServiceV2?wsdl"; // URL na testovaci WSDL bez SSL kanalu
	const prod_wsdl_ssl    = "https://gate.gopay.cz/axis/EPaymentServiceV2?wsdl"; // URL na provozni WSDL
	const prod_wsdl_nonssl = "http://gate.gopay.cz/axis/EPaymentServiceV2?wsdl"; // URL na provozni WSDL
	const paypal_wsdl      = "https://www.sandbox.paypal.com/wsdl/PayPalSvc.wsdl"; // URL PayPal WSDL

	public static function runTest($targetGoId, $secureKey) {

		if (self::$admin == true) {
			error_reporting(E_ALL|E_STRICT);
			ini_set('display_errors', 1);
		}

		ini_set('soap.wsdl_cache', '0');
		ini_set('soap.wsdl_cache_enabled', '0'); 
		ini_set('date.timezone', 'Europe/Prague');

		$soapOK = 1;
		$sslOK = 1;
		
		echo "Modul mcrypt: ";
		echo self::testMcrypt() == 0 ? self::kopvs_result() : self::okpvs_result();

		echo "Modul mhash / sha1: ";
		echo self::testMhashSHA1() == 0 ? self::kopvs_result() : self::okpvs_result();

		echo "Modul SOAP: ";
		if (self::testSOAP() == 0) {
			echo self::kopvs_result();
			$soapOK = 0;
		} else {
			echo self::okpvs_result();
		}

		if ($soapOK == 1) {
			
			if (self::$admin == true) {
				echo "<br>";
				echo "------------------------------------------------";
				echo "<br>";
	
				echo "<br>Kontrola dostupnosti WS pomocí CURL - Test prostředí<br>";
				self::wsdlAvailibilityCurl(self::test_wsdl_nonssl);
	
				echo "<br>Kontrola dostupnosti WS pomocí CURL - Test prostředí - SSL<br>";
				self::wsdlAvailibilityCurl(self::test_wsdl_ssl);
				
				echo "<br>Kontrola dostupnosti WS pomocí CURL - Provozní prostředí<br>";
				self::wsdlAvailibilityCurl(self::prod_wsdl_nonssl);
	
				echo "<br>Kontrola dostupnosti WS pomocí CURL - Provozní prostředí - SSL<br>";
				self::wsdlAvailibilityCurl(self::prod_wsdl_ssl);
				
				echo "<br>";
				echo "------------------------------------------------";
				echo "<br>";
				
				echo "Test volání WSDL - Test bez SSL: ";
				self::callWsdl(self::test_wsdl_nonssl);
				
				echo "Test volání WSDL - Test s SSL: ";
				self::callWsdl(self::test_wsdl_ssl);
				
				echo "Test volání WSDL - Provoz bez SSL: ";
				self::callWsdl(self::prod_wsdl_nonssl);
				
				echo "Test volání WSDL - Provoz s SSL: ";
				self::callWsdl(self::prod_wsdl_ssl);
				
				echo "Test volání WSDL - PayPal WSDL: ";
				self::callWsdl(self::paypal_wsdl);
				
				echo "<br>";
				echo "------------------------------------------------";
				echo "<br>";
			}

			echo "Test volání metody WSDL - GoPay: ";
			self::callWsdlFunctionTouchTestNonssl();
	
			echo "Modul OpenSSL - SOAP volání provozní SSL WSDL: ";
			if (self::callWsdl(self::prod_wsdl_ssl) == 0) {
				$sslOK = 0;
			}
	
			if ($sslOK == 1) {
				echo "Komunikace s Test certifikátem: "; 
				self::callWsdlTestSsl();
		  		
		  		if (!empty($targetGoId) && !empty($secureKey)) {
		  			echo self::testCreatePayment($targetGoId, $secureKey);
		  		}
			}
		}
		
	}
	
	private static Function okpvs_result() {
		return "<span style='color:green'>OK</span><br>";
	}
	
	private static function kopvs_result() {
		return "<span style='color:red'>CHYBA</span><br>";
	}

	// kontrola PHP modulu mcrypt
	private static function testMcrypt() {
		return (function_exists("mcrypt_module_open")!=true) ? 0 : 1;
	}
	
	// kontrola PHP modulu mhash / sha1
	private static function testMhashSHA1() {
		return (function_exists("sha1")!=true && function_exists("mhash")!=true) ? 0 : 1;
	}

	// kontrola PHP modulu SOAP
	private static function testSOAP() {
		return (function_exists("is_soap_fault")!=true) ? 0 : 1;
	}
	
	// kontrola volani WSDL metod
	private static function callWsdlFunctionTouchTestNonssl() {
		try{
			$go_client = new SoapClient(self::test_wsdl_nonssl);
			$go_client->__call('touch', array());
			echo self::okpvs_result();

		} catch (Exception $f){
			echo self::kopvs_result();
			if (self::$admin == true) {
				var_dump($f);
				echo("<br><br>");
			}
		}
	}

	// kontrola volani WSDL
	public static function callWsdl($wsdl) {
		try {	
			$client = new SoapClient($wsdl);
			echo self::okpvs_result();
			return 1;

		} catch (Exception $e) {
			echo self::kopvs_result();
			if (self::$admin == true) {
				var_dump($e);
				echo("<br><br>");
			}
			return 0;
		}
	}

	// test komunikace se SSL certifikatem na test prostredi
	private static function callWsdlTestSsl() {
		try {
			$client = new SoapClient(self::test_wsdl_ssl);
			echo self::okpvs_result();

		} catch (SoapFault $f) {
			
			try {
				$client = new SoapClient(self::test_wsdl_nonssl);
				echo self::kopvs_result();
				if (self::$admin == true) {
					var_dump($f);
				}
				echo("<br><br>");
			
			} catch (SoapFault $f) {
				echo self::kopvs_result();
				if (self::$admin == true) {
					var_dump($f);
				}
			}
		}
	}
	
	// vytvoreni pokusne platby - kontrola intepretace parametru
	private static function testCreatePayment($targetGoId, $secureKey) {
		$result = "<br><br><br>";
		
		try {
			$totalPrice = 100;
			$currency = "CZK";
			$orderNumber = "gopay_test_".$targetGoId;
			$productName = "productName";
			$failedURL = "http://www.failed_url.cz";
			$successURL = "http://www.success_url.cz";

			$encryptedSignature = self::encrypt(
					self::hash(
							self::concatPaymentCommand(
											(float)$targetGoId,
											$productName, 
											(float)$totalPrice,
											$currency,
											$orderNumber,
											$failedURL,
											$successURL,
											false,
											false,
											null,
											null,
											null,
											"",
											$secureKey)
									),
									$secureKey);

			$customerData = array(
					"firstName" => "test_firstName",
					"lastName" => "test_lastName",
					"city" => "city",
					"street" => "street",
					"postalCode" => "12345",
					"countryCode" => "CZE",
					"email" => "test@test.cz",
					"phoneNumber" => "123456789"
			);

			$paymentCommand = array(
						"targetGoId" => (float)$targetGoId,
						"productName" => trim($productName),
						"totalPrice" => (int)$totalPrice,
						"currency" => trim($currency),
						"orderNumber" => trim($orderNumber),
						"failedURL" => trim($failedURL),
						"successURL" => trim($successURL),
				  		"preAuthorization" => false,
				  		"recurrentPayment" => false,
						"paymentChannels" => "",
						"defaultPaymentChannel" => "",
				  		"encryptedSignature" => $encryptedSignature,
				  		"customerData" => $customerData,
				  		"p1" => null,
				  		"p2" => null,
				  		"p3" => null,
				  		"p4" => null
		     );

			$go_client = new SoapClient(self::test_wsdl_ssl, array());
			$payment_status = $go_client->__call('createPayment', array('paymentCommand'=>$paymentCommand));
			
			$result .= "Vytváření platby: ".self::okpvs_result()."<br>";
			$result .= "paymentSessionId = ".$payment_status->paymentSessionId."<br>";
			$result .= "targetGoId = ".$payment_status->targetGoId."<br>";
			$result .= "productName = ".$payment_status->productName."<br>";
			$result .= "totalPrice = ".$payment_status->totalPrice."<br>";
			$result .= "orderNumber = ".$payment_status->orderNumber."<br>";
			$result .= "encryptedSignature = ".$payment_status->encryptedSignature."<br>";
			$result .= "result = ".$payment_status->result."<br>";
			$result .= "sessionState = ".$payment_status->sessionState."<br>";
			$result .= "resultDescription = ".$payment_status->resultDescription."<br>";

		} catch (SoapFault $f) {
			$result .= "Vytváření platby: ".self::kopvs_result()."<br>";
			$result .= print_r($f, true);
		}
		
		return $result;
	}
	
	private static function encrypt($data, $secureKey) {
  		$td = mcrypt_module_open (MCRYPT_3DES, '', MCRYPT_MODE_ECB, '');
        $mcrypt_iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init ($td, substr($secureKey, 0, mcrypt_enc_get_key_size($td)), $mcrypt_iv);
        $encrypted_data = mcrypt_generic ($td, $data);
        mcrypt_generic_deinit ($td);
        mcrypt_module_close ($td);

        return bin2hex($encrypted_data);
  	}

	private static function hash($data) {
  		if (function_exists("sha1") == true) {
  			$hash = sha1($data, true);

  		} else {
  			$hash = mhash(MHASH_SHA1, $data);
  		}

  		return bin2hex($hash);   		
  	}
	
	public static function castBooleanForWS($boolean) {
		$boolean = self::castString2Boolean($boolean);
		
		if ($boolean === FALSE) {
			return 0;
	
		} else 	if ($boolean === TRUE) {
			return 1; 

		} else {
			return "";
		}
	}
	
	public static function castString2Boolean($boolean) {
		if (is_string($boolean)) {

			if (strtolower($boolean) == "true") {
				return TRUE;

			} else if (strtolower($boolean) == "false") {
				return FALSE;

			}
		}

		return $boolean;
	}

	public static function concatPaymentCommand(
	  		$goId,
	  		$productName, 
	  		$totalPriceInCents, 
	  		$currency, 
	  		$orderNumber,
	  		$failedURL,
	  		$successURL, 
	  		$preAuthorization,
	  		$recurrentPayment,
	  		$recurrenceDateTo,
	  		$recurrenceCycle,
	  		$recurrencePeriod,
	  		$paymentChannels,
	  		$secureKey) {

			$preAuthorization = self::castBooleanForWS($preAuthorization);
			$recurrentPayment = self::castBooleanForWS($recurrentPayment);

			return $goId."|".trim($productName)."|".$totalPriceInCents."|".trim($currency)."|".trim($orderNumber)."|".trim($failedURL)."|".trim($successURL)."|".$preAuthorization."|".$recurrentPayment."|".trim($recurrenceDateTo)."|".trim($recurrenceCycle)."|".trim($recurrencePeriod)."|".trim($paymentChannels)."|".$secureKey; 
	  	}
	
	public static function setAdmin($new_admin) {
		self::$admin = $new_admin;
	}
	
	private static function wsdlAvailibilityCurl($wsdl_url) {
		if (function_exists("curl_init") == true) {
		
			$tuCurl = curl_init(); 
			curl_setopt($tuCurl, CURLOPT_URL, $wsdl_url);
			curl_setopt($tuCurl, CURLOPT_SSL_VERIFYHOST, 1);
			curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($tuCurl, CURLOPT_VERBOSE, 1);
		
			$tuData = curl_exec($tuCurl); 
	
			echo "Stažení definice WS pomocí CURL - ";
			echo ($tuData == true) ? self::okpvs_result() : self::kopvs_result();
	
			$headers = curl_getinfo($tuCurl);
			echo "CURL - HEADERS WS - ";
			echo ($headers["content_type"] != null) ? self::okpvs_result() : self::kopvs_result();
			if (self::$admin == true) {
				var_dump($headers);
				echo "<br>";
			}
	
			curl_close($tuCurl);
		
		} else {
			echo "CURL není přítomen<br> ";
			
		}
	}

	public static function showPhpinfo() {
		if (self::$admin == true) {
			phpinfo();
		}
		
	}
	
}
?>