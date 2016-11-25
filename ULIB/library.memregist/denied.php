<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="memregist-denied";
mn_lib();
$tbname="webpage_memregist";
//printr($selectlist);

$c[2][text]="Name::l::Name";
$c[2][field]="UserAdminName";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="".barcodeval_get("memregist-extfieldname")."";
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


$dsp[3][text]="บันทึกโดย::l::Update by";
$dsp[3][field]="UserAdminName";
$dsp[3][width]="30%";
$dsp[3][filter]="module:local_granter";

function local_granter($wh) {
	$s=getlang("บันทึกโดย::l::Update by")." ".get_library_name($wh[granter])."<BR>
	".ymd_datestr($wh[grantdt])."";

	return $s;
}

function local_detail($wh) {
	$s="$wh[prefi] ".get_member_name($wh[UserAdminID])."<BR>
	Barcode=[$wh[UserAdminID]] Password=[$wh[Password]]<BR>
	Email=[$wh[email]] Tel.=[$wh[tel]]<BR>
	".barcodeval_get("memregist-extfieldname")."=[$wh[descr]]<BR><FONT  COLOR=red>$wh[denieddescr]</FONT>";

	return $s;
}
?><TABLE width=780 align=center>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF;?>">
	<TR>
	<TD><?php 
fixform_tablelister($tbname," granted='denied' ",$dsp,"no","no","yes","mi=$mi",$c);
?></TD>
</TR>

</FORM>
</TABLE><?php 

foot();
?>