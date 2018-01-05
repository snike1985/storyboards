<div class="home_box">
	<div class="overlay-container">
		<a href="<?php echo($pvs_theme_content[ 'item_url' ]);?>"><img src="<?php echo($pvs_theme_content[ 'item_img2' ]);?>" alt="<?php echo($pvs_theme_content[ 'item_title' ]);?>" class="home_preview" <?php echo($pvs_theme_content[ 'item_lightbox' ]);?> style='width:<?php echo($pvs_theme_content[ 'width' ]);?>px;height:<?php echo($pvs_theme_content[ 'height' ]);?>px;'></a>
	</div>
	<div class="home_box_body">
		<?php if ( $pvs_global_settings[ 'lightboxes' ]) {?>
			<a href="javascript:show_lightbox(<?php echo($pvs_theme_content[ 'item_id' ]);?>,'<?php echo (site_url( ) );?>/')" title="<?php echo(pvs_word_lang("add to favorite list"));?>"  class="home_box_heart"><i class="fa fa-heart-o"></i></a>
		<?php }?>
		<h6><a href="<?php echo($pvs_theme_content[ 'item_url' ]);?>"><?php echo($pvs_theme_content[ 'item_title' ]);?></a></h6>
		<p class="small"><?php echo($pvs_theme_content[ 'item_description' ]);?></p>
		<div class="elements-list clearfix">
			<?php if ($pvs_theme_content[ 'cart' ]) {?>				
				<a href="javascript:add_cart_flow(<?php echo($pvs_theme_content[ 'item_id' ]);?>,'<?php echo (site_url( ) );?>/')" title="<?php echo(pvs_word_lang("Add to Cart"));?>" id="ts_cart<?php echo($pvs_theme_content[ 'item_id' ]);?>">
					<i class="fa fa-shopping-cart"></i> 
					<span class="ts_cart_text<?php echo($pvs_theme_content[ 'item_id' ]);?>">
						<?php echo(pvs_word_lang("Add to Cart"));?>
					</span>
					<span style='display:none' class="ts_cart_text2<?php echo($pvs_theme_content[ 'item_id' ]);?>">
						<?php echo(pvs_word_lang("In your cart"));?>
					</span>
				</a>
			<?php } else {?>
				<?php if ( $pvs_theme_content[ 'rights_managed' ]) {?>
					<a href="<?php echo($pvs_theme_content[ 'item_url' ]);?>" title="<?php echo(pvs_word_lang("Add to Cart"));?>" id="ts_cart<?php echo($pvs_theme_content[ 'item_id' ]);?>">
						<i class="fa fa-shopping-cart"></i> 
						<span class="ts_cart_text<?php echo($pvs_theme_content[ 'item_id' ]);?>">
							<?php echo(pvs_word_lang("Add to Cart"));?>
						</span>
					</a>				
				<?php }?>
				<?php if ( $pvs_theme_content[ 'free' ]) {?>
					<a href="<?php echo($pvs_theme_content[ 'free_url' ]);?>" title="<?php echo(pvs_word_lang("Add to Cart"));?>" id="ts_cart<?php echo($pvs_theme_content[ 'item_id' ]);?>">
						<i class='glyphicon glyphicon-download'> </i>
						<span class="ts_cart_text<?php echo($pvs_theme_content[ 'item_id' ]);?>">
							<?php echo(pvs_word_lang("Free download"));?>
						</span>
					</a>
				<?php }?>
			<?php }?>
		</div>
	</div>
</div>
