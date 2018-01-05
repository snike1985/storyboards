<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_customers" );
?>



<div class="back"><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>


<h1><?php echo pvs_word_lang( "user" )?> &mdash; <?php
if ( ! isset( $_GET["id"] ) ) {
	echo ( pvs_word_lang( "add" ) . " " );
} else
{
	echo ( pvs_word_lang( "edit" ) . " " );
}
?></h1>
<div class="box box_padding">

<?php
$user_fields = array();
$user_fields["login"] = "";
$user_fields["name"] = "";
$user_fields["email"] = "";
$user_fields["telephone"] = "";
$user_fields["address"] = "";
$user_fields["country"] = "";
$user_fields["category"] = $pvs_global_settings["userstatus"];
$user_fields["lastname"] = "";
$user_fields["city"] = "";
$user_fields["state"] = "";
$user_fields["zipcode"] = "";
$user_fields["avatar"] = "";
$user_fields["description"] = "";
$user_fields["website"] = "";

if ( $pvs_global_settings["common_account"] ) {
	$user_fields["utype"] = "common";
} else {
	$user_fields["utype"] = "buyer";
}

$user_fields["company"] = "";
$user_fields["newsletter"] = "";
$user_fields["business"] = 0;
$user_fields["vat"] = "";
$user_fields["vat_checked"] = 0;
$user_fields["vat_checked_date"] = 0;
$user_fields["country_checked"] = 0;
$user_fields["country_checked_date"] = 0;
if ( $pvs_global_settings["examination"] ) {
	$user_fields["examination"] = 0;
} else
{
	$user_fields["examination"] = 1;
}
$user_fields["authorization"] = "site";
$user_fields["aff_commission_buyer"] = $pvs_global_settings["buyer_commission"];
$user_fields["aff_commission_seller"] = $pvs_global_settings["seller_commission"];
$user_fields["payout_limit"] = $pvs_global_settings["payout_limit"];
$user_fields["authorization"] = '';
$user_fields["date"] = '';

if ( isset( $_GET["id"] ) ) {
	$user_info = get_userdata((int)$_GET["id"]);
	
	$user_fields["login"] = @$user_info -> user_login;
	$user_fields["name"] = @$user_info -> first_name;
	$user_fields["country"] = @$user_info -> country;
	$user_fields["telephone"] = @$user_info -> telephone;
	$user_fields["address"] =@ $user_info -> address;
	$user_fields["ip"] =@ $user_info -> ip;
	$user_fields["email"] = @$user_info -> user_email;
	$user_fields["lastname"] = @$user_info -> last_name;
	$user_fields["city"] = @$user_info -> city;
	$user_fields["state"] = @$user_info -> state;
	$user_fields["zipcode"] = @$user_info -> zipcode;
	$user_fields["description"] = @$user_info -> description;
	$user_fields["website"] = @$user_info -> user_url;
	$user_fields["utype"] = @$user_info -> utype;
	$user_fields["category"] = @$user_info -> category;
	$user_fields["company"] = @$user_info -> company;
	$user_fields["newsletter"] = @$user_info -> newsletter;
	$user_fields["business"] = @$user_info -> business;
	$user_fields["vat"] = @$user_info -> vat;
	$user_fields["examination"] = @$user_info -> examination;
	$user_fields["authorization"] = @$user_info -> authorization;
	$user_fields["aff_commission_buyer"] = @$user_info -> aff_commission_buyer;
	$user_fields["aff_commission_seller"] = @$user_info -> aff_commission_seller;
	$user_fields["aff_visits"] = @$user_info -> aff_visits;
	$user_fields["aff_signups"] = @$user_info -> aff_signups;
	$user_fields["aff_referal"] = @$user_info -> aff_referal;
	$user_fields["country_checked"] = @$user_info -> country_checked;
	$user_fields["country_checked_date"] = @$user_info -> country_checked_date;
	$user_fields["vat_checked"] = @$user_info -> vat_checked;
	$user_fields["vat_checked_date"] = @$user_info -> vat_checked_date;
	$user_fields["payout_limit"] = @$user_info -> payout_limit;
	$user_fields["date"] = @$user_info -> user_registered;
}
?>




<script language="javascript">



