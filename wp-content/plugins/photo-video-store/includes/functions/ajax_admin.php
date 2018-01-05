<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Imagga recognition
add_action( 'wp_ajax_pvs_recognition_imagga', 'pvs_ajax_recognition_imagga' );

function pvs_ajax_recognition_imagga()
{
	global $pvs_global_settings;

	$tags_result = "";

	$api_credentials = array( 'key' => $pvs_global_settings["imagga_key"], 'secret' =>
			$pvs_global_settings["imagga_password"] );

	$ch = curl_init();

	curl_setopt( $ch, CURLOPT_URL, 'https://api.imagga.com/v1/tagging?url=' . $_REQUEST["url"] .
		'&language=' . $_REQUEST["lang"] );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt( $ch, CURLOPT_HEADER, FALSE );
	curl_setopt( $ch, CURLOPT_USERPWD, $api_credentials['key'] . ':' . $api_credentials['secret'] );

	$response = curl_exec( $ch );
	curl_close( $ch );

	$json_response = json_decode( $response );

	if ( isset( $json_response->results
	{
		0}
	->tags ) )
	{
		foreach ( $json_response->results
		{
			0}
		->tags as $key => $value )
		{
			if ( $tags_result != '' )
			{
				$tags_result .= ',';
			}

			$tags_result .= $value->tag;
		}
	}
	echo ( $tags_result );
}

//Amazon test
add_action( 'wp_ajax_pvs_amazon_test', 'pvs_ajax_amazon_test' );

