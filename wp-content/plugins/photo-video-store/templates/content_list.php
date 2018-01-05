<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

include ( "content_list_vars.php" );?>
<style>
/*New styles for the previews. It overwrites style.css file.*/
.item_list 
{ 
	width: <?php echo ( $pvs_global_settings["thumb_width"] + 20 )?>px;
}

.item_list_img
{
	width: <?php echo ( $pvs_global_settings["thumb_width"] + 20 )?>px;
	height: <?php echo ( $pvs_global_settings["thumb_width"] + 20 )?>px;
}

.item_list_text1,.item_list_text2,.item_list_text3,.item_list_text4
{
	width: <?php echo ( $pvs_global_settings["thumb_width"] + 20 )?>px;
}

<?php
if ( @$stock != "site" ) {
?>
	<?php
	if ( @$stock != "fotolia" and @$stock != "depositphotos" and @$stock !=
		"pixabay" ) {
?>
		.iviewed,.idownloaded
		{
		display:none;
		}
	<?php
	}
?>
	
	.action-control,.fa-heart-o,li.hb_lightbox
	{
	display:none;
	}
	
	.preview_listing
	{
	max-width:120px;
	max-height:120px;
	}
	
<?php
}
?>
</style>
<?php
if ( @$prints_flag ) {
?>
	<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">
	<?php
}
?>

<?php

$search_header = '<div class="row" id="search_columns"><div class="col-xl-3 col-lg-3 col-md-3 search_left">';
$search_middle = '</div><div class="col-xl-9 col-lg-9 col-md-9 search_right">';
$search_footer = '</div></div>';
?>


<?php
if ( $showmenu == 1 and $pvs_global_settings["left_search"] ) {
	echo ( $search_header );

	if ( $stock == 'site' ) {
		include ( "content_list_menu.php" );
	}

	if ( $stock == 'istockphoto' ) {
		include ( "content_list_menu_istockphoto.php" );
	}

	if ( $stock == 'shutterstock' ) {
		include ( "content_list_menu_shutterstock.php" );
	}

	if ( $stock == 'fotolia' ) {
		include ( "content_list_menu_fotolia.php" );
	}

	if ( $stock == 'depositphotos' ) {
		include ( "content_list_menu_depositphotos.php" );
	}

	if ( $stock == 'rf123' ) {
		include ( "content_list_menu_123rf.php" );
	}

	if ( $stock == 'bigstockphoto' ) {
		include ( "content_list_menu_bigstockphoto.php" );
	}

	if ( $stock == 'pixabay' ) {
		include ( "content_list_menu_pixabay.php" );
	}

	echo ( $search_middle );
}
//Show menu

?>
<div class="search_header_mobile visible-phone"></div>
<div class="clearfix" style="padding-bottom:10px;margin-bottom:20px;border-bottom:1px solid #f5f5f5">
	<?php
$search_title = pvs_word_lang( "results" );
$search_description = '';
$search_buttons = '';
if ( $id_parent != 0 ) {
	$sql2 = "select id,title from " . PVS_DB_PREFIX .
		"category where id=" . ( int )$id_parent;
	$dr->open( $sql2 );
	if ( ! $dr->eof ) {
		$translate_results = pvs_translate_category( $dr->row["id"], $dr->row["title"],
			"", "" );
		$search_title = $translate_results["title"];
	}
}
if ( isset( $_REQUEST["collection"] ) ) {
	$sql2 = "select title,description,price from " . PVS_DB_PREFIX . "collections where active = 1 and id=" . ( int ) $_REQUEST["collection"];
	$dr->open( $sql2 );
	if ( ! $dr->eof ) {
		$search_title = pvs_word_lang("Collection") . ': ' . $dr->row["title"];
		$search_description = '<p>' . $dr->row["description"] . '<br><b>' . pvs_word_lang("price") . ':</b> <span class="price">' . pvs_currency( 1 ) . pvs_price_format( $dr->row["price"], 2 ) . '  ' . pvs_currency( 2 ) . '</span></p>';
		$search_description .= '<p><a href="' . site_url() . '/shopping-cart-add-collection/?collection=' . ( int ) $_REQUEST["collection"] . '" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"> </i> ' . pvs_word_lang("add to cart") . '</a></p>';
	}
}
if ( isset( $_REQUEST["lightbox"] ) ) {
	$sql2 = "select title from " . PVS_DB_PREFIX . "lightboxes where id=" . ( int ) $_REQUEST["lightbox"];
	$dr->open( $sql2 );
	if ( ! $dr->eof ) {
		$search_title = pvs_word_lang("Lightbox") . ': ' . $dr->row["title"];
		if (!$pvs_global_settings["printsonly"]) {
			$search_description .= '<p><a href="' . site_url() . '/shopping-cart-add-lightbox/?lightbox=' . ( int ) $_REQUEST["lightbox"] . '" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"> </i> ' . pvs_word_lang("add to cart") . '</a> </p>';
		}
	}
}
?>
	<h1><?php echo $search_title
