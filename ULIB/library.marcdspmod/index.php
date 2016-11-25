<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="marcdspmod";
mn_lib();

$tbname="marcdspmod_main";

if ($dup1!="") {
	?><TABLE width=700 align=center class=table_border>
<FORM METHOD=POST ACTION="index.php">
<INPUT TYPE="hidden" NAME="dup2" value="<?php  echo $dup1?>">
			<TR>
		<TD class=table_head><?php  echo getlang("กรุณาใส่ชื่อใหม่::l::Please set new name"); ?></TD>
		<TD class=table_td><INPUT TYPE="text" NAME="newname" value="<?php 
	$s=tmq("select * from marcdspmod_main where id='$dup1' ");	
	$s=tmq_fetch_array($s);
	echo $s[name];
	?>"> 
	<INPUT TYPE="submit" value="<?php  echo getlang("ทำซ้ำ::l::Duplicate"); ?>"  class=a_btn> 
	<A HREF="index.php" class=a_btn style="color: darkred;"><?php  echo getlang("ยกเลิก::l::Cancel");?></A></TD>
	</TR>
	</FORM>
	</TABLE><?php 
}

$newname=trim($newname);
if ($dup2!="" && $newname!="") {
	$newname=addslashes($newname);
	$now=time();
	tmq("insert into marcdspmod_main set name='$newname' , dt='$now' ,loginid='$useradminid'  ");
	$newid=tmq_insert_id();
	$s=tmq("select * from marcdspmod_rule where pid='$dup2' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into marcdspmod_rule set pid='$newid',
		bool='$r[bool]',
		tagid='$r[tagid]',
		decis='$r[decis]',
		val='$r[val]',
		ordr='$r[ordr]'
		");
	}
	$s=tmq("select * from marcdspmod_itemrule where pid='$dup2' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into marcdspmod_itemrule set pid='$newid',
		val='$r[val]',
		idlist='$r[idlist]',
		decis='$r[decis]'
		");
	}
}

$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เวลาที่สร้าง::l::Date";
$c[3][field]="dt";
$c[3][fieldtype]="autotime";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ผู้สร้าง::l::Officer";
$c[4][field]="loginid";
$c[4][fieldtype]="autoofficer";
$c[4][descr]="";
$c[4][defval]="";
//dsp
/*
$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][filter]="module:localicon";
$dsp[4][width]="10%";
*/
$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localname";
$dsp[2][width]="20%";
function localname($wh) {
	global $dcrURL;
	$s=$wh[name];
	$s.="<br><A HREF='index.php?dup1=$wh[id]' class=smaller>".getlang("ทำสำเนา::l::Duplicate")."</A> ";
	return $s;
}


$dsp[5][text]="จัดการกฏ::l::Manage select rule";
$dsp[5][field]="name";
$dsp[5][align]="center";
$dsp[5][filter]="module:local_manrule";
$dsp[5][width]="15%";


$dsp[6][text]="ดูตัวอย่าง::l::Matched Bib.";
$dsp[6][field]="name";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_export";
$dsp[6][width]="16%";

$dsp[7][text]="การปรับ MARC::l::Modification";
$dsp[7][field]="name";
$dsp[7][align]="center";
$dsp[7][filter]="module:local_modrule";
$dsp[7][width]="17%";

function localicon($wh) {
				 global $dcrURL;
				 return "<img src='$dcrURL/neoimg/freedbicon/$wh[icon].png' width=48>";
}
function local_manrule($wh) {
				 global $dcrURL;
				 $c=tmq("select * from marcdspmod_rule where pid='$wh[id]' ");
				 $c="(".tmq_num_rows($c).")";
				 $c2=tmq("select * from marcdspmod_itemrule where pid='$wh[id]' and idlist<>'' ");
				 if (tnr($c2)>0) {
					$c2str="<br><font class=smaller2>".getlang("มีกฏไอเทม::l::Have item rule")."</font>";
				 };
				 return "<A HREF='sub_rule.php?main=$wh[id]'>".getlang("จัดการกฏ::l::Manage")."</A> <FONT class=smaller2>$c</FONT>$c2str";
}
function local_modrule($wh) {
				 global $dcrURL;
				 $c=tmq("select * from marcdspmod_modrule where pid='$wh[id]' ");
				 $c="(".tmq_num_rows($c).")";
				 return "<A HREF='sub_modrule.php?main=$wh[id]'>".getlang("จัดการ::l::Manage")."</A> <FONT class=smaller2>$c</FONT>";
}

function local_export($wh) {
				 global $dcrURL;
				 $c=tmq("select * from marcdspmod_rule where pid='$wh[id]' ");
				 $c=tmq_num_rows($c);
				 $c2=tmq("select * from marcdspmod_itemrule where pid='$wh[id]' and idlist<>'' ");

				 if ($c!=0 || tnr($c2)>0) {
					 if ($wh[cache_dt]) {
						$addstr="<FONT class=smaller2><BR>ผลการคำนวณครั้งที่แล้ว<BR>เมื่อ ". ymd_ago($wh[cache_dt]).
							"<BR> Bib=".number_format($wh[cache_bib]).
							" Item=".number_format($wh[cache_item])."</FONT>";
					 }
					 return "<A HREF='sub_export.php?main=$wh[id]&createexport=yes'>".getlang("ดูตัวอย่าง::l::View")."</A>$addstr";
				 } else {
					return "-";
				 }
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);
?>
<TABLE  width="<?php  echo $_TBWIDTH?>" border=0 cellpadding=0 cellspacing=0 align=center>
<TR>
	<TD align=right><FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>#configformmod">
<TABLE width=450 class=table_border>
	<TR>
	<TD class="table_head smaller"><?php  echo getlang("เปิดใช้ระบบ::l::Use this module");?>
	<A name="configformmod"></A></TD>
	<TD class=table_td>
<?php 
//printr($_POST);
if ($isenablemarcdspmod!="") {
	barcodeval_set("isenablemarcdspmod","$isenablemarcdspmod");
}
$ise=barcodeval_get("isenablemarcdspmod");?>
	<label style="color:darkgreen" class=smaller2><INPUT TYPE="radio" NAME="isenablemarcdspmod" value="yes"
	<?php  if ($ise=="yes") { echo " checked ";}	?>
	><?php  echo getlang("เปิดใช้::l::Enable");?></label>
	<label style="color:dardred"  class=smaller2><INPUT TYPE="radio" NAME="isenablemarcdspmod" value="no" 	
	<?php  if ($ise=="no") { echo " checked ";}	?>
><?php  echo getlang("ไม่เปิดใช้::l::Disable");?></label>
	
	</TD>
	<TD class=table_td> <INPUT TYPE="submit" value=" Save " class=a_btn style="color:red"></TD>
</TR>

</TABLE></FORM></TD>
</TR>
</TABLE>
<?php 
foot();
?>