<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
$tbname="coverbyinfo";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[10][text]="นำไปใช้หรือไม่::l::Use this cover rule";
$c[10][field]="isuse";
$c[10][fieldtype]="list:yes,no";
$c[10][descr]="";
$c[10][defval]="yes";

$c[12][text]="ต้องมี ISN ใช่หรือไม่::l::Is require ISN";
$c[12][field]="req_isn";
$c[12][fieldtype]="list:no,yes";
$c[12][descr]="";
$c[12][defval]="no";

$c[3][text]="เฉพาะภาษาใด::l::Only language";
$c[3][field]="req_lang";
$c[3][fieldtype]="text";
$c[3][descr]=" จากรหัสภาษา 3 ตัวอักษรใน Fixed width field";
$c[3][defval]="";

$c[4][text]="ข้อความที่ต้องปรากฏใน 050::l::Text required in 050";
$c[4][field]="req_050";
$c[4][fieldtype]="text";
$c[4][descr]="หากไม่สนใจให้ปล่อยว่าง::l::Left blank to do not limit";
$c[4][defval]="";

$c[5][text]="ข้อความที่ต้องปรากฏใน 082::l::Text required in 082";
$c[5][field]="req_082";
$c[5][fieldtype]="text";
$c[5][descr]="หากไม่สนใจให้ปล่อยว่าง::l::Left blank to do not limit";
$c[5][defval]="";

$c[6][text]="ข้อความที่ต้องปรากฏใน 099::l::Text required in 099";
$c[6][field]="req_099";
$c[6][fieldtype]="text";
$c[6][descr]="หากไม่สนใจให้ปล่อยว่าง::l::Left blank to do not limit";
$c[6][defval]="";

$c[8][text]="URL ภาพ::l::Cover URL";
$c[8][field]="url";
$c[8][fieldtype]="text";
$c[8][descr]="ตัวเลือกที่สามารถใส่ URL ภาพได้ ดูจากด้านล่าง::l::Check options for URL on bottom of page";
$c[8][defval]="";

$c[9][text]="Order (Priority)";
$c[9][field]="ordr";
$c[9][fieldtype]="number";
$c[9][descr]="";
$c[9][defval]="";
//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[9][text]="Order";
$dsp[9][field]="ordr";
$dsp[9][width]="30%";

$dsp[8][text]="Url::l::Url";
$dsp[8][field]="url";
$dsp[8][width]="30%";

$dsp[10][text]="ใช้::l::Use";
$dsp[10][field]="isuse";
$dsp[10][filter]="switchsingle";
$dsp[10][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"ordr");
?><BR><TABLE class=table_border width=780 align=center>
<TR>
	<TD class=table_head colspan=2><?php  echo getlang("ตัวเลือกที่สามารถหยิบไปใส่ URL::l::Options for URL fields");?></TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[bibid] </B></TD>
	<TD class=table_td><?php  echo getlang("หมายเลข Bib::l::Bib ID.");?></TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[isn] </B></TD>
	<TD class=table_td>ISBN / ISSN</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099::l::Text in 099");?><BR>
	^aVC 125 => VC 125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_l] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 (ตัวพิมพ์เล็ก)::l::Text in 099 (Lower case)");?><BR>
	^aVC 125 => vc 125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_u] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 (ตัวพิมพ์ใหญ่)::l::Text in 099 (Upper case)");?><BR>
	^avc 125 => VC 125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_s] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 ที่ไม่มีช่องว่าง::l::Text in 099 (no white space)");?><BR>
	^aVC 125 => VC125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_sl] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 (ตัวพิมพ์เล็ก+ไม่มีช่องว่าง)::l::Text in 099 (Lower case+no white space)");?><BR>
	^aVC 125 => vc125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_su] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 (ตัวพิมพ์ใหญ่+ไม่มีช่องว่าง)::l::Text in 099 (Upper case+no white space)");?><BR>
	^avc 125 => VC125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_a1] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 ส่วนแรก (นับตั้งแต่เริ่ม Subfield ไปจนถึงช่องว่างแรก)::l::Text in 099 1st part ( from ^a to white space)");?><BR>
	^aVC 125 => VC</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_a1l] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 ส่วนแรก ตัวพิมพ์เล็ก (นับตั้งแต่เริ่ม Subfield ไปจนถึงช่องว่างแรก)::l::Text in 099 1st part lowercase ( from ^a to white space)");?><BR>
	^aVC 125 => vc</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_a1u] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 ส่วนแรก ตัวพิมพ์ใหญ่ (นับตั้งแต่เริ่ม Subfield ไปจนถึงช่องว่างแรก)::l::Text in 099 1st part upper ( from ^a to white space)");?><BR>
	^avc 125 => VC</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_a2] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 ส่วน 2::l::Text in 099 2nd part");?><BR>
	^aVC 125 => 125</TD>
</TR>
<TR>
	<TD class=table_head2 width=20%><B>[tag099_a3] </B></TD>
	<TD class=table_td><?php  echo getlang("ข้อความใน 099 ส่วน 3::l::Text in 099 3rd part");?><BR>
	^aVC 125 x => x</TD>
</TR>
<TR>
	<TD class=table_head2 colspan=2><B><?php  echo getlang("แท็ก 099 สามารถเปลี่ยนเป็น 050 หรือ 082 ได้ ::l:: 099 can chage to 050 or 082");?></B></TD>
</TR>
</TABLE><?php 

foot();
?>