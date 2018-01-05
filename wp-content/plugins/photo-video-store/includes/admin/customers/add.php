<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_customers" );

$newsletter = 0;
if ( isset( $_POST["newsletter"] ) ) {
	$newsletter = 1;
}

$exam = 0;
if ( isset( $_POST["examination"] ) ) {
	$exam = 1;
}

if ( isset( $_GET["id"] ) ) {
	$id = ( int )$_GET["id"];
	
	$user_info = get_userdata($id);
	
	if ( @$_POST["password"] != "********" ) {
		$userdata = array(
			'ID' => ( int )$_GET["id"],
			'user_login'   =>  pvs_result( @$_POST["login"] ),
			'user_pass'   =>  pvs_result( @$_POST["password"] ),
			'user_email' => pvs_result( @$_POST["email"] ),
			'first_name' => pvs_result( @$_POST["name"] ),
			'last_name' => pvs_result( @$_POST["lastname"] ),
			'description' => pvs_result( @$_POST["description"] ),
			'user_url' => pvs_result( @$_POST["website"] )
		);
	} else {
		$userdata = array(
			'ID' => ( int )$_GET["id"],
			'user_login'   =>  pvs_result( @$_POST["login"] ),
			'user_email' => pvs_result( @$_POST["email"] ),
			'first_name' => pvs_result( @$_POST["name"] ),
			'last_name' => pvs_result( @$_POST["lastname"] ),
			'description' => pvs_result( @$_POST["description"] ),
			'user_url' => pvs_result( @$_POST["website"] )
		);	
	}

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
	update_user_meta( $id, 'utype', pvs_result( @$_POST["utype"] ));
	update_user_meta( $id, 'category', pvs_result( @$_POST["category"] ));
	
	update_user_meta( $id, 'aff_commission_buyer', pvs_result( @$_POST["aff_commission_buyer"] ));
	update_user_meta( $id, 'aff_commission_seller', pvs_result( @$_POST["aff_commission_seller"] ));
	update_user_meta( $id, 'payout_limit', pvs_result( @$_POST["payout_limit"] ));

} else
{
	$params["login"] = pvs_result( $_POST["login"] );
	$params["password"] = pvs_result( $_POST["password"] );
	$params["name"] = pvs_result( @$_POST["name"] );
	$params["country"] = pvs_result( @$_POST["country"] );
	$params["telephone"] = pvs_result( @$_POST["telephone"] );
	$params["address"] = pvs_result( @$_POST["address"] );
	$params["email"] = pvs_result( @$_POST["email"] );
	$params["ip"] = pvs_result( $_SERVER["REMOTE_ADDR"] );
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
	$params["aff_commission_buyer"] = ( int )$_POST["aff_commission_buyer"];
	$params["aff_commission_seller"] = ( int )$_POST["aff_commission_seller"];
	$params["aff_visits"] = 0;
	$params["aff_signups"] = 0;
	$params["aff_referal"] = 0;
	$params["business"] = ( int )@$_POST["business"];
	$params["vat"] = pvs_result( @$_POST["vat"] );
	$params["payout_limit"] = ( float )@$_POST["payout_limit"];
	$params["avatar"] = '';
	$params["description"] = pvs_result( $_POST["description"] );
	$params["downloads"] = 0;
	$params["downloads_date"] = 0;
	$params["country_checked"] = 0;
	$params["country_checked_date"] = 0;
	$params["vat_checked"] = 0;
	$params["vat_checked_date"] = 0;
	$params["rating"] = 0;

	$id = pvs_add_user( $params );
}

//Payout settings
$sql = "select * from " . PVS_DB_PREFIX . "payout where activ=1";
$ds->open( $sql );
while ( ! $ds->eof ) {
	update_user_meta( $id, $ds->row["svalue"], pvs_result( @$_POST[ $ds->row["svalue"] ] ));
	$ds->movenext();
}

//Upload photos
$user_info = get_userdata($id);

$_FILES['avatar']['name'] = pvs_result_file( @$_FILES['avatar']['name'] );

$ext = strtolower( pvs_get_file_info( @$_FILES['avatar']['name'], "extention" ) );

if ( @$_FILES['avatar']['size'] > 0 and @$_FILES['avatar']['size'] < 20 * 1024 * 1024 ) {
	if ( $ext == "jpg" and ! preg_match( "/text/i", $_FILES['avatar']['type'] ) ) {
		$img = pvs_upload_dir() . "/content/users/" . $user_info -> user_login . "." . $ext;
		move_uploaded_file( $_FILES['avatar']['tmp_name'], $img );

		pvs_easyResize( $img, $img, 100, 150 );
		
		update_user_meta( $id, 'avatar', "/content/users/" . $user_info -> user_login . "." . $ext, true );
	}
}

?>
