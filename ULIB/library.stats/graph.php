<?php 
include ("../inc/config.inc.php");
// Standard inclusions     
include("pChart/pChart/pData.class");  
include("pChart/pChart/pChart.class");  
if ($getcsv=="yes") {

header('Content-type: text/csv');
header('Content-disposition: attachment;filename='.str_remspecialsign($gid,"-").'.csv');
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
   
	$gdata=sessionval_get("$gid");
	$gdata=unserialize($gdata);

 @reset($gdata[title][Description]);
	@reset($gdata[data]["1"]);
	//printr($gdata[data]);
	echo "Statistic,";
	while (list($k2,$v2)=each($gdata[data]["1"])) {
		//echo "($k2,$v2)";
		$tmp=strip_tags($k2);
		echo $tmp.",";
	}
	echo "\n";
	while (list($k,$v)=each($gdata[title][Description])) {
		$tmp=strip_tags($gdata[title][Description][$k]);
		echo ($tmp).",";
		$k=str_replace("name","",$k);
		@reset($gdata[data]["$k"]);
		//printr($gdata[data]);
		while (list($k2,$v2)=each($gdata[data]["$k"])) {
			//echo "($k2,$v2)";
			$tmp=strip_tags($v2);
			echo $tmp.",";
		}
	echo "\n";
	}


//printr($gdata);
		die;
}

html_start();

if ($gmode=="") {
	$gmode="CubicCurve";
	$gmode="LineGraph";
}


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
		$DataSet->AddPoint($gdata[data][$si],"Serie$si");
}

 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie();
 @reset($gdata[data]);
$si=0;
while (list($k,$v)=each($gdata[data])) {
	$si++;
	echo $gdata[Description]["name$si"]."<BR>";
	 $DataSet->SetSerieName(iconvutf($gdata[title][Description]["name$si"]),"Serie$si");
}

//printr($gdata);
//peace - initialize value
$maxgraphval=floor($maxgraphval*1.1);


 // Initialise the graph
 $Test = new pChart(950,450);

 $Test->setFixedScale(-2,$maxgraphval);
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->setGraphArea(50,30,900,400);
 $Test->drawFilledRoundedRectangle(7,7,950,440,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,950,440,5,230,230,230);
// $Test->drawGraphAreaGradient(90,90,90,90,TARGET_BACKGROUND);  

 $Test->drawGraphArea(255,255,255,TRUE);
 //function drawRightScale($Data,$DataDescription,$ScaleMode,$R,$G,$B,$DrawTicks=TRUE,$Angle=0,$Decimals=1,$WithMargin=FALSE,$SkipLabels=1)

 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,0);
 $Test->drawGrid(4,TRUE,230,230,230,50);

 // Draw the 0 line
 $Test->setFontProperties("Fonts/tahoma.ttf",6);
 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);
 // $Test->setShadowProperties(3,3,0,0,0,30,4);  

 // Draw the cubic curve graph
 switch ($gmode) {
	case "CubicCurve":
		$Test->drawCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription());
		break;

	case "OverlayBarGraph":
		 $Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());
		break;

	case "LineGraph":
	 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());     
	 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);  
		break;

	case "BarGraph":
	 $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
		break;

	case "StackedBarGraph":
	 $Test->drawStackedBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
		break;

	case "OverlayBarGraph":
	 $Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
		break;

	case "Line_Area":
	 $Test->drawArea($DataSet->GetData(),"Serie1","Serie3",239,238,227,50);  
	 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
	 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);
	 break;

	case "Limits_graph":
		$Test->drawLimitsGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,180,180); 
		break;

	case "FilledLineGraph":
		 $Test->drawFilledLineGraph($DataSet->GetData(),$DataSet->GetDataDescription(),50,TRUE);  
		break;

	case "FilledCubicCurve":
	 $Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.1,50);  
		break;

	case "FilledRadar":
		 $Test->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);  
		 $Test->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);  
		 break;


 }

 /// $Test->clearShadow();  


 // Finish the graph

 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
 $Test->setFontProperties("Fonts/tahoma.ttf",10);
 $Test->drawTitle(50,22,iconvutf($gdata[reporttitle]),50,50,50,585);


$Test->Render("$dcrs/_tmp/graphtemp/Naked.png");  
?><BR><CENTER><BR>
<?php  echo getlang("เลือกรูปแบบกราฟอื่น ๆ ::l::Choose graph style");?> : 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=CubicCurve" class=a_btn>CubicCurve</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=OverlayBarGraph" class=a_btn>OverlayBarGraph</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=LineGraph" class=a_btn>LineGraph</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=BarGraph" class=a_btn>BarGraph</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=StackedBarGraph" class=a_btn>StackedBarGraph</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=OverlayBarGraph" class=a_btn>OverlayBarGraph</A> <BR>
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=Line_Area" class=a_btn>Line_Area</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=Limits_graph" class=a_btn>Limits_graph</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=FilledLineGraph" class=a_btn>FilledLineGraph</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=FilledCubicCurve" class=a_btn>FilledCubicCurve</A> 
<A HREF="graph.php?gid=<?php  echo $gid?>&gmode=FilledRadar" class=a_btn>FilledRadar</A> 


<BR><img src="../_tmp/graphtemp/Naked.png?<?php  echo randid();?>"><br>
<a href="graph.php?&gid=<?php  echo $gid;?>&getcsv=yes" class="a_btn smaller2" target=_blank>get .csv</a>

</CENTER>
