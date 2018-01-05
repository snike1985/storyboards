<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


$sql = "select * from " . PVS_DB_PREFIX . "galleries where user_id='" . ( int )
	get_current_user_id() . "' and id=" . ( int )@$_REQUEST["id"] .
	" order by data desc";
	
$dr->open( $sql );
if ( $dr->eof ) {
	exit();
}

?>

<script>
//Print's quantity
function quantity_change(value,quantity_limit) {
	quantity = $("#quantity").val()*1+value;
	
	if(quantity< 0) {
		quantity = 0;
	}
	
	if(quantity> quantity_limit && quantity_limit != -1) {
		quantity = quantity_limit;
	}
	
	$("#quantity").val(quantity);
}
</script>


<?php
include ( "profile_top.php" );?>

<input type="button" value="<?php echo pvs_word_lang( "back" )?>" class="profile_button" onClick="location.href='<?php echo (site_url( ) );?>/printslab-order/?id=<?php echo ( int )$_GET["id"] ?>'">

<h1><?php echo pvs_word_lang( "prints lab" )?> &mdash; <?php echo pvs_word_lang( "photo" )?> #<?php echo ( int )$_GET["photo"] ?></h1>


<?php
$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" . ( int )
	$_GET["id"] . " and id=" . ( int )$_GET["photo"] . " order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$preview_url = "/content/galleries/" . ( int )$_GET["id"] . "/thumb" .
		$rs->row["id"] . "_2.jpg";

	$size = getimagesize( pvs_upload_dir() .
		"/content/galleries/" . ( int )$_GET["id"] . "/" . $rs->row["photo"] );
	$default_width = $size[0];
	$default_height = $size[1];

	if ( $size[0] < $size[1] ) {
		$iframe_width = round( $size[0] * $pvs_global_settings["thumb_width2"] / $size[1] );
		$iframe_height = $pvs_global_settings["thumb_width2"];

		$width_prints2 = round( $size[0] * $pvs_global_settings["prints_previews_width"] /
			$size[1] );
		$height_prints2 = $pvs_global_settings["prints_previews_width"];
	} else {
		$iframe_width = $pvs_global_settings["thumb_width2"];
		$iframe_height = round( $size[1] * $pvs_global_settings["thumb_width2"] / $size[0] );

		$width_prints2 = $pvs_global_settings["prints_previews_width"];
		$height_prints2 = round( $size[1] * $pvs_global_settings["prints_previews_width"] /
			$size[0] );
	}

	if ( ! file_exists( pvs_upload_dir() . $preview_url ) ) {
		pvs_easyResize( pvs_upload_dir() . "/content/galleries/" .
			( int )$_GET["id"] . "/" . $rs->row["photo"], pvs_upload_dir() . $preview_url,
			100, $width_prints2 );
	}

	$print_info = pvs_get_print_preview_info( ( int )$_GET["print_id"] );

	$preview_url = pvs_upload_dir('baseurl') . $preview_url;
	
	$pvs_theme_content[ 'big_width_prints' ] = $iframe_width;
	$pvs_theme_content[ 'big_height_prints' ] = $iframe_height;
	$pvs_theme_content[ 'image' ] = $preview_url;
			
	include( PVS_PATH . "includes/prints/" . $print_info["preview"] . "_big.php" );
	
	$print_content = $pvs_theme_content[ 'print_content' ];

	$flag_resize = 0;
	$resize_min = $pvs_global_settings["thumb_width2"];
	;
	$resize_max = $pvs_global_settings["prints_previews_width"];
	$resize_value = $pvs_global_settings["thumb_width2"];
	;

	$sql = "select * from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int )@$_REQUEST["print_id"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$flag_resize = $ds->row["resize"];
		$resize_min = $ds->row["resize_min"];
		$resize_max = $ds->row["resize_max"];
		$resize_value = $ds->row["resize_value"];
	}

	if ( $default_width < $default_height ) {
		$photo_size = $default_height;
	} else {
		$photo_size = $default_width;
	}

	$cart_flag = false;
	$printslab_flag = true;
	$id_parent = (int) $_GET["photo"];
	include ( "content_print_properties.php" );
	?>
	
	<script src="<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/colorpicker.js"></script>
	<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/eye.js'></script>
	<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/utils.js'></script>
	<link href="<?php echo pvs_plugins_url()?>/assets/js/colorpicker/css/colorpicker.css" rel="stylesheet">
	<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">
	<link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'>
	<script>
	function show_more(value) {
		$.colorbox({width:"700",height:"500", href:value});
	}
	
	
	//Print type
	print_type = "<?php echo $print_info["preview"] ?>";
	
	//Big preview size
	print_width = <?php echo $iframe_width
