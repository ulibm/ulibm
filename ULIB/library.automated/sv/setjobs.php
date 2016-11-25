<?php 
	; 

include ("../../inc/config.inc.php");
html_start();
include("conf.php");

if ($refcode=="") {
	html_dialog("Warning","โมดูลนี้จะใช้งานได้ก็ต่อเมื่อติดตั้งโปรแกรมที่ไอพีจริง และลงทะเบียนโปรแกรม ULibM แล้ว");
	die;
}
if ($issave=="yes") {
	//printr($setjobs);
	$tosave=serialize($setjobs);
	tmq("update automatedsv set jobconf='$tosave',refurl='$refurl' where refcode='$refcode' ",false);
	html_dialog("Saved","บันทึกการตั้งค่าเรียบร้อย<br> สำหรับ :$refcode ($refurl)");
}
//printr($_GET);
//$s=tfa($s);
//printr($s);
$chk=tmq("select * from automatedsv where refcode='$refcode' ");
if (tnr($chk)==0) {
	tmq("insert into automatedsv set refcode='$refcode' ");
}
$dat=tmq("select * from automatedsv where refcode='$refcode' ",false);
$dat=tfa($dat);
$jobs=$dat[jobconf];
$jobs=unserialize($jobs);
if (!is_array($jobs)) {
	$jobs=Array();
}
//printr($jobs);
?><form method="post" action="<?php  echo $PHP_SELF;?>">
	<input type="hidden" name="issave" value="yes">
	<input type="hidden" name="refcode" value="<?php  echo $refcode;?>">
	<table width=100% class=table_border>
	<tr>
		<td width=100><?php  echo getlang("เลือกกิจกรรมที่ต้องการให้ประมวลผล::l::Choose Task");?></td></tr>
		<?php 
@reset($jobsdb);
//printr($jobsdb);
while (list($k,$v)=each($jobsdb)) {
	//printr($v);
	//printr($jobs["$k"]);
	?><tr><td class=table_td> <img src="../../neoimg/menuicon/Clock-icon.png" width="16" height="16" border="0" alt=""> <?php 
	echo "<b>".$v[name]."</b></td></tr><tr style='background-color: white;'><td> &nbsp;&nbsp;&nbsp;&nbsp;";
	for($i=0;$i<=6;$i++) {
		$sl="";
		//echo $k.$sl;
		if ($jobs["$k"]["$i"]=="yes") {
			$sl=" selected checked ";
		}
		echo "<label><input type=checkbox name='setjobs[$k][$i]' value='yes' $sl >".$thaidaystr[$i]."</label> ";
	}
	?></td>
	</tr><?php 
}
		?>
<tr>
	<td colspan=2 align=center><input type="submit"></td>
</tr>
	</table>
	<input type="hidden" name="refcode" value="<?php  echo $refcode;?>">
	<input type="hidden" name="refurl" value="<?php  echo $refurl;?>">
</form>