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
	$dayback2=100000;
}
   $now=time();

	$nowpure=mktime(0, 0, 0, date('m'), date('j'), date('Y'));
	$groupbyctrl=" group by  isdone,memberId";
	$havingctrl="having isdone<>'yes' and sumb>='$dayback' and sumb<='$dayback2' ";
	$wheresql=" 1 ";
	if (floor($limitroom)!=0) {
      $idlistlimitroom=tmq("select UserAdminID from member where room='$limitroom' and trim(UserAdminID)<>'' ");
      $idlistlimitroomc=tnr($idlistlimitroom);
      if ($idlistlimitroomc>0) {
         $idlistlimitroomstr="";
         while ($idlistlimitroomr=tfa($idlistlimitroom)) {
            $idlistlimitroomstr.=",'".$idlistlimitroomr[UserAdminID]."'";
         }
         $idlistlimitroomstr=trim($idlistlimitroomstr,",");
   		$wheresql.=" and memberId in ($idlistlimitroomstr) ";
		}
	}
	if (floor($limitfac)!=0) {
		$wheresql.=" and memberId in (select UserAdminID from member where major='$limitfac' ) ";
	}
	if (trim($memberbc)!="") {
		$wheresql.=" and memberId = '$memberbc' ";
	}
	$selectctrl="*,sum(fine) as sumb";
	  $sql1 ="SELECT $selectctrl FROM fine WHERE $wheresql 
	  $groupbyctrl 
	  $havingctrl "; // limit $goto,$list_page";
    $test = tmq($sql1,false);
    $rc = tmq_num_rows($test);

if ($goto!="") {
	tmq("delete from fines_notif where libid='$useradminid' ");
	$setid=randid();
	while ($r=tmq_fetch_array($test)) {
		$chk=tmq("select * from fines_notif where libid='$useradminid' and memid='$r[memberId]' ",false);
		if (tmq_num_rows($chk)==0) {
			tmq("insert into fines_notif set libid='$useradminid' ,memid='$r[memberId]' ,setid='$setid' ",false);
		}
	}
	redir("process.php?goto=$goto&setid=$setid&pid=$pid");
	die;
}
	
	
	head();
	$_REQPERM="finesnotif";
   
   
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
      barcodeval_set("finesnotifnotif-email-$editval",addslashes($val));
      tmq("delete from barcode_valmem;");
      html_dialog("Ok","Saved");
   }
   ?>
      <input type=hidden name=saveval value="yes">
      <input type=hidden name=editval value="<?php echo $editval;?>">
      <textarea style="width: 800px; height: 350px;" name=val ><?php echo stripslashes(barcodeval_get("finesnotifnotif-email-$editval"));?></textarea>
      
      <BR> <input type=submit value="Save"> 
   </form> <a href="index.php" class=a_btn><?php echo getlang("กลับ::l::Back");?></a>
   <table width=600><tr><td>
   [MEMBERNAME] = Member's name<BR>
	[MEMBERBC] = Member's Barcode<BR>
	[MEMBERMAIL] = Member's Email<BR>
	[MYNAME] = Librarian's name<BR>
	[LIBURL] = Library main URL<BR>
	[HOLDNUM] = Number (count) of fines items<BR>
	[HOLDINGLIST] = list of fines items
   </td></tr></table>
   <?php
   
   foot();
   die;
}	
	mn_lib();
  ?>  
<br />

<table align=center><form name="form1" action="index.php" method="GET" >
<tr><td> <img src="../image/search.gif" width="18" height="15" hspace="4"> <?php  echo getlang("ระบุจำนวนเงินที่ค้างชำระ::l::Specify day number to show. Between ");?> 
<INPUT TYPE="text" NAME="dayback" onkeypress="return numbersonly()"
value='<?php  echo $dayback;?>' size=5>
<?php  echo getlang("ถึง::l::to");?> 
<INPUT TYPE="text" NAME="dayback2" onkeypress="return numbersonly()"
value='<?php  echo $dayback2;?>' size=5>
<?php  echo getlang("บาท::l::฿");?> <br>
<?php echo getlang("บาร์โค้ดสมาชิก::l::Member's barcode"); ?> <input type=text name=memberbc value="<?php echo $memberbc;?>"><BR>
<?php  echo $_ROOMWORD; ?> 
<?php  
form_room("limitroom",$limitroom,"yes");
//form_quickedit("limitroom",$limitroom,"foreign:-localdb-,room,id,name,allowblank");?>
<BR><?php  echo $_FACULTYWORD; ?>  
<?php  form_quickedit("limitfac",$limitfac,"foreign:-localdb-,major,id,name,allowblank");?>


<input type="submit" name="<?php  echo getlang("ตกลง::l::Submit");?>" 
value="<?php  echo getlang("ตกลง::l::Submit");?>"><BR>

</td></tr>
</form>
</table>
<?php 


 
$tbname="fine";

$c=Array();
//dsp

$dsp[20][text]="สมาชิก::l::Member";
$dsp[20][field]="id";
$dsp[20][filter]="module:local_member";
//$dsp[20][align]="center";
$dsp[20][width]="20%";
$namelist=Array();

