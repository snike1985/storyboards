<?php
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
	wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.12.0/jquery-ui.min.js', false, false, false);
	wp_register_script('pvs_request',  pvs_plugins_url() . '/assets/js/JsHttpRequest.js', false, false, false);
	wp_register_script('colorbox',  pvs_plugins_url() . '/assets/js/jquery.colorbox-min.js', false, false, false);
	wp_register_script('bootstrap',  '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js', false, false, false);
	wp_register_script('prettyPhoto',  'https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/js/jquery.prettyPhoto.min.js', false, false, false);
	wp_register_script('wow', 'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js', false, false, false);
	//wp_register_script('jquery-latest', 'http://code.jquery.com/jquery-latest.min.js', false, false, false);
	wp_register_script('menu', get_template_directory_uri() . '/assets/js/menu.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/menu.js'), true);
	wp_register_script('ajax', get_template_directory_uri() . '/assets/js/ajax.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/ajax.js'), true);
	wp_register_script('popup', get_template_directory_uri() . '/assets/js/jquery.popup.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/jquery.popup.js'), true);
	wp_register_script('slider', get_template_directory_uri() . '/assets/js/slider.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/js/slider.js'), true);
	wp_register_script('slick', get_template_directory_uri() . '/assets/slick/slick.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/assets/slick/slick.js'), true);
	wp_register_script('custom_js', get_template_directory_uri() . '/custom.js', false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . '/custom.js'), false);

	wp_register_style('style', get_stylesheet_uri(), false, filemtime(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/style.css'));
	wp_register_style('style-2', get_template_directory_uri() . '/assets/css/style.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/style.css'));
	wp_register_style('reset', get_template_directory_uri() . '/assets/css/reset.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/reset.css'));
	wp_register_style('adaptive', get_template_directory_uri() . '/assets/css/adaptive.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/adaptive.css'));
	wp_register_style('popup', get_template_directory_uri() . '/assets/css/popup.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/css/popup.css'));
	wp_register_style('slick', get_template_directory_uri() . '/assets/slick/slick.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/slick/slick.css'));
	wp_register_style('slick-theme', get_template_directory_uri() . '/assets/slick/slick-theme.css',false, filemtime( realpath(__DIR__ . DIRECTORY_SEPARATOR . '..').'/assets/slick/slick-theme.css'));
	wp_register_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,500,700,900',false, false);
	wp_register_style('font_awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',false, false);
	wp_register_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css',false, false);
	wp_register_style('themes_css', get_template_directory_uri() . '/theme.css',false, false);

	//wp_enqueue_script('jquery-latest');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script('menu');

	if( true ) {
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('pvs_request');
		wp_enqueue_script('prettyPhoto');
		wp_enqueue_script('colorbox');
		wp_enqueue_script('wow');
		wp_enqueue_script('custom_js');

		wp_enqueue_style('themes_css');
		wp_enqueue_style('bootstrap');
	}

	wp_enqueue_style('style-2');
	wp_enqueue_style('reset');
	wp_enqueue_style('adaptive');
	wp_enqueue_style('fonts');
	wp_enqueue_style('font_awesome');

	if( is_author() ) {
		wp_enqueue_script('ajax');
	}

	if( is_author() || ( is_front_page() && ! isset( $_GET['search'] ) ) ) {
		wp_enqueue_script('slick');
		wp_enqueue_script('slider');

		wp_enqueue_style('slick');
		wp_enqueue_style('slick-theme');
	}

	if( is_page_template('page-video.php')) {
		wp_enqueue_script('popup');

		wp_enqueue_style('popup');
	}

	wp_enqueue_style('style');
}

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

add_filter( 'gform_submit_button_1', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
	return "<button type=\"submit\" class='send-button' id='gform_submit_button_{$form['id']}'>{$form['button']['text']}</button>";
}

function get_count_storyboards( $author_id = 0 ) {
	return count_user_posts( $author_id, 'storyboard');
}
function curl_get( $url ) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($curl);
	curl_close($curl);
	return $return;
}