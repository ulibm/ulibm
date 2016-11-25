<?php 
    ;
	include ("../inc/config.inc.php");
	

if ($export=="yes") {
	header("Content-type: application/ms-download\n\n");
	header("Content-Disposition: attachment; filename=\"Holdlist.export.csv\"\n"); 
	   header("Pragma: no-cache");
   header("Expires: 0");
      echo "\xEF\xBB\xBF"; //UTF-8 BOM
      
   $tmp= sessionval_get("tmpholdlistsql");
   $s=tmq("select * from checkout where ".$tmp);
   function localskip($var,$var2) {
   echo "[$var-$var2]";
    return !($var == "" || $var == null);
   }
   $first="yes";
   while ($r=tfa($s)) {
      if ($first=="yes") {
         while (list($k,$v)=each($r)) {
            if (floor($k)==0) {
               echo $k.",";
               $first="no";
            }
         }
         echo "<BR>
";
      }
      @reset($r);
      while (list($k,$v)=each($r)) {
         if (floor($k)!=0) {
            unset($r[$k]);
         } else {
            $r[$k]=str_replace(","," ",$r[$k]);
         }

      }
      $str=implode(",",$r);
      echo $str;
      echo "<BR>
";
      //printr($r);
   }
   die;
}
head();
	$_REQPERM="holdlist";
	mn_lib();

   $itembc=trim($itembc);
   $typeid=trim($typeid);
  ?>  <form name="form1" action="holdlist.php" method="GET" >
          <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3">
  
            <tr align="center">
              <td colspan="3"><font face="MS Sans Serif" size="2"><img 
src="../image/search.gif" width="18" height="15" 
hspace="4">

<?php  echo getlang("แสดงเฉพาะรายการจองที่พร้อมยืมต่อแล้ว::l::Show only ready-to-pickup items");?>
                </font><font face="MS Sans Serif" size="2">
<input type=checkbox class=checkbox  name=keyword value="on"
<?php  if ($keyword=="on") { echo " checked "; }?>><BR>  
&nbsp; <?php  echo getlang("แสดงเฉพาะประเภททรัพยากร::l::Show only resource type"); 
frm_restype("restype",$restype);
?><br>
<?php  echo getlang("ค้นหาจากรหัสสมาชิก::l::Search by member barcode");?> <INPUT TYPE="text" NAME="typeid" 
value='<?php  echo $typeid;?>' size=15> 
Item Barcode <INPUT TYPE="text" NAME="itembc" 
value='<?php  echo $itembc;?>' size=15>
</td></tr>
<tr><td align=center>
<table width=100%>
<tr><td width=150><?php echo getlang("วันยืม::l::Checkout date");?></td><td>
<?php echo getlang("ตั้งแต่ ::l::from ");
$codate_s=form_pickdt_get("codate_s");
if ($codate_s==0) {
   $codate_s=ymd_mkdt(date("d"),date("m"),date("Y")-1);
}
form_pickdate("codate_s",$codate_s,"yes");
echo getlang(" ถึง ::l:: to ");
$codate_e=form_pickdt_get("codate_e");
if ($codate_e==0) {
   $codate_e=ymd_mkdt(date("d"),date("m"),date("Y")+1);
}
form_pickdate("codate_e",$codate_e,"yes");

?>
<?php ?>
</td></tr>
<tr><td><?php echo getlang("วันคืน::l::Due date");?></td><td>
<?php echo getlang("ตั้งแต่ ::l::from ");
$duedate_s=form_pickdt_get("duedate_s");
if ($duedate_s==0) {
   $duedate_s=ymd_mkdt(date("d"),date("m"),date("Y")-1);
}
form_pickdate("duedate_s",$duedate_s,"yes");
echo getlang(" ถึง ::l:: to ");
$duedate_e=form_pickdt_get("duedate_e");
if ($duedate_e==0) {
   $duedate_e=ymd_mkdt(date("d"),date("m"),date("Y")+1);
}
form_pickdate("duedate_e",$duedate_e,"yes");

?>
</td></tr>
</table>
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
$c[2][fieldtype]="month";
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

