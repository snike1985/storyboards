<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<div class="page_internal">
<h1><?php echo pvs_word_lang( "Google map" )?></h1>

<div id="map_canvas" class="map" style="width:1000px;height:700px"></div>

<script src="https://maps.google.com/maps/api/js?sensor=false&key=<?php echo $pvs_global_settings["google_api"] ?>"></script> 
<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery-ui-map-3.0-rc/markerclustererplus-2.0.6/markerclusterer.js"></script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery-ui-map-3.0-rc/jquery.ui.map.min.js"></script>
<script>
	$(function() { 


			$('#map_canvas').gmap({'zoom': 2, 'disableDefaultUI':true,'zoomControl': true,'panControl': true,'mapTypeControl': true,'scaleControl': true,'streetViewControl': true,
'overviewMapControl': true}).bind('init', function(evt, map) { 
			
	var bounds = map.getBounds();
	var southWest = bounds.getSouthWest();
	var northEast = bounds.getNorthEast();
	var lngSpan = northEast.lng() - southWest.lng();
	var latSpan = northEast.lat() - southWest.lat();
	

	
	<?php
$sql_mass = array();

//Media
$sql_mass["media"] =
	"select id,title,server1,google_x,google_y,description,media_id from " .
	PVS_DB_PREFIX . "media where google_x<>0 and google_y<>0 order by id desc";


//Category
$sql_mass["category"] =
	"select id,title,description,location,keywords,google_x,google_y,photo,creation_date from " .
	PVS_DB_PREFIX . "category where google_x<>0 and google_y<>0 and activation_date < " .
	pvs_get_time() . " and (expiration_date > " . pvs_get_time() .
	" or expiration_date = 0) order by id desc";

foreach ( $sql_mass as $key => $value ) {
	$rs->open( $value );
	$n = 0;
	while ( ! $rs->eof ) {
		$img_url = "";

		$remote_width = 0;
		$remote_height = 0;
		$flag_storage = false;

		if ( $key != "category" and $rs->row["media_id"] == 1 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb1.jpg' or filename1='thumb1.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}
		if ( $key != "category" and $rs->row["media_id"] == 2 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb.jpg' or filename1='thumb.jpeg' or filename1='thumb0.jpg' or filename1='thumb0.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}
		if ( $key != "category" and $rs->row["media_id"] == 3 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb.jpg' or filename1='thumb.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}
		if ( $key != "category" and $rs->row["media_id"] == 4 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb1.jpg' or filename1='thumb1.jpeg' or filename1='thumb.jpg' or filename1='thumb.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}

		if ( $key != "category" ) {
			if ( ! $flag_storage )
			{
				$size = @getimagesize( pvs_upload_dir() . $img_url );
				$img_width = round( $size[0] / 2 );
				$img_height = round( $size[1] / 2 );
			} else
			{
				$img_width = round( $remote_width / 2 );
				$img_height = round( $remote_height / 2 );
			}
		} else {
			$category_result = pvs_show_category_preview($rs->row["id"]);
			$img_url = $category_result["photo"];
			$img_width = round( $category_result["width"] / 4 );
			$img_height = round( $category_result["height"] / 4 );
		}
?>
				$(this).gmap('addMarker', 
				{
		'position': '<?php echo $rs->row["google_x"] ?>,<?php echo $rs->row["google_y"] ?>', 
		'bounds': true,
		/*
		'icon':
		{
			'url':'<?php echo $img_url
?>',
			'size':
			{
				'width':'<?php echo $img_width
?>', 
				'height':'<?php echo $img_height
?>'
			}
		},
		*/
				} 
			 ).click(function() 
			{
				<?php
		if ( $key != "category" ) {
?>
		$('#map_canvas').gmap('openInfoWindow', {'content': '<a href="<?php
			echo pvs_item_url( $rs->row["id"] )?>"><img border="0" src="<?php
			echo $img_url
?>"></a><div style="padding:5px 0px 3px 0px"><a href="<?php
			echo pvs_item_url( $rs->row["id"] )?>"><b><?php
			echo addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["title"] ) ) )?></b></a></div><?php
			echo addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["description"] ) ) )?>',maxWidth: 220}, this);
				<?php
		} else {

			$itg = "";
			$nlimit = 0;
			$count_id = pvs_count_files_in_category( $rs->row["id"] );?>
		$('#map_canvas').gmap('openInfoWindow', {'content': '<a href="<?php
			echo pvs_category_url( $rs->row["id"] )?>"><img border="0" src="<?php
			echo $img_url
?>" style="max-height:200px"></a><div style="padding:5px 0px 3px 0px"><a href="<?php
			echo pvs_category_url( $rs->row["id"] )?>"><b><?php
			echo addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["title"] ) ) )?></b></a></div><div><?php
			echo addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["description"] ) ) )?></div><div><?php
			echo addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["location"] ) ) )?></div><div><?php
			echo date( date_format, $rs->row['creation_date'] )?></div><div><?php
			echo ( pvs_word_lang( "photos" ) . ": " . $count_id );?></div>',maxWidth: 220}, this);
				<?php
		}
?>
			})
			<?php
		$n++;
		$rs->movenext();
	}
}
?>
	$(this).gmap('set', 'MarkerClusterer', new MarkerClusterer(map, $(this).gmap('get', 'markers')));
			});


	});
</script>



</div>
