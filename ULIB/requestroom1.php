<?php 
;
include("./inc/config.inc.php");
stat_add("visithp_type","requestroom");
head();
mn_web("requestroom");
?>
<style>
.dayname {
	font-size:18px;
}
</style>
<?php 


	$ttbdtdb=tmq_dump2("rqroom_maintb","code","dtstart,dtend,name,day_preserv"," where 1 order by name");
//printr($ttbdtdb);
	pagesection("เลือกวันที่ต้องการจองห้อง::l::Pick date you need");


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

//printr($ttbdb);
$ttbdbliblff=array();
$i=0;
$s3="select * from closeservice where (mon='$m' and yea='".($y+543)."') or (mon='$m' and yea='-1')  ";
$s3=tmq($s3,false);
while ($r3=tmq_fetch_array($s3)) {
  $i++;
  $ttbdbliblff[$r3[dat]]=$r3[descr];
}

//printr($ttbdbliblff);

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

echo "<table  xclass=table_border width='$_TBWIDTH'  cellspacing='1' cellpadding='0' align=center  border='0' bgcolor=#dddddd>
<td align=center class=table_head><font size='3' face='Tahoma'> <a href='requestroom1.php?prm=$qm_back&y=$qy_back&roomid=$roomid'>&lt;เดือนก่อนหน้า</a> </td>
<td colspan=5 align=center class=table_head><font size='3' face='Tahoma' style='font-size: 20px;'>".$thaimonstr[floor($m)]." ".($y+543)." </td>
<td align=center class=table_head><font size='3' face='Tahoma'> <a href='requestroom1.php?prm=$qm_forward&y=$qy_forward&roomid=$roomid'>เดือนถัดไป&gt;</a> </td></tr>
<tr align=center  style='background-color:#F8F8F8'>";

echo "<td width=14%><b class=dayname>".$thaidaystr[0]."</b></td>
<td width=14%><b class=dayname>".$thaidaystr[1]."</b></td>
<td width=14%><b class=dayname>".$thaidaystr[2]."</b></td>
<td width=14%><b class=dayname>".$thaidaystr[3]."</b></td>
<td width=14%><b class=dayname>".$thaidaystr[4]."</b></td>
<td width=14%><b class=dayname>".$thaidaystr[5]."</b></td>
<td width=14%><b class=dayname>".$thaidaystr[6]."</b></td></tr><tr bgcolor=white>";

////// End of the top line showing name of the days of the week//////////

