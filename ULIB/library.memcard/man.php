<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
$parent=tmq("select * from memcard where code='".str_replace("FOOT::","",$pid)."' ");
$parent=tfa($parent);
$cate=tmq("select * from memcard where code='$parent[pid]' ");
$cate=tfa($cate);
pagesection("Template: ".getlang($cate[name]).": ".getlang($parent[name]));


//edit_string
$save_string=floor($save_string);
if ($save_string!=0) {
	tmq("update memcard_sub_i set data='".addslashes($entertext)."',string_fontsize='$string_fontsize' where id='$save_string'");
}
$edit_string=floor($edit_string);
if ($edit_string!=0) {
	?><form method="post" action="man.php">
	<input type="hidden" name="pid" value="<?php  echo $pid;?>">
	<input type="hidden" name="save_string" value="<?php  echo $edit_string;?>">
		<table width=<?php  echo $_TBWIDTH?> align=center class=table_border>
	<tr>
		<td class=table_head><?php  echo getlang("ป้อนข้อความ::l::Enter Text");?></td>
		<td class=table_td><textarea name="entertext" rows="" cols="3" style="width: 300px"><?php 
		$oldval=tmq("select * from memcard_sub_i where id='$edit_string' ");	
	$oldval=tfa($oldval);
	echo stripslashes($oldval[data]);
	?></textarea><br>
	Font Size  <input type="text" name="string_fontsize" value="<?php  
	$oldval[string_fontsize]=floor($oldval[string_fontsize]);
	if ($oldval[string_fontsize]==0) {
		$oldval[string_fontsize]=15;
	}
	echo $oldval[string_fontsize];?>" size=3>
	
	<br><input type="submit" value=" Save "></td>
	</tr>
	</table>
	</form><?php 
}
$save_var=floor($save_var);
if ($save_var!=0) {
	tmq("update memcard_sub_i set data='".addslashes($edit_var_data)."',string_fontsize='$string_fontsize' where id='$save_var'");
}
$edit_var=floor($edit_var);
if ($edit_var!=0) {
	?><form method="post" action="man.php">
	<input type="hidden" name="pid" value="<?php  echo $pid;?>">
	<input type="hidden" name="save_var" value="<?php  echo $edit_var;?>">
		<table width=<?php  echo $_TBWIDTH?> align=center class=table_border>
	<tr>
		<td class=table_head><?php  echo getlang("ป้อนข้อความ::l::Enter Text");?></td>
		<td class=table_td> <?php 
		$oldval=tmq("select * from memcard_sub_i where id='$edit_var' ");	
	$oldval=tfa($oldval);
	$data= stripslashes($oldval[data]);
	form_quickedit("edit_var_data",$data,"foreign:-localdb-,memcard_var,code,name");
	?><br>
	Font Size  <input type="text" name="string_fontsize" value="<?php  
	$oldval[string_fontsize]=floor($oldval[string_fontsize]);
	if ($oldval[string_fontsize]==0) {
		$oldval[string_fontsize]=9;
	}
	echo $oldval[string_fontsize];?>" size=3>
	
	<br> <input type="submit" value=" Save "></td>
	</tr>
	</table>
	</form><?php 
}
$save_image=floor($save_image);
if ($save_image!=0) {
	$dr="$dcrs/_tmp/memcard_img/";
	//echo $dr;
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) { 
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "$save_image.jpg"); 
	}
}
$edit_image=floor($edit_image);
if ($edit_image!=0) {
	?><form method="post" action="man.php" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php  echo $pid;?>">
	<input type="hidden" name="save_image" value="<?php  echo $edit_image;?>">
		<table width=<?php  echo $_TBWIDTH?> align=center class=table_border>
	<tr>
		<td class=table_head><?php  echo getlang("เลือกไฟล์ภาพ::l::Choost image");?></td>
		<td class=table_td><?php 
	$oldval=tmq("select * from memcard_sub_i where id='$edit_image' ");	
	$oldval=tfa($oldval);
	if (file_exists($dcrs."_tmp/memcard_img/$oldval[id].jpg")) {
		?><img src="../_tmp/memcard_img/<?php  echo $oldval[id];?>.jpg?<?php  echo rand();?>" width=48 height=48 style="border-width:1;border-style:inset;"><?php 
	}
	?> <INPUT TYPE="file" NAME="selectedfile" size=15 >
	<input type="submit" value=" Upload "><br>JPG only**</td>
	</tr>
	</table>
	</form><?php 
}
$tbname="memcard_sub_i";
/*
$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";
*/
$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ตำแหน่ง::l::Position";
$c[4][field]="pos";
$c[4][fieldtype]="memcard_pos";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="ประเภท::l::Type";
$c[5][field]="type1";
$c[5][fieldtype]="foreign:-localdb-,memcard_itype,code,name";
$c[5][descr]="";
$c[5][defval]="string";

