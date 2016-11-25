<?php 
include("../inc/config.inc.php");
		if ($_ISULIBMASTER!="yes") {
		gen404();
		die;
	}
	head();
	mn_web("webpage");

		member_log($_memid,"uug-staff");

$tbname="ulib_clientlogins_contact";


$c[2][text]="Login ID";
$c[2][field]="uug";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=substr($_memid,4);

$c[3][text]="ชื่อบุคคลติดต่อ";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[5][text]="เบอร์โทรศัพท์";
$c[5][field]="tel";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

$c[7][text]="E-mail";
$c[7][field]="email";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";


$c[4][text]="รับผิดชอบด้าน";
$c[4][field]="role";
$c[4][fieldtype]="list:บรรณารักษ์,ช่างเทคนิค/คอมพิวเตอร์,เน็ทเวิร์ค,ผู้บริหาร,อื่น ๆ";
$c[4][descr]="";
$c[4][defval]="บรรณารักษ์";


//dsp

$dsp[3][text]="รายชื่อผู้ติดต่อ";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_dsp";
$dsp[3][width]="70%";
function local_dsp($wh) {
	$s=($wh[name])." <font class=smaller2>" .($wh[email])." ".$wh[tel]."</font> (รับผิดชอบด้าน: $wh[role])
	";
	 return $s;
}




fixform_tablelister($tbname," uug='".substr($_memid,4)."' ",$dsp,"yes","yes","yes","id=$id",$c,"name");
?>
<a href="viewmember.php?id=<?php  echo $_memid?>"><center><b>กลับ</b></center></a>
<?php 
foot();
?>