function local_member($wh) { //printr($wh);
   $mem=tmq("select * from member where UserAdminID='$wh[hold]' ");
   $memr=tfa($mem);
	return get_member_name($wh[hold])." <BR><font class=smaller2>".get_room_name($memr[room])."</font>";
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
		$s.= "<a target=_blank
		href='/$dcr/dublin.php?ID=$wh[pid]&adm=on&item=$wh[mediaId]' > ".stripslashes($wh[mediaName])."</a>";
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
$sql1=" 1 ";
if ($keyword=="on") { 
    $sql1= "$sql1 and (returned ='yes')"; 
  } 
if ($typeid <> "") { 
    $sql1= "$sql1 and (hold like '%$typeid%')"; 
  } 
if ($itembc <> "") { 
    $sql1= "$sql1 and (mediaId = '$itembc')"; 
  } 
if ($restype!="") {
	$sql1=" $sql1 and RESOURCE_TYPE='$restype' ";
}
$permedit="no";
if (library_gotpermission("editduedate")) {
	$permedit="yes";
}

if ($codate_s!=0) {
   $sql1="$sql1 and UNIX_TIMESTAMP(concat(syea-543,\"-\",smon,\"-\",sdat))>$codate_s";
}
if ($codate_e!=0) {
   $sql1="$sql1 and UNIX_TIMESTAMP(concat(syea-543,\"-\",smon,\"-\",sdat))<$codate_e";
}
if ($duedate_s!=0) {
   $sql1="$sql1 and UNIX_TIMESTAMP(concat(eyea-543,\"-\",emon,\"-\",edat))>$duedate_s";
}
if ($duedate_e!=0) {
   $sql1="$sql1 and UNIX_TIMESTAMP(concat(eyea-543,\"-\",emon,\"-\",edat))<$duedate_e";
}
fixform_tablelister($tbname," $sql1 ",$dsp,"no","$permedit","yes","mi=$mi&restype=$restype&keyword=$keyword&itembc=$itembc&typeid=$typeid",$c,'',$o);
sessionval_set("tmpholdlistsql",$sql1);
//echo $sql1;
?>
<center><a href="<?php echo $PHP_SELF;?>?export=yes" target=_blank class=a_btn><?php echo getlang("Export รายการที่แสดงด้านบน::l::Export list above");?></a></center>


<BR> <CENTER>** <?php  echo getlang("ชื่อหนังสือที่แสดง เป็นชื่อหนังสือที่บันทึกไว้ตั้งแต่ตอนทำการยืม ในระบบฐานข้อมูลอาจมีการเปลี่ยนข้อมูลไปแล้ว::l::Displayed titles is title of items since items checkout, may difference from database records. ");?> **<BR><BR>
<?php  echo getlang("การลบข้อมูลจากหน้าจอนี้ จะเป็นการลบออกจากระบบการยืมอย่างถาวร โดยไม่ผ่านกระบวนการคืน::l::Delete record from this module will erase check-out record without check-in process");?>

<BR>
<TABLE  width="<?php  echo $_TBWIDTH?>" border=0 cellpadding=0 cellspacing=0 align=center>
<TR>
	<TD align=right><FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>#configformmod">
<TABLE width=700 class=table_border>
	<TR>
	<TD class="table_head smaller" width=60%><?php  echo getlang("เปิดใช้ URL สาธารณะ::l::Use public URL");?>
	<A name="configformmod"></A></TD>
	<TD class=table_td>
<?php 
//printr($_POST);
if ($isenableholdlongpublichtml!="") {
	barcodeval_set("isenableholdlongpublichtml","$isenableholdlongpublichtml");
}
$ise=barcodeval_get("isenableholdlongpublichtml");?>
	<label style="color:darkgreen" class=smaller2><INPUT TYPE="radio" NAME="isenableholdlongpublichtml" value="yes"
	<?php  if ($ise=="yes") { echo " checked ";}	?>
	><?php  echo getlang("เปิดใช้::l::Enable");?></label>
	<label style="color:dardred"  class=smaller2><INPUT TYPE="radio" NAME="isenableholdlongpublichtml" value="no" 	
	<?php  if ($ise=="no") { echo " checked ";}	?>
><?php  echo getlang("ไม่เปิดใช้::l::Disable");?></label>
	
	</TD>
	<TD class=table_td> <INPUT TYPE="submit" value=" Save " class=a_btn style="color:red"></TD>
</TR>

<TR>
	<TD class="table_td smaller" colspan=3 align=center>
	<?php
	$url=$dcrURL."library/holdlist-public.php";
	 echo "<a href='$url' target=_blank class=smaller2 >$url</a>";?>
	</td></tr>
</TABLE></FORM></TD>
</TR>
</TABLE>


</CENTER><?php 
foot();
?>