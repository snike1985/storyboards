<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$category_id = 0;
if ( isset( $_GET["id"] ) ) {
	$category_id = ( int )$_GET["id"];
}
?>
<br>
<div class="row">
	<div class="col-md-8">
		<h1><?php echo pvs_word_lang( "categories" )?> 	
		<?php
if ( $category_id != 0 ) {
	$sql = "select id,title from " . PVS_DB_PREFIX . "category where id=" . $category_id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$translate_results = pvs_translate_category( $rs->row["id"], $rs->row["title"],
			"", "" );
		echo ( " &mdash; " . $translate_results["title"] );
	}
}
?>
		</h1>
	</div>
	<div class="col-md-4">	
		<form  method="GET" style="margin-top:5px">
			<div class="input-group">
			  <input type="text" placeholder="<?php echo ( pvs_word_lang( "search" ) );?>..."  class="form-control" autocomplete="off" name="search" />	
			  <span class="input-group-btn">
	<button class="btn btn-primary" style="margin-top:0px;"><i class="fa fa-search"></i></button>
			  </span>
			</div>	
		</form>
	</div>
</div>

<div id="category_boxes">
<?php

if ( @$_REQUEST["search"] == '' ) {
	$sql = "select id,id_parent,title,priority,published,url,photo,description,location from " . PVS_DB_PREFIX .
		"category where id_parent=" . $category_id .
		" and published=1 and activation_date < " . pvs_get_time() .
		" and (expiration_date > " . pvs_get_time() .
		" or expiration_date = 0) order by priority,title";
} else
{
	$sql = "select id,id_parent,title, priority, published, url, photo, description,location from " .
		PVS_DB_PREFIX . "category where (title like '%" . pvs_result( $_REQUEST["search"] ) .
		"%' or keywords like '%" . pvs_result( $_REQUEST["search"] ) .
		"%' or description like '%" . pvs_result( $_REQUEST["search"] ) .
		"%') and  published=1 and activation_date < " . pvs_get_time() .
		" and (expiration_date > " . pvs_get_time() .
		" or expiration_date = 0) order by id desc";
}
$rs->open( $sql );
if ( ! $rs->eof ) {
	$n = 0;
	while ( ! $rs->eof ) {

		$count_id = 0;

		$itg = "";
		$nlimit = 0;
		$count_id = pvs_count_files_in_category( $rs->row["id"] );
		$pvs_theme_content[ 'category_id' ] = $rs->row["id"];

		$translate_results = pvs_translate_category( $rs->row["id"], $rs->row["title"], $rs->row["description"], "" );
			
		$category_result = pvs_show_category_preview($rs->row["id"]);
		$pvs_theme_content[ 'category_photo' ] = $category_result["photo"];
		$pvs_theme_content[ 'category_width' ] = $category_result["width"];
		$pvs_theme_content[ 'category_height' ] = $category_result["height"];
		
		$title = $translate_results["title"];
		if($pvs_global_settings["category_items"]) {
			$title .= ' (' . $count_id . ')';
		}

		$pvs_theme_content[ 'category_title' ] = $title;

		$sql = "select id from " . PVS_DB_PREFIX . "category where id_parent=" . $rs->row["id"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$pvs_theme_content[ 'category_url' ] = site_url() . "/categories/?id=" . $rs->row["id"];
		} else {
			$pvs_theme_content[ 'category_url' ] = site_url() . $rs->row["url"];
		}

		$description = $translate_results["description"];

		if ( $rs->row["location"] != '' ) {
			$description .= '<br>' . $rs->row["location"];
		}

		$pvs_theme_content[ 'category_description' ] = $description;
		
		if ($n%4 == 0 and $pvs_global_settings["category_view"] == 'grid') {
			echo("</div><div class='row'>");
		}
		
		if ( $pvs_global_settings["category_view"] == 'fixed_width') {
			include(get_stylesheet_directory() . "/item_category.php");
		}
		if ( $pvs_global_settings["category_view"] == 'grid') {
			include(get_stylesheet_directory() . "/item_category_grid.php");
		}
		$n++;
		$rs->movenext();
	}
	
}
?>
	</div>
	<style>
	.category_box
	{
		width:<?php echo ( $pvs_global_settings["category_preview"] + 20 )?>px;
	}
	</style>
	<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery.masonry.min.js"></script>
<script>
<?php
if ($pvs_global_settings["category_view"] == 'fixed_width') {
?>
$('#category_boxes').masonry({
  		itemSelector: '.category_box'
		});
<?php
}
?>		
			$('.home_preview').each(function(){
     		$(this).animate({opacity:'1.0'},1);
   			$(this).mouseover(function(){
     		$(this).stop().animate({opacity:'0.3'},600);
    		});
    		$(this).mouseout(function(){
    		$(this).stop().animate({opacity:'1.0'},300);
    		});
		});
</script>
