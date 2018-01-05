<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Change
if ( @$_REQUEST["action"] == 'change_backblaze' )
{
	$activ = 0;
	if ( isset( $_POST["activ"] ) )
	{
		$activ = 1;
	}
	
	pvs_update_setting('backblaze', $activ);
	pvs_update_setting('backblaze_prefix', pvs_result( $_POST["prefix"] ));
	pvs_update_setting('backblaze_username', pvs_result( $_POST["username"] ));
	pvs_update_setting('backblaze_api_key', pvs_result( $_POST["api_key"] ));

	//Update settings
	pvs_get_settings();
}
?>

<div class="subheader"><?php echo pvs_word_lang( "overview" )?></div>
<div class="subheader_text">

<p>
<a href="https://www.backblaze.com/b2/cloud-storage.html"><b>Backblaze B2 Cloud Storage</b></a> From bytes to petabytes Backblaze B2 is the lowest
cost high performance cloud storage in the world.
</p>

<p>
All files are stored on the <b>local server first</b> and then they are moved<br> Backblaze B2 <b>ONLY</b> by <a href="index.php?d=5"><b>Cron script</b></a>. The files will not be moved on Backblaze B2 if you don't run the cron script.
</p>

<p>The script creates in your Backblaze B2 account <b>2 buckets:</b></p>

<p>
<b>[PREFIX]-files</b> - for the files.<br> 
<b>[PREFIX]-previews</b> - for the previews. 
</p>

<p>From time to time you can change the prefix to organize your file archive better. We recomment you to <b>test the process every time</b> when you change prefix name.</p>

<p>
You should check the <a href="../phpini/">php.ini settings</a>:<br>
allow_url_fopen = On<br>
ignore_user_abort = On
</p>

</div>


<div class="subheader"><?php echo pvs_word_lang( "settings" )?></div>
<div class="subheader_text">

<form method="post">
<input type="hidden" name="action" value="change_backblaze">

