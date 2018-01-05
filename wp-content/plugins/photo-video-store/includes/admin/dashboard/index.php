<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "dashboard_dashboard" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Set .htaccess
pvs_set_htaccess();


$sql = "select * from " . PVS_DB_PREFIX . "filestorage where types=0";
$rs->open( $sql );
while ( ! $rs->eof ) {

	if ( ! is_writeable(pvs_upload_dir() . $rs->row["url"] ) ) {
		echo('<div class="alert alert-danger" role="alert">Error! The directory <b>' . pvs_upload_dir() . $rs->row["url"] . '</b>  is <b>not writable</b>. The script cannot upload any files there.</p>');
	}
	
	if ( ! file_exists( pvs_upload_dir() . $rs->row["url"] . "/.htaccess" ) ) {
		echo('<div class="alert alert-danger" role="alert"><b>Security risk!</b> The file <b>' . pvs_upload_dir() . $rs->row["url"] . '/.htaccess doesn\'t exist.</b>. You should immediately create it with the content:<br>
		
		<br>
<small>RewriteEngine On<br>
RewriteRule ([0-9]+)/thumb_original\.jpg$ ' . pvs_plugins_url() . '/assets/images/access_denied.gif<br>
RewriteRule ([0-9]+)/thumb([A-Za-z0-9]{0,}).(jpg|jpeg|flv|mp4|mp3)$ $1/thumb$2.$3<br>
RewriteRule ([0-9]+)/([A-Za-z0-9_-]{0,})\.([A-Za-z0-9]+)$ ' . site_url() . '/download/?u=$1/$2.$3<br>
RemoveHandler .phtml .php .php3 .php4 .php5 .php6 .phps .cgi .exe .pl .asp .aspx .shtml .shtm .fcgi .fpl .jsp .htm .html .wml<br>
AddType text/html .phtml .php .php3 .php4 .php5 .php6 .phps .cgi .exe .pl .asp .aspx .shtml .shtm .fcgi .fpl .jsp .htm .html .wml <br>
AddHandler server-parsed .phtml .php .php3 .php4 .php5 .php6 .phps .cgi .exe .pl .asp .aspx .shtml .shtm .fcgi .fpl .jsp .htm .html .wml<br></small>
		
		
		</div>');
	}
	$rs->movenext();
}

//Activation
if ( @$_REQUEST["action"] == 'api_activate' ) {
	include ( "api_activate.php" );
}

//Content
if ( @$_REQUEST["action"] == 'api' or @$_REQUEST["action"] == 'api_save' ) {
	include ( "api.php" );
} else {
?>

          <h1>
            Plugin: Photo Video Store
            <small><a href="https://www.cmsaccount.com/" target="blank">version <?php echo PVS_VERSION
?></a><br><iframe src="https://www.cmsaccount.com/members/version.php?version=<?php echo PVS_VERSION
?>" style="width:300px;height:20px;margin-top:5px" frameborder="no" scrolling="no"></iframe></small><br>
          </h1><br>
          <div class="alert alert-info">
          	<?php echo(pvs_word_lang("license"));?>: <b><u><?php echo PVS_LICENSE ?></u></b> 
          	<?php
          	if ( PVS_LICENSE != 'Free') {
          		if (@$pvs_global_settings["activation"] == 0) {
          			echo('<span class="label label-danger">' . pvs_word_lang('Not activated') . '</span>');
          		} else {
          			echo('<span class="label label-success">' . pvs_word_lang('Activated') . '</span>');
          		}
          	}
          	?>
          	<br><br>
          	<?php
          	if ( PVS_LICENSE != 'Free' ) {
          		echo( '<a href="' . pvs_plugins_admin_url('dashboard/index.php') . '&action=api" class="btn btn-primary">' . pvs_word_lang('API keys') . '</a> ' );
          		if (@$pvs_global_settings["activation"] == 0) {
          			echo( '<a href="' . pvs_plugins_admin_url('dashboard/index.php') . '&action=api_activate" class="btn btn-success">' . pvs_word_lang('Activate license') . '</a> ' );
          		}
          	}
          	if ( PVS_LICENSE == 'Free' ) {
          		echo( '<a href="https://www.cmsaccount.com/download/" target="blank" class="btn btn-danger">' . pvs_word_lang('Purchase Full license now!') . '</a>' );
          	}
          	 if ( PVS_LICENSE == 'Lite' ) {
          		echo( '<a href="https://www.cmsaccount.com/download/" target="blank" class="btn btn-danger">' . pvs_word_lang('Upgrade to Full license now!') . '</a>' );
          	}
          	?>
          </div>
        </section>
        
        
		<script>
		function pvs_order_status(value) 
		{
			jQuery.ajax({
				type:'POST',
				url:ajaxurl,
				data:'action=pvs_order_status&id=' + value,
				success:function(data){
					if(data.charAt(data.length-1) == '0')
					{
						data = data.substring(0,data.length-1)
					}
					document.getElementById('status'+value).innerHTML =data;
				}
			});
		}
		
		function pvs_order_shipping_status(value) 
		{
			jQuery.ajax({
				type:'POST',
				url:ajaxurl,
				data:'action=pvs_order_shipping_status&id=' + value,
				success:function(data){
					if(data.charAt(data.length-1) == '0')
					{
						data = data.substring(0,data.length-1)
					}
					document.getElementById('shipping'+value).innerHTML =data;
				}
			});
		}

		function pvs_credits_status(value) 
		{
			jQuery.ajax({
				type:'POST',
				url:ajaxurl,
				data:'action=pvs_credits_status&id=' + value,
				success:function(data){
					if(data.charAt(data.length-1) == '0')
					{
						data = data.substring(0,data.length-1)
					}
					document.getElementById('cstatus'+value).innerHTML =data;
				}
			});
		}		


		function pvs_subscription_status(value) 
		{
			jQuery.ajax({
				type:'POST',
				url:ajaxurl,
				data:'action=pvs_subscription_status&id=' + value,
				success:function(data){
					if(data.charAt(data.length-1) == '0')
					{
						data = data.substring(0,data.length-1)
					}
					document.getElementById('sstatus'+value).innerHTML =data;
				}
			});
		}		

		</script>

        
        
        <?php
$current_month = date( "n" );
$current_year = date( "Y" );
$month_step = 8;

$sales_year_credits = array();
$sales_year_orders = array();
$sales_year_subscription = array();
$sales_month_credits = array();
$sales_month_orders = array();
$sales_month_subscription = array();

$sales_year_credits[$current_year] = 0;
$sales_year_orders[$current_year] = 0;
$sales_year_subscription[$current_year] = 0;

$count_photos = 0;
$count_videos = 0;
$count_audio = 0;
$count_vector = 0;
$count_orders = 0;
$count_credits = 0;
$count_subscription = 0;
$count_users = 0;

for ( $i = $month_step; $i >= 0; $i-- ) {
	$j = $current_month - $i;
	if ( $j <= 0 ) {
		$j = 12 + $current_month - $i;
	}
	$sales_month_credits[$j] = 0;
	$sales_month_orders[$j] = 0;
	$sales_month_subscription[$j] = 0;
}

$buyers_total = array();
$items_total = array();

if ( $pvs_global_settings["credits"] == 1 ) {
	//Credits
	$sql = "select total,data,quantity from " . PVS_DB_PREFIX .
		"credits_list where quantity>0 and approved=1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( $rs->row["data"] > pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
			date( "m" ), date( "d" ), date( "Y" ) ) - 365 * 24 * 3600 ) {
			foreach ( $sales_month_credits as $key => $value )
			{
				if ( $key == date( "n", $rs->row["data"] ) )
				{
					$sales_month_credits[$key] += (int)$rs->row["total"];
				}
			}
			if ( $current_year == date( "Y", $rs->row["data"] ) )
			{
				$sales_year_credits[$current_year] += (int)$rs->row["total"];
			}
		}

		$count_credits += $rs->row["quantity"];

		$rs->movenext();
	}
}

