<?php 
    ;
	include ("../inc/config.inc.php");
loginchk_lib('check');
	
$dayback=floor($dayback);
$dayback2=floor($dayback2);
if ($dayback==0) {
	$dayback=0;
}
if ($dayback2==0) {
	$dayback2=90;
}
   $now=time();

$nowpure=mktime(0, 0, 0, date('m'), date('j'), date('Y'));
if ($revers!="yes") {
	$daybackuse=$nowpure-($dayback*60*60*24);
	$daybackuse_str=date('Y-m-d',$daybackuse);
	$dayback2use=$nowpure-($dayback2*60*60*24);
	$dayback2use_str=date('Y-m-d',$dayback2use);
	$havingctrl=" having enddt<=date('$daybackuse_str') and enddt>=date('$dayback2use_str') ";
} else {
	$daybackuse=$nowpure+($dayback*60*60*24);
	$daybackuse_str=date('Y-m-d',$daybackuse);
	$dayback2use=$nowpure+($dayback2*60*60*24);
	$dayback2use_str=date('Y-m-d',$dayback2use);
	$havingctrl=" having enddt>=date('$daybackuse_str') and enddt<=date('$dayback2use_str') ";
}
//echo "[$daybackuse_str-$dayback2use_str]";
	$selectctrl=" *,str_to_date(concat(dat,',',mon,',',(yea-543)),'%d,%m,%Y') as enddt ";

  $sql1 ="SELECT $selectctrl FROM `member` WHERE 1 
  $havingctrl "; // limit $goto,$list_page";
	//echo $sql1;
    $test = tmq($sql1,false);
    $rc = tmq_num_rows($test);

if ($goto!="") {
	tmq("delete from memexpire_notif where libid='$useradminid' ");
	$setid=randid();
	$test=tmq("$sql1  "); // for item that just has a hold
	while ($r=tmq_fetch_array($test)) {
		$chk=tmq("select * from memexpire_notif where libid='$useradminid' and memid='$r[UserAdminID]' ",false);
		if (tmq_num_rows($chk)==0) {
			tmq("insert into memexpire_notif set libid='$useradminid' ,memid='$r[UserAdminID]' ,setid='$setid' ",false);
		}
	}
	redir("process.php?goto=$goto&setid=$setid");
	die;
}
	
	
	head();
	$_REQPERM="memexpire";
	mn_lib();
  ?>  
<br />

<table align=center><form name="form1" action="index.php" method="GET" >
<tr><td>
<?php 
echo getlang("จำนวนวันที่หมดอายุสมาชิกไปแล้ว:::l::Days after membership expired:");
?><br>
<img src="../image/search.gif" width="18" height="15" hspace="4"> <?php  echo getlang("ระบุจำนวนวันที่ต้องการให้แสดง ระหว่าง::l::Specify day number to show. Between ");?> 
<INPUT TYPE="text" NAME="dayback" onkeypress="return numbersonly()"
value='<?php  echo $dayback;?>' size=5>
<?php  echo getlang("ถึง::l::to");?> 
<INPUT TYPE="text" NAME="dayback2" onkeypress="return numbersonly()"
value='<?php  echo $dayback2;?>' size=5>
<?php  echo getlang("วัน::l::Days");?> 
<input type="submit" name="<?php  echo getlang("ตกลง::l::Submit");?>" 
value="<?php  echo getlang("ตกลง::l::Submit");?>">
 <input type="hidden" name="sid" value="<?php  echo $sid;?>"><BR>
<label><INPUT TYPE="checkbox" NAME="revers" value="yes"
<?php  if ($revers=="yes") {
	echo " checked ";
}?>> <?php  echo getlang("ใช้อายุสมาชิกที่เหลือ::l::use available day");?> </label>


</td></tr>
</form>
</table>
<?php 


 
$tbname="member";

$c=Array();
//dsp

$dsp[20][text]="สมาชิก::l::Member";
$dsp[20][field]="id";
$dsp[20][filter]="module:local_member";
//$dsp[20][align]="center";
$dsp[20][width]="20%";
$namelist=Array();

