<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="mailsman";
mn_lib();

$tbname="umail_que";

$c=Array();
$setid=urldecode($setid);
if ($command=="resetstatus" && $setid!="") {
	tmq("update umail_que set status='wait' where setid='$setid'  ");
}
if ($command=="delete" && $setid!="") {
	tmq("delete from umail_que where setid='$setid'  ");
}

//dsp
/*
$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][filter]="module:localicon";
$dsp[4][width]="10%";
*/
$dsp[2][text]="ชุดการส่ง::l::Set name";
$dsp[2][field]="setid";
$dsp[2][width]="30%";

$dsp[7][text]="-";
$dsp[7][field]="setid";
$dsp[7][width]="30%";
$dsp[7][filter]="module:local_info";


$dsp[5][text]="ส่ง::l::Send";
$dsp[5][field]="id";
$dsp[5][align]="center";
$dsp[5][filter]="module:local_send";
$dsp[5][width]="15%";

$dsp[6][text]="คำสั่ง::l::Command";
$dsp[6][field]="name";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_cmd";
$dsp[6][width]="16%";


function local_info($wh) {
				 global $useradminid;
				 $c=tmq("select * from umail_que where setid='$wh[setid]' ");
				 $c=tmq_num_rows($c);
				 $s=getlang("ทั้งหมด::l::All")."=".number_format($c).",";
				 $c=tmq("select * from umail_que where setid='$wh[setid]' and status='wait' ");
				 $c=tmq_num_rows($c);
				 $s.=getlang("รอส่ง::l::Waiting")."=".number_format($c).",";
				 $c=tmq("select * from umail_que where setid='$wh[setid]' and status='success' ");
				 $c=tmq_num_rows($c);
				 $s.=getlang("สำเร็จ::l::Success")."=".number_format($c).",";
				 $c=tmq("select * from umail_que where setid='$wh[setid]' and status='error' ");
				 $c=tmq_num_rows($c);
				 $s.=getlang("ผิดพลาด::l::Error")."=".number_format($c)."";
				 return "<FONT class=smaller>$s</FONT><FONT class=smaller2><BR>".getlang("ส่งโดย::l::Send by")." ".get_library_name($useradminid)."</FONT>";;
}
function local_cmd($wh) {
				 global $dcrURL;
				 $s="";
				 $s.="<A HREF='index.php?setid=".urlencode($wh[setid])."&command=resetstatus' style='' class=smaller>".getlang("ปรับสถานะใหม่หมด::l::Reset status")."</A><BR>";
				 $s.="<A HREF='index.php?setid=".urlencode($wh[setid])."&command=delete' class=smaller style='color:darkred' onclick=\"return confirm('please confirm');\">".getlang("ลบ::l::Delete")."</A> &nbsp;";
				 $s.="<A HREF='view.php?setid=".urlencode($wh[setid])."' class=smaller style='color:darkgreen'>".getlang("ดู::l::View")."</A><BR>";
				 return $s;
}
function local_send($wh) {
				 global $dcrURL;
				 if (barcodeval_get("mailsetting-isenable")!="yes") {
					return "Email Module Disabled";
				 }
				 $c=tmq("select * from umail_que where setid='$wh[setid]' and status='wait' ");
				 $c=tmq_num_rows($c);
				 if ($c!=0) {
					 return "<A HREF='send.php?setid=".urlencode($wh[setid])."'>".getlang("ส่งอีเมล์::l::Send")."</A>";
				 } else {
					return "-";
				 }
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,'',$o,"distinct setid");
?><center><a href="emaillog.php" class=a_btn><?php  echo getlang("E-mail log");?></a></center><?php 
foot();
?>