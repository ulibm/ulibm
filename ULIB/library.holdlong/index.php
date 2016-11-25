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
	$dayback2=1000;
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
	$selectctrl=" *,str_to_date(concat(edat,',',emon,',',(eyea-543)),'%d,%m,%Y') as enddt ";

  $sql1 ="SELECT $selectctrl FROM `checkout` WHERE 1  ";
if ($restype!="") {
	$limit.="  and RESOURCE_TYPE='$restype' ";
}  
   if ($limitroom!="") {
      $idlistlimitroom=tmq("select UserAdminID from member where room='$limitroom' and trim(UserAdminID)<>'' ");
      $idlistlimitroomcc=tnr($idlistlimitroom);
      if ($idlistlimitroomcc==0) {
         html_dialog("",getlang("ไม่มีสมาชิกใน $_ROOMWORD ดังกล่าว::l::No member in specificed $_ROOMWORD"));
      } else {
         $idlistlimitroomstr="";
         while ($idlistlimitroomr=tfa($idlistlimitroom)) {
            $idlistlimitroomstr.=",'".$idlistlimitroomr[UserAdminID]."'";
         }
         $idlistlimitroomstr=trim($idlistlimitroomstr,",");
      	$sql1.="  and hold in ($idlistlimitroomstr) ";
   	}
   }
	if (trim($memberbc)!="") {
		$sql1.=" and hold = '$memberbc' ";
	}
   if ($limitmemtype!="") {
   	$sql1.="  and hold in (select UserAdminID from member where type='$limitmemtype' ) ";
   }
  $sql1.=" $havingctrl "; // limit $goto,$list_page";

//echo $sql1; die;
    $test = tmq($sql1,false);
    $rc = tmq_num_rows($test);
if ($goto!="") {
	tmq("delete from holdlong_notif where libid='$useradminid' ");
	$setid=randid();
	$test=tmq("$sql1 and returned	='no' "); // for item that just has a hold
	while ($r=tmq_fetch_array($test)) {
		$chk=tmq("select * from holdlong_notif where libid='$useradminid' and memid='$r[hold]' ",false);
		if (tmq_num_rows($chk)==0) {
			tmq("insert into holdlong_notif set libid='$useradminid' ,memid='$r[hold]' ,setid='$setid' ",false);
		}
	}
	redir("process.php?goto=$goto&setid=$setid&pid=$pid");
	die;
}
	
		$_REQPERM="holdlong";

if ($editval!="") {
   head();
   mn_lib();

   ?><center>
   <form action=index.php method=post>
   <?php
   if ($editval=="mailsubj") {
      pagesection("ข้อความส่วนหัว::l::Title");
   } elseif ($editval=="mailbody") {
      pagesection("ข้อความในอีเมล์::l::Email body");   
   } else {
      die("invalid variable;.");
   }
   if ($saveval=="yes") {
      barcodeval_set("holdlongnotif-email-$editval",addslashes($val));
      tmq("delete from barcode_valmem;");
      html_dialog("Ok","Saved");
   }
   ?>
      <input type=hidden name=saveval value="yes">
      <input type=hidden name=editval value="<?php echo $editval;?>">
      <textarea style="width: 800px; height: 350px;" name=val ><?php echo stripslashes(barcodeval_get("holdlongnotif-email-$editval"));?></textarea>
      
      <BR> <input type=submit value="Save"> 
   </form> <a href="index.php" class=a_btn><?php echo getlang("กลับ::l::Back");?></a>
   <table width=600><tr><td>
   [MEMBERNAME] = Member's name<BR>
	[MEMBERBC] = Member's Barcode<BR>
	[MEMBERMAIL] = Member's Email<BR>
	[MYNAME] = Librarian's name<BR>
	[LIBURL] = Library main URL<BR>
	[HOLDNUM] = Number of hold<BR>
	[HOLDINGLIST] = list of hold items
   </td></tr></table>
   <?php
   
   foot();
   die;
}	
	head();
	mn_lib();

  ?>  
<br />

