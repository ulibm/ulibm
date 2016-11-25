<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");


?><TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="working.midinfo.php">
<TR>
	<TD class=table_head><?php  echo getlang("กรุณากรอกรหัสบาร์โค้ดวัสดุ::l::Please enter media's barcode");?></TD>
	<TD class=table_td> <INPUT TYPE="text" NAME="mediabarcode" ID="mediabarcode" value="<?php  echo $mediabarcode?>"> <INPUT TYPE="submit" value=" OK "></TD>
</TR>
</FORM><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('mediabarcode').select();
//-->
</SCRIPT>
</TABLE>
<?php 
if ($mediabarcode!="") {
	$tmp=tmq("select * from media_mid where bcode='$mediabarcode' ");
	if (tmq_num_rows($tmp)!=1) {
		localdisplayerror("ไม่พบวัสดุบาร์โค้ดนี้::l::Barcode not found");
		die;	
	}
	$tmp=tmq_fetch_array($tmp);
	?>
	<TABLE class=table_border width=100% align=center>

	<TR>
		<TD class=table_head><?php  echo getlang("ประเภทวัสดุ::l::Resource Type");?></TD>
		<TD class=table_td><?php 
	$s=tmq("select * from media_type where code='$tmp[RESOURCE_TYPE]' ");	
	$s=tmq_fetch_array($s);
	echo getlang($s[name]);?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("เลขทะเบียน::l::เลขทะเบียน");?></TD>
		<TD class=table_td><?php  echo $tmp[tabean];?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("Note");?></TD>
		<TD class=table_td><?php  echo $tmp[note];?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("สถานะ::l::Status");?></TD>
		<TD class=table_td><?php 
	if ($tmp[status]=='') {
		echo getlang("ปกติ::l::Normal");
	} else {
		$s=tmq("select * from media_mid_status  where code='$tmp[status]' ");	
		$s=tmq_fetch_array($s);
		echo getlang($s[name]);
		echo " (";
		if ($s[iscancheckout]=="no") {
			echo getlang("ยืมออกไม่ได้::l::Cannot checkout");
		} else {
			echo getlang("ยืมออกได้::l::Can checkout");
		}
		echo " )";
	}
	?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("สาขาห้องสมุด::l::Library Campus");?></TD>
		<TD class=table_td><?php  echo get_libsite_name($tmp[libsite]);?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("ชั้นเก็บ::l::Shelf");?></TD>
		<TD class=table_td><?php 
	$s=tmq("select * from media_place where code='$tmp[place]' ");	
	$s=tmq_fetch_array($s);
	echo getlang($s[name]);
	?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("การยืมใช้ในห้องสมุด::l::Use in library");?></TD>
		<TD class=table_td><?php 
		$s=tmq("select * from useinsidelib where bcode='$tmp[bcode]'  ");
	if (tmq_num_rows($s)!=0) {
		$s=tmq_fetch_array($s);
		echo getlang("ถูกยืม โดย::l::Checkedout By")." ".get_member_name($s[memid]);
		?><TABLE width=100% class=table_border>
		<TR>
			<TD class=table_head><?php  echo getlang("วันยืม::l::Checkout date");?></TD>
			<TD><?php  echo ymd_datestr($s[dt]);;?>  <?php  echo ymd_ago($s[dt]);;?> </TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("โดย::l::By");?></TD>
			<TD><?php  echo get_library_name($s[loginid])?> </TD>
		</TR>
		
		</TABLE><?php 		
	} else {
		echo getlang("ไม่ถูกยืม::l::Available");
	}
	?>
</TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("การยืม::l::Checkout info");?></TD>
		<TD class=table_td><?php  
	$s=tmq("select * from checkout where mediaId='$tmp[bcode]' ");	
	if (tmq_num_rows($s)!=0) {
		$s=tmq_fetch_array($s);
		echo getlang("ถูกยืม โดย::l::Checkedout By")." ".get_member_name($s[hold]);
		?><TABLE width=100% class=table_border>
		<TR>
			<TD class=table_head><?php  echo getlang("วันยืม::l::Checkout date");?></TD>
			<TD><?php  echo $s[sdat]." " . $thaimonstr[$s[smon]]." " . $s[syea];?></TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("วันส่ง::l::return date");?></TD>
			<TD><?php  echo $s[edat]." " . $thaimonstr[$s[emon]]." " . $s[eyea];?></TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("การจองต่อ::l::Request");?></TD>
			<TD><?php  
		if ($s[request]=="") {
			echo getlang("ไม่มีการจอง::l::No Request");
		} else {
			echo getlang("จอง โดย::l::Request By")." ".get_member_name($s[request]);
		}
		?></TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("การยืมต่อ::l::Renew");?></TD>
			<TD><?php  
		$membertype=tmq("select * from member where UserAdminID='$s[hold]' ");
		$membertype=tfa($membertype);
		$maxrenew=tmq("select * from checkout_rule where member_type='$membertype[type]' and media_type='$s[RESOURCE_TYPE]' and libsite='$LIBSITE' ");
		$maxrenew=tfa($maxrenew);
			echo getlang("ยืมต่อ ($s[renewcount]/".$maxrenew[renew].") ครั้ง::l::Renew ($s[renewcount]/".$maxrenew[renew].")");
			/*
		if ($s[isrenew]=="no") {
			echo getlang("ยังไม่ยืมต่อ::l::No Renew");
		} else {
			echo getlang("ยืมต่อแล้ว::l::Renewed");
		}*/
		?></TD>
		</TR>
		</TABLE><?php 
	} else {
		echo getlang("ไม่ถูกยืม::l::Not checked out");

	$hrs=getval("config","timetocirputtoshelf");

	if (floor($tmp[lastcheckin]+(60*60*$hrs))>time()) {
		 echo "<font color='#cc3333'><i>*";
		 echo getlang("เพิ่งรับคืน::l::At circulation desk");
		 echo "</i></font>";
	}
	}
	?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("ฉบับที่::l::Copy.");?></TD>
		<TD class=table_td><?php  echo $tmp[inumber];?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("ราคา::l::Price");?></TD>
		<TD class=table_td><?php  echo $tmp[price];?></TD>
	</TR>
	
	<TR>
		<TD class=table_head colspan=2><?php 
	echo getlang("ข้อมูล Bib::l::Bib info");
	?></TD>
	</TR>
	<TR>
		<TD class=table_td colspan=2><?php 
	echo html_displaymedia($tmp[pid]);	
	?></TD>
	</TR>
	</TABLE>
	
	<?php 
		
$tbname="media_mid";

$dsp[2][text]=getlang("ประวัติการยืม::l::Checkout history");;
$dsp[2][field]="memid";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_detail";
/*
$dsp[3][text]="อนุญาต::l::Granted";
$dsp[3][field]="granted";
$dsp[3][width]="2%";
$dsp[3][filter]="switchsingle";


*/

function local_detail($wh) {
	//printr($wh);
	$s="Barcode=$wh[bcode]
	 (".get_media_type($wh[RESOURCE_TYPE]).")<BR>
	 <B>".getlang("เก็บไว้ที่::l::Shelf") ."</B>:".get_itemplace_name($wh[place])."
	 <B>".getlang("เป็นของห้องสมุด::l::campus") ."</B>:".get_libsite_name($wh[libsite])."<FONT class=smaller> 
	<I>$wh[adminnote]</I><BR>";
	$sc=tmq("select * from stathist_checkout_member_media  where foot='$wh[bcode]' order by dt  ");
	if (tmq_num_rows($sc)==0) {
		$s.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -".getlang("ไม่มีข้อมูลการถูกยืมออก::l::No check out history")." -<BR>";
	}
	while ($scr=tmq_fetch_array($sc)) {
		$s.=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".getlang("ถูกยืมโดย::l::Checked out by ")."::".get_member_name($scr[head])." ($scr[head]) " .getlang("เมื่อ::l::Since")." ".ymd_datestr($scr[dt])." ".ymd_ago($scr[dt])."<BR>";
	}
	$s.="</FONT>";

	return $s;
}

fixform_tablelister($tbname," pid='$tmp[pid]' ",$dsp,"no","no","no","mediabarcode=$mediabarcode",$c);
}
?>	<CENTER><?php  html_label("b",$tmp[pid]);?></CENTER>
