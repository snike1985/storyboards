<?php /* <div class="clearfix">
	<h1><?php echo($pvs_theme_content[ 'title' ]);?></h1>
	<ul class="path_corlate">
		<?php echo(pvs_get_social_meta_tags('path'));?>
	</ul>
</div>
    <div class="row">
    <div class="col-lg-6 col-md-6" style="min-width:500px">
        	<?php echo($pvs_theme_content[ 'image' ]);?> 
        	<div class="file_links row">
        		<div class="col-lg-9 col-md-9">
        			<?php if ( $pvs_global_settings[ 'lightboxes' ]) {?>
						<a href="<?php echo($pvs_theme_content[ 'add_to_favorite_link' ]);?>" class="btn btn-success btn-sm"><i class="fa fa-heart"> </i> <?php echo(pvs_word_lang("add to favorite"));?></a> 
					<?php }?>
					<?php if ($pvs_theme_content[ 'flag_downloadsample' ] ) {?>
						<a href="<?php echo($pvs_theme_content[ 'downloadsample' ]);?>" class="btn btn-danger btn-sm"><i class="fa fa-download"> </i>  <?php echo(pvs_word_lang("Download Sample"));?></a>
					<?php }?>
				</div>
				<div class="col-lg-3 col-md-3 next_previous">
					<?php if ($pvs_theme_content[ 'flag_previous' ] ) {?>
						<a href="<?php echo($pvs_theme_content[ 'previous_link' ]);?>" title="<?php echo(pvs_word_lang("Previous"));?>"><i class="fa fa-arrow-circle-left"></i></a>&nbsp;&nbsp;&nbsp;
					<?php }?>
					<?php if ($pvs_theme_content[ 'flag_next' ] ) {?>
						<a href="<?php echo($pvs_theme_content[ 'next_link' ]);?>" title="<?php echo(pvs_word_lang("Next"));?>"><i class="fa fa-arrow-circle-right"></i></a>
					<?php }?>
				</div>
			</div>			
			
			<div class='file_details'>
			<h5><?php echo(pvs_word_lang("Keywords"));?></h5>
			<?php echo($pvs_theme_content[ 'keywords_lite' ]);?>
			
			<hr />
			
			<h5><?php echo(pvs_word_lang("File details"));?></h5>
			<span><b><?php echo(pvs_word_lang("Published"));?>:</b> <?php echo($pvs_theme_content[ 'published' ]);?></span>
			<span><b><?php echo(pvs_word_lang("Rating"));?>:</b> <?php echo($pvs_theme_content[ 'item_rating_new' ]);?></span>
			<span><b><?php echo(pvs_word_lang("Category"));?>:</b> <?php echo($pvs_theme_content[ 'category' ]);?></span>
			<span><b><?php echo(pvs_word_lang("Viewed"));?>:</b> <?php echo($pvs_theme_content[ 'viewed' ]);?></span>
			<span><b><?php echo(pvs_word_lang("Downloads"));?>:</b> <?php echo($pvs_theme_content[ 'downloads' ]);?></span>	
			<?php if ($pvs_theme_content[ 'flag_model' ] ) {?>
				<?php echo($pvs_theme_content[ 'model' ]);?>
			<?php }?>
			
			<?php if ($pvs_theme_content[ 'flag_colors' ] ) {?>
				<hr />
				<h5><?php echo(pvs_word_lang("Color"));?></h5>
				<?php echo($pvs_theme_content[ 'colors' ]);?>
				<br><br>
			<?php }?>
			
			<hr />
			
			           <h5><?php echo(pvs_word_lang("Share"));?></h5>
        <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[title]=<?php echo($pvs_theme_content[ 'share_title' ]);?>&p[summary]=<?php echo($pvs_theme_content[ 'share_title' ]);?>&p[url]=<?php echo($pvs_theme_content[ 'share_url' ]);?>&&p[images][0]=<?php echo($pvs_theme_content[ 'share_image' ]);?>" target="_blank" class="btn btn-md btn-default">&nbsp;<i  class="fa fa-facebook"></i></a>
        <a href="http://twitter.com/home?status=<?php echo($pvs_theme_content[ 'share_url' ]);?>&title=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-default">&nbsp;<i  class="fa fa-twitter"></i></a> 
        <a href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?php echo($pvs_theme_content[ 'share_url' ]);?>&title=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-default">&nbsp;<i  class="fa fa-google-plus"></i></a>
        <a href="http://pinterest.com/pin/create/button/?url=<?php echo($pvs_theme_content[ 'share_url' ]);?>&media=<?php echo($pvs_theme_content[ 'share_image' ]);?>&description=<?php echo($pvs_theme_content[ 'share_title' ]);?>" target="_blank" class="btn btn-md btn-default">&nbsp;<i  class="fa fa-pinterest"></i></a>
			
		</div>
    </div>   

    <div class="col-lg-6 col-md-6 summary entry-summary">
      <div class="row">
      	<div class="col-lg-4 col-md-4 col-sm-4"><?php echo($pvs_theme_content[ 'author' ]);?> </div>
       	<div class="col-lg-2 col-md-2 col-sm-2"><b>ID : <?php echo($pvs_theme_content[ 'id' ]);?></b></div>
       	<div class="col-lg-6 col-md-6 col-sm-6">
       		<div id="vote_dislike" class="dislike-btn dislike-h"><?php echo(pvs_word_lang("Dislike"));?> <?php echo($pvs_theme_content[ 'dislike' ]);?></div>
			<div id="vote_like" class="like-btn like-h"><?php echo(pvs_word_lang("Like"));?> <?php echo($pvs_theme_content[ 'like' ]);?></div>
       	</div>
       </div>
       
       <hr / style="margin-bottom:0px">

      	<?php if ($pvs_theme_content[ 'flag_editorial' ] ) {?>
			<div class="editorial"><?php echo(pvs_word_lang("files for editorial use only"));?></div>
		<?php }?>
		<?php if ($pvs_theme_content[ 'flag_exclusive' ] ) {?>
			<div class="editorial"><?php echo(pvs_word_lang("Exclusive price. The file will be removed from the stock after the purchase"));?></div>
		<?php }?>
		<div class="cart-actions">
			<div class="addto">
				<?php echo($pvs_theme_content[ 'sizes' ]);?>
			</div>
			
			<div style="clear:both"></div><br><br>
		</div>
   


      
        <ul class="nav nav-tabs  style-2" role="tablist" style="margin:0px;">
          <li class="active"><a href="#details" data-toggle="tab"><?php echo(pvs_word_lang("Description"));?></a></li>
          <li><a href="#exif_content" data-toggle="tab"  onclick="exif_show(<?php echo($pvs_theme_content[ 'id' ]);?>);">EXIF</a></li>
          <li><a href="#comments_content" data-toggle="tab" onclick="reviews_show(<?php echo($pvs_theme_content[ 'id' ]);?>);"><?php echo(pvs_word_lang("Comments"));?></a></li>
          <li><a href="#tell_content" data-toggle="tab"  onclick="tell_show(<?php echo($pvs_theme_content[ 'id' ]);?>);"><?php echo(pvs_word_lang("Tell a friend"));?></a></li>
          <li><a href="#reviewscontent" data-toggle="tab"  onclick="map_show(<?php echo($pvs_theme_content[ 'google_x' ]);?>,<?php echo($pvs_theme_content[ 'google_y' ]);?>);"><?php echo(pvs_word_lang("Google map"));?></a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="details"><?php echo($pvs_theme_content[ 'description' ]);?></div>
          <div class="tab-pane" id="exif_content"></div>     
          <div class="tab-pane" id="comments_content"></div>
          <div class="tab-pane" id="tell_content"></div>
          <div class="tab-pane" id="reviewscontent"></div>
          
        </div>

    
    </div>
    
  </div>
<?php if ($pvs_theme_content[ 'flag_related' ]) {?> 
	<h2><?php echo(pvs_word_lang("Related items"));?></h2>
	<hr />
	<div class="container-fluid ">
		<div class="row">
		<?php pvs_show_related_items( get_query_var('pvs_id'), "show" );?>
	</div> 
	</div>
	<br>
	<br>
<?php }?> 
*/ ?>

