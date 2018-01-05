<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$flag = true;

$user_info = get_userdata(get_current_user_id());

//Check if the user exists
$sql = "select ID, user_login from " . $table_prefix . "users where user_email='" . pvs_result( $_POST["email"] ) . "'";
$rs->open( $sql );
if ( ! $rs->eof and $_POST["email"] != $user_info -> user_email ) {
	$flag = false;
	header( "location:" . site_url() . "/profile-about/?d=2" );
	exit();
}

if ( $flag == true and @$_POST["password"] != '') {
	if ( isset( $_POST["newsletter"] ) ) {
		$newsletter = 1;
	} else {
		$newsletter = 0;
	}
	
	$userdata = array(
		'ID' => get_current_user_id(),
		'user_login'   =>  $user_info -> user_login,
		'user_pass'   =>  pvs_result( @$_POST["password"] ),
		'user_email' => pvs_result( @$_POST["email"] ),
		'first_name' => pvs_result( @$_POST["name"] ),
		'last_name' => pvs_result( @$_POST["lastname"] ),
		'description' => pvs_result( @$_POST["description"] ),
		'user_url' => pvs_result( @$_POST["website"] )
	);

	$id = wp_update_user( $userdata ) ;
	
	update_user_meta( $id, 'country', pvs_result( @$_POST["country"] ));
	update_user_meta( $id, 'telephone', pvs_result( @$_POST["telephone"] ));
	update_user_meta( $id, 'address', pvs_result( @$_POST["address"] ));
	update_user_meta( $id, 'city', pvs_result( @$_POST["city"] ));
	update_user_meta( $id, 'state', pvs_result( @$_POST["state"] ));
	update_user_meta( $id, 'zipcode', pvs_result( @$_POST["zipcode"] ));
	update_user_meta( $id, 'company', pvs_result( @$_POST["company"] ));
	update_user_meta( $id, 'newsletter', $newsletter);
	update_user_meta( $id, 'business', ( int )@$_POST["business"]);
	update_user_meta( $id, 'vat', pvs_result( @$_POST["vat"] ));
	
	if ( @$user_info -> country != pvs_result( @$_POST["country"] ) ) {
		update_user_meta( $id, 'country_checked', 0);
		update_user_meta( $id, 'country_checked_date', 0);
	}

	
	header( "location:" . site_url() . "/profile-about/?d=3" );
}
?>