<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_site" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Update settings
if ( @$_POST["action"] == 'update' )
{

	$sql = "select * from " . PVS_DB_PREFIX .
		"settings where stype='site'  and priority>0";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		if ( isset( $_POST[$rs->row["setting_key"]] ) )
		{
			$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . pvs_result( $_POST[$rs->
				row["setting_key"]] ) . "' where id=" . $rs->row["id"];
			$db->execute( $sql );
		} else
		{
			$sql = "update " . PVS_DB_PREFIX . "settings set svalue='0' where id=" . $rs->
				row["id"];
			$db->execute( $sql );
		}
		$rs->movenext();
	}
}
?>



<h1><?php
echo pvs_word_lang( "settings" );
?></h1>

<?php
$pvs_setting_group_name['content'] = pvs_word_lang( 'content' );
$pvs_setting_group_name['orders'] = pvs_word_lang( 'orders' );
$pvs_setting_group_name['users'] = pvs_word_lang( 'users' );
$pvs_setting_group_name['catalog'] = pvs_word_lang( 'catalog' );
$pvs_setting_group_name['categories'] = pvs_word_lang( 'categories' );
$pvs_setting_group_name['preview'] = pvs_word_lang( 'preview' );
$pvs_setting_group_name['upload'] = pvs_word_lang( 'Upload process' );
$pvs_setting_group_name['prints'] = pvs_word_lang( 'prints' );
$pvs_setting_group_name['google'] = pvs_word_lang( 'Google' );
$pvs_setting_group_name['lang'] = pvs_word_lang( 'languages' );
$pvs_setting_group_name['other'] = pvs_word_lang( 'other' );

$pvs_setting_group_style['content'] = 'snd';
$pvs_setting_group_style['orders'] = 'snd';
$pvs_setting_group_style['users'] = 'snd';
$pvs_setting_group_style['catalog'] = 'snd';
$pvs_setting_group_style['categories'] = 'snd';
$pvs_setting_group_style['preview'] = 'snd';
$pvs_setting_group_style['upload'] = 'snd';
$pvs_setting_group_style['prints'] = 'snd';
$pvs_setting_group_style['google'] = 'snd';
$pvs_setting_group_style['lang'] = 'snd';
$pvs_setting_group_style['other'] = 'snd';