<?php
global $wpdb;
global $translate_results;
$newtable = $wpdb->get_results( "SELECT author FROM " . PVS_DB_PREFIX . "media WHERE id=" . $pvs_theme_content['id'] );
$user_data = get_user_by( 'slug', $newtable[0]->author );
//var_dump($translate_results["keywords"]);
$gallery_string[] = $pvs_theme_content[ 'downloadsample' ];
$gallery_string = json_encode($gallery_string);
?>
<section class="profile">

    <div class="container">

        <div class="storyboard-container">

            <div class="story-left">
                <div class="newslider newsliderClick" data-slider="first" data-gallery='<?= $gallery_string; ?>'>
                    <div class=""><img src="<?php echo($pvs_theme_content[ 'downloadsample' ]);?>" alt=""></div>
                </div>

                <div class="slider-nav" data-slider="second">
                    <div class=""><img src="<?php echo($pvs_theme_content[ 'downloadsample' ]);?>" width="106" alt=""></div>
                </div>
                <div class="story-id"><?= __('ID', 'storyboards'); ?>: <?php echo($pvs_theme_content[ 'id' ]);?></div>
                <div class="story-tag">
	                <?php
                    if ( $translate_results["keywords"] != "" ) {
                      $keywords = explode( ",", str_replace( ";", ",", $translate_results["keywords"] ) );

                      $keywords_count = count( $keywords );
                      for ( $i = 0; $i < count( $keywords ); $i++ ) {

                        if( $i === 10 && $keywords_count > 10 ) {
                          echo '<div class="show-more-option active">... ' . __('show more', 'storyboards') . '</div>' .
                               '<div class="story-tag-hidden">';
                        }

                        if( $i === $keywords_count && $keywords_count > 10 ) {
                          echo "</div>";
                        }

                        $keywords[$i] = trim( $keywords[$i] );
                        if ( $keywords[$i] != "" ) {
                          echo "<a href='" . site_url() . "/?search=" . $keywords[$i] . "'><div class=\"story-tag-option\">" . $keywords[$i] . "</div></a>";
                        }

                      }
                    }
		            ?>
                </div>
            </div>

            <div class="story-right">

                <h2 class="story-title"><?php echo($pvs_theme_content[ 'title' ]);?></h2>

                <div class="about-profile"><?php echo($pvs_theme_content[ 'description' ]);?></div>

                <div class="story-author">

                    <div class="author-img">
                        <?= get_avatar($user_data->ID, 58); ?>
                    </div>

                    <div class="author-name">
	                    <?php
                        if( $user_data->first_name || $user_data->last_name ) {
	                        echo $user_data->first_name . ' ' . $user_data->last_name;
	                    } else {
	                        echo $user_data->display_name;
		                }
		                ?>
                    </div>

                </div>

                <form id="price">
                    <div class="select">
                        <input type="radio" id="radio1" form="price" checked="checked" class="radio-button" name="file">
                        <label for="radio1">
                                    <span class="selectOption">
                                        <span class="file-type">
                                                    jpg
                                        </span>
                                        <span class="file-option">
                                                    monochrome
                                        </span>
                                        <span class="file-size">
                                                    32 kb
                                                       </span>
                                        <span class="file-price">
                                                    19$
                                        </span>
                                    </span>
                        </label>
                    </div>
                    <div class="select">
                        <input type="radio" id="radio2" form="price" name="file" class="radio-button">
                        <label for="radio2">
                                    <span class="selectOption">
                                        <span class="file-type">
                                                    jpg
                                        </span>
                                        <span class="file-option">
                                                    colored
                                        </span>
                                        <span class="file-size" >
                                                    50 kb
                                                       </span>
                                        <span class="file-price">
                                                    30$
                                        </span>
                                    </span>
                        </label>
                    </div>
                    <div class="select">
                        <input type="radio" id="radio3" form="price" name="file" class="radio-button">
                        <label for="radio3">
                                    <span class="selectOption">
                                        <span class="file-type">
                                                    psd
                                        </span>
                                        <span class="file-option">
                                                    multilayered
                                        </span>
                                        <span class="file-size">
                                                    120 kb
                                                        </span>
                                        <span class="file-price">
                                                    49$
                                        </span>
                                    </span>
                        </label>
                    </div>
                    <div class="story-buttons">
                        <button type="submit" class="send-button" value="" name="addtocart" form="price">ADD TO CART</button>
											<?php if ( $pvs_global_settings[ 'lightboxes' ]) {?>
                          <a class="send-button" href="<?php echo($pvs_theme_content[ 'add_to_favorite_link' ]);?>">ADD TO LIGHTBOX</a>
											<?php } ?>
                    </div>
                </form>

            </div>

        </div>

    </div>

