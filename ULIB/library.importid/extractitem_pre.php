<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?>
<?php 
$itemlocatetag=getval("MARC","itemlocatetag");
?><BR>
	<TABLE width=780 align=center><FORM METHOD=POST ACTION="extractitem.php">
		
<TR bgcolor=f2f2f2>
	<TD width=40%><?php  echo getlang("นำเข้าไอเทมในแท็ก $itemlocatetag ::l::Import Items in tag $itemlocatetag"); ?></TD>
	<TD>
	<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID;?>">
	<INPUT TYPE="hidden" NAME="setconfig" value="yes">
	<INPUT TYPE="hidden" NAME="importitem[itemlocatetag]" value="<?php  echo $itemlocatetag;?>">
	</TD>
</TR>

<TR>
	<TD colspan=2><?php  echo getlang("โปรแกรมจะสร้าง Item ให้อัตโนมัติ ตามรายละเอียดด้านล่าง::l::Importer will create media's items automatically with following data."); ?></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("เป็นวัสดุฯของห้องสมุดใด::l::Campus of these Material"); ?></TD>
	<TD>
	<?php 
	frm_libsite("importitem[libsite]");
	?></TD>
</TR>


<TR valign=top>

<TD class=table_head><?php  echo getlang("เปลี่ยนสถานะเป็น::l::Item's  Status "); ?></B> </TD>
			<TD><SELECT NAME="importitem[status]">
<?php 
	echo "<option value=''>ปกติ ";
$s=tmq("select * from media_mid_status order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[code]'>".getlang($r[name])." ($r[code]) ";
}
?> 
			</SELECT></TD>
		</TR>

	<TR>
			<TD class=table_head><?php  echo getlang("เปลี่ยนสถานที่จัดเก็บ::l::Item's  Shelf"); ?></TD>
			<TD><?php frm_itemplace("importitem[itemplace]","NONE","NO");?></TD>
	</TR>
	<TR>
			<TD class=table_head><?php  echo getlang("หากบาร์โค้ดซ้ำ::l::On duplicate barcode"); ?></TD>
			<TD><INPUT TYPE="radio" NAME="importitem[onbcdup]" value="ignore" style='border-width:0' checked> <?php  echo getlang("ไม่เพิ่ม::l::Ignore");?> 
			<INPUT TYPE="radio" NAME="importitem[onbcdup]" value="add" style='border-width:0'> <?php  echo getlang("เพิ่มเป็นบาร์โค้ดซ้ำ::l::Force Add");?> 
			<INPUT TYPE="radio" NAME="importitem[onbcdup]" value="emptybc" style='border-width:0'> <?php  echo getlang("เพิ่มบาร์โค้ดว่าง::l::Add Empty Barcode");?> </TD>
	</TR>
	<TR>
			<TD class=table_head><?php  echo getlang("ทำอย่างไรกับ $itemlocatetag::l::What to do with $itemlocatetag"); ?></TD>
			<TD><INPUT TYPE="radio" NAME="importitem[doafter]" value="delete" style='border-width:0' checked> <?php  echo getlang("ลบทิ้ง::l::Delete");?> 
			<INPUT TYPE="radio" NAME="importitem[doafter]" value="ignore" style='border-width:0'> <?php  echo getlang("ไม่ทำอะไร::l::Ignore");?> </TD>
	</TR>
	<TR>
			<TD class=table_head><?php  echo getlang("ประเภทวัสดุฯ::l::Item's Type"); ?></TD>
			<TD>** <?php  echo getlang("ตาม Subfields L ซึ่งคุณสามารถจัดการได้ภายหลังกับระบบจัดการไอเทมวัสดุ::l::Specific in Subfield L , which you can manage it again with 'media item management'"); ?><BR>
			** <?php  echo getlang("คุณสามารถตรวจสอบความถูกต้องอีกครั้งได้จากระบบตรวจสอบความถูกต้องของข้อมูล::l::You can re-verify the correction in system data verify module"); ?></TD>
	</TR>
<TR>
	<TD colspan=2 align=center><INPUT TYPE="submit" value="<?php  echo getlang("ลงมือ::l::Submit");?>">  :: <A HREF="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A></TD>
</TR>
	</FORM>
</TABLE>
<CENTER><BR></CENTER>
  <?php 
		foot();   
	   ?>