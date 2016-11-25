<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();


$tbname="library_site";
//printr($selectlist);
//dsp
$dsp[2][text]="สาขาห้องสมุด::l::Library campus";
$dsp[2][field]="id";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_detail";

function local_detail($wh) {
	global $dcrs;
	global $dcrURL;
	$s="<B>".getlang($wh[name])."</B> <A HREF='upload.php?site=$wh[code]' class='smaller2 a_btn'>".getlang("อัพโหลดแผนที่::l::Upload map")."</A><BR>";
	if (file_exists($dcrs."_tmp/_floorplan_$wh[code].jpg")) {
		$s.="<img src='$dcrURL/_tmp/_floorplan_$wh[code].jpg?rand=".randid()."' width=100><BR>";
	}
	$s.="<TABLE width=300>
";
	$s2=tmq("select * from media_place where main='$wh[code]' order by name");
	if (tmq_num_rows($s2)==0) {
		$s.='-';
	}
	while ($r=tmq_fetch_array($s2)) {
		$s.=	"<TR>
		<TD style='padding-left: 30;' width=200 class=table_td>".getlang($r[name])." </TD><TD width=100 class=table_td><A HREF='sub.php?id=$r[code]' class=a_btn>".getlang("จัดการ::l::Manage")."</A> ";
		$c=tmq_num_rows(tmq("select id from media_place_shelf where pid='$r[code]' "));
		$s.=" <FONT class=smaller>($c)</FONT></TD>
	</TR>";
	}
	$s.="
	</TABLE><BR>";

	return $s;
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"name");

foot();
?>