$c[8][text]="ค่าตัวแปร::l::Variable";
$c[8][field]="varid";
$c[8][fieldtype]="foreign:-localdb-,memcard_var,code,name";
$c[8][descr]=" เฉพาะประเภทค่าตัวแปร";
$c[8][defval]="";

$c[9][text]="ข้อความ::l::Text";
$c[9][field]="data";
$c[9][fieldtype]="longtext";
$c[9][descr]=" เฉพาะประเภทข้อความ";
$c[9][defval]="";

$c[7][text]="ขนาดตัวอักษร::l::Font Size";
$c[7][field]="string_fontsize";
$c[7][fieldtype]="number";
$c[7][descr]=" เฉพาะประเภทข้อความและค่าตัวแปร";
$c[7][defval]="15";
/*
$c[10][text]="การจัดอักษร::l::alignment";
$c[10][field]="string_align";
$c[10][fieldtype]="foreign:-localdb-,memcard_align,code,name";
$c[10][descr]=" ";
$c[10][defval]="J";*/


$c[70][text]="Font";
$c[70][field]="font";
$c[70][fieldtype]="list:,Tahoma,Browalia,Angsana,THSarabunNew,TH Baijam,TH Chakra Petch,TH Charmonman,TH K2D July8,TH Kodchasal,TH KoHo,TH Mali Grade6,TH Niramit AS,TH Srisakdi";
$c[70][descr]=" เฉพาะประเภทข้อความและค่าตัวแปร";
$c[70][defval]="";

$c[71][text]="ตัวหนา::l::is bold";
$c[71][field]="fontisbold";
$c[71][fieldtype]="yesno";
$c[71][descr]=" เฉพาะประเภทข้อความและค่าตัวแปร";
$c[71][defval]="no";


$c[6][text]="-";
$c[6][field]="pid";
$c[6][fieldtype]="addcontrol";
$c[6][descr]="";
$c[6][defval]=$pid;
//dsp


//$dsp[1][text]="รหัส::l::Code";
//$dsp[1][field]="code";
//$dsp[1][width]="20%";

$dsp[2][text]="รายละเอียด::l::Detail";
$dsp[2][field]="name";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_name";
$itypedb=tmq_dump("memcard_itype","code","name");
function local_name($wh) {
	global $itypedb;
	$s="[$wh[ordr]] ".getlang($itypedb[$wh[type1]]);;
	return $s;
}

$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][align]="center";
$dsp[4][field]="name";
$dsp[4][filter]="module:local_man";
$dsp[4][width]="30%";
function local_man($wh) {
	global $pid;
	global $dcrs;
	//printr($wh);
	if ($wh[type1]=="string") {
		//$s= "<a href=\"man.php?pid=$pid&edit_string=$wh[id]\"><font >".getlang("จัดการ::l::Manage")." </font></a><br>";;
		$s="<font class=smaller2>$wh[data]</font>";

	}
	if ($wh[type1]=="image") {
		$s= "<a href=\"man.php?pid=$pid&edit_image=$wh[id]\"><font >".getlang("จัดการ::l::Manage")." </font></a><br>";
		if (file_exists($dcrs."_tmp/memcard_img/$wh[id].jpg")) {
			$s.= "<img src=\"../_tmp/memcard_img/$wh[id].jpg?<?php  echo rand();?>\" width=48 height=48 style=\"border-width:1;border-style:inset;\">";
		}

	}
	if ($wh[type1]=="var") {
		//$s= "<a href=\"man.php?pid=$pid&edit_var=$wh[id]\"><font >".getlang("จัดการ::l::Manage")." </font></a><br><font class=smaller2>$wh[data]</font>";
		
		$s="<font class=smaller2>$wh[varid]</font>";

	}

	return $s;
}
/*
$dsp[5][text]="ยังใช้งาน::l::is active?";
$dsp[5][field]="isactive";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";
*/


fixform_tablelister($tbname," pid='$pid' ",$dsp,"yes","yes","yes","pid=$pid",$c," ordr ",$o);
//printr($parent);
?><center><b>Quick Preview</b><br>
<?php  echo getlang("คลิก และใช้ปุ่มลูกศรเพื่อจัดตำแหน่ง<br>
ปุ่ม 4,6 เพื่อลด-เพิ่มความกว้าง<br>ปุ่ม 8,2 เพื่อลด-เพิ่มความสูง
::l::Click and use arrow key to adjust position<br>
key 4,6 to decrease-increase width<br>
key 8,2 to decrease-increase height") ; ?><br>
<iframe src="_pospicker.php?pid=<?php  echo $pid;?>&view=yes" height="<?php  echo floor($parent[h]*$_MMTOPX)+20?>"  width="<?php  echo floor($parent[w]*$_MMTOPX)+20?>"></iframe>
</center><?php 
?><center><a href=mantp.php>Back</a><?php

foot(); 
?>