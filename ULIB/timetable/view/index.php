<?php 
;
include("../../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
?>
<style>
.dayname {
	font-size:18px;
}
</style>
<?php 

	$ttbdtdb=tmq_dump2("rqroom_maintb","code","dtstart,dtend,name"," where 1 ");


	pagesection("เลือกวันที่มีการจองห้อง::l::Pick date with request info");

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

////echo "<PRE>";
	$nows = mktime(0, 0, 0, date("m"), 1,   date("Y"));
	$nowe = mktime(0, 0, 0, date("m"), 31,   date("Y"));



$ttbdb=array();
$i=0;
$s3="select distinct maintb,code,dayname from rqroom_repeatinfo where 1  ";
$s3=tmq($s3,false);
while ($r3=tmq_fetch_array($s3)) {
  $i++;
  $ttbdb[$r3[dayname]][$i][maintb]=$r3[maintb];
  $ttbdb[$r3[dayname]][$i][code]=$r3[code];
}

$ttbdbdt_key=array();
$s3="select DISTINCT dt,maintb from rqroom_timetbi where 1 ";
$s3=tmq($s3,false);
while ($r3=tmq_fetch_array($s3)) {
  $i++;
  $ttbdbdt_key[$r3[dt]][$i][maintb]=$r3[maintb];
  $ttbdbdt_key[$r3[dt]][$i][code]=$r3[code];
}

//printr($ttbdb);

$no_of_days = date('t',mktime(0,0,0,$m,1,$y)); // This is to calculate number of days in a month

$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month

for($k=1; $k<=$j; $k++){ // Adjustment of date starting
$adj .="<td>&nbsp;</td>";
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

echo "<table  class=table_border width=780  cellspacing='0' cellpadding='0' align=center  border='1'>
<td align=center class=table_head><font size='3' face='Tahoma'> <a href='index.php?prm=$qm_back&y=$qy_back&roomid=$roomid'>&lt;ก่อนหน้า</a> </td>
<td colspan=5 align=center class=table_head><font size='3' face='Tahoma' style='font-size: 20px;'>".$thaimonstr[floor($m)]." ".($y+543)." </td>
<td align=center class=table_head><font size='3' face='Tahoma'> <a href='index.php?prm=$qm_forward&y=$qy_forward&roomid=$roomid'>ถัดไป&gt;</a> </td></tr>
<tr align=center  style='background-color:#F8F8F8'>";

echo "<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[0]."</b></font></td>
<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[1]."</b></font></td>
<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[2]."</b></font></td>
<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[3]."</b></font></td>
<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[4]."</b></font></td>
<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[5]."</b></font></td>
<td width=14%><font size='3' face='Tahoma'><b class=dayname>".$thaidaystr[6]."</b></font></td></tr><tr>";

////// End of the top line showing name of the days of the week//////////

//////// Starting of the days//////////
for($i=1;$i<=$no_of_days;$i++){
	$realtoday=ymd_mkdt(date('d'),date('m'),date('Y'));
	$today=date("N",mktime(0, 0, 0, $m, $i, $y));
	$todaydt=mktime(0, 0, 0, $m, $i, $y);
	$todayname=date("l",mktime(0, 0, 0, $m, $i, $y));
	$todaytxt=date("Y-m-d",mktime(0, 0, 0, $m, $i, $y));
	$bgcol="#FFFFFF";
	$brdr="";
	$bgimg="";
	$brdrs="solid";
	$brdrw=1;
	if ($i==$d && $m== date("m") && $y == date("Y")) {
		$caldescr[$i][text]=getlang("วันนี้::l::Today");
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
		$brdr="#800080";
	}
	//scan ttb s
	if ($todayname=='Monday' || $todayname=='Tuesday'  || $todayname=='Wednesday'  || $todayname=='Thursday'  || $todayname=='Friday' ) {
		$addsql="Monday-Friday";
	} else {
		$addsql="Saturday-Sunday";
	}
	//echo "[$todayname]";
	if (is_array($ttbdb[$todayname]) || is_array($ttbdb[$addsql]) || is_array($ttbdb[All])  || is_array($ttbdb[$todaytxt]) ) {
		@reset($ttbdb);
		@reset($ttbdb[$todayname]);
		$usearray=Array();
		if (is_array($ttbdb[$todayname])) { $usearray[]=$ttbdb[$todayname];}
		if (is_array($ttbdb[$addsql])) { $usearray[]=$ttbdb[$addsql];}
		if (is_array($ttbdb[$todaytxt])) { $usearray[]=$ttbdb[$todaytxt];}
		if (is_array($ttbdb[All])) { $usearray[]=$ttbdb[All];}
	$allmaintbcode="";
	//echo "<H2>[[$todaytxt]]</H2><pre>";
	//print_r($ttbdb[$todaytxt]);
		while (list($kttb,$vttb)=each($usearray)) {
			while (list($kttb2,$vttb2)=each($vttb)) {
			//printr($ttbdtdb);
				//if ($todaydt >=$realtoday && $ttbdtdb[$vttb2[maintb]][0]<=$todaydt && $ttbdtdb[$vttb2[maintb]][1]>=$todaydt) {
					//strip block prev month
				if ( $ttbdtdb[$vttb2[maintb]][0]<=$todaydt && $ttbdtdb[$vttb2[maintb]][1]>=$todaydt) {
					$bgcol="#DFFECB";
					$brdr="#33FF00";
					//print_r($vttb);
					//$caltext[$i][text].="".$ttbdtdb[$vttb2[maintb]][2]." <BR>";
					//$caltext[$i][text]="".getlang("เลือก::l::Pick");
					$allmaintbcode.=",".$vttb2[maintb];
					$caltext[$i][text].=" <FONT class=smaller2>".$ttbdtdb[$vttb2[maintb]][2]."</FONT>";
					//continue;
				} 
			}
		}
	}

//printr($ttbdbdt_key[$todaydt]);
if (is_array($ttbdbdt_key[$todaydt])) {
	 $caltext[$i][text].="<BR><font class=smaller2>".getlang("มีการจอง::l::Requested.")."</font>";
	 $bgcol="#FFB66C";
}
		////////////////////////start eventinfo
			$allmaintbcodea=explode(',',$allmaintbcode);
			$allmaintbcodea=arr_filter_remnull($allmaintbcodea);
			while (list($k,$v)=each($allmaintbcodea)) {
				$inolead=floor($i);
				$mnolead=floor($m);
				$evs="select * from rqroom_eventinfo where ( ";
				$evs.= " maintb='$v' ";
				$evs.=") and keyid='$inolead-$mnolead-$y' order by text";
				$evs=tmq($evs,false);
				if (tnr($evs)!=0) {
					//printr($ttbdtdb[$v][2]);
					//$caltext[$i][text].= "<BR><font  style='font-size: 12px;'>".$ttbdtdb[$v][2]."</font><BR>";
					while ($evsr=tfa($evs)) {
						$caltext[$i][text].= "<BR><FONT COLOR=#4B4B4B style='font-size: 10px;'>
						$evsr[text]</FONT>";
					}
					$caltext[$i][text].= "";
				}
			}
		///////////////////////end eventinfo
		
		echo $adj."<td 
height=40 
valign=top align=center class=table_td style='background-color: $bgcol;
background-image: url($bgimg); 
border-color: $brdr; 
border-style: $brdrs;
border-width: $brdrw;' ";
if ($caldescr[$i][text]!="") {
	//echo "onmouseover=\"dsp('".($caldescr[$i][text])."')\" onmouseout=\"dsp('&nbsp;')\"";
}

echo "><font size='2' face='Tahoma' style='font-size: 18px;'>$i<br>"; // This will display the date inside the calendar cell


echo " </font>";

	if ($caltext[$i][text]!="") {
		echo " <A HREF='predetail.php?mon=".floor($m)."&dat=".floor($i)."&yea=$y&allmaintbcode=$allmaintbcode' >".($caltext[$i][text])."</A> ";
	}

echo "</td>";
$adj='';
$j ++;
if($j==7){echo "</tr><tr>";
$j=0;}

}

echo "</tr></table>";
if ($m!= date("m") || $y != date("Y")) {
	echo "<center><font face='Verdana' size='2'><a href='index.php?clicked=$clicked&roomid=$roomid'>ไปยังเดือนปัจจุบัน</a></center></font>";
}

echo "<center><b><a href='../index.php'>".getlang("กลับ::l::Back")."</a></b></center>";
?><CENTER><span id="dsp"><BR></span></CENTER><SCRIPT LANGUAGE="JavaScript">
<!--
function dsp(txt) {
	document.all.dsp.innerHTML=txt;
}
//-->
</SCRIPT>

<?php 





foot();
?>