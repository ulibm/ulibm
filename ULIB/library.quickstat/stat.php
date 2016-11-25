<?php  
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
?>
<script>
function localopen(url,wh) {
   window.open("export2.php?"+url+wh.value);
   wh.selectedIndex=0;
}
</script>
<?php
	$s=tmq("select * from quickstat where id='$id'");
	$s=tmq_fetch_array($s);
	?><B><?php  echo getlang("สถิติ::l::Statistic").": ".getlang($s[name]);?></B><BR>
	<?php  
echo getlang("ดึงข้อมูลจากแท็ก::l::Use tag").": ".getlang($s[tag]). " ";
echo getlang("เฉพาะข้อมูลในปี::l::These year(s) only").": ".($s[yea]);
if (trim($s[yea])=="") {
	echo getlang("ทุกปี::l::All years");
}
$x=explodenewline($s["stat"]);
$x=arr_filter_remnull($x);
@reset($x);

$yea=explodenewline($s["yea"]);

$yeasql="";
while (list($yeak,$yeav)=each($yea)) {
	if ($yeasql!="") {
		$yeasql="$yeasql or";
	}
	$yeasql="$yeasql tag008 LIKE  '_______$yeav%'";
}
		$yeasql="($yeasql)";
		//echo $yeasql;
@reset($yea);
	//printr($yea);

$db=barcodeval_get("quickstat-descr");
$db=explodenewline($db);
$db=arr_filter_remnull($db);
@reset($db);
$dba=Array();
while (list($dbk,$dbv)=each($db)) {
	$db1=explode("=",$dbv);
	$dba[trim($db1[0])]=trim(getlang($db1[1]));
}
//printr($dba);
$statarr=Array();
	?><TABLE width=100% class=table_border>
	<TR>
		<TD class=table_head width=40%>-</TD>
		<TD class=table_head width=15%>Bib</TD>
		<TD class=table_head width=15%>Items</TD>
		<TD class=table_head width=10%>Export</TD>
	</TR>
	<?php  
	$bibsum=0;
	$isum=0;
	while (list($k,$v)=each($x)) {
	  $statarr[$v]=Array();
		//echo $v;
		?>
	<TR>
		<TD width=160 class=table_td><?php 
		$descr=$dba[$v];
		if ($descr=="") {
			echo $v;
		   //printr($s);
		   if ($s[tag]=="082" && mb_strlen($v)==2) {
		    $descr=$dba[$v."0"];
		    //try add 0
		    if ($descr!="") {
		       echo " ".$descr;
		    }
		   }
		} else {
			echo "$v ".$descr;
		}
			$statarr[$v][name]="$v ".$descr;
		
		?></TD>
		<TD class=table_td><?php  
			$sql="select * from media where $yeasql ";

			$sql.=" and (
				tag$s[tag] like '__$v%'  
				or
				tag$s[tag] like '__^a$v%'  
				) ";
			//echo $sql;
			$sql=tmq($sql);
			$cc=tmq_num_rows($sql);
			$statarr[$v][bib]=floor($cc);
			echo number_format($cc);
			$bibsum=$bibsum+$cc;

		?></TD>
			<TD class=table_td><?php  
			$sql="select * from media,media_mid where media.ID=media_mid.pid and $yeasql ";

			$sql.=" and (
				tag$s[tag] like '__$v%'  
				or
				tag$s[tag] like '__^a$v%'  
				) ";
			$sql=tmq($sql);
			$cc=tmq_num_rows($sql);
			$statarr[$v][item]=floor($cc);
			$isum=$isum+$cc;

			echo number_format($cc);
		?></TD>
					<TD class=table_td>
					<!----<A HREF="export.php?id=<?php echo $id?>&subid=<?php echo $v;?>" target=_blank>Export</A>-->
					<form><select onchange="localopen('id=<?php echo $id?>&subid=<?php echo $v;?>&exportmode=',this);">ส่งออกเป็น MARC :: HTML แบบเต็ม :: HTML แบบย่อ :: HTML สังเขป :: CSV :: CSV เฉพาะเนื้อหา 
					 <option value=''>Export</option>
					 <option value='quickview'>Quick View</option>
					 <option value='marc'><?php  echo getlang("ส่งออกเป็น MARC::l::Export as MARC")?></option>
					 <option value='full'><?php  echo getlang("HTML แบบเต็ม::l::Full html")?></option>
					 <option value='brieve'><?php  echo getlang("HTML แบบย่อ::l::Brieve HTML")?></option>
					 <option value='shorted'><?php  echo getlang("HTML สังเขป::l::very brieve HTML ")?></option>
					 <option value='csv'><?php  echo getlang("CSV::l::CSV")?></option>
					 <option value='csvreadable'><?php  echo getlang("CSV เฉพาะเนื้อหา::l::Readable CSV")?></option>
					 <option value='csv&encodemode=th'>th-<?php  echo getlang("CSV::l::CSV")?></option>
					 <option value='csvreadable&encodemode=th'>th-<?php  echo getlang("CSV เฉพาะเนื้อหา::l::Readable CSV")?></option>
					 <option value='custom'><?php  echo getlang("HTML-กำหนดเอง::l::HTML-Custom")?></option>

					</select></form>
					</TD>
	</TR>
	<?php  }?>
	<tr>
		<td class=table_head>Sum</td>
		<td class=table_head><?php echo number_format($bibsum);?></td>
		<td class=table_head><?php echo number_format($isum);?></td>
		<td  class=table_head>&nbsp;</td>
	</tr>
	</TABLE>
	
	
	
	
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/pie.js" type="text/javascript"></script>
        
        <!-- scripts for exporting chart as an image -->
        <!-- Exporting to image works on all modern browsers except IE9 (IE10 works fine) -->
        <!-- Note, the exporting will work only if you view the file from web server -->
        <!--[if (!IE) | (gte IE 10)]> -->
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/exporting/amexport.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/exporting/canvg.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/exporting/jspdf.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/exporting/filesaver.js" type="text/javascript"></script>
        <script src="<?php echo $dcrURL;?>library.stats/amcharts/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>
        <!-- <![endif]-->
        
