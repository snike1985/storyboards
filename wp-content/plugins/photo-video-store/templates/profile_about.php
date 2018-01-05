<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>

<h1><?php echo pvs_word_lang( "my profile" );?></h1>



<div class="subheader"><?php echo pvs_word_lang( "settings" );?></b></div>

<div class="subheader_text">


<?php

	$user_fields["login"] = @$user_info -> user_login;
	$user_fields["name"] = @$user_info -> first_name;
	$user_fields["country"] = @$user_info -> country;
	$user_fields["telephone"] = @$user_info -> telephone;
	$user_fields["address"] =@ $user_info -> address;
	$user_fields["email"] = @$user_info -> user_email;
	$user_fields["lastname"] = @$user_info -> last_name;
	$user_fields["city"] = @$user_info -> city;
	$user_fields["state"] = @$user_info -> state;
	$user_fields["zipcode"] = @$user_info -> zipcode;
	$user_fields["description"] = @$user_info -> description;
	$user_fields["website"] = @$user_info -> user_url;
	$user_fields["utype"] = @$user_info -> utype;
	$user_fields["company"] = @$user_info -> company;
	$user_fields["newsletter"] = @$user_info -> newsletter;
	$user_fields["business"] = @$user_info -> business;
	$user_fields["vat"] = @$user_info -> vat;



$ss = "modify";

include ( "signup_content.php" );?>
</div>



<?php
if ( PVS_LICENSE != 'Free' ) {

$com = "";
if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "common" ) {
	$com = " and buyer=1 ";
}
if ( pvs_get_user_type () == "seller" or pvs_get_user_type () ==
	"common" ) {
	$com = " and seller=1 ";
}
if ( pvs_get_user_type () == "affiliate" or pvs_get_user_type () ==
	"common" ) {
	$com = " and affiliate=1 ";
}

$sql = "select id,title,description,filesize from " . PVS_DB_PREFIX .
	"documents_types where enabled=1 " . $com . " order by priority";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<div class="subheader"><?php echo pvs_word_lang( "Documents" );?></b></div>
	<div class="subheader_text">
	
	<a name="documents"></a>
	<form method=post Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/profile-document-upload/">
	<div  class="form_field">
		<span><b><?php echo pvs_word_lang( "type" );?></b>:</span>
		<select name="document_type" class="ibox form-control" style="width:400px;">
			<?php
	while ( ! $rs->eof ) {
?>
	<option value="<?php echo $rs->row["id"];
?>"><?php echo $rs->row["title"];
?> (< <?php echo $rs->row["filesize"];
?>MB.)</option>
	<?php
		$rs->movenext();
	}
?>
		</select>
	</div>
	
	<div  class="form_field">	 
		<input type="file" name="document_file" style="width:400px">
		<span><small><?php echo pvs_word_lang( "file types" );?>:</b> *.jpg,*.pdf.</small></span>
	</div>
	
	<div  class="form_field">
		<input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "upload" );?>">
	</div>

	</form>
	<?php
	$sql = "select id,title,status,comment,filename,data from " . PVS_DB_PREFIX .
		"documents where user_id=" . get_current_user_id() .
		" order by data desc";
	$dr->open( $sql );

	if ( ! $dr->eof ) {
?><br>
		<table border='0' cellpadding='0' cellspacing='0' style="margin-bottom:20px" class="profile_table" width="100%">
		<tr>
		<th><?php echo pvs_word_lang( "date" );?></th>
		<th><?php echo pvs_word_lang( "Documents" );?></th>
		<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "file" );?></th>
		<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "size" );?></th>
		<th><?php echo pvs_word_lang( "status" );?></th>
		</tr>
		<?php
		while ( ! $dr->eof ) {
			$size = filesize( pvs_upload_dir() . "/content/users/doc_" .
				$dr->row["id"] . "_" . $dr->row["filename"] );?>
			<tr>
	<td><div class="link_date"><?php
			echo date( date_format, $dr->row["data"] );?></div></td>
	<td><b><?php
			echo $dr->row["title"];
?></b></td>
	<td><?php
			echo $dr->row["filename"];
?></td>
	<td><?php
			echo pvs_price_format( $size / ( 1024 * 1024 ), 3 ) . " Mb.";
?></td>
	<td>
	<?php
			if ( $dr->row["status"] == 1 )
			{
?>
		<span class="label label-success"><?php
				echo pvs_word_lang( "approved" );?></span>
		<?php
			}
			if ( $dr->row["status"] == 0 )
			{
?>
		<span class="label label-warning"><?php
				echo pvs_word_lang( "pending" );?></span>
		<?php
			}
			if ( $dr->row["status"] == -1 )
			{
?>
		<span class="label label-danger"><?php
				echo pvs_word_lang( "declined" );?></span>
		<?php
				if ( $dr->row["comment"] != "" )
				{
?>
			<br><small><?php
					echo $dr->row["comment"];
?></small>
			<?php
				}
			}
?>
	</td>
			</tr>
			<?php
			$dr->movenext();
		}
?>
		</table>
		<?php
	}
?>
	</div>
	<?php
}
?>



<div class="subheader"><?php echo pvs_word_lang( "photo" );?></b></div>
	<div class="subheader_text">



<table>
<tr valign="top">


<td style="padding-right:10px">
<?php echo get_avatar(get_current_user_id()); ?>
<?php
if ( file_exists (pvs_upload_dir() . "/content/users/" . $user_info->user_login . ".jpg") ) {
	?>
	<div><a href="<?php echo (site_url( ) );?>/profile-photo-delete/"><?php echo pvs_word_lang( "delete" );?></a></div>
	<?php 
}
?>
	</td>

<td>
<form method=post Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/profile-photo-upload/">
<div style="margin-top:5px"><input type="file" name="avatar" style="width:200px"></div>
<div class="smalltext"><small>*.jpg < 2Mb.</small></div>
<div style="margin-top:5px"><input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "upload" );?>"></div>
</form>
</td>
</tr>
</table>

</div>



<?php
} //End. Not free license
include ( "profile_bottom.php" );
?>