<?php 
include("./inc/config.inc.php");
head();

mn_web("memregist");
$tbname="webpage_memregist";
//printr($selectlist);

$c[2][text]="Name::l::Name";
$c[2][field]="UserAdminName";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[9][text]="แสดงให้ผู้ใช้เห็นหรือไม่::l::Show to user";
$c[9][field]="isshowtouser";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="yes";

//dsp



$dsp[2][text]="Name::l::Name";
$dsp[2][field]="UserAdminName";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_detail";


$dsp[3][text]="การอนุญาต::l::Grant info";
$dsp[3][field]="UserAdminName";
$dsp[3][width]="30%";
$dsp[3][filter]="module:local_granter";

function local_granter($wh) {
	$s=getlang("อนุญาตโดย::l::Grant by")." ".get_library_name($wh[granter])."<BR>
	".ymd_datestr($wh[grantdt])."";

	return $s;
}

function local_detail($wh) {
	$s="$wh[prefi] ".get_member_name($wh[UserAdminID])."<BR>
	Loginid=$wh[UserAdminID]";

	return $s;
}

	pagesection(getlang("ผู้สมัครที่อนุญาตแล้ว::l::Granted Member"));
$limit=" and 1";
?><TABLE	width="<?php echo $_TBWIDTH?>" align=center>
<FORM METHOD=POST ACTION="memregist.granted.php">
	<TR>
	<TD align=center> ค้นหาจากชื่อ <INPUT TYPE="text" NAME="search" value="<?php  echo $search?>"> <INPUT TYPE="submit" value="ค้นหา"> <?php 
	if ($search!="") {
		echo " <A HREF='memregist.granted.php' class=a_btn>แสดงทั้งหมด</A>";
	}
	?></TD>
</TR>
</FORM>
</TABLE><?php 
if ($search!="") {
	$limit=" and UserAdminName like '%$search%' ";
}
fixform_tablelister($tbname," granted='yes' $limit ",$dsp,"no","no","no","mi=$mi",$c);


foot();
?>