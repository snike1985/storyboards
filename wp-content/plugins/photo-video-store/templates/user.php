<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<script>

function add_friend(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
document.getElementById('friendbox').innerHTML =req.responseText;
        }
    }
    req.open(null, '<?php echo site_url();
?>/friends-add/', true);
    req.send( { friend: value } );
}


function delete_friend(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
document.getElementById('friendbox').innerHTML =req.responseText;
        }
    }
    req.open(null, '<?php echo site_url();
?>/friends-delete/', true);
    req.send( { friend: value } );
}

function testimonials_show(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
document.getElementById('testimonialscontent').innerHTML =req.responseText;
        }
    }
    req.open(null, '<?php echo site_url();
?>/user-testimonials-content/', true);
    req.send( { login: value} );
}


function testimonials_add(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
document.getElementById('testimonialscontent').innerHTML =req.responseText;

        }
    }
    req.open(null, '<?php echo site_url();
?>/user-testimonials-content/', true);
    req.send( {'form': document.getElementById(value) } );
}


</script>

<script src="<?php echo pvs_plugins_url();
?>/assets/js/raty/jquery.raty.min.js"></script>

<script>
    $(function() {
      $.fn.raty.defaults.path = '<?php echo pvs_plugins_url(); ?>/assets/js/raty/img';

      $('.star').raty({ score: 5 });
      
    });
    
    function vote_rating(id,score)
    {
    	<?php
if ( ! is_user_logged_in() and $pvs_global_settings["users_rating_limited"] ) {
?>	
			location.href='<?php echo site_url();
?>/login/';
		<?php
} else
{
?>
    		var req = new JsHttpRequest();
        
    		// Code automatically called on load finishing.
   	 		req.onreadystatechange = function()
    		{
        		if (req.readyState == 4)
        		{
	
        		}
    		}
    		req.open(null, '<?php echo site_url();
?>/vote-user/', true);
    		req.send( {id: id,vote:score } );
    	<?php
}
?>
   	}
</script>


<?php
$user_info = get_user_by("login", get_query_var('pvs_user_id'));
?>

<div class="page_internal">
<div class="row">
	<div class="col-xl-3 col-lg-3 col-md-3">
		<div class="portfolio_left">

<?php echo(get_avatar( $user_info -> ID ));?>

<div class="portfolio_title"><?php echo(pvs_word_lang("contacts information"));?></div>
<div class="portfolio_box">
	<div><b><?php echo(pvs_word_lang("name"));?>:</b> <?php echo(@$user_info -> first_name);?> <?php echo(@$user_info -> last_name);?></div>
	<div><b><?php echo(pvs_word_lang("address"));?>:</b> <?php echo(@$user_info -> city);?>, <?php echo(@$user_info -> country);?></div>
	<div><b><?php echo(pvs_word_lang("website"));?>:</b> <a href="<?php echo(@$user_info -> user_url);?>"><?php echo(pvs_word_lang("link"));?></a></div>
	<div><b><?php echo(pvs_word_lang("date"));?>:</b> <?php echo(@$user_info -> user_registered);?></div>
	<div><b><?php echo(pvs_word_lang("company"));?>:</b> <?php echo(@$user_info -> company);?></div>
<?php
	if ( $pvs_global_settings["users_rating"] ) {
	$rating_text = "<script>
    			$(function() {
      	$('#star" . @$user_info -> ID . "').raty({
      	score: " . ( float )@$user_info -> rating . ",
 		half: true,
  		number: 5,
  		click: function(score, evt) {
    		vote_rating(" . @$user_info -> ID . ",score);
  		}
	});
    			});
	</script>
	<div id='star" . @$user_info -> ID .
		"' class='users_rating' style='display:inline'></div>";
		echo($rating_text);
	}
?>
</div>

<?php
//Mail link
if ( is_user_logged_in() ) {
	$mail_link = site_url() . "/messages-new/?user=" . @$user_info -> user_login;
} else {
	$mail_link = site_url() . "/login/";
}

//Friend link
if ( is_user_logged_in() ) {
	$sql = "select friend1,friend2 from " . PVS_DB_PREFIX .
		"friends where friend1='" . pvs_result( pvs_get_user_login () ) .
		"' and friend2='" . @$user_info -> user_login . "'";
	$dr->open( $sql );
	if ( $dr->eof ) {
		$friend = pvs_word_lang( "add to friends" );
		$friend_link = "javascript:add_friend('" . @$user_info -> user_login . "')";
	} else {
		$friend = pvs_word_lang( "delete from friends" );
		$friend_link = "javascript:delete_friend('" . @$user_info -> user_login . "')";
	}
} else {
	$friend = pvs_word_lang( "add to friends" );
	$friend_link = site_url() . "/login/";
}

if ( is_user_logged_in() ) {
	$testimonial_link = pvs_user_url( @$user_info -> ID ) . '?section=testimonials';
} else {
	$testimonial_link = site_url() . "/login/";
}
?>

<?php if ( @$user_info -> user_login != pvs_get_user_login () ) {?>
	<div class="portfolio_title"><?php echo(pvs_word_lang("tools"));?></div>
	<div class="portfolio_box">
		<?php if ( $pvs_global_settings["friends"] ) {?>
			<div class="box_members" id="friendbox" name="friendbox"><a href="<?php echo($friend_link);?>"><?php echo($friend);?></a></div>
		<?php }?>
		<?php if ( $pvs_global_settings["messages"] ) {?>
			<div class="box_members"><a href="<?php echo($mail_link);?>"><?php echo(pvs_word_lang("sitemail to user"));?></a></div>
		<?php }?>
		<?php if ( $pvs_global_settings["testimonials"] ) {?>
			<div class="box_members"><a href="<?php echo($testimonial_link);?>"><?php echo(pvs_word_lang("add a testimonial"));?></a></div>
		<?php }?>
	</div>
<?php }?>



<?php
$role = pvs_get_user_type($user_info -> ID);
if ($role == 'seller' or $role == 'common') {

	$viewed_count = 0;
	$downloaded_count = 0;
	$photo_count = 0;
	$video_count = 0;
	$audio_count = 0;
	$vector_count = 0;


	if ( $pvs_global_settings["allow_photo"] ) {
		$sql = "select id,media_id, viewed,downloaded from " . PVS_DB_PREFIX .
			"media where published=1 and author='" . $user_info -> user_login . "'";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
			if ($dr->row["media_id"] == 1) {
				$photo_count ++;
			}
			if ($dr->row["media_id"] == 2) {
				$video_count ++;
			}
			if ($dr->row["media_id"] == 3) {
				$audio_count ++;
			}
			if ($dr->row["media_id"] == 4) {
				$vector_count ++;
			}
			$viewed_count += $dr->row["viewed"];
			$downloaded_count += $dr->row["downloaded"];
			$dr->movenext();
		}
	}
?>
	<div class="portfolio_title"><?php echo(pvs_word_lang("portfolio"));?></div>
	<div class="portfolio_box">
		<?php
		if ( $pvs_global_settings["allow_photo"] ) {
		?>
			<div><b><?php echo(pvs_word_lang("photos"));?>:</b> <a href="<?php echo (site_url( ) );?>/index.php?user=<?php echo(@$user_info -> ID);?>&portfolio=1&sphoto=1"><?php echo($photo_count);?></a></div>
		<?php }?>
		<?php
		if ( $pvs_global_settings["allow_video"] ) {
		?>
			<div><b><?php echo(pvs_word_lang("video"));?>:</b> <a href="<?php echo (site_url( ) );?>/index.php?user=<?php echo(@$user_info -> ID);?>&portfolio=1&svideo=1"><?php echo($video_count);?></a></div>
		<?php }?>
		<?php
		if ( $pvs_global_settings["allow_audio"] ) {
		?>
			<div><b><?php echo(pvs_word_lang("audio"));?>:</b> <a href="<?php echo (site_url( ) );?>/index.php?user=<?php echo(@$user_info -> ID);?>&portfolio=1&saudio=1"><?php echo($audio_count);?></a></div>
		<?php }?>
		<?php
		if ( $pvs_global_settings["allow_vector"] ) {
		?>
			<div><b><?php echo(pvs_word_lang("vector"));?>:</b> <a href="<?php echo (site_url( ) );?>/index.php?user=<?php echo(@$user_info -> ID);?>&portfolio=1&svector=1"><?php echo($vector_count);?></a></div>
		<?php }?>
		<div><b><?php echo(pvs_word_lang("viewed"));?>:</b> <?php echo($viewed_count);?></div>
		<div><b><?php echo(pvs_word_lang("downloads"));?>:</b> <?php echo($downloaded_count);?></div>
	</div>
<?php }?>


		</div>
		</div>
		<div class="col-xl-9 col-lg-9 col-md-9">
			<div class="portfolio_right">
			<h1><?php echo(pvs_show_user_name( $user_info -> user_login ));?></h1>



			<div class="tabs_border2">
			
			<div id="tabs_menu">
			<ul>
			<li <?php
			if ( ! isset($_GET["section"]) ) {
				echo ( "class='activno'" );
			}
			?>><a href="<?php echo pvs_user_url( @$user_info -> ID ); ?>"><?php echo pvs_word_lang( "about" );?></a></li>
			
			<li><a href="<?php echo site_url();
			?>/?user=<?php echo(@$user_info -> ID);?>&portfolio=1"><?php echo pvs_word_lang( "portfolio" );?></a></li>
			
			<?php
			if ( $pvs_global_settings["testimonials"] ) {
			?>
			<li <?php
				if ( @$_GET["section"] == 'testimonials' ) {
					echo ( "class='activno'" );
				}
			?>><a href="<?php echo pvs_user_url( @$user_info -> ID ); ?>?section=testimonials"><?php echo pvs_word_lang( "testimonials" );?></a></li>
			<?php
			}
			?>
			<?php
			if ( $pvs_global_settings["friends"] ) {
			?>
			<li <?php
				if ( @$_GET["section"] == 'friends' ) {
					echo ( "class='activno'" );
				}
			?>><a href="<?php echo pvs_user_url( @$user_info -> ID ); ?>?section=friends"><?php echo pvs_word_lang( "friends" );?></a></li>
			<?php
			}
			?>
			
			
			</ul>
			</div>
			<div id="tabs_menu_content">
