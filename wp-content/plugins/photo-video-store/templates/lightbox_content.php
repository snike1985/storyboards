<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );?>

<h1><?php echo pvs_word_lang( "my favorite list" )?>
<?php
if ( isset( $_GET["id"] ) ) {
	echo ( " &mdash; " . pvs_word_lang( "edit" ) );
} else
{
	echo ( " &mdash; " . pvs_word_lang( "add" ) );
}

$users_field = array();
$users_field["title"] = "";
$users_field["description"] = "";

if ( isset( $_GET["id"] ) ) {
	$id = ( int )$_GET["id"];

	//Check
	$sql = "select id_parent,user_owner from " . PVS_DB_PREFIX .
		"lightboxes_admin where user=" . get_current_user_id() .
		" and id_parent=" . $id . " and  user_owner=1";
	$rs->open( $sql );
	if ( $rs->eof ) {
		exit();
	}

	$sql = "select title,description from " . PVS_DB_PREFIX . "lightboxes where id=" .
		$id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$users_field["title"] = $rs->row["title"];
		$users_field["description"] = $rs->row["description"];
	}
} else
{
	$id = 0;
}
?>
</h1>

<script>
	form_fields=new Array("title");
	fields_emails=new Array(0,0);
	error_message="<?php echo pvs_word_lang( "Incorrect field" )?>";
</script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<form method="post" action="<?php echo (site_url( ) );?>/lightbox-edit/?id=<?php echo $id
?>" onSubmit="return my_form_validate();">

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "title" )?>:</b></span>
	<input type="text" class="ibox form-control" style="width:300px" name="title" id="title" value="<?php echo $users_field["title"] ?>">
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "description" )?>:</b></span>
	<textarea class="ibox form-control" style="width:300px;height:70px" name="description" id="description"><?php echo $users_field["description"] ?></textarea>
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "administrators" )?>*:</b></span>

<?php
$n = 1;
$sql = "select friend1,friend2 from " . PVS_DB_PREFIX .
	"friends where friend1='" . pvs_result( pvs_get_user_login () ) .
	"' order by friend2";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0"> 
	<tr>
	<?php
	while ( ! $rs->eof ) {
		$user_id = 0;
		$sql = "select ID from " . $table_prefix . "users where user_login='" . $rs->
			row["friend2"] . "'";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$user_id = $dr->row["ID"];
		}

		$sel = "";
		$sql = "select id_parent from " . PVS_DB_PREFIX . "lightboxes_admin where user=" .
			$user_id . " and id_parent=" . $id;
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$sel = "checked";
		}

		if ( $n % 4 == 0 ) {
			echo ( "</tr><tr valign=top>" );
		}
?>
		<td style="padding-right:50px;padding-bottom:20px">
		<input type="checkbox" name="user<?php echo $user_id
?>" <?php echo $sel
?>>&nbsp;<?php echo pvs_show_user_name( $rs->row["friend2"], "login" )?>
		</td>
		<?php
		$n++;
		$rs->movenext();
	}
?>
	</tr>
	</table>
	<?php
} else
{
?>
	<p><b><?php echo pvs_word_lang( "not found" )?></b></p>
	<?php
}
?>	

</div>


<div class="form_field">
	<input type="submit" class="isubmit" value="<?php echo pvs_word_lang( "save" )?>">
</div>
	
</form>

<p>* You may assign only your friends to the administrators.</p>

<?php
include ( "profile_bottom.php" );
?>