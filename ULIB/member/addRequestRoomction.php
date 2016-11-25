<?php 
;
     include("../inc/config.inc.php");;
head();
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);

if(empty($useradminidx) ) { 
	 html_dialog("","กรุณาตรวจสอบรหัสล็อกอินและรหัสผ่าน::l::Please re-correct yout login and password");
	 die;
}


$chk="select * from rqroom_maintb where code='$roomid' ";
$chk=tmq($chk);
$chk=tfa($chk);

		$c2=tmq("select * from member where UserAdminID='$useradminidx' ");
		$c2=tmq_fetch_array($c2);
		$c2_orig=$c2;
//printr($c2);
		$mbtdb=tmq_dump("member_type","type","descr");

	if (trim("$chk[grantonly1]$chk[grantonly2]$chk[grantonly3]$chk[grantonly4]")!="") {
		if ($chk[grantonly1]!=$c2[type] && $chk[grantonly2]!=$c2[type] &&$chk[grantonly3]!=$c2[type] &&$chk[grantonly4]!=$c2[type] ) {
		?><CENTER><?php 
		$mbt="";
		if (trim($chk[grantonly1])!="") { $mbt.= getlang($mbtdb[$chk[grantonly1]]) ." &nbsp; "; }
		if (trim($chk[grantonly2])!="") { $mbt.= getlang($mbtdb[$chk[grantonly2]]) ." &nbsp; "; }
		if (trim($chk[grantonly3])!="") { $mbt.= getlang($mbtdb[$chk[grantonly3]]) ." &nbsp; "; }
		if (trim($chk[grantonly4])!="") { $mbt.= getlang($mbtdb[$chk[grantonly4]]) ." &nbsp; "; }
		 html_dialog("","ขออภัย สงวนเฉพาะสมาชิก $mbt::l::Sorry, Only for member type $mbt");
		?></CENTER><?php 
			foot();
	die;
		}
	}

	$user_id=ChkLoginAdminmember($useradminidx, $passwordadminx);
	if ($user_id == false)
		{
				 html_dialog("","กรุณาตรวจสอบรหัสล็อกอินและรหัสผ่าน::l::Please re-correct yout login and password");
				die;
		}
		
		$dt=ymd_mkdt($dat,$mon,$yea);
		
		$chkdup=tmq("select * from rqroom_timetbi where maintb='$roomid' and period='$periodid' and keyid='$dat-$mon-$yea' and loginid='$useradminidx' and dt=$dt ",false);
			if (tmq_num_rows($chkdup)!=0) {
				 html_dialog("","ไม่อนุญาตให้จองห้องเดียวกัน ช่วงเวลาเดียวกัน ซ้ำ โดยสมาชิกคนเดิม กรุณาติดต่อเจ้าหน้าที่::l::You reserved a room for this period and room , please contact librarian.");
				die;
		}
		$c2=tmq("select * from member_type where type='$c2[type]'  ");
		$c2=tmq_fetch_array($c2);
		if ($c2[grant_room]=='yes') {
			//ตรวจว่า สมาชิกหมดอายุหรือยัง
			//printr($c2_orig);
			//die;
                    $todate=GregorianToJD2(date('n'), date('j'), date('Y')+543);
                    $mbdate=GregorianToJD2($c2_orig[mon], $c2_orig[dat], $c2_orig[yea]);
                    if ($c2_orig[yea]!==0 || $mbdate >= $todate) {
                        //echo "สมาชิกยังไม่หมดอายุ";
						//echo ymd_datestr($edt,'date');
                    } else {
							?><SCRIPT LANGUAGE="JavaScript">
							<!--
							alert("<?php  echo getlang("ขออภัย สถานะสมาชิกของคุณหมดอายุแล้ว กรุณาติดต่อเจ้าหน้าที่::l::Sorry, your membership is expired, please contact librarian."); ?>\n");
							//-->
							</SCRIPT><?php 
								redir ($dcrURL."/requestroom1.php");
							die;
					}

    tmq("delete from rqroom_timetbi where maintb='$roomid' and period='$periodid' and keyid='$dat-$mon-$yea' and roomsub='$roomsub'");

    tmq("insert into rqroom_timetbi set maintb='$roomid' , period='$periodid' , keyid='$dat-$mon-$yea' ,loginid='$useradminidx',dt=$dt,roomsub='$roomsub' ");
    stathist_add("rqroom_member",$roomid,$useradminidx);	
    html_dialog("","ทำการเพิ่มข้อมูลเรียบร้อยแล้ว::l::Request recorded");

	stathist_add("ttb_member",$useradminidx,$roomid);	

?><SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php  echo getlang("บันทึกการจองเรียบร้อย::l::Request sent!"); ?>\n");
//-->
</SCRIPT><?php 
	redir ($dcrURL."/requestroom1.php");
} else {
	//printr($c2);
	$c2[descr]=getlang($c2[descr]);
   html_dialog("","สมาชิกประเภท $c2[descr] ไม่สามารถทำการจองได้::l::Member type $c2[descr] cannot request for room");
}
foot();?>