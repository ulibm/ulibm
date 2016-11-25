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
}

t("select","*");
t("from","member");
t("where","UserAdminID","=","$ID");
$OTHERLIBSITE=library_gotpermission("managemember-otherlib");
			if ($OTHERLIBSITE != true) {
				t("where","and libsite","=","$LIBSITE");
			}
                $result=t("e");

                $Num=tnr($result);
                if ($Num == 0)
                    {

                    echo "<CENTER><h1><br>No Member ID $ID</h1></CENTER><BR><BR>";
					foot();
                    exit;
                    }

                    $row=tmq_fetch_array($result);
                    $UserAdminID=$row["UserAdminID"];
                    $Password=$row["Password"];
                    $UserAdminName=$row["UserAdminName"];
                    $email=$row["email"];
                    $descr=$row["descr"];
                    $type=$row["type"];
                    $statusactive=$row["statusactive"];
                    $tel=$row["tel"];
                    $address=stripslashes($row["address"]);
                    $address2=stripslashes($row["address2"]);
                    $prefi=$row["prefi"];
                    $dat=$row["dat"];
                    $mon=$row["mon"];
                    $yea=$row["yea"];
                    $room=$row["room"];
                    $major=$row["major"];
                    $picture=$row["picture"];
					//printr($row);
            ?>


                            <table width = "<?php 
if ($remoteedit=="yes") {
   echo "100%";
} else {
   echo $_TBWIDTH;
}
                            ?>" align=center border = "0">
<form method = "post" action = "editMediaAction.php" name = "webForm" enctype="multipart/form-data">                                <tr>
                                    <td class=table_head>
                                        <b><font color = "#FF0000"></font></b> <?php  echo getlang("บาร์โค้ด::l::Barcode"); ?> :
                                    </td>
                                    <td class=table_td><?php  echo "$ID"; ?>
                                    </td>
                                </tr>
                                <tr>

<tr>
	<td class=table_head>
		<b><font color = "#FF0000">*</font></b> <?php  echo getlang("รหัสผ่าน::l::Password"); ?> :
	</td>
	<td class=table_td>
		<input type = "text" name = "Password" size = "20" value = "<?php echo "$Password";?>">
	</td>
</tr>
<tr>
<td  class=table_head>
	<b><font color = "#FF0000">*</font></b> <?php  echo getlang("ชื่อ-สกุล::l::Name"); ?> :
</td>
<td class=table_td>
	<input type = "text" name = "UserAdminName" size = "25" value = "<?php echo "$UserAdminName";?>">

 <?php  echo getlang("ประเภท::l::Member type"); ?> :

                                            <select name = 'type'>
											
<?php 
$s=tmq("select * from member_type where type='$type' ");
if (tmq_num_rows($s)!=0) {
	$s=tmq_fetch_array($s);
	echo "<option value='$type' selected>".getlang($s[descr]);
} else {
	echo "<option value='' selected>ยังไม่ระบุ";
}
?><?php 
                    $sql1="SELECT *  FROM member_type";
                    $result=tmq( $sql1);
                    while ($rowx=tmq_fetch_array($result))
                        {
                        $ID3 = $rowx[type];
                        $descr=getlang($rowx[descr]);

                        echo "<option value='$ID3' $aa>$descr";
                        }
                ?></select>

</td>
</tr>
 <tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle" class=table_head><B>
	<font face = "MS Sans Serif" size = "2" color=darkred> CREDIT</font></B></td>
	<td width = "73%">
<input type = text name = "credit" value="<?php  echo $row[credit]?>">
	 	<label><INPUT TYPE="checkbox" NAME="isaddcreditfee" style="border:0" value="yes" checked> <?php 
	echo getlang("เพิ่มค่าใช้จ่ายสำหรับเครดิตอัตโนมัติ::l::add Credit fee automatically");
	?> </label></td>