function check() {
		flag=true
		if(document.getElementById('login_ok').value==-1 || document.getElementById('login_ok').value==0) {
			flag=false;
			document.getElementById('error_login').innerHTML="<span class='error'><?php echo pvs_word_lang( "incorrect field" )?></span>";
		}

		if(document.getElementById('email_ok').value==-1 || document.getElementById('email_ok').value==0) {
			flag=false;
			document.getElementById('error_email').innerHTML="<span class='error'><?php echo pvs_word_lang( "incorrect field" )?></span>";
		}
		return flag;
}


function pvs_check_login(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_check_login&login=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			
			document.getElementById('error_login').innerHTML = data;
			
			if(data=="<span class='error'><?php echo pvs_word_lang( "Error: Username is already in use." )?></span>" || data =="<span class='error'><?php echo pvs_word_lang( "incorrect field" )?></span>")
			{
				document.getElementById('login_ok').value=-1
			}
			else
			{
				document.getElementById('login_ok').value=1
			}
		}
	});
}




function pvs_check_email(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_check_email&email=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			
			document.getElementById('error_email').innerHTML =data;
			if(data=="<span class='error'><?php echo pvs_word_lang( "Error: Email is already in use." )?></span>" || data=="<span class='error'><?php echo pvs_word_lang( "incorrect field" )?></span>")
			{
				document.getElementById('email_ok').value=-1
			}
			else
			{
				document.getElementById('email_ok').value=1
			}
		}
	});
}



function pvs_check_password() {
	if(document.getElementById('password2').value!="") {
		if(document.getElementById('password').value!=document.getElementById('password2').value) {
			document.getElementById('error_password').innerHTML ="<span class='error'><?php echo pvs_word_lang( "not equal" )?></span>";
		}
		else
		{
			document.getElementById('error_password').innerHTML ="";
		}
	}
}



function pvs_check_vat(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_check_vat&status=' + value + '&id=<?php echo ( int )@$_GET["id"] ?>',
		success:function(data){
			if(value == 0)
			{
				$('#vat1').addClass('btn-warning').removeClass('btn-default');
				$('#vat2').removeClass('btn-success').addClass('btn-default');
				$('#vat3').removeClass('btn-danger').addClass('btn-default');
			}
			if(value == 1)
			{
				$('#vat1').removeClass('btn-warning').addClass('btn-default');
				$('#vat2').addClass('btn-success').removeClass('btn-default');
				$('#vat3').removeClass('btn-danger').addClass('btn-default');
			}
			if(value == -1)
			{
				$('#vat1').removeClass('btn-warning').addClass('btn-default');
				$('#vat2').removeClass('btn-success').addClass('btn-default');
				$('#vat3').addClass('btn-danger').removeClass('btn-default');
			}
		}
	});
}


function pvs_check_country(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_check_country&status=' + value + '&id=<?php echo ( int )@$_GET["id"] ?>',
		success:function(data){
			if(value == 0)
			{
				$('#country1').addClass('btn-warning').removeClass('btn-default');
				$('#country2').removeClass('btn-success').addClass('btn-default');
				$('#country3').removeClass('btn-danger').addClass('btn-default');
			}
			if(value == 1)
			{
				$('#country1').removeClass('btn-warning').addClass('btn-default');
				$('#country2').addClass('btn-success').removeClass('btn-default');
				$('#country3').removeClass('btn-danger').addClass('btn-default');
			}
			if(value == -1)
			{
				$('#country1').removeClass('btn-warning').addClass('btn-default');
				$('#country2').removeClass('btn-success').addClass('btn-default');
				$('#country3').addClass('btn-danger').removeClass('btn-default');
			}
		}
	});
}



function pvs_user_login() 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_user_login&id=<?php echo ( int )@$_GET["id"] ?>',
		success:function(data){
			location.href='<?php echo (site_url( ) );?>/profile/';
		}
	});
}

</script>



<?php
if ( isset( $_GET["id"] ) ) {
	$id_param = '&id=' . (int) $_GET["id"];
} else {
	$id_param = '';
}
?>



<form method="post" action="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=add<?php echo $id_param; ?>"  Enctype="multipart/form-data" name="signupform" onsubmit="return check();">

<div class="subheader"><?php echo pvs_word_lang( "common information" )?></div>
<div class="subheader_text">


