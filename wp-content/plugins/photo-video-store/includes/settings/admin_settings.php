<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$pvs_menu_admin = array();
$pvs_menu_admin_name = array();
$pvs_menu_admin_icon = array();
$pvs_menu_admin_url = array();
$pvs_submenu_admin = array();
$pvs_submenu_admin_url = array();

$pvs_menu_admin[] = "dashboard";
$pvs_menu_admin_name[] = pvs_word_lang( "Dashboard" );
$pvs_menu_admin_icon[] = "dashicons-dashboard";
$pvs_menu_admin_url[] = "/dashboard/index.php";

$pvs_menu_admin[] = "orders";
$pvs_menu_admin_name[] = pvs_word_lang( "orders" );
$pvs_menu_admin_icon[] = "dashicons-cart";
$pvs_menu_admin_url[] = "/orders/index.php";

$pvs_menu_admin[] = "catalog";
$pvs_menu_admin_name[] = pvs_word_lang( "catalog" );
$pvs_menu_admin_icon[] = "dashicons-format-gallery";
$pvs_menu_admin_url[] = "/catalog/index.php";

if ( @$pvs_global_settings["prints"] == 1 )
{
	$pvs_menu_admin[] = "prints";
	$pvs_menu_admin_name[] = pvs_word_lang( "prints" );
	$pvs_menu_admin_icon[] = "dashicons-book";
	$pvs_menu_admin_url[] = "/prints/index.php";
}

$pvs_menu_admin[] = "users";
$pvs_menu_admin_name[] = pvs_word_lang( "Users" );
$pvs_menu_admin_icon[] = "dashicons-groups";
$pvs_menu_admin_url[] = "/customers/index.php";

$pvs_menu_admin[] = "settings";
$pvs_menu_admin_name[] = pvs_word_lang( "settings" );
$pvs_menu_admin_icon[] = "dashicons-admin-settings";
$pvs_menu_admin_url[] = "/settings/index.php";

if ( @$pvs_global_settings["affiliates"] )
{
	$pvs_menu_admin[] = "affiliates";
	$pvs_menu_admin_name[] = pvs_word_lang( "affiliates" );
	$pvs_menu_admin_icon[] = "dashicons-chart-pie";
	$pvs_menu_admin_url[] = "/affiliates/index.php";
}

//Order submenu

$pvs_submenu_admin["orders_orders"] = pvs_word_lang( "orders" );
$pvs_submenu_admin_url["orders_orders"] = "/orders/index.php";

if ( @$pvs_global_settings["credits"] )
{
	$pvs_submenu_admin["orders_credits"] = pvs_word_lang( "credits" );
	$pvs_submenu_admin_url["orders_credits"] = "/credits/index.php";
}

if ( @$pvs_global_settings["subscription"] )
{
	$pvs_submenu_admin["orders_subscription"] = pvs_word_lang( "subscription" );
	$pvs_submenu_admin_url["orders_subscription"] = "/subscription_list/index.php";
}

if ( @$pvs_global_settings["invoices"] )
{
	$pvs_submenu_admin["orders_invoices"] = pvs_word_lang( "Invoices" );
	$pvs_submenu_admin_url["orders_invoices"] = "/invoices/index.php";
}

$pvs_submenu_admin["orders_payments"] = pvs_word_lang( "payments" );
$pvs_submenu_admin_url["orders_payments"] = "/payments/index.php";

$pvs_submenu_admin["orders_coupons"] = pvs_word_lang( "coupons" );
$pvs_submenu_admin_url["orders_coupons"] = "/coupons/index.php";

if ( @$pvs_global_settings["userupload"] )
{
	$pvs_submenu_admin["orders_commission"] = pvs_word_lang( "commission manager" );
	$pvs_submenu_admin_url["orders_commission"] = "/commission/index.php";
}

if ( PVS_LICENSE != 'Free' and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["orders_carts"] = pvs_word_lang( "Shopping carts" );
	$pvs_submenu_admin_url["orders_carts"] = "/shopping_carts/index.php";
}

if ( ! @$pvs_global_settings["printsonly"] )
{
	$pvs_submenu_admin["orders_downloads"] = pvs_word_lang( "Downloads" );
	$pvs_submenu_admin_url["orders_downloads"] = "/downloads/index.php";
}

//End. Order submenu

//Catalog submenu

