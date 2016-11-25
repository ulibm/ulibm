<?php 
	; 
		ini_set("max_execution_time",600);
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_mem";
        mn_lib();

			pagesection(getlang("นำเข้าข้อมูลสมาชิก โดยการคัดลอกและวาง::l::Import Member Records by copy and paste"));		
		$importFilename=$file;
		/** Include path **/
?><center><?php
if ($submitit=="yes") {
$tmp=explodenewline($xlsdata);
$tmp=arr_filter_remnull($tmp);
if (count($tmp)==0) {
   html_dialog("","ไม่พบข้อมูลที่วาง");
} else {
   @reset($tmp);
   $i=0;$e=0;
   while (list($k,$v)=each($tmp)) {
      $va=explode("\t",$v);
      $barcode=trim("$va[0]");
   	$name=trim("$va[1]")." ".trim("$va[2]")." ".trim("$va[3]")." ".trim("$va[4]")." ".trim("$va[5]")." ".trim("$va[6]")." ".trim("$va[7]")." ".trim("$va[8]")." ".trim("$va[9]");
   	$name=trim($name);
   	$name=addslashes($name);
   	$barcode=addslashes($barcode);
   	$schk=tmq("select UserAdminID from member where UserAdminID='$barcode' ",false);
   	if (tnr($schk)!=0 || trim($barcode)=="" || trim($name)=="") {
   		echo "<FONT COLOR=#737373>ทำการข้ามรายการ [$barcode-$name], บาร์โค้ดซ้ำหรือเป็นค่าว่าง หรือ ชื่อสมาชิกเป็นค่าว่าง</FONT><BR>";
   		$e++;
   	} else {
   		$i++;
   		$sql="insert into member set
   		UserAdminID='$barcode',
   		UserAdminName='$name',
   		Password='$barcode',
   		type='$mem_type',
   		room='$to_room',
   		libsite='$libsite'
   		";
   		tmq($sql);
      }
   }
   ?>
   <B><?php  echo getlang("ผลการนำเข้า::l::Import result"); ?></B><BR><?php  echo getlang("นำเข้าสำเร็จ::l::Success"); ?> 
<?php  echo number_format($i);?> <?php  echo getlang("รายการ ::l::records "); ?>  (<?php  echo getlang("ผิดพลาด::l::Error"); ?> 
<?php  echo number_format($e);?> <?php  echo getlang("ครั้ง::l::times"); ?>)<BR>
<BR><BR>
<a href="<?php echo $PHP_SELF;?>" class=a_btn>Back</a></center><?php
foot();
die;
}
}

html_dialog("",getlang("คัดลอกข้อมูลมาจาก Microsoft Excel แล้วนำข้อมูลมาวางลงในที่ว่างด้านล่าง <BR>โดยให้คอลัมน์แรกเป็นบาร์โค้ดของสมาชิก ส่วนคอลัมน์ต่อ ๆ มาจะรวมอยู่ในข้อมูล ชื่อและนามสกุล::l::
Copy data from Microsoft Excel and paste in textarea below<BR>First column is member's barcode, the rest of columns will use as member's name"));

?>
<FORM METHOD=POST ACTION="<?php echo $PHP_SELF;?>">

<table border="0" cellspacing="1" cellpadding="3" align=center width=<?php echo $_TBWIDTH;?> >
<tr><td align=center>
<?php echo getlang("ตัวอย่าง::l::Examples");?>
<table align=center width=800><tr valign=top><td align=center><img src=ex1.png width=350></td><td align=center><img src=ex2.png width=300></td></tr></table>

<textarea name="xlsdata" style="width: 800px;height: 300px"></textarea>
</td></tr>
</table>

<BR><BR><TABLE align=center>
<TR valign=top>
	<TD><?php  echo getlang("เมื่ออิมพอร์ทแล้ว จะให้สมาชิกอยู่ในห้องใด::l::Room to be store these member"); ?></TD>
	<TD><?php 
	form_room("to_room",$to_room,"yes");
	?></TD>
</TR><TR valign=top>
	<TD><?php  echo getlang("ประเภทสมาชิกที่จะกำหนดให้::l::Member type for these member"); ?></TD>
	<TD>
	<SELECT NAME="mem_type">
	<?php 
	$s=tmq("select * from member_type order by descr");
	while ($r=tmq_fetch_array($s)) {
		echo "<option value='$r[type]' >$r[descr]";
	}
	?>
	</SELECT><BR>
	</TD>
</TR>
<TR>
	<TD><?php  echo getlang("เป็นสมาชิกของห้องสมุดใด::l::Campus of these member"); ?></TD>
	<TD>
	<?php 
	frm_libsite("libsite");
	?></TD>
</TR>
	<TR>
	<TD align=right><INPUT TYPE="reset" value=" Back " onclick="self.location='index.php?file=<?php  echo $file?>' "></TD>
	<TD><INPUT TYPE="submit" value=" Import "></TD>
</TR>
</TABLE>
<INPUT TYPE="hidden" NAME="submitit" value="yes">
</FORM>

<?php 

//print_r($data);
//print_r($data->formatRecords);


foot();
?>