</tr>

                                    <tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ห้องสมุด::l::Library campus"); ?> :
                                        </td>
                                        <td class=table_td>
                                            <B><?php echo get_libsite_name($row[libsite]);;?></B>
                                        </td>
                                    </tr>
									<tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo getlang("อีเมล์::l::E-mail"); ?> :
                                        </td>
                                        <td class=table_td>
                                            <input type = "text" name = "email" size = "50" value = "<?php echo "$email";   ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ที่อยู่::l::Address"); ?> :
                                        </td>
                                        <td class=table_td>
                                            <input type = "text" name = "address" size = "50" value = "<?php echo "$address";?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ที่อยู่ บรรทัดที่ 2::l::Address line 2"); ?> :
                                        </td>
                                        <td class=table_td>
                                            <input type = "text" name = "address2" size = "50" value = "<?php echo "$address2";?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo getlang("เบอร์โทรศัพท์::l::Tel."); ?> :
                                        </td>
                                        <td class=table_td>
                                            <input type = "text" name = "tel" size = "50" value = "<?php echo "$tel"; ?>">
                                        </td>
                                    </tr>
	<tr>
		<td class=table_head>
			<b><font color = "#FF0000">*</font></b> <?php  echo getlang("วันที่หมดอายุสมาชิก::l::Expire [date]"); ?> :
		</td>
		<td class=table_td>
		<SELECT NAME="dat" ID="expdat">
		<?php 
	if ($dat==0) {
		echo "<option value='' selected>-";
	} else {
		echo "<option value='' >-";
		echo "<option value='$dat' selected>$dat";
	}
		for ($i=1;$i<=31;$i++) {
			echo "<option value='$i'>$i ";
		}
		?>
		</SELECT>
		
		<SELECT NAME="mon" ID="expmon">
		<?php 
	if ($mon==0) {
		echo "<option value='' selected>-";
	} else {
		echo "<option value='' >-";
		echo "<option value='$mon' selected>$thaimonstr[$mon]";
	}
		for ($i=1;$i<=12;$i++) {
			echo "<option value='$i'>$thaimonstr[$i] ";
		}
		?>
		</SELECT>

		<SELECT NAME="yea"  ID="expyea">
		<?php 

	if ($yea==0) {
		echo "<option value='' selected>-";
	} else {
		echo "<option value='' >-";
		echo "<option value='$yea' selected>$yea";
	}
	for ($i=getval('FORM','LIST_YEAR_START');$i<=getval('FORM','LIST_YEAR_END');$i++) {
		echo "<option value='$i'>$i ";
	}
		?>
		</SELECT>
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
	</script>
		</td>
	</tr>


                                    <tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <B style="color: darkred"><?php  echo getlang("รายละเอียดอื่น::l::Note"); ?></B> :
                                        </td>
                                        <td class=table_td><TEXTAREA style="; border: 1px darkred solid" NAME="descr" ROWS="3" COLS="55"><?php echo "$row[descr]"; ?></TEXTAREA>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b><?php  echo getlang(" สถานะ ::l::Status"); ?>:
                                        </td>
                                        <td class=table_td>
                                            <input type = "text" name = "statusactive" ID = "xxx" size = "10" value = "<?php echo "$statusactive";?>"> <small><a href = "javascript:void(null);" onclick = "xxx.value='normal'; return false; ">normal</a>,<a href = "javascript:void(null);" onclick = "xxx.value='abnormal'; return false; ">abnormal</a><BR>
