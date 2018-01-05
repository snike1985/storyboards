<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "sales" )?></span></h4>

                <div class="inside">
	<div class="main">
                <div class="box-body">
                      <div class="chart">
                        <canvas id="salesChart" height="250"></canvas>
                      </div>
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-red" style="color:#da4541">
                        <?php
	if ( $pvs_global_settings["credits"] ) {
?>
                        	<i class="fa fa-diamond"></i> <?php echo pvs_word_lang( "credits" )?>
                        <?php
	} else {
?>
                        	<i class="fa fa-cart-plus"></i> <?php echo pvs_word_lang( "orders" )?>
                        <?php
	}
?>
                        </span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-blue" style="color:#4c86b0"><i class="fa fa-clock-o"></i> <?php echo pvs_word_lang( "subscription" )?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                  </div>
                </div>
              </div>
</div>
</div>

<script src="<?php echo pvs_plugins_url()?>/assets/js/chartjs/Chart.min.js" type="text/javascript"></script>

	<script>
'use strict';
$(function () {

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: [<?php echo @$sales_month_list
?>],
    datasets: [
      <?php
	if ( $pvs_global_settings["credits"] ) {
?>
		  {
			label: "<?php echo pvs_word_lang( "credits" )?>",
			fillColor: "rgb(218, 69, 65)",
			strokeColor: "rgb(218, 69, 65)",
			pointColor: "rgb(218, 69, 65)",
			pointStrokeColor: "#c1c7d1",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgb(218, 69, 65)",
			data: [<?php echo @$sales_credits_list
?>]
		  }
      <?php
	} else {
?>
		  {
			label: "<?php echo pvs_word_lang( "orders" )?>",
			fillColor: "rgb(218, 69, 65)",
			strokeColor: "rgb(218, 69, 65)",
			pointColor: "rgb(218, 69, 65)",
			pointStrokeColor: "#c1c7d1",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgb(218, 69, 65)",
			data: [<?php echo @$sales_orders_list
?>]
		  }
	  <?php
	}

	if ( $pvs_global_settings["subscription"] ) {
		if ( ! $pvs_global_settings["subscription_only"] ) {
			echo ( "," );
		}
?>
		  {
			label: "<?php echo pvs_word_lang( "subscription" )?>",
			fillColor: "rgba(60,141,188,0.9)",
			strokeColor: "rgba(60,141,188,0.8)",
			pointColor: "#3b8bba",
			pointStrokeColor: "rgba(60,141,188,1)",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgba(60,141,188,1)",
			data: [<?php echo @$sales_subscription_list
?>]
		  }
      <?php
	}
?>
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"{{=name.toLowerCase()}}-legend\">{{ for (var i=0; i<datasets.length; i++){}}<li><span style=\"background-color:{{=datasets[i].lineColor}}\"></span>{{=datasets[i].label}}</li>{{}}}</ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------

});
	</script>