?> <span id="result_count">(<?php
if ( ! $pvs_global_settings["no_calculation"] ) {
	echo ( $record_count );
} else
{
	echo ( " > " . $pvs_global_settings["no_calculation_result"] );
}
?>)</span>
</h1>
<?php echo($search_description);?>
	<div id="search_header2">
	<div id="search_sort">
		<?php
if ( $stock_remote ) {
	$stockmenu = "<select onChange='location.href=this.value' style='width:130px' class='form-control'>";
	foreach ( $mstocks as $key => $value ) {
		if ( $pvs_global_settings[$key . "_api"] ) {
			$sel = "";
			if ( $key == $stock )
			{
				$sel = "selected";
			}

			if ( isset( $_REQUEST["print_id"] ) and ( int )$_REQUEST["print_id"] > 0 )
			{
				$print_var = '&print_id=' . ( int )$_REQUEST["print_id"];
			} else
			{
				$print_var = "";
			}

			$stockmenu .= "<option value='?stock=" . $key . "&search=" . urlencode( @$_REQUEST["search"] ) .
				$print_var . "' " . $sel . ">" . $value . "</option>";
		}
	}
	$stockmenu .= "</select>";
	echo ( $stockmenu );
} else
{
	echo ( $sortmenu );
}
?>
	</div>
	
	<div id="search_contentmenu">
		<?php
$stock_sort = array();

