<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


if ( $pvs_global_settings["auth_yandex"] ) {

	$client_id = $pvs_global_settings["auth_yandex_key"];
	$client_secret = $pvs_global_settings["auth_yandex_secret"];
	$redirect_uri = site_url(). "/check-yandex/";

	$url = 'https://oauth.yandex.ru/authorize';

	$params = array(
		'response_type' => 'code',
		'client_id' => $client_id,
		'display' => 'popup' );

	if ( ! isset( $_GET['code'] ) ) {
		$link = $url . '?' . urldecode( http_build_query( $params ) );
		header( "location:" . $link );
		exit();
	}

	if ( isset( $_GET['code'] ) ) {
		$result = false;

		$params = array(
			'grant_type' => 'authorization_code',
			'code' => $_GET['code'],
			'client_id' => $client_id,
			'client_secret' => $client_secret );

		$url = 'https://oauth.yandex.ru/token';

		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, urldecode( http_build_query( $params ) ) );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec( $curl );
		curl_close( $curl );

		$tokenInfo = json_decode( $result, true );

		if ( isset( $tokenInfo['access_token'] ) ) {
			$params = array( 'format' => 'json', 'oauth_token' => $tokenInfo['access_token'] );

			$user = json_decode( file_get_contents( 'https://login.yandex.ru/info' . '?' .
				urldecode( http_build_query( $params ) ) ), true );
			if ( isset( $user['id'] ) )
			{

				//Add new user into the database
				$temp_login = "yandex_" . pvs_result( $user['display_name'] );

				$sql = "select ID from " . $table_prefix. "users where user_login='" . $temp_login . "'";
				$flag_add = false;
				$ds->open( $sql );
				if ( $ds->eof )
				{
					//Add a new user
					$flag_add = true;
				}

				if ( $flag_add == true )
				{
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

					$utype = "";
					if ( $pvs_global_settings["common_account"] )
					{
						$utype = "common";
					}

					$avatar = '';

					if ( ! $user['is_avatar_empty'] )
					{
						$avatar = 'https://avatars.yandex.net/get-yapic/' . pvs_result( $user['default_avatar_id'] );
					}

					$params["login"] = $temp_login;
					$params["password"] = pvs_create_password();
					$params["name"] = pvs_result( $user['first_name'] );
					$params["country"] = '';
					$params["telephone"] = '';
					$params["address"] = '';
					$params["email"] = pvs_result( $user['emails'][0] );
					$params["data1"] = pvs_get_time();
					$params["ip"] = pvs_result( $_SERVER["REMOTE_ADDR"] );
					$params["accessdenied"] = 0;
					$params["lastname"] = pvs_result( $user['last_name'] );
					$params["city"] = '';
					$params["state"] = '';
					$params["zipcode"] = '';
					$params["category"] = $pvs_global_settings["userstatus"];
					$params["website"] = '';
					$params["utype"] = $utype;
					$params["company"] = '';
					$params["newsletter"] = 0;
					$params["examination"] = $exam;
					$params["authorization"] = 'yandex';
					$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
					$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
					$params["aff_visits"] = 0;
					$params["aff_signups"] = 0;
					$params["aff_referal"] = $aff;
					$params["business"] = 0;
					$params["vat"] = '';
					$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
					$params["avatar"] = $avatar;
					$params["description"] = '';
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
	}
}
?>