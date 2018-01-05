<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>

<script src="<?php echo pvs_plugins_url();
?>/assets/js/raty/jquery.raty.min.js"></script>

<script>
    $(function() {
      $.fn.raty.defaults.path = '<?php echo pvs_plugins_url();
?>/assets/js/raty/img';

      $('.star').raty({ score: 3 });
      
    });
    
    function support_rating(id,score)
    {
    	var req = new JsHttpRequest();
        
    	// Code automatically called on load finishing.
   	 	req.onreadystatechange = function()
    	{
        	if (req.readyState == 4)
        	{
	
        	}
    	}
    	req.open(null, '<?php echo site_url();
?>/support-rating/', true);
    	req.send( {id: id,score:score } );
    }
</script>

<?php
if ( isset( $_GET["id"] ) ) {
	$sql = "select subject,message,data,user_id,closed from " . PVS_DB_PREFIX .
		"support_tickets where id=" . ( int )$_GET["id"] . " and user_id=" . get_current_user_id();
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "support_tickets set viewed_user=1 where id=" . ( int )
			$_GET["id"] . " or id_parent=" . ( int )$_GET["id"];
		$db->execute( $sql );?>

		<h1><?php echo pvs_word_lang( "support" );?> &mdash; <?php echo $rs->row["subject"];
?></h1>


		<div class="panel panel-default">
  			<div class="panel-heading">
  				<div class="link_date" style="float:right"><?php echo pvs_show_time_ago( $rs->row["data"] );?></div>
  				<?php echo pvs_show_user_avatar( $rs->row["user_id"], "id" );?>  				
			</div>
 			<div class="panel-body">
 				<?php echo str_replace( "\n", "<br>", $rs->row["message"] );?>
 			</div>
		</div>

		
		<?php
		$sql = "select id,subject,message,data,user_id,closed,admin_id,rating from " .
			PVS_DB_PREFIX . "support_tickets where id_parent=" . ( int )$_GET["id"] .
			" order by id";
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			$box_style = "default";
			if ( $ds->row["admin_id"] != 0 )
			{
				$box_style = "warning";
			}
?>

			<div class="panel panel-<?php echo($box_style);?>">
  			<div class="panel-heading">
  				<div class="link_date" style="float:right"><?php echo pvs_show_time_ago( $ds->row["data"] );?></div>
					<?php
							if ( $ds->row["user_id"] != 0 )
							{
				?>
						<?php
								echo pvs_show_user_avatar( $ds->row["user_id"], "id" );?>
						<?php
							}
							if ( $ds->row["admin_id"] != 0 )
							{
				?>
						<?php
								echo pvs_show_user_avatar( $ds->row["admin_id"], "id" );?>
						<?php
							}
				?>				
			</div>
 			<div class="panel-body">
				<?php
			echo str_replace( "\n", "<br>", $ds->row["message"] );?>
			
			<?php
			if ( $ds->row["admin_id"] != 0 )
			{
?>
	<script>
    			$(function() {
      	$('#star<?php
				echo $ds->row["id"];
?>').raty({
      	score: <?php
				echo $ds->row["rating"];
?>,
 		half: true,
  		number: 5,
  		click: function(score, evt) {
    		support_rating(<?php
				echo $ds->row["id"];
?>,score);
  		}
	});
    			});
	</script>
	<div id="star<?php
				echo $ds->row["id"];
?>" style="float:right;margin-top:7px"></div>
	<?php
			}
?>
			

			
			</div>
		</div>

			<?php
			$ds->movenext();
		}

		if ( $rs->row["closed"] == 0 ) {
?>

	<script>
		form_fields=new Array("message");
		fields_emails=new Array(0);
		error_message="<?php
			echo pvs_word_lang( "Incorrect field" );?>";
	</script>
	<script src="<?php
			echo pvs_plugins_url();
?>/assets/jquery.qtip-1.0.0-rc3.min.js"></script>
			
	<form method="post" action="/support-add/?id=<?php
			echo ( int )$_GET["id"];
?>" onSubmit="return my_form_validate();">
		
	<textarea class="ibox form-control" style="width:600px;height:150px;margin-bottom:15px" name="message" id="message"></textarea>

	<input type="submit" class="isubmit" value="<?php
			echo pvs_word_lang( "send" );?>">
	
	</form>
			<?php
		}
	}
}
?>


<?php
include ( "profile_bottom.php" );
?>