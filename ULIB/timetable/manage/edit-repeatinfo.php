<?php 
    ;
include("../../inc/config.inc.php");
include("./_REQPERM.php");
head();
mn_lib();

pagesection("แก้ไขวันเปิดทำการ::l::Edit Repeat info");


?>
<CENTER><B><?php  echo getlang("เครื่องมือ::l::Tools");?></B>: 
<A  class=a_btn HREF="edit-repeatinfo.php?syeaid=<?php  echo $syeaid?>&tm=form"><?php  echo getlang("สำเนามาจากห้องอื่น::l::Copy from other");?></A>,
<A  class=a_btn HREF="edit-repeatinfo.php?syeaid=<?php  echo $syeaid?>&tmbydat=form"><?php  echo getlang("สร้างตามช่วงวัน::l::Generate by date");?></A>

</CENTER>
<?php 
if ($tm=="form") {
?>
<TABLE width=500 class=table_border align=center>
<FORM METHOD=POST ACTION="edit-repeatinfo.php">
	
<TR>
	<TD class=table_head><?php  echo getlang("สำเนามาจากห้องอื่น::l::Copy from other");?></TD>
</TR>
<TR>
	<TD class=table_td><?php 
		frm_genlist("copyfrommaintb","select * from  rqroom_maintb where code<>'$syeaid' order by name","code","name","-localdb-","no")
	
?> <INPUT TYPE="checkbox"  style="border-width: 0px" NAME="isdeleteold" value="yes" style="border-width:0"><?php  echo getlang("ลบข้อมูลเก่า::l::Delete existing data");?> </TD>
</TR>
<INPUT TYPE="hidden" NAME="tm" value="submitit">
<INPUT TYPE="hidden" NAME="syeaid" value="<?php  echo $syeaid?>">
<TR>
	<TD class=table_td><INPUT TYPE="submit" value="<?php  echo getlang("ตกลง::l::Submit");?>"> <A class=a_btn  HREF="edit-repeatinfo.php?syeaid=<?php  echo $syeaid?>"><?php  echo getlang("ยกเลิก::l::Cancel");?></A></TD>
</TR>
</FORM>
</TABLE>
<?php 
}
if ($tm=="submitit") {
	if ($isdeleteold=="yes") {
		tmq("delete from rqroom_repeatinfo where maintb='$syeaid' ");
	}
	$s=tmq("select * from rqroom_repeatinfo where maintb='$copyfrommaintb' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into rqroom_repeatinfo set maintb='$syeaid' ,
		ordr='$r[ordr]',
		code='$r[code]',
		dayname='$r[dayname]',
		name='$r[name]',
		descr='$r[descr]'
		");
	}
?>
<TABLE width=500 class=table_border align=center>
<TR>
	<TD class=table_head><?php  echo getlang("การสำเนาเรียบร้อย::l::Success");?></TD>
</TR>
</TABLE>
<?php }
if ($tmbydat=="form") {
?>
<TABLE width=600 class=table_border align=center>
<FORM METHOD=POST ACTION="edit-repeatinfo.php">
	
<TR>
	<TD class=table_head colspan=2><?php  echo getlang("กรุณาระบุช่วงวัน::l::Specific date range");?></TD>
</TR>
<TR>
	<TD class=table_td colspan=1><?php  echo getlang("เริ่มจาก::l::Start");?></TD>
	<TD class=table_td><?php 
form_pickdate("formstart",time())	;
?> </TD>
</TR>
<TR>
	<TD class=table_td colspan=1><?php  echo getlang("จนถึง::l::End");?></TD>
	<TD class=table_td><?php 
form_pickdate("formend",time()+(60*60*24*30))	;
?> </TD>
</TR>
<TR>
	<TD class=table_td colspan=1><?php  echo getlang("วันที่ต้องการสร้าง::l::Only in day");?></TD>
	<TD class=table_td>
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Monday" checked style="border-width:0"> <?php  echo getlang("จันทร์::l::Monday");?> 
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Tuesday" checked style="border-width:0"> <?php  echo getlang("อังคาร::l::Tuesday");?> 
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Wednesday" checked style="border-width:0"> <?php  echo getlang("พุธ::l::Wednesday");?>
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Thursday" checked style="border-width:0"> <?php  echo getlang("พฤหัสบดี::l::Thursday");?>
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Friday" checked style="border-width:0"> <?php  echo getlang("ศุกร์::l::Friday");?><BR>
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Saturday" checked style="border-width:0"> <?php  echo getlang("เสาร์::l::Saturday");?>
<INPUT TYPE="checkbox" NAME="dayallow[]" value="Sunday" checked style="border-width:0"> <?php  echo getlang("อาทิตย์::l::Sunday");?>
</TD>
</TR>
<INPUT TYPE="hidden" NAME="tmbydat" value="submitit">
<INPUT TYPE="hidden" NAME="syeaid" value="<?php  echo $syeaid?>">
<TR>
	<TD class=table_td > </TD>
	<TD class=table_td>
	 <INPUT TYPE="checkbox" NAME="isdeleteold" value="yes" style="border-width:0"> <?php  echo getlang("ลบข้อมูลเก่า::l::Delete existing data");?><BR>
	<INPUT TYPE="submit" value="<?php  echo getlang("ตกลง::l::Submit");?>"> <A  class=a_btn HREF="edit-repeatinfo.php?syeaid=<?php  echo $syeaid?>"><?php  echo getlang("ยกเลิก::l::Cancel");?></A></TD>
</TR>
</FORM>
</TABLE>
<?php }
if ($tmbydat=="submitit") {
	if ($isdeleteold=="yes") {
		tmq("delete from rqroom_repeatinfo where maintb='$syeaid' ");
	}
	$s=form_pickdt_get("formstart");
	$e=form_pickdt_get("formend");
	$step=(60*60*24);
	$ordr=0;
	while ($s<=$e) {
		$dayname=date("l",$s);
		if (in_array($dayname,$dayallow)) {
			$res=date("Y-m-d",$s);
			$ordr++;
			$restxt=ymd_datestr($s,"date");
			tmq("insert into rqroom_repeatinfo set maintb='$syeaid' ,
			ordr='$ordr',
			code='$res',
			dayname='$res',
			name='$restxt'
			");	
		}
		$s+=$step;
	}
?>
<TABLE width=500 class=table_border align=center>
<TR>
	<TD class=table_head><?php  echo getlang("การสำเนาเรียบร้อย::l::Success");?></TD>
</TR>
</TABLE>
<?php }




$tbname="rqroom_repeatinfo";

$c[1][text]="ชื่อการวนซ้ำ::l::Repeating";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[3][text]="Code";
$c[3][field]="code";
$c[3][fieldtype]="autorun";
$c[3][descr]="";
$c[2][text]="ข้อความเพิ่มเติม::l::Note";
$c[2][field]="descr";
$c[2][fieldtype]="longtext";
$c[2][descr]="";
$c[4][field]="maintb";
$c[4][fieldtype]="addcontrol";
$c[4][descr]="";
$c[4][defval]="$syeaid";
$c[6][text]="วันให้บริการห้อง::l::Service day name";
$c[6][field]="dayname";
$c[6][descr]="<BR>".getlang("ภาษาอังกฤษ::l::In English").":None, All, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, Monday-Friday, Saturday-Sunday, yyyy-m-d (2009-08-14)";
$c[6][fieldtype]="text";
$c[7][text]="เรียงลำดับ::l::Order";
$c[7][field]="ordr";
$c[7][fieldtype]="number";
$c[7][descr]="";

//

$dsp[1][text]="ชื่อวันที่ให้บริการ::l::Repeating";
$dsp[1][field]="name";
$dsp[1][width]="30%";

$dsp[5][text]="ข้อความเพิ่มเติม::l::Note";
$dsp[5][field]="descr";
$dsp[5][width]="50%";

$dsp[6][text]="วันให้บริการห้อง::l::Service day name";
$dsp[6][field]="dayname";
$dsp[6][width]="15%";




fixform_tablelister($tbname," maintb='$syeaid' ",$dsp,"yes","yes","yes","syeaid=$syeaid",$c);
?><CENTER><A HREF="index.php" class=a_btn ><?php  echo getlang("กลับ::l::Back");?></A></CENTER>

<?php 
foot();
?>