//////// Starting of the days//////////
$realtoday=ymd_mkdt(date('d'),date('m'),date('Y'));
for($i=1;$i<=$no_of_days;$i++){
	$m=floor($m);
	$i=floor($i);
	$y=floor($y);
	$today=date("N",mktime(0, 0, 0, $m, $i, $y));
	$todaydt=mktime(0, 0, 0, $m, $i, $y);
	$distantfromtoday=((mktime(0, 0, 0, $m, $i, $y)-$realtoday)/(60*60*24));
	$todayname=date("l",mktime(0, 0, 0, $m, $i, $y));
	$todaytxt=date("Y-m-d",mktime(0, 0, 0, $m, $i, $y));
	$bgcol="#FFFFFF";
	$brdr="";
	$bgimg="";
	$brdrs="inset";
	$brdrw=1;
	if ($today==6) {
		$bgcol="#DDEEF9";
	}
	if ($today==7) {
		$bgcol="#F3E9E9";
	}
	if ($i==$d && $m== date("m") && $y == date("Y")) {
		$caldescr[$i][text]=getlang("วันนี้::l::Today");
		$bgcol="#FFFBDD";
		$bgimg="blink.gif";
		$brdr="#FFFF00";
		$brdrw=1;
	}
	if ($caldescr[$i][type]=="bye") {
		$bgcol="#F2CAFF";
		$brdr="#800080";
	}
	//scan ttb s
	$addsql="resettonone";
	if ($todayname=='Monday' || $todayname=='Tuesday'  || $todayname=='Wednesday'  || $todayname=='Thursday'  || $todayname=='Friday' ) {
		$addsql="Monday-Friday";
	} else {
		$addsql="Saturday-Sunday";
	}
	//echo "[$todayname]";
	//echo "[$i]";	//printr($ttbdb[$addsql]);
	//if (is_array($ttbdb[$addsql])) {		echo "pass";	}
	if (is_array($ttbdb[$todayname]) || is_array($ttbdb[$addsql]) || is_array($ttbdb[All])  || is_array($ttbdb[$todaytxt]) ) {
		//echo "[$i]pass";	//printr($ttbdb[$addsql]);
		@reset($ttbdb);
		@reset($ttbdb[$todayname]);
		$usearray=Array();
		if (is_array($ttbdb[$todayname])) { $usearray[]=$ttbdb[$todayname];}
		if (is_array($ttbdb[$addsql])) { $usearray[]=$ttbdb[$addsql];}
		if (is_array($ttbdb[$todaytxt])) { $usearray[]=$ttbdb[$todaytxt];}
		if (is_array($ttbdb[All])) { $usearray[]=$ttbdb[All];}
	$allmaintbcode="";
	//printr($usearray);
	//echo "<H2>[[$todaytxt]]</H2><pre>";
	//echo "<H2>[[$distantfromtoday]]</H2><pre>";
		while (list($kttb,$vttb)=each($usearray)) {
			while (list($kttb2,$vttb2)=each($vttb)) {
				$ttbdtdb[$vttb2[maintb]][0]=floor($ttbdtdb[$vttb2[maintb]][0]);
				$ttbdtdb[$vttb2[maintb]][1]=floor($ttbdtdb[$vttb2[maintb]][1]);
				$ttbdtdb[$vttb2[maintb]][3]=floor($ttbdtdb[$vttb2[maintb]][3]);
				//printr($ttbdtdb);
				//printr($ttbdtdb[$vttb2[maintb]]);
				//echo "$vttb2[maintb] ===";
				//echo ymd_datestr($ttbdtdb[$vttb2[maintb]][1])." gt ";
				//echo ymd_datestr($todaydt)."<HR>";
				//	echo "[$i]pass";
				//echo "[if ($todaydt >=$realtoday && ".$ttbdtdb[$vttb2[maintb]][0]."<=$todaydt && [".$ttbdtdb[$vttb2[maintb]][1]."]>=$todaydt && (".$ttbdtdb[$vttb2[maintb]][3].">=".$distantfromtoday." || ".$ttbdtdb[$vttb2[maintb]][3]."==0 ))]<HR>";
				if ($todaydt >=$realtoday && $ttbdtdb[$vttb2[maintb]][0]<=$todaydt && $ttbdtdb[$vttb2[maintb]][1]>=$todaydt && ($ttbdtdb[$vttb2[maintb]][3]>=$distantfromtoday || $ttbdtdb[$vttb2[maintb]][3]==0 )) {
					$bgcol="#E3F7D2";
					$brdr="#336633";
					//print_r($vttb);
					//$caltext[$i][text].="".$ttbdtdb[$vttb2[maintb]][2]." <BR>";
					//$caltext[$i][text]="".getlang("เลือก::l::Pick");
					$allmaintbcode.=",".$vttb2[maintb];
					$caltext[$i][text].=" <FONT class=smaller>".$ttbdtdb[$vttb2[maintb]][2]."</FONT><BR>";
					//continue;
				} 
			}
		}
	}

$brdrw=0;
echo $adj."<td 
height=100 
valign=top align=left noclass=table_td style='background-color: $bgcol;
background-image: url($bgimg); 
border-color: $brdr; 
border-style: $brdrs;
border-width: $brdrw;' ";
if ($caldescr[$i][text]!="") {
	echo "onmouseover=\"dsp('".($caldescr[$i][text])."')\" onmouseout=\"dsp('&nbsp;')\"";
}

echo "><font size='2' face='Tahoma' style='width:100%; font-size: 19px;
font-weight: bolder; float: left; padding-left:3px; padding-top: 3px;'>$i </font>";
	if ($ttbdbliblff[$i]!="") {
		echo "<font class=smaller>&nbsp;&nbsp;<img src='$dcrURL"."neoimg/Seal.gif' align=absmiddle border=0 width=12 height=12> ".$ttbdbliblff[$i]."</font>";
	}

echo "<br>"; // This will display the date inside the calendar cell
//echo " <span style='width:100%; padding-left: 12;'>";
echo "<div style=\"display: inline-block; width: calc(100% - 15px); padding-left: 15px; \">";
	if ($caltext[$i][text]!="") {
		//echo " <A HREF='requestroom.detail.php?mon=$m&dat=$i&yea=$y&allmaintbcode=$allmaintbcode' >".($caltext[$i][text])."</A> ";
		////////////////////////start eventinfo
			$allmaintbcodea=explode(',',$allmaintbcode); //printr($_SESSION);
			$allmaintbcodea=arr_filter_remnull($allmaintbcodea);
			while (list($k,$v)=each($allmaintbcodea)) {
				$evs="select * from rqroom_eventinfo where ( ";
				$evs.= " maintb='$v' ";
				$evs.=") and keyid='$i-$m-$y' and text<>'' order by text";
				$evs=tmq($evs,false);
				if (tnr($evs)!=0) {
					//printr($ttbdtdb[$v][2]);
					echo "<div style=\"display: inline-block; width:100%;\"><A HREF='requestroom.predetail.php?mon=$m&dat=$i&yea=$y&allmaintbcode=$allmaintbcode'><img src='./neoimg/menuicon/groupofusers16.png' align=absmiddle border=0 width=12 height=12><B  style='font-size: 12px;'> ".$ttbdtdb[$v][2]."</B></A><BR>";
					while ($evsr=tfa($evs)) {
						echo "<FONT COLOR=#4B4B4B class=smaller2>
						&nbsp;&nbsp;$evsr[text]</FONT><BR>";
					}
					echo "</div>";
				} else {
				  $chkautoopen=tmq("select * from rqroom_maintb where code='$v'");
				  $chkautoopenr=tfa($chkautoopen);
				  //printr($chkautoopenr);
				  if (strtolower($chkautoopenr[isautoopen])=="yes") {
					echo "<div style=\"display: inline-block; width:100%;\"><A HREF='requestroom.predetail.php?mon=$m&dat=$i&yea=$y&allmaintbcode=$allmaintbcode'><img src='./neoimg/menuicon/groupofusers16.png' align=absmiddle border=0 width=12 height=12><B  style='font-size: 12px;'> ".$ttbdtdb[$v][2]."</B></A><BR>";
					//echo "<FONT COLOR=#4B4B4B class=smaller2>&nbsp;&nbsp;".stripslashes(getlang($chkautoopenr[name]))."</FONT><BR>";
					echo "</div>";
				  }
				}
			}
			

		///////////////////////end eventinfo
	}

echo "
</div>
</td>";
$adj='';
$j ++;
if($j==7){echo "</tr><tr bgcolor=white>";
$j=0;}

}
for ($endingtd=$j;$endingtd<7;$endingtd++) {
	echo "<TD>&nbsp;</TD>";
}
echo "</tr></table>";
if ($m!= date("m") || $y != date("Y")) {
	echo "<center><font face='Verdana' size='2'><a href='requestroom1.php?clicked=$clicked&roomid=$roomid'>ไปยังเดือนปัจจุบัน</a></center></font>";
}

