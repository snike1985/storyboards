<?php
//required actions
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wlwmanifest_link');
// close required actions
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'signuppageheaders');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
// Отключаем сам REST API
add_filter('rest_enabled', '__return_false');
// Отключаем фильтры REST API
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('auth_cookie_malformed', 'rest_cookie_collect_status');
remove_action('auth_cookie_expired', 'rest_cookie_collect_status');
remove_action('auth_cookie_bad_username', 'rest_cookie_collect_status');
remove_action('auth_cookie_bad_hash', 'rest_cookie_collect_status');
remove_action('auth_cookie_valid', 'rest_cookie_collect_status');
remove_filter('rest_authentication_errors', 'rest_cookie_check_errors', 100);
// Отключаем события REST API
remove_action('init', 'rest_api_init');
remove_action('rest_api_init', 'rest_api_default_filters', 10, 1);
remove_action('parse_request', 'rest_api_loaded');
// Отключаем Embeds связанные с REST API
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
//remove_action('wp_head', 'wp_oembed_add_host_js');
add_filter('the_content', 'do_shortcode');
add_filter('wpcf7_form_elements', 'do_shortcode');
add_filter( 'the_content', 'wpautop' );

register_nav_menus(array('menu' => 'menu'));

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

/*add_action( 'wp_enqueue_scripts', 'custom_clean_head' );
function custom_clean_head() {
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
}*/

add_action('wp_enqueue_scripts', 'add_js');
function add_js() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/assets/js/vendors/jquery-2.2.1.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/jquery-2.2.1.min.js'), true);
	wp_register_script('index', get_template_directory_uri() . '/assets/js/index.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/index.min.js'), true);
	wp_register_script('swiper', get_template_directory_uri() . '/assets/js/vendors/swiper.jquery.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/swiper.jquery.min.js'), true);
	wp_register_script('ScrollToPlugin', get_template_directory_uri() . '/assets/js/vendors/ScrollToPlugin.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/ScrollToPlugin.min.js'), true);
	wp_register_script('TweenMax', get_template_directory_uri() . '/assets/js/vendors/TweenMax.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/TweenMax.min.js'), true);
//	wp_register_script('isotope', get_template_directory_uri() . '/assets/js/vendors/isotope.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/isotope.js'), true);
	wp_register_script('perfect-scrollbar', get_template_directory_uri() . '/assets/js/vendors/perfect-scrollbar.jquery.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/perfect-scrollbar.jquery.min.js'), true);
	wp_register_script('instafeed', get_template_directory_uri() . '/assets/js/vendors/instafeed.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/instafeed.min.js'), true);
	wp_register_script('ScrollMagic', get_template_directory_uri() . '/assets/js/vendors/ScrollMagic.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/ScrollMagic.min.js'), true);
	wp_register_script('animation', get_template_directory_uri() . '/assets/js/vendors/animation.gsap.min.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/vendors/animation.gsap.min.js'), true);

	wp_register_style('style', get_stylesheet_uri(), false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/style.css'));
	wp_register_style('index', get_template_directory_uri() . '/assets/css/index.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/index.css'));
	wp_register_style('swiper', get_template_directory_uri() . '/assets/css/swiper.min.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/swiper.min.css'));
	wp_register_style('works-page', get_template_directory_uri() . '/assets/css/works-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/works-page.css'));
	wp_register_style('blog-page', get_template_directory_uri() . '/assets/css/blog-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/blog-page.css'));
	wp_register_style('perfect-scrollbar', get_template_directory_uri() . '/assets/css/perfect-scrollbar.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/perfect-scrollbar.css'));
	wp_register_style('article-page', get_template_directory_uri() . '/assets/css/article-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/article-page.css'));
	wp_register_style('case-page', get_template_directory_uri() . '/assets/css/case-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/case-page.css'));
	wp_register_style('contacts-page', get_template_directory_uri() . '/assets/css/contacts-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/contacts-page.css'));
	wp_register_style('about-us-page', get_template_directory_uri() . '/assets/css/about-us-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/about-us-page.css'));
	wp_register_style('landing-page', get_template_directory_uri() . '/assets/css/landing-page.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/landing-page.css'));


	wp_enqueue_script('jquery');
	wp_enqueue_script('ScrollToPlugin');
	wp_enqueue_script('TweenMax');
	wp_enqueue_script('perfect-scrollbar');

	wp_enqueue_style('perfect-scrollbar');


	if(is_front_page()) {
		wp_enqueue_script('ScrollMagic');
		wp_enqueue_script('animation');
		wp_enqueue_script('swiper');
		wp_enqueue_script('instafeed');

		wp_enqueue_style('swiper');
		wp_enqueue_style('index');
	}

	if(is_page_template('page-landing.php')) {
		wp_enqueue_script('swiper');

		wp_enqueue_style('swiper');
		wp_enqueue_style('landing-page');
	}

	if(is_page(5)) {
		wp_enqueue_style('works-page');
	}

	if(is_page(8)) {
		wp_enqueue_script('instafeed');
		wp_enqueue_script('swiper');

		wp_enqueue_style('swiper');
		wp_enqueue_style('about-us-page');
	}

	if(is_page(14)) {
		wp_enqueue_style('contacts-page');
	}

	if(is_home() || is_tag()) {
		wp_enqueue_style('blog-page');
	}

	if(is_singular('post') || is_singular('work')) {
		wp_enqueue_script('swiper');
		wp_enqueue_script('instafeed');

		wp_enqueue_style('swiper');
	  wp_enqueue_style('case-page');
	}

	/*if(is_singular('work')) {
		wp_enqueue_script('swiper');

		wp_enqueue_style('swiper');
		wp_enqueue_style('case-page');
	}*/

	wp_enqueue_script('index');

	wp_enqueue_style('style');
}

function filter_wpcf7_ajax_json_echo( $items, $result ) {
	$items['message'] = do_shortcode($items['message']);
	return $items;
};
add_filter( 'wpcf7_ajax_json_echo', 'filter_wpcf7_ajax_json_echo', 10, 2 );

