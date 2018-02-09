<?php
global $wpdb;
global $translate_results;
$newtable = $wpdb->get_results( "SELECT author FROM " . PVS_DB_PREFIX . "media WHERE id=" . $pvs_theme_content['id'] );
$user_data = get_user_by( 'slug', $newtable[0]->author );
$gallery_string = array();

$preview_items_carousel = '';
if ( ! $flag_storage ) {
	$dir = opendir( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $folder );

	while ( $file = readdir( $dir ) ) {

		if ( $file <> "." && $file <> ".." ) {

			if ( preg_match( "/thumbs[0-9]+/", $file ) ) {

				if ( preg_match( "/.jpg$|.jpeg$|.png$|.gif$/i", $file ) ) {

					$kk = explode( "thumbs", $file );

					if ( count( $kk ) > 1 ) {
						$afiles[( int )$kk[1]] = $file;
					}
				}
			}
		}
	}
	closedir( $dir );
	ksort( $afiles );
	reset( $afiles );

	for ( $k = 0; $k < count( $afiles ); $k++ ) {

		if ( isset( $afiles[$k] ) ) {
			$file = $afiles[$k];
			$thumbz = str_replace( "thumbs", "thumbz", $file );
			$preview_items_carousel .= '<div><img src="' . pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $folder . "/" . $thumbz . '"></div>';
			$gallery_string[] = pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $folder . "/" . $thumbz;
		}
	}
} else {

	foreach ( $remote_previews as $key => $value ) {

		if ( preg_match( "/thumbs[0-9]+/", $key ) ) {

			if ( preg_match( "/.jpg$|.jpeg$|.png$|.gif$/i", $key ) ) {

				$kk = explode( "thumbs", $key );

				if ( count( $kk ) > 1 ) {
					$afiles[( int )$kk[1]] = $key;
				}

			}

		}

	}

	for ( $k = 1; $k < count( $afiles ); $k++ ) {
		if ( isset( $afiles[$k] ) ) {
			$file = $afiles[$k];
			$thumbz = str_replace( "thumbs", "thumbz", $file );
			$preview_items_carousel .= '<div><img src="' . $remote_previews[$thumbz] . '"></div>';
			$gallery_string[] = $remote_previews[$thumbz];
		}
	}
}
require_once( 'vector_sizes.php' );
$gallery_string = json_encode($gallery_string);
?>
<script>
        function getRadioCheckedValue(ids) {
            var oRadio = document.getElementById("p" + ids).elements['cart'];

            for(var i = 0; i < oRadio.length; i++)
            {
                if(oRadio[i].checked)
                {
                    return oRadio[i].value;
                }
            }

            return '';
        }

        function add_cart2(event,x,ids) {

            if(x==0) {
                value=getRadioCheckedValue(ids);
            }

            var req = new JsHttpRequest(),
                IE='\v'=='v';

            if(cartprices[value]==0 && x==0) {
                location.href="<?php echo site_url(); ?>/count/?type=<?php echo @$atype; ?>&id="+document.getElementById("cart").value+"&id_parent=<?php echo ( int )@get_query_var('pvs_id'); ?>";
            } else {
                req.onreadystatechange = function() {
                    if (req.readyState == 4) {

                        if(document.getElementById('shopping_cart')) {
                            document.getElementById('shopping_cart').innerHTML =req.responseJS.box_shopping_cart;
                        }

                        if(document.getElementById('shopping_cart_lite')) {
                            document.getElementById('shopping_cart_lite').innerHTML =req.responseJS.box_shopping_cart_lite;
                        }


                        if(x==1) {
													<?php if ( ! $pvs_global_settings["prints_previews"] ) { ?>
                            if(!IE) {
                                $.colorbox({html:req.responseJS.cart_content,width:'600px',scrolling:false});
                            }
													<?php } else { ?>
                            location.href = req.responseJS.redirect_url;
													<?php } ?>
                        } else {
                            if(!IE) {
                                $.colorbox({html:req.responseJS.cart_content,width:'600px',scrolling:false});
                            }
                        }

                        if(typeof set_styles == 'function') {
                            set_styles();
                        }

                        if(typeof reload_cart == 'function') {
                            reload_cart();
                        }
                    }
                };
                req.open(null, '<?php echo site_url()?>/shopping-cart-add/', true);
                req.send( {id: value } );
            }

            event.preventDefault();
        }
    </script>
<section class="profile">

    <div class="container">

        <div class="storyboard-container">

            <div class="story-left">
                <div class="newslider" data-slider="first" data-gallery='<?= $gallery_string; ?>'>
                    <?= $preview_items_carousel; ?>
                </div>

                <div class="slider-nav" data-slider="second">
	                <?= $preview_items_carousel; ?>
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

                    $keywords[$i] = trim( $keywords[$i] );
                    if ( $keywords[$i] != "" ) {
                      echo "<a href='" . site_url() . "/?search=" . $keywords[$i] . "'><div class=\"story-tag-option\">" . $keywords[$i] . "</div></a>";
                    }

                    if( $i === $keywords_count - 1 && $keywords_count > 10 ) {
                      echo "</div>";
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

				<?php echo($sizebox);?>

            </div>

        </div>

    </div>

</section>

<?php if ($pvs_theme_content[ 'flag_related' ]) {?>
    <section class="main-section">
        <div class="container">
            <h2 class="content-header" style="margin:0 0 35px"><?= __('Similar Storyboards', 'storyboards'); ?></h2>
            <div class="main-content">
			<?php pvs_show_related_items2( get_query_var('pvs_id'), "show" );?>
            </div>
            <div class="content-more" style="margin-top:40px">
                <a href="<?= get_site_url() . '?user=' . $user_data->ID; ?>"><?= __('SEE MORE', 'storyboards'); ?></a>
            </div>
        </div>
    </section>
<?php }?>














<?php /*

<div class="clearfix">
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
       
       <hr  style="margin-bottom:0">

		<?php if ($pvs_theme_content[ 'flag_exclusive' ] ) {?>
			<div class="editorial"><?php echo(pvs_word_lang("Exclusive price. The file will be removed from the stock after the purchase"));?></div>
		<?php }?>
		<div class="cart-actions">
			<div class="addto">
				<?php echo($pvs_theme_content[ 'sizes' ]);?>
			</div>
			
			<div style="clear:both"></div><br><br>
		</div>
   


    
    </div>
    
  </div>
*/