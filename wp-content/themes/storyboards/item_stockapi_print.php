<script>
//Print type
print_type = "<?php echo($pvs_theme_content[ 'print_type' ]);?>";

//Big preview size
print_width = <?php echo($pvs_theme_content[ 'big_width_prints' ]);?>;
print_height = <?php echo($pvs_theme_content[ 'big_height_prints' ]);?>;
print_image ="<?php echo($pvs_theme_content[ 'print_preview' ]);?>";

//Overlay image size
image_width = <?php echo($pvs_theme_content[ 'width_print_preview' ]);?>;
image_height = <?php echo($pvs_theme_content[ 'height_print_preview' ]);?>;

//Default image size
default_width = <?php echo($pvs_theme_content[ 'default_width' ]);?>;
default_height = <?php echo($pvs_theme_content[ 'default_height' ]);?>;

//Site root
site_root = "<?php echo (pvs_plugins_url());?>/";
site_root2 = "<?php echo (site_url());?>/";

//Default settings
$(function() {
	<?php echo($pvs_theme_content[ 'default_js_functions' ]);?>
});


//Image preupload
$.preloadImages = function() {
  for (var i = 0; i < arguments.length; i++) {
    $("<img />").attr("src", arguments[i]);
  }
}
$.preloadImages(print_image);

<?php echo($pvs_theme_content[ 'preloaded_frames' ]);?>
<?php echo($pvs_theme_content[ 'preloaded_tshirts' ]);?>

</script>
<script src="<?php echo(pvs_plugins_url());?>/includes/prints/prints.js"></script>


<div style="margin:40px auto 40px auto;display:table;">
	<h1><?php echo($pvs_theme_content[ 'print_title' ]);?>: <?php echo($pvs_theme_content[ 'title' ]);?></h1>
	<?php echo($pvs_theme_content[ 'image' ]);?>
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

<div class="row transitionfx">
    <div class="col-lg-6 col-md-6">	
    
          <div class="row">
      	<div class="col-lg-6 col-md-6 col-sm-6"><?php echo($pvs_theme_content[ 'author' ]);?> </div>
       	<div class="col-lg-6 col-md-6 col-sm-6"><b>ID : <?php echo($pvs_theme_content[ 'id' ]);?></b></div>
       </div>
       
       		<hr / style="margin-bottom:0px">
			
			<div class='file_details'>