$pvs_setting_group['site_name'] = 'other';
$pvs_setting_group['allow_photo'] = 'content';
$pvs_setting_group['allow_video'] = 'content';
$pvs_setting_group['allow_audio'] = 'content';
$pvs_setting_group['allow_vector'] = 'content';
$pvs_setting_group['prints'] = 'prints';
$pvs_setting_group['prints_users'] = 'prints';
$pvs_setting_group['printsonly'] = 'prints';
$pvs_setting_group['prints_lab'] = 'prints';
$pvs_setting_group['prints_lab_filesize'] = 'prints';
$pvs_setting_group['userupload'] = 'users';
$pvs_setting_group['affiliates'] = 'users';
$pvs_setting_group['common_account'] = 'users';
$pvs_setting_group['site_guest'] = 'users';
$pvs_setting_group['examination'] = 'users';
$pvs_setting_group['moderation'] = 'users';
$pvs_setting_group['credits'] = 'orders';
$pvs_setting_group['credits_currency'] = 'orders';
$pvs_setting_group['rights_managed'] = 'content';
$pvs_setting_group['rights_managed_sellers'] = 'content';
$pvs_setting_group['royalty_free'] = 'content';
$pvs_setting_group['subscription'] = 'orders';
$pvs_setting_group['subscription_only'] = 'orders';
$pvs_setting_group['k_str'] = 'catalog';
$pvs_setting_group['sorting_catalog'] = 'catalog';
$pvs_setting_group['adult_content'] = 'catalog';
$pvs_setting_group['contacts_price'] = 'content';
$pvs_setting_group['exclusive_price'] = 'content';
$pvs_setting_group['search_history'] = 'catalog';
$pvs_setting_group['image_resize'] = 'preview';
$pvs_setting_group['resolution_dpi'] = 'preview';
$pvs_setting_group['thumb_width'] = 'preview';
$pvs_setting_group['thumb_height'] = 'preview';
$pvs_setting_group['thumb_width2'] = 'preview';
$pvs_setting_group['thumb_height2'] = 'preview';
$pvs_setting_group['category_preview'] = 'categories';
$pvs_setting_group['lightbox_photo'] = 'preview';
$pvs_setting_group['max_hover_size'] = 'preview';
$pvs_setting_group['lightbox_video'] = 'preview';
$pvs_setting_group['video_width'] = 'preview';
$pvs_setting_group['video_height'] = 'preview';
$pvs_setting_group['catalog_view'] = 'catalog';
$pvs_setting_group['grid'] = 'catalog';
$pvs_setting_group['fixed_width'] = 'catalog';
$pvs_setting_group['fixed_height'] = 'catalog';
$pvs_setting_group['width_flow'] = 'catalog';
$pvs_setting_group['height_flow'] = 'catalog';
$pvs_setting_group['auto_paging'] = 'catalog';
$pvs_setting_group['auto_paging_default'] = 'catalog';
$pvs_setting_group['left_search'] = 'catalog';
$pvs_setting_group['left_search_default'] = 'catalog';
$pvs_setting_group['no_calculation'] = 'catalog';
$pvs_setting_group['no_calculation_result'] = 'catalog';
$pvs_setting_group['no_calculation_total'] = 'catalog';
$pvs_setting_group['max_price'] = 'catalog';
$pvs_setting_group['qnews'] = 'other';
$pvs_setting_group['userstatus'] = 'users';
$pvs_setting_group['content_type'] = 'content';
$pvs_setting_group['show_content_type'] = 'content';
$pvs_setting_group['show_users_type'] = 'users';
$pvs_setting_group['avatarwidth'] = 'users';
$pvs_setting_group['userphotowidth'] = 'users';
$pvs_setting_group['photopreupload'] = 'upload';
$pvs_setting_group['videopreupload'] = 'upload';
$pvs_setting_group['audiopreupload'] = 'upload';
$pvs_setting_group['vectorpreupload'] = 'upload';
$pvs_setting_group['messages'] = 'other';
$pvs_setting_group['testimonials'] = 'other';
$pvs_setting_group['reviews'] = 'other';
$pvs_setting_group['friends'] = 'other';
$pvs_setting_group['support'] = 'other';
$pvs_setting_group['download_limit'] = 'orders';
$pvs_setting_group['download_expiration'] = 'orders';
$pvs_setting_group['download_sample'] = 'orders';
$pvs_setting_group['related_items'] = 'catalog';
$pvs_setting_group['related_items_quantity'] = 'catalog';
$pvs_setting_group['zoomer'] = 'catalog';
$pvs_setting_group['model'] = 'catalog';
$pvs_setting_group['show_model'] = 'catalog';
$pvs_setting_group['bulk_upload'] = 'upload';
$pvs_setting_group['google_coordinates'] = 'google';
$pvs_setting_group['google_api'] = 'google';
$pvs_setting_group['exif'] = 'catalog';
$pvs_setting_group['google_captcha'] = 'google';
$pvs_setting_group['google_recaptcha'] = 'google';
$pvs_setting_group['google_captcha_public'] = 'google';
$pvs_setting_group['google_captcha_private'] = 'google';
$pvs_setting_group['java_uploader'] = 'upload';
$pvs_setting_group['flash_uploader'] = 'upload';
$pvs_setting_group['jquery_uploader'] = 'upload';
$pvs_setting_group['plupload_uploader'] = 'upload';
$pvs_setting_group['photo_uploader'] = 'upload';
$pvs_setting_group['video_uploader'] = 'upload';
$pvs_setting_group['audio_uploader'] = 'upload';
$pvs_setting_group['vector_uploader'] = 'upload';
$pvs_setting_group['seller_prices'] = 'users';
$pvs_setting_group['language_detection'] = 'lang';
$pvs_setting_group['weight'] = 'prints';
$pvs_setting_group['cd_weight'] = 'other';
$pvs_setting_group['auth_freedownload'] = 'orders';
$pvs_setting_group['daily_download_limit'] = 'orders';
$pvs_setting_group['auth_rating'] = 'catalog';
$pvs_setting_group['users_rating'] = 'users';
$pvs_setting_group['users_rating_limited'] = 'users';
$pvs_setting_group['multilingual_categories'] = 'lang';
$pvs_setting_group['multilingual_publications'] = 'lang';
$pvs_setting_group['taxes_cart'] = 'orders';
$pvs_setting_group['show_in_stock'] = 'prints';
$pvs_setting_group['show_not_in_stock'] = 'prints';
$pvs_setting_group['seller_prints_quantity'] = 'prints';
$pvs_setting_group['upload_previews'] = 'preview';
$pvs_setting_group['telephone'] = 'other';
$pvs_setting_group['facebook_link'] = 'other';
$pvs_setting_group['google_link'] = 'other';
$pvs_setting_group['twitter_link'] = 'other';
$pvs_setting_group['show_colors'] = 'catalog';
$pvs_setting_group['colors_number'] = 'catalog';
$pvs_setting_group['collections'] = 'orders';
$pvs_setting_group['category_view'] = 'categories';
$pvs_setting_group['category_items'] = 'categories';
$pvs_setting_group['category_sort'] = 'categories';
$pvs_setting_group['company_address'] = 'other';
$pvs_setting_group['upload_terms'] = 'upload';
$pvs_setting_group['wordpress_signup'] = 'users';
$pvs_setting_group['invoices'] = 'orders';
$pvs_setting_group['lightboxes'] = 'orders';
$pvs_setting_group['examination_description'] = 'users';
$pvs_setting_group['examination_result'] = 'users';
$pvs_setting_group['ffmpeg_video_width'] = 'preview';
$pvs_setting_group['ffmpeg_video_height'] = 'preview';