function pvs_ajax_amazon_test()
{
	global $pvs_global_settings;
	include ( plugin_dir_path( __FILE__ ) . "../plugins/amazon/sdk.class.php" );

	// Set plain text headers
	header( "Content-type: text/plain; charset=utf-8" );

	/*%******************************************************************************************%*/
	// UPLOAD FILES TO S3

	// Instantiate the AmazonS3 class
	$s3 = new AmazonS3();

	// Determine a completely unique bucket name (all lowercase)
	$bucket = $pvs_global_settings["amazon_prefix"] . "-test";
	$bucket_files = $pvs_global_settings["amazon_prefix"] . "-files";
	$bucket_previews = $pvs_global_settings["amazon_prefix"] . "-previews";

	// Create our new bucket in the US-West region.
	if ( $pvs_global_settings["amazon_region"] == "REGION_US_E1" )
	{
		$region = AmazonS3::REGION_US_E1;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_US_W1" )
	{
		$region = AmazonS3::REGION_US_W1;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_EU_W1" )
	{
		$region = AmazonS3::REGION_EU_W1;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_APAC_SE1" )
	{
		$region = AmazonS3::REGION_APAC_SE1;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_APAC_NE1" )
	{
		$region = AmazonS3::REGION_APAC_NE1;
	}

	if ( $pvs_global_settings["amazon_region"] == "REGION_US_W2" )
	{
		$region = AmazonS3::REGION_US_W2;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_EU_W2" )
	{
		$region = AmazonS3::REGION_EU_W2;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_APAC_SE2" )
	{
		$region = AmazonS3::REGION_APAC_SE2;
	}
	if ( $pvs_global_settings["amazon_region"] == "REGION_SA_E1" )
	{
		$region = AmazonS3::REGION_SA_E1;
	}

	$create_bucket_response = $s3->create_bucket( $bucket, $region );

	// Provided that the bucket was created successfully...
	if ( $create_bucket_response->isOK() )
	{
		/* Since AWS follows an "eventual consistency" model, sleep and poll
		until the bucket is available. */
		$exists = $s3->if_bucket_exists( $bucket );
		while ( ! $exists )
		{
			// Not yet? Sleep for 1 second, then check again
			sleep( 1 );
			$exists = $s3->if_bucket_exists( $bucket );
		}

		$filename = "test.jpg";
		$filename_path = plugin_dir_path( __FILE__ ) .
			"/includes/admin/includes/img/test.jpg";

		$s3->batch()->create_object( $bucket, $filename, array(
			'fileUpload' => $filename_path,
			'acl' => AmazonS3::ACL_PUBLIC,
			) );

		$file_upload_response = $s3->batch()->send();

		if ( $file_upload_response->areOK() )
		{
			$url = $s3->get_object_url( $bucket, $filename );

			echo ( "The file has been uploaded successfully: " . $url . " into the bucket '" .
				$bucket . "'<br><br>" );

		} else
		{
			echo ( "Error. The script cannot upload the file '" . $filename .
				"' into the bucket '" . $bucket . "'.<br><br>" );
		}
	} else
	{
		echo ( "Error. The script cannot create the bucket: '" . $bucket .
			"'. Probably the bucket already exists or the name is incorrect.<br><br>" );
	}

	$create_bucket_response = $s3->create_bucket( $bucket_files, $region );
	if ( $create_bucket_response->isOK() )
	{
		echo ( "The script created the bucket: '" . $bucket_files .
			"' successfully.<br><br>" );
	} else
	{
		echo ( "Error. The script cannot create the bucket: '" . $bucket_files .
			"'. Probably the bucket already exists or the name is incorrect.<br><br>" );
	}

	$create_bucket_response = $s3->create_bucket( $bucket_previews, $region );
	if ( $create_bucket_response->isOK() )
	{
		echo ( "The script created the bucket: '" . $bucket_previews .
			"' successfully.<br><br>" );
	} else
	{
		echo ( "Error. The script cannot create the bucket: '" . $bucket_previews .
			"'. Probably the bucket already exists or the name is incorrect.<br><br>" );
	}
}

//Rights managed preview admin
add_action( 'wp_ajax_pvs_rights_managed_preview',
	'pvs_ajax_rights_managed_preview' );

function pvs_ajax_rights_managed_preview()
{
	global $_REQUEST;
	global $rs;
	global $dr;
	global $ds;

	if ( $_REQUEST["events"] == "step_add" )
	{
?>
			<div class="modal_header"><?php
		echo pvs_word_lang( "add step" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="step_add">
			<input type="hidden" name="id" value="<?php
		echo $_REQUEST["id"]
?>">
			<div class='admin_field'>
				<span><?php
		echo pvs_word_lang( "title" )
?>:</span>
				<input type="text" name="title" value="" style="width:300px" class="form-control">
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-primary" value="<?php
		echo pvs_word_lang( "add" )
?>">
			</div>
			</form>
		<?php
	}

	if ( $_REQUEST["events"] == "step_edit" )
	{
		$sql = "select title from " . PVS_DB_PREFIX .
			"rights_managed_structure where types=0 and id=" . ( int )$_REQUEST["id_element"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
?>
			<div class="modal_header"><?php
			echo pvs_word_lang( "edit" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="step_edit">
			<input type="hidden" name="id" value="<?php
			echo $_REQUEST["id"]
?>">
			<input type="hidden" name="id_element" value="<?php
			echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				<span><?php
			echo pvs_word_lang( "title" )
?>:</span>
				<input type="text" name="title" value="<?php
			echo $rs->row["title"]
?>" style="width:300px" class="form-control">
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-primary" value="<?php
			echo pvs_word_lang( "save" )
?>">
			</div>
			</form>
			<?php
		}
	}

	if ( $_REQUEST["events"] == "step_delete" )
	{
		$sql = "select title from " . PVS_DB_PREFIX .
			"rights_managed_structure where types=0 and id=" . ( int )$_REQUEST["id_element"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
?>
			<div class="modal_header"><?php
			echo pvs_word_lang( "delete" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="step_delete">
			<input type="hidden" name="id" value="<?php
			echo $_REQUEST["id"]
?>">
			<input type="hidden" name="id_element" value="<?php
			echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				Are you sure that you want to remove <b>"<?php
			echo $rs->row["title"]
?>" step</b> and all nested elements?
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-danger" value="<?php
			echo pvs_word_lang( "delete" )
?>">
			</div>
			</form>
			<?php
		}
	}

	if ( $_REQUEST["events"] == "group_add" )
	{
?>
			<div class="modal_header"><?php
		echo pvs_word_lang( "add group" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="group_add">
			<input type="hidden" name="id" value="<?php
		echo $_REQUEST["id"]
?>">
			<input type="hidden" name="step" value="<?php
		echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				<span><?php
		echo pvs_word_lang( "groups" )
?>:</span>
				<select name="group" style="width:350px" class="form-control">
					<?php
		$sql = "select id,title from " . PVS_DB_PREFIX .
			"rights_managed_groups order by title";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
?>
							<option value="<?php
			echo $rs->row["id"]
?>"><?php
			echo $rs->row["title"]
?></option>
						<?php
			$rs->movenext();
		}
?>
				</select>
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-primary" value="<?php
		echo pvs_word_lang( "add" )
?>">
			</div>
			</form>
		<?php
	}

	if ( $_REQUEST["events"] == "group_delete" )
	{
		$sql = "select title from " . PVS_DB_PREFIX .
			"rights_managed_structure where types=1 and id=" . ( int )$_REQUEST["id_element"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
?>
			<div class="modal_header"><?php
			echo pvs_word_lang( "delete" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="step_delete">
			<input type="hidden" name="id" value="<?php
			echo $_REQUEST["id"]
?>">
			<input type="hidden" name="id_element" value="<?php
			echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				Are you sure that you want to remove <b>"<?php
			echo $rs->row["title"]
?>" group</b> and all nested elements?
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-danger" value="<?php
			echo pvs_word_lang( "delete" )
?>">
			</div>
			</form>
			<?php
		}
	}

	if ( $_REQUEST["events"] == "option_delete" )
	{
		$sql = "select title from " . PVS_DB_PREFIX .
			"rights_managed_structure where types=2 and id=" . ( int )$_REQUEST["id_element"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
?>
			<div class="modal_header"><?php
			echo pvs_word_lang( "delete" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="step_delete">
			<input type="hidden" name="id" value="<?php
			echo $_REQUEST["id"]
?>">
			<input type="hidden" name="id_element" value="<?php
			echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				Are you sure that you want to remove <b>"<?php
			echo $rs->row["title"]
?>" option</b> and all nested elements?
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-danger" value="<?php
			echo pvs_word_lang( "delete" )
?>">
			</div>
			</form>
			<?php
		}
	}

	if ( $_REQUEST["events"] == "option_edit" )
	{
		$sql = "select title,price,adjust from " . PVS_DB_PREFIX .
			"rights_managed_structure where types=2 and id=" . ( int )$_REQUEST["id_element"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
			$options = "";
			if ( $rs->row["adjust"] == "+" )
			{
				$options = "<option value='+' selected>+</option><option value='-'>-</option><option value='x'>x</option>";
			} elseif ( $rs->row["adjust"] == "-" )
			{
				$options = "<option value='+'>+</option><option value='-' selected>-</option><option value='x'>x</option>";
			} else
			{
				$options = "<option value='+'>+</option><option value='-'>-</option><option value='x' selected>x</option>";
			}
?>
			<div class="modal_header"><?php
			echo pvs_word_lang( "edit" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="option_edit">
			<input type="hidden" name="id" value="<?php
			echo $_REQUEST["id"]
?>">
			<input type="hidden" name="id_element" value="<?php
			echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				<span><?php
			echo pvs_word_lang( "title" )
?>:</span>
				<input type="text" name="title" value="<?php
			echo $rs->row["title"]
?>" style="width:350px" class="form-control">
			</div>
			<div class='admin_field'>
				<span><?php
			echo pvs_word_lang( "price" )
?>:</span>
				<select name='adjust' style='width:50px;' class="form-control"><?php
			echo $options
?></select>&nbsp;<input type="text" name="price" value="<?php
			echo pvs_price_format( $rs->row["price"], 2 )
?>" style="width:50px" class="form-control">
			</div>
			<div class='admin_field'>
				<input type="submit" class="btn btn-primary" value="<?php
			echo pvs_word_lang( "save" )
?>">
			</div>
			</form>
			<?php
		}
	}

	if ( $_REQUEST["events"] == "conditions" )
	{
		$sql = "select id,title,conditions,id_parent from " . PVS_DB_PREFIX .
			"rights_managed_structure where types=1 and id=" . ( int )$_REQUEST["id_element"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
			$mass_conditions = explode( "-", $rs->row["conditions"] );
?>
			<div class="modal_header"><?php
			echo $rs->row["title"]
?> &mdash; <?php
			echo pvs_word_lang( "conditions" )
?></div>
			<form method="post">
			<input type="hidden" name="action" value="conditions_edit">
			<input type="hidden" name="id" value="<?php
			echo $_REQUEST["id"]
?>">
			<input type="hidden" name="id_element" value="<?php
			echo $_REQUEST["id_element"]
?>">
			<div class='admin_field'>
				You can set special conditions when the group is available.<br><br>
				<?php
			for ( $i = 0; $i < 7; $i++ )
			{
?>
				<span><?php
				if ( $i > 0 )
				{
					echo ( " or " );
				}
?>Condition <?php
				echo $i + 1
?>:</span>
				<select style="width:370px;margin-bottom:15px" name="condition<?php
				echo $i
?>" class="form-control">
					<option value=''></value>
					<?php
				$sql = "select id,title from " . PVS_DB_PREFIX .
					"rights_managed_groups where id<>" . $rs->row["id"] . " order by id";
				$ds->open( $sql );
				while ( ! $ds->eof )
				{
					$sel = "";
					if ( isset( $mass_conditions[$i] ) and ( int )$mass_conditions[$i] == $ds->row["id"] )
					{
						$sel = "selected";
					}
?>
								<option value="<?php
					echo $ds->row["id"]
?>" <?php
					echo $sel
?>><?php
					echo $ds->row["title"]
?></option>
							<?php
					$sql = "select id,title from " . PVS_DB_PREFIX .
						"rights_managed_options where id_parent=" . $ds->row["id"] . " order by id";
					$dr->open( $sql );
					while ( ! $dr->eof )
					{
						$sel = "";
						if ( isset( $mass_conditions[$i] ) and ( int )$mass_conditions[$i] == $dr->row["id"] )
						{
							$sel = "selected";
						}
?>
									<option value="<?php
						echo $dr->row["id"]
?>" <?php
						echo $sel
?>>-&nbsp;&nbsp;<?php
						echo $dr->row["title"]
?></option>
								<?php
						$dr->movenext();
					}
?>
								<option value=''></value>
							<?php
					$ds->movenext();
				}
?>
				</select>
				<?php
			}
?>
			</div>
	
			<div class='admin_field'>
				<input type="submit" class="btn btn-primary" value="<?php
			echo pvs_word_lang( "save" )
?>">
			</div>
			</form>
			<?php
		}
	}
}


//Collection status
add_action( 'wp_ajax_pvs_collection_status',
	'pvs_ajax_collection_status' );

function pvs_ajax_collection_status()
{
	global $_REQUEST;
	global $rs;
	global $dr;
	global $db;
	
	$id = ( int )@$_REQUEST['id'];
	$sql = "select id,active from " . PVS_DB_PREFIX . "collections where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["active"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "collections set active=0 where id=" . $id;
			$db->execute( $sql );
			?>
				<a href="javascript:pvs_collection_status(<?php echo $id?>);"><span class="label label-danger"><?php echo pvs_word_lang( "pending" )?></span></a>
			<?php
		} else {
				$sql = "update " . PVS_DB_PREFIX . "collections set active=1 where id=" . $id;
				$db->execute( $sql );
		?>
				<a href="javascript:pvs_collection_status(<?php echo $id?>);"><span class="label label-success"><?php echo pvs_word_lang( "active" )?></span></a>
			<?php
		}
	}
}


//Deselect row of new item in admin panel
add_action( 'wp_ajax_pvs_deselect_row',
	'pvs_ajax_deselect_row' );

function pvs_ajax_deselect_row()
{
	global $_SESSION;
	global $_REQUEST;
	$_SESSION["admin_rows_" . pvs_result( $_REQUEST["id"] )] = 1;
}


//Upload moderation status
add_action( 'wp_ajax_pvs_upload_moderation',
	'pvs_ajax_upload_moderation' );

function pvs_ajax_upload_moderation()
{
	global $rs;
	global $db;
	global $_REQUEST;

	$id = ( int )@$_REQUEST['fid'];
	$fdo = ( int )@$_REQUEST['fdo'];
	
	$sql = "select id,published from " . PVS_DB_PREFIX .
		"media where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "media set published=" . $fdo .
			" where id=" . $id;
		$db->execute( $sql );
	?>
	<a href="javascript:pvs_upload_moderation(<?php echo $rs->row["id"] ?>,1);" <?php
		if ( $fdo != 1 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "approved" )?></a><br>
	<a href="javascript:pvs_upload_moderation(<?php echo $rs->row["id"] ?>,0);" <?php
		if ( $fdo != 0 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "pending" )?></a><br>
	<a href="javascript:pvs_upload_moderation(<?php echo $rs->row["id"] ?>,-1);" <?php
		if ( $fdo != -1 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "declined" )?></a>
	<?php
	}
}


//Upload moderation category status
add_action( 'wp_ajax_pvs_upload_moderation_category',
	'pvs_ajax_upload_moderation_category' );

function pvs_ajax_upload_moderation_category()
{
	global $rs;
	global $db;
	global $_REQUEST;

	$id = ( int )@$_REQUEST['fid'];
	$fdo = ( int )@$_REQUEST['fdo'];
	
	$sql = "select id,published from " . PVS_DB_PREFIX .
		"category where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "category set published=" . $fdo .
			" where id=" . $id;
		$db->execute( $sql );
	?>
	<a href="javascript:pvs_upload_moderation_category(<?php echo $rs->row["id"] ?>,1);" <?php
		if ( $fdo != 1 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "approved" )?></a><br>
	<a href="javascript:pvs_upload_moderation_category(<?php echo $rs->row["id"] ?>,0);" <?php
		if ( $fdo != 0 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "pending" )?></a><br>
	<a href="javascript:pvs_upload_moderation_category(<?php echo $rs->row["id"] ?>,-1);" <?php
		if ( $fdo != -1 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "declined" )?></a>
	<?php
	}
}

//Upload moderation category status
add_action( 'wp_ajax_pvs_refuse_reason',
	'pvs_ajax_refuse_reason' );

function pvs_ajax_refuse_reason()
{
	global $rs;
	global $db;
	global $_REQUEST;

	$id = ( int )@$_REQUEST['fid'];
	$doc = @$_REQUEST['ftable'];
	$content = @$_REQUEST['fcontent'];
	
	$sql = "select id,published from " . PVS_DB_PREFIX .
		"media where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "media set refuse_reason='" .
			pvs_result( $content ) . "' where id=" . $id;
		$db->execute( $sql );
	
		echo ( $content );
	}
}



//Document status
add_action( 'wp_ajax_pvs_document_status',
	'pvs_ajax_document_status' );

function pvs_ajax_document_status()
{
	global $rs;
	global $db;
	global $_REQUEST;

	$id = ( int )@$_REQUEST['fid'];
	$fdo = ( int )@$_REQUEST['fdo'];
	
	$sql = "select id,status from " . PVS_DB_PREFIX . "documents where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "documents set status=" . $fdo . " where id=" .
			$id;
		$db->execute( $sql );
	?>
		<a href="javascript:pvs_document_status(<?php echo $rs->row["id"] ?>,1);" <?php
		if ( $fdo != 1 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "approved" )?></a><br>
		<a href="javascript:pvs_document_status(<?php echo $rs->row["id"] ?>,0);" <?php
		if ( $fdo != 0 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "pending" )?></a><br>
		<a href="javascript:pvs_document_status(<?php echo $rs->row["id"] ?>,-1);" <?php
		if ( $fdo != -1 ) {
	?>class="gray"<?php
		}
	?>><?php echo pvs_word_lang( "declined" )?></a>
		<?php
	}
}



//Support status
add_action( 'wp_ajax_pvs_support_status',
	'pvs_ajax_support_status' );

function pvs_ajax_support_status()
{
	global $rs;
	global $db;
	global $_REQUEST;
	
	$id = ( int )@$_REQUEST['id'];
	
	$sql = "select id,closed from " . PVS_DB_PREFIX . "support_tickets where id=" .
		$id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["closed"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "support_tickets set closed=0 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_support_status(<?php echo $rs->row["id"] ?>);" class="red"><?php echo pvs_word_lang( "in progress" )?></a>
			<?php
		} else {
			$sql = "update " . PVS_DB_PREFIX . "support_tickets set closed=1 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_support_status(<?php echo $rs->row["id"] ?>);"><?php echo pvs_word_lang( "closed" )?></a>
			<?php
		}
	}
}

//Notification preview
add_action( 'wp_ajax_pvs_notification_preview',
	'pvs_ajax_notification_preview' );

function pvs_ajax_notification_preview()
{
	global $rs;
	global $ds;
	global $_REQUEST;
	global $table_prefix;

	
	$sql = "select events,title,message,enabled,priority,subject,html,message_html from " .
		PVS_DB_PREFIX . "notifications where events='" . pvs_result( $_REQUEST["events"] ) .
		"'";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$example = "";
	
		if ( $rs->row["events"] == "contacts_to_admin" or $rs->row["events"] ==
			"contacts_to_user" ) {
			$_POST["name"] = "John";
			$_POST["email"] = "john@yourdomain.com";
			$_POST["telephone"] = "1-234-765-4967";
			$_POST["method"] = "By email";
			$_POST["question"] = "This is test Contact Us email.";
	
			$example = pvs_send_notification( $rs->row["events"], "", "", "", "", true );
		}
	
		if ( $rs->row["events"] == "fraud_to_user" ) {
			$example = pvs_send_notification( $rs->row["events"], "hsdjh453j2",
				"john@yourdomain.com", "John", "", true );
		}
	
		if ( $rs->row["events"] == "neworder_to_user" or $rs->row["events"] ==
			"neworder_to_admin" ) {
			$sql = "select id from " . PVS_DB_PREFIX . "orders order by id desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["id"], "", "", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live order in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "subscription_to_admin" or $rs->row["events"] ==
			"subscription_to_user" ) {
			$sql = "select id_parent from " . PVS_DB_PREFIX .
				"subscription_list order by id_parent desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["id_parent"], "",
					"", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live subscription in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "credits_to_admin" or $rs->row["events"] ==
			"credits_to_user" ) {
			$sql = "select id_parent from " . PVS_DB_PREFIX .
				"credits_list  where quantity>0 order by id_parent desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["id_parent"], "",
					"", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there are no any live credits in the database. It is impossible to show the notification's preview.</p>";
			}
		}

		if ( $rs->row["events"] == "signup_to_admin" ) {
			$sql = "select ID from " . $table_prefix . "users  order by ID desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["ID"], "",
					"", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live user in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "signup_to_user" ) {
			$_POST["email"] = "user@email.com";
			$_POST["name"] = "John";
			$example = pvs_send_notification( $rs->row["events"], "", "", "", "", true );
		}
	
		if ( $rs->row["events"] == "signup_guest" ) {
			$_POST["guest_email"] = "user@email.com";
			$example = pvs_send_notification( $rs->row["events"], "guest12234",
				"sfrfe234xc2", "", "", true );
		}
	
		if ( $rs->row["events"] == "forgot_password" ) {
			$sql = "select email from " . PVS_DB_PREFIX .
				"users where authorization='site'  order by id_parent desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$_POST["email"] = $ds->row["email"];
				$example = pvs_send_notification( $rs->row["events"], "", "", "", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live user in the database. It is impossible to show the notification's preview.</p>";
			}
		}	
	
	
		if ( $rs->row["events"] == "tell_a_friend" ) {
			$_REQUEST["email"] = "fromuser@email.com";
			$_REQUEST["email2"] = "touser@email.com";
			$_REQUEST["name"] = "John";
			$_REQUEST["name2"] = "Nick";
			$example = pvs_send_notification( $rs->row["events"], "http://www.domain.com/",
				"", "", "", true );
		}
	
		if ( $rs->row["events"] == "commission_to_seller" ) {
			$sql = "select total,user,orderid,item,publication,types,data,description from " .
				PVS_DB_PREFIX . "commission where total>0 order by data desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["user"], $ds->
					row["orderid"], $ds->row["publication"], $ds->row["total"], true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live commission in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "commission_to_affiliate" ) {
			$sql = "select userid,types,types_id,rates,total,data,aff_referal from " .
				PVS_DB_PREFIX . "affiliates_signups where total>0 order by data desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["userid"], $ds->
					row["types_id"], "", $ds->row["total"], true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live commission in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "exam_to_admin" or $rs->row["events"] ==
			"exam_to_seller" ) {
			$sql = "select id,user,data,status,comments from " . PVS_DB_PREFIX .
				"examinations order by data desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["user"], $ds->
					row["id"], "", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live examination in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "support_to_admin" ) {
			$sql = "select id,id_parent from " . PVS_DB_PREFIX .
				"support_tickets where user_id<>0 order by data desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["id"], "", "", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live support request in the database. It is impossible to show the notification's preview.</p>";
			}
		}
	
		if ( $rs->row["events"] == "support_to_user" ) {
			$sql = "select id,id_parent from " . PVS_DB_PREFIX .
				"support_tickets where id_parent<>0 and admin_id<>0 order by data desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$example = pvs_send_notification( $rs->row["events"], $ds->row["id"], "", "", "", true );
			} else {
				$example = "<p>Ops! Unfortunately there is no any live support request in the database. It is impossible to show the notification's preview.</p>";
			}
		}

		echo ( $example );
	}
}


//Check country
add_action( 'wp_ajax_pvs_check_country',
	'pvs_ajax_check_country' );

function pvs_ajax_check_country()
{
	global $_REQUEST;
	
	$check_date = pvs_get_time();
	
	if ( ( int )@$_REQUEST["status"] == 0 ) {
		$check_date = 0;
	}
	
	update_user_meta( ( int )@$_REQUEST["id"], 'country_checked', ( int )@$_REQUEST["status"] );
	update_user_meta( ( int )@$_REQUEST["id"], 'country_checked_date', $check_date );
}


//Check vat
add_action( 'wp_ajax_pvs_check_vat',
	'pvs_ajax_check_vat' );

function pvs_ajax_check_vat()
{
	global $_REQUEST;
	
	$check_date = pvs_get_time();
	
	if ( ( int )@$_REQUEST["status"] == 0 ) {
		$check_date = 0;
	}
	
	update_user_meta( ( int )@$_REQUEST["id"], 'vat_checked', ( int )@$_REQUEST["status"] );
	update_user_meta( ( int )@$_REQUEST["id"], 'vat_checked_date', $check_date );
}


//User login from the admin panel
add_action( 'wp_ajax_pvs_user_login',
	'pvs_ajax_user_login' );

function pvs_ajax_user_login()
{
	global $_REQUEST;

	if ( current_user_can('manage_options') )
	{
		pvs_user_authorization( ( int )@$_REQUEST["id"] );
	}
}


//Check login
add_action( 'wp_ajax_pvs_check_login',
	'pvs_ajax_check_login' );

function pvs_ajax_check_login()
{
	global $_REQUEST;
	global $rs;
	global $table_prefix;
	
	$login = pvs_result_strict( $_REQUEST['login'] );
	
	if ( $_REQUEST['login'] == "" or ! preg_match( "/^[A-Za-z]{1,}[A-Za-z0-9]{4,}$/", $_REQUEST['login'] ) ) {
		echo ( "<span class='error'>" . pvs_word_lang( "incorrect field" ) . "</span>" );
	} else
	{
		$sql = "select user_login from " . $table_prefix . "users where user_login='" . $login . "'";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			echo ( "<span class='error'>" . pvs_word_lang( "Error: Username is already in use." ) . "</span>" );
		} else {
			echo ( "<span class='ok'>" . pvs_word_lang( "Ok. Username is available." ) . "</span>" );
		}
	}
}