<table align=center><form name="form1" action="index.php" method="GET" >
<tr><td> <img src="../image/search.gif" width="18" height="15" hspace="4"> <?php  echo getlang("ระบุจำนวนวันที่ต้องการให้แสดง ระหว่าง::l::Specify day number to show. Between ");?> 
<INPUT TYPE="text" NAME="dayback" onkeypress="return numbersonly()"
value='<?php  echo $dayback;?>' size=5>
<?php  echo getlang("ถึง::l::to");?> 
<INPUT TYPE="text" NAME="dayback2" onkeypress="return numbersonly()"
value='<?php  echo $dayback2;?>' size=5>
<?php  echo getlang("วัน::l::Days");?> <BR>
<?php echo getlang("บาร์โค้ดสมาชิก::l::Member's barcode"); ?> <input type=text name=memberbc value="<?php echo $memberbc;?>"><BR>
<input type="submit" name="<?php  echo getlang("ตกลง::l::Submit");?>" 
value="<?php  echo getlang("ตกลง::l::Submit");?>">
 <input type="hidden" name="sid" value="<?php  echo $sid;?>"><BR>
<label><INPUT TYPE="checkbox" NAME="revers" value="yes"
<?php  if ($revers=="yes") {
	echo " checked ";
}?>> <?php  echo getlang("ใช้วันที่ยังยืมได้::l::use available day");?> </label>

<br><?php  echo getlang("แสดงเฉพาะประเภททรัพยากร::l::Show only resource type"); 
frm_restype("restype",$restype);
?><br><?php  echo getlang($_ROOMWORD); 
echo " ";
form_room("limitroom",$limitroom,"yes");
//frm_genlist("limitroom","select * from room order by name,"id","name","-localdb-","yes");
?><br><?php  echo getlang("ประเภทสมาชิก::l::Member Type"); 
echo " ";
frm_genlist("limitmemtype","select * from member_type order by descr","type","descr","-localdb-","yes",$limitmemtype);
?><br>
</td></tr>
</form>
</table>
<?php 

 
$tbname="checkout";

$c=Array();
//dsp

$dsp[20][text]="สมาชิกผู้ยืม::l::Member";
$dsp[20][field]="id";
$dsp[20][filter]="module:local_member";
//$dsp[20][align]="center";
$dsp[20][width]="20%";
$namelist=Array();