if ( $stock != "site" ) {
	if ( $stock == 'shutterstock' ) {
		$stock_sort = array(
			"popular",
			"newest",
			"relevance",
			"random" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $value == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $value . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}

	if ( $stock == 'fotolia' ) {
		$stock_sort = array();
		$stock_sort['relevance'] = pvs_word_lang( "relevance" );
		$stock_sort['price_1'] = pvs_word_lang( "price" );
		$stock_sort['creation'] = pvs_word_lang( "date" );
		$stock_sort['nb_views'] = pvs_word_lang( "most popular" );
		$stock_sort['nb_downloads'] = pvs_word_lang( "most downloaded" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $key == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $key . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}

	if ( $stock == 'istockphoto' ) {
		$stock_sort = array();
		$stock_sort['best_match'] = pvs_word_lang( "relevance" );
		$stock_sort['most_popular'] = pvs_word_lang( "most popular" );
		$stock_sort['newest'] = pvs_word_lang( "date" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $key == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $key . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}

	if ( $stock == 'depositphotos' ) {
		$stock_sort = array();
		$stock_sort['1'] = pvs_word_lang( "relevance" );
		$stock_sort['4'] = pvs_word_lang( "most downloaded" );
		$stock_sort['5'] = pvs_word_lang( "new" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $key == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $key . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}

	if ( $stock == 'bigstockphoto' ) {
		$stock_sort = array();
		$stock_sort['popular'] = pvs_word_lang( "most popular" );
		$stock_sort['relevant'] = pvs_word_lang( "relevance" );
		$stock_sort['new'] = pvs_word_lang( "date" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $key == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $key . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}

	if ( $stock == 'rf123' ) {
		$stock_sort = array();
		$stock_sort['random'] = pvs_word_lang( "random" );
		$stock_sort['latest'] = pvs_word_lang( "new" );
		$stock_sort['most_downloaded'] = pvs_word_lang( "most downloaded" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $key == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $key . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}

	if ( $stock == 'pixabay' ) {
		$stock_sort = array();
		$stock_sort['popular'] = pvs_word_lang( "most popular" );
		$stock_sort['latest'] = pvs_word_lang( "new" );

		$vars_sort = pvs_build_variables( "sort", "" );
		$sortmenu = "<select onChange='location.href=this.value' style='width:160px' class='form-control'>";

		foreach ( $stock_sort as $key => $value ) {
			$sel = "";
			if ( $key == @$_REQUEST["sort"] )
			{
				$sel = "selected";
			}
			$sortmenu .= "<option value='" . $vars_sort . "&sort=" . $key . "' " . $sel .
				">" . pvs_word_lang( $value ) . "</option>";
		}

		$sortmenu .= "</select>";
		echo ( $sortmenu );
	}
} else
{
	if ( $stock_remote ) {
		echo ( $sortmenu );
	} else {
		echo ( $contentmenu );
	}
}
?>
	</div>

	<div id="search_items"><?php echo $itemsmenu
?></div>
	<?php
$flow_count = 0;
if ( $pvs_global_settings["grid"] ) {
	$flow_count++;
}
if ( $pvs_global_settings["fixed_width"] ) {
	$flow_count++;
}
if ( $pvs_global_settings["fixed_height"] ) {
	$flow_count++;
}

if ( $flow_count > 1 and ( int )@$_REQUEST["print_id"] == 0 ) {
?>
		<div id="search_flow_menu">
			<?php
	if ( $pvs_global_settings["grid"] ) {
?>
	<a href="<?php echo pvs_build_variables( "flow", "" )?>&flow=0"><img src="<?php echo( get_bloginfo( 'template_url' ) ); ?>/assets/images/view0.gif" class='<?php
		if ( $flow == 0 ) {
			echo ( "active" );
		} else {
			echo ( "disabled" );
		}
?>'></a>
	<?php
	}
	if ( $pvs_global_settings["fixed_width"] ) {
?>
	<a href="<?php echo pvs_build_variables( "flow", "" )?>&flow=1"><img src="<?php echo( get_bloginfo( 'template_url' ) ); ?>/assets/images/view1.gif" class='<?php
		if ( $flow == 1 ) {
			echo ( "active" );
		} else {
			echo ( "disabled" );
		}
?>'></a>
	<?php
	}
	if ( $pvs_global_settings["fixed_height"] ) {
?>
	<a href="<?php echo pvs_build_variables( "flow", "" )?>&flow=2"><img src="<?php echo( get_bloginfo( 'template_url' ) ); ?>/assets/images/view2.gif" class='<?php
		if ( $flow == 2 ) {
			echo ( "active" );
		} else {
			echo ( "disabled" );
		}
?>'></a>
	<?php
	}
?>
		</div>
	<?php
}
?>
	
	<?php
if ( $pvs_global_settings["auto_paging"] ) {
?>
		<div id="search_autopaging_menu"><input type="checkbox" name="autopaging" <?php
	if ( $autopaging == 1 ) {
		echo ( "checked" );
	}
?> onClick="location.href='<?php echo pvs_build_variables( "autopaging", "" )?>&autopaging=<?php
	if ( $autopaging == 1 ) {
		echo ( 0 );
	} else {
		echo ( 1 );
	}
?>'">&nbsp;<?php echo pvs_word_lang( "auto" )?></div>
	<?php
}
if ( $pvs_global_settings["left_search"] ) {
?>
		<div id="search_show_menu" style="margin-top:5px"><input type="checkbox" name="showmenu" <?php
	if ( $showmenu == 1 ) {
		echo ( "checked" );
	}
?> onClick="location.href='<?php echo pvs_build_variables( "showmenu", "" )?>&showmenu=<?php
	if ( $showmenu == 1 ) {
		echo ( 0 );
	} else {
		echo ( 1 );
	}
?>'">&nbsp;<?php echo pvs_word_lang( "menu" )?></div>
	<?php
}
?>
	</div>
	<?php
if ( $record_count > $kolvo and $autopaging == 0 ) {
?>
		<!--<div id="search_paging"><?php echo $paging_text
?></div>-->
		<?php
}
?>
	
</div>
<div class="search_header_mobile visible-phone"></div>




<?php
if ( $flow == 1 ) {
?>
	<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/jquery.masonry.min.js"></script>
	<script>
	$(document).ready(function(){
		$('#flow_body').masonry({
  		itemSelector: '.home_box'
		});
		
		$('.home_preview').each(function(){


     		$(this).animate({opacity:'1.0'},1);
   			$(this).mouseover(function(){
     		$(this).stop().animate({opacity:'0.6'},600);
    		});
    		$(this).mouseout(function(){
    		$(this).stop().animate({opacity:'1.0'},300);
    		});

    		
    		$(".hb_cart").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);

    		});

    		$(".hb_cart").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
 		
    		<?php
	if ( @$stock == "site" ) {
?>
    		 $(".hb_lightbox").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);
    		});

    		$(".hb_lightbox").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
    		<?php
	}
?>
    		
    		 $(".hb_free").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);
    		});

    		$(".hb_free").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
        

		});
	});
	</script>
	<?php
}