//Check email
add_action( 'wp_ajax_pvs_check_email',
	'pvs_ajax_check_email' );

function pvs_ajax_check_email()
{
	global $_REQUEST;
	global $rs;
	global $table_prefix;
	
	$email = pvs_result( $_REQUEST['email'] );

	if ( $_REQUEST['email'] == "" or ! preg_match( "/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\.A-Za-z0-9]{2,}/", $_REQUEST['email'] ) ) {
		echo ( "<span class='error'>" . pvs_word_lang( "incorrect field" ) . "</span>" );
	} else
	{
		$sql = "select user_email from " . $table_prefix . "users where user_email='" . $email . "'";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			echo ( "<span class='error'>" . pvs_word_lang( "Error: Email is already in use." ) . "</span>" );
		} else {
			echo ( "<span class='ok'>" . pvs_word_lang( "Ok. Email is available." ) . "</span>" );
		}
	}
}



//Coupon status 
add_action( 'wp_ajax_pvs_coupon_status',
	'pvs_ajax_coupon_status' );

function pvs_ajax_coupon_status()
{
	global $_REQUEST;
	global $rs;
	global $ds;
	global $db;
	
	$id = ( int )@$_REQUEST['id'];
	$sql = "select id_parent,used,coupon_id from " . PVS_DB_PREFIX .
		"coupons where id_parent=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["used"] == 1 ) {
			$sql = "select days from " . PVS_DB_PREFIX . "coupons_types where id_parent=" .
				$rs->row["coupon_id"];
			$ds->open( $sql );
			{
				$sql = "update " . PVS_DB_PREFIX . "coupons set used=0,tlimit=0,data2=" .
					pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
					date( "Y" ) ) . ",data=" . ( pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
					date( "m" ), date( "d" ), date( "Y" ) ) + $ds->row["days"] * 3600 * 24 ) .
					" where id_parent=" . $id;
				$db->execute( $sql );
			}
	?>
			<a href="javascript:pvs_coupon_status(<?php echo $rs->row["id_parent"] ?>);"><?php echo pvs_word_lang( "active" )?></a>
			<?php
		} else {
			$sql = "update " . PVS_DB_PREFIX . "coupons set used=1 where id_parent=" . $id;
			$db->execute( $sql );
	?>
			<a href="javascript:pvs_coupon_status(<?php echo $rs->row["id_parent"] ?>);" class="red"><?php echo pvs_word_lang( "expired" )?></a>
			<?php
		}
	}
}

