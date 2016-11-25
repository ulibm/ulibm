<?php 
include ("../inc/config.inc.php");
// Standard inclusions     
include("pChart/pChart/pData.class");  
include("pChart/pChart/pChart.class");  

html_start();



  $maxgraphval=0;
$gdata=sessionval_get("$gid");
$gdata=unserialize($gdata);
//printr($gdata);

 // Dataset definition 
 $DataSet = new pData;
 $si=0;
// printr($gdata[title][Description]);
 @reset($gdata[title][Description]);
	while (list($k,$v)=each($gdata[title][Description])) {
		$gdata[title][Description][$k]=strip_tags($gdata[title][Description][$k]);
	}

 @reset($gdata[data]);
while (list($k,$v)=each($gdata[data])) {
	$si++;
	$tmp=max($gdata[data][$si]);
	if ($tmp>$maxgraphval) {
		$maxgraphval=$tmp;
	}
	//for ($i=1;$i<=31;$i++) {
	//}
}

 @reset($gdata[data]);
$si=0;
while (list($k,$v)=each($gdata[data])) {
	$si++;
	echo $gdata[Description]["name$si"]."<BR>";
}

//printr($gdata);


 /// $Test->clearShadow();  


 // Finish the graph
 $colarr=explode(",","00904B,64BD4F,E13987,F191BA,FEEA65,835322,72CBDB,55134E,A0596B,FEC343,EF7351,0099CC,CCFFCC,66CCFF,003399");
 shuffle($colarr);
$localcoli=0;
function localcol( $username ) {
   global $colarr;
   global $localcoli;
   $localcoli=$localcoli+1;
   if ($localcoli>=count($colarr)) {
      $localcoli=0;
   }
   return "#".$colarr[$localcoli];
}


if ($charttype=="") {
   $charttype="serial";
}
?>
        <script src="./amcharts/amcharts.js" type="text/javascript"></script>
        <script src="./amcharts/serial.js" type="text/javascript"></script>
        <script src="./amcharts/pie.js" type="text/javascript"></script>
        
        <!-- scripts for exporting chart as an image -->
        <!-- Exporting to image works on all modern browsers except IE9 (IE10 works fine) -->
        <!-- Note, the exporting will work only if you view the file from web server -->
        <!--[if (!IE) | (gte IE 10)]> -->
        <script src="./amcharts/exporting/amexport.js" type="text/javascript"></script>
        <script src="./amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
        <script src="./amcharts/exporting/canvg.js" type="text/javascript"></script>
        <script src="./amcharts/exporting/jspdf.js" type="text/javascript"></script>
        <script src="./amcharts/exporting/filesaver.js" type="text/javascript"></script>
        <script src="./amcharts/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>
        <!-- <![endif]-->


        
        <script type="text/javascript">

            var chartData = [<?php
               $tmptitle=$gdata[title][Description];
               $i=0;
                while (list($k,$v)=each($gdata[data][1])) {  $i++; //echo count($gdata[data][1]);?>{
               
                   "maindate": "<?php echo str_replace("Serie","",$k) ?>",
                       <?php 
                       @reset($tmptitle);
                       $tmptitlei=0;
                       while (list($tk,$tv)=each($tmptitle)) {
                          $tmptitlei++;
                          echo "\"$tk\": ". floor($gdata[data][$tmptitlei]["Serie".$i]).",$newline";
                       }
                       ?>
                       "color": "<?php echo localcol($k)?>"
               }<?php
                  if ($i<count($gdata[data][1])) {
                     echo ",";
                  }
               }

            ?>]


            var chartDataPie = [<?php
               $tmptitle=$gdata[title][Description];
               $i=0;
               @reset($gdata);
               @reset($gdata[data][1]);
                while (list($k,$v)=each($gdata[data][1])) {  $i++; //echo count($gdata[data][1]);?>{
               
                   "maindate": "<?php echo str_replace("Serie","",$k) ?>",
                       <?php 
                       @reset($tmptitle);
                       $summed=0;
                       $tmptitlei=0;
                       while (list($tk,$tv)=each($tmptitle)) {
                       $tmptitlei=$tmptitlei+1;
                      // echo "".floor($gdata[data][$tmptitlei]["Serie".$i])."--";
                          $summed=$summed+floor($gdata[data][$tmptitlei]["Serie".$i]);
                       }
                       echo "\"Sum\": ". floor($summed).",$newline";
                       ?>
                       "color": "<?php echo localcol($k)?>"
               }<?php
                  if ($i<count($gdata[data][1])) {
                     echo ",";
                  }
               }

            ?>]            