<div style="float:left;width:300px">

	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "login" )?>:</span>
	<input type="text" id="login2" name="login" value="<?php echo $user_fields["login"] ?>" style="width:200px"  onChange="pvs_check_login(this.value);"><div id="error_login" name="error_login"></div><input type="hidden" id="login_ok" name="login_ok" value="<?php
if ( ! isset( $_GET["id"] ) ) {
?>0<?php
} else
{
?>1<?php
}
?>">
	</div>

<?php
if ( $user_fields["authorization"] == "site" or  $user_fields["authorization"] == "") {
?>	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "password" )?>:</span>
	<input id="password" type="password" name="password" value="<?php
	if ( isset( $_GET["id"] ) ) {
		echo ( "********" );
	}
?>" style="width:200px" onChange="pvs_check_password();">
	<div id="error_password" name="error_password"></div>
	</div>
	

	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "confirm password" )?>:</span>
	<input id="password2" type="password" name="password2" value="<?php
	if ( isset( $_GET["id"] ) ) {
		echo ( "********" );
	}
?>" style="width:200px" onChange="pvs_check_password();">
	<div id="error_password2" name="error_password2"></div>
	</div>
<?php
}
?>

	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "e-mail" )?>:</span>
	<input type="text" id="email" name="email" onChange="pvs_check_email(this.value);" value="<?php echo $user_fields["email"] ?>" style="width:200px"><div id="error_email" name="error_email"></div><input type="hidden" id="email_ok" name="email_ok" value="<?php
if ( ! isset( $_GET["id"] ) ) {
?>0<?php
} else
{
?>1<?php
}
?>">
	</div>
	


	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "newsletter" )?>:</span>
	<input type="checkbox" name="newsletter" <?php
if ( $user_fields["newsletter"] == 1 ) {
	echo ( "checked" );
}
?>>
	</div>
	
	
</div>
<?php
if ( isset( $_GET["id"] ) ) {
?>
<div class="box_stats box box-solid">
	
	<div><b><?php echo pvs_word_lang( "date of registration" )?>:</b> <?php echo $user_fields["date"] ?></div>
	
	<div>
		<b><?php echo pvs_word_lang( "authorization" )?>:</b> 
		<?php
	if ( $user_fields["authorization"] == "site" or $user_fields["authorization"] == "" ) {
		echo ( pvs_word_lang( "website" ) );
	} else {
		if ( $user_fields["authorization"] == "twitter" ) {
			echo ( "<a href='http://www.twitter.com/" . $user_fields["login"] .
				"'>Twitter</a>" );
		}
		if ( preg_match( "/^facebook/i", $user_fields["authorization"] ) ) {
			if ( preg_match( "/^fb/i", $user_fields["login"] ) )
			{
				echo ( "<a href='https://www.facebook.com/app_scoped_user_id/" . str_replace( "fb",
					"", $user_fields["login"] ) . "'>Facebook</a>" );
			} elseif ( preg_match( "/^facebook/i", $user_fields["authorization"] ) )
			{
				echo ( "<a href='https://www.facebook.com/app_scoped_user_id/" . str_replace( "facebook",
					"", $user_fields["authorization"] ) . "'>Facebook</a>" );
			} else
			{
				echo ( "Facebook" );
			}
		}
		if ( $user_fields["authorization"] == "vk" ) {
			echo ( "<a href='http://vk.com/id" . str_replace( "vk", "", $user_fields["login"] ) .
				"'>Vkontakte</a>" );
		}
		if ( $user_fields["authorization"] == "instagram" ) {
			echo ( "<a href='http://instagram.com/" . str_replace( "instagram_", "", $user_fields["login"] ) .
				"'>Instagram</a>" );
		}
		if ( $user_fields["authorization"] == "yandex" ) {
			echo ( "Yandex" );
		}
		if ( $user_fields["authorization"] == "google" ) {
			echo ( "Google" );
		}
	}
?>
	</div>
	
	<?php
	if ( $user_fields["ip"] != '' ) {
	?>
	<div><b>IP:</b> <?php echo $user_fields["ip"] ?></div>
	<?php
	}
	?>
	<?php
	if ( $user_fields["utype"] == "buyer" or $user_fields["utype"] == "common" or $user_fields["utype"] == "administrator" ) {
?>
		<div>
			<b><?php echo pvs_word_lang( "orders" )?>:</b> 
			<a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&search=<?php echo $user_fields["login"] ?>&search_type=login">
			<?php
		$sql = "select count(id) as order_count from " . PVS_DB_PREFIX .
			"orders where user=" . ( int )$_GET["id"];
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			echo ( $rs->row["order_count"] );
		} else {
			echo ( 0 );
		}
?>
			</a>
		</div>
		<?php
		if ( $pvs_global_settings["credits"] ) {
?>
			<div>
			<b><?php
			echo pvs_word_lang( "credits" )?>:</b> 
			<a href="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>&search=<?php
			echo $user_fields["login"] ?>&search_type=login">
			<?php
			$sql = "select sum(quantity) as credits_count from " . PVS_DB_PREFIX .
				"credits_list where user='" . $user_fields["login"] . "'";
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
				echo ( $rs->row["credits_count"] );
			} else
			{
				echo ( 0 );
			}
?>
			</a>
			</div>
			<?php
		}
		if ( $pvs_global_settings["subscription"] ) {
?>
			<div>
			<b><?php
			echo pvs_word_lang( "subscription" )?>:</b> 
			<a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>&search=<?php
			echo $user_fields["login"] ?>&search_type=login">
			<?php
			$sql = "select count(id_parent) as subscription_count from " . PVS_DB_PREFIX .
				"subscription_list where user='" . $user_fields["login"] . "'";
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
				echo ( $rs->row["subscription_count"] );
			} else
			{
				echo ( 0 );
			}
