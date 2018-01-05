<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<br>
<div class="row">
	<div class="col-md-8">
		<h1>
		<?php echo(pvs_word_lang( "Collections" )); ?>
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

<div id="category_boxes"  class="row">
<?php

if ( @$_REQUEST["search"] == '' ) {
		$sql = "select id, title, description, price, types from " . PVS_DB_PREFIX . "collections where active = 1 order by title";
} else
{
		$sql = "select id, title, description, price, types from " . PVS_DB_PREFIX . "collections where title like '%" . pvs_result( $_REQUEST["search"] ) .
		"%' and active = 1 order by title";
}
$rs->open( $sql );
if ( ! $rs->eof ) {
	$n = 0;
	while ( ! $rs->eof ) {
		$collection_result = pvs_show_collection_preview($rs->row["id"]);

		$pvs_theme_content[ 'category_title' ] = $rs->row["title"] . ' (' . pvs_count_files_in_collection($rs->row["id"]) . ')';

		$pvs_theme_content[ 'category_url' ] = pvs_collection_url( $rs->row["id"], $rs->row["title"] );

		$pvs_theme_content[ 'category_photo' ] = $collection_result["photo"];

		$description = '';
		
		if ( $rs->row["description"] != '' ) {
			$description .= $rs->row["description"] . '<br>';
		}
		
		$description .= pvs_word_lang("price") . ': <span class="price">' . pvs_currency( 1 ) . pvs_price_format( $rs->row["price"], 2 ) . '  ' . pvs_currency( 2 ). '</span><br>';

		$pvs_theme_content[ 'category_description' ] = $description;
		$pvs_theme_content[ 'category_width' ] = $collection_result["width"];
		$pvs_theme_content[ 'category_height' ] = $collection_result["height"];
		
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