//Gateway status 
add_action( 'wp_ajax_pvs_gateway_status',
	'pvs_ajax_gateway_status' );

function pvs_ajax_gateway_status()
{
	global $_REQUEST;
	global $pvs_payments;
	global $pvs_global_settings;
	
	$id = ( int )@$_REQUEST['id'];

	$i = 1;
	foreach ( $pvs_payments as $key => $value ) {
		if ( $i == $id ) {
			$gateway = $key;
		}
		$i++;
	}

	if ( (int)@$pvs_global_settings[$gateway . "_active"] == 1 ) {
		pvs_update_setting($gateway . '_active', 0);
		?>
		<a href="javascript:pvs_gateway_status(<?php echo $id ?>);" class='red'><b><?php echo pvs_word_lang( "disabled" )?></b></a>
		<?php
	} else {
		pvs_update_setting($gateway . '_active', 1);
		?>
		<a href="javascript:pvs_gateway_status(<?php echo $id ?>);" class='green'><b><?php echo pvs_word_lang( "enabled" )?></b></a>
		<?php
	}
}

//Credits status 
add_action( 'wp_ajax_pvs_credits_status',
	'pvs_ajax_credits_status' );

function pvs_ajax_credits_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$id = ( int )@$_REQUEST['id'];
	$sql = "select id_parent,approved from " . PVS_DB_PREFIX .
		"credits_list where id_parent=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["approved"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX .
				"credits_list set approved=0 where id_parent=" . $id;
			$db->execute( $sql );
			pvs_affiliate_delete_commission( $id, "credits" );
	?>
				<a href="javascript:pvs_credits_status(<?php echo $id
	?>);"><span class="label label-danger"><?php echo pvs_word_lang( "pending" )?></span></a>
			<?php
		} else {
			pvs_credits_approve( $id, "" );
			pvs_send_notification( 'credits_to_user', $id );
			pvs_send_notification( 'credits_to_admin', $id );
	?>
				<a href="javascript:pvs_credits_status(<?php echo $id
	?>);"><span class="label label-success"><?php echo pvs_word_lang( "approved" )?></span></a>
			<?php
		}
	}
}


