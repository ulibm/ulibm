<?php 
 
		
        include ("../inc/config.inc.php");
		head();


	
$_REQPERM="stat-filter";
mn_lib();
pagesection("สถิติ::l::Statistics","stats");

$statdb[stathist_checkout_member_libsite]=getlang("การยืมคืนของสมาชิก/สาขา::l::Checkout Member/Campus");
$statdb[stathist_checkout_member_media]=getlang("การยืมคืนของสมาชิก/วัสดุ::l::Checkout Member/Resource");
$statdb[stathist_insidelib_member]=getlang("การยืมใช้ภายในของสมาชิก/วัสดุ::l::Use Inside Library Member/Resource");
$statdb[stathist_ms_member_gate]=getlang("การเข้าใช้ของสมาชิก/ทางเข้า::l::Entrance gate by Member/Gate");

?>
<form method="get" action="<?php  echo $PHP_SELF?>">
	<TABLE width=620 align=center cellspacing=0 class=table_border>

<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("เลือกสถิติเพื่อดู::l::Select Statistic Category.");

?></TD>
<TD class=table_td>
<select name="libtoview">
<?php  @reset($statdb);
while (list($k,$v)=each($statdb)) {
?>
	<option value="<?php  echo $k?>" <?php  if ($libtoview==$k) {echo "selected checked"; }?>><?php  echo $statdb[$k];
}?>
</select>
<input type="submit" value="<?php  echo getlang("เลือก::l::Select");?>"></TD>
</TR>
</TABLE>
</form><BR>
<?php 
if ($libtoview=="") {
	foot(); die;
}

if ($libtoview=="stathist_checkout_member_libsite") {
	$s_type="member";
	$d_type="libsite";
	$l_dat="yes";
	$l_mon="yes";
	$l_hrs="yes";
	$l_yea="yes";
}
if ($libtoview=="stathist_checkout_member_media") {
	$s_type="member";
	$d_type="media";
	$l_dat="yes";
	$l_mon="yes";
	//$l_hrs="yes";
	$l_yea="yes";
}
if ($libtoview=="stathist_insidelib_member") {
	$s_type="member";
	$d_type="media";
	$l_dat="yes";
	$l_mon="yes";
	//$l_hrs="yes";
	$l_yea="yes";
}
if ($libtoview=="stathist_ms_member_gate") {
	$s_type="member";
	$d_type="gate";
	$l_dat="yes";
	$l_mon="yes";
	$l_hrs="yes";
	$l_yea="yes";
}

$typedb[member]=getlang("สมาชิก::l::Member");
$typedb[libsite]=getlang("สาขาห้องสมุด::l::Library Campus");

function local_sdlimiter($side,$wh) {
	global $dbname;
	global $_ROOMWORD;
	global $_FACULTYWORD;
	global $_GET;
	if ($wh=="member") {
		$tmpfid=$side."_".$wh."_room";
		echo getlang($_ROOMWORD);?>  <?php 
		//form_quickedit($tmpfid,$_POST[$tmpfid],"foreign:-localdb-,room,id,name,allowblank");
		form_room($tmpfid,$_POST[$tmpfid],"yes");
		echo "<br>";
		$tmpfid=$side."_".$wh."_major";
		echo getlang($_FACULTYWORD);?>  <?php 
		form_quickedit($tmpfid,$_POST[$tmpfid],"foreign:-localdb-,major,id,name,allowblank");
	}
	if ($wh=="libsite") {
		$tmpfid=$side."_".$wh."";
		echo getlang("สาขาห้องสมุด::l::Library Campus");?>  <?php 
		form_quickedit($tmpfid,$_POST[$tmpfid],"foreign:-localdb-,library_site,code,name,allowblank");
	}
	if ($wh=="gate") {
		$tmpfid=$side."_".$wh."_gate";
		echo getlang("ทางเข้า::l::Gate");?>  <?php 
		form_quickedit($tmpfid,$_POST[$tmpfid],"foreign:-localdb-,ms_sub,code,name,allowblank");
	}
	if ($wh=="media") {
		$tmpfid=$side."_".$wh."";
		echo getlang("ประเภทวัสดุ::l::Resource Type");?>  <?php 
		form_quickedit($tmpfid,$_POST[$tmpfid],"foreign:-localdb-,media_type,code,name,allowblank");
		$tmpfid=$side."_".$wh."_campus";
		echo "<br>";
		echo getlang("วัสดุของสาขา::l::Resource of Campus");?>  <?php 
		form_quickedit($tmpfid,$_POST[$tmpfid],"foreign:-localdb-,library_site,code,name,allowblank");
	}
}
?><form method="post" action="<?php  echo $PHP_SELF?>">
<input type="hidden" name="searching" value="yes">
<input type="hidden" name="libtoview" value="<?php  echo $libtoview;?>">
	<table width="<?php  echo $_TBWIDTH;?>" align=center>
