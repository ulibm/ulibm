<?php 
include("inc/config.inc.php");
html_start();

if(isset($prm) and $prm > 0) {
	$m=$prm;
} else {
	$m= date("m");
}

$d= date("d");     // Finds today's date
if(isset($y) and $y > 0) {
	//get y from query
} else {
	$y= date("Y");     // Finds today's year
}
$caldescr[]=array();

//db gather s
$weeklyclose=tmq_dump("weeklyclose","dat","dat");

	$s=tmq("select * from closeservice  where  mon=$m and (yea=$y or yea=$y+543 or yea=-1)");
	$byedb=array();
	while ($r=tmq_fetch_array($s)) {
		//print_r($r);
		$caldescr[$r[dat]][text]=getlang($r[descr]);
		$caldescr[$r[dat]][type]="bye";
	}
//db gather e
$no_of_days = date('t',mktime(0,0,0,$m,1,$y)); // This is to calculate number of days in a month

$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month

for($k=1; $k<=$j; $k++){ // Adjustment of date starting
$adj .="<td style='border-width: 1;border-top-width: 0;border-left-width: 0; border-right-width: 0;'><B style='font-size: 2px;'>&nbsp;</B></td>";
}

/// Starting of top line showing name of the days of the week
$qm_back=floor($m)-1;
$qm_forward=floor($m)+1;
$qy_back=$y;
$qy_forward=$y;
if ($qm_back==0) {
	$qm_back=12;
	$qy_back=$qy_back-1;
}
if ($qm_forward==12) {
	$qm_forward=1;
	$qy_forward=$qy_forward+1;
}

echo "<table  width=100%  cellspacing='0' cellpadding='0' align=center  border='1'>

<td align=center class=table_head><font size='2' face='Tahoma'> <a href='webpage.calendar.php?prm=$qm_back&y=$qy_back'><</a> </td>

<td colspan=5 align=center class=table_head><font size='2' face='Tahoma'>".$thaimonstrbrief[floor(date('m',mktime(0,0,0,$m,1,$y)))]." ".($y+543)." </td>

<td align=center class=table_head><font size='2' face='Tahoma'> <a href='webpage.calendar.php?prm=$qm_forward&y=$qy_forward'>></a> </td></tr><tr align=center>";

echo "<td><font size='2' face='Tahoma'><b>".$thaidayshortstr[0]."</b></font></td><td><font size='2' face='Tahoma'><b>".$thaidayshortstr[1]."</b></font></td><td><font size='2' face='Tahoma'><b>".$thaidayshortstr[2]."</b></font></td><td><font size='2' face='Tahoma'><b>".$thaidayshortstr[3]."</b></font></td><td><font size='2' face='Tahoma'><b>".$thaidayshortstr[4]."</b></font></td><td><font size='2' face='Tahoma'><b>".$thaidayshortstr[5]."</b></font></td><td><font size='2' face='Tahoma'><b>".$thaidayshortstr[6]."</b></font></td></tr><tr>";

////// End of the top line showing name of the days of the week//////////

//////// Starting of the days//////////
for($i=1;$i<=$no_of_days;$i++){
	$today=date("N",mktime(0, 0, 0, $m, $i, $y));
	$bgcol="#FFFFFF";
	$brdr="";
	$bgimg="";
	$brdrs="solid";
	$brdrw=1;
	if ($i==$d && $m== date("m") && $y == date("Y")) {
		$caldescr[$i][text]="วันนี้";
		$bgcol="#33FF00";
		$bgimg="blink.gif";
		$brdr="#000000";
		$brdrw=1;
	}
	if ($today==6) {
		$bgcol="#BFDFFF";
	}
	if ($today==7) {
		$bgcol="#FFB3B3";
	}
	if ($caldescr[$i][type]=="bye") {
		$bgcol="#F2CAFF";
		$brdr="#FF0000";
		$brdrw=2;
	}
	if ($weeklyclose[$today]!="" || $weeklyclose[$today-7]!="") {
		$brdr="#FF0000";
		$brdrw="2";
	}
echo $adj."<td valign=top align=center class=table_td style='background-color: $bgcol;
background-image: url($bgimg); 
border-color: $brdr; 
border-style: $brdrs;
border-width: 0;
border-bottom-width: $brdrw;  ' ";
	if ($caldescr[$i][text]!="") {
		echo "onmouseover=\"dsp('".($caldescr[$i][text])."')\" onmouseout=\"dsp('&nbsp;')\"";
	}
echo "><font size='2' style='font-size:12px;' face='Tahoma'>$i<br>"; // This will display the date inside the calendar cell
echo " </font></td>";
$adj='';
$j ++;
if($j==7){echo "</tr><tr>";
$j=0;}

}

echo "</tr></table>";
if ($m!= date("m") || $y != date("Y")) {
	echo "<center><font face='Verdana' size='2'><a href=webpage.calendar.php?clicked=$clicked>ไปยังเดือนปัจจุบัน</a></center></font>";
}

?><CENTER><span id="dsp"></span><BR><FONT style="font-size: 12px"><?php 
echo getlang("วันที่ขีดเส้นใต้สีแดงคือวันหยุดห้องสมุด::l::days with red-underline marked on library's close");
?></FONT></CENTER><SCRIPT LANGUAGE="JavaScript">
<!--
function dsp(txt) {
	document.all.dsp.innerHTML=txt;
}
//-->
</SCRIPT>