<p><?php echo(pvs_word_lang("File details"));?></p>
			<?php if ($pvs_theme_content[ 'flag_published' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Published"));?>:</b> <?php echo(@$pvs_theme_content[ 'published' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_category' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Category"));?>:</b> <?php echo(@$pvs_theme_content[ 'category' ]);?></span>
			<?php }?>
			<span><b><?php echo(pvs_word_lang("Type"));?>:</b> <?php echo(@$pvs_theme_content[ 'type' ]);?></span>
			<?php if ($pvs_theme_content[ 'flag_duration' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Duration"));?>:</b> <?php echo(@$pvs_theme_content[ 'duration' ]);?> sec.</span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_aspect' ]) {?> 
				<span><b><?php echo(pvs_word_lang("aspect ratio"));?>:</b> <?php echo(@$pvs_theme_content[ 'aspect_ratio' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_model' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Model release"));?>:</b> <?php echo(@$pvs_theme_content[ 'model_release' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_property' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Property release"));?>:</b> <?php echo(@$pvs_theme_content[ 'property_release' ]);?></span>
			<?php }?>
			
			<?php if ($pvs_theme_content[ 'flag_bpm' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Beats per minute"));?>:</b> <?php echo(@$pvs_theme_content[ 'bpm' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_artists' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Artists"));?>:</b> <?php echo(@$pvs_theme_content[ 'artists' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_album' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Album"));?>:</b> <?php echo(@$pvs_theme_content[ 'album' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_genres' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Genres"));?>:</b> <?php echo(@$pvs_theme_content[ 'genres' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_instruments' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Instruments"));?>:</b> <?php echo(@$pvs_theme_content[ 'instruments' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_lyrics' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Lyrics"));?>:</b> <?php echo(@$pvs_theme_content[ 'lyrics' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_moods' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Moods"));?>:</b> <?php echo(@$pvs_theme_content[ 'moods' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'flag_vocal_description' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Vocal description"));?>:</b> <?php echo(@$pvs_theme_content[ 'vocal_description' ]);?></span>
			<?php }?>
			<?php if ($pvs_theme_content[ 'fotolia' ]) {?> 
				<span><b><?php echo(pvs_word_lang("Viewed"));?>:</b> <?php echo($pvs_theme_content[ 'viewed' ]);?></span>
				<span><b><?php echo(pvs_word_lang("Downloaded"));?>:</b> <?php echo($pvs_theme_content[ 'downloaded' ]);?></span>
			<?php }?>

      
      <div style="clear:both"></div>
      
      </div>
    </div>   

    <div class="col-lg-6 col-md-6"  style="padding-left:50px">
    
    <div class="cart-actions">
			<div class="addto">
				<?php if ($pvs_theme_content[ 'flag_resize' ]) {?> 
					<h4><?php echo(pvs_word_lang("Image size"));?>:</h4>
					<script type="text/javascript">
						$(document).ready(function() {
							 $("#slide1").slider({
								min: <?php echo($pvs_theme_content[ 'resize_min' ]);?>,
								max: <?php echo($pvs_theme_content[ 'resize_max' ]);?>,
								value:<?php echo($pvs_theme_content[ 'resize_value' ]);?>,
								slide: function( event, ui ) {
											$( "#print_size" ).val(ui.value);
											show_image();
										}
							});
						});
					</script>
		
					<div id="slide1"></div> 
					<input type="hidden" id="print_size" value="<?php echo($pvs_theme_content[ 'resize_value' ]);?>">
				<?php }?>
				
				<form name="print_form" id="print_form" action="<?php echo (site_url( ) );?>/shopping-cart-add-print/"  enctype="multipart/form-data">
				<?php echo($pvs_theme_content[ 'properties' ]);?>
				
				<hr />
				<div class="row">
   					<div class="col-lg-6 col-md-6">
   						<h4><?php echo(pvs_word_lang("price"));?></h4>
   						<div id="print_price" class="price" style="font-size:17px"><?php echo($pvs_theme_content[ 'price' ]);?></div>
   					</div>
   					<div class="col-lg-6 col-md-6">
   						<input type="hidden" name="stock" value="1">
   						<input type="hidden" name="stock_type" value="<?php echo($pvs_theme_content[ 'stock_type' ]);?>">
   						<input type="hidden" name="stock_id" value="<?php echo($pvs_theme_content[ 'stock_id' ]);?>">
   						<input type="hidden" name="stock_url" value="<?php echo($pvs_theme_content[ 'stock_url' ]);?>">
   						<input type="hidden" name="stock_preview" value="<?php echo($pvs_theme_content[ 'stock_preview' ]);?>">
   						<input type="hidden" name="stock_site_url" value="<?php echo($pvs_theme_content[ 'stock_site_url' ]);?>">
   						<input type="submit" class="add_to_cart" value="<?php echo($pvs_theme_content[ 'add_to_cart' ]);?>">
   					</div>
   				</div>
   				</form>
			</div>
			
			<div style="clear:both"></div><br><br>
		</div>
    
    
    
    


      
		
      
      <div class="clearfix">
        <p> <?php echo(pvs_word_lang("Share"));?> </p>
        <div class="socialIcon"> 
        <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[title]=<?php echo($pvs_theme_content[ 'share_title' ]);?>&p[summary]=<?php echo($pvs_theme_content[ 'share_title' ]);?>&p[url]=<?php echo($pvs_theme_content[ 'share_url' ]);?>&&p[images][0]=<?php echo($pvs_theme_content[ 'share_image' ]);?>" target="_blank" class="btn btn-md btn-default">&nbsp;<i  class="fa fa-facebook"></i></a>
        <a href="http://twitter.com/home?status=<?php echo($pvs_theme_content[ 'share_url' ]);?>&title=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-primary">&nbsp;<i  class="fa fa-twitter"></i></a> 
        <a href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?php echo($pvs_theme_content[ 'share_url' ]);?>&title=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-warning">&nbsp;<i  class="fa fa-google-plus"></i></a>
        <a href="http://pinterest.com/pin/create/button/?url=<?php echo($pvs_theme_content[ 'share_url' ]);?>&media=<?php echo($pvs_theme_content[ 'share_image' ]);?>&description=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-danger">&nbsp;<i  class="fa fa-pinterest"></i></a>
	 </div>
      </div>
    </div>
    
  </div>
  <div class="row recommended">
  <hr />
 	<h2> <?php echo(pvs_word_lang("Other prints and products"));?> </h2>
 	<div class="clearfix">
  		<?php pvs_show_related_prints_stock( ( int ) get_query_var('pvs_print_id'), $pvs_theme_content[ 'title' ], $pvs_theme_content[ 'stock_type' ], $pvs_theme_content[ 'stock_id' ], $pvs_theme_content[ 'preview_url' ] );?>
    </div> 
  </div>

  <div style="clear:both"></div>