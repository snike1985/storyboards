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

register_nav_menus(array(
	'menu' => 'menu',
	'menu-mobile' => 'menu-mobile',
	'menu-footer' => 'menu-footer'
));

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    add_theme_support('excerpt');
    add_theme_support('author');
    add_theme_support('editor');
    add_theme_support('title');
}
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'preview', 85, 53, true );
	add_image_size( 'storyboard', 540, 404, true );
}

add_action('wp_enqueue_scripts', 'add_js');
function add_js() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, false, false);
	wp_register_script('jquery-latest', 'http://code.jquery.com/jquery-latest.min.js', false, false, false);
	wp_register_script('menu', get_template_directory_uri() . '/assets/js/menu.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/menu.js'), true);
	wp_register_script('ajax', get_template_directory_uri() . '/assets/js/ajax.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/ajax.js'), true);
	wp_register_script('popup', get_template_directory_uri() . '/assets/js/jquery.popup.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/jquery.popup.js'), true);

	wp_register_style('style', get_stylesheet_uri(), false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/style.css'));
	wp_register_style('style-2', get_template_directory_uri() . '/assets/css/style.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/style.css'));
	wp_register_style('reset', get_template_directory_uri() . '/assets/css/reset.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/reset.css'));
	wp_register_style('adaptive', get_template_directory_uri() . '/assets/css/adaptive.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/adaptive.css'));
	wp_register_style('popup', get_template_directory_uri() . '/assets/css/popup.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/popup.css'));
	wp_register_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900',false, false);
	wp_register_style('bootstrap', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',false, false);


	wp_enqueue_script('jquery-latest');
	wp_enqueue_script('jquery');
	wp_enqueue_script('menu');



	wp_enqueue_style('style-2');
	wp_enqueue_style('reset');
	wp_enqueue_style('adaptive');
	wp_enqueue_style('fonts');
	wp_enqueue_style('bootstrap');
	wp_enqueue_style('style');

	if(is_author()) {
		wp_enqueue_script('ajax');
		wp_enqueue_script('popup');

		wp_enqueue_style('popup');
	}
}

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
add_filter( 'gform_submit_button_1', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
	return "<button type=\"submit\" class='send-button' id='gform_submit_button_{$form['id']}'>{$form['button']['text']}</button>";
}

function get_count_storyboards($author_id = 0) {
	return count_user_posts($author_id, 'storyboard');
}