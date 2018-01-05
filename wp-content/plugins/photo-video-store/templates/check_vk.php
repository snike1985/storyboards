<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


if ( $pvs_global_settings["auth_vkontakte"] ) {

	$client_id = $pvs_global_settings["auth_vkontakte_key"];
	$client_secret = $pvs_global_settings["auth_vkontakte_secret"];
	$my_url = site_url() . "/check-vk/";

	if ( isset( $_SERVER["HTTP_REFERER"] ) and preg_match( "/checkout/i", $_SERVER["HTTP_REFERER"] ) ) {
		$_SESSION["redirect_url"] = "checkout";
	}

	if ( ! isset( $_GET["code"] ) ) {
		$url = "https://oauth.vk.com/authorize?client_id=" . $client_id .
			"&scope=&redirect_uri=" . $my_url . "&response_type=code";
		header( "location:" . $url );

		exit();
	}

	if ( isset( $_GET["code"] ) ) {
		$token_url = "https://oauth.vk.com/access_token?client_id=" . $client_id .
			"&client_secret=" . $client_secret . "&code=" . $_GET['code'] . "&redirect_uri=" .
			$my_url;

		$resp = file_get_contents( $token_url );
		$data = json_decode( $resp, true );
		$_SESSION["access_token"] = $data['access_token'];
		$_SESSION["access_id"] = $data['user_id'];

		$graph_url = "https://api.vk.com/method/getProfiles?uid=" . $_SESSION["access_id"] .
			"&access_token=" . $_SESSION["access_token"] .
			"&fields=about,photo_50,photo_100";
		$results = json_decode( file_get_contents( $graph_url ) )->response;

		if ( isset( $results[0]->uid ) ) {

			//Add new user into the database
			$temp_login = "vk" . pvs_result( $results[0]->uid );
			$temp_name = pvs_result( $results[0]->first_name );
			$temp_lastname = pvs_result( $results[0]->last_name );
			$temp_website = "http://vk.com/id" . $results[0]->uid;
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

				$params["login"] = $temp_login;
				$params["password"] = pvs_create_password();
				$params["name"] = $temp_name;
				$params["country"] = '';
				$params["telephone"] = '';
				$params["address"] = '';
				$params["email"] = '';
				$params["data1"] = pvs_get_time();
				$params["ip"] = pvs_result( $_SERVER["REMOTE_ADDR"] );
				$params["accessdenied"] = 0;
				$params["lastname"] = $temp_lastname;
				$params["city"] = '';
				$params["state"] = '';
				$params["zipcode"] = '';
				$params["category"] = $pvs_global_settings["userstatus"];
				$params["website"] = $temp_website;
				$params["utype"] = $utype;
				$params["company"] = '';
				$params["newsletter"] = 0;
				$params["examination"] = $exam;
				$params["authorization"] = 'vk';
				$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
				$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
				$params["aff_visits"] = 0;
				$params["aff_signups"] = 0;
				$params["aff_referal"] = $aff;
				$params["business"] = 0;
				$params["vat"] = '';
				$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
				$params["avatar"] = pvs_result( $results[0]->photo_50 );
				$params["description"] = pvs_result( $results[0]->about );
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
} else
{
	header( "location:" . site_url() . "/login/" );
	exit();
}
?>