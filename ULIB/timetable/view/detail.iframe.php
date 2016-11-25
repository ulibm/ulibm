<?php 
;
include("../../inc/config.inc.php");
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);
html_start();

//include("_REQPERM.php");
$_REQPERM="rqroom_display";
loginchk_lib();
$confirmbarcode=trim($confirmbarcode);
$affected=0;
if ($confirmbarcode!="") {
	$s2=tmq("select * from rqroom_roomsub where maintb='$iframe_maintb' order by ordr ",false);
	while ($r2=tmq_fetch_array($s2)) {
		$c=tmq("select * from rqroom_timetbi where maintb='$iframe_maintb' and period='$iframe_period' and keyid='$dat-$mon-$yea' and roomsub='$r2[code]' and loginid='$confirmbarcode' ",false);

		if (tmq_num_rows($c)!=0) {
			$affected++;
			tmq("update rqroom_timetbi set confirmed='yes' where maintb='$iframe_maintb' and period='$iframe_period' and keyid='$dat-$mon-$yea' and roomsub='$r2[code]' and loginid='$confirmbarcode' ",false);
		} 
	}
	if ($affected==0) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
			alert("<?php  echo getlang("ไม่พบบาร์โค้ด $confirmbarcode ในรอบนี้::l::Barcode $confirmbarcode not found in participants");?>");
		//-->
		</SCRIPT><?php 
	}
}

	if ($uploadplanimg=="yes") {
		$uploaddir ="$dcrs/_tmp/rqroomfile_tp/";
		@mkdir("$uploaddir", 0777);
		
	
		$purename=$_FILES['Filedata']['name'];
    $ext=explode('.',$purename);
    $ext=$ext[count($ext)-1];
    $ext=strtolower($ext);
		if ($ext!="jpg") {
			 die("extension not allowed, jpg only");
		}
		
		$newname="$iframe_maintb.$ext";
    $uploadfile = $uploaddir . $newname;

		if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {
			//print "อัพโหลดไฟล์เรียบร้อย. ";
		}
	}
	
if ($editplan=="yes") {
	 ?>
	 <table border="0" cellpadding="0" cellspacing="0" width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<form action="detail.iframe.php" method="post"  enctype="multipart/form-data">
<input type="hidden" name="mon" value="<?php  echo $mon;?>" />
<input type="hidden" name="dat" value="<?php  echo $dat;?>" />
<input type="hidden" name="yea" value="<?php  echo $yea;?>" />
<input type="hidden" name="iframe_maintb" value="<?php  echo $iframe_maintb;?>" />
<input type="hidden" name="iframe_period" value="<?php  echo $iframe_period;?>" />

<input type="hidden" name="uploadplanimg" value="yes" />

<tr><td class=table_head><?php  echo getlang("ภาพแผนผัง::l::Room plan");?></td><td class=table_td><input type="file" name="Filedata" ><br />
Width=<?php  echo $_TBWIDTH?>px, JPG only
 </td></tr>

<tr><td class=table_head colspan=2><input type="submit" value=" OK "> <input type="reset" value=" Reset "></td></tr>
</form>
</table>
	 <?php 
	
	echo "<B><CENTER><A class=a_btn HREF='detail.iframe.php?mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period'>".getlang("กลับ::l::Back")."</A></CENTER></B>";
	die();
}

$allmaintbcodeorig=$allmaintbcode;
?>
<table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH?> align=center class=table_border>

<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
<tr><td class="smaller table_head" width=30% ><?php  echo getlang("ช่วงเวลา::l::Period")?></td>
<td class="smaller table_td"><?php 
		$s2=tmq("select * from rqroom_periodinfo where maintb='$iframe_maintb' and code='$iframe_period' ",false);
		if (tmq_num_rows($s2)!=1) { die("rqroom_periodinfo where maintb='$iframe_maintb' and code='$iframe_period' ");}
		$r2=tmq_fetch_array($s2);
		echo getlang($r2[name]);

