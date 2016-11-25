<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();

?><BR><BR><TABLE width=<?php  echo $_TBWIDTH;?> align=center>
<FORM METHOD=POST ACTION="searching.php">
<TR>
	<TD align=center><B><?php  echo getlang("กรุณาสแกนบาร์โค้ดไอเทมเพิ่มเติม หรือ เลือกคำสั่งด้านล่าง::l::Please scan item's barcode or choose action below"); ?></B></TD>
</TR>
<TR>
	<TD style="padding-left: 24px;">
	<?php 
	$s=tmq("select * from countuse_name where countuse='$countuse' ");

	if (tmq_num_rows($s) ==0 )  {
		$name="[".getlang("ยังไม่ได้ตั้งชื่อ::l::Name not set")."]";
	} else {
		$s=tmq_fetch_array($s);
		$name=$s[name];
		$sshelf=$s[shelf];
	}
	echo "<H2><IMG SRC='../neoimg/Document32.gif' WIDTH='32' HEIGHT='32' BORDER='0' ALT='' align=absmiddle> $name</H2>";
	if ($sshelf!="") {
		echo "<B>".getlang("ที่::l::At")." " . get_itemplace_name($sshelf)."</B>";
	}
	?>
	</TD>
</TR>
<?php 
?>
<TR>
	<TD align=center >
<iframe width=<?php  echo $_TBWIDTH;?> height=400 src="if.php?qnid=<?php echo $countuse;?>" bordercolor=red name=iframe1></iframe>

	</TD>
</TR>
<TR>
	<TD align=center >
<?php if (library_gotpermission("bitem_countuse_manage")) { ?>
<A class=a_btn HREF="if_rename.php?qnid=<?php echo $countuse;?>" target=iframe1><?php  echo getlang("ตั้งชื่อชุดการนับ::l::Rename counting set"); ?></A> | 
<A class=a_btn HREF="if_empty.php?qnid=<?php echo $countuse;?>" target=iframe1 onclick="return confirm ('<?php  echo getlang("คุณแน่ใจหรือที่จะลบรายการที่สแกนเข้าไปแล้วทั้งหมด?::l::Are you sure to delete all item in this counting set?");?>')"><?php  echo getlang("ลบการนับไอเทมในชุดนี้::l::Empty this counting set"); ?></A> |
<A class=a_btn HREF="if_manage.php?qnid=<?php echo $countuse;?>" target=iframe1><?php  echo getlang("จัดการรายการที่นับไว้แล้ว::l::Manage Counted items"); ?></A> |
<A class=a_btn HREF="import.php?qnid=<?php echo $countuse;?>" target=iframe1><?php  echo getlang("นำเข้า::l::Import"); ?></A> |
<?php } ?>
<A class=a_btn HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A>

</TD>
</TR><?php 
?>
</TABLE><BR><BR><BR>

<?php 

foot();
?> 