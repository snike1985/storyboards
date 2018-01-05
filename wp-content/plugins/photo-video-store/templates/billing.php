<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );



if ( isset( $_REQUEST["type"] ) ) {
	$_SESSION["billing_type"] = $_REQUEST["type"];
}

if ( isset( $_POST["credits"] ) ) {
	$_SESSION["billing_id"] = ( int )$_POST["credits"];
}

if ( isset( $_POST["subscription"] ) ) {
	$_SESSION["billing_id"] = ( int )$_POST["subscription"];
}
?>


<h1><?php echo pvs_word_lang( "buy " . pvs_result( $_SESSION["billing_type"] ) )?></h1>

<div class="login_header">

<div style="float:right;">[ <a href="<?php echo (site_url( ) );?>/<?php echo pvs_result( $_SESSION["billing_type"] )?>/?d=1"><?php echo pvs_word_lang( "change" )?></a> ]</div>	

<h2 style="margin-top:30px"><?php echo pvs_word_lang( "order" )?></h2></div>

<?php
include ( "billing_content.php" );?>


<?php
if ( ! isset( $_SESSION["coupon_code"] ) ) {
?>
	<div class="login_header" style="margin-top:30px"><h2><?php echo pvs_word_lang( "coupon" )?></h2></div>

	<?php
	if ( isset( $_GET["coupon"] ) ) {
		echo ( "<p><b>Error. The coupon doesn't exist.</b></p>" );
	}
?>

	<div class="form_field" id="coupon_field">
	<form method="post" action="<?php echo (site_url( ) );?>/billing-coupon/">
	<?php echo pvs_word_lang( "code" )?>:&nbsp;&nbsp;
	<input type="text" name="coupon" style="width:150px" class="ibox form-control">
	<input type="submit" value="Ok" class="isubmit">
	</form>
	</div>
<?php
}
?>
	

<?php
$user_info = get_userdata(get_current_user_id());

if ( ! isset( $_SESSION["billing_firstname"] ) ) {
	$_SESSION["billing_firstname"] = @$user_info -> first_name;
}

if ( ! isset( $_SESSION["billing_lastname"] ) ) {
	$_SESSION["billing_lastname"] = @$user_info -> last_name;
}

if ( ! isset( $_SESSION["billing_address"] ) ) {
	$_SESSION["billing_address"] = @ $user_info -> address;
}

if ( ! isset( $_SESSION["billing_city"] ) ) {
	$_SESSION["billing_city"] = @$user_info -> city;
}

if ( ! isset( $_SESSION["billing_zip"] ) ) {
	$_SESSION["billing_zip"] = @$user_info -> zipcode;
}

if ( ! isset( $_SESSION["billing_country"] ) ) {
	$_SESSION["billing_country"] = @$user_info -> country;
}

if ( ! isset( $_SESSION["billing_state"] ) ) {
	$_SESSION["billing_state"] = @$user_info -> state;
}




if ( ( @$_REQUEST["type"] == "credits" and $pvs_global_settings["checkout_credits_billing"] ) or
	( @$_REQUEST["type"] == "subscription" and $pvs_global_settings["checkout_subscription_billing"] ) ) {
?>

<div class="login_header"><h2 style="margin-top:50px"><?php echo pvs_word_lang( "billing address" )?></h2></div>

<script>
	form_fields=new Array('billing_firstname','billing_lastname','billing_city','billing_country','billing_zip','billing_address','billing_state');
	fields_emails=new Array(0,0,0,0,0,0);
	error_message="<?php echo pvs_word_lang( "Incorrect field" )?>";
</script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>


<form method="post"  Enctype="multipart/form-data"  action="<?php echo (site_url( ) );?>/billing-payment/" name="billingform"  onSubmit="return my_form_validate();">



<div class="form_field">
<span><?php echo pvs_word_lang( "first name" )?></b></span>
<input class="ibox form-control" type="text" name="billing_firstname"  id="billing_firstname" value="<?php echo $_SESSION["billing_firstname"] ?>" style="width:400px">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "last name" )?></b></span>
<input class="ibox form-control" type="text" name="billing_lastname"  id="billing_lastname" value="<?php echo $_SESSION["billing_lastname"] ?>" style="width:400px">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "address" )?></b></span>
<textarea class="ibox form-control" name="billing_address" id="billing_address" style="width:400px;" rows="2"><?php echo $_SESSION["billing_address"] ?></textarea>
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "city" )?></b></span>
<input class="ibox form-control" type="text" name="billing_city" id="billing_city"  value="<?php echo $_SESSION["billing_city"] ?>" style="width:400px">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "state" )?></b></span>
<input class="ibox form-control" type="text" name="billing_state" id="billing_state"  value="<?php echo $_SESSION["billing_state"] ?>" style="width:400px">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "zipcode" )?></b></span>
<input class="ibox form-control" type="text" name="billing_zip" id="billing_zip" value="<?php echo $_SESSION["billing_zip"] ?>" style="width:400px">
</div>

<div class="form_field">
<span><?php echo pvs_word_lang( "country" )?></b></span>
<?php
	if ( ! $pvs_global_settings["eu_tax"] ) {
?>
<select name="billing_country" id="billing_country" style="width:400px;" class="ibox form-control"><option value=""></option>
			<?php
		$sql = "select name from " . PVS_DB_PREFIX .
			"countries where activ=1 order by priority,name";
		$dd->open( $sql );
		while ( ! $dd->eof ) {
			$sel = "";
			if ( $dd->row["name"] == $_SESSION["billing_country"] )
			{
				$sel = "selected";
			}
?>
	<option value="<?php
			echo $dd->row["name"] ?>" <?php
			echo $sel
?>><?php
			echo $dd->row["name"] ?></option>
			<?php
			$dd->movenext();
		}
?>
			</select>
<?php
	} else {
?>
<?php echo $_SESSION["billing_country"] ?>
<input type="hidden" name="billing_country" id="billing_country" value="<?php echo $_SESSION["billing_country"] ?>">
<?php
	}
?>
</div>





<input class="isubmit" type="submit" value="<?php echo pvs_word_lang( "next step" )?>" style="margin-top:30px">
</form>

<?php
} else
{
?>

<form method="post"  Enctype="multipart/form-data"  action="<?php echo (site_url( ) );?>/billing-payment/" name="billingform">

<input class="isubmit" type="submit" value="<?php echo pvs_word_lang( "next step" )?>" style="margin-top:30px">
</form>
<?php
}
?>





<?php
include ( "profile_bottom.php" );
?>