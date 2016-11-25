<?php  
    ;
include ("../inc/config.inc.php");
include("_REQPERM.php");
if ($remoteedit=="yes") {
	html_start();
	loginchk_lib();
} else {
	head();
	mn_lib();
}?>
<BR>                                
 <table width = "780" border = "0" cellspacing = "1" cellpadding = "4" align = "center"><form name = "form1" method = "post" action = "<?php  echo $dcrURL?>library.member/addnewDBddal.php" enctype="multipart/form-data">
 <tr bgcolor = "#f3f3f3">
	<td width = "27%"  class=table_head>
	 <?php echo getlang("รหัสบาร์โค้ด::l::Barcode ID"); ?>
	* <br> </font></td>
	<td width = "73%">
	<input type = text name = "UserAdminID" ID='UserAdminID'  value="<?php echo $ov[UserAdminID]?>"
	onkeyup="timeoutman('bcchecker',this);"	
	onkeydown="return localdisablereturn(event,this);"
		onmousedown="getobj('bcchecker').src='<?php echo $dcrURL?>library.member/bccheck.php?bc='+this.value;return localdisablereturn(event,this);"			
	>
			<img border=0 align=absmiddle src="<?php echo $dcrURL?>neoimg/favbadd16.png" style="cursor: hand; cursor: pointer;" onclick="getobj('bcchecker').src='<?php echo $dcrURL?>library.member/getnextbc.php?parentid=x<?php echo randid();?>'" > 
<SCRIPT LANGUAGE="JavaScript">
<!--
function localdisablereturn(event){
	if (event.keyCode==13) {
		return false;
	}
	return true;
}//-->
</SCRIPT>
			<img border=0 align=absmiddle src="<?php echo $dcrURL?>neoimg/Right.gif" style="cursor: hand; cursor: pointer;" onclick="getobj('PasswordID1').value=getobj('UserAdminID').value"> 	 <?php echo getlang("รหัสผ่าน::l::Password"); ?> <input type = text name = "Password" size=15 ID="PasswordID1"  value="<?php echo $ov[Password]?>"> </font></td>
	</tr>
  <tr bgcolor = "#f3f3f3">
	<td class=table_head>
<script>
function timeoutman(wh,whthis) {
if (whthis.timeoutvalue!=undefined) {
  clearTimeout(whthis.timeoutvalue);
}
	whthis.timeoutvalue=setTimeout("getobj('bcchecker').src='<?php echo $dcrURL?>library.member/bccheck.php?bc="+whthis.value+"';",1000);
	//alert("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';");
}
</script>
</td><td class=table_td><iframe src="" width=400 height=25 frameborder=0 SCROLLING=NO ID='bcchecker'></iframe></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
	<td class=table_head>
		 <?php echo getlang("ชื่อ-สกุล::l::Name"); ?> * <br> </font></td>
	<td width = "73%">	
		
	<input type = text name = "UserAdminName" ID="UserAdminName" value="<?php echo $ov[UserAdminName]?>"
		onkeyup="timeoutmandupname('bcchecker',this);"	
	onkeydown="return localdisablereturn(event,this);"
		onmousedown="getobj('dupnamechecker').src='<?php echo $dcrURL?>library.member/dupnamecheck.php?name='+this.value;return localdisablereturn(event,this);"	
	> 
	<img align=absmiddle border=0 src="../neoimg/View.gif" style="cursor: hand; cursor: pointer;; "
	onclick="tmp=getobj('UserAdminName');window.open('DBddal.php?keyword='+tmp.value,'popfindmember')"
	>
	<?php echo getlang("ประเภท::l::Type"); ?> *
<select name = type><?php  
		$result=tmq("select * from member_type");
		while ($row=tfa($result))
			{
			$sl="";
			if ($fixtype==$row[type]) {$sl="selected";}
			$ID = $row[type];
			$descr=getlang($row[descr]);
         
			echo "<option value='$ID' $sl>$descr";
			}
	?></select> </font></td>
</tr>

  <tr bgcolor = "#f3f3f3">
	<td class=table_head>