$pvs_submenu_admin["catalog_catalog"] = pvs_word_lang( "catalog" );
$pvs_submenu_admin_url["catalog_catalog"] = "/catalog/index.php";

$pvs_submenu_admin["catalog_categories"] = pvs_word_lang( "categories" );
$pvs_submenu_admin_url["catalog_categories"] = "/categories/index.php";



$pvs_submenu_admin["catalog_bulkupload"] = pvs_word_lang( "bulk upload" );
$pvs_submenu_admin_url["catalog_bulkupload"] = "/bulk_upload/index.php";

if ( @$pvs_global_settings["userupload"] )
{
	$pvs_submenu_admin["catalog_upload"] = pvs_word_lang( "upload manager" );
	$pvs_submenu_admin_url["catalog_upload"] = "/upload/index.php";

	if ( @$pvs_global_settings["examination"] )
	{
		$pvs_submenu_admin["catalog_exam"] = pvs_word_lang( "seller examination" );
		$pvs_submenu_admin_url["catalog_exam"] = "/exam/index.php";
	}
}



if ( @$pvs_global_settings["reviews"] )
{
	$pvs_submenu_admin["catalog_comments"] = pvs_word_lang( "reviews" );
	$pvs_submenu_admin_url["catalog_comments"] = "/comments/index.php";
}

if ( @$pvs_global_settings["search_history"] )
{
	$pvs_submenu_admin["catalog_search"] = pvs_word_lang( "search history" );
	$pvs_submenu_admin_url["catalog_search"] = "/search/index.php";
}

if ( @$pvs_global_settings["lightboxes"] )
{
	$pvs_submenu_admin["catalog_lightboxes"] = pvs_word_lang( "Lightboxes" );
	$pvs_submenu_admin_url["catalog_lightboxes"] = "/lightboxes/index.php";
}

if ( @$pvs_global_settings["collections"] )
{
	$pvs_submenu_admin["catalog_collections"] = pvs_word_lang( "Collections" );
	$pvs_submenu_admin_url["catalog_collections"] = "/collections/index.php";
}

//End. Catalog submenu


//Prints submenu
if ( @$pvs_global_settings["prints"] )
{
	$pvs_submenu_admin["prints_prints"] = pvs_word_lang( "prints and products" );
	$pvs_submenu_admin_url["prints_prints"] = "/prints/index.php";
	
	$pvs_submenu_admin["prints_types"] = pvs_word_lang( "types" );
	$pvs_submenu_admin_url["prints_types"] = "/prints_types/index.php";

	$pvs_submenu_admin["prints_productsoptions"] = pvs_word_lang( "Products options" );
	$pvs_submenu_admin_url["prints_productsoptions"] =
		"/products_options/index.php";

	$pvs_submenu_admin["prints_printscategories"] = pvs_word_lang( "Prints categories" );
	$pvs_submenu_admin_url["prints_printscategories"] =
		"/prints_categories/index.php";

	if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ] ) {
		$pvs_submenu_admin["prints_printspreviews"] = pvs_word_lang( "Prints previews" );
		$pvs_submenu_admin_url["prints_printspreviews"] = "/prints_previews/index.php";


		$pvs_submenu_admin["prints_pwinty"] = pvs_word_lang( "pwinty prints service" );
		$pvs_submenu_admin_url["prints_pwinty"] = "/prints_pwinty/index.php";

		$pvs_submenu_admin["prints_fotomoto"] = pvs_word_lang( "Fotomoto prints service" );
		$pvs_submenu_admin_url["prints_fotomoto"] = "/prints_fotomoto/index.php";

		$pvs_submenu_admin["prints_printful"] = pvs_word_lang( "Printful prints service" );
		$pvs_submenu_admin_url["prints_printful"] = "/prints_printful/index.php";
	}
}
//End. Prints submenu


//User submenu

$pvs_submenu_admin["users_customers"] = pvs_word_lang( "customers" );
$pvs_submenu_admin_url["users_customers"] = "/customers/index.php";

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["users_documents"] = pvs_word_lang( "Documents" );
	$pvs_submenu_admin_url["users_documents"] = "/documents/index.php";
}

$pvs_submenu_admin["users_notifications"] = pvs_word_lang( "notifications" );
$pvs_submenu_admin_url["users_notifications"] = "/notifications/index.php";

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["users_newsletter"] = pvs_word_lang( "newsletter" );
	$pvs_submenu_admin_url["users_newsletter"] = "/newsletter/index.php";
}

