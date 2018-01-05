<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


$user_info = get_userdata(get_current_user_id());
?>
<div class="row" style="margin-top:20px"><div class="col-xl-3 col-lg-3 col-md-3 profile_left">
			<div id='profile_menu_top'></div>
			<div id='profile_menu'>
	<div id="profile_photo">
	<a href="<?php echo (site_url( ) );?>/profile/"><?php echo get_avatar(get_current_user_id());
?></a><a href="<?php echo (site_url( ) );?>/profile/"><b><?php echo $user_info -> first_name;
?> <?php echo $user_info -> last_name;
?></b></a>
	<span><a href="<?php echo (site_url( ) );?>/profile-about/"><?php echo pvs_word_lang( "edit" );?></a></span>
	</div>








<?php
if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "common" ) {
?>
	<ul>
		<?php
	if ( ! $pvs_global_settings["printsonly"] ) {
?>
			<li  id="icons_downloads" <?php
		if ( get_query_var('pvs_page') == "profile_downloads" ) {
			echo ( "class='activno'" );
		}
?>><i class="glyphicon glyphicon-floppy-save"> </i> <a href="<?php echo (site_url( ) );?>/profile-downloads/"><?php echo pvs_word_lang( "my downloads" );?></a></li>
		<?php
	}
?>
	
		<?php
	if ( ! $pvs_global_settings["subscription_only"] ) {
?>
			<li  id="icons_orders" <?php
		if ( get_query_var('pvs_page') == "orders" ) {
			echo ( "class='activno'" );
		}
?>><i class="glyphicon glyphicon-shopping-cart"> </i> <a href="<?php echo (site_url( ) );?>/orders/"><?php echo pvs_word_lang( "orders" );?></a></li>
		<?php
	}
?>
	
		<?php
	if ( $pvs_global_settings["credits"] and ! $pvs_global_settings["subscription_only"] ) {
?>
			<li  id="icons_credits" <?php
		if ( get_query_var('pvs_page') == "credits" ) {
			echo ( "class='activno'" );
		}
?>><i class="glyphicon glyphicon-cd"> </i> <a href="<?php echo (site_url( ) );?>/credits/"><?php echo pvs_word_lang( "credits" );?></a></li>
	<?php
		if ( get_query_var('pvs_page') == "credits" ) {
?>
		<ul>
			<li <?php
			if ( ! isset( $_GET["d"] ) or @$_GET["d"] == 2 )
			{
?>class="activno"<?php
			}
?>><a href="<?php echo (site_url( ) );?>/credits/?d=2"><?php
			echo pvs_word_lang( "balance" );?></a></li>																		
			<li <?php
			if ( isset( $_GET["d"] ) and $_GET["d"] == 1 )
			{
?>class="activno"<?php
			}
?>><a href="<?php echo (site_url( ) );?>/credits/?d=1"><?php
			echo pvs_word_lang( "buy credits" );?></a></li>
		</ul>
	<?php
		}
?>
		<?php
	}
?>
	
		<?php
	if ( $pvs_global_settings["subscription"] ) {
?>
			<li  id="icons_subscription" <?php
		if ( get_query_var('pvs_page') == "subscription" ) {
			echo ( "class='activno'" );
		}
?>><i class="glyphicon glyphicon-time"> </i> <a href="<?php echo (site_url( ) );?>/subscription/"><?php echo pvs_word_lang( "subscription" );?></a></li>
		<?php
	}
?>
	
		<li id="icons_coupons" <?php
	if ( get_query_var('pvs_page') == "coupons" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-barcode"> </i> <a href="<?php echo (site_url( ) );?>/coupons/"><?php echo pvs_word_lang( "coupons" );?></a></li>
	
		<?php
	if ( $pvs_global_settings["prints_lab"] ) {
?>
			<li  id="icons_publications" <?php
		if ( get_query_var('pvs_page') == "printslab" ) {
			echo ( "class='activno'" );
		}
?>><i class="glyphicon glyphicon-picture"> </i> <a href="<?php echo (site_url( ) );?>/printslab/"><?php echo pvs_word_lang( "prints lab" );?></a></li>
		<?php
	}
?>
	</ul>
<?php
}
?>












<?php
if ( ( pvs_get_user_type () == "seller" or pvs_get_user_type () ==
	"common" ) and $pvs_global_settings["userupload"] == 1 ) {
?>


<?php
	//Check photographer's rights/limits
	$scategory = false;
	$sphoto = false;
	$svideo = false;
	$saudio = false;
	$svector = false;
	$lvideo = 10;
	$lpreview = 3;
	$laudio = 10;
	$lpreviewaudio = 3;
	$lphoto = 5;
	$lvector = 10;
	$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
		pvs_result( pvs_get_user_category () ) . "'";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["category"] == 1 ) {
			$scategory = true;
		}
		if ( $rs->row["upload"] == 1 ) {
			$sphoto = true;
		}
		if ( $rs->row["upload2"] == 1 ) {
			$svideo = true;
		}
		if ( $rs->row["upload3"] == 1 ) {
			$saudio = true;
		}
		if ( $rs->row["upload4"] == 1 ) {
			$svector = true;
		}

		$lvideo = $rs->row["videolimit"];
		$lpreview = $rs->row["previewvideolimit"];
		$lpreviewvideo = $lpreview;
		$laudio = $rs->row["audiolimit"];
		$lpreviewaudio = $rs->row["previewaudiolimit"];
		$lphoto = $rs->row["photolimit"];
		$lvector = $rs->row["vectorlimit"];
	}
