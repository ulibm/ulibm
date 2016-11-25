<?php 
;
include("../../inc/config.inc.php");
head();
//include("_REQPERM.php");
$_REQPERM="rqroom_display";
mn_lib();
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);

$allmaintbcodeorig=$allmaintbcode;
?>
<table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH?> align=center class=table_border>

<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
<tr><td></td>
<td class=table_td><?php 
					echo "<A HREF='detail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig' target=_top><img src='$dcrURL/neoimg/right32.png' 
					align=absmiddle border=0 width=32><b style='font-size:24'> ";
				 echo getlang("แสดงทุกห้อง ทุกช่วงเวลา::l::Show all room all period")."</b></A>";
				 	echo " (<A HREF='../../requestroom.predetail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig' target=_blank><font class=smaller>";
				 echo getlang("แสดงในมุมมองของผู้ใช้::l::Show in member's view")."</font></A>)";
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
	 tmq("insert into rqroom_eventinfo set maintb='$editinfo_maintb' , period='$editinfo_period' , keyid='$dat-$mon-$yea' ,text='$text' ,descr='$descr',image='$oldb4del[image]'");
	 
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
if ($editinfo!="") {
$old=tmq("select * from rqroom_eventinfo where maintb='$editinfo_maintb' and period='$editinfo_period' and keyid='$dat-$mon-$yea'  ");
$oldcount=tmq_num_rows($old);
$old=tmq_fetch_array($old);
	 ?>
	 <table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH?> align=center class=table_border>
<form action="predetail.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mon" value="<?php  echo $mon;?>" />
<input type="hidden" name="dat" value="<?php  echo $dat;?>" />
<input type="hidden" name="yea" value="<?php  echo $yea;?>" />
<input type="hidden" name="allmaintbcode" value="<?php  echo $allmaintbcodeorig;?>" />

<input type="hidden" name="editinfosave" value="<?php  echo $editinfo;?>" />
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
</form>
</table>
	 <?php 
}

if ($iframe_period!="") {
	?><CENTER><iframe width=<?php  echo $_TBWIDTH?> src="detail.iframe.php?<?php 
	echo "mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period";	
	?>" height=530></iframe></CENTER><?php 
}
?>
<br />
<?php 

$s="select * from rqroom_maintb where 0 ";

$allmaintbcode=explode(',',$allmaintbcode);
$allmaintbcode=arr_filter_remnull($allmaintbcode);
while (list($k,$v)=each($allmaintbcode)) {
	$s.= " or code='$v' ";
}
$s.="order by name";
$s=tmq($s);
//pagesection("กรุณาระบุห้อง/ห้องย่อย/ที่นั่ง ที่ต้องการจอง::l::Please choose room, seat you want to request");
while ($r=tmq_fetch_array($s)) {
	//printr($r);
	pagesection($r[name],"requestroom");
	$s2=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr ");
	?>
<TABLE width=<?php  echo $_TBWIDTH?> align=center>
<tr><td   valign=middle align=left colspan='<?php  echo tnr($s2)+1?>'>
<?php 
		echo "<A HREF='detail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$r[code]' target=_top style='text-decoration: none;'><img src='$dcrURL/neoimg/right32.png' 
		align=absmiddle border=0 width=24><b style='font-size:20'> ";
		echo getlang("แสดงเฉพาะห้อง::l::Show")."</b></A>";
	?> &nbsp;&nbsp;<?php  echo getlang($r[descr]);?>
</td></tr>
<?php 

			echo "<TR  valign=bottom>";
			echo "<TD width=100  valign=top><img src='../../neoimg/spacer.gif' height=10 width=100></TD>";
			echo "<TD class=table_td align=left width=100%>";
			$s3=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr");
			while ($r3=tmq_fetch_array($s3)) {
			  $str="<span style='width:100%; margin-top:10; background-color: transparent; display:block; height: 120'>";

			$old=tmq("select * from rqroom_eventinfo where maintb='$r[code]' and period='$r3[code]' and keyid='$dat-$mon-$yea'  ",false);
  			$old=tmq_fetch_array($old);
  			if (strtolower($r[isautoopen])=="yes") {
  			    $str.= getlang("เปิดให้บริการแม้ไม่มีกิจกรรม");
  			} else {
   			if (trim($old[text])=="") {
   				$str.= getlang("ไม่เปิดให้บริการ คลิก [แก้ไขข้อมูล] เพื่อเปิดใช้งาน");
   			} 
			}
			$str.="<A HREF='predetail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&iframe_maintb=$r[code]&iframe_period=$r3[code]' target=_top style='text-decoration: none;'>";
  			if ($old[image]!='' && file_exists("$dcrs/_tmp/rqroomfile/$old[image]")) {
  				  $str.= "<!-- [$old[image]] --><img src='$dcrURL/_tmp/rqroomfile/$old[image]' style='float:left; margin-right: 3px;;' border=0 width=120 height=120>";
  			} else {
  				  $str.= "<img src='Group-icon.png' style='float:left; margin-right: 3px;;' border=0 width=120 >";
			}
			if (trim($old[text])!='') {
				 $str.= "<font style='color:#005771; font-size: 22px;'>$old[text]</font>";
			}
          //$str.="<img src='$dcrURL/neoimg/right32.png' align=absmiddle border=0 width=32>";
           $str.=" <font style='color:#005771; font-size: 14'>&nbsp;(".getlang($r3[name]).")</font>";
			 $str.= "<br /><img src='$dcrURL/neoimg/clock.png' 
				align=absmiddle border=0 width=16><b style='font-size:12'> ";
				  $str.= getlang("แสดงเฉพาะรอบ::l::Show Period")."</b></A>";
		   $str.= " <BR><img src='$dcrURL/neoimg/edit16.png' 
				align=absmiddle border=0 width=16><A HREF='predetail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&editinfo=$r3[code]&editinfo_maintb=$r[code]&editinfo_period=$r3[code]'  style='font-size:12'> ";
          $str.=getlang("แก้ไขข้อมูล::l::Edit Info.")."</A><BR></span>";
          
          echo $str;
			}
          echo "</TD>";
		
		
		echo "</TR>";

	?>
	</TABLE><?php 
}


foot();

?>