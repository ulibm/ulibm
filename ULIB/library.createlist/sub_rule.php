<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="createlist";
mn_lib();
$tbname="createlist_rule";

$c[2][text]="Nested::l::Nested";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$main;


$c[3][text]="เงื่อนไข::l::Boolean";
$c[3][field]="bool";
$c[3][fieldtype]="list:AND,OR,NOT";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="แท็ก::l::TAG";
$c[4][field]="tagid";
$c[4][fieldtype]="foreign:-localdb-,bkedit,fid,name,,,displaykeyfirst,leader=LEADER";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="การเปรียบเทียบ::l::Comparision";
$c[5][field]="decis";
$c[5][fieldtype]="list:Exact match,Like (match any case),Match (anywhere),Begin with,End with";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="ค่าที่ใช้เปรียบเทียบ::l::Comparision to value";
$c[6][field]="val";
$c[6][fieldtype]="text";
$c[6][descr]="<BR> เปรียบเทียบกับทั้งฟิลด์ รวมถึง indicator (ใช้ _ แทน blank หรือ อักษรใด ๆ 1 อักษร) เช่น _7^aสังคมศาสตร์ <BR>
และใช้ % แทนกลุ่มข้อความใด ๆ (wildcard)";
$c[6][defval]="";

$c[7][text]="เรียงลำดับกฏ::l::Rule order #";
$c[7][field]="ordr";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]="";

//dsp


$dsp[3][text]="เงื่อนไข::l::Boolean";
$dsp[3][field]="bool";
$dsp[3][width]="20%";

$dsp[4][text]="แท็ก::l::TAG";
$dsp[4][field]="tagid";
$dsp[4][filter]="foreign:-localdb-,bkedit,fid,name,,,leader=LEADER";
$dsp[4][width]="20%";

$dsp[5][text]="การเปรียบเทียบ::l::Comparision";
$dsp[5][field]="decis";
$dsp[5][width]="20%";

$dsp[6][text]="ค่าที่ใช้เปรียบเทียบ::l::Comparision to value";
$dsp[6][field]="val";
$dsp[6][width]="20%";

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;
?><BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td><B><?php  echo getlang("กฏของการ Createlist:::l::Rule for:");
	$s=tmq("select * from createlist_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> <?php 
	echo $s[name];
	?></TD>
</TR>
</TABLE><BR><?php 
$o[addlink][] = "sub_itemrulemain.php?main=$main::".getlang("เงื่อนไขจากไอเทม::l::Item rule")."::_self";

fixform_tablelister($tbname," pid='$main' ",$dsp,"yes","yes","yes","main=$main",$c," ordr ",$o);

foot();
?>