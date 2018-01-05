<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( ! $pvs_global_settings["prints_lab"] ) {
	exit();
}

$sql = "select * from " . PVS_DB_PREFIX . "galleries where user_id='" . ( int )
	get_current_user_id() . "' and id=" . ( int )@$_GET["id"] .
	" order by data desc";
$dr->open( $sql );
if ( $dr->eof ) {
	exit();
}


include ( "profile_top.php" );


/*
* jQuery File Upload Plugin Test 6.14
* https://github.com/blueimp/jQuery-File-Upload
*
* Copyright 2010, Sebastian Tschan
* https://blueimp.net
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/MIT
*/
?>

<h1><?php echo pvs_word_lang( "prints lab" )?> &mdash; <?php echo pvs_word_lang( "upload" )?> <?php echo pvs_word_lang( "photos" )?></h1>

<div class="subheader"><?php echo pvs_word_lang( "select files" )?>. (*.jpg <  <?php echo $pvs_global_settings["prints_lab_filesize"] ?>M)</b></div>

<div class="subheader_text">

<?php
$tmp_folder = "user_" . get_current_user_id();
pvs_create_temp_folder();?>



<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/css/style.css">
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->

<!-- Bootstrap Image Gallery styles -->
<link rel="stylesheet" href="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/css/jquery.fileupload-ui-noscript.css"></noscript>



  <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?php echo site_url()?>/printslab-preupload/" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="<?php echo site_url()?>/printslab-preupload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="fileupload-buttonbar">
            <div>
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span><?php echo pvs_word_lang( "add files" )?>...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span><?php echo pvs_word_lang( "start upload" )?></span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span><?php echo pvs_word_lang( "cancel upload" )?></span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span><?php echo pvs_word_lang( "delete" )?></span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <!-- The global progress information -->
            <div class="fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>


<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span><?php echo pvs_word_lang( "start" )?></span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span><?php echo pvs_word_lang( "cancel" )?></span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <img src="{%=file.thumbnail_url%}">
            {% } %}</td>
            <td class="name">
                {%=file.name%}
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span><?php echo pvs_word_lang( "delete" )?></span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script>


$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: '<?php echo site_url()?>/upload-photo-jquery/',
        maxFileSize: <?php echo $pvs_global_settings["prints_lab_filesize"] * 1000000
?>,
            acceptFileTypes: /(\.|\/)(jpe?g)$/i,
            process: [
                {
                    action: 'load',
                    fileTypes: /^image\/(jpeg)$/,
                    maxFileSize: <?php echo $pvs_global_settings["prints_lab_filesize"] * 1000000
?> // 20MB
                },
                {
                    action: 'save'
                }
            ]
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '<?php echo site_url()?>/upload-photo-jquery/',
            maxFileSize: <?php echo $pvs_global_settings["prints_lab_filesize"] * 1000000
?>,
            acceptFileTypes: /(\.|\/)(jpe?g)$/i,
            process: [
                {
                    action: 'load',
                    fileTypes: /^image\/(jpeg)$/,
                    maxFileSize: <?php echo $pvs_global_settings["prints_lab_filesize"] * 1000000
?> // 20MB
                },
                {
                    action: 'save'
                }
            ]
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '<?php echo site_url()?>/upload-photo-jquery/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }

});
	
</script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="<?php echo(pvs_plugins_url());?>/includes/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->






</div>






<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/printslab-upload-process/" name="uploadform">
<div class="subheader"><?php echo pvs_word_lang( "select gallery" )?></div>

<div class="subheader_text">
	<select name="gallery_id" style="width:250px" class="ibox form-control">
		<?php
$sql = "select id,title from " . PVS_DB_PREFIX . "galleries where user_id='" . ( int )
	get_current_user_id() . "' order by title";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = "";
	if ( $_GET["id"] == $rs->row["id"] ) {
		$sel = "selected";
	}
?>
			<option value="<?php echo $rs->row["id"] ?>" <?php echo $sel
?>><?php echo $rs->row["title"] ?></option>
			<?php
	$rs->movenext();
}
?>
	</select>
	
	<div class="form_field">
		<input type="submit" name="subm" class="isubmit" value="<?php echo pvs_word_lang( "next step" )?>">
	</div>


</div>


	
</form>



<?php
include ( "profile_bottom.php" );
?>