<link href="<?php echo(pvs_plugins_url());?>/includes/prints/style.css" rel="stylesheet">




<?php
if (@$_GET['section'] == 'testimonials') {
	?>
	<script>
	testimonials_show('<?php echo $user_info -> user_login; ?>');
	</script>
	<div id="testimonialscontent">
	</div>
	
	<?php
} else if (@$_GET['section'] == 'friends') {
	$sql = "select friend1,friend2 from " . PVS_DB_PREFIX .
	"friends where friend1='" . pvs_result_strict( $user_info -> user_login ) .
	"' and friend2<>'" . pvs_result_strict( $user_info -> user_login ) .
	"'";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		while ( ! $dr->eof ) {
			?>
				<div style="margin-right:50px;padding-bottom:20px;width:150px;float:left" class="seller_list"><?php echo pvs_show_user_avatar( $dr->row["friend2"], "login" );?></div>
			<?php
			$dr->movenext();
		}
	} else {
		echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
	}
} else {
	$flag = false;

	echo ( str_replace( "\n", "<br>", strip_tags( $user_info -> description ) ) );

	if ( pvs_get_user_type($user_info -> ID) == "seller" or pvs_get_user_type($user_info -> ID)== "common" ) {
		$flag = true;
	}


	if ( $flag == true ) {
		echo ( "<div id='flow_body' style='clear:both;margin-top:20px'>" );
	
		$id_parent = 0;
		$_REQUEST["flow"] = 1;
		$_REQUEST["portfolio"] = 1;
		$_REQUEST["user"] = (int) $user_info -> ID;

		include ( "content_list_vars.php" );
		include ( "content_list_items.php" );

		echo ( "</div>" );
		?>
			<script src="<?php echo pvs_plugins_url(); ?>/assets/js/jquery.masonry.min.js"></script>
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
	});
	</script>

			<?php
	}
}

?>
</div></div>
</div>
</td>
</tr>
</table>


							</div>				</div></div>
		</div>
	</div>
</div>
</div>
<br>