?> &nbsp; <a class="smaller a_btn" href="detail.iframe.php?<?php  echo "mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period";?>&editplan=yes"><?php  echo getlang("แก้ไขภาพแผนผัง::l::Edit plan image");?></a>
&nbsp;  <a class="smaller a_btn" href="javascript:void(0)" onclick="local_confirmation();"><?php  echo getlang("ยืนยันการเข้าใช้::l::Confirmation");?></a>
<SCRIPT LANGUAGE="JavaScript">
<!--
function local_confirmation() {
	confirmed=prompt("<?php  echo getlang("กรุณากรอกบาร์โค้ด::l::Enter Member's barcode");?>","");
	if (confirmed=="" || confirmed==false || confirmed==null) {
		return false;
	}
	self.location="detail.iframe.php?<?php  echo "mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period";?>&confirmbarcode="+confirmed;
	return true;
}
//-->
</SCRIPT>
</td></tr>
</table><?php 

if ($delete_id!="") {
	tmq("delete from rqroom_timetbi  where id='$delete_id' ");
}


if ($setloginid!="") {
	 $dt=ymd_mkdt($dat,$mon,$yea);
	 tmq("delete from rqroom_timetbi  where maintb='$iframe_maintb' and period='$iframe_period' and keyid='$dat-$mon-$yea' and roomsub='$edit_subroom' and dt='$dt' ");
	 tmq("insert into rqroom_timetbi  set maintb='$iframe_maintb' , period='$iframe_period' , keyid='$dat-$mon-$yea' ,loginid='$setloginid' ,dt='$dt' ,roomsub='$edit_subroom' ");
	stathist_add("ttb_member",$setloginid,$iframe_maintb);	
}

if ($edit_subroom!="" && $setloginid=="") {

	 $dt=ymd_mkdt($dat,$mon,$yea);
	 $old=tmq("select * from rqroom_timetbi  where maintb='$iframe_maintb' and period='$iframe_period' and keyid='$dat-$mon-$yea'  and dt='$dt' and roomsub='$edit_subroom'  ");
$oldcount=tmq_num_rows($old);
$old=tmq_fetch_array($old);
	 ?>
	 <table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH?> align=center class=table_border>
<form action="detail.iframe.php" method="post" >
<input type="hidden" name="mon" value="<?php  echo $mon;?>" />
<input type="hidden" name="dat" value="<?php  echo $dat;?>" />
<input type="hidden" name="yea" value="<?php  echo $yea;?>" />
<input type="hidden" name="iframe_maintb" value="<?php  echo $iframe_maintb;?>" />
<input type="hidden" name="iframe_period" value="<?php  echo $iframe_period;?>" />

<input type="hidden" name="edit_subroom" value="<?php  echo $edit_subroom;?>" />

<tr><td class=table_head><?php  echo getlang("บาร์โค้ดสมาชิก::l::Member's barcode");?></td><td class=table_td><input type="text" name="setloginid" value="<?php  echo $old[loginid];?>" ID='setloginid'><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj("setloginid").select();
//-->
</SCRIPT>
 <A class=a_btn HREF="detail.iframe.php?<?php  echo "mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period&delete_id=$old[id]"; ?>"><?php  echo getlang("สละสิทธิ์::l::Cancel");?></A>
</td></tr>

<tr><td class=table_head colspan=2><input type="submit" value=" OK "> <input type="reset" value=" Reset "></td></tr>
</form>
</table>
	 <?php 
	
	echo "<B><CENTER><A class=a_btn HREF='detail.iframe.php?mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period'>".getlang("กลับ::l::Back")."</A></CENTER></B>";
	die();
}
//////////////////////plan img start
$spath="$dcrs/_tmp/rqroomfile_tp/$iframe_maintb.jpg";
//echo $spath;
if (file_exists($spath) ) {
	 echo "<img border=0 src='$dcrURL"."_tmp/rqroomfile_tp/$iframe_maintb.jpg' width=$_TBWIDTH>";
}
//////////////////////plan img end
		$s2=tmq("select * from rqroom_roomsub where maintb='$iframe_maintb' order by ordr ",false);
		while ($r2=tmq_fetch_array($s2)) {
			$jsid="a".randid();
		$c=tmq("select * from rqroom_timetbi where maintb='$iframe_maintb' and period='$iframe_period' and keyid='$dat-$mon-$yea' and roomsub='$r2[code]' ",false);
			?><div id="root<?php  echo $jsid;?>" style="left:<?php  echo $r2[js_x]?>px; top:<?php  echo $r2[js_y]?>px; position: absolute; width:70;" class=table_border>
<div id="handle<?php  echo $jsid;?>" class=table_head style="cursor:move;"><nobr  class=smaller><?php  echo getlang($r2[name]);?></nobr></div>
<?php 
$str="";
	$editurl="<A HREF='detail.iframe.php?mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period&edit_subroom=$r2[code]'  class=smaller2>";
if (tmq_num_rows($c)==0) {
	$str="$editurl<img src='$dcrURL/neoimg/right32.png' align=absmiddle border=0 width=16> ";
	$str.=getlang("เลือก::l::Pick")."</A>";
	$bgcol="#D0FFCE";
} else {
	$c=tmq_fetch_array($c);
	$str="$editurl".getlang("จองแล้ว::l::Taken")."</a>";
	if ($c[confirmed]=="yes") {
		$str.="<img src='$dcrURL"."neoimg/Checkmark.gif' border=0 width=14 height=14 TITLE='ยืนยันแล้ว/Confirmed'>";
	}
	$str.="<BR>";
	$str.="<nobr  class=smaller2>".get_member_name($c[loginid],"style='font-size:10px;'")."</nobr>";
	$bgcol="#FFE7CE";
}
echo "<TABLE width=100%>
<TR>
	<TD  bgcolor=$bgcol class=smaller2>$str</TD>
</TR>
</TABLE>";
?>
</div>
<script type="text/javascript">
var theHandle<?php  echo $jsid;?> = document.getElementById("handle<?php  echo $jsid;?>");
var theRoot<?php  echo $jsid;?> = document.getElementById("root<?php  echo $jsid;?>");
Drag.init(theHandle<?php  echo $jsid;?>, theRoot<?php  echo $jsid;?>);
theRoot<?php  echo $jsid;?>.onDragEnd = function(x, y) {// x, y contains current offset coords of drag
x=Math.round(x / 10) *10;
y=Math.round(y / 10) *10;
this.style.top=y
this.style.left=x
getobj("POSSAVER").src="savepos.php?subid=<?php  echo $r2[id]?>&js_x="+x+"&js_y="+y;
}
</script><?php 
		}
?><iframe width=1 src="" height=1 ID='POSSAVER' frameborder=no></iframe>