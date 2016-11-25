<?php 
    ;
include ("../inc/config.inc.php");
include("_REQPERM.php");
	html_start();
	loginchk_lib();
?>          <form name = "form1" method = "post" action = "<?php echo $dcrURL?>library.mst/tempadd.php" enctype="multipart/form-data">
                                    <table width = "100%" border = "0" cellspacing = "1" cellpadding = "4" align = "center">
 <tr bgcolor = "#f3f3f3">
	<td width = "27%"  class=table_head>
	<font face = "MS Sans Serif" size = "2"> <?php  echo getlang("รหัสบาร์โค้ด::l::Barcode ID"); ?>
	* <br> </font></td>
	<td width = "73%">
	<font face = "MS Sans Serif" size = "2"><input type = text name = "UserAdminID" ID='UserAdminID'  value="<?php  echo $ov[UserAdminID]?>"
	onkeyup="timeoutman('bcchecker',this);"	
	onkeydown="return localdisablereturn(event,this);"
		onmousedown="getobj('bcchecker').src='<?php  echo $dcrURL?>library.member/bccheck.php?bc='+this.value;return localdisablereturn(event,this);"			
	>
			<img border=0 align=absmiddle src="<?php  echo $dcrURL?>neoimg/favbadd16.png" style="cursor: hand; cursor: pointer;" onclick="getobj('bcchecker').src='<?php  echo $dcrURL?>library.member/getnextbc.php?parentid=x<?php  echo randid();?>'" > 
<SCRIPT LANGUAGE="JavaScript">
<!--
function localdisablereturn(event){
	if (event.keyCode==13) {
		return false;
	}
	return true;
}//-->
</SCRIPT>
			 <input type=hidden name = "Password" size=15 ID="PasswordID1"  value="<?php  echo $ov[Password]?>"> Password: <div ID=PasswordID2 style="display:inline; font-weight: bold;"></div> </font></td>
	</tr>
  <tr bgcolor = "#f3f3f3">
	<td class=table_head>
<script>
function timeoutman(wh,whthis) {
if (whthis.timeoutvalue!=undefined) {
  clearTimeout(whthis.timeoutvalue);
}
	whthis.timeoutvalue=setTimeout("getobj('bcchecker').src='<?php  echo $dcrURL?>library.member/bccheck.php?bc="+whthis.value+"'; ",1000);
	//alert("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';");
}
function localcopypassword() {
	getobj('PasswordID1').value=getobj('UserAdminID').value
	getobj('PasswordID2').innerHTML=getobj('UserAdminID').value
}
setInterval("localcopypassword();",250);
</script>
</td><td class=table_td><iframe src="" width=400 height=25 frameborder=0 SCROLLING=NO ID='bcchecker'></iframe></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
	<td class=table_head>
		<font face = "MS Sans Serif" size = "2"> <?php  echo getlang("ชื่อ-สกุล::l::Name"); ?> * <br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2">
		
	<input type = text name = "UserAdminName" ID="UserAdminName" value="<?php  echo $ov[UserAdminName]?>"> 
	<img align=absmiddle border=0 src="../neoimg/View.gif" style="cursor: hand; cursor: pointer;; "
	onclick="tmp=getobj('UserAdminName');window.open('DBddal.php?keyword='+tmp.value,'popfindmember')"
	>
	<?php  echo getlang("ประเภท::l::Type"); 
		$result=tmq("select * from member_type where type='temp' ");
		if (tnr($result)==0) {
		    tmq("INSERT INTO `member_type` ( `type`, `descr`, `limithold`, `maxfine`, `grant_room`) VALUES('temp', 'สมาชิกชั่วคราว::l::Temp Member', 0, 0, 'no');");
		    $result=tmq("select * from member_type where type='temp' ");
		}
		$result=tfa($result);
	?> 
	<input type="hidden" name="type" value="temp">
	<b><?php  echo getlang($result[descr]);?></b></font></td>
</tr>
 <tr bgcolor = "#f3f3f3">
	<td  class=table_head><B>
	<font face = "MS Sans Serif" size = "2" color=darkred> CREDIT</font></B></td>
	<td width = "73%">
	<font face = "MS Sans Serif" size = "2"><input type = text name = "credit" value=0> 
	 <label><INPUT TYPE="checkbox" NAME="isaddcreditfee" style="border:0" value="yes" checked> <?php 
	echo getlang("เพิ่มค่าใช้จ่ายสำหรับเครดิตอัตโนมัติ::l::add Credit fee automatically");
	?> </label>
	</font></td>
	</tr>