?>
			</a>
			</div>
			<?php
		}
	}
	if ( $user_fields["utype"] == "seller" or $user_fields["utype"] == "common" or $user_fields["utype"] == "administrator" ) {
		$userbalance = 0;
		$sales_count = 0;

		$sql = "select user,total from " . PVS_DB_PREFIX . "commission where user=" . ( int )
			$_GET["id"];
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			$userbalance += $ds->row["total"];
			if ( $ds->row["total"] > 0 )
			{
				$sales_count++;
			}
			$ds->movenext();
		}
?>
			<div>
				<b><?php echo pvs_word_lang( "sales" )?>:</b> <a href="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&search=<?php echo $user_fields["login"] ?>&search_type=login&pub_type=plus"><?php echo $sales_count
?></a>
			</div>
			<div>
				<b><?php echo pvs_word_lang( "commission" )?>:</b> <a href="<?php echo(pvs_plugins_admin_url('commision/index.php'));?>&d=3"><?php echo pvs_currency( 1, false )?><?php echo $userbalance
?>
				 <?php echo pvs_currency( 2, false )?></a>
			</div>
		<?php
	}
	if ( $user_fields["utype"] == "affiliate" or $user_fields["utype"] == "common" or $user_fields["utype"] == "administrator" ) {
		$affbalance = 0;

		$sql = "select total from " . PVS_DB_PREFIX .
			"affiliates_signups where aff_referal=" . ( int )$_GET["id"];
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			$affbalance += $ds->row["total"];
			$ds->movenext();
		}
?>
			<div>
				<b><?php echo pvs_word_lang( "affiliate" )?> - <?php echo pvs_word_lang( "commission" )?>:</b> <a href="<?php echo(pvs_plugins_admin_url('affiliates/index.php'));?>&search=<?php echo $user_fields["login"] ?>&search_type=affiliate"><?php echo pvs_currency( 1, false )?><?php echo $affbalance
?>
				 <?php echo pvs_currency( 2, false )?></a>
			</div>
		<?php
	}
	if ( $user_fields["utype"] == "buyer" or $user_fields["utype"] == "common" or $user_fields["utype"] == "administrator" ) {
		$downloads_count = 0;

		$sql = "select count(id) as downloads_count from " . PVS_DB_PREFIX .
			"downloads where user_id=" . pvs_user_login_to_id( $user_fields["login"] ) .
			" group by user_id";
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$downloads_count = $ds->row["downloads_count"];
		}
?>
		<div>
			<b><?php echo pvs_word_lang( "downloads" )?>:</b> <a href="<?php echo(pvs_plugins_admin_url('downloads/index.php'));?>&search=<?php echo $user_fields["login"] ?>&search_type=user"><?php echo $downloads_count
