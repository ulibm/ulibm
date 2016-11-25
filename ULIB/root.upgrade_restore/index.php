<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("upgrade_restore");
			pagesection(getlang("Restore database"));

?><BR><TABLE align=center width=550>
<?php 
// Note that !== did not exist until 4.0.0-RC2

if ($handle = opendir('../_output/')) {
   // echo "Directory handle: $handle\n";
    //echo "Files:\n";

    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
		if ($file!="." && $file !="..") {
			$fileurl="step1.php?file=$file";
			?><TR>
	<TD><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php 
			echo "<A HREF=\"$fileurl\" onclick=\"return confirm('".getlang("การ Restore จะนำข้อมูลในไฟล์นี้ ขึ้นไปทับฐานข้อมูลทั้งหมด \\nซึ่งหากไฟล์นี้ไม่สมบูรณ์ อาจทำให้ระบบใช้งานไม่ได้และเกิดการสูญหายของข้อมูลอีกด้วย\\n::l::This restore procexx will replace current database with this file\\n If this file is incorrect may causes system damage.")."');\">$file</A><BR>\n";
?></TD><TD></TD>
</TR><?php 
		}
    }

    closedir($handle);
}
?> 

</TABLE>
<BR><BR>
<HR><TABLE width=600 align=center>
<TR>
	<TD>
	<?php  echo getlang("<B>หมายเหตุ</B> รายการดังกล่าวเป็นไฟล์ที่มีผู้นำไปไว้ที่โฟลเดอร์ /_output/ <BR>
ซึ่งสามารถนำไปไว้ได้ทั้งวิธีการคัดลอกไฟล์ไปไว้ <A HREF='UPLOAD.php'>หรืออัพโหลดผ่านแบบฟอร์ม</A> ที่เตรียมไว้ให้ ::l::
<B>Note</B> Files in folder /_output/ are shown above. To upload more files Administrator might upload files mannually or by <A HREF='UPLOAD.php'>provided form</A>"); ?>
<BR></TD>
</TR>
</TABLE><?php 
foot();
?>