function local_member($wh) {
	global $namelist;
	global $dcrURL;
	if ($namelist["$wh[memberId]"]!="yes") {
		$addstr=" &nbsp; <A target=_blank class='smaller a_btn' HREF='../circulation/index.php?loadfine=$wh[memberId]&submitnow=yes'>".getlang("จัดการ::l::Manage")."</A><BR>&nbsp;&nbsp;";
		
		$addstr.="<B><A HREF=\"print.php?memberbarcode=$wh[memberId]\" target=_blank class=smaller2>".
			getlang("พิมพ์ใบทวงค่าปรับ::l::Print notification")." 
			</A></B> ";
	if (barcodeval_get("mailsetting-isenable")=="yes") {
   			$addstr.="<B><A HREF=\"index.php?memberbc=$wh[memberId]&goto=emails\" target=_blank class=smaller2>".
			getlang("ส่งอีเมล์เตือน::l::Send Notification Emails")." 
			</A></B> ";
   }         
		$addstr.="<B><A HREF=\"$dcrURL/library.download/_finesnotification.php?id=$wh[memberId]\" target=_blank class=smaller2>".
			getlang("version 5.x")." 
			</A></B>";
	}

	$namelist["$wh[memberId]"]="yes";
	return get_member_name($wh[memberId]). $addstr;
}

$dsp[2][text]="รายการค่าปรับ::l::Fine info";
$dsp[2][field]="id";
$dsp[2][filter]="module:local_fineinfo";
//$dsp[2][align]="center";
$dsp[2][width]="30%";

function local_fineinfo($wh) {
	global $dcr;
	$s="";
	$sdet=tmq("select * from fine where fine<>0 and memberId='$wh[memberId]' and isdone<>'yes' ");
	while ($sdetr=tmq_fetch_array($sdet)) {
		$s.="&bull; ".stripslashes($sdetr[topic])." <B>".number_format($sdetr[fine])."</B>฿<BR>";
	}
	return "<FONT class=smaller>$s&nbsp;&nbsp; (".ymd_datestr($wh[dt],"date")."<!-- -".ymd_ago($wh[dt])." -->)</FONT>";
}

$dsp[3][text]="จำนวน::l::Amount";
$dsp[3][field]="fine";
$dsp[3][align]="center";
$dsp[3][filter]="module:local_finenum";
$dsp[3][width]="15%";

function local_finenum($wh) {
	return "<FONT style='color:darkred'>".number_format($wh[sumb])."฿</FONT>";
}

if ($rc>0) {
	$html_xpbtnstrlib=getlang("พิมพ์ประกาศ::l::Print Annoucement").",index.php?memberbc=$memberbc&limitroom=$limitroom&limitfac=$limitfac&revers=$revers&dayback=$dayback&goto=annouce&dayback2=$dayback2&limitfac=$limitfac&limitroom=$limitroom,green,_blank::" ;
   //echo barcodeval_get("mailsetting-isenable");
	if (barcodeval_get("mailsetting-isenable")=="yes") {
		$html_xpbtnstrlib.=getlang("ส่งอีเมล์เตือน::l::Send Notification Emails").",index.php?memberbc=$memberbc&limitroom=$limitroom&limitfac=$limitfac&revers=$revers&dayback=$dayback&goto=emails&dayback2=$dayback2&limitfac=$limitfac&limitroom=$limitroom,green::" ;
	}
	$sp=tmq("select * from printtemplate_sub where pid='finesnotif' ");
	while ($spr=tfa($sp)) {
		$html_xpbtnstrlib.="::".getlang("ใบทวง::l::Notif").":".getlang($spr[name]).",index.php?memberbc=$memberbc&limitroom=$limitroom&limitfac=$limitfac&revers=$revers&dayback=$dayback&goto=notif&dayback2=$dayback2&pid=$spr[code]&limitfac=$limitfac&limitroom=$limitroom,green,_blank" ;
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


fixform_tablelister($tbname," $wheresql ",$dsp,"no","no","no","memberbc=$memberbc&limitroom=$limitroom&limitfac=$limitfac&dayback=$dayback&dayback2=$dayback2&revers=$revers&limitfac=$limitfac&limitroom=$limitroom",$c,'sumb desc',$o,$selectctrl,$havingctrl,$groupbyctrl);

?>

<table width=800 align=center>
<tr valign=top>
	<td width=50%><b><?php  echo getlang("กำหนดตัวเลือกสำหรับใบทวงแบบ version 6.x::l::Setting for version 6.x style");?><br></b>
   <a href="index.php?editval=mailsubj"><?php echo getlang("ข้อความส่วนหัว::l::Title");?></a><BR>
   <a href="index.php?editval=mailbody"><?php echo getlang("ข้อความในอีเมล์::l::Email body");?></a><BR>
   </td>
   
	<td><b><?php  echo getlang("กำหนดตัวเลือกสำหรับใบทวงแบบ version 5.x::l::Setting for version 5.x style");?><br></b><?php 
	function local_set($item,$title) {
?>&nbsp;&nbsp;<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle><A HREF="../library.download/set.php?item=<?php  echo $item?>" target=_blank><?php echo getlang($title);?></A><BR>
<?php 	
}
	local_set("finesnotification-head","ข้อความส่วนหัว::l::Head");
	local_set("finesnotification-body1","ข้อความ 1::l::Text 1 ");
	local_set("finesnotification-body2","ข้อความ 2::l::Text 2 ");
	?></td>
</tr>
</table>
<?php 
foot();
?>