if ( @$pvs_global_settings["support"] )
{
	$pvs_submenu_admin["users_support"] = pvs_word_lang( "support" );
	$pvs_submenu_admin_url["users_support"] = "/support/index.php";
}

if ( @$pvs_global_settings["messages"] )
{
	$pvs_submenu_admin["users_messages"] = pvs_word_lang( "messages" );
	$pvs_submenu_admin_url["users_messages"] = "/messages/index.php";
}

if ( @$pvs_global_settings["testimonials"] )
{
	$pvs_submenu_admin["users_testimonials"] = pvs_word_lang( "testimonials" );
	$pvs_submenu_admin_url["users_testimonials"] = "/testimonials/index.php";
}

$pvs_submenu_admin["users_contacts"] = pvs_word_lang( "contacts" );
$pvs_submenu_admin_url["users_contacts"] = "/contacts/index.php";

//End. User submenu

//Settings submenu

$pvs_submenu_admin["settings_site"] = pvs_word_lang( "site settings" );
$pvs_submenu_admin_url["settings_site"] = "/settings/index.php";

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ] ) {
	$pvs_submenu_admin["settings_storage"] = pvs_word_lang( "file storage" );
	$pvs_submenu_admin_url["settings_storage"] = "/storage/index.php";
}

$pvs_submenu_admin["settings_languages"] = pvs_word_lang( "languages" );
$pvs_submenu_admin_url["settings_languages"] = "/languages/index.php";

$pvs_submenu_admin["settings_countries"] = pvs_word_lang( "Countries" );
$pvs_submenu_admin_url["settings_countries"] = "/countries/index.php";

$pvs_submenu_admin["settings_currency"] = pvs_word_lang( "currency" );
$pvs_submenu_admin_url["settings_currency"] = "/currency/index.php";

$pvs_submenu_admin["settings_payments"] = pvs_word_lang( "payments" );
$pvs_submenu_admin_url["settings_payments"] = "/gateways/index.php";

$pvs_submenu_admin["settings_stockapi"] = pvs_word_lang( "Stock API" );
$pvs_submenu_admin_url["settings_stockapi"] = "/stock_api/index.php";

$pvs_submenu_admin["settings_watermark"] = pvs_word_lang( "watermark" );
$pvs_submenu_admin_url["settings_watermark"] = "/watermark/index.php";

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["settings_recognition"] = pvs_word_lang( "Image recognition" );
	$pvs_submenu_admin_url["settings_recognition"] = "/recognition/index.php";
}

if ( @$pvs_global_settings["royalty_free"] )
{
	$pvs_submenu_admin["settings_licenses"] = pvs_word_lang( "royalty free" ) .
		" - " . pvs_word_lang( "license" );
	$pvs_submenu_admin_url["settings_licenses"] = "/licenses/index.php";

	$pvs_submenu_admin["settings_prices"] = pvs_word_lang( "royalty free" ) . " - " .
		pvs_word_lang( "prices" );
	$pvs_submenu_admin_url["settings_prices"] = "/prices/index.php";
}

if ( @$pvs_global_settings["rights_managed"] )
{
	$pvs_submenu_admin["settings_rightsmanaged"] = pvs_word_lang( "rights managed" ) .
		" - " . pvs_word_lang( "license" );
	$pvs_submenu_admin_url["settings_rightsmanaged"] = "/rights_managed/index.php";
}

if ( @$pvs_global_settings["invoices"] )
{
	$pvs_submenu_admin["settings_invoices"] = pvs_word_lang( "Invoices" );
	$pvs_submenu_admin_url["settings_invoices"] = "/invoices_settings/index.php";
}

$pvs_submenu_admin["settings_taxes"] = pvs_word_lang( "taxes" );
$pvs_submenu_admin_url["settings_taxes"] = "/tax/index.php";

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["settings_taxeseu"] = pvs_word_lang( "EU VAT law compliance" );
	$pvs_submenu_admin_url["settings_taxeseu"] = "/tax_eu/index.php";
}

$pvs_submenu_admin["settings_shipping"] = pvs_word_lang( "shipping" );
$pvs_submenu_admin_url["settings_shipping"] = "/shipping/index.php";