<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("วันหมดอายุ::l::Expire date"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2">
			<?php 
			$expdt=time()+(60*60*24*floor(getval("_SETTING","circulation_tempmemdays")));
			$fixdat=floor(date("j",$expdt));
			$fixmon=floor(date("n",$expdt));
			$fixyea=floor(date("Y",$expdt)+543);
			//echo "[$fixdat/$fixmon/$fixyea]";
			//echo ymd_datestr($expdt);
			?>
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
				?></select> <br>* <?php  echo getlang("ไม่ใส่หมายถึงไม่กำหนด::l::Don't fill if don't want specific"); ?> </font>
				
		<font class=smaller2><?php  echo getlang("หรือเลือกจากรายการ::l::or choose from template");?></font>
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
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("คำนำหน้า::l::Prefix"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><input type = text ID = 'xxx2' name = "pref"  value="<?php  echo $ov[prefi]?>"> <br>
			  <?php 
$qn=getval("_SETTING","circulation_memprefix");
$qn=explode(",",$qn);
$qn=arr_filter_remnull($qn);
//printr($qn);
@reset($qn);
while (list($qnk,$qnv)=each($qn)) {
	?><a href="javascript:void(null);" onclick="tmp=getobj('xxx2'); tmp.value='<?php  echo stripslashes($qnv);?>'; " class="smaller2 a_btn"><?php  echo stripslashes($qnv);?></a> <?php 
}
	  ?>	
			</font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo $_ROOMWORD; ?> </font></td>
		<td width = "73%">
	<?php  
		$result=tmq("select * from room where istemp='YES' ");
		if (tnr($result)==0) {
		    tmq("INSERT INTO `room` ( `name`, `rid`, `editable`, `istemp`, `ishide`, `pid`) VALUES( 'สมาชิกชั่วคราว::l::Temp Member', '0', 'NO', 'YES', 'no', 'default');");
		    $result=tmq("select * from room where istemp='YES' ");
		}		
		$result=tfa($result);
	?> 
	<input type="hidden" name="room" value="<?php  echo ($result[id]);?>">
			<b><?php  echo get_room_name($result[id]);?></b>
			
		<?php  echo $_FACULTYWORD; ?>	&nbsp; <?php  
		$result=tmq("select * from major where istemp='YES' ");
		if (tnr($result)==0) {
		    tmq("INSERT INTO `major` ( `name`, `rid`, `delable`, `istemp`) VALUES('บัตรสำรอง', '0', 'NO', 'YES');");
			$result=tmq("select * from major where istemp='YES' ");
		}	
		$result=tfa($result);
	?> 
	<input type="hidden" name="major" value="<?php  echo ($result[id]);?>">
			<b><?php  echo getlang($result[name]);?></b>	
			</td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("เบอร์โทรศัพท์::l::Tel."); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><input type = text name = "tel"  value="<?php  echo $ov[tel]?>"> 
			<?php  echo getlang("อีเมล์::l::E-mail"); ?> <input type = text name = "email"  value="<?php  echo $ov[email]?>"> </font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ที่อยู่::l::Address"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><input type = text name = "address" size = 50  value="<?php  echo $ov[address]?>"> </font></td>
	</tr>
	 <tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ที่อยู่ บรรทัดที่ 2::l::Address line 2"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><input type = text name = "address2" size = 50  value="<?php  echo $ov[address2]?>"> </font></td>
	</tr>
   <tr bgcolor = "#f3f3f3">
		<td  class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("รายละเอียดอื่น::l::Note"); ?> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><input type = text name = "descr" size = 50  value="<?php  echo $ov[note]?>"> </font></td>
	</tr>
<?php 

$cust=tmq("select * from member_customfield where isshow='yes' order by fid ");

while ($custr=tfa($cust)) {
?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang($custr[name]);?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
	if ($ov[$custr[fid]]!="") {
		$custr[defval]=$ov[$custr[fid]];
	}
	form_quickedit($custr[fid],$custr[defval],$custr[ftype]);	

?><!-- <input type = text name = "<?php  echo $custr[fid];?>" size = 57> --></TD>
	</TR>
<?php 
}?>
<tr bgcolor = "#f3f3f3">
	<td  class=table_head>
		<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ภาพของสมาชิก::l::Member's photo"); 
@unlink("./ulibcamcap-newmem/file/temp$useradminid.jpg");
?> </font></td>
	<td width = "73%">
		<input type="file" name="updatephoto" />  <A HREF="javascript:void(null)" onclick="window.open('./ulibcamcap-newmem/index.php?id=<?php  echo $ID?>','ulibcamcapwin','width=750,height=400')"><?php  echo getlang("ถ่ายภาพจากกล้อง::l::Capture from webcam")?></A>
		<br />
																				<font class=smaller>
<?php  echo getlang("ไฟล์ JPG เท่านั้น ขนาดปกติคือ กว้าง 128 สูง 144<br /> การจัดเก็บจะจัดเก็บภาพตามการตั้งค่าภาพของสมาชิก<br />
 ภาพใหม่จะทับภาพเก่า
::l::JPG file only default size is 128w x 144h,<br /> photo will be store by member's photo setting<br />
new photo will overwrite old photo.");?></font></td>
</tr>

		<tr bgcolor = "#e3e3e3">
			<td width = "27%" valign = "top">
	&nbsp;</td>
			<td width = "73%">
				<font face = "MS Sans Serif" size = "2">
				<input type = "submit" name = "Submit2" value = "<?php  echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
				<input type = "hidden" name = "remoteedit" value = "<?php  echo $remoteedit;?>">
				<input type = "hidden" name = "sid" value = "<?php  echo $sid;?>">
				<input type = "hidden" name = "backto" value = "<?php  echo $dcrURL;?>circulation/working.extmems.php">
				<input type = "hidden" name = "LibID" value = "<?php  echo $LibID;?>">
				</font></td>
		</tr>
</table>
 </form>