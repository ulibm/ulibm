<?php 
    ;
	include ("../inc/config.inc.php");
	
   $ise=barcodeval_get("isenableholdlongpublichtml");
   if ($ise!="yes") {
      head();
      html_dialog("",getlang("ระบบไม่เปิดใช้การแสดงรายการค้างส่งแบบสาธารณะ::l::Public Hold record disabled"));
      foot();
      die;
   }
   
head();
	$_REQPERM="publicholdlist";
	mn_web("publicholdlist");

   $itembc=trim($itembc);
   $typeid=trim($typeid);
  ?>  <form name="form1" action="holdlist-public.php" method="GET" >
          <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3">
  
            <tr align="center">
              <td colspan="3"><font face="MS Sans Serif" size="2">

<?php  echo getlang("ค้นหาจากรหัสสมาชิก::l::Search by member barcode");?> <INPUT TYPE="text" NAME="typeid" 
value='<?php  echo $typeid;?>' size=15> 
<input type="submit" name="Submit" 
value="ตกลง">
                <input type="hidden" name="sid" value="<?php  echo $sid;?>">
                </font><font face="MS Sans Serif" size="2"></font></td>
            </tr>
  </table></form><?php 

  
$tbname="checkout";

$c=Array();

$c[4][text]="ทรัพยากร::l::Title";
$c[4][field]="mediaName";
$c[4][fieldtype]="readonlytext";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="สมาชิก::l::Member";
$c[5][field]="hold";
$c[5][fieldtype]="readonlytext";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="บาร์โค้ดทรัพยากร::l::item barcode";
$c[6][field]="mediaId";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

$c[1][text]="วัน::l::Date";
$c[1][field]="edat";
$c[1][fieldtype]="number";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="เดือน::l::Month";
$c[2][field]="emon";
$c[2][fieldtype]="number";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ปี::l::Year";
$c[3][field]="eyea";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";
//dsp

$dsp[20][text]="สมาชิกผู้ยืม::l::Member";
$dsp[20][field]="id";
$dsp[20][filter]="module:local_member";
//$dsp[20][align]="center";
$dsp[20][width]="20%";

function local_member($wh) {
	return strip_tags(get_member_name($wh[hold]));
}

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
	$mdstr=mb_substr($mdstr,0,40)."...";
	if ($mediaIdx!="") {
		$s.= " ".stripslashes($wh[mediaName])."";
	} else {
		$s.= "<I>Bib not found, </I>";
	}
	$s.="<BR>&nbsp;&nbsp;<FONT class=smaller2>BibID:$wh[pid] ,BC=$wh[mediaId]</FONT>";
	return $s;
}

$dsp[3][text]="วันยืม / วันส่ง::l::Checkout-date/Return date";
$dsp[3][field]="isshow";
$dsp[3][align]="center";
$dsp[3][filter]="module:local_chdate";
$dsp[3][width]="15%";

function local_chdate($wh) {
	$tmp= "<FONT class=smaller2>".ymd_datestr(ymd_mkdt($wh[sdat],$wh[smon],$wh[syea]-543),'shortd')." /<BR>".
		ymd_datestr(ymd_mkdt($wh[edat],$wh[emon],$wh[eyea]-543),'shortd')."<br>(".ymd_ago(ymd_mkdt($wh[edat],$wh[emon],$wh[eyea]-543)).")</FONT>";
      return $tmp;
}

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
$chkset=tmq("select * from setreturndtfromto_sub where origid='$wh[id]' ");
$chksetstr="";
while ($chksetr=tfa($chkset)) {
   $getname=tmq("select * from setreturndtfromto where id='$chksetr[pid]' ",false);
   $getnames=tfa($getname); //printr($getnames);
   $chksetstr.="<BR>".getlang("ผลจากการกำหนดวันส่งทรัพยากรผ่านระบบ,จาก::l::result from set return date function, from ").":$getnames[note]:".$chksetr[dat]."-".$chksetr[mon]."-".$chksetr[yea];;
}
$chkset=tmq("select * from setreturndate_sub where origid='$wh[id]' ");
$chksetstr2="";
while ($chksetr=tfa($chkset)) {
   $getname=tmq("select * from setreturndate where id='$chksetr[pid]' ",false);
   $getnames=tfa($getname); //printr($getnames);
   $chksetstr2.="<BR>".getlang("ผลจากการกำหนดวันส่งทรัพยากรผ่านระบบ,จาก::l::result from set return date function, from ").":$getnames[note]:".$chksetr[dat]."-".$chksetr[mon]."-".$chksetr[yea];;
}
	return $holdr."<font class=smaller2>".$chksetstr.$chksetstr2."</font>";
}
/*
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
*/
//$o[undelete][field]="returned";
//$o[undelete][value]="no";
$sql1=" 1 ";

if ($typeid <> "") { 
    $sql1= "$sql1 and (hold like '%$typeid%')"; 
  } 

$permedit="no";
fixform_tablelister($tbname," $sql1 ",$dsp,"no","no","no","mi=$mi&restype=$restype&keyword=$keyword&itembc=$itembc&typeid=$typeid",$c,'',$o);
sessionval_set("tmpholdlistsql",$sql1);
//echo $sql1;
?>

</CENTER><?php 
foot();
?>