<tr>
	<td class=table_head width=50%><?php  echo $typedb[$s_type]?></td>
	<td class=table_head width=50%><?php  echo $typedb[$d_type]?></td>
</tr>
<tr valign=top>
	<td class=table_td><?php  local_sdlimiter("s",$s_type) ;?></td>
	<td class=table_td><?php  local_sdlimiter("d",$d_type) ;?></td>
</tr>

<?php 
	if ($l_hrs=="yes") {
		?>
<tr valign=top align=center>
	<td class=table_td colspan=2><b><?php  echo getlang("เลือกชั่วโมงของวัน (ไม่เลือกเลยหมายถึงไม่นำมาคำนวณ)::l::Select Hours (don't select to ignore)");?></b>
	<table align=center>
	<tr>
		<?php 
		if (!is_array($limithrs)) { $limithrs=Array();}
		for ($i=0;$i<=23;$i++) {
			?><td class=table_td><label><input type="checkbox" name="limithrs[]" value="<?php  echo $i?>" <?php  if (in_array("$i",$limithrs)) {echo "selected checked"; }?>> <?php  echo $i?>.00 </label></td><?php 
				if (($i+1) % 12==0) {
				echo "</tr><tr>";
			}
		}	
		?>
	</tr>
	</table>
	
	</td>
</tr>
<?php 
	}
?>
<?php 
	if ($l_dat=="yes") {
		?>
<tr valign=top align=center>
	<td class=table_td colspan=2><b><?php  echo getlang("เลือกวันที่ (ไม่เลือกเลยหมายถึงไม่นำมาคำนวณ)::l::Select Date (don't select to ignore)");?></b>
	<table align=center>
	<tr>
		<?php 
		if (!is_array($limitdate)) { $limitdate=Array();}
		for ($i=1;$i<=31;$i++) {
			?><td class=table_td><label><input type="checkbox" name="limitdate[]" value="<?php  echo $i?>" <?php  if (in_array("$i",$limitdate)) {echo "selected checked"; }?>> <?php  echo $i?> </label></td><?php 
				if ($i % 10==0) {
				echo "</tr><tr>";
			}
		}	
		?>
	</tr>
	</table>
	
	</td>
</tr>
<?php 
	}
?>
<?php 
	if ($l_mon=="yes") {
		?>
<tr valign=top align=center>
	<td class=table_td colspan=2><b><?php  echo getlang("เลือกเดือน (ไม่เลือกเลยหมายถึงไม่นำมาคำนวณ)::l::Select Month (don't select to ignore)");?></b>
	<table align=center>
	<tr>
		<?php 
		if (!is_array($limitmon)) { $limitmon=Array();}
		for ($i=1;$i<=12;$i++) {
			?><td class=table_td><label><input type="checkbox" name="limitmon[]" value="<?php  echo $i?>" <?php  if (in_array("$i",$limitmon)) {echo "selected checked"; }?>> <?php  echo $thaimonstr[$i]?> </label></td><?php 
				if ($i % 6==0) {
				echo "</tr><tr>";
			}
		}	
		?>
	</tr>
	</table>
	
	</td>
</tr>
<?php 
	}