//Subscription status 
add_action( 'wp_ajax_pvs_subscription_status',
	'pvs_ajax_subscription_status' );

function pvs_ajax_subscription_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$id = ( int )@$_REQUEST['id'];
	$sql = "select id_parent,approved from " . PVS_DB_PREFIX .
		"subscription_list where id_parent=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["approved"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX .
				"subscription_list set approved=0 where id_parent=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_subscription_status(<?php echo $id
	?>);"><span class="label label-danger"><?php echo pvs_word_lang( "pending" )?></span></a>
			<?php
			pvs_affiliate_delete_commission( $id, "subscription" );
		} else {
			pvs_subscription_approve( $id );
			pvs_send_notification( 'subscription_to_user', $id );
			pvs_send_notification( 'subscription_to_admin', $id );
	?>
				<a href="javascript:pvs_subscription_status(<?php echo $id
	?>);"><span class="label label-success"><?php echo pvs_word_lang( "approved" )?></span></a>
			<?php
		}
	}
}


//Invoice status 
add_action( 'wp_ajax_pvs_invoice_status',
	'pvs_ajax_invoice_status' );

function pvs_ajax_invoice_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$id = ( int )@$_REQUEST['id'];
	$sql = "select id,status from " . PVS_DB_PREFIX . "invoices where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["status"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "invoices set status=0 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_invoice_status(<?php echo $id
	?>);"><span class="label label-danger"><?php echo pvs_word_lang( "pending" )?></span></a>
			<?php
		} else {
			$sql = "update " . PVS_DB_PREFIX . "invoices set status=1 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_invoice_status(<?php echo $id
	?>);"><span class="label label-success"><?php echo pvs_word_lang( "published" )?></span></a>
			<?php
		}
	}
}


