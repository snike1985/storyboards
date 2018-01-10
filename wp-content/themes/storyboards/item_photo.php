<?php
global $wpdb;
global $translate_results;
$newtable = $wpdb->get_results( "SELECT author FROM " . PVS_DB_PREFIX . "media WHERE id=" . $pvs_theme_content['id'] );
$user_data = get_user_by( 'slug', $newtable[0]->author );
$gallery_string[] = $pvs_theme_content[ 'downloadsample' ];
$gallery_string = json_encode($gallery_string);

if ( $rs->row["contacts"] == 0 ) {
	//Show prices and prints
	if ( $rs->row["rights_managed"] == 0) {
		$sizebox = "";

		if ( ( $pvs_global_settings["subscription"] and pvs_user_subscription( pvs_get_user_login (), get_query_var('pvs_id') ) ) or $rs->row["free"] == 1 or $pvs_global_settings["subscription_only"] ) {
			$subscription_item = true;
		} else {
			$subscription_item = false;
		}

		$sizebox_labels = "";
		$sizeboxes = array();
		if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
		                  $folder ) ) {
			$sql = "select id_parent,name from " . PVS_DB_PREFIX .
			       "licenses order by priority";

			$dd->open( $sql );
			$sizebox_labels_checked = "checked";
			$sizebox_buy_checked = "";
			$ncount = 0;
			while ( ! $dd->eof )
			{
				$flag_license = true;

				$sql = "select id_parent,title,size,jpg,png,gif,raw,tiff,eps from " .
				       PVS_DB_PREFIX . "sizes where license=" . $dd->row["id_parent"] .
				       " order by priority";
				$dr->open( $sql );

				while ( ! $dr->eof ) {
					$sql = "select id,name,url,price from " . PVS_DB_PREFIX .
					       "items where price_id=" . $dr->row["id_parent"] . " and id_parent=" . get_query_var('pvs_id') .
					       " order by priority";
					$ds->open( $sql );
					while ( ! $ds->eof ) {
						if ( $flag_license ) {
							$sizeboxes[$dd->row["id_parent"]] = "";
							$sizebox_labels .= "";
							$sizebox_labels_checked = "";
							$flag_license = false;
						}

						$photo_width = $default_width;
						$photo_height = $default_height;
						$photo_filesize = 0;
						$photo_nojpg = 0;

						foreach ( $photo_files as $key => $value ) {
							if ( $dr->row[$key] == 1 ) {

								if ( $key != "jpg" and $key != "gif" and $key != "png" ) {
									$photo_nojpg++;
								}

								if ( $image_width[$key] >= $image_height[$key] ) {
									if ( ( $image_width[$key] < $photo_width or $photo_width == 0 ) and $image_width[$key] != 0 ) {
										$photo_width = $image_width[$key];
										$photo_height = $image_height[$key];
										$photo_filesize = $image_filesize[$key];
									}
								} else {
									if ( ( $image_height[$key] < $photo_height or $photo_height == 0 ) and $image_height[$key] != 0 )
									{
										$photo_width = $image_width[$key];
										$photo_height = $image_height[$key];
										$photo_filesize = $image_filesize[$key];
									}
								}

								$photo_filesize = $image_filesize[$key];
							}
						}

						if ( $photo_width != 0 and $photo_height != 0 )
						{
							$rw = $photo_width;
							$rh = $photo_height;

							if ( $dr->row["size"] != 0 )
							{
								if ( $rw > $rh )
								{
									$rw = $dr->row["size"];
									if ( $rw != 0 )
									{
										$rh = round( $photo_height * $rw / $photo_width );
									}
								} else
								{
									$rh = $dr->row["size"];
									if ( $rh != 0 )
									{
										$rw = round( $photo_width * $rh / $photo_height );
									}
								}
								$dpi = $photo_dpi;
							} else
							{
								$dpi = $photo_dpi;
							}
						}

						if ( $size_photo == "cm" ) {
							$rw = pvs_price_format( $rw * 2.54 / $dpi, 1 );
							$rh = pvs_price_format( $rh * 2.54 / $dpi, 1 );
						}

						$subscription_link = "";

						if ( $ncount == 0 ) {
							$sizebox_buy_checked = "checked";
						} else {
							$sizebox_buy_checked = "";
						}

						$flag_format = false;
						foreach ( $photo_formats as $key => $value )
						{
							if ( $rs->row["url_" . $value] != "" and $dr->row[$value] == 1 )
							{
								$flag_format = true;
							}
						}

						if ( ( ( ( $photo_width >= $photo_height and $dr->row["size"] <= $photo_width ) or ( $photo_width < $photo_height and $dr->row["size"] <= $photo_height ) ) or $photo_nojpg > 0 ) and $flag_format ) {

						    if ( $ds->row["price"] != 0 ) {
								$price_text = pvs_currency( 2 ) . pvs_price_format( $ds->row["price"], 2, true ) . pvs_currency( 1 );
							} else {
								$price_text = pvs_word_lang( "free download" );
							}

							$content_price = "<span class=\"file-price\">" . $price_text . "</span>";

							if ( $rs->row["free"] == 1 ) {
								$content_price = "";
							}
							$formats = "";
							foreach ( $photo_formats as $key => $value ) {

								if ( $dr->row[$value] == 1 and $rs->row["url_" . $value] != "" )
								{
									if ( $formats != "" )
									{
										$formats .= ", ";
									}
									$formats .= strtoupper( $value );
								}
							}

							$sizeboxes[$dd->row["id_parent"]] .= "<div class=\"select\">
                                                                    <input type=\"radio\" id='cart-" . $ds->row["id"] . "' name='cart' value='" . $ds->row["id"] . "' class=\"radio-button\" " . $sizebox_buy_checked . ">
                                                                    <label for=\"cart-" . $ds->row["id"] . "\">
                                                                        <span class=\"selectOption\">
                                                                            <span class=\"file-type\">" . strtolower($formats) . "</span>
                                                                            <span class=\"file-option\">" . pvs_word_lang( $ds->row["name"] ) . $subscription_link . "</span>
                                                                            <span class=\"file-size\">" . strval( pvs_price_format( $photo_filesize / ( 1024 * 1024 ), 3 ) ) . " Mb</span>
                                                                            "  . $content_price . "
                                                                        </span>
                                                                    </label>
                                                                  </div>";

						}

						$ds->movenext();
					}
					$ncount++;
					$dr->movenext();
				}
				$dd->movenext();
			}

			foreach ( $sizeboxes as $key => $value ) {
				$sizebox .= "<form id='p" . $key . "'>" . $value;

				if ( $pvs_global_settings["printsonly"] ) {
				    $sizebox = $prints_content;
				} else {
				    //$sizebox = "<div style='margin-bottom:6px;margin-top:15px' class='price_license'><a href='" . site_url() . "/license/'>" . pvs_word_lang( "license" ) . ":</a></b> " . $sizebox_labels . $prints_label . "</div>" . $sizebox . $prints_content;

				    if ( $subscription_item )
								{
									$word_cart = pvs_word_lang( "download" );
									if ( $rs->row["free"] == 1 )
									{
										$word_cart = pvs_word_lang( "free download" );
									}

									$sizebox .= "<input id='item_button_cart' class='add_to_cart' type='button' onclick=\"add_download('photo'," .
									            $rs->row["id"] . "," . $rs->row["server1"] . ")\" value='" . $word_cart .
									            "'>";
								} else {
					    $sizebox .= "<div class=\"story-buttons\"><button id='item_button_cart' onclick=\"add_cart2( event, 0, " . $key ." )\" type=\"submit\" class=\"send-button add_to_cart\">" . pvs_word_lang( "add to cart" ) . "</button>";
						if ( $pvs_global_settings[ 'lightboxes' ] ) {
						    $sizebox .= '<a class="send-button" href="' . $pvs_theme_content[ 'add_to_favorite_link' ] . '"><span>' . __('ADD TO LIGHTBOX', 'storyboards') . '</span></a>';
						}
						$sizebox .= '</div></form>';

					}
				}
			}
		}

	} else {

		$sizebox = "<form id='p1'>";

		foreach ( $photo_files as $key => $value ) {
			//$sizebox = "<tr><td>" . strtoupper( $key ) . "</td><td> " . $image_width[$key] . "x" . $image_height[$key] . "px</td><td>" . strval( pvs_price_format( $image_filesize[$key] / ( 1024 * 1024 ), 3 ) ) . " Mb</td></tr>";
			$sizebox .= "<div class=\"select\">
                        <input type=\"radio\" id=\"radio1\" form=\"price\" checked=\"checked\" class=\"radio-button\" name=\"file\">
                        <label for=\"radio1\">
                                    <span class=\"selectOption\">
                                        <span class=\"file-type\">" . strtoupper( $key ) . "</span>
                                        <span class=\"file-option\">" . pvs_word_lang( $ds->row["name"] ) . $subscription_link . "</span>
                                        <span class=\"file-size\">" . strval( pvs_price_format( $image_filesize[$key] / ( 1024 * 1024 ), 3 ) ) . " Mb</span>
                                        "  . $content_price . "
                                    </span>
                        </label>
                    </div>";
		}

		$sizebox .= "<div class=\"story-buttons\"><button id='item_button_cart' onClick='rights_managed(" . $rs->row["id"] . ")' type=\"submit\" class=\"send-button add_to_cart\">" . pvs_word_lang( "add to cart" ) . "</button>";
		if ( $pvs_global_settings[ 'lightboxes' ] ) {
          $sizebox .= '<a class="send-button" href="' . $pvs_theme_content[ 'add_to_favorite_link' ] . '"><span>' . pvs_word_lang( "calculate price" ) . '</span></a>';
		}
		$sizebox .= '</div></form>';
	}
} else {
	$sizebox = "<form id='p1'>";

	foreach ( $photo_files as $key => $value )
	{
			$sizebox .= "<div class=\"select\">
                        <input type=\"radio\" id=\"radio1\" form=\"price\" checked=\"checked\" class=\"radio-button\" name=\"file\">
                        <label for=\"radio1\">
                                    <span class=\"selectOption\">
                                        <span class=\"file-type\">" . strtoupper( $key ) . "</span>
                                        <span class=\"file-option\">" . pvs_word_lang( $ds->row["name"] ) . $subscription_link . "</span>
                                        <span class=\"file-size\">" . strval( pvs_price_format( $image_filesize[$key] / ( 1024 * 1024 ), 3 ) ) . " Mb</span>
                                        "  . $content_price . "
                                    </span>
                        </label>
                    </div>";
	}

	$sizebox .= "<div class=\"story-buttons\"><button id='item_button_cart' onClick=\"location.href='" . site_url() . "/contacts/?file_id=" . $rs->row["id"] . "\" type=\"submit\" class=\"send-button add_to_cart\">" . pvs_word_lang( "Contact us to get the price" ) . "</button>";
	if ( $pvs_global_settings[ 'lightboxes' ] ) {
		$sizebox .= '<a class="send-button" href="' . $pvs_theme_content[ 'add_to_favorite_link' ] . '"><span>' . pvs_word_lang( "calculate price" ) . '</span></a>';
	}
	$sizebox .= '</div></form>';
}



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