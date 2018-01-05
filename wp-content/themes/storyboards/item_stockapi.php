<div class="item_path">
	<ul>
		<li class="first"><a href="<?php echo (site_url( ) );?>/"><?php echo(pvs_word_lang("Home"));?></a></li>
		<li><a href="<?php echo (site_url( ) );?>/index.php?search="><?php echo(pvs_word_lang("catalog"));?></a></li>
	</ul>
	<div class="clearfix"></div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6" style="min-width:500px">
        	<?php echo($pvs_theme_content[ 'image' ]);?> <br><br>
        	<a href="<?php echo($pvs_theme_content[ 'downloadsample' ]);?>" class="btn btn-danger btn-sm"><i class="fa fa-download"> </i>  <?php echo(pvs_word_lang("Download Sample"));?></a>
		
			
			<div class='file_details'>

			
			<h5><?php echo(pvs_word_lang("File details"));?></h5>
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

			
			<hr />
			
			           <h5><?php echo(pvs_word_lang("Share"));?></h5>
        <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[title]=<?php echo($pvs_theme_content[ 'share_title' ]);?>&p[summary]=<?php echo($pvs_theme_content[ 'share_title' ]);?>&p[url]=<?php echo($pvs_theme_content[ 'share_url' ]);?>&&p[images][0]=<?php echo($pvs_theme_content[ 'share_image' ]);?>" target="_blank" class="btn btn-md btn-default">&nbsp;<i  class="fa fa-facebook"></i></a>
        <a href="http://twitter.com/home?status=<?php echo($pvs_theme_content[ 'share_url' ]);?>&title=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-primary">&nbsp;<i  class="fa fa-twitter"></i></a> 
        <a href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?php echo($pvs_theme_content[ 'share_url' ]);?>&title=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-warning">&nbsp;<i  class="fa fa-google-plus"></i></a>
        <a href="http://pinterest.com/pin/create/button/?url=<?php echo($pvs_theme_content[ 'share_url' ]);?>&media=<?php echo($pvs_theme_content[ 'share_image' ]);?>&description=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-danger">&nbsp;<i  class="fa fa-pinterest"></i></a>
				
		</div>
    </div>   

    <div class="col-lg-6 col-md-6">
    	<h1 class="product_title entry-title"><?php echo($pvs_theme_content[ 'title' ]);?></h1>
      <div class="row">
      	<div class="col-lg-6 col-md-6 col-sm-6"><?php echo($pvs_theme_content[ 'author' ]);?> </div>
       	<div class="col-lg-6 col-md-6 col-sm-6"><b>ID : <?php echo($pvs_theme_content[ 'id' ]);?></b></div>
       </div>
       
       <hr / style="margin-bottom:0px">

      	<?php if ($pvs_theme_content[ 'flag_editorial' ]) {?>  
			<div class="editorial"><?php echo($pvs_theme_content[ 'editorial' ]);?></div>
		<?php }?>

		<div class="cart-actions">
			<div class="addto" style='margin:20px 0px 40px 0px'>
				<?php echo($pvs_theme_content[ 'sizes' ]);?>
			</div>
			
			<?php if ($pvs_theme_content[ 'depositphotos' ] or $pvs_theme_content[ 'bigstockphoto' ]) {?> 
				<h5><?php echo(pvs_word_lang("Description"));?></h5>
				<?php echo($pvs_theme_content[ 'description' ]);?>
				
			<?php }?>

			<hr />
			<h5><?php echo(pvs_word_lang("Keywords"));?></h5>
			<?php echo($pvs_theme_content[ 'keywords_lite' ]);?>
			<hr />

			
			<div style="clear:both"></div><br><br>
		</div>

    
    </div>
    
  </div>
<?php if ($pvs_theme_content[ 'flag_related' ]) {?>  
<hr />
<div class="products related">
	<h2><?php echo(pvs_word_lang("Related items"));?></h2>
	<ul class="products">
		<?php echo($pvs_theme_content[ 'related_items' ]);?>
	</ul>
</div>
<?php }?> 