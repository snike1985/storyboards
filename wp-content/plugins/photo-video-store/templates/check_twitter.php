<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


include ( PVS_PATH . "includes/plugins/twitter/autoload.php" );
use Abraham\TwitterOAuth\TwitterOAuth;

if ( $pvs_global_settings["auth_twitter"] ) {
	if ( isset( $_SERVER["HTTP_REFERER"] ) and preg_match( "/checkout/i", $_SERVER["HTTP_REFERER"] ) ) {
		$_SESSION["redirect_url"] = "checkout";
	}

	if ( ! isset( $_SESSION["steps"] ) ) {
		$_SESSION["steps"] = "redirect";
	}

	define( 'CONSUMER_KEY', $pvs_global_settings["auth_twitter_key"] );
	define( 'CONSUMER_SECRET', $pvs_global_settings["auth_twitter_secret"] );
	define( 'OAUTH_CALLBACK', site_url() . "/check-twitter/" );

	if ( $_SESSION["steps"] == "redirect" ) {
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET );
		$request_token = $connection->oauth( 'oauth/request_token', array( 'oauth_callback' =>
				OAUTH_CALLBACK ) );

		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		$url = $connection->url( 'oauth/authorize', array( 'oauth_token' => $request_token['oauth_token'] ) );
		$_SESSION["steps"] = "callback";

		header( "Location:" . $url );
		exit();
	}

	if ( $_SESSION["steps"] == "callback" ) {

		/* If the oauth_token is old redirect to the connect page. */
		if ( isset( $_REQUEST['oauth_token'] ) && $_SESSION['oauth_token'] != $_REQUEST['oauth_token'] ) {
			$_SESSION['oauth_status'] = 'oldtoken';
			$_SESSION["steps"] = "redirect";
			header( "location:" . site_url() . "/login/" );
			exit();
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'],
			$_SESSION['oauth_token_secret'] );

		/* Request access tokens from twitter */
		$access_token = $connection->oauth( "oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']] );

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['access_token'] = $access_token;

		/* Remove no longer needed request tokens */
		unset( $_SESSION['oauth_token'] );
		unset( $_SESSION['oauth_token_secret'] );

		$_SESSION["steps"] = "authorized";
	}

	if ( $_SESSION["steps"] == "authorized" ) {
		/* If access tokens are not available redirect to connect page. */
		if ( empty( $_SESSION['access_token'] ) || empty( $_SESSION['access_token']['oauth_token'] ) ||
			empty( $_SESSION['access_token']['oauth_token_secret'] ) ) {
			header( "location:" . site_url() . "/login/" );
			exit();
		}

		/* Get user access tokens out of the session. */
		$access_token = $_SESSION['access_token'];

		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'],
			$access_token['oauth_token_secret'] );

		/* If method is set change API call made. Test is called by default. */
		$content = $connection->get( 'account/verify_credentials' );

		//Add new user into the database
		$temp_login = pvs_result( $content->screen_name );
		$temp_name = pvs_result( $content->name );
		$temp_description = pvs_result( $content->description );
		$temp_website = pvs_result( $content->url );
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
			$params["authorization"] = 'twitter';
			$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
			$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
			$params["aff_visits"] = 0;
			$params["aff_signups"] = 0;
			$params["aff_referal"] = $aff;
			$params["business"] = 0;
			$params["vat"] = '';
			$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
			$params["avatar"] = pvs_result( $content->profile_image_url_https );
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
} else
{
	header( "location:" . site_url() . "/login/" );
	exit();
}
?>