<?php 
//printr($statarr);

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

?>
        <script type="text/javascript">

            var chartData = [<?php
               $i=0;
                while (list($k,$v)=each($statarr)) {
                  $i++; //echo count($gdata[data][1]);?>{
                   "maindate": "<?php echo $k ?>",
                       "bib": <?php echo $v[bib]; ?>,
                       "item": <?php echo $v[item]; ?>,
                       "color": "<?php echo localcol($k)?>"
               }<?php
                  if ($i<count($statarr)) {
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
                


                 <?php  ?>
AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.pathToImages = "<?php echo $dcrURL;?>library.stats/amcharts/images/";
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

                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "Bib";
                graph1.valueField = "bib";
                graph1.balloonText = "Bib";//"Income:[[value]]";
                graph1.lineAlpha = 0;
                graph1.fillColors = "<?php echo localcol($tmptitlei)?>";
                graph1.fillAlphas = 1;
                chart.addGraph(graph1);

                var graph2 = new AmCharts.AmGraph();
                graph2.type = "column";
                graph2.title = "Item";
                graph2.valueField = "item";
                graph2.balloonText = "Item";//"Income:[[value]]";
                graph2.lineAlpha = 0;
                graph2.fillColors = "<?php echo localcol($tmptitlei)?>";
                graph2.fillAlphas = 1;
                chart.addGraph(graph2);


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
                chartScrollbar.gridCount = 20;
                chartScrollbar.color = "#888888";
                chart.addChartScrollbar(chartScrollbar);
                
                // WRITE
                chart.write("chartdiv");
                 });
                 
        </script>
        <style>
.amExportButton {
   top: 40px!important;
}
        </style>
        <div id="chartdiv" style="width: 100%; height: 500px;"></div><br> 