<script>
function timeoutmandupname(wh,whthis) {
if (whthis.timeoutvalue!=undefined) {
  clearTimeout(whthis.timeoutvalue);
}
	whthis.timeoutvalue=setTimeout("getobj('dupnamechecker').src='<?php echo $dcrURL?>library.member/dupnamecheck.php?name="+whthis.value+"';",1000);
	//alert("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';");
}
</script>
</td><td class=table_td><iframe src="" width=400 height=25 frameborder=0 SCROLLING=NO ID='dupnamechecker'></iframe></td>
	</tr>

 <tr bgcolor = "#f3f3f3">
	<td  class=table_head><B>
	<font face = "MS Sans Serif" size = "2" color=darkred> CREDIT</font></B></td>
	<td width = "73%">
	<input type = text name = "credit" value=0> 
	 <label><INPUT TYPE="checkbox" NAME="isaddcreditfee" style="border:0" value="yes" checked> <?php  
	echo getlang("เพิ่มค่าใช้จ่ายสำหรับเครดิตอัตโนมัติ::l::add Credit fee automatically");
	?> </label>
	</font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo getlang("วันหมดอายุ::l::Expire date"); ?><br> </font></td>
		<td width = "73%">
			
			<select name = dat ID="expdat">
				<option value = "" >กรุณาเลือก<?php  
					for ($i=1; $i <= 31; $i++)
						{
						$sl="";
						if ($fixdat==$i) {$sl="selected";}
						print "<option value='$i' $sl>$i";
						}
				?></select>
			<select name = mon ID="expmon">
				<option value = "">กรุณาเลือก<?php  
					for ($i=1; $i <= 12; $i++)
						{
						$sl="";
						if ($fixmon==$i) {$sl="selected";}
						print "<option value='$i' $sl>";
						echo $thaimonstr[$i];
						}
				?></select>
			<select name = yea ID="expyea">
				<option value = "">กรุณาเลือก<?php  
					for ($i=$_MSTARTY; $i <= $_MENDY; $i++)
						{
						$sl="";
						if ($fixyea==$i) {$sl="selected";}
						print "<option value='$i' $sl>$i";
						}
				?></select> <br>* <?php echo getlang("ไม่ใส่หมายถึงไม่กำหนด::l::Don't fill if don't want specific"); ?> </font>
				
		<font class=smaller2><?php echo getlang("หรือเลือกจากรายการ::l::or choose from template");?></font>
		<?php  
			$setp=tmq("select * from member_expireset order by dt");
			?><select name="tmp_member_expireset" class=smaller  
			onchange="member_expiresetfunc(this);">
			<?php  
			echo "<option selected value=''>-";
			while ($setpr=tfa($setp)) {
				echo "<option value='".date("Y/m/d",$setpr[dt])."'>".stripslashes($setpr[name]);;
			}
		?>
		</select>

	<script type="text/javascript">
	<!--
		function member_expiresetfunc(wh) {
			//alert(wh.value);
			ymd=wh.value;
			ymd=ymd.split("/");
			//alert(ymd);
			var curr_date = Math.floor(ymd[2]);
			var curr_month = Math.floor(ymd[1]);
			var curr_year =Math.floor(ymd[0])+543;
			//alert(curr_year);
			tmp=getobj('expdat');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_date) {
					tmp.options[i].selected=true
				}
			}
			tmp=getobj('expmon');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_month) {
					tmp.options[i].selected=true
				}
			}
			tmp=getobj('expyea');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_year) {
					tmp.options[i].selected=true
				}
			}
		}
	//-->
	</script></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo getlang("คำนำหน้า::l::Prefix"); ?><br> </font></td>
		<td width = "73%">
			<input type = text ID = 'xxx2' name = "pref"  value="<?php echo $ov[prefi]?>"> <br>
			  <?php  