function local_member($wh) {
	global $namelist;
	global $dcrURL;
	if ($namelist["$wh[hold]"]!="yes") {
		/*$addstr="<BR>&nbsp;&nbsp;<B><A HREF=\"$dcrURL/library.download/_notification.php?id=$wh[hold]\" target=_blank class=smaller2>".
			getlang("พิมพ์ใบทวงถาม::l::Print notification")." 
			</A></B>";*/

			$addstr.="<B><A HREF=\"print.php?memberbarcode=$wh[hold]\" target=_blank class=smaller2>".
			getlang("พิมพ์ใบทวงถาม::l::Print notification")." 
			</A></B> ";
	if (barcodeval_get("mailsetting-isenable")=="yes") {
   			$addstr.="<B><A HREF=\"index.php?memberbc=$wh[hold]&goto=emails\" target=_blank class=smaller2>".
			getlang("ส่งอีเมล์เตือน::l::Send Notification Emails")." 
			</A></B> ";
   }
		$addstr.="<B><A HREF=\"$dcrURL/library.download/_notification.php?id=$wh[hold]\" target=_blank class=smaller2>".
			getlang("version 5.x")." 
			</A></B>";
	}

	$namelist["$wh[hold]"]="yes";
	return get_member_name($wh[hold])."<br>".$addstr;
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

$dsp[3][text]="วันยืม / วันส่ง::l::Checkout-date/Return date";
$dsp[3][field]="isshow";
$dsp[3][align]="center";
$dsp[3][filter]="module:local_chdate";
$dsp[3][width]="15%";

function local_chdate($wh) {
	return "<FONT class=smaller2>".ymd_datestr(ymd_mkdt($wh[sdat],$wh[smon],$wh[syea]-543),'shortd')." /<BR>".
		ymd_datestr(ymd_mkdt($wh[edat],$wh[emon],$wh[eyea]-543),'shortd')."</FONT>";
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



if ($rc>0) {
	$html_xpbtnstrlib=getlang("พิมพ์ประกาศ::l::Print Annoucement").",index.php?memberbc=$memberbc&limitmemtype=$limitmemtype&limitroom=$limitroom&revers=$revers&dayback=$dayback&goto=annouce&dayback2=$dayback2,green,_blank::" ;
	if (barcodeval_get("mailsetting-isenable")=="yes") {
		$html_xpbtnstrlib.=getlang("ส่งอีเมล์เตือน::l::Send Notification Emails").",index.php?memberbc=$memberbc&limitmemtype=$limitmemtype&limitroom=$limitroom&revers=$revers&dayback=$dayback&goto=emails&dayback2=$dayback2,green::" ;
	}
	//$html_xpbtnstrlib.=getlang("พิมพ์ใบทวง::l::Print notifications").",index.php?revers=$revers&dayback=$dayback&goto=notif&dayback2=$dayback2,green,_blank" ;
		$sp=tmq("select * from printtemplate_sub where pid='holdlongnotif' ");
	while ($spr=tfa($sp)) {
		$html_xpbtnstrlib.="::".getlang("ใบทวง::l::Notif").":".getlang($spr[name]).",index.php?memberbc=$memberbc&limitmemtype=$limitmemtype&limitroom=$limitroom&revers=$revers&dayback=$dayback&goto=notif&dayback2=$dayback2&pid=$spr[code]&limitfac=$limitfac&limitroom=$limitroom,green,_blank" ;
	}
?><TABLE width="<?php  echo $_TBWIDTH?>" align=center>
<TR>
	<TD><?php 
	$html_xpbtnstrlib=str_replace("::::","::",$html_xpbtnstrlib);
	html_xpbtn($html_xpbtnstrlib);
?></TD>
</TR>
</TABLE><?php 
}
$limit=" 1 ";
if ($restype!="") {
	$limit.="  and RESOURCE_TYPE='$restype' ";
}
if ($limitroom!="") {
      if ($idlistlimitroomcc!=0) {
      	$limit.="  and hold in ($idlistlimitroomstr ) ";
      }
}
if ($limitmemtype!="") {
	$limit.="  and hold in (select UserAdminID from member where type='$limitmemtype' ) ";
}
if ($memberbc!="") {
	$limit.="  and hold = '$memberbc'";
}
//echo $limit; die;

//die("here");
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","memberbc=$memberbc&limitmemtype=$limitmemtype&limitroom=$limitroom&dayback=$dayback&dayback2=$dayback2&revers=$revers&restype=$restype",$c,'hold',$o,$selectctrl,$havingctrl);

?><BR> <CENTER>** <?php  echo getlang("ชื่อหนังสือที่แสดง เป็นชื่อหนังสือที่บันทึกไว้ตั้งแต่ตอนทำการยืม ในระบบฐานข้อมูลอาจมีการเปลี่ยนข้อมูลไปแล้ว::l::Displayed titles is title of items since items checkout, may difference from database records. ");?> **<BR><BR>

<table width=300 align=center>
<tr>
	<td><?php 
	function local_set($item,$title) {
?>&nbsp;&nbsp;<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle><A HREF="../library.download/set.php?item=<?php  echo $item?>" target=_blank><?php echo getlang($title);?></A><BR>
<?php 	
}
/*
	local_set("notification-head","ข้อความส่วนหัว::l::Head");
	local_set("notification-body1","ข้อความ 1::l::Text 1 ");
	local_set("notification-body2","ข้อความ 2::l::Text 2 ")*/
	?></td>
</tr>
</table>
<?php ?>
<table width=800 align=center>
<tr valign=top>
	<td width=50%><b><?php  echo getlang("กำหนดตัวเลือกสำหรับใบทวงแบบ version 6.x::l::Setting for version 6.x style");?><br></b>
   <a href="index.php?editval=mailsubj"><?php echo getlang("ข้อความส่วนหัว::l::Title");?></a><BR>
   <a href="index.php?editval=mailbody"><?php echo getlang("ข้อความในอีเมล์::l::Email body");?></a><BR>
   </td>

	<td><b><?php  echo getlang("กำหนดตัวเลือกสำหรับใบทวงแบบ version 5.x::l::Setting for version 5.x style");?><br></b><?php 

	local_set("notification-head","ข้อความส่วนหัว::l::Head");
	local_set("notification-body1","ข้อความ 1::l::Text 1 ");
	local_set("notification-body2","ข้อความ 2::l::Text 2 ");
	?></td>
</tr>
</table>
<?php 
foot();
?>