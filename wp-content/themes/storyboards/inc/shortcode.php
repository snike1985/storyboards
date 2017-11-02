<?php

function time_function($attr, $content = '') {
	return date('Y');
}

function register_shortcodes(){
	add_shortcode('time', 'time_function');
}

add_action( 'init', 'register_shortcodes');
