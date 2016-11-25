<?php 
;
include("./inc/config.inc.php");
stat_add("visithp_type","requestroom");
head();
mn_web("requestroom");
?>
<style>
.dayname {
	font-size:18px;
}
</style>
<?php 
$dat=floor($ymd_dat);
$mon=floor($ymd_mon);
$yea=floor($ymd_yea);

$allmaintbcodeorig=$allmaintbcode;
$mememtype="";
if ($_memid!="") {
	$memem=tmq("select * from member where UserAdminID='$_memid' ");
	$memem2=tfa($memem);
	//printr($memem2);
	$mememtype=trim($memem2[type]);
}
?>
<table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH?> align=center class=table_border>

<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
<tr><td class=table_head width=30%><?php  //echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
$editinfo_maintbinf=tmq("select * from rqroom_maintb where code='$editinfo_maintb' ");
$editinfo_maintbinfr=tfa($editinfo_maintbinf);
//printr($editinfo_maintbinfr);
echo getlang($editinfo_maintbinfr[name]);
		if ($mememtype!="" && ($mememtype==$editinfo_maintbinfr[fullgrant1] ||$mememtype==$editinfo_maintbinfr[fullgrant2] ||$mememtype==$editinfo_maintbinfr[fullgrant3] ||$mememtype==$editinfo_maintbinfr[fullgrant4] )) {
		} else {
			html_dialog("","Permission denied");
			die;
		}
?></td></tr>
<tr><td class=table_head width=30%><?php  //echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
$editinfo_periodinf=tmq("select * from rqroom_periodinfo where code='$editinfo_period' ");
$editinfo_periodinfr=tfa($editinfo_periodinf);
//printr($editinfo_periodinfr);
echo getlang($editinfo_periodinfr[name]);

?></td></tr>

</table><br />
<?php 
if ($editinfosave!="") {
	 $text=addslashes($text1);
	 $descr=addslashes($descr);
	if ($removeimage=="yes") {
		 $del=tmq("select * from rqroom_eventinfo where maintb='$editinfo_maintb' and period='$editinfo_period' and keyid='$dat-$mon-$yea'");
		 $del=tfa($del);
		 @unlink("$dcrs/_tmp/rqroomfile/$del[image]");
	}
	//not delete old image incaseof lazy
	$oldb4del=tmq("select * from rqroom_eventinfo where maintb='$editinfo_maintb' and period='$editinfo_period' and keyid='$dat-$mon-$yea' ");
	$oldb4del=tfa($oldb4del);
	 tmq("delete from rqroom_eventinfo where maintb='$editinfo_maintb' and period='$editinfo_period' and keyid='$dat-$mon-$yea' ");
	 tmq("insert into rqroom_eventinfo set maintb='$editinfo_maintb' , period='$editinfo_period' , keyid='$dat-$mon-$yea' ,text='$text' ,descr='$descr',image='$oldb4del[image]',memid='$_memid'",false);
	 
	 $previd=tmq_insert_id();
		
	if ($removeimage!="yes") {
		$uploaddir ="$dcrs/_tmp/rqroomfile/";
		@mkdir("$uploaddir", 0777);
		
	
		$purename=$_FILES['Filedata']['name'];
    $ext=explode('.',$purename);
    $ext=$ext[count($ext)-1];
    $ext=strtolower($ext);
		if ($ext=="php" || $ext=="php3" || $ext=="phps" || $ext=="exe") {
			 die("extension not allowed");
		}
		
		$newname=randid().".$ext";
    $uploadfile = $uploaddir . $newname;

		if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {
			//print "อัพโหลดไฟล์เรียบร้อย. ";
			tmq("update rqroom_eventinfo set image='$newname' where id='$previd' ",false);
		}
	}
}
$old=tmq("select * from rqroom_eventinfo where maintb='$editinfo_maintb' and period='$editinfo_period' and keyid='$dat-$mon-$yea'  ",false);
$oldcount=tmq_num_rows($old);
$old=tmq_fetch_array($old);
	 ?>
<form action="<?php  echo $PHP_SELF;?>" method="post" enctype="multipart/form-data">
	 <table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH?> align=center class=table_border>
<input type="hidden" name="ymd_mon" value="<?php  echo $ymd_mon;?>" />
<input type="hidden" name="ymd_dat" value="<?php  echo $ymd_dat;?>" />
<input type="hidden" name="ymd_yea" value="<?php  echo $ymd_yea;?>" />
<input type="hidden" name="allmaintbcode" value="<?php  echo $allmaintbcodeorig;?>" />

<input type="hidden" name="editinfosave" value="yes" />
<input type="hidden" name="editinfo_maintb" value="<?php  echo $editinfo_maintb;?>" />
<input type="hidden" name="editinfo_period" value="<?php  echo $editinfo_period;?>" />

<tr><td class=table_head><?php  echo getlang("ข้อความ::l::Text");?></td><td class=table_td><input type="text" name="text1" value="<?php  echo $old[text];?>"></td></tr>
<tr><td class=table_head><?php  echo getlang("ข้อความบรรยาย::l::Detail");?></td><td class=table_td><?php  form_quickedit("descr",$old[descr],"smallhtml");?></td></tr>
<tr><td class=table_head><?php  echo getlang("ภาพ::l::Image");?></td><td class=table_td><input type="file" name=Filedata > <?php 
	echo getlang("กรุณาใช้ภาพทรงจตุรัส::l::Please use square-size image");
if ($old[image]!="") {
	 ?><br /> <input type="checkbox" name="removeimage" value="yes"/> <?php 
	 echo getlang("ลบภาพออก::l::Remove image");
}
?></td></tr>
<tr><td class=table_head colspan=2><input type="submit" value=" OK "></td></tr>
</table>
<center><a href="requestroom1.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></center>
</form>
	 <?php 




foot();

?>