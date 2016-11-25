<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="createlist";
mn_lib();
$tbname="createlist_itemrule";

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
$c[4][fieldtype]="foreign:-localdb-,bkedit,fid,name,,,displaykey,leader=LEADER";
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


$dsp[5][text]="Order";
$dsp[5][field]="ordr";
$dsp[5][align]="center";
$dsp[5][width]="7%";

$dsp[3][text]="เงื่อนไข::l::Boolean";
$dsp[3][field]="decis";
$dsp[3][width]="10%";
$dsp[3][align]="center";





$dsp[6][text]="กฏ::l::Rule";
$dsp[6][field]="val";
$dsp[6][filter]="module:localruledsp";
$dsp[6][width]="70%";
function localruledsp($w) {

		$dataa=unserialize($w[val]);
		//printr($dataa);
		$sqllimit=" ";
	if ($dataa[status]!="") {
		$sqllimit=" Status='$status'<BR> ";
	}
	
	if ($dataa[limitdate_yea]>20) {
	$sqllimit="$sqllimit Date add Item='$dataa[limitdate_dat]-$dataa[limitdate_mon]-$dataa[limitdate_yea]'<BR> ";
	}
	if ($dataa[limitdatelastxday_yea]>20) {
	$sqllimit="$sqllimit Date add Item from='$dataa[limitdatelastxday_dat]-$dataa[limitdatelastxday_mon]-$dataa[limitdatelastxday_yea]' 
	  to='$dataa[limitdatelastxdayend_dat]-$dataa[limitdatelastxdayend_mon]-$dataa[limitdatelastxdayend_yea]'<BR>  ";
	}
	if ($dataa[limitdatestatuschanges_yea]>20) {
	$sqllimit="$sqllimit Last status change from='$dataa[limitdatestatuschanges_dat]-$dataa[limitdatestatuschanges_mon]-$dataa[limitdatestatuschanges_yea]' 
	  to='$dataa[limitdatestatuschangee_dat]-$dataa[limitdatestatuschangee_mon]-$dataa[limitdatestatuschangee_yea]'<BR>  ";
	}

	if ($dataa[note]!="") { $note=addslashes($dataa[note]);
	$sqllimit="$sqllimit and note contain '$note' <BR> ";
	}
	if ($dataa[adminnote]!="") { $adminnote=addslashes($dataa[adminnote]);
	$sqllimit="$sqllimit and adminnote contain '$adminnote' <BR>";
	}
	if ($dataa[siteoflib]!="") {
	$sqllimit="$sqllimit Campus='$dataa[siteoflib]' ".get_libsite_name($dataa[siteoflib])."<BR>";
	}
	if ($dataa[mdtype]!="") {
	$sqllimit="$sqllimit and Resource Type='$dataa[mdtype]' ".get_media_type($dataa[mdtype])."<BR> ";
	}
	if ($dataa[itemplace]!="") {
	$sqllimit="$sqllimit and Place='$dataa[itemplace]' ".get_itemplace_name($dataa[itemplace])."<BR> ";
	}

	
   return "$sqllimit";
}

$dsp[4][text]="ปรับ::l::Change";
$dsp[4][field]="tagid";
$dsp[4][align]="center";
$dsp[4][filter]="module:localruleedit";
$dsp[4][width]="20%";
function localruleedit($w) {
   global $main;
   return "<a href='sub_itemrule.php?main=$main&ruleid=$w[id]'>".getlang("ปรับ::l::Change")."</a>";
}


$o[addlink][] = "sub_itemrule.php?main=$main::".getlang("เพิ่มกฏไอเทม::l::Add item rule");;
$o[addlink][] = "sub_rule.php?main=$main::".getlang("กลับ::l::Back");;
?><BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td><B><?php  echo getlang("กฏไอเทมของการ Createlist:::l::Item rules for:");
	$s=tmq("select * from createlist_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> <?php 
	echo $s[name];
	?></TD>
</TR>
</TABLE><BR><?php 
//$o[addlink][] = "sub_itemrule.php?main=$main::".getlang("เงื่อนไขจากไอเทม::l::Item rule")."::_self";

fixform_tablelister($tbname," pid='$main' ",$dsp,"no","no","yes","main=$main",$c," ordr ",$o);

foot();
?>