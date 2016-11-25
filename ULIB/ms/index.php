<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="msadmin";
mn_lib();

$tbname="ms_sub";


$c[5][text]="รหัส::l::Code";
$c[5][field]="code";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เวลาเก็บสถิติ::l::Time to add stat.";
$c[3][field]="min";
$c[3][fieldtype]="text";
$c[3][descr]="<BR>เวลาที่จะบันทึกการเข้าใช้ของสมาชิกที่เข้าที่ทางเข้า [นาที] หากไม่ต้องการกำหนด ให้ใส่ 0::l::<BR>Timeout to re-record statistic at entrance gate [minute], if dont need timeout please enter 0";
$c[3][defval]="10";

$c[6][text]="เสียงทักทาย::l::Greeting sound";
$c[6][field]="welcomesound";
$c[6][fieldtype]="list:none,สวัสดี,ยินดีต้อนรับ,Welcome,depending on time of day";
$c[6][descr]="";
$c[6][defval]="none";


$c[7][text]="เสียงแจ้งเตือน::l::Sound alert";
$c[7][field]="soundit";
$c[7][fieldtype]="yesno";
$c[7][descr]="";
$c[7][defval]="no";

$c[8][text]="ภาพพื้นหลัง::l::Background Image";
$c[8][field]="custombg";
$c[8][fieldtype]="singlefile";
$c[8][descr]="";
$c[8][defval]="";

//dsp

$dsp[4][text]="รหัส::l::Code";
$dsp[4][field]="code";
$dsp[4][width]="10%";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="ใช้งาน::l::Use this";
$dsp[3][align]="center";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_use";
$dsp[3][width]="60%";


function local_use($wh) {
	 global $dcrURL;
	  $s= "<form method=GET action='./run.php'>
		<A HREF='./run.php?use=$wh[code]&gateid=$wh[id]' class=a_btn>".getlang("ใช้งาน::l::Use this")."</A> : <!-- <A HREF='./run.php?use=$wh[code]&code=UserID01' class=a_btn>".getlang("ใช้งาน (ใช้โค้ด)::l::Use this (Use Code)")."</A> -->";
	  $s=$s."<select name=use>";
		$sl=tmq("select * from member_customfield order by fid ");
		while ($r=tfa($sl)) {
			$s=$s." <option value='$r[fid]'> ".getlang($r[name]);
		}
	  $s=$s." </select> <input type=submit value='".getlang("ใช้งาน (ใช้โค้ด)::l::Use this (Use Code)")."'>
	  </form>";
	  return $s;
}


$dsp[5][text]="ประกาศ::l::Annouce ";
$dsp[5][align]="center";
$dsp[5][field]="id";
$dsp[5][filter]="module:local_ann";
$dsp[5][width]="25%";

function local_ann($wh) {
	 global $dcrURL;
	 $annoucec=tmq("select * from ms_annouce2 where loc='$wh[code]' ",false);
	 $annoucec=tmq_num_rows($annoucec);
	 return "<A HREF='./ann.php?mi=$wh[code]' class=a_btn>".getlang("จัดการ::l::Edit")." ($annoucec)</A>";
}
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>