</section>

<section class="main-section">
            <div class="container">
                <h2 class="content-header" style="margin:0 0 35px">
                                                 Similar Storyboards
                                                         </h2>
                <div class="main-content">
                    <div class="content-element">
                        <a href="#">
                            <img src="images/story/005.jpg" alt="">
                            <div class="board">
                                <div class="board-info">
                                    <div class="board-name">Storyboard name</div>
                                    <div class="board-downloads">54 downloads</div>
                                </div>
                                <div class="board-author">
                                    <img src="images/artists/101.png" width="30" height="30" alt="">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content-element">
                        <a href="#">
                            <img src="images/story/006.jpg" alt="">
                            <div class="board">
                                <div class="board-info">
                                    <div class="board-name">Storyboard name</div>
                                    <div class="board-downloads">54 downloads</div>
                                </div>
                                <div class="board-author">
                                    <img src="images/artists/101.png" width="30" height="30" alt="">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content-element">
                        <a href="#">
                            <img src="images/story/007.jpg" alt="">
                            <div class="board">
                                <div class="board-info">
                                    <div class="board-name">Storyboard name</div>
                                    <div class="board-downloads">54 downloads</div>
                                </div>
                                <div class="board-author">
                                    <img src="images/artists/101.png" width="30" height="30" alt="">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content-element">
                        <a href="#">
                            <img src="images/story/008.jpg" alt="">
                            <div class="board">
                                <div class="board-info">
                                    <div class="board-name">Storyboard name</div>
                                    <div class="board-downloads">54 downloads</div>
                                </div>
                                <div class="board-author">
                                    <img src="images/artists/101.png" width="30" height="30" alt="">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="content-more" style="margin-top:40px">
                    <a href="#">SEE MORE</a>
                </div>
            </div>
        </section>