?></a>
		</div>
		<?php
	}
?>
<hr />
<?php
	$documents_count = 0;
	$sql = "select count(id) as documents_count from " . PVS_DB_PREFIX .
		"documents where user_id=" . pvs_user_login_to_id( $user_fields["login"] ) .
		" group by user_id";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$documents_count = $ds->row["documents_count"];
	}
?>
	<div>
		<b><?php echo pvs_word_lang( "Documents" )?>:</b> <a href="<?php echo(pvs_plugins_admin_url('documents/index.php'));?>&search=<?php echo $user_fields["login"] ?>"><?php echo $documents_count
?></a>
	</div>
	
	
	<div>
		<b><?php echo pvs_word_lang( "country" )?>:</b> <?php echo $user_fields["country"] ?></a>
	</div>
		<a href="javascript:pvs_check_country(0)" id="country1" class="btn btn-<?php
	if ( ( int )$user_fields["country_checked"] == 0 ) {
		echo ( "warning" );
	} else {
		echo ( "default" );
	}
?> btn-xs"><?php echo pvs_word_lang( "Not checked" )?></a>
		<a href="javascript:pvs_check_country(1)" id="country2" class="btn btn-<?php
	if ( ( int )$user_fields["country_checked"] == 1 ) {
		echo ( "success" );
	} else {
		echo ( "default" );
	}
?>  btn-xs"><?php echo pvs_word_lang( "Valid" )?></a>
		<a href="javascript:pvs_check_country(-1)" id="country3" class="btn btn-<?php
	if ( ( int )$user_fields["country_checked"] == -1 ) {
		echo ( "danger" );
	} else {
		echo ( "default" );
	}
?>  btn-xs"><?php echo pvs_word_lang( "Invalid" )?></a>
		<?php
	if ( $user_fields["country_checked_date"] != 0 ) {
?>
			<br><small><?php echo pvs_word_lang( "Last check" )?>: <?php echo pvs_show_time_ago( $user_fields["country_checked_date"] )?></small>
			<?php
	}
?>
	<?php
	if ( $user_fields["vat"] != "" ) {
		$vatCountry = substr( $user_fields["vat"], 0, 2 );
		$vatNumber = substr( $user_fields["vat"], 2 );
		$apiURL = "http://ec.europa.eu/taxation_customs/vies/viesquer.do?ms=" . $vatCountry .
			"&vat=" . $vatNumber;
?>
		<hr />
		<div>
		<b><?php echo pvs_word_lang( "VAT number" )?>:</b> <?php echo $user_fields["vat"] ?> <a href="<?php echo "$apiURL";
?>" target="blank" class="btn btn-xs btn-primary"><?php echo pvs_word_lang( "Online check" )?></a>
		</div>
		<div>
		<a href="javascript:pvs_check_vat(0)" id="vat1" class="btn btn-<?php
		if ( ( int )$user_fields["vat_checked"] == 0 ) {
			echo ( "warning" );
		} else {
			echo ( "default" );
		}
?> btn-xs"><?php echo pvs_word_lang( "Not checked" )?></a>
		<a href="javascript:pvs_check_vat(1)" id="vat2" class="btn btn-<?php
		if ( ( int )$user_fields["vat_checked"] == 1 ) {
			echo ( "success" );
		} else {
			echo ( "default" );
		}
?>  btn-xs"><?php echo pvs_word_lang( "Valid" )?></a>
		<a href="javascript:pvs_check_vat(-1)" id="vat3" class="btn btn-<?php
		if ( ( int )$user_fields["vat_checked"] == -1 ) {
			echo ( "danger" );
		} else {
			echo ( "default" );
		}
?>  btn-xs"><?php echo pvs_word_lang( "Invalid" )?></a>
		<?php
		if ( $user_fields["vat_checked_date"] != 0 ) {
?>
			<br><small><?php
			echo pvs_word_lang( "Last check" )?>: <?php
			echo pvs_show_time_ago( $user_fields["vat_checked_date"] )?></small>
			<?php
		}
?>
		</div>
		<?php
	}
?>
	<div style="margin-top:15px">
		<hr />
		<a class="btn btn-success" href="javascript:pvs_user_login()"><?php echo pvs_word_lang( "login on the frontend" )?></a><br>
		<small>* <?php echo pvs_word_lang( "You will be logged out from the admin panel." )?></small>
	</div>
