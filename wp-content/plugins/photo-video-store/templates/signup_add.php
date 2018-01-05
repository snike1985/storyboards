<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$_SESSION["login"] = @$_POST["login"];
$_SESSION["name"] = @$_POST["name"];
$_SESSION["lastname"] = @$_POST["lastname"];
$_SESSION["city"] = @$_POST["city"];
$_SESSION["state"] = @$_POST["state"];
$_SESSION["zipcode"] = @$_POST["zipcode"];
$_SESSION["country"] = @$_POST["country"];
$_SESSION["telephone"] = @$_POST["telephone"];
$_SESSION["address"] = @$_POST["address"];
$_SESSION["email"] = @$_POST["email"];
$_SESSION["utype"] = @$_POST["utype"];
$_SESSION["website"] = @$_POST["website"];
$_SESSION["company"] = @$_POST["company"];
$_SESSION["business"] = @$_POST["business"];

//Check if the user exists
$sql = "select user_login from " . $table_prefix . "users where user_login='" . pvs_result( $_POST["login"] ) .
	"'";
$rs->open( $sql );
if ( ! $rs->eof ) {
	header( "location:" . site_url() . "/signup/?d=1" );
	exit();
} else
{
	$sql = "select user_email from " . $table_prefix . "users where user_email='" . pvs_result( $_POST["email"] ) .
		"'";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		header( "location:" . site_url() . "/signup/?d=2" );
		exit();
	} else {
		//Check captcha
		require_once ( PVS_PATH . 'includes/plugins/recaptcha/recaptchalib.php' );
		$flag_captcha = pvs_check_captcha();

		if ( $flag_captcha and $_POST["login"] != "" and $_POST["password"] != "" ) {

			//Examination
			if ( $pvs_global_settings["examination"] )
			{
				$exam = 0;
			} else
			{
				$exam = 1;
			}

			if ( isset( $_POST["newsletter"] ) )
			{
				$newsletter = 1;
			} else
			{
				$newsletter = 0;
			}

			$aff = 0;
			if ( isset( $_COOKIE["aff"] ) )
			{
				$aff = ( int )$_COOKIE["aff"];
			}

			$params["login"] = pvs_result( $_POST["login"] );
			$params["password"] = pvs_result( $_POST["password"] );
			$params["name"] = pvs_result( @$_POST["name"] );
			$params["country"] = pvs_result( @$_POST["country"] );
			$params["telephone"] = pvs_result( @$_POST["telephone"] );
			$params["address"] = pvs_result( @$_POST["address"] );
			$params["email"] = pvs_result( @$_POST["email"] );
			$params["data1"] = pvs_get_time();
			$params["ip"] = pvs_result( $_SERVER["REMOTE_ADDR"] );
			$params["accessdenied"] = 0;
			$params["lastname"] = pvs_result( @$_POST["lastname"] );
			$params["city"] = pvs_result( @$_POST["city"] );
			$params["state"] = pvs_result( @$_POST["state"] );
			$params["zipcode"] = pvs_result( @$_POST["zipcode"] );
			$params["category"] = $pvs_global_settings["userstatus"];
			$params["website"] = pvs_result( @$_POST["website"] );
			$params["utype"] = pvs_result( @$_POST["utype"] );
			$params["company"] = pvs_result( @$_POST["company"] );
			$params["newsletter"] = $newsletter;
			$params["examination"] = $exam;
			$params["authorization"] = 'site';
			$params["aff_commission_buyer"] = ( int )$pvs_global_settings["buyer_commission"];
			$params["aff_commission_seller"] = ( int )$pvs_global_settings["seller_commission"];
			$params["aff_visits"] = 0;
			$params["aff_signups"] = 0;
			$params["aff_referal"] = $aff;
			$params["business"] = ( int )@$_POST["business"];
			$params["vat"] = pvs_result( @$_POST["vat"] );
			$params["payout_limit"] = ( int )$pvs_global_settings["payout_limit"];
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
			pvs_send_notification( 'signup_to_user', $id );

			//insert the coupon for new user
			pvs_coupons_add( pvs_result( $_POST["login"] ), "New Signup" );

			header( "location:" . site_url() . "/thanks/" );
			exit();
		}
	}
}
?>