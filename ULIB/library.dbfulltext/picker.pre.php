<?php 
include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();


	 ?><BR>
	 <TABLE width=780 align=center class=table_border>
<TR>
	<TD class=table_head><?php  echo getlang("เพิ่มไฟล์ให้::l::Add file to"); ?></TD>
	<TD class=table_td><?php  echo marc_gettitle($mid);?></TD>
</TR>
<TR>
	<TD class=table_td colspan=2 align=center>
	<A HREF="../library.book/"><?php  echo getlang("กลับไปฐานข้อมูล::l::Back to database");?> </A>
	::
	<A HREF="mediacontent.php?FTCODE=<?php  echo $FTCODE?>&mid=<?php  echo $mid?>"><?php  echo getlang("จัดการไฟล์ของรายการนี้::l::Back to files of this records");?></A>
	</TD>
</TR>
<TR>
	<TD class=table_td colspan=2 align=center><?php  echo getlang("กรุณาเลือกที่เก็บไฟล์::l::Please choose where file is.");?></TD>
</TR>
</TABLE><BR>
	 <?php 
$tbname="filesonserver";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Path::l::Path";
$c[3][field]="path";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Url::l::Url";
$c[4][field]="url";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][filter]="module:local_pick";
$dsp[2][field]="name";
$dsp[2][width]="50%";

$dsp[3][text]="Path::l::Path";
$dsp[3][field]="path";
$dsp[3][width]="20%";

$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="20%";

function local_pick($wh) {
	global $mid;
	global $FTCODE;
	$s="<A HREF='picker.php?mid=$mid&pathid=$wh[id]&FTCODE=$FTCODE'>".getlang($wh[name])."</A>";

	return $s;
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mid=$mid&FTCODE=$FTCODE&mid=$mid",$c);

foot();
?>