$pvs_disabled_options = array();

if ( PVS_LICENSE == 'Lite' ) {
	$pvs_disabled_options = array(
		'userupload',
		'affiliates',
		'common_account',
		'examination',
		'seller_prices'
	);
}

if ( PVS_LICENSE == 'Free' ) {
	$pvs_disabled_options = array(
		'userupload',
		'affiliates',
		'common_account',
		'examination',
		'seller_prices',
		'prints_lab',
		'rights_managed',
		'rights_managed_sellers',
		'credits',
		'credits_currency',
		'subscription',
		'subscription_only',
		'no_calculation',
		'show_content_type',
		'messages',
		'testimonials',
		'reviews',
		'friends',
		'support',
		'multilingual_categories',
		'multilingual_publications',
		'taxes_cart',
		'show_in_stock',
		'seller_prints_quantity',
		'show_not_in_stock',
		'upload_previews',
		'collections',
		'invoices',
		'lightboxes'
	);
}

$pvs_group_default = 'content';
if ( isset( $_REQUEST["group_name"] ) and $_REQUEST["group_name"] != '' )
{
	$pvs_group_default = pvs_result( $_REQUEST["group_name"] );
}
?>

<h2 class="nav-tab-wrapper">
<?php
foreach ( $pvs_setting_group_name as $key => $value )
{
	$sel = '';
	if ( $key == $pvs_group_default )
	{
		$sel = "nav-tab-active";
	}
?>
	<a href="javascript:change_group('<?php
	echo ( $key );
?>')" class="nav-tab menu_settings menu_settings_<?php
	echo ( $key );
?> <?php
	echo ( $sel );
?>"><?php
	echo ( $value );
?></a>
	<?php
}
?>
</h2>


<script>
function change_group(value)
{
	$(".group_settings").css("display","none");
	$(".group_"+value).css("display","table-row");
	$(".menu_settings").removeClass('nav-tab-active');
	$(".menu_settings_"+value).addClass('nav-tab-active');
	$("#group_name").val(value);
}

