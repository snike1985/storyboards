<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["gopay_active"] ) {
	require_once ( PVS_PATH . 'includes/plugins/gopay/example/config.php' );
	require_once ( PVS_PATH . 'includes/plugins/gopay/example/order.php' );
	
	require_once ( PVS_PATH . 'includes/plugins/gopay/api/gopay_helper.php' );
	require_once ( PVS_PATH . 'includes/plugins/gopay/api/gopay_soap.php' );
	
	/*
	* Parametry obsazene v notifikaci platby, predavane od GoPay e-shopu
	*/
	$returnedPaymentSessionId = $_GET['paymentSessionId'];
	$returnedParentPaymentSessionId = $_GET['parentPaymentSessionId'];
	$returnedGoId = $_GET['targetGoId'];
	$returnedOrderNumber = $_GET['orderNumber'];
	$returnedEncryptedSignature = $_GET['encryptedSignature'];
	
	$mass = explode( "-", $_GET['orderNumber'] );
	$product_type = $mass[0];
	$id = ( int )$mass[1];
	
	if ( $product_type == "credits" ) {
		$sql = "select title from " . PVS_DB_PREFIX . "credits_list where id_parent=" .
			$id;
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$product_name = $rs->row["title"];
		}
	}
	if ( $product_type == "subscription" ) {
		$sql = "select title,user from " . PVS_DB_PREFIX .
			"subscription_list where id_parent=" . $id;
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$product_name = $rs->row["title"] . " - " . $rs->row["user"];
		}
	}
	if ( $product_type == "order" ) {
		$product_name = "Order #" . $id;
	}
	
	$order_info = array();
	pvs_get_order_info( $id, $product_type );
	
	$order->orderNumber = $product_type . "-" . $id;
	$order->totalPrice = $order_info["product_total"] * 100;
	$order->currency = pvs_get_currency_code(1);
	$order->productName = $product_name;
	
	/*
	* Nacist data objednavky dle prichoziho paymentSessionId, 
	* zde z testovacich duvodu vse primo v testovaci tride Order
	* Upravte dle ulozeni vasich objednavek
	*/
	$order = new Order();
	
	if ( empty( $returnedParentPaymentSessionId ) ) {
		// notifikace o bezne platbe
		//$order->loadByPaymentSessionId($returnedPaymentSessionId); // ! UPRAVTE !
	
	} else
	{
		// notifikace o rekurentni platbe
		//$order->loadByPaymentSessionId($returnedParentPaymentSessionId); // ! UPRAVTE !
	
	}
	
	/*
	* Kontrola validity parametru v http notifikaci, opatreni proti podvrzeni potvrzeni platby (notifikace)
	*/
	
	try
	{
	
		GopayHelper::checkPaymentIdentity( ( float )$returnedGoId, ( float )$returnedPaymentSessionId,
			( float )$returnedParentPaymentSessionId, $returnedOrderNumber, $returnedEncryptedSignature,
			( float )GOID, $order->getOrderNumber(), SECURE_KEY );
	
		/*
		* Kontrola zaplacenosti objednavky na strane GoPay
		*/
		$result = GopaySoap::isPaymentDone( ( float )$returnedPaymentSessionId, ( float )
			GOID, $order->getOrderNumber(), ( int )$order->getTotalPrice(), $order->
			getcurrency(), $order->getProductName(), SECURE_KEY );
	
		if ( $result["sessionState"] == GopayHelper::PAID ) {
			/*
			* Zpracovat pouze objednavku, ktera jeste nebyla zaplacena 
			*/
			if ( empty( $returnedParentPaymentSessionId ) ) {
				// notifikace o bezne platbe
	
				if ( $order->getState() != GopayHelper::PAID )
				{
	
					/*
					*  Zpracovani objednavky  ! UPRAVTE !
					*/
					$order->processPayment();
					$transaction_id = pvs_transaction_add( "gopay", "", pvs_result( $product_type ),
						$id );
	
					if ( $product_type == "credits" and ! pvs_is_order_approved( $id, 'credits' )  )
					{
						pvs_credits_approve( $id, $transaction_id );
						pvs_send_notification( 'credits_to_user', $id );
						pvs_send_notification( 'credits_to_admin', $id );
					}
	
					if ( $product_type == "subscription" and ! pvs_is_order_approved( $id, 'subscription' )  )
					{
						pvs_subscription_approve( $id );
						pvs_send_notification( 'subscription_to_user', $id );
						pvs_send_notification( 'subscription_to_admin', $id );
					}
	
					if ( $product_type == "order" and ! pvs_is_order_approved( $id, 'order' )  )
					{
						pvs_order_approve( $id );
						pvs_commission_add( $id );
	
						pvs_coupons_add( pvs_order_user( $id ) );
						pvs_send_notification( 'neworder_to_user', $id );
						pvs_send_notification( 'neworder_to_admin', $id );
					}
				}
	
			} else {
				// notifikace o rekurentni platbe
	
				/*
				* Je potreba kontrolovat, jestli jiz toto paymentSessionId neni zaplaceno, aby pri 
				* opakovane notifikaci nedoslo k duplicitnimu zaznamu o zaplaceni 
				* a nasledne zaznamenat $returnedPaymentSessionId pro kontroly u dalsich opakovanych plateb
				*/
				if ( $order->isPaidRecurrentPayment( $returnedPaymentSessionId ) != true )
				{
	
					/*
					*  pridani paymentSessionId do seznamu uhrazenych opakovanych plateb
					*/
					$order->addPaidRecurrentPayment( $returnedPaymentSessionId );
				}
	
			}
	
		} else
			if ( $result["sessionState"] == GopayHelper::CANCELED ) {
				/* Platba byla zrusena objednavajicim */
				$order->cancelPayment();
	
			} else
				if ( $result["sessionState"] == GopayHelper::TIMEOUTED )
				{
					/* Platnost platby vyprsela  */
					$order->timeoutPayment();
	
				} else
					if ( $result["sessionState"] == GopayHelper::REFUNDED )
					{
						/* Platba byla vracena - refundovana */
						$order->refundePayment();
	
					} else
						if ( $result["sessionState"] == GopayHelper::AUTHORIZED )
						{
							/* Platba byla autorizovana, ceka se na dokonceni  */
							$order->autorizePayment();
	
						} else
						{
							header( "HTTP/1.1 500 Internal Server Error" );
							exit( 0 );
	
						}
	
	}
	catch ( Exception $e ) {
		/*
		* Nevalidni informace z http notifikaci - prevdepodobne pokus o podvodne zaslani notifikace
		*/
		header( "HTTP/1.1 500 Internal Server Error" );
		exit( 0 );
	}
}
?>