<?php 
;
set_time_limit(2);
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");



	 $serr=tmq("select * from cir_error where lib='$useradminid' ");
	 if (tmq_num_rows($serr)!=0) {
	 	$serr=tmq_fetch_array($serr);
		localdisplayerror($serr[msg]);
		tmq("delete from cir_error  where lib='$useradminid' ");
		die;
		//error will display in display iframe
	 }
	 $s=tmq("select * from member where UserAdminID='$memberbarcode' ");
	 if (tmq_num_rows($s)!=1) {
		die;
		//error will display in display iframe
	 }



		$s=tmq_fetch_array($s);
		$member_room=floor($s[room]);
		$member_major=floor($s[major]);

		$mbtype=$s[type];
		$mbdat=$s[dat];
		$mbmon=$s[mon];
		$mbyea=$s[yea];

		//ยืมได้กี่รายการ+max fine
		$tmpmbtype="SELECT *  FROM member_type where type ='$mbtype'"; 
		$tmpmbtype=tmq($tmpmbtype);
		if (tmq_num_rows($tmpmbtype) == 0) {
			localdisplayerror("ไม่พบ ประเภทสมาชิก $mbtype ::l:: member type not found $mbtype");
			die;
		}
		$tmpmbtype=tmq_fetch_array($tmpmbtype);
		$limithold=$tmpmbtype[limithold];
		$maxfine=$tmpmbtype[maxfine];


if ($cirmode=="checkout" && $mediabarcode!="") {
	$mediabarcodea=explode(",",$mediabarcode);
	$mediabarcodea=arr_filter_remnull($mediabarcodea);
	@reset($mediabarcodea);
	while (list($k,$v)=each($mediabarcodea)) {
		$res=cir_checkout($memberbarcode,$v,$Fdat,$Fmon,$Fyea);
		?><table width=100%>
		<tr valign=top>
		<?php 
   if (getval("_SETTING","circulation_displaycover")=="yes") {
	   ?><td width=200><TABLE>
	   <TR>
		<TD width=200 align=center><?php  echo res_brief_dsp($res[media_pid]);?></TD>
	   </TR>
	   </TABLE></td><?php 
   }				
	
		?><td><?php 
		if ($res[status]=="error") {
			echo "<b style='color:darkred'>".getlang("ไม่สามารถให้ยืมได้::l::Cannot Checkout")."</b><br>";
		}
		$tmpstatus=$res[error];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkred'>".getlang($tmpstatusv)."</font><br>";
		}
		$tmpstatus=$res[msg];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkblue'>".getlang($tmpstatusv)."</font><br>";
		}
		$tmpstatus=$res[success];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkgreen'>".getlang($tmpstatusv)."</font><br>";
		}
			?></td>
		</tr>
		</table><?php 
	}
 
	

 }
	 ?><?php 



 //tab display
 $tmp=Array();
$tmp[hold]="1";
$tmp[request]="2";
$tmp[requestlist]="3";
$tmp[fine]="4";
$tmp[other]="5";

if ($tabmode=="") {
	$tabmode="hold";
}
///////////////////////
$addstr="";
$decis=member_isoverduing($memberbarcode);
if ($decis!="PASS") {
	$addstr=" <B style='color:red'>!!!</B>";
}
$holdcount=tmq("SELECT *  FROM checkout where hold ='$memberbarcode' and allow='yes' and returned='no' ",false);
$holdcount=" (".tmq_num_rows($holdcount).")";
$tabstr=$tmp[$tabmode]."::b::".getlang("รายการยืม::l::Checkout")." $holdcount$addstr,working.viewmember.php?memberbarcode=$memberbarcode&tabmode=hold";
////////////////////////
/*
$addstr="";
$rqcount="select * from checkout where request='$memberbarcode'";
$rqcount=tmq_num_rows(tmq($rqcount));
if ($rqcount!=0) {
	$addstr=" <B style='color:red'>($rqcount)</B>";
}
$tabstr.="::".getlang("รายการจอง::l::Request")."$addstr,working.viewmember.php?memberbarcode=$memberbarcode&tabmode=request";
////////////////////////
if ($tabmode=="requestlist") {
	if ($cancelrequestlist_id!="") {
		tmq("delete from request_list where memberid='$memberbarcode' and id='$cancelrequestlist_id' ",false);
	}
}
$addstr="";
$rqcount="select * from request_list where memberid='$memberbarcode' ";
$rqcount=tmq_num_rows(tmq($rqcount));
if ($rqcount!=0) {
	$addstr=" <B style='color:red'>($rqcount)</B>";
}
$tabstr.="::".getlang("รายการขอยืม::l::Request List")."$addstr,working.viewmember.php?memberbarcode=$memberbarcode&tabmode=requestlist";
////////////////////////
$addstr="";
$rqcount=tmq("SELECT * FROM fine where memberId='$memberbarcode' and isdone='no' ");
$rqcountc=tmq_num_rows(($rqcount));
if ($rqcountc!=0) {
	$finecount=0;
	while ($rqcountr=tmq_fetch_array($rqcount)) {
		$finecount=$finecount+floor($rqcountr[fine]);
	}
	$addstr=" <B style='color:red'>($finecount)</B>";
}
$tabstr.="::".getlang("ค่าปรับ::l::Fine")."$addstr,working.viewmember.php?memberbarcode=$memberbarcode&tabmode=fine";
$_TBWIDTH="100%";

$tabstr.="::".getlang("อื่น ๆ::l::Other").",working.viewmember.php?memberbarcode=$memberbarcode&tabmode=other";
*/
if ($memberbarcode!="") {
	if ($clearmemberwaringnoteinfo=="yes") {
		tmq("update member set descr='' where UserAdminID='$memberbarcode' ");
	} else {
		$memberwaringnoteinfo=tmq("select * from member where UserAdminID='$memberbarcode' ");
		$memberwaringnoteinfo=tmq_fetch_array($memberwaringnoteinfo);
		$memberwaringnoteinfo=stripslashes(trim($memberwaringnoteinfo[descr]));
		if ($memberwaringnoteinfo!="") {
			?><TABLE width=100% style="border: red 1px solid;">
			<TR>
				<TD align=center bgcolor=#FFF2F2><B style='color:red'>Note: </B><?php  echo $memberwaringnoteinfo;?> &nbsp; <A HREF="working.viewmember.php?memberbarcode=<?php  echo $memberbarcode;?>&clearmemberwaringnoteinfo=yes" class='smaller a_btn'>Clear</A></TD>
			</TR>
			</TABLE><?php 
		}
	}
}

html_xptab($tabstr);
if ($tabmode=="hold") {
	member_showhold($memberbarcode);
}

?>
<script>
//tmp=parent.getobj('main');
//tmp.getobj('submitbtn').disabled=false;
</script>