if ( ! $pvs_global_settings["credits"] or ( $pvs_global_settings["credits"] and
	$pvs_global_settings["credits_currency"] ) ) {
	//Orders
	$sql = "select total,data,user from " . PVS_DB_PREFIX . "orders where status=1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( $rs->row["data"] > pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
			date( "m" ), date( "d" ), date( "Y" ) ) - 365 * 24 * 3600 ) {
			foreach ( $sales_month_orders as $key => $value )
			{
				if ( $key == date( "n", $rs->row["data"] ) )
				{
					$sales_month_orders[$key] += (int)$rs->row["total"];
				}
			}
			if ( $current_year == date( "Y", $rs->row["data"] ) )
			{
				$sales_year_orders[$current_year] += (int)$rs->row["total"];
			}
		}

		if ( ! isset( $buyers_total[$rs->row["user"]] ) ) {
			$buyers_total[$rs->row["user"]] = (int)$rs->row["total"];
		} else {
			$buyers_total[$rs->row["user"]] += (int)$rs->row["total"];
		}

		$count_orders++;

		$rs->movenext();
	}
}

if ( $pvs_global_settings["subscription"] == 1 ) {
	//Subscription
	$sql = "select total,data1,payments,user from " . PVS_DB_PREFIX .
		"subscription_list where approved=1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( $rs->row["data1"] > pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
			date( "m" ), date( "d" ), date( "Y" ) ) - 365 * 24 * 3600 ) {
			foreach ( $sales_month_subscription as $key => $value )
			{
				if ( $key == date( "n", $rs->row["data1"] ) )
				{
					$sales_month_subscription[$key] += $rs->row["total"] * $rs->row["payments"];
				}
			}
			if ( $current_year == date( "Y", $rs->row["data1"] ) )
			{
				$sales_year_subscription[$current_year] += $rs->row["total"] * $rs->row["payments"];
			}
		}

		if ( ! isset( $buyers_total[pvs_user_login_to_id( $rs->row["user"] )] ) ) {
			$buyers_total[pvs_user_login_to_id( $rs->row["user"] )] = $rs->row["total"];
		} else {
			$buyers_total[pvs_user_login_to_id( $rs->row["user"] )] += $rs->row["total"];
		}

		$count_subscription++;

		$rs->movenext();
	}
}