function local_member($wh) {
	return get_member_name($wh[UserAdminID]);
}
/*
$dsp[2][text]="บาร์โค้ดวัสดุฯ-ชื่อเรื่อง::l::Item barcode-Title";
$dsp[2][field]="id";
$dsp[2][filter]="module:local_mdinfo";
//$dsp[2][align]="center";
$dsp[2][width]="30%";

function local_mdinfo($wh) {
	global $dcr;
	$s="";
	$sql2 ="SELECT *  FROM media_mid where bcode = '$wh[mediaId]'";
	$result22 = tmq($sql2);
	$row2 = tmq_fetch_array($result22);
	$mediaIdx = $row2[pid];
	$mdstr=substr($mdstr,0,40)."...";
	if ($mediaIdx!="") {
		$s.= "<a target=_blank
		href='/$dcr/dublin.php?ID=$wh[pid]&adm=on&item=$wh[mediaId]' > ".stripslashes($wh[mediaName])."</a>";
	} else {
		$s.= "<I>Bib not found, </I>";
	}
	$s.="<BR>&nbsp;&nbsp;<FONT class=smaller2>BibID:$wh[pid] ,BC=$wh[mediaId]</FONT>";
	return $s;
}
*/
$dsp[3][text]="วันหมดอายุสมาชิก::l::Expiry date";
$dsp[3][field]="id";
$dsp[3][align]="center";
$dsp[3][filter]="module:local_chdate";
$dsp[3][width]="20%";

function local_chdate($wh) {
	if ( floor($wh[dat]) == 0 || floor($wh[mon]) == 0 || floor($wh[yea]) == 0) {
		return getlang("ไม่กำหนดวันหมดอายุ::l::Expre date not set");
	}
	return 	ymd_datestr(ymd_mkdt($wh[dat],$wh[mon],$wh[yea]-543),'shortd')." <br><font class=smaller>".ymd_ago(ymd_mkdt($wh[dat],$wh[mon],$wh[yea]-543))."</font>";
}
/*
$dsp[4][text]="ยืมได้อีก (วัน)::l::Days availbles";
$dsp[4][field]="id";
$dsp[4][filter]="module:local_holdetail";
$dsp[4][width]="20%";

function local_holdetail($wh) {
	$xfine = $wh[fine];
	$shld=GregorianToJD2(date("n"),date("j"),date("Y")+543);
	$ehld=GregorianToJD2($wh[emon],$wh[edat],$wh[eyea]);
	$holdr= $ehld-$shld;
   if ($holdr>=1) {
    $holdr="<FONT SIZE=2 COLOR=garkgreen class=smaller>$holdr ".getlang("วัน::l::day")."</FONT>";
} else {
    $holdr="<FONT SIZE=2 COLOR=darkred  class=smaller><B  class=smaller>".getlang("เกินกำหนด::l::Overdue")." ".number_format(-$holdr) ." ".getlang("วัน::l::day")."</B> <BR>".getlang("ปรับ::l::Fine")." " . number_format(-$holdr*$xfine). " ฿</FONT>";
}
	return $holdr;
}

$dsp[5][text]="ผู้จอง/พร้อมรับ?::l::Requested by/Ready-to-pickup";
$dsp[5][field]="id";
$dsp[5][align]="center";
$dsp[5][filter]="module:local_request";
$dsp[5][width]="30%";

function local_request($wh) {
	if ($wh[request]=="") {
		return getlang("ไม่มีการจอง::l::No request");
	}
	$s=get_member_name($wh[request]);
	if ($wh[returned]=="no") {
		$s.=" (".getlang("ยังไม่พร้อมรับ::l::Not returned").")";
	}
	if ($wh[returned]=="yes") {
		$s.=" (".getlang("พร้อมรับ::l::Ready for pickup").")";
	}
	return "<FONT class=smaller>$s</FONT>";
}

//$o[undelete][field]="returned";
//$o[undelete][value]="no";
*/

if ($rc>0) {
	if (barcodeval_get("mailsetting-isenable")=="yes") {
		$html_xpbtnstrlib.=getlang("ส่งอีเมล์เตือน::l::Send Notification Emails").",index.php?revers=$revers&dayback=$dayback&goto=emails&dayback2=$dayback2,green" ;
	}
?><TABLE width="<?php  echo $_TBWIDTH?>" align=center>
<TR>
	<TD><?php 
	html_xpbtn($html_xpbtnstrlib);
?></TD>
</TR>
</TABLE><?php 
}
$limit=" 1 ";

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","dayback=$dayback&dayback2=$dayback2&revers=$revers",$c,'UserAdminID',$o,$selectctrl,$havingctrl);

?><BR> <CENTER>** <?php  echo getlang("ชื่อหนังสือที่แสดง เป็นชื่อหนังสือที่บันทึกไว้ตั้งแต่ตอนทำการยืม ในระบบฐานข้อมูลอาจมีการเปลี่ยนข้อมูลไปแล้ว::l::Displayed titles is title of items since items checkout, may difference from database records. ");?> **<BR><BR>


<?php 
foot();
?>