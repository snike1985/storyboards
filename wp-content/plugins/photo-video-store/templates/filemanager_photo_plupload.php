<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	exit();
}

include ( "profile_top.php" );


$formats = "";
$sql = "select id,photo_type from " . PVS_DB_PREFIX .
	"photos_formats where enabled=1 and photo_type<>'jpg' order by id";
$dr->open( $sql );
while ( ! $dr->eof ) {
	if ( $formats != "" ) {
		$formats .= ",";
	}
	$formats .= "*." . $dr->row["photo_type"];
	$dr->movenext();
}


?>

<script>
$(document).ready(function() {
	change_group('upload');
});
</script>

<h1><?php echo pvs_word_lang( "plupload photo uploader" )?></h1>


<br>
<div class="nav-tabs-custom tabs-style-2">
	<ul class="nav nav-tabs" style="margin-left:0px">
	  <li class="menu_settings menu_settings_upload"><a href="javascript:change_group('upload')" class="nav-link active"><?php echo pvs_word_lang( "photos" )?></a></li>
	  <?php
		if ( ! $pvs_global_settings["printsonly"] ) {
		?>
				<li class="menu_settings menu_settings_price"><a href="javascript:change_group('price')" class="nav-link"><?php echo pvs_word_lang( "price" )?></a></li>
			  <?php
		}
		?>
	  <?php
		if ( $pvs_global_settings["prints"] ) {
		?>
				<li class="menu_settings menu_settings_prints"><a href="javascript:change_group('prints')" class="nav-link"><?php echo pvs_word_lang( "prints" )?></a></li>
			  <?php
		}
		?>
	  <li class="menu_settings menu_settings_categories"><a href="javascript:change_group('categories')" class="nav-link"><?php echo pvs_word_lang( "categories" )?></a></li>
	  <li class="menu_settings menu_settings_other"><a href="javascript:change_group('other')" class="nav-link"><?php echo pvs_word_lang( "settings" )?></a></li>
	  <li class="menu_settings menu_settings_models"><a href="javascript:change_group('models')" class="nav-link"><?php echo pvs_word_lang( "models" )?></a></li>
	  <?php
		if ( $pvs_global_settings["google_coordinates"] ) {
		?>
				<li class="menu_settings menu_settings_google"><a href="javascript:change_group('google')" class="nav-link"><?php echo pvs_word_lang( "Google map" )?></a></li>
			  <?php
		}
		?>
	</ul>
</div>
<div style="padding:20px" class="tab-content">

<div class='group_settings group_upload'>
<p><?php echo pvs_word_lang( "select files" )?>. (*.jpg <  <?php echo $lphoto?>M)</b></p>



<?php
if ( $formats != "" ) {
?>
<p><?php echo str_replace( "{FORMATS}", $formats, pvs_word_lang( "If you want to upload additional formats {FORMATS} the files must have the same names as *.jpg." ) )?></p>
<?php
}
?>

<?php
$tmp_folder = "user_" . get_current_user_id();
if ( file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder ) ) {
	$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." ) {
			if ( is_file( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" .
				$file ) )
			{
				@unlink( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $file );
			}
			if ( is_dir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" .
				$file ) )
			{
				$dir2 = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder .
					"/" . $file );
				while ( $file2 = readdir( $dir2 ) )
				{
					if ( $file2 <> "." && $file2 <> ".." )
					{
						if ( is_file( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" .
							$file . "/" . $file2 ) )
						{
							@unlink( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $file .
								"/" . $file2 );
						}
					}
				}
				rmdir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $file );
			}
		}
	}
} else {
	mkdir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
}
?>







<!-- Load Queue widget CSS and jQuery -->
<style type="text/css">@import url(<?php echo pvs_plugins_url()?>/includes/plugins/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>

<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/plupload/browserplus-min.js"></script>

<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/plupload/plupload.full.min.js"></script>
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script>
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'flash,gears,silverlight,browserplus,html5',
		url : '<?php echo (site_url( ) );?>/upload-photo-plupload/',
		max_file_size : '<?php echo $lphoto
?>mb',

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,jpeg,gif,png,raw,tif,tiff,eps"}
		],

		// Flash settings
		//flash_swf_url : '<?php echo pvs_plugins_url()?>/includes/plugins/plupload/plupload.flash.swf',

		// Silverlight settings
		//silverlight_xap_url : '<?php echo pvs_plugins_url()?>/includes/plugins/plupload/plupload.silverlight.xap'
	});

	// Client side form validation
	$('#form_plupload').submit(function(e) {
        var uploader = $('#uploader').pluploadQueue();

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('#form_plupload')[0].submit();
                }
            });
                
            uploader.start();
        } else {
            alert('You must queue at least one file.');
        }

        return false;
    });
});
</script>


<form style="margin:0px;" id="form_plupload">
	<div id="uploader">
		<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
</form>
</div>















<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/upload-photo-plupload-process/" name="uploadform">



	<?php
	$free = 0;
	$model = 0;
	$editorial = 0;
	$adult = 0;
	$folderid = 0;
	include ( "filemanager_photo_content.php" );
	?>

<hr>
	<script>
		function check_terms() {
			if( $('#terms').is(':checked')==false) {
				document.getElementById('upload_submit').disabled=true;
			}
			else
			{
				document.getElementById('upload_submit').disabled=false;
			}
		}
	</script>
			<div class="form_field">
	<span><?php echo pvs_word_lang( "terms and conditions" )?></span>
	<iframe src="<?php echo site_url()?>/agreement/?id=<?php echo($pvs_global_settings["upload_terms"])?>" frameborder="no" scrolling="yes" class="framestyle_terms"></iframe>
	<br><input name="terms" id="terms" type="checkbox" value="1" onClick="check_terms();"> <?php echo pvs_word_lang( "i agree" )?>
	 		</div>

<div class="form_field">
	<input type="submit" name="subm"  id="upload_submit" class="isubmit" value="<?php echo pvs_word_lang( "next step" )?>" disabled>
</div>

</form>



</div>
<?php
include ( "profile_bottom.php" );
?>