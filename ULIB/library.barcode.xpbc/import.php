<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();
			pagesection(getlang("นำเข้าข้อมูลเพื่อบาร์โค้ด::l::Import data to Barcode-on-demand"));

if ($delll!="" && (strpos($delll,"..")===false)) {
	unlink($dcrs.'/_input/xpbc/' . "$delll");
}

?><BR><TABLE align=center width=550>
<?php 
// Note that !== did not exist until 4.0.0-RC2

if ($handle = opendir('../_input/xpbc/')) {
   // echo "Directory handle: $handle\n";
    //echo "Files:\n";

    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
		if ($file!="." && $file !="..") {
			$fileurl="step1.php?file=$file";
			?><TR>
	<TD><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php 
			echo "<A HREF=\"$fileurl\" class=a_btn>$file</A><BR>\n";
?></TD><TD><A HREF="import.php?delll=<?php  echo $file;?>"><IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> Delete</A></TD>
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
		<?php  echo getlang("<B>หมายเหตุ</B> รายการดังกล่าวเป็นไฟล์ที่มีผู้นำไปไว้ที่โฟลเดอร์ /_input/xpbc/ <BR>
ซึ่งสามารถนำไปไว้ได้ทั้งวิธีการคัดลอกไฟล์ไปไว้ <A class=a_btn HREF='UPLOAD.php'>หรืออัพโหลดผ่านแบบฟอร์ม</A> ที่เตรียมไว้ให้ ::l::
<B>Note</B> Files in folder /_input/xpbc/ are shown above. To upload more files Administrator might upload files mannually or by <A class=a_btn HREF='UPLOAD.php'>provided form</A>"); ?>
<BR></TD>
</TR>
</TABLE><?php 
foot();
?>