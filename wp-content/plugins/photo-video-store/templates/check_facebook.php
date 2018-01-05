<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

require_once ( PVS_PATH . 'includes/plugins/facebook/src/Facebook/autoload.php' );

if ( $pvs_global_settings["auth_facebook"] ) {

	$my_url = site_url() . "/check-facebook/";

	if ( isset( $_SERVER["HTTP_REFERER"] ) and preg_match( "/checkout/i", $_SERVER["HTTP_REFERER"] ) ) {
		$_SESSION["redirect_url"] = "checkout";
	}

	$fb = new Facebook\Facebook( ['app_id' => $pvs_global_settings["auth_facebook_key"],
		'app_secret' => $pvs_global_settings["auth_facebook_secret"],
		'default_graph_version' => 'v2.8', 'persistent_data_handler' => 'session'] );

	if ( ! isset( $_GET["code"] ) ) {

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email', 'public_profile', 'user_friends']; // Optional permissions
		$url = $helper->getLoginUrl( $my_url, $permissions );
		header( "location:" . $url );
		exit();

	} else {
		$helper = $fb->getRedirectLoginHelper();

		if ( isset( $_GET['state'] ) ) {
			$helper->getPersistentDataHandler()->set( 'state', $_GET['state'] );
		}

		try
		{
			$accessToken = $helper->getAccessToken();
		}
		catch ( Facebook\Exceptions\FacebookResponseException $e ) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}
		catch ( Facebook\Exceptions\FacebookSDKException $e ) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if ( ! isset( $accessToken ) ) {
			if ( $helper->getError() )
			{
				header( 'HTTP/1.0 401 Unauthorized' );
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else
			{
				header( 'HTTP/1.0 400 Bad Request' );
				echo 'Bad request';
			}
			exit;
		}

		try
		{
			// Returns a `Facebook\FacebookResponse` object
			$response = $fb->get( '/me?fields=id,name,first_name,last_name,email,website,link,picture,about,hometown',
				$accessToken );
		}
		catch ( Facebook\Exceptions\FacebookResponseException $e ) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}
		catch ( Facebook\Exceptions\FacebookSDKException $e ) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$user = $response->getGraphUser();


		//Add new user into the database
		$temp_login = "fb" . pvs_result($user['id']);

		$sql = "select ID from " . $table_prefix. "users where user_login='" . $temp_login . "'";
		$flag_add = false;
		$ds->open( $sql );
		if ( $ds->eof ) {
			//Add a new user
			$flag_add = true;
		}

		if ( $flag_add == true ) {
			//Examination
			if ( $pvs_global_settings["examination"] )
			{
				$exam = 0;
			} else
			{
				$exam = 1;
			}

			$aff = 0;
			if ( isset( $_COOKIE["aff"] ) )
			{
				$aff = ( int )$_COOKIE["aff"];
			}

			$avatar = '';

			$photo_mass = json_decode( $user['picture'] );
			if ( isset( $photo_mass->url ) )
			{
				$avatar = urldecode( $photo_mass->url );
			}
			
			if ( $pvs_global_settings["common_account"] ) {
				$utype = "common";
			} else {
				$utype = "buyer";
			}

			$params["login"] = $temp_login;
			$params["password"] = pvs_create_password();
			$params["name"] = pvs_result( $user['first_name'] );
			$params["country"] = '';
			$params["telephone"] = '';
			$params["address"] = '';
			$params["email"] = pvs_result( $user['email'] );
			$params["data1"] = pvs_get_time();
			$params["ip"] = pvs_result( $_SERVER["REMOTE_ADDR"] );
			$params["accessdenied"] = 0;
			$params["lastname"] = pvs_result( $user['last_name'] );
			$params["city"] = pvs_result( $user['hometown'] );
			$params["state"] = '';
			$params["zipcode"] = '';
			$params["category"] = $pvs_global_settings["userstatus"];
			$params["website"] = pvs_result( $user['link'] );
			$params["utype"] = $utype;
			$params["company"] = '';
			$params["newsletter"] = 0;
			$params["examination"] = $exam;
			$params["authorization"] = 'facebook' . pvs_result($user['id']);
			$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
			$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
			$params["aff_visits"] = 0;
			$params["aff_signups"] = 0;
			$params["aff_referal"] = $aff;
			$params["business"] = 0;
			$params["vat"] = '';
			$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
			$params["avatar"] = pvs_result( $avatar );
			$params["description"] = pvs_result( $user['about'] );
			$params["downloads"] = 0;
			$params["downloads_date"] = 0;
			$params["country_checked"] = 0;
			$params["country_checked_date"] = 0;
			$params["vat_checked"] = 0;
			$params["vat_checked_date"] = 0;
			$params["rating"] = 0;

			$id = pvs_add_user( $params );
			pvs_send_notification( 'signup_to_admin', $id );

			//insert the coupon for new user
			pvs_coupons_add( $temp_login, "New Signup" );
		}

		//Authorization
		pvs_user_authorization( pvs_user_login_to_id($temp_login) );

		if ( isset( $_SESSION["redirect_url"] ) and $_SESSION["redirect_url"] ==
			"checkout" )
		{
			header( "location:" . site_url() . "/checkout/" );
			exit();
		} else
		{
			header( "location:" . site_url() . "/profile/" );
			exit();
		}
	}
}
?>