<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["robokassa_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

// 1.
// Payment of the set sum with a choice of currency on merchant site

// registration info (login, password #1)
$mrh_login = $pvs_global_settings["robokassa_account"];
$mrh_pass1 = $pvs_global_settings["robokassa_password"];

// number of order
$inv_id = $product_id;

// order description
$inv_desc = $product_type;

// sum of order
$out_summ = pvs_price_format( $product_total, 2 );

// code of goods
$shp_item = $product_type;

// default payment e-currency
$in_curr = "";

// language
$culture = "ru";

// encoding
$encoding = "utf-8";

// generate signature
$crc = md5( "$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item" );



print "<form action='https://auth.robokassa.ru/Merchant/Index.aspx' method=POST  name='process' id='process'>
  <input type=hidden name=MrchLogin value=$mrh_login>
  <input type=hidden name=OutSum value=$out_summ>
  <input type=hidden name=InvId value=$inv_id>
  <input type=hidden name=Desc value='$inv_desc'>
  <input type=hidden name=SignatureValue value=$crc>
  <input type=hidden name=IncCurrLabel value=$in_curr>
  <input type=hidden name=Culture value=$culture>
  <input type=hidden name=Shp_item value='$shp_item'>
  </form>";

pvs_show_payment_page( 'footer' );
?>