?>;
	print_height = <?php echo $iframe_height
?>;
	print_image ="<?php echo $preview_url
?>";
	
	//Overlay image size
	image_width = <?php echo $width_prints2
?>;
	image_height = <?php echo $height_prints2
?>;
	
	//Default image size
	default_width = <?php echo $default_width
?>;
	default_height = <?php echo $default_height
?>;
	
	//Site root
	site_root = "<?php echo pvs_plugins_url() . "/"?>";
	site_root2 = "<?php echo (site_url());?>/";
	
	//Default settings
	$(function() {
		<?php echo $default_js_functions
?>
	});
	
	
	//Image preupload
	$.preloadImages = function() {
	  for (var i = 0; i < arguments.length; i++) {
		$("<img />").attr("src", arguments[i]);
	  }
	}
	$.preloadImages(print_image);
	
	<?php echo $preloaded_frames
?>
	<?php echo $preloaded_tshirts
?>
	
	</script>
	<script src="<?php echo pvs_plugins_url()?>/includes/prints/prints.js"></script>
	
	
	<div style="margin:0px auto 40px auto;display:table;">
		<?php echo $print_content
?>
		<div class="print_wrap"></div>
		<div class="print_border_left print_display"></div>
		<div class="print_border_top print_display"></div>
		<div class="print_border_right print_display"></div>
		<div class="print_border_bottom print_display"></div>
		<div class="print_border_left2 print_display"></div>
		<div class="print_border_top2 print_display"></div>
		<div class="print_border_right2 print_display"></div>
		<div class="print_border_bottom2 print_display"></div> 
		
		<div class="clearfix"></div>
	</div>
	<hr />
	
	<?php
	if ( $flag_resize ) {
?>
		<h4><?php echo pvs_word_lang( "Image size" )?>:</h4>
		<script>
			$(document).ready(function() {
	 $("#slide1").slider({
		min: <?php echo $resize_min
?>,
		max: <?php echo $resize_max
?>,
		value: <?php echo $resize_value
?>,
		slide: function( event, ui ) {
		$( "#print_size" ).val(ui.value);
		show_image();
				}
	});
			});
		</script>

		<div id="slide1"></div> 
		<input type="hidden" id="print_size" value="<?php echo $resize_value
?>">
	<?php
	}
?>
	
	<form name="print_form" id="print_form" action="<?php echo (site_url( ) );?>/printslab-add-to-cart2/"  enctype="multipart/form-data">
	<?php echo $prints_content
?>
	
	<hr />
	<div class="row">
		<div class="col-lg-6 col-md-6">
			<h4><?php echo pvs_word_lang( "price" )?></h4>
			<div id="print_price" class="price" style="font-size:17px"><?php echo pvs_currency( 1 ) . pvs_price_format( $price, 2, true ) . ' ' .
		pvs_currency( 2 )?></div>
		</div>
		<div class="col-lg-6 col-md-6">
			<input type="hidden" name="printslab" value="1">
			<input type="hidden" name="id" value="<?php echo ( int )$_GET["id"] ?>">
			<input type="hidden" name="print_id" value="<?php echo ( int )$_GET["print_id"] ?>">
			<input type="hidden" name="photo" value="<?php echo ( int )$_GET["photo"] ?>">
			<input type="submit" class="btn btn-success" value="<?php echo pvs_word_lang( "add to cart" )?>" class="isubmit">
		</div>
	</div>
	</form>
	
	
	
	<?php
}

include ( "profile_bottom.php" );
?>