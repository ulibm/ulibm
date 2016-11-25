<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_bookitem";
	$tmp=mn_lib();
	pagesection($tmp);
if ($delll!="" && (strpos($delll,"..")===false)) {
	unlink($dcrs.'/_input/import/' . "$delll");
}

?><BR><TABLE align=center width=550>
<?php 
// Note that !== did not exist until 4.0.0-RC2

if ($handle = opendir('../_input/import/')) {
   // echo "Directory handle: $handle\n";
    //echo "Files:\n";

    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
		if ($file!="." && $file !=".." && $file !="import") {
			$fileurl="step1.php?file=$file";
			?><TR>
	<TD><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php 
			echo "<A HREF=\"$fileurl\" >$file</A><BR>\n";
?></TD><TD><A HREF="index.php?delll=<?php  echo $file;?>"><IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> Delete</A></TD>
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
	<?php  echo getlang("<B>หมายเหตุ</B> รายการดังกล่าวเป็นไฟล์ที่มีผู้นำไปไว้ที่โฟลเดอร์ /_input/import/ <BR>
ซึ่งสามารถนำไปไว้ได้ทั้งวิธีการคัดลอกไฟล์ไปไว้ <A HREF='UPLOAD.php'>หรืออัพโหลดผ่านแบบฟอร์ม</A> ที่เตรียมไว้ให้ ::l::
<B>Note</B> Files in folder /_input/import/ are shown above. To upload more files Administrator might upload files mannually or by <A HREF='UPLOAD.php'>provided form</A>"); ?>

<BR></TD>
</TR>
</TABLE><?php 
foot();
?>