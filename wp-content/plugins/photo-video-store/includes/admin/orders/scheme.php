<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );
?><html>
	<head>
	<title><?php echo pvs_word_lang( "Scheme" )?> - <?php echo pvs_result( $_REQUEST["print"] )?> | <?php echo pvs_word_lang( "order" )?> #<?php echo ( int )$_REQUEST["order_id"] ?> | <?php echo pvs_word_lang( "photo" )?> #<?php echo ( int )$_REQUEST["photo_id"] ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<?php
$photo_width = ( int )$_REQUEST["width"];
$photo_height = ( int )$_REQUEST["height"];


if ( $photo_width > $photo_height ) {
	$preview_width = $pvs_global_settings["thumb_width2"];
	$preview_height = round( $preview_width * $photo_height / $photo_width );
} else
{
	$preview_height = $pvs_global_settings["thumb_width2"];
	$preview_width = round( $preview_height * $photo_width / $photo_height );
}
?>
	<style>
	.border
	{
		display:table;
		position:relative;
		margin:40px;
	}
	#bottom_left,#top_left,#bottom_right,#print,#print_x1,#print_y1,#print_x2,#print_y2
	{
		position:absolute;
		font-size:12px;
	}
	
	#print_h
	{
		position:absolute;
		background-color:#000000;
		opacity:0.5;
		filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0.5);
		-moz-opacity: 0.5;
		-khtml-opacity: 0.5;
		width:<?php echo $preview_width
?>px;
		height: <?php echo round( ( ( int )$_REQUEST["y2"] - ( int )$_REQUEST["y1"] ) * $preview_height / $photo_height )?>px;
		border-top: 1px #FFFFFF dashed;
		border-bottom: 1px #FFFFFF dashed;
	}
	
	#print_v
	{
		position:absolute;
		background-color:#000000;
		opacity:0.5;
		filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0.5);
		-moz-opacity: 0.5;
		-khtml-opacity: 0.5;
		width:<?php echo round( ( ( int )$_REQUEST["x2"] - ( int )$_REQUEST["x1"] ) * $preview_width / $photo_width )?>px;
		height: <?php echo $preview_height
?>px;
		border-right: 1px #FFFFFF dashed;
		border-left: 1px #FFFFFF dashed;
	}
	
	#print
	{
		position:absolute;
		background-color:#f90707;
		opacity:0.4;
		filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0.4);
		-moz-opacity: 0.4;
		-khtml-opacity: 0.4;
		width:<?php echo round( ( ( int )$_REQUEST["x2"] - ( int )$_REQUEST["x1"] ) * $preview_width / $photo_width )?>px;
		height: <?php echo round( ( ( int )$_REQUEST["y2"] - ( int )$_REQUEST["y1"] ) * $preview_height / $photo_height )?>px;
	}
	</style>
	</head>
	<body>
	<div class="container">

	<h1><?php echo pvs_word_lang( "order" )?> #<?php echo ( int )$_REQUEST["order_id"] ?></h1>
	<p><b><?php echo pvs_word_lang( "photo" )?>:</b> #<?php echo ( int )$_REQUEST["photo_id"] ?> &mdash; <?php echo $photo_width
?>x<?php echo $photo_height
?>px</p>
	<p><b><?php echo pvs_word_lang( "prints and products" )?>:</b> <?php echo pvs_result( $_REQUEST["print"] )?> &mdash;  <?php echo ( ( int )$_REQUEST["x2"] - ( int )$_REQUEST["x1"] )?>x<?php echo ( ( int )$_REQUEST["y2"] - ( int )$_REQUEST["y1"] )?>px</p>
	
	<br>
	<div class="border">
		<img id="print_preview" src="<?php echo pvs_result( $_REQUEST["preview"] )?>" style="width:<?php echo $preview_width
?>px;height:<?php echo $preview_height
?>px;margin:0px">
		<div id="bottom_left">0</div>
		<div id="top_left"><?php echo $photo_height
?></div>
		<div id="bottom_right"><?php echo $photo_width
?></div>
		<div id="print_h"></div>
		<div id="print_v"></div>
		<div id="print"></div>
		<div id="print_x1"></div>
		<div id="print_y1"></div>
		<div id="print_x2"></div>
		<div id="print_y2"></div>
	</div>
	
	<?php
if ( ! isset( $_REQUEST["stock"] ) ) {
?>
	<img src="<?php echo (site_url( ) );?>/orders-crop/?width=<?php echo ( int )$_REQUEST["width"] ?>&height=<?php echo ( int )$_REQUEST["height"] ?>&x1=<?php echo ( int )$_REQUEST["x1"] ?>&y1=<?php echo ( int )$_REQUEST["y1"] ?>&x2=<?php echo ( int )$_REQUEST["x2"] ?>&y2=<?php echo ( int )$_REQUEST["y2"] ?>&photo=<?php echo urlencode( pvs_result( $_REQUEST["photo"] ) )?>" style="width:<?php echo $preview_width
?>px;margin:40px">
	<?php
}
?>
	
	</div>
	<script>
		function build_scheme() {
			x1_original =<?php echo ( int )$_REQUEST["x1"] ?>;
			y1_original =<?php echo ( int )$_REQUEST["y1"] ?>;
			x2_original =<?php echo ( int )$_REQUEST["x2"] ?>;
			y2_original =<?php echo ( int )$_REQUEST["y2"] ?>;			
			
			x1=<?php echo round( ( int )$_REQUEST["x1"] * $preview_width / $photo_width )?>;
			y1=<?php echo round( ( int )$_REQUEST["y1"] * $preview_height / $photo_height )?>;
			x2=<?php echo round( ( int )$_REQUEST["x2"] * $preview_width / $photo_width )?>;
			y2=<?php echo round( ( int )$_REQUEST["y2"] * $preview_height / $photo_height )?>;
			
			$("#print_h").css("top", y1);
			$("#print_h").css("left", 0);
			
			$("#print_v").css("top", 0);
			$("#print_v").css("left", x1);
			
			$("#print").css("top", y1);
			$("#print").css("left", x1);
			
			$("#top_left").css("top", -5);
			$("#top_left").css("right", $('#print_preview').width()+10);
			
			$("#bottom_left").css("top", $('#print_preview').height()+5);
			$("#bottom_left").css("left", -3);
			
			$("#bottom_right").css("top", $('#print_preview').height()+5);
			$("#bottom_right").css("left", $('#print_preview').width()-15);
			
			if(x1 != 0)
			{
				$("#print_x1").css("top", $('#print_preview').height()+5);
				$("#print_x1").css("left", x1-10);
				$("#print_x1").html(x1_original);
			}
			
			if(x2 != 0)
			{
				$("#print_x2").css("top", $('#print_preview').height()+5);
				$("#print_x2").css("left", x2-10);
				$("#print_x2").html(x2_original);
			}
			
			if(y1 != 0)
			{
				$("#print_y1").css("top", y2-7);
				$("#print_y1").css("right", $('#print_preview').width()+10);
				$("#print_y1").html(<?php echo $photo_height
?>-y2_original);
			}
			
			if(y2 != 0)
			{
				$("#print_y2").css("top", y1-7);
				$("#print_y2").css("right", $('#print_preview').width()+10);
				$("#print_y2").html(<?php echo $photo_height
?>-y1_original);
			}
			
		}
		build_scheme();
	</script>
</body>
</html>


<?php

?>