$sales_month_list = "";
$sales_credits_list = "";
$sales_orders_list = "";
$sales_subscription_list = "";

foreach ( $sales_month_credits as $key => $value ) {
	if ( $sales_month_list != "" ) {
		$sales_month_list .= ",";
	}
	if ( $sales_credits_list != "" ) {
		$sales_credits_list .= ",";
	}
	$sales_month_list .= '"' . $m_month[$key - 1] . '"';
	$sales_credits_list .= $value;
}

foreach ( $sales_month_orders as $key => $value ) {
	if ( $sales_orders_list != "" ) {
		$sales_orders_list .= ",";
	}
	$sales_orders_list .= $value;
}

foreach ( $sales_month_subscription as $key => $value ) {
	if ( $sales_subscription_list != "" ) {
		$sales_subscription_list .= ",";
	}
	$sales_subscription_list .= $value;
}

if ( $pvs_global_settings["allow_photo"] ) {
	$sql = "select count(id) as count_param from " . PVS_DB_PREFIX .
		"media where published=1 and media_id=1 group by published";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$count_photos = $rs->row["count_param"];
	}
}

if ( $pvs_global_settings["allow_video"] ) {
	$sql = "select count(id) as count_param from " . PVS_DB_PREFIX .
		"media where published=1 and media_id=2 group by published";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$count_videos = $rs->row["count_param"];
	}
}

if ( $pvs_global_settings["allow_audio"] ) {
	$sql = "select count(id) as count_param from " . PVS_DB_PREFIX .
		"media where published=1 and media_id=3 group by published";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$count_audio = $rs->row["count_param"];
	}
}

if ( $pvs_global_settings["allow_vector"] ) {
	$sql = "select count(id) as count_param from " . PVS_DB_PREFIX .
		"media where published=1 and media_id=4 group by published";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$count_vector = $rs->row["count_param"];
	}
}

$sql = "select count(ID) as count_param from " . $table_prefix . "users group by user_login";
$rs->open( $sql );
if ( ! $rs->eof ) {
	$count_users = $rs->row["count_param"];
}
?>
        
<br>


          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
			<?php
$sql = "select title from " . PVS_DB_PREFIX .
	"templates_admin_home where activ=1 and left_right=0 order by priority";
$dd->open( $sql );
while ( ! $dd->eof ) {
	$tab_name = preg_replace( "/[^a-z_]/i", "", strtolower( str_replace( " ", "_", $dd->
		row["title"] ) ) );
	if ( ! isset( $_COOKIE["delete_" . $tab_name] ) or $_COOKIE["delete_" . $tab_name] ==
		0 ) {
		include ( PVS_PATH . "includes/admin/dashboard/" . $tab_name . ".php" );
	}

	$dd->movenext();
}
?>
            

            </div><!-- /.col -->
			<div class="col-md-4">
			<?php
$sql = "select title from " . PVS_DB_PREFIX .
	"templates_admin_home where activ=1 and left_right=1 order by priority";
$dd->open( $sql );
while ( ! $dd->eof ) {
	$tab_name = preg_replace( "/[^a-z_]/i", "", strtolower( str_replace( " ", "_", $dd->
		row["title"] ) ) );

	if ( ! isset( $_COOKIE["delete_" . $tab_name] ) or $_COOKIE["delete_" . $tab_name] ==
		0 ) {
		include ( PVS_PATH . "includes/admin/dashboard/" . $tab_name . ".php" );
	}

	$dd->movenext();
}
?>


            </div><!-- /.col -->
          </div><!-- /.row -->
<?php
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>