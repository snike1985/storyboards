<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<div class="page_internal">
<h1><?php echo pvs_word_lang( "languages" )?></h1>

<div id="lang_box">
<ul>
<?php
$lang_list = "";

foreach ( $pvs_site_langs as $key => $value ) {
	$lt = "";
	$sel = "selected";
	if ( $lng != $key ) {
		$lt = "style='opacity:0.7'";
		$sel = "";
	}

	$lng3 = strtolower( $key );
	if ( $lng3 == "chinese traditional" ) {
		$lng3 = "chinese";
	}
	if ( $lng3 == "chinese simplified" ) {
		$lng3 = "chinese";
	}
	if ( $lng3 == "afrikaans formal" ) {
		$lng3 = "afrikaans";
	}
	if ( $lng3 == "afrikaans informal" ) {
		$lng3 = "afrikaans";
	}

	$lang_list .= "<li><a href='" . site_url() . "/language-select/?lang=" . $key .
		"'><img src='" . pvs_plugins_url() . "/assets/images/languages/" . $lng3 . ".gif' " . $lt . ">" . $key .
		"</a></li>";
}
echo ( $lang_list );?>
</ul>
</div>
</div>
<?php
?>