</div>
<?php
}
?>
	
</div>




<div class="subheader"><?php echo pvs_word_lang( "customer information" )?></div>
<div class="subheader_text">
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "type" )?>:</span>
	<input type="radio" name="utype" <?php
if ( $user_fields["utype"] == "buyer" ) {
	echo ( "checked" );
}
?> onClick="show_fields('buyer')" value="buyer"> <?php echo pvs_word_lang( "buyer" )?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="utype" <?php
if ( $user_fields["utype"] == "seller" ) {
	echo ( "checked" );
}
?> onClick="show_fields('seller')" value="seller"> <?php echo pvs_word_lang( "seller" )?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="utype" <?php
if ( $user_fields["utype"] == "affiliate" ) {
	echo ( "checked" );
}
?> onClick="show_fields('affiliate')" value="affiliate"> <?php echo pvs_word_lang( "affiliate" )?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="utype" <?php
if ( $user_fields["utype"] == "common" or  $user_fields["utype"] == "administrator") {
	echo ( "checked" );
}
?> onClick="show_fields('common')" value="common"> <?php echo pvs_word_lang( "common" )?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	
	
	<div class='admin_field' id="field_category">
	<span><?php echo pvs_word_lang( "category" )?>:</span>
	<select name="category" style="width:200px">
		<?php
$sql = "select name from " . PVS_DB_PREFIX . "user_category order by name";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = "";
	if ( $rs->row["name"] == $user_fields["category"] ) {
		$sel = "selected";
	}
?>
			<option value="<?php echo $rs->row["name"] ?>" <?php echo $sel
?>><?php echo $rs->row["name"] ?></option>
			<?php
	$rs->movenext();
}
?>
	</select>
	</div>
	
	<div class='admin_field' id="field_examination">
	<span><?php echo pvs_word_lang( "examination" )?>:</span>
	<input type="checkbox" name="examination" <?php
if ( $user_fields["examination"] == 1 ) {
	echo ( "checked" );
}
?>>
	</div>
	
	<div class='admin_field' id="field_payout_limit">
	<span><?php echo pvs_word_lang( "Balance threshold for payout" )?> (<?php echo pvs_get_currency_code(1)
?>):</span>
	<input type="text" name="payout_limit" value="<?php echo pvs_price_format( $user_fields["payout_limit"], 2 )?>" style="width:200px">
	</div>
	
	
	<?php
$sql = "select * from " . PVS_DB_PREFIX . "payout where activ=1";
$ds->open( $sql );
while ( ! $ds->eof ) {

if (isset($_GET["id"])) {
	$payout_value = get_user_meta( (int)$_GET["id"], $ds->row["svalue"], true );
} else {
	$payout_value = '';
}

?>
		<div class='admin_field payout_field' id="field_<?php echo $ds->row["svalue"] ?>">
				<span><?php echo $ds->row["title"] ?>:</span>

				<input type="text" name="<?php echo $ds->row["svalue"] ?>" value="<?php echo $payout_value;?>" style="width:200px">
		</div>
		<?php
	$ds->movenext();
}
?>
	
	<div class='admin_field' id="field_aff_commission_buyer">
	<span>Buyer signup commission:</span>
	<input type="text" name="aff_commission_buyer" value="<?php echo (int)$user_fields["aff_commission_buyer"] ?>" style="width:200px">
	</div>
	
	<div class='admin_field' id="field_aff_commission_seller">
	<span>Seller signup commission:</span>
	<input type="text" name="aff_commission_seller" value="<?php echo (int)$user_fields["aff_commission_seller"] ?>" style="width:200px">
	</div>


</div>


<div class="subheader"><?php echo pvs_word_lang( "contacts information" )?></div>
<div class="subheader_text">

	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "first name" )?>:</span>
	<input type="text" name="name" value="<?php echo $user_fields["name"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "last name" )?>:</span>
	<input type="text" name="lastname" value="<?php echo $user_fields["lastname"] ?>" style="width:300px">
	</div>
	

	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "telephone" )?>:</span>
	<input type="text" name="telephone" value="<?php echo $user_fields["telephone"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "country" )?>:</span>
	<select name="country" style="width:300px">
	<option value=""></option>
			<?php