<?php  echo getlang(" หากไม่อยู่ในสถานะ normal จะไม่สามารถทำการล็อกอินเข้าระบบได้ ::l::if not set to normal member will be not able to checkout or login"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=table_head>
                                            <b><font color = "#FF0000">*</font></b><?php  echo getlang("คำนำหน้า::l::Prefix"); ?>  :
                                        </td>
                                        <td class=table_td>
                                            <input type = "text" name = "prefi" ID = "xxx2" size = "10" value = "<?php 
echo "$prefi";
?>"><BR><?php 
$qn=getval("_SETTING","circulation_memprefix");
$qn=explode(",",$qn);
$qn=arr_filter_remnull($qn);
//printr($qn);
@reset($qn);
while (list($qnk,$qnv)=each($qn)) {
	?><a href="javascript:void(null);" onclick="tmp=getobj('xxx2'); tmp.value='<?php  echo stripslashes($qnv);?>'; " class="smaller2 a_btn"><?php  echo stripslashes($qnv);?></a> <?php 
}
	  ?>		
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo $_ROOMWORD; ?> :
                                        </td>
                                        <td class=table_td> <?php  form_room("room",$room,"yes");?>
                                                   </td>
                                    </tr>
                                    <tr>
                                        <td  class=table_head>
                                            <b><font color = "#FF0000">*</font></b> <?php  echo $_FACULTYWORD; ?> :
                                        </td>
                                        <td class=table_td>
                                            <select name = 'major'>
<?php 
$s=tmq("select * from major where id='$major' ");
if (tmq_num_rows($s)!=0) {
	$s=tmq_fetch_array($s);
	echo "<option value='' >-";
	echo "<option value='$major' selected>$s[name] ";
} else {
	echo "<option value='' selected>ยังไม่ระบุ";
}
?>
<?php 
                $sql1="SELECT *  FROM major";
                $result=tmq( $sql1);
                while ($rowx=tmq_fetch_array($result))
                    {
                    $ID3 = $rowx[id];
                    $descr=$rowx[name];
                    echo "<option value='$ID3' $aa> $descr";
                    }
            ?></select>
                                        </td>
                                    </tr>

																		<?php 
$cust=tmq("select * from member_customfield where isshow='yes' order by fid");
while ($custr=tmq_fetch_array($cust)) {
?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang($custr[name]);?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
	//echo $row[$custr[fid]];
form_quickedit($custr[fid],$row[$custr[fid]],$custr[ftype]);	
?><!-- <input type = text name = "<?php  echo $custr[fid];?>" size = 57 value="<?php  echo $row[$custr[fid]]?>"> --></TD>
	</TR>
<?php 
}?>

                                    <tr>
                                        <td  class=table_head>
                                            <?php  echo getlang("อัพเดทภาพของสมาชิก::l::Update member's photo"); 		

?> :
       </td>
       <td  class=table_td><input type="file" name="updatephoto" /> <A HREF="javascript:void(null)" onclick="window.open('./ulibcamcap/index.php?id=<?php  echo $ID?>','ulibcamcapwin','width=750,height=400')"><?php  echo getlang("ถ่ายภาพจากกล้อง::l::Capture from webcam")?></A><br />
									<label><input type="checkbox" style="border:0" name="deloldphoto" value="yes"/> <?php  echo getlang("ลบภาพเก่า::l::Delete old photo");?></label>
									<br />
									<font class=smaller>
<?php  echo getlang("ไฟล์ JPG เท่านั้น ขนาดปกติคือ กว้าง 128 สูง 144<br /> การจัดเก็บจะจัดเก็บภาพตามการตั้งค่าภาพของสมาชิก<br />
 ภาพใหม่จะทับภาพเก่า
::l::JPG file only default size is 128w x 144h,<br /> photo will be store by member's photo setting<br />
new photo will overwrite old photo.");?></font>
<?php 
//if ($remoteedit!="yes") {
	?><BR><IMG SRC='<?php  echo member_pic_url($ID);?>' <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''><?php 
	if (barcodeval_get("memberpic-wheresave")=="local") {
   	$tmphtml_photofilter=member_pic_spath($ID);
   	//echo "[$tmphtml_photofilter]";
   	$tmphtml_photofilterorig=$tmphtml_photofilter;
   	$tmphtml_photofilter=str_replace($dcrs,"",$tmphtml_photofilter);
   	if (file_exists($tmphtml_photofilterorig)) {
   	  html_photofilter($tmphtml_photofilter,"",true);
   	}
	}
//}?>

                                        </td>
                                    </tr>																		
                            </table>
                            <CENTER><input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
							<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>">
							<input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>">
							<input type = "hidden" name = "remoteedit" value = "<?php  echo "$remoteedit"; ?>">
<?php 
if ($remoteedit!="yes") {
?>
<a href="DBddal.php"  class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a>
<?php 
}
	?>
							</CENTER>
</form>
            <?php 
if ($remoteedit!="yes") {
	foot();
}
?>