// in order to set theme for a chart, all you need to include theme file
        // located in amcharts/themes folder and set theme property for the chart.
 
/*
                amExport: {
                    top: 21,
                    right: 21,
                    buttonColor: '#EFEFEF',
                    buttonRollOverColor:'#DDDDDD',
                    exportPNG:true,
                    exportJPG:true,
                    exportPDF:false,
                    exportSVG:true
                }*/
                
<?php if ($charttype=="pie") {?>
                 AmCharts.makeChart("chartdiv", {
                "type": "pie",
                "dataProvider": chartDataPie,
                "titleField": "maindate",
                "valueField": "Sum",
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "legend": {
                    "align": "center",
                    "markerType": "circle"
                },
                "pathToImages" :"./amcharts/images/"
               , 
               
               amExport: {
                    "top": 200,
                    "right": 21,
                    bottom: undefined,
                    buttonColor: '#EFEFEF',
                    buttonRollOverColor:'#DDDDDD',
                    exportPNG:true,
                    exportJPG:true,
                    exportPDF:false,
                    exportSVG:true
                },
                "creditsPosition" : "bottom-right"
            });
<?php } ?>
<?php if ($charttype=="serial") {?>

                 <?php  ?>
AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.pathToImages = "./amcharts/images/";
                chart.categoryField = "maindate";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart
                chart.rotate = false;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);

                // GRAPHS
                <?php
                @reset($tmptitle);
               $tmptitlei=0;
               while (list($tk,$tv)=each($tmptitle)) {
               $tmptitlei++;
               ?>
                var graph<?php echo $tmptitlei;?> = new AmCharts.AmGraph();
                graph<?php echo $tmptitlei;?>.type = "column";
                graph<?php echo $tmptitlei;?>.title = "<?php echo $tv?>";
                graph<?php echo $tmptitlei;?>.valueField = "name<?php echo $tmptitlei;?>";
                graph<?php echo $tmptitlei;?>.balloonText = "<?php echo $tv?>";//"Income:[[value]]";
                graph<?php echo $tmptitlei;?>.lineAlpha = 0;
                graph<?php echo $tmptitlei;?>.fillColors = "<?php echo localcol($tmptitlei)?>";
                graph<?php echo $tmptitlei;?>.fillAlphas = 1;
                chart.addGraph(graph<?php echo $tmptitlei;?>);
                <?php
                }?>

                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);
                chart.amExport={
                    top: 21,
                    right: 21,
                    buttonColor: '#EFEFEF',
                    buttonRollOverColor:'#DDDDDD',
                    exportPNG:true,
                    exportJPG:true,
                    exportPDF:false,
                    exportSVG:true
                }
                chart.creditsPosition = "bottom-right";
                
                // CURSOR                
                var chartCursor = new AmCharts.ChartCursor();
                chart.addChartCursor(chartCursor);
                
                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                //chartScrollbar.scrollbarHeight = 30;
                //chartScrollbar.graph = graph; // as we want graph to be displayed in the scrollbar, we set graph here
                chartScrollbar.graphType = "line"; // we don't want candlesticks to be displayed in the scrollbar                
                chartScrollbar.gridCount = 31;
                chartScrollbar.color = "#888888";
                chart.addChartScrollbar(chartScrollbar);
                
                // WRITE
                chart.write("chartdiv");
                 });
                 <?php 
                 }
                  ?>
        </script>
        <style>
.amExportButton {
   top: 40px!important;
}
        </style>
        <div id="chartdiv" style="width: 100%; height: 500px;"></div><br> 
        <center><a href="<?php echo $PHP_SELF;?>?gid=<?php echo $gid;?>&charttype=pie">Pie chart</a>
        <a href="<?php echo $PHP_SELF;?>?gid=<?php echo $gid;?>&charttype=serial">Serial chart</a> 