echo "<center><b><a href='requestroom1.php'>".getlang("กลับ::l::Back")."</a></b></center>";
?><CENTER><span id="dsp"><BR></span></CENTER><SCRIPT LANGUAGE="JavaScript">
<!--
function dsp(txt) {
	document.all.dsp.innerHTML=txt;
}
//-->
</SCRIPT>

<?php 
$mememtype="";
if ($_memid!="") {
	$memem=tmq("select * from member where UserAdminID='$_memid' ");
	$memem2=tfa($memem);
	//printr($memem2);
	$mememtype=trim($memem2[type]);
	//printr($r);
	$s="select * from rqroom_maintb where 1 ";
	$s=tmq($s);
	?><table align=center width=<?php  echo $_TBWIDTH;?>>
	<tr>
		<td><?php 
	while ($r=tfa($s)) {
		if ($mememtype!="" && ($mememtype==$r[fullgrant1] ||$mememtype==$r[fullgrant2] ||$mememtype==$r[fullgrant3] ||$mememtype==$r[fullgrant4] )) {
			echo getlang("สร้างกิจกรรมใหม่สำหรับ ::l::Create new event for ") ." <b>".getlang($r[name]);
			$s3=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr");
			?></b><form method="get" action="requestroom.memcreateevent.php">
			
				<input type="hidden" name="editinfo_maintb" value="<?php  echo $r[code];?>">
			<?php  echo getlang("วันเดือนปี::l::Date")." "; 
			form_quickedit("ymd",time(),"date");
			?>
			<select name="editinfo_period"><?php 
			while ($r3=tmq_fetch_array($s3)) {
				echo "<option value='$r3[code]'>".getlang($r3[name]);
			}
			?>				
			</select>
		<input type="submit" value=" Ok ">
			</form><?php 
			echo "<br>";
		}
	}
	?></td>
	</tr>
	</table><?php 
}

foot();
?>