?>
<?php 
	if ($l_yea=="yes") {
		?>
<tr valign=top>
	<td class=table_td colspan=2 align=center><?php  echo getlang("เลือกปี ::l::Select Year");?>
		<select name="limityea">
		<option value="" ><?php  echo getlang("ไม่กำหนด::l:: - ");?>
		
		<?php 
		for ($i=$_MSTARTY;$i<=$_MENDY;$i++) {
			?><option value="<?php  echo $i?>" <?php  if ($limityea==$i) {echo "selected checked"; }?>><?php  echo $i?><?php 
		}	
		?></select>
	</td>
</tr>
<?php 
	}
?>
<tr>
	<td colspan=2 align=center><input type="submit" value="  Submit  " style="font-size: 24px; height:33px;"></td>
</tr>
</table>
</form>
<?php 
if ($searching!="yes") {
	foot(); die;
}
//printr($_POST);
?><table width=500 class=table_border align=center>
<tr>
	<td class=table_head style="font-size: 24px;"><?php 
	echo getlang("จำนวนผลลัพธ์::l::Result");
	echo " : ";

	$s="select * from $libtoview where 1";
	if ($s_member_room!="") {
		$s.="
		and head in (select UserAdminID from member where room='$s_member_room' )";
	}
	if ($d_member_room!="") {
		$s.=" 
		and foot in (select UserAdminID from member where room='$s_member_room' )";
	}
	if ($s_member_major!="") {
		$s.="
		and head in (select UserAdminID from member where major='$s_member_major' )";
	}
	if ($d_member_major!="") {
		$s.="
		and foot in (select UserAdminID from member where major='$s_member_major' )";
	}
	if ($s_libsite!="") {
		$s.="
		and head ='$d_libsite' ";
	}
	if ($d_libsite!="") {
		$s.="
		and foot ='$d_libsite' ";
	}
	if ($s_media!="") {
		$s.="
		and head in (select bcode from media_mid where RESOURCE_TYPE='$d_media' )";
	}
	if ($d_media!="") {
		$s.="
		and foot in (select bcode from media_mid where RESOURCE_TYPE='$d_media' )";
	}
	if ($s_media_campus!="") {
		$s.="
		and head in (select bcode from media_mid where LIBSITE='$d_media_campus' )";
	}
	if ($d_media_campus!="") {
		$s.="
		and foot in (select bcode from media_mid where LIBSITE='$d_media_campus' )";
	}
	if ($s_gate_gate!="") {
		$s.="
		and head ='$s_gate_gate' ";
	}
	if ($d_gate_gate!="") {
		$s.="
		and foot ='$d_gate_gate' ";
	}
	if (@count($limithrs)>0) {
		@reset($limithrs);
		$s.="
		and (0 ";
		while (list($k,$v)=each($limithrs)) {
			$s.=" or floor(FROM_UNIXTIME(dt,'%H'))=$v
			";
		}
		$s.=" ) ";
	}
	if (@count($limitdate)>0) {
		@reset($limitdate);
		$s.="
		and (0 ";
		while (list($k,$v)=each($limitdate)) {
			//$s.=" or floor(FROM_UNIXTIME(dt,'%d'))=$v 			";
			$s.=" or dat=$v 
			";
		}
		$s.=" ) ";
	}

	if (@count($limitmon)>0) {
		@reset($limitmon);
		$s.="
		and (0 ";
		while (list($k,$v)=each($limitmon)) {
			//$s.=" or floor(FROM_UNIXTIME(dt,'%m'))=$v 			";
			$s.=" or mon=$v 
			";
		}
		$s.=" ) ";
	}
	if ($limityea!="") {
		$s.="
		and yea ='".($limityea-543)."' ";
	}
	$s=tmq($s);
	echo number_format(tmq_num_rows($s));
	?></td>
</tr>
</table><?php 

?>
<?php  foot(); ?>