$qn=getval("_SETTING","circulation_memprefix");
$qn=explode(",",$qn);
$qn=arr_filter_remnull($qn);
//printr($qn);
@reset($qn);
while (list($qnk,$qnv)=each($qn)) {
	?><a href="javascript:void(null);" onclick="tmp=getobj('xxx2'); tmp.value='<?php echo stripslashes($qnv);?>'; " class="smaller2 a_btn"><?php echo stripslashes($qnv);?></a> <?php  
}
	  ?>	
			</font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo $_ROOMWORD; ?></td>
		<td width = "73%"><?php form_room("room",$fixroom,"yes");?></td>
	</tr>
		<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo $_FACULTYWORD; ?> </font></td>
		<td width = "73%">
			
			<select name = major>
				<option value = "" selected>ไม่ระบุ<?php  
					$result=tmq("select * from major order by name");
					while ($row=tfa($result))
						{
						$sl="";
						if ($fixmajor==$row[id]) {$sl="selected";}
						$ID = $row[id];
						$descr=$row[name];
						$descr=getlang($descr);
						echo "<option value='$ID' $sl>$descr";
						}
				?></select></font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td class=table_head>
			<?php echo getlang("เบอร์โทรศัพท์::l::Tel."); ?><br> </font></td>
		<td width = "73%">
			<input type = text name = "tel"  value="<?php echo $ov[tel]?>"> 
			<?php echo getlang("อีเมล์::l::E-mail"); ?> <input type = text name = "email"  value="<?php echo $ov[email]?>"> </font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo getlang("ที่อยู่::l::Address"); ?><br> </font></td>
		<td width = "73%">
			<input type = text name = "address" size = 50  value="<?php echo $ov[address]?>"> </font></td>
	</tr>
	 <tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo getlang("ที่อยู่ บรรทัดที่ 2::l::Address line 2"); ?><br> </font></td>
		<td width = "73%">
			<input type = text name = "address2" size = 50  value="<?php echo $ov[address2]?>"> </font></td>
	</tr>
   <tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<?php echo getlang("รายละเอียดอื่น::l::Note"); ?> </font></td>
		<td width = "73%">
			<input type = text name = "descr" size = 50  value="<?php echo $ov[note]?>"> </font></td>
	</tr>
<?php  

$cust=tmq("select * from member_customfield where isshow='yes' order by fid ");

while ($custr=tfa($cust)) {
?>
	<TR>
		<TD class=table_head  <?php echo $addhtmlsizehead;?>><?php echo getlang($custr[name]);?></TD>
		<TD class=table_td <?php echo $addhtmlsize;?>><?php  
	if ($ov[$custr[fid]]!="") {
		$custr[defval]=$ov[$custr[fid]];
	}
	form_quickedit($custr[fid],$custr[defval],$custr[ftype]);	

?><!-- <input type = text name = "<?php echo $custr[fid];?>" size = 57> --></TD>
	</TR>
<?php  
}?>
<tr bgcolor = "#f3f3f3">
	<td  class=table_head>
		<?php echo getlang("ภาพของสมาชิก::l::Member's photo"); 
@unlink("./ulibcamcap-newmem/file/temp$useradminid.jpg");
?> </font></td>
	<td width = "73%">
		<input type="file" name="updatephoto" />  <A HREF="javascript:void(null)" onclick="window.open('./ulibcamcap-newmem/index.php?id=<?php echo $ID?>','ulibcamcapwin','width=750,height=400')"><?php echo getlang("ถ่ายภาพจากกล้อง::l::Capture from webcam")?></A>
		<br />
																				<font class=smaller>
<?php echo getlang("ไฟล์ JPG เท่านั้น ขนาดปกติคือ กว้าง 128 สูง 144<br /> การจัดเก็บจะจัดเก็บภาพตามการตั้งค่าภาพของสมาชิก<br />
 ภาพใหม่จะทับภาพเก่า
::l::JPG file only default size is 128w x 144h,<br /> photo will be store by member's photo setting<br />
new photo will overwrite old photo.");?></font></td>
</tr>

		<tr bgcolor = "#e3e3e3">
			<td width = "27%" valign = "top">
	&nbsp;</td>
			<td width = "73%">
				
				<input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
				<input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset"); ?>">
				<input type = "hidden" name = "remoteedit" value = "<?php echo $remoteedit;?>">
				<input type = "hidden" name = "sid" value = "<?php echo $sid;?>">
				<input type = "hidden" name = "backto" value = "<?php echo $dcrURL;?>circulation/working.extmems.php">
				<input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>">
				<?php if ($remoteedit!="yes") {?>
				<label><input type = checkbox checked name = "isback" style="border: 0px;"><?php echo getlang("กลับมาหน้านี้อีก::l::Back to this page"); ?></label> <B><A HREF="DBddal.php" class=a_btn><?php echo getlang("กลับ::l::Back"); ?></A></B>
				<?php  
		}?></font></td>
		</tr>
 </form></table>



<?php  
if ($remoteedit!="yes") {
	foot();
}
?>