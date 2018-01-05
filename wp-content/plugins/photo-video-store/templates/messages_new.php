<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
include ( "profile_top.php" );

$type = "new";
?>

<h1><?php echo pvs_word_lang( "messages" )?> - <?php echo pvs_word_lang( "new message" )?></h1>




<script>
	form_fields=new Array("to","subject","content");
	fields_emails=new Array(0,0,0);
	error_message="<?php echo pvs_word_lang( "Incorrect field" )?>";
</script>
<script src="<?php echo pvs_plugins_url()?>/assets/jquery.qtip-1.0.0-rc3.min.js"></script>





<?php
if ( ! isset( $_GET["d"] ) or $_GET["d"] == 2 ) {
	$touser = "";
	$subject = "";
	$content = "";

	if ( isset( $_GET["m"] ) ) {
		$sql = "select touser,subject,content,data,id_parent,fromuser from " .
			PVS_DB_PREFIX . "messages where id_parent=" . ( int )$_GET["m"] .
			" and touser='" . pvs_result( pvs_get_user_login () ) . "'";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$touser = $rs->row["fromuser"];
			$subject = "Re: " . $rs->row["subject"];
			$content = "\n\n\n\n\n\n" . pvs_word_lang( "you wrote" ) . ": " . date( datetime_format,
				$rs->row["data"] ) . "\n" . $rs->row["content"];
		}
	}

	if ( isset( $_GET["user"] ) ) {
		$sql = "select friend1,friend2 from " . PVS_DB_PREFIX .
			"friends where friend1='" . pvs_result( pvs_get_user_login () ) .
			"' and friend2='" . pvs_result_strict( $_GET["user"] ) . "'";
		$rs->open( $sql );
		if ( $rs->eof ) {
			$sql = "insert into " . PVS_DB_PREFIX . "friends (friend1,friend2) values ('" .
				pvs_result( pvs_get_user_login () ) . "','" . pvs_result_strict( $_GET["user"] ) .
				"')";
			$db->execute( $sql );
		}
		$touser = pvs_result_strict( $_GET["user"] );
	}
?>






<form method="post" action="<?php echo (site_url( ) );?>/messages-add/" onSubmit="return my_form_validate();">



<div class="form_field">
<span><b><?php echo pvs_word_lang( "to" )?>:</b></span>

<select name="to" id="to" style="width:200px" class='ibox form-control'><option value=""></option>
<?php
	$sql = "select friend1, friend2 from " .
		PVS_DB_PREFIX . "friends where friend1='" . pvs_result( pvs_get_user_login () ) .
		"' order by friend1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$sel = "";
		if ( $touser == $rs->row["friend2"] ) {
			$sel = "selected";
		}
?>
<option value="<?php echo $rs->row["friend2"] ?>" <?php echo $sel
?>><?php echo pvs_show_user_name( $rs->row["friend2"] )?></option>
<?php
		$rs->movenext();
	}
?>

</select>
</div>


<div class="form_field">
<span><?php echo pvs_word_lang( "cc" )?>:</span>

<select name="cc" style="width:200px" class='ibox form-control'><option value=""></option>
<?php
	$sql = "select friend1, friend2 from " .
		PVS_DB_PREFIX . "friends where friend1='" . pvs_result( pvs_get_user_login () ) .
		"' order by friend1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
?>
<option value="<?php echo $rs->row["friend2"] ?>"><?php echo pvs_show_user_name( $rs->row["friend2"] )?></option>
<?php
		$rs->movenext();
	}
?>

</select>
</div>


<div class="form_field">
<span><?php echo pvs_word_lang( "bcc" )?>:</span>

<select name="bcc" style="width:200px" class='ibox form-control'><option value=""></option>
<?php
	$sql = "select friend1, friend2 from " .
		PVS_DB_PREFIX . "friends where friend1='" . pvs_result( pvs_get_user_login () ) .
		"' order by friend1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
?>
<option value="<?php echo $rs->row["friend2"] ?>"><?php echo pvs_show_user_name( $rs->row["friend2"] )?></option>
<?php
		$rs->movenext();
	}
?>

</select>
</div>


<div class="form_field">
<span><b><?php echo pvs_word_lang( "subject" )?>:</b></span>
<input class='ibox form-control' type="text" style="width:400px" name="subject"  id="subject" value="<?php echo $subject
?>">
</div>





<div class="form_field">
<span><b><?php echo pvs_word_lang( "content" )?>:</b></span>
<textarea name="content" id="content" style="width:400px;height:250px" class='ibox form-control'><?php echo $content
?></textarea>
</div>



<div class="form_field">
<input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "send" )?>">
</div>

</form>

<p>* <?php echo pvs_word_lang( "friend email" )?></p>



<?php
} else
{
?>
<p><b><?php echo pvs_word_lang( "sent" )?><b></p>

<?php
}

include ( "profile_bottom.php" );
?>