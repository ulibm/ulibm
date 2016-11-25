<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("rootutils");

			pagesection(getlang("โปรแกรมอรรถประโยชน์::l::Utility Files"));

?><BR><TABLE align=center width=550>
<TR>
	<TD><?php 
// Note that !== did not exist until 4.0.0-RC2

if ($handle = opendir('../_tmp/rootutils/')) {
   // echo "Directory handle: $handle\n";
    //echo "Files:\n";

    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
		if ($file!="." && $file !="..") {
			$fileurl="../_tmp/rootutils/$file";
			?><IMG SRC="../neoimg/Down.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php 
			echo "<A HREF=\"$fileurl\" target=_blank>$file</A><BR>\n";
		}
    }

    closedir($handle);
}
?> 

<BR><BR>
<HR>
	<?php  echo getlang("<B>หมายเหตุ</B> รายการดังกล่าวเป็นไฟล์ที่มีผู้นำไปไว้ที่โฟลเดอร์ /_root/rootutils/ <BR>
ซึ่งสามารถคัดลอกไฟล์ไปไว้ ซึ่งไม่เกี่ยวกับตัวโปรแกรม ULIBm และไม่อยู่ในความรับผิดชอบของทีมงานผู้พัฒนาฯ::l::
<B>Note</B> Files in folder /_input/rootutils/ are shown above. Which can copy files to folder easily, and these files not in responsive of ULIB developer."); ?>

</TD>
</TR>
</TABLE><BR><?php 
foot();
?>