?>

<div class="profile_separator"></div>
	<ul>
		<li  id="icons_upload" <?php
	if ( get_query_var('pvs_page') == "upload" or preg_match("/filemanager/",get_query_var('pvs_page'))  ) {
?>class="activno"<?php
	}
?>><i class="glyphicon glyphicon-upload"> </i> <a href="<?php echo (site_url( ) );?>/upload/"><span><?php echo pvs_word_lang( "upload files" );?></span></a></li>
			<ul style="<?php
	if ( get_query_var('pvs_page') == "upload" or preg_match("/filemanager/",get_query_var('pvs_page')) ) {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">
			
	<?php
	if ( $sphoto == true and $pvs_global_settings["jquery_uploader"] and $pvs_global_settings["allow_photo"] ) {
?>
		<li <?php
		if ( get_query_var('pvs_page') == "filemanager-photo-jquery" ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/filemanager-photo-jquery/"><?php echo pvs_word_lang( "simple photo uploader" );?></a></li>
	<?php
	}
?>
	
	<?php
	if ( $sphoto == true and $pvs_global_settings["plupload_uploader"] and $pvs_global_settings["allow_photo"] ) {
?>
		<li <?php
		if ( get_query_var('pvs_page') == "filemanager-photo-plupload" ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/filemanager-photo-plupload/"><?php echo pvs_word_lang( "plupload photo uploader" );?></a></li>
	<?php
	}
?>
			
	<?php
	if ( $sphoto == true and $pvs_global_settings["java_uploader"] and $pvs_global_settings["allow_photo"] ) {
?>
		<li <?php
		if ( get_query_var('pvs_page') == "filemanager-photo-java" ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/filemanager-photo-java/"><?php echo pvs_word_lang( "java photo uploader" );?></a></li>
	<?php
	}
?>
	

	
	<?php
	if ( $svideo == true and $pvs_global_settings["allow_video"] ) {
?>
		<li <?php
		if ( get_query_var('pvs_page') == "filemanager-video" ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/filemanager-video/"><?php echo pvs_word_lang( "upload video" );?></a></li>
	<?php
	}
?>

	<?php
	if ( $saudio == true and $pvs_global_settings["allow_audio"] ) {
?>
		<li <?php
		if ( get_query_var('pvs_page') == "filemanager-audio" ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/filemanager-audio/"><?php echo pvs_word_lang( "upload audio" );?></a></li>
	<?php
	}
?>

	<?php
	if ( $svector == true and $pvs_global_settings["allow_vector"] ) {
?>
		<li <?php
		if ( get_query_var('pvs_page') == "filemanager-vector" ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/filemanager-vector/"><?php echo pvs_word_lang( "upload vector" );?></a></li>
	<?php
	}
?>

	<?php
	if ( $scategory == true ) {
?>
		<?php
		if ( $pvs_global_settings["examination"] and pvs_get_user_examination () != 1 ) {
		} else {
?>
			<li <?php
			if ( get_query_var('pvs_page') == "filemanager-category" )
			{
				echo ( "class='activno'" );
			}
?>><a href="<?php echo (site_url( ) );?>/filemanager-category/?d=1"><?php
			echo pvs_word_lang( "create category" );?></a></li>
	<?php
		}
	}
?>
			</ul>
		<li  id="icons_publications" <?php
	if ( get_query_var('pvs_page') == "publications" ) {
?>class="activno"<?php
	}
?>><i class="glyphicon glyphicon-picture"> </i> 	<a href="<?php echo (site_url( ) );?>/publications/"><span><?php echo pvs_word_lang( "my publications" );?></span></a></li>
		
<ul style="<?php
	if ( get_query_var('pvs_page') == "publications" ) {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">
	<?php
	if ( $sphoto == true and $pvs_global_settings["allow_photo"] ) {
?>
		<li <?php
		if ( isset( $_GET["d"] ) and $_GET["d"] == 2 ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/publications/?d=2"><?php echo pvs_word_lang( "photos" );?></a></li>
	<?php
	}
?>
			
	
	<?php
	if ( $svideo == true and $pvs_global_settings["allow_video"] ) {
?>
		<li <?php
		if ( isset( $_GET["d"] ) and $_GET["d"] == 3 ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/publications/?d=3"><?php echo pvs_word_lang( "videos" );?></a></li>
	<?php
	}
?>

	<?php
	if ( $saudio == true and $pvs_global_settings["allow_audio"] ) {
?>
		<li <?php
		if ( isset( $_GET["d"] ) and $_GET["d"] == 4 ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/publications/?d=4"><?php echo pvs_word_lang( "audio" );?></a></li>
	<?php
	}
?>

	<?php
	if ( $svector == true and $pvs_global_settings["allow_vector"] ) {
?>
		<li <?php
		if ( isset( $_GET["d"] ) and $_GET["d"] == 5 ) {
			echo ( "class='activno'" );
		}
?>><a href="<?php echo (site_url( ) );?>/publications/?d=5"><?php echo pvs_word_lang( "vector" );?></a></li>
	<?php
	}
?>

	<?php
	if ( $scategory == true ) {
?>
		<?php
		if ( $pvs_global_settings["examination"] and pvs_get_user_examination () != 1 ) {
		} else {
?>
			<li <?php
			if ( isset( $_GET["d"] ) and $_GET["d"] == 1 )
			{
				echo ( "class='activno'" );
			}
?>><a href="<?php echo (site_url( ) );?>/publications/?d=1"><?php
			echo pvs_word_lang( "categories" );?></a></li>
	<?php
		}
	}
?>
			</ul>
		
		<?php
	if ( $pvs_global_settings["model"] ) {
?>
			<li id="icons_models" <?php
		if ( get_query_var('pvs_page') == "models" ) {
?>class="activno"<?php
		}
?>><i class="glyphicon glyphicon-user"> </i> <a href="<?php echo (site_url( ) );?>/models/"><span><?php echo pvs_word_lang( "models" );?></span></a></li>
		<?php
	}
?>
		<li id="icons_commission" <?php
	if ( get_query_var('pvs_page') == "commission" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-piggy-bank"> </i> <a href="<?php echo (site_url( ) );?>/commission/"><?php echo pvs_word_lang( "my commission" );?></a></li>
		<ul style="<?php
	if ( get_query_var('pvs_page') == "commission" ) {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">
			<li <?php
	if ( @$_GET["d"] == 1 or @$_GET["d"] == 0 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/commission/?d=1"><?php echo pvs_word_lang( "balance" );?></a></li>
			<li <?php
	if ( @$_GET["d"] == 2 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/commission/?d=2"><?php echo pvs_word_lang( "earning" );?></a></li>
			<li <?php
	if ( @$_GET["d"] == 3 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/commission/?d=3"><?php echo pvs_word_lang( "refund" );?></a></li>
			<li <?php
	if ( @$_GET["d"] == 4 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/commission/?d=4"><?php echo pvs_word_lang( "settings" );?></a></li>
		</ul>
	</ul>
<?php
}
?>




<?php
if ( ( pvs_get_user_type () == "affiliate" or pvs_get_user_type () ==
	"common" ) and $pvs_global_settings["affiliates"] == 1 ) {
?>
<div class="profile_separator"></div>
	<ul>
		<li  id="icons_partner" <?php
	if ( get_query_var('pvs_page') == "affiliate" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-thumbs-up"> </i> <a href="/affiliate/?d=1"><?php echo pvs_word_lang( "affiliate" );?></a></li>
			<ul style="<?php
	if ( get_query_var('pvs_page') == "affiliate" ) {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">
	<li <?php
	if ( @$_GET["d"] == 1 or @$_GET["d"] == 0 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/affiliate/?d=1"><?php echo pvs_word_lang( "balance" );?></a></li>
	<li <?php
	if ( @$_GET["d"] == 2 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/affiliate/?d=2"><?php echo pvs_word_lang( "earning" );?></a></li>
	<li <?php
	if ( @$_GET["d"] == 3 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/affiliate/?d=3"><?php echo pvs_word_lang( "refund" );?></a></li>
	<li <?php
	if ( @$_GET["d"] == 4 ) {
		echo ( "class='activno'" );
	}
?>><a href="<?php echo (site_url( ) );?>/affiliate/?d=4"><?php echo pvs_word_lang( "settings" );?></a></li>
			</ul>
	</ul>
<?php
}
?>



<div class="profile_separator"></div>

<ul>
<?php
if ( $pvs_global_settings["lightboxes"] ) {
?>
	<li id="icons_lightbox"><i class="glyphicon glyphicon-heart"> </i> <a href="<?php echo (site_url( ) );?>/my-favorite-list/"><?php echo pvs_word_lang( "my favorite list" );?></a></li>
<?php
}
if ( $pvs_global_settings["support"] ) {

	$new_support = "";
	$support_qty = 0;
	$sql = "select id from " . PVS_DB_PREFIX . "support_tickets where user_id='" . get_current_user_id() . "' and id_parent=0";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		while ( ! $rs->eof ) {
			$sql = "select count(id) as count_id from " . PVS_DB_PREFIX .
				"support_tickets where id_parent=" . $rs->row["id"] . " and viewed_user=0";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$support_qty += $ds->row["count_id"];
			}

			$rs->movenext();
		}

		if ( $support_qty != 0 ) {
			$new_support = "&nbsp;&nbsp;<span class='badge badge-important'>" . $support_qty .
				"</span>";
		}
	}
?>
	<li id="icons_comments" <?php
	if ( get_query_var('pvs_page') == "support" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-comment"> </i> <a href="<?php echo (site_url( ) );?>/support/"><?php echo pvs_word_lang( "support" );?></a>  <?php
	if ( get_query_var('pvs_page') != "support" ) {
		echo ( $new_support );
	}
?></li>
<?php
}
?>

<?php
if ( $pvs_global_settings["friends"] ) {
?>
	<li id="icons_friends" <?php
	if ( get_query_var('pvs_page') == "friends" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-user"> </i> <a href="<?php echo (site_url( ) );?>/friends/"><?php echo pvs_word_lang( "friends" );?></a></li>
<?php
}
?>

<?php
if ( $pvs_global_settings["messages"] ) {

	$new_message = "";
	$sql = "select touser,trash,viewed,del from " . PVS_DB_PREFIX .
		"messages where touser='" . pvs_result( pvs_get_user_login () ) .
		"' and trash=0 and viewed=0 and del=0";
	$rs->open( $sql );
	if ( $rs->rc > 0 ) {
		$new_message = "&nbsp;&nbsp;<span class='badge badge-important'>" . $rs->rc .
			"</span>";
	}
?>
<li id="icons_messages" <?php
	if ( get_query_var('pvs_page') == "messages"  or get_query_var('pvs_page') == "messages-new" or get_query_var('pvs_page') == "messages-sent" or get_query_var('pvs_page') == "messages-trash"  or get_query_var('pvs_page') == "messages-content" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-envelope"> </i> <a href="<?php echo (site_url( ) );?>/messages/"><?php echo pvs_word_lang( "messages" );?></a> <?php
		echo ( $new_message );
?></li>

<ul style="<?php
	if ( get_query_var('pvs_page') == "messages" or get_query_var('pvs_page') == "messages-new" or get_query_var('pvs_page') == "messages-sent" or get_query_var('pvs_page') == "messages-trash"  or get_query_var('pvs_page') == "messages-content") {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">





<li <?php
	if ( isset( $type ) and $type == "inbox" ) {
?>class="activno"<?php
	}
?>><a href="<?php echo (site_url( ) );?>/messages/"><?php echo pvs_word_lang( "inbox" );?></a>
</li>

<li <?php
	if ( isset( $type ) and $type == "sent" ) {
?>class="activno"<?php
	}
?>><a href="<?php echo (site_url( ) );?>/messages-sent/"><?php echo pvs_word_lang( "sentbox" );?></a> 
</li>

<li <?php
	if ( isset( $type ) and $type == "trash" ) {
?>class="activno"<?php
	}
?>><a href="<?php echo (site_url( ) );?>/messages-trash/"><?php echo pvs_word_lang( "trash" );?></a> 
</li>







</ul>


<?php
}
?>

<?php
if ( $pvs_global_settings["reviews"] ) {
?>
<li id="icons_comments" <?php
	if ( get_query_var('pvs_page') == "reviews" or get_query_var('pvs_page') == "reviews-for-me" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-comment"> </i> <a href="<?php echo (site_url( ) );?>/reviews/"><?php echo pvs_word_lang( "reviews" );?></a></li>

<ul style="<?php
	if ( get_query_var('pvs_page') == "reviews" or get_query_var('pvs_page') == "reviews-for-me" ) {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">
<li <?php
	if ( isset( $type ) and $type == "mine" ) {
?>class="activno"<?php
	}
?>> <a href="<?php echo (site_url( ) );?>/reviews/" ><?php echo pvs_word_lang( "mine" );?></a></li>
<li <?php
	if ( isset( $type ) and $type == "for me" ) {
?>class="activno"<?php
	}
?>><a href="<?php echo (site_url( ) );?>/reviews-for-me/"><?php echo pvs_word_lang( "for me" );?></a></li>
</ul>
<?php
}
?>
<?php
if ( $pvs_global_settings["testimonials"] ) {
?>
<li  id="icons_testimonials" <?php
	if ( get_query_var('pvs_page') == "testimonials" or get_query_var('pvs_page') == "testimonials-for-me" ) {
		echo ( "class='activno'" );
	}
?>><i class="glyphicon glyphicon-star"> </i> <a href="<?php echo (site_url( ) );?>/testimonials/"><?php echo pvs_word_lang( "testimonials" );?></a></li>


<ul style="<?php
	if ( get_query_var('pvs_page') == "testimonials" or get_query_var('pvs_page') == "testimonials-for-me" ) {
		echo ( "display:block" );
	} else {
		echo ( "display:none" );
	}
?>">
<li <?php
	if ( isset( $type ) and $type == "mine" ) {
?>class="activno"<?php
	}
?>><a href="<?php echo (site_url( ) );?>/testimonials/" ><?php echo pvs_word_lang( "mine" );?></a></li>
<li <?php
	if ( isset( $type ) and $type == "for me" ) {
?>class="activno"<?php
	}
?>><a href="<?php echo (site_url( ) );?>/testimonials-for-me/"><?php echo pvs_word_lang( "for me" );?></a></li>
</ul>



<?php
}
?>
<li id="icons_preview"><i class="glyphicon glyphicon-eye-open"> </i> <a href="<?php echo pvs_user_url( get_current_user_id() );?>"><?php echo pvs_word_lang( "preview" );?></a></li>
</ul>

</div>
			<div id='profile_menu_bottom'></div>
</div><div class="col-xl-9 col-lg-9 col-md-9 search_right">
	
	<link rel="stylesheet" href="<?php echo ( pvs_plugins_url() );?>/assets/js/treeview/jquery.treeview.css" />
	<script src="<?php echo ( pvs_plugins_url() );?>/assets/js/treeview/jquery.cookie.js"></script>
	<script src="<?php echo ( pvs_plugins_url() );?>/assets/js/treeview/jquery.treeview.js"></script>
	<script>
	
	function model_add(model_id,type,model_name) 
	{	
		if(type==0) {
			type_name="<?php echo pvs_word_lang( "Model release" )?>";
		}
		else
		{
			type_name="<?php echo pvs_word_lang( "Property release" )?>";
		}
		
		$('#models_list').append("<div  style='clear:both;margin:5px 0px 5px 0px' id='div_"+model_id+"'><a href='<?php echo (site_url( ) );?>/models-content/?id="+model_id+"' class='btn btn-default btn-small'><b><i class='fa fa-check' aria-hidden='true'></i> "+type_name+":</b> "+model_name+"</a> <button class='btn btn-danger btn-small' type='button' onClick=\"pvs_model_delete('"+model_id+"');\"><?php echo pvs_word_lang( "delete" )?></button><input type='hidden' name='model"+model_id+"' value='"+type+"'></div>");
		
		document.getElementById('model0_'+model_id.toString()).style.display='none';
		document.getElementById('model1_'+model_id.toString()).style.display='none';
	}
	
	function pvs_model_delete(model_id) 
	{
		$('#div_'+model_id.toString()).remove()
		document.getElementById('model0_'+model_id.toString()).style.display='block';
		document.getElementById('model1_'+model_id.toString()).style.display='block';
	}
	
	function set_license(value) 
	{
		if(value==1)
		{
			document.getElementById('box_license2').style.display='none';
			document.getElementById('box_license1').style.display='block';
		}
		else
		{
			document.getElementById('box_license2').style.display='block';
			document.getElementById('box_license1').style.display='none';
		}
	}
	
	function change_group(value) 
	{
		$(".group_settings").css("display","none");
		$(".group_"+value).css("display","block");
		$("li.menu_settings").removeClass('active');
		$("li.menu_settings_"+value).addClass('active');
		$("li.menu_settings a").removeClass('active');
		$("li.menu_settings_"+value+" a").addClass('active');
		
		if(value == 'google') {
			$(document).gMapsLatLonPicker().init( $(".gllpLatlonPicker") );
		}
	}
	</script>
	