$(document).ready(function() {
	change_group('<?php
echo ( $pvs_group_default );
?>');
});
</script>


<form method="post">
<input type="hidden" name="action" value="update">
<input type="hidden" id="group_name" name="group_name" value="<?php
echo ( $pvs_group_default );
?>">
<table class="wp-list-table widefat fixed posts">
<?php
$sql = "select * from " . PVS_DB_PREFIX .
	"settings where stype='site' and priority>0 order by priority,name ";
$rs->open( $sql );
while ( ! $rs->eof )
{

	if ( isset( $pvs_setting_group[$rs->row["setting_key"]] ) )
	{
		$style = "class='group_settings " . $pvs_setting_group_style[$pvs_setting_group[$rs->
			row["setting_key"]]] . " group_" . $pvs_setting_group[$rs->row["setting_key"]] .
			"'";
	} else
	{
		$style = "class='group_settings " . $pvs_setting_group_style[$pvs_setting_group[$rs->
			row["setting_key"]]] . " group_other'";
	}

	if ( @$pvs_setting_group_style[$pvs_setting_group[$rs->row["setting_key"]]] ==
		'snd' )
	{
		$pvs_setting_group_style[$pvs_setting_group[$rs->row["setting_key"]]] = '';
	} else
	{
		$pvs_setting_group_style[$pvs_setting_group[$rs->row["setting_key"]]] = 'snd';
	}
?>
		<tr valign="top" <?php
	echo ( $style );
?>>
		<td><?php
	echo pvs_word_lang( $rs->row["name"] );
?>:</td>
		<td style="width:70%">
		<?php
	if ( $rs->row["checkboxes"] == 1 )
	{
		$disable_text = '';
		$disable_alt = pvs_word_lang( "enable" );
		if (in_array($rs->row["setting_key"], $pvs_disabled_options)) {
			$disable_text = 'disabled';
			
			if ( PVS_LICENSE == 'Free' ) {
				$disable_alt = pvs_word_lang('Disabled in Free version');
			}
			
			if ( PVS_LICENSE == 'Lite' ) {
				$disable_alt = pvs_word_lang('Disabled in Lite version') ;
			}
		}
?>
				<input type="checkbox" name="<?php
		echo $rs->row["setting_key"];
?>" value="1" <?php
		if ( @$pvs_global_settings[ $rs->row["setting_key"] ] == 1 )
		{
			echo ( "checked" );
		}
?> <?php echo($disable_text );?>> <?php
		echo $disable_alt ;
?>
				<?php
	} elseif ( $rs->row["setting_key"] == 'userstatus' )
	{
?>
				<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:150px" class="ibox form-control">
				<?php
		$sql = "select * from " . PVS_DB_PREFIX . "user_category order by priority";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
			$sel = "";
			if ( $rs->row["svalue"] == $dr->row["name"] )
			{
				$sel = "selected";
			}
?>
					<option value="<?php
			echo $dr->row["name"];
?>" <?php
			echo $sel;
?>><?php
			echo $dr->row["name"];
?></option>
					<?php
			$dr->movenext();
		}
?>
				</select>
			<?php
	} elseif ( $rs->row["setting_key"] == 'catalog_view' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:350px" class="ibox form-control">
				<option value="grid" <?php
		if ( $rs->row["svalue"] == "grid" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "grid" );
?></option>
				
				<option value="fixed_width" <?php
		if ( $rs->row["svalue"] == "fixed_width" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "fixed width" );
?></option>
				
				<option value="fixed_height" <?php
		if ( $rs->row["svalue"] == "fixed_height" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "fixed height" );
?></option>
			</select>
			
			<?php
				} elseif ( $rs->row["setting_key"] == 'category_view' ) {
?>
			<select  name="<?php echo $rs->row["setting_key"] ?>" style="width:350px" class="ibox form-control">
				<option value="grid" <?php
		if ( $rs->row["svalue"] == "grid" ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "grid" )?></option>
				
				<option value="fixed_width" <?php
		if ( $rs->row["svalue"] == "fixed_width" ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "fixed width" )?></option>
				

			</select>
			
			
			
			<?php
	} elseif ( $rs->row["setting_key"] == 'show_users_type' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:150px" class="ibox form-control">
				<option value="login" <?php
		if ( $rs->row["svalue"] == "login" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "login" );
?></option>
				<option value="name" <?php
		if ( $rs->row["svalue"] == "name" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "name" );
?></option>
			</select>
			<?php
	} elseif ( $rs->row["setting_key"] == 'image_resize' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:150px" class="ibox form-control">
				<option value="GD" <?php
		if ( $rs->row["svalue"] == "GD" )
		{
			echo ( "selected" );
		}
?>>GD</option>
				<option value="ImageMagick" <?php
		if ( $rs->row["svalue"] == "ImageMagick" )
		{
			echo ( "selected" );
		}
?>>ImageMagick</option>
			</select>
			<?php
	} elseif ( $rs->row["setting_key"] == 'sorting_catalog' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:200px" class="ibox form-control">
				<option value="downloaded" <?php
		if ( $rs->row["svalue"] == "downloaded" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "most downloaded" );
?></option>
				<option value="popular" <?php
		if ( $rs->row["svalue"] == "popular" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "most popular" );
?></option>
				<option value="date" <?php
		if ( $rs->row["svalue"] == "date" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "date" );
?></option>

				<option value="rated" <?php
		if ( $rs->row["svalue"] == "rated" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "top rated" );
?></option>
			</select>
			<?php
				} elseif ( $rs->row["setting_key"] == 'category_sort' ) {
?>
			<select  name="<?php echo $rs->row["setting_key"] ?>" style="width:200px" class="ibox form-control">
				<option value="priority" <?php
		if ( $rs->row["svalue"] == "priority" ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "priority" )?></option>
				<option value="title" <?php
		if ( $rs->row["svalue"] == "title" ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "title" )?></option>
				<option value="date" <?php
		if ( $rs->row["svalue"] == "date" ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "date" )?></option>
			</select>
			
			
			
			
			<?php
	} elseif ( $rs->row["setting_key"] == 'weight' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:200px" class="ibox form-control">
				<option value="kg" <?php
		if ( $rs->row["svalue"] == "kg" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "kg" );
?></option>
				<option value="lbs" <?php
		if ( $rs->row["svalue"] == "lbs" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "lbs" );
?></option>
			</select>
			<?php
	} elseif ( $rs->row["setting_key"] == 'photo_uploader' or $rs->row["setting_key"] ==
	'video_uploader' or $rs->row["setting_key"] == 'audio_uploader' or $rs->row["setting_key"] ==
		'vector_uploader' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:200px" class="ibox form-control">
				<option value="usual uploader" <?php
		if ( $rs->row["svalue"] == "usual uploader" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "usual uploader" );
?></option>
				<option value="jquery uploader" <?php
		if ( $rs->row["svalue"] == "jquery uploader" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "jquery uploader" );
?></option>
			</select>
			<?php
	} elseif ( $rs->row["setting_key"] == 'meta_keywords' or $rs->row["setting_key"] ==
	'meta_description' or $rs->row["setting_key"] == 'company_address' )
	{
?>
			<textarea   name="<?php
		echo $rs->row["setting_key"];
?>" style="width:400px;height:90px" class="ibox form-control"><?php
		echo $rs->row["svalue"];
?></textarea>
			<?php
	} elseif ( $rs->row["setting_key"] == 'content_type' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:150px" class="ibox form-control">
			<?php
		$sql = "select * from " . PVS_DB_PREFIX . "content_type order by priority";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
			$sel = "";
			if ( $rs->row["svalue"] == $dr->row["name"] )
			{
				$sel = "selected";
			}
?>
				<option value="<?php
			echo $dr->row["name"];
?>" <?php
			echo $sel;
?>><?php
			echo $dr->row["name"];
?></option>
				<?php
			$dr->movenext();
		}
?>
			</select>
			<?php
	} 
	 elseif ( $rs->row["setting_key"] == 'upload_terms' or $rs->row["setting_key"] == 'examination_description' or $rs->row["setting_key"] == 'examination_result' )
	{
?>
			<select  name="<?php
		echo $rs->row["setting_key"];
?>" style="width:200px" class="ibox form-control">
			<option value="0"></option>
				<?php
		$sql = "select ID, post_title from " . $table_prefix .
			"posts where post_type = 'page' and post_status = 'publish' order by post_title";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$sel = "";
			if ( $ds->row["ID"] == $rs->row["svalue"]  )
			{
				$sel = "selected";
			}
?>
					<option value="<?php
			echo $ds->row["ID"]
?>" <?php
			echo $sel
?>><?php
			echo $ds->row["post_title"]
?></option>
					<?php
			$ds->movenext();
		}
?>
			</select>
			<?php
	} else
	{
?><input type="text" name="<?php
		echo $rs->row["setting_key"];
?>" class="ibox form-control" style="width:400px" value="<?php
		echo $rs->row["svalue"];
?>"><?php
	}
?>
		</td>
		</tr>
		<?php
	$rs->movenext();
}
?>
	</table>
	
	<br>
	<p><input type="submit" value="<?php
echo pvs_word_lang( "save" );
?>" class="button button-primary button-large"></p>
</form>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>