//Order status 
add_action( 'wp_ajax_pvs_order_status',
	'pvs_ajax_order_status' );

function pvs_ajax_order_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$id = ( int )@$_REQUEST['id'];
	
	$sql = "select status from " . PVS_DB_PREFIX . "orders where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["status"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "orders set status=0 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_order_status(<?php echo $id ?>);"><span class="label label-danger"><?php echo pvs_word_lang( "pending" )?></span></a>
			<?php
			$sql = "delete from " . PVS_DB_PREFIX . "commission where orderid=" . $id .
				" and total>=0";
			$db->execute( $sql );
	
			pvs_affiliate_delete_commission( $id, "orders" );
		} else {
			pvs_order_approve( $id );
			pvs_send_notification( 'neworder_to_user', $id );
			pvs_coupons_add( pvs_order_user( $id ) );
			pvs_commission_add( $id );
	?>
				<a href="javascript:pvs_order_status(<?php echo $id ?>);"><span class="label label-success"><?php echo pvs_word_lang( "approved" )?></span></a>
			<?php
		}
	}
}


//Order shipping status 
add_action( 'wp_ajax_pvs_order_shipping_status',
	'pvs_ajax_order_shipping_status' );

function pvs_ajax_order_shipping_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$id = ( int )@$_REQUEST['id'];
	
	$sql = "select shipped from " . PVS_DB_PREFIX . "orders where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["shipped"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "orders set shipped=0 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_order_shipping_status(<?php echo $id ?>);"><span class="label label-warning"><?php echo pvs_word_lang( "not shipped" )?></span></a>
			<?php
		} else {
			$sql = "update " . PVS_DB_PREFIX . "orders set shipped=1 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_order_shipping_status(<?php echo $id ?>);"><span class="label label-info"><?php echo pvs_word_lang( "shipped" )?></span></a>
			<?php
		}
	}
}

