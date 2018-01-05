<?php
/**
 * Plugin Name: Photo Video Store
 * Plugin URI: https://www.cmsaccount.com/
 * Description: Sell photo, video, audio, vector digital files online. Prints store.
 * Version: 17.12
 * Author: CMSaccount
 * Author URI: https://www.cmsaccount.com/
 * Author Email: sales@cmsaccount.com
 * Text Domain: photo-video-store
 * Domain Path: languages
 * License: Commercial
 *
 * @package PhotoVideoStore
 * @category Core
 * @author CMSaccount
 */
if ( ! defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

//Constants
define( 'PVS_NAME', 'PVS' );
define( 'PVS_VERSION', '17.12' );
define( 'PVS_LICENSE', 'Lite' );
define( 'PVS_DOMAIN', 'photo-video-store' );
define( 'PVS_DB_PREFIX', 'pvs_' );
define( 'PVS_PATH', plugin_dir_path( __FILE__ ) );
define( "PVS_UPLOAD_DIRECTORY", "/content" );
define( "PVS_PAGE_NUMBER", 7 );

global $wpdb;


//Create db tables if they don't exist
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/mysqldb.php';
register_activation_hook( __FILE__, 'pvs_db' );
function pvs_db(){
	require_once plugin_dir_path( __FILE__ ) . '/includes/functions/db.php';
}


//Functions
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/functions.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/upload.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/show.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/rights_managed.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/ajax_admin.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/functions/template.php';


//Settings
require_once plugin_dir_path( __FILE__ ) . '/includes/settings/settings.php';


//Languages
add_filter('locale','pvs_set_lang');  

$mo_file_path = plugin_dir_path( __FILE__ ) . '/languages/' . PVS_DOMAIN . '-' .
	get_locale() . '.mo';
if ( file_exists ($mo_file_path) ) {
	load_textdomain( PVS_DOMAIN, $mo_file_path );
}


//Upload directories
register_activation_hook( __FILE__, 'pvs_create_upload_folders' );


//.htaccess
register_activation_hook( __FILE__, 'pvs_set_htaccess' );


//Admin menu
require_once plugin_dir_path( __FILE__ ) . '/includes/settings/admin_settings.php';
add_action( 'admin_menu', 'pvs_get_admin_menu' );


//Admin js scripts + css
add_action( 'admin_enqueue_scripts', 'pvs_admin_js_css' );


//Rewrite rules
register_activation_hook( __FILE__, 'pvs_rewrite_rules' );
add_action('query_vars','pvs_rewrite_vars');


//Cookies
add_action( 'init', 'pvs_set_cookies' );


//Session start
add_action('init', 'pvs_session_start');


//User login:
add_filter('login_redirect', 'pvs_admin_default_page');


//Avatar
add_filter( 'get_avatar' , 'pvs_get_avatar' , 1 , 5 );


//Admin notification
add_action( 'wp_login', 'pvs_admin_notifications', 99 );
?>