<div class='admin_field'>
<span>Backblaze B2:</span>
<input type='checkbox' name='activ'   <?php
if ( $pvs_global_settings["backblaze"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<span>Bucket's name prexif:</span>
<input type='text' name='prefix'  style="width:400px" value="<?php echo $pvs_global_settings["backblaze_prefix"] ?>">
</div>

<div class='admin_field'>
<span>Account ID:</span>
<input type='text' name='username'  style="width:400px" value="<?php echo $pvs_global_settings["backblaze_username"] ?>">
</div>

<div class='admin_field'>
<span>Application Key:</span>
<input type='text' name='api_key'  style="width:400px" value="<?php echo $pvs_global_settings["backblaze_api_key"] ?>">
</div>





<div class='admin_field'>
<input type='submit' class="btn btn-primary"  value="<?php echo pvs_word_lang( "save" )?>">
</div>

</form>

</div>
<div class="subheader">Test</div>
<div class="subheader_text">

<p>The script will upload <a href="test.jpg">the file</a> on Backblaze B2.</p>


<p>
<a class="btn btn-primary" href="<?php echo(pvs_plugins_admin_url('storage/index.php'));?>&d=6&action=test"><i class="icon-picture icon-arrow-right icon-white fa fa-upload"></i> Test Backblaze B2 Now</a>
</p>

<?php
if ( isset( $_GET["action"] ) ) {

	$account_id = $pvs_global_settings["backblaze_username"]; // Obtained from your B2 account page
	$application_key = $pvs_global_settings["backblaze_api_key"]; // Obtained from your B2 account page
	$credentials = base64_encode($account_id . ":" . $application_key);
	$url = "https://api.backblazeb2.com/b2api/v1/b2_authorize_account";
	
	$session = curl_init($url);
	
	// Add headers
	$headers = array();
	$headers[] = "Accept: application/json";
	$headers[] = "Authorization: Basic " . $credentials;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers
	
	curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
	$server_output = curl_exec($session);
	curl_close ($session);
	$results = json_decode($server_output);

	
	
	$api_url = @$results -> apiUrl ; // From b2_authorize_account call
	$auth_token = @$results -> authorizationToken; // From b2_authorize_account call
	
	//Create a new preview bucket
	$bucket_name = $pvs_global_settings["backblaze_prefix"] . '-preview'; // 6 char min, 50 char max: letters, digits, - and _
	$bucket_type = "allPublic"; // Either allPublic or allPrivate
	
	$session = curl_init($api_url .  "/b2api/v1/b2_create_bucket");
	
	// Add post fields
	$data = array("accountId" => $account_id, "bucketName" => $bucket_name, "bucketType" => $bucket_type);
	$post_fields = json_encode($data);
	curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $auth_token;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up
	$results2 = json_decode($server_output); // Tell me about the rabbits, George!

	if (isset($results2 -> bucketId)) {
		$bucket_id = $results2 -> bucketId;
		
		$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . pvs_result( $results2 -> bucketId ) . "' where setting_key='backblaze_preview'";
		$db->execute( $sql );
		
		echo('<p><b>OK.</b> The script have successfully created <b>' . $pvs_global_settings["backblaze_prefix"] . '-preview</b> bucket.</p>');
	} else {
		echo('<p><b>Error!</b> The script cannot create <b>' . $pvs_global_settings["backblaze_prefix"] . '-preview</b> bucket. Probably it already exists.</p>');
	}
	
	
	
	//Create a new files bucket
	$bucket_name = $pvs_global_settings["backblaze_prefix"] . '-files'; // 6 char min, 50 char max: letters, digits, - and _
	$bucket_type = "allPublic"; // Either allPublic or allPrivate
	
	$session = curl_init($api_url .  "/b2api/v1/b2_create_bucket");
	
	// Add post fields
	$data = array("accountId" => $account_id, "bucketName" => $bucket_name, "bucketType" => $bucket_type);
	$post_fields = json_encode($data);
	curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $auth_token;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up
	$results3 = json_decode($server_output); // Tell me about the rabbits, George!

	if (isset($results3 -> bucketId)) {
		$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . pvs_result( $results3 -> bucketId ) . "' where setting_key='backblaze_files'";
		$db->execute( $sql );
		
		echo('<p><b>OK.</b> The script have successfully created <b>' . $pvs_global_settings["backblaze_prefix"] . '-files</b> bucket.</p>');
	} else {
		echo('<p><b>Error!</b> The script cannot create <b>' . $pvs_global_settings["backblaze_prefix"] . '-files</b> bucket.  Probably it already exists.</p>');
	}
	
	
	
	//Get upload URL
	$session = curl_init($api_url .  "/b2api/v1/b2_get_upload_url");

	// Add post fields
	$data = array("bucketId" => $bucket_id);
	$post_fields = json_encode($data);
	curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $auth_token;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up
	$results4 = json_decode($server_output);



	
	//Upload file
	$file_name = "test.jpg";
	$my_file =  plugin_dir_path( __FILE__ ) . "../includes/img/"  . $file_name;
	$handle = fopen($my_file, 'r');
	$read_file = fread($handle,filesize($my_file));
	
	$upload_url = $results4->uploadUrl; // Provided by b2_get_upload_url
	$upload_auth_token = $results4->authorizationToken; // Provided by b2_get_upload_url
	$content_type = "image/jpeg";
	$sha1_of_file_data = sha1_file($my_file);
	
	$session = curl_init($upload_url);
	
	// Add read file as post field
	curl_setopt($session, CURLOPT_POSTFIELDS, $read_file); 
	
	// Add headers
	$headers = array();
	$headers[] = "Authorization: " . $upload_auth_token;
	$headers[] = "X-Bz-File-Name: " . $file_name;
	$headers[] = "Content-Type: " . $content_type;
	$headers[] = "X-Bz-Content-Sha1: " . $sha1_of_file_data;
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 
	
	curl_setopt($session, CURLOPT_POST, true); // HTTP POST
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
	$server_output = curl_exec($session); // Let's do this!
	curl_close ($session); // Clean up
	$results5 = json_decode($server_output);
	
	if (isset($results5->fileName)) {
		echo('<p><b>OK.</b> The file has been successfully uploaded:  ' . $results->downloadUrl . '/file/' . $pvs_global_settings["backblaze_prefix"] . '-preview/' . $results5->fileName . '</p><p><img src="' . $results->downloadUrl . '/file/' . $pvs_global_settings["backblaze_prefix"] . '-preview/' . $results5->fileName . '"></p>');
	} else {
		echo('<p><b>Error!</b> The file was not uploaded.</p>');
	}

}
?>
</div>

