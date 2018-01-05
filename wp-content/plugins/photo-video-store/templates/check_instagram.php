<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


include ( PVS_PATH . "includes/plugins/instagram/instagram.class.php" );

if ( $pvs_global_settings["auth_instagram"] ) {
	$instagram = new Instagram( array(
		'apiKey' => $pvs_global_settings["auth_instagram_key"],
		'apiSecret' => $pvs_global_settings["auth_instagram_secret"],
		'apiCallback' => site_url() . "/check-instagram/" ) );

	$client_id = $pvs_global_settings["auth_instagram_key"];
	$client_secret = $pvs_global_settings["auth_instagram_secret"];
	$my_url = site_url() . "/check-instagram/";

	if ( isset( $_SERVER["HTTP_REFERER"] ) and preg_match( "/checkout/i", $_SERVER["HTTP_REFERER"] ) ) {
		$_SESSION["redirect_url"] = "checkout";
	}

	if ( ! isset( $_GET["code"] ) ) {
		$loginUrl = $instagram->getLoginUrl();
		header( "location:" . $loginUrl );
		exit();
	}

	if ( isset( $_GET["code"] ) ) {
		$code = $_GET['code'];

		// Check whether the user has granted access
		if ( true === isset( $code ) ) {
			// Receive OAuth token object
			$data = $instagram->getOAuthToken( $code );

			if ( ! empty( $data->user->username ) )
			{
				//Add new user into the database
				$temp_login = "instagram_" . pvs_result( $data->user->username );
				$temp_name = pvs_result( $data->user->full_name );
				$temp_website = pvs_result( $data->user->website );
				$temp_description = pvs_result( $data->user->bio );
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
					$params["lastname"] = '';
					$params["city"] = '';
					$params["state"] = '';
					$params["zipcode"] = '';
					$params["category"] = $pvs_global_settings["userstatus"];
					$params["website"] = $temp_website;
					$params["utype"] = $utype;
					$params["company"] = '';
					$params["newsletter"] = 0;
					$params["examination"] = $exam;
					$params["authorization"] = 'instagram';
					$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
					$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
					$params["aff_visits"] = 0;
					$params["aff_signups"] = 0;
					$params["aff_referal"] = $aff;
					$params["business"] = 0;
					$params["vat"] = '';
					$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
					$params["avatar"] = pvs_result( $data->user->profile_picture );
					$params["description"] = $temp_description;
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
		} else {
			// Check whether an error occurred
			if ( true === isset( $_GET['error'] ) )
			{
				echo 'An error occurred: ' . $_GET['error_description'];
			}
		}
	}
} else
{
	header( "location:" . site_url() . "/login/" );
	exit();
}
?>