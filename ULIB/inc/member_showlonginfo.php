<?php 
function member_showlonginfo($id,$isfor_ms="") {
	global $member_showlonginfo_isshowexternallinks;
	global $_ROOMWORD;
	global $_TBWIDTH;
	global $thaimonstr;
	global $_memid;
	global $dcrURL;
	global $memberspechtml;
	global $dcr;
			$sql2="select * from member where UserAdminID='$id'";
			//echo ($sql2);
			$result2=tmq($sql2);
				$nnnn=tmq_num_rows($result2);
				$s=tmq_fetch_array($result2);

			if ($nnnn == 0)
				{
				html_dialog("","ไม่พบรหัสสมาชิกนี้! กรุณาระบุใหม่ ::l::Barcode id not found!");
				die();
				}
		?>
<br />
<TABLE cellpadding=0 border=0 cellspacing=0 width="<?php  echo $_TBWIDTH;?>" align=center class=table_border >
<TR valign=top>
	<TD width=50><IMG SRC='<?php  echo member_pic_url($id);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''><?php 
	if ($member_showlonginfo_isshowexternallinks!="no"  ) {
		if ( ($id==$_memid || loginchk_lib('chk'))) {
			echo "<br><br><a href=\"$dcrURL"."member/log.login.php?mem=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("ประวัติการล็อกอิน::l::Login History")."</a>";
			echo "<br><a href=\"$dcrURL"."member/log.ms.php?mem=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("ประวัติการเข้าห้องสมุด::l::Gate History")."</a>";
      }
		if ( ( loginchk_lib('chk'))) {

        	echo "<br><a href=\"$dcrURL"."member/log.edit.php?mem=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("ประวัติการแก้ไข::l::Update History")."</a>";
        	echo "<br><a href=\"$dcrURL"."library.member/editMedia.php?ID=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("แก้ไข::l::Edit")."</a>";
		}
	}
		?></TD>
	<TD>
	<TABLE cellpadding=0 border=0 cellspacing=0 width=100% > 
	<TR>
		<TD class=table_head <?php  echo $addhtmlsizehead;?>><?php  echo getlang("Barcode::l::Barcode");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[UserAdminID]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ชื่อ::l::Name");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_member_name($s[UserAdminID]);
		if ($member_showlonginfo_isshowexternallinks!="no"  ) {
			if ($s[publishbookinfo]=="yes" || loginchk_lib("check")==true || $_memid==$s[UserAdminID]) {
				if (barcodeval_get("webmenu_memfavbook-o-enable")=="yes") {
					echo " <A HREF='$dcrURL/member/viewmember.php?id=$s[UserAdminID]' notarget=_blank class='a_btn smaller2'>View Favourite book</A>";
				}
			}
		}
										?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ประเภทสมาชิก::l::Member Type");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		$rooms=tmq("select * from member_type where type='$s[type]'");
		$rooms=tmq_fetch_array($rooms);
		
		if (trim($rooms[descr])=="") {
         echo "[$s[type]]";
      }
      echo html_membertype_icon($rooms[type]);
		echo getlang($rooms[descr])?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("$_ROOMWORD");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		echo get_room_name($s[room]);?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ที่อยู่::l::Address");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[address]?></TD>
	</TR>
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
						echo " <font class=smaller>".ymd_ago($edt)."</font>";
                    } else {
                        echo "<b style='color:red' class=smaller>Expired:".ymd_datestr($edt,'date')."</b>";
 						echo " <font class=smaller>".ymd_ago($edt)."</font>";
                   }
                } else {
                    echo getlang("ไม่มีการกำหนดวันหมดอายุสมาชิก::l::No expire date defined");
                }
		?></TD>
	</TR>
	<?php  if ($isfor_ms=="") {?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("รายละเอียดอื่น::l::Note")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[descr]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("อีเมล์::l::Email")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[email]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("เบอร์โทรศัพท์::l::Tel.")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[tel]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("สาขาห้องสมุด::l::Campus");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_libsite_name($s[libsite])?></TD>
	</TR>
<?php 
$cust=tmq("select * from member_customfield where isshow='yes' and isshowtouser='yes' order by fid");
while ($custr=tmq_fetch_array($cust)) {
?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang($custr[name]);?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[$custr[fid]]?></TD>
	</TR>
<?php 
}
		} else {


$holdcount=tmq("SELECT *  FROM checkout where hold ='$id' and allow='yes' and returned='no' ");
$holdcount=" <B>".tmq_num_rows($holdcount)."</B>";
$tabstr=getlang("รายการยืม::l::Checkout")." $holdcount ";
////////////////////////
$addstr="";
$rqcount="select * from checkout where request='$id'";
$rqcount=tmq_num_rows(tmq($rqcount));
if ($rqcount!=0) {
	$addstr=" <B style='color:red'>($rqcount)</B>";
	$tabstr.=" :: ".getlang("รายการจอง::l::Request")." $addstr";
}
////////////////////////
$addstr="";
$rqcount="select * from request_list where memberid='$id' ";
$rqcount=tmq_num_rows(tmq($rqcount));
if ($rqcount!=0) {
	$addstr=" <B style='color:red'>($rqcount)</B>";
	$tabstr.=" ::  ".getlang("รายการขอยืม::l::Request List")."$addstr";
}
////////////////////////
$addstr="";
$rqcount=tmq("SELECT * FROM fine where memberId='$id' and isdone='no' ");
$rqcountc=tmq_num_rows(($rqcount));
if ($rqcountc!=0) {
	$finecount=0;
	while ($rqcountr=tmq_fetch_array($rqcount)) {
		$finecount=$finecount+floor($rqcountr[fine]);
	}
	$addstr=" <B style='color:red'>($finecount)</B>";
	$tabstr.=" :: ".getlang("ค่าปรับ::l::Fine")."$addstr";
}

?><TR>
		<TD class=table_head><?php  echo getlang("สรุปสถานะสมาชิก");?></TD>
		<TD class=table_td><?php  echo $tabstr?></TD>
	</TR>
<?php 
		}
?>
</table>

</td></tr>
</table>
										<?php 
}
?>