if ( $flow == 2 ) {
?>
	<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/collageplus/jquery.collagePlus.min.js"></script>
	<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/collageplus/extras/jquery.removeWhitespace.js"></script>
    <script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/collageplus/extras/jquery.collageCaption.js"></script>
	<script>
	$(document).ready(function(){
	
	

	
		refreshCollagePlus();
		
		$('.home_preview').each(function(){
     		$(this).animate({opacity:'1.0'},1);
   			$(this).mouseover(function(){
     		$(this).stop().animate({opacity:'0.6'},600);
    		});
    		$(this).mouseout(function(){
    		$(this).stop().animate({opacity:'1.0'},300);
    		});
    	});
	});
	

	
	function refreshCollagePlus() {
    	$('.item_list_page').removeWhitespace().collagePlus({
        	'targetHeight'    : <?php echo $pvs_global_settings["height_flow"] ?>,
            'fadeSpeed'       : "slow",
            'effect'          : 'default',
            'direction'       : 'vertical',
            'allowPartialLastRow'       : true
    	});
	}
	
	// This is just for the case that the browser window is resized
    var resizeTimer = null;
    $(window).bind('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(refreshCollagePlus, 200);
    });

	</script>
	<style>

	.item_list_page img{
    	margin:10px;
    	padding:0px;
    	display:inline-block;
    	vertical-align:bottom;
    	opacity:1;
	}
	</style>
	<link rel="stylesheet" type="text/css" href="<?php echo pvs_plugins_url()?>/assets/js/collageplus/css/transitions.css" media="all" />
	<?php
}