$pvs_submenu_admin["settings_checkout"] = pvs_word_lang( "checkout" );
$pvs_submenu_admin_url["settings_checkout"] = "/checkout/index.php";

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["settings_documents"] = pvs_word_lang( "Documents types" );
	$pvs_submenu_admin_url["settings_documents"] = "/documents_types/index.php";
}

$pvs_submenu_admin["settings_couponstypes"] = pvs_word_lang( "types of coupons" );
$pvs_submenu_admin_url["settings_couponstypes"] = "/coupons_types/index.php";

if ( PVS_LICENSE != 'Free' and PVS_LICENSE != 'Lite' and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ]  ) {
	$pvs_submenu_admin["settings_payout"] = pvs_word_lang( "refund" );
	$pvs_submenu_admin_url["settings_payout"] = "/payout/index.php";
}

$pvs_submenu_admin["settings_content_types"] = pvs_word_lang( "content type" );
$pvs_submenu_admin_url["settings_content_types"] = "/content_types/index.php";

$pvs_submenu_admin["settings_signup"] = pvs_word_lang( "sign up" );
$pvs_submenu_admin_url["settings_signup"] = "/signup/index.php";

$pvs_submenu_admin["settings_networks"] = pvs_word_lang( "social networks" );;
$pvs_submenu_admin_url["settings_networks"] = "/networks/index.php";

if ( @$pvs_global_settings["userupload"] )
{
	$pvs_submenu_admin["settings_sellercategories"] = pvs_word_lang( "customer categories" );
	$pvs_submenu_admin_url["settings_sellercategories"] =
		"/seller_categories/index.php";
}

if ( @$pvs_global_settings["subscription"] )
{
	$pvs_submenu_admin["settings_subscription"] = pvs_word_lang( "subscription" );
	$pvs_submenu_admin_url["settings_subscription"] = "/subscription/index.php";
}

if ( @$pvs_global_settings["credits"] )
{
	$pvs_submenu_admin["settings_creditstypes"] = pvs_word_lang( "credits" );
	$pvs_submenu_admin_url["settings_creditstypes"] = "/credits_types/index.php";
}

if ( @$pvs_global_settings["model"] )
{
	$pvs_submenu_admin["settings_models"] = pvs_word_lang( "model property release" );
	$pvs_submenu_admin_url["settings_models"] = "/models/index.php";
}



if ( @$pvs_global_settings["allow_video"] )
{
	$pvs_submenu_admin["settings_video"] = pvs_word_lang( "video" );
	$pvs_submenu_admin_url["settings_video"] = "/video/index.php";
}

if ( @$pvs_global_settings["allow_audio"] )
{
	$pvs_submenu_admin["settings_audio"] = pvs_word_lang( "audio" );
	$pvs_submenu_admin_url["settings_audio"] = "/audio/index.php";
}

if ( PVS_LICENSE != 'Free'  and @$pvs_global_settings[ 'ac' . 'ti' .'va' . 'tion' ] ) {
	if ( @$pvs_global_settings["allow_video"] or @$pvs_global_settings["allow_audio"] )
	{
		$pvs_submenu_admin["settings_ffmpeg"] = "FFMPEG & Sox";
		$pvs_submenu_admin_url["settings_ffmpeg"] = "/ffmpeg/index.php";
	}
}

$pvs_submenu_admin["settings_home"] = pvs_word_lang( "home page" );
$pvs_submenu_admin_url["settings_home"] = "/home/index.php";

//End. Settings submenu

//Affiliates submenu
if ( @$pvs_global_settings["affiliates"] )
{
	$pvs_submenu_admin["affiliates_stats"] = pvs_word_lang( "stats" );
	$pvs_submenu_admin_url["affiliates_stats"] = "/affiliates/index.php";

	$pvs_submenu_admin["affiliates_commission"] = pvs_word_lang( "users earnings" );
	$pvs_submenu_admin_url["affiliates_commission"] = "/affiliates/commission.php";

	$pvs_submenu_admin["affiliates_payout"] = pvs_word_lang( "refund" );
	$pvs_submenu_admin_url["affiliates_payout"] = "/affiliates/payout.php";

	$pvs_submenu_admin["affiliates_settings"] = pvs_word_lang( "settings" );
	$pvs_submenu_admin_url["affiliates_settings"] = "/affiliates/settings.php";
}
//End. Affiliates submenu

?>