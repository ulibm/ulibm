<?php 
    ;
include("../../inc/config.inc.php");
include("./_REQPERM.php");
head();
mn_lib();

pagesection("แก้ไขช่วงเวลาที่ให้บริการจองห้อง::l::Period to request room");

?>
<CENTER><B><?php  echo getlang("เครื่องมือ::l::Tools");?></B>: <A  class=a_btn HREF="edit-periodinfo.php?syeaid=<?php  echo $syeaid?>&tm=form"><?php  echo getlang("สำเนามาจากห้องอื่น::l::Copy from other");?></A></CENTER>
<?php 
if ($tm=="form") {
?>
<TABLE width=500 class=table_border align=center>
<FORM METHOD=POST ACTION="edit-periodinfo.php">
	
<TR>
	<TD class=table_head><?php  echo getlang("สำเนามาจากห้องอื่น::l::Copy from other");?></TD>
</TR>
<TR>
	<TD class=table_td><?php 
		frm_genlist("copyfrommaintb","select * from  rqroom_maintb where code<>'$syeaid' order by name","code","name","-localdb-","no")
	
?> <INPUT TYPE="checkbox" style="border-width: 0px" NAME="isdeleteold" value="yes"> <?php  echo getlang("ลบข้อมูลเก่า::l::Delete existing data");?></TD>
</TR>
<INPUT TYPE="hidden" NAME="tm" value="submitit">
<INPUT TYPE="hidden" NAME="syeaid" value="<?php  echo $syeaid?>">
<TR>
	<TD class=table_td><INPUT TYPE="submit" value="<?php  echo getlang("ตกลง::l::Submit");?>"> <A  class=a_btn HREF="edit-periodinfo.php?syeaid=<?php  echo $syeaid?>"><?php  echo getlang("ยกเลิก::l::Cancel");?></A></TD>
</TR>
</FORM>
</TABLE>
<?php 
}
if ($tm=="submitit") {
	if ($isdeleteold=="yes") {
		tmq("delete from rqroom_periodinfo where maintb='$syeaid' ");
	}
	$s=tmq("select * from rqroom_periodinfo where maintb='$copyfrommaintb' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into rqroom_periodinfo set maintb='$syeaid' ,
		ordr='$r[ordr]',
		code='$r[code]',
		name='$r[name]',
		time='$r[time]',
		cost='$r[cost]',
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


$tbname="rqroom_periodinfo";

$c[1][text]="ช่วงเวลา";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[3][text]="Code";
$c[3][field]="code";
$c[3][fieldtype]="autorun";
$c[3][descr]="";
$c[2][text]="ข้อความเพิ่มเติม";
$c[2][field]="descr";
$c[2][fieldtype]="longtext";
$c[2][descr]="";
$c[4][field]="maintb";
$c[4][fieldtype]="addcontrol";
$c[4][descr]="";
$c[4][defval]="$syeaid";
$c[6][text]="เวลา";
$c[6][field]="time";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[7][text]="เรียงลำดับ";
$c[7][field]="ordr";
$c[7][fieldtype]="number";
$c[7][descr]="";
/*
$c[8][text]="หน่วย";
$c[8][field]="cost";
$c[8][fieldtype]="number";
$c[8][descr]="";
*/
//

$dsp[1][text]="ช่วงเวลา";
$dsp[1][field]="name";
$dsp[1][width]="20%";
/*
$dsp[2][text]="Code";
$dsp[2][field]="code";
$dsp[2][width]="20%";

$dsp[3][text]="เรียงลำดับ";
$dsp[3][field]="ordr";
$dsp[3][width]="10%";
*/
$dsp[5][text]="ข้อความเพิ่มเติม";
$dsp[5][field]="descr";
$dsp[5][width]="30%";


fixform_tablelister($tbname," maintb='$syeaid' ",$dsp,"yes","yes","yes","syeaid=$syeaid",$c);
?><CENTER><A HREF="index.php" class=a_btn ><?php  echo getlang("กลับ::l::Back");?></A></CENTER>
<?php 
foot();
?>