if ( $autopaging == 1 ) {
?>
	<script>
	str=2;
	flag_auto=true;
	res=" ";
	
	function auto_pvs_paging(page) {
		str=page;
	
    	var req = new JsHttpRequest();
   		 // Code automatically called on load finishing.
    	req.onreadystatechange = function() {
        if (req.readyState == 4) {
 		if(page==1)
 		{
			document.getElementById('flow_body').innerHTML =req.responseText;
			res=req.responseText;
		}
		else
		{
			document.getElementById('flow_body').innerHTML = document.getElementById('flow_body').innerHTML + req.responseText;
			res=req.responseText;
			check_carts('<?php echo pvs_word_lang( "in your cart" )?>');
		}

		<?php
	if ( $flow == 1 ) {
?>
			$('#flow_body').masonry({
  			itemSelector: '.home_box'
			});
		
			$('#flow_body').masonry('reload') ;
		<?php
	}
	if ( $flow == 2 ) {
?>
			refreshCollagePlus();
			<?php
	}
?>
		
		
		$('.home_preview').each(function(){


     		$(this).animate({opacity:'1.0'},1);
   			$(this).mouseover(function(){
     		$(this).stop().animate({opacity:'0.6'},600);
    		});
    		$(this).mouseout(function(){
    		$(this).stop().animate({opacity:'1.0'},300);
    		});

    		
    		$(".hb_cart").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);

    		});

    		$(".hb_cart").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
    		
    		$(".hb_cart2").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);
    		});

    		$(".hb_cart2").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
 		
    		
    		 $(".hb_lightbox").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);
    		});

    		$(".hb_lightbox").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
    		
    		 $(".hb_free").mouseover(function(){
     			$(this).stop().animate({ opacity: 1}, 600);
    		});

    		$(".hb_free").mouseout(function(){
    			$(this).stop().animate({ opacity: 0.5}, 600);
    		});
        

		});


        }
    }
    req.open(null, '<?php echo site_url()?>/content-list-paging/', true);
    req.send( {<?php echo @$flow_vars
?>,str: str,id_parent:<?php echo (int)@$id_parent
?>} );
    str++;

	}
	
	
	$(document).ready(function(){
		$(window).scroll(function(){
			if($(document).height() - $(window).height() - $(window).scrollTop() <150) 
    		{
    			if(flag_auto)
    			{
    	flag_auto=false;
    	if(res!="")
    	{
    		auto_pvs_paging(str);
    	}
    			}
    		}
    		else
    		{
    			flag_auto=true;
    		}
		});
	});
	</script>
	<?php
}
?>


<div class='item_list_page' id="flow_body">
	<?php
$search_content = pvs_word_lang( "not found" );

if ( $stock == 'site' ) {
	include ( "content_list_items.php" );
}

if ( $stock == 'istockphoto' ) {
	include ( "content_list_istockphoto.php" );
}

if ( $stock == 'shutterstock' ) {
	include ( "content_list_shutterstock.php" );
}

if ( $stock == 'fotolia' ) {
	include ( "content_list_fotolia.php" );
}

if ( $stock == 'depositphotos' ) {
	include ( "content_list_depositphotos.php" );
}

if ( $stock == 'rf123' ) {
	include ( "content_list_123rf.php" );
}

if ( $stock == 'bigstockphoto' ) {
	include ( "content_list_bigstockphoto.php" );
}

if ( $stock == 'pixabay' ) {
	include ( "content_list_pixabay.php" );
}

//Show result
echo ( $search_content );?>
</div>

<script>
check_carts('<?php echo pvs_word_lang( "in your cart" )?>');
</script>


<?php
//Stock results count
if ( $stock != 'site' ) {
	$paging_text = pvs_paging( ( int )@$stock_result_count, $str, $kolvo, $kolvo2,
		site_url() . "/", pvs_build_variables( "str", "", false ), false, true );

	if ( ( int )@$stock_result_count > $kolvo and @$autopaging == 0 ) {
?>
	<div id="search_footer">
		<div id="search_paging2"><?php echo $paging_text
?></div>
	</div>
	<?php
	}
?>
	<script>
		function show_results_count() {
			$('#result_count').html('(<?php echo ( int )@$stock_result_count
?>)')
		}
		show_results_count()
	</script>
	<?php
} else
{
	if ( $record_count > $kolvo and @$autopaging == 0 ) {
?>
	<div id="search_footer">
		<div id="search_paging2"><?php echo $paging_text
?></div>
	</div>
	<?php
	}
}
?>


<?php
if ( $showmenu == 1 and $pvs_global_settings["left_search"] ) {
	echo ( $search_footer );
}
?>

