<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_payments" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );



if ( isset( $_REQUEST["d"] ) ) {
	$d = $_REQUEST["d"];
} else {
	$d = 0;
}

?>


<h1><?php echo pvs_word_lang( "payments" )?></h1>




<h2 class="nav-tab-wrapper">
<a href="<?php echo(pvs_plugins_admin_url('gateways/index.php'));?>&d=0" class="nav-tab <?php
if ( $d == 0 )
{
	echo ( "nav-tab-active" );
}
?>"><?php echo pvs_word_lang( "payments" )?></a>



<?php
$i = 1;
foreach ( $pvs_payments as $key => $value ) {
	if ( @$pvs_global_settings[strtolower( $key ) . "_active"] == 1 or $d == $i ) {
?>
		<a href="<?php echo(pvs_plugins_admin_url('gateways/index.php'));?>&d=<?php echo $i
?>"  class="nav-tab <?php
if ( $d == $i )
{
	echo ( "nav-tab-active" );
}
?>"><?php echo $value
?></a>
	<?php
	}
	$i++;
}
?>
    	</h2>










<?php
if ( $d == 0 ) {
?>


<script>

function pvs_gateway_status(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_gateway_status&id=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+value).innerHTML = data;
		}
	});
}
</script>

<table class="wp-list-table widefat fixed striped posts">
<?php
	$i = 1;
	foreach ( $pvs_payments as $key => $value ) {
		if ( @$pvs_global_settings[strtolower( $key ) . "_active"] == 1 ) {
			$cl = "green";
		} else {
			$cl = "red";
		}
?>

<tr>
<td><a href="<?php echo(pvs_plugins_admin_url('gateways/index.php'));?>&d=<?php echo $i
?>"><b><?php echo $value
?></b></td>
<td><div id="status<?php echo $i
?>" name="status<?php echo $i
?>"><a href="javascript:pvs_gateway_status(<?php echo $i
?>);" class="<?php echo $cl
?>"><b><?php
		if ( @$pvs_global_settings[strtolower( $key ) . "_active"] == 1 ) {
			echo ( pvs_word_lang( "enabled" ) );
		} else {
			echo ( pvs_word_lang( "disabled" ) );
		}
?></b></a></div></td>
</tr>

<?php
		$i++;
	}
?>
</table>











<?php
} else
{
	$i = 1;
	foreach ( $pvs_payments as $key => $value ) {
		if ( $i == $d ) {
			echo ( "<div class='box_padding'>" );
			include ( PVS_PATH . 'includes/payments/' . $key . '/settings.php' );
			echo ( "</div>" );
		}
		$i++;
	}
}

include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>