$sql = "select name from " . PVS_DB_PREFIX .
	"countries where activ=1 order by priority,name";
$dd->open( $sql );
while ( ! $dd->eof ) {
	$sel = "";
	if ( $dd->row["name"] == $user_fields["country"] ) {
		$sel = "selected";
	}
?>
				<option value="<?php echo $dd->row["name"] ?>" <?php echo $sel
?>><?php echo $dd->row["name"] ?></option>
				<?php
	$dd->movenext();
}
?>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "city" )?>:</span>
	<input type="text" name="city" value="<?php echo $user_fields["city"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "state" )?>:</span>
	<input type="text" name="state" value="<?php echo $user_fields["state"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "zipcode" )?>:</span>
	<input type="text" name="zipcode" value="<?php echo $user_fields["zipcode"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "address" )?>:</span>
	<textarea name="address" style="width:300px;height:50px"><?php echo $user_fields["address"] ?></textarea> 
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "company" )?>:</span>
	<input type="text" name="company" value="<?php echo $user_fields["company"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "website" )?>:</span>
	<input type="text" name="website" value="<?php echo $user_fields["website"] ?>" style="width:300px">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "description" )?>:</span>
	<textarea name="description" style="width:300px;height:50px"><?php echo $user_fields["description"] ?></textarea> 
	</div>
	
	<div class="admin_field">
	<span><?php echo pvs_word_lang( "status" )?></span>
	<select name="business" style="width:310px">
		<option value="0" <?php
if ( $user_fields["business"] == 0 ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "individual" )?></option>
		<option value="1" <?php
if ( $user_fields["business"] == 1 ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "business" )?></option>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "VAT number" )?>:</span>
	<input type="text" name="vat" value="<?php echo $user_fields["vat"] ?>" style="width:300px">
	</div>

</div>


<div class="subheader"><?php echo pvs_word_lang( "photo" )?></div>
<div class="subheader_text">

<table>
<tr valign="top">


<td style="padding-right:10px">
<?php
if (isset($_GET["id"])) {
	echo get_avatar((int)$_GET["id"]);
	
	if ( file_exists (pvs_upload_dir() . "/content/users/" . @$user_info -> user_login . ".jpg") ) {
		?>
		<div><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=delete_photo&id=<?php echo((int)$_GET["id"]);?>"><?php echo pvs_word_lang( "delete" );?></a></div>	
		<?php 
	}
}
?>
</td>

<td>
<div style="margin-top:5px"><input type="file" name="avatar"></div>
<div class="smalltext"><small>*.jpg</small></div>
</td>
</tr>
</table>


</div>

<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
		</div>
	</div>


</form>

</div>


<script>

function show_fields(types) {
	if(types=="buyer") {
		document.getElementById('field_category').style.display="none";
		document.getElementById('field_examination').style.display="none";
		document.getElementById('field_aff_commission_buyer').style.display="none";
		document.getElementById('field_aff_commission_seller').style.display="none";		
		document.getElementById('field_payout_limit').style.display="none";
		$('.payout_field').css("display","none");
										
	}
	if(types=="seller") {
		document.getElementById('field_category').style.display="block";
		document.getElementById('field_examination').style.display="block";
		document.getElementById('field_payout_limit').style.display="block";
		document.getElementById('field_aff_commission_buyer').style.display="none";
		document.getElementById('field_aff_commission_seller').style.display="none";
		$('.payout_field').css("display","block");
	}
	if(types=="affiliate") {
		document.getElementById('field_category').style.display="none";
		document.getElementById('field_examination').style.display="none";
		document.getElementById('field_payout_limit').style.display="block";
		document.getElementById('field_aff_commission_buyer').style.display="block";
		document.getElementById('field_aff_commission_seller').style.display="block";
		$('.payout_field').css("display","block");
	}
	if(types=="common" || types=="administrator") {
		document.getElementById('field_category').style.display="block";
		document.getElementById('field_examination').style.display="block";
		document.getElementById('field_payout_limit').style.display="block";
		document.getElementById('field_aff_commission_buyer').style.display="block";
		document.getElementById('field_aff_commission_seller').style.display="block";
		$('.payout_field').css("display","block");
	}
}

show_fields('<?php echo $user_fields["utype"] ?>');
</script>
