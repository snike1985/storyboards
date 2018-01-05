<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<div class="page_internal">
<h1><?php echo pvs_word_lang( "sign up" );?></h1>


<?php

$user_fields["login"] = @$_SESSION["login"];
$user_fields["name"] = @$_SESSION["name"];
$user_fields["lastname"] = @$_SESSION["lastname"];
$user_fields["country"] = @$_SESSION["country"];
$user_fields["telephone"] = @$_SESSION["telephone"];
$user_fields["address"] = @$_SESSION["address"];
$user_fields["email"] = @$_SESSION["email"];
$user_fields["city"] = @$_SESSION["city"];
$user_fields["state"] = @$_SESSION["state"];
$user_fields["zipcode"] = @$_SESSION["zipcode"];
$user_fields["description"] = @$_SESSION["description"];
$user_fields["website"] = @$_SESSION["website"];
$user_fields["utype"] = @$_SESSION["utype"];
$user_fields["company"] = @$_SESSION["company"];
$user_fields["newsletter"] = @$_SESSION["newsletter"];
$user_fields["business"] = @$_SESSION["business"];
$user_fields["vat"] = @$_SESSION["vat"];

$ss = "add";

if ( ! isset( $_GET["utype"] ) ) {
	if ( $pvs_global_settings["common_account"] ) {
		$user_fields["utype"] = "common";
	} else {
		$user_fields["utype"] = "buyer";
	}
} else {
	if ( $_GET["utype"] == 'buyer') {
		$user_fields["utype"] = "buyer";
	}
	if ( $_GET["utype"] == 'seller') {
		$user_fields["utype"] = "seller";
	}
	if ( $_GET["utype"] == 'affiliate') {
		$user_fields["utype"] = "affiliate";
	}
	if ( $_GET["utype"] == 'common') {
		$user_fields["utype"] = "common";
	}
}
//One step signup
include ( "signup_content.php" );

?>







</div>