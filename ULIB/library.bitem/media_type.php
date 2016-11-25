<?php 
;
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();
$now=time();

	$undotorepairroom=trim($undotorepairroom);
	if ($undotorepairroom!=0) {
		tmq("update media_mid set status='' where bcode='$undotorepairroom' limit 1 ");
	}
	
	$torepairroom=trim($torepairroom);
	if ($torepairroom!=0) {
		$dspcalln=marc_getmidcalln($torepairroom);
		tmq("update media_mid set status='repair',status_lastupdate='$now' where bcode='$torepairroom' limit 1 ");
		?>  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0" class=table_border>

		<TR>
			<TD class=table_td style="padding: 12 12 12 12 " align=center><?php echo getlang("รายการ $dspcalln [$torepairroom] ถูกบันทึกว่าส่งซ่อมแล้ว 
			<A target=_blank HREF='repairslip.php?bcode=$torepairroom'>คลิกที่นี่</A> เพื่อพิมพ์ใบปะหน้าส่งซ่อม ::l::Item $dspcalln [$torepairroom] set status to repairing, click <A HREF='repairslip.php?bcode=$torepairroom'>here</A> to print repair slip.");?> <A HREF="<?php  echo "media_type.php?undotorepairroom=$torepairroom&TYPE=$mType&MID=$MID&remotes_row=$remotes_row";?>">Undo</A></TD>
		</TR>
		</TABLE><?php 
	}
	 ?>
  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
         
<a href="../library.book/DBbook.php?linkfrom=<?php echo $MID?>&startrow=<?php echo $remotes_row?>" class=a_btn><?php  echo getlang("กลับหน้าฐานข้อมูลวัสดุฯ::l::Back to Material database"); ?>  </a>
<A HREF="../library.book/addDBbook.php?startrow=<?php echo $remotes_row?>"  class=a_btn><?php  echo getlang("แบบฟอร์มเพิ่มทรัพยากรใหม่::l::Key new record"); ?></A> 
<A HREF="../library.book/easyadd.php?startrow=<?php echo $remotes_row?>"  class=a_btn><?php  echo getlang("แบบฟอร์ม (Non Marc)::l::Key new (Non Marc)"); ?></A> 
<A HREF="../library.book/parsemarc.php" class=a_btn><?php  echo getlang("วาง MARC::l::Parse MARC");?></A>

<?php pagesection(getlang("กำลังจัดการไอเทมของวัสดุฯ::l::Managing Items of Material"));?>
</TD>
</TR>
</TABLE>
<TABLE width="770" border="0" cellspacing="1" cellpadding="3" align=center>
<TR>
	<TD><?php 
  res_brief_dsp($MID);	
	?></TD>
</TR>
</TABLE><CENTER>
<?php 
	$module=get_itemmodule($MID);
	if ($module=="item") {
		include("book_module.php");
	} elseif ($module=="serial") {
		die("cannot edit serials here");
	} else {
		echo "ผิดพลาด ไม่สามารถหาโมดูลสำหรับ $module";
	}
?></CENTER><?php 
	index_reindex($MID);
  foot();
  ?>