<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 if (loginchk_lib("check")!=true) {
   ?>
   <script>
   alert("<?php echo getlang("กรุณาล็อกอินเข้าระบบ::l::Please Login");?>");
   top.location="<?php echo $dcrURL;?>library/";
   </script>
   <?php
   die;
}
	 include("inc.php");
	 if ($memberid=="none") {
		localdisplayerror("กรุณากรอกบาร์โค้ดสมาชิก::l::Please enter member's barcode","#006291");
		die;	
	 }
	 if ($memberid=="fine") {
		localdisplayerror("กรุณากรอกบาร์โค้ดสมาชิก::l::Please enter member's barcode","#800000");
		die;	
	 }
	 if ($memberid=="checkin") {
		localdisplayerror("กรุณากรอกบาร์โค้ดวัสดุสารสนเทศ::l::Please enter media's barcode","#336600");
		die;	
	 }
	 $s=tmq("select * from member where UserAdminID='$memberid' ");
	 if (tmq_num_rows($s)!=1) {
		localdisplayerror("membernotfound");
		die;	
	 }
	
	//cirstat for menu recent member
	stathist_add("cir_member",$memberid,$LIBSITE);	

	 $s=tmq_fetch_array($s);
	 $addhtmlsize=" width=220 style='font-size:14px;' ";
	 $addhtmlsizehead=" nowidth=120 style='font-size:14px;' ";
?><TABLE cellpadding=0 border=0 cellspacing=0 width=100% >
<TR valign=top>
	<TD width=50><IMG SRC='<?php  echo member_pic_url($memberid);?>?rand=<?php  echo randid();?>' <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''></TD>
	<TD>
	<TABLE cellpadding=0 border=0 cellspacing=0 width=100% > 

	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?> width=50% ><?php  echo getlang("ชื่อ::l::Name");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_member_name($s[UserAdminID]);
		if ($s[credit]!=0) {
			echo "&nbsp; (<u style='color:darkred; font-size: 14px'>Credit: ".number_format($s[credit])."</u>)";
		}
		?></TD>
	</TR>
 	<TR>
		<TD class=table_head <?php  echo $addhtmlsizehead;?>><?php  echo getlang("Barcode::l::Barcode");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[UserAdminID]?></TD>
	</TR> 
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ประเภท::l::Member type");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><nobr><a  <?php  echo $addhtmlsize;?> href="working.membertype.php?membertype=<?php  echo $s[type]?>" target="working"><?php 
		$mbtype=tmq("select * from member_type where type='$s[type]'");
		$mbtype=tmq_fetch_array($mbtype);
		echo html_membertype_icon($mbtype[type]);
		echo mb_substr(getlang($mbtype[descr]),0,40);?></a></nobr></TD>
	</TR>
	<?php  if ($s[room]!='') {?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("$_ROOMWORD");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><nobr><?php 
		$rooms=tmq("select * from room where id='$s[room]'");
		$rooms=tmq_fetch_array($rooms);
		//echo getlang($rooms[name]);
		echo mb_substr(get_room_name($s[room]),0,40);?></nobr></TD>
	</TR>
	<?php }?>
	<?php  if ($s[major]!='') {?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("$_FACULTYWORD");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><nobr><?php 
		$rooms=tmq("select * from major where id='$s[major]'");
		$rooms=tmq_fetch_array($rooms);
		echo mb_substr(getlang($rooms[name]),0,40);?></nobr></TD>
	</TR>
	<?php }?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("อายุสมาชิก::l::Expire");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  
		//printr($s);
                if ($s[dat] != "" && $s[dat] != 0) {
                    $todate=GregorianToJD2(date('n'), date('j'), date('Y')+543);
                    $mbdate=GregorianToJD2($s[mon], $s[dat], $s[yea]);
					$edt=mktime(0, 0, 0, $s[mon], $s[dat], $s[yea]-543);
                    if ($mbdate >= $todate) {
                        //echo "สมาชิกยังไม่หมดอายุ";
						echo ymd_datestr($edt,'date');
                    } else {
                        echo "<b style='color:red' class=smaller>Expired:".ymd_datestr($edt,'date')."</b>";
                    }
                } else {
                    echo getlang("ไม่มีการกำหนดวันหมดอายุสมาชิก::l::No expire date defined");
                }
		?></TD>
	</TR>
	<?php 
	$s[descr]=trim($s[descr]);
	if ($s[descr]!="") {
	?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("รายละเอียดอื่น::l::Note")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[descr]?></TD>
	</TR>
	<?php 
	}	
	?>
<!-- 	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("อีเมล์::l::Email")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[email]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("เบอร์โทรศัพท์::l::Tel.")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[tel]?></TD>
	</TR> -->
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("สาขาห้องสมุด::l::Campus");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_libsite_name($s[libsite])?></TD>
	</TR>
	</TABLE>
			<TABLE  width=100% border=0 cellpadding=1 cellspacing=0 >
		<TR>
			<TD class=table_td>
		<A  class=a_btn <?php  echo $addhtmlsize;?>  HREF="working.viewmember.php?memberbarcode=<?php  echo $s[UserAdminID]?>" target=working><?php  echo getlang("รายละเอียด::l::Informations");?></A> 
		<A class=a_btn <?php  echo $addhtmlsize;?> HREF="../library.member/editMedia.php?ID=<?php  echo $s[UserAdminID]?>&remoteedit=yes" target=working><?php  echo getlang("แก้ไขข้อมูล::l::Edit");?></A>  
		<A class=a_btn <?php  echo $addhtmlsize;?> HREF="working.fine.php?memberbarcode=<?php  echo $s[UserAdminID]?>" target=working><?php  echo getlang("ค่าปรับ::l::Fine");?></A> 
		<A class=a_btn <?php  echo $addhtmlsize;?> HREF="working.checkouthist.php?memberbarcode=<?php  echo $s[UserAdminID]?>" target=working><?php  echo getlang("ประวัติยืม.::l::CheckoutHist");?></A>
		<A class=a_btn <?php  echo $addhtmlsize;?> HREF="_printmember.php?memberbarcode=<?php  echo $s[UserAdminID]?>" target=_blank><?php  echo getlang("พิมพ์รายละเอียด.::l::Print");?></A>
		<A class=a_btn <?php  echo $addhtmlsize;?> HREF="_printmembertempcard.php?memberbarcode=<?php  echo $s[UserAdminID]?>" target=_blank><?php  echo getlang("พิมพ์บัตรชั่วคราว.::l::Print	Temp. Card");?></A>
		
		
		</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
</TABLE>
<?php 
if ($alertfine=="yes" && strtolower(getval("_SETTING","circulation_alertfine"))=="yes") {
   $rqcount=tmq("SELECT * FROM fine where memberId='$memberid' and isdone='no' ");
   $rqcountc=tmq_num_rows(($rqcount));
	$finecount=0;
   if ($rqcountc!=0) {
   	while ($rqcountr=tmq_fetch_array($rqcount)) {
   		$finecount=$finecount+floor($rqcountr[fine]);
   	}
   }
   if ($finecount>0) {
      ?><script>
      parent.cirpagealert_show("Fines <?php  echo number_format($finecount);?>฿");
      </script><?php 
   }
}
?>