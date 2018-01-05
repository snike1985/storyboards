<div class="item_list">
	<div  class="item_list_img">
		<div  class="item_list_img2">
			<a href="<?php echo($pvs_theme_content[ 'item_url' ]);?>"><img src="<?php echo($pvs_theme_content[ 'item_img' ]);?>" border="0" <?php echo($pvs_theme_content[ 'item_lightbox' ]);?> class="preview_listing"></a>
		</div>
	</div>
	<div class="item_list_text">
		<div>
			<a href="<?php echo($pvs_theme_content[ 'item_url' ]);?>"><i class="fa <?php echo($pvs_theme_content[ 'class2' ]);?>"> </i> #<?php echo($pvs_theme_content[ 'item_id' ]);?></a>
		</div>
		<div id='cart<?php echo($pvs_theme_content[ 'item_id' ]);?>'>
			<?php if ($pvs_theme_content[ 'cart' ]) {?>
				<a href="javascript:<?php echo($pvs_theme_content[ 'cart_function' ]);?>_cart(<?php echo($pvs_theme_content[ 'item_id' ]);?>);"  class="ac<?php echo($pvs_theme_content[ 'cart_class' ]);?>"><?php echo($pvs_theme_content[ 'add_to_cart' ]);?></a>
			<?php }?>
		</div>
		<div class="iviewed">
			<i class="glyphicon glyphicon-eye-open"> </i> <?php echo($pvs_theme_content[ 'item_viewed' ]);?>
		</div>
		<div class="idownloaded">
			<i class="glyphicon glyphicon-download"> </i> <?php echo($pvs_theme_content[ 'item_downloaded' ]);?>
		</div>
	</div>
</div>