//Payout status 
add_action( 'wp_ajax_pvs_payout_status',
	'pvs_ajax_payout_status' );

function pvs_ajax_payout_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$id = ( int )@$_REQUEST['id'];
	
	$sql = "select id,status from " . PVS_DB_PREFIX . "commission where id=" . $id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["status"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "commission set status=0 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_payout_status(<?php echo $rs->row["id"] ?>);" class="red"><?php echo pvs_word_lang( "pending" )?></a>
			<?php
		} else {
			$sql = "update " . PVS_DB_PREFIX . "commission set status=1 where id=" . $id;
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_payout_status(<?php echo $rs->row["id"] ?>);"><?php echo pvs_word_lang( "approved" )?></a>
			<?php
		}
	}
}


//Affiliates Payout status 
add_action( 'wp_ajax_pvs_affiliates_status',
	'pvs_ajax_affiliates_status' );

function pvs_ajax_affiliates_status()
{
	global $_REQUEST;
	global $pvs_global_settings;
	global $db;
	global $rs;

	$sql = "select data,aff_referal,status from " . PVS_DB_PREFIX .
		"affiliates_signups where data=" . ( int )$_REQUEST["data"] .
		" and  aff_referal=" . ( int )$_REQUEST["user"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( $rs->row["status"] == 1 ) {
			$sql = "update " . PVS_DB_PREFIX . "affiliates_signups set status=0 where data=" . ( int )
				$_REQUEST["data"] . " and  aff_referal=" . ( int )$_REQUEST["user"];
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_affiliates_status(<?php echo $rs->row["data"] ?>,<?php echo $rs->row["aff_referal"] ?>);" class="red"><?php echo pvs_word_lang( "pending" )?></a>
			<?php
		} else {
			$sql = "update " . PVS_DB_PREFIX . "affiliates_signups set status=1 where data=" . ( int )
				$_REQUEST["data"] . " and  aff_referal=" . ( int )$_REQUEST["user"];
			$db->execute( $sql );
	?>
				<a href="javascript:pvs_affiliates_status(<?php echo $rs->row["data"] ?>,<?php echo $rs->row["aff_referal"] ?>);"><?php echo pvs_word_lang( "approved" )?></a>
			<?php
		}
	}
}
?>