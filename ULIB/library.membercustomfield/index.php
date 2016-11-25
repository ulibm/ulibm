<?php 
include("../inc/config.inc.php");
head();
		$_REQPERM="membercustomfield";
        $tmp=mn_lib();
pagesection($tmp);
$tbname="member_customfield";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="แสดงฟิลด์นี้หรือไม่::l::Show this field";
$c[3][field]="isshow";
$c[3][fieldtype]="list:yes,no";
$c[3][descr]="";
$c[3][defval]="yes";

$c[8][text]="สมาชิกแก้ไขได้หรือไม่::l::Allow User Edit";
$c[8][field]="usercanedit";
$c[8][fieldtype]="list:yes,no";
$c[8][descr]="";
$c[8][defval]="yes";

$c[9][text]="แสดงในหน้าข้อมูลผู้ใช้หรือไม่::l::Show this field to user";
$c[9][field]="isshowtouser";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="yes";

$c[4][text]="ค่าเริ่มต้น::l::default val";
$c[4][field]="defval";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Field ID.";
$c[5][field]="fid";
$c[5][fieldtype]="readonlytext";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="ประเภทฟิลด์::l::Field type";
$c[6][field]="ftype";
$c[6][fieldtype]="text";
$c[6][descr]="<br>ประเภท:<br>
text=Small Text<br>
longtext=Open fill<br>
list:option 1, option 2=List box<br>
multilist:option 1, option 2=Multi list<br>
date=Date time
";
$c[6][defval]="";
/*
$c[7][text]="ค่าเริ่มต้น::l::Default Value";
$c[7][field]="defval";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";*/
//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="แสดงฟิลด์นี้หรือไม่::l::Show this field";
$dsp[3][field]="isshow";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="20%";

$dsp[7][text]="แสดงในหน้าข้อมูลผู้ใช้หรือไม่::l::Show this field to user";
$dsp[7][field]="isshowtouser";
$dsp[7][filter]="switchsingle";
$dsp[7][width]="20%";

$dsp[8][text]="ผู้ใช้แก้ไขได้หรือไม่::l::User Can Edit";
$dsp[8][field]="usercanedit";
$dsp[8][filter]="switchsingle";
$dsp[8][width]="20%";

$dsp[5][text]="Field ID.";
$dsp[5][field]="fid";
$dsp[5][width]="20%";

$dsp[6][text]="Ftype::l::Ftype";
$dsp[6][field]="ftype";
$dsp[6][width]="20%";

fixform_tablelister($tbname," 1 ",$dsp,"no","yes","no","mi=$mi",$c);


foot();
?>