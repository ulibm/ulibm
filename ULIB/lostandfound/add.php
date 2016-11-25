<?php  
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("lostandfound_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("lostandfound");
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php  include("menu.php");?></TD>
<FORM METHOD=POST ACTION="addaction.php"  enctype="multipart/form-data">
		<TD align=center>
		<?php  
		if (library_gotpermission("lostandfound")!=true) {
			echo getlang("เฉพาะเจ้าหน้าที่ที่ได้รับสิทธิ์ จึงจะโพสท์รายการใหม่ได้::l::Only granted officer can post new item.");
			/*echo "<BR><A HREF='../member/index.php?backto=".urlencode("$dcrURL/lostandfound/add.php")."'>".getlang("ล็อกอินที่นี่::l::Login here")."</A>";*/
		} else {
			
			?>
			<TABLE width=100% class=table_border>
			<TR>
				<TD class=table_head><?php echo getlang("ชื่อรายการ::l::Title");?></TD>
				<TD class=table_td><INPUT TYPE="text" NAME="title" size=55></TD>
			</TR>
			<TR>
				<TD class=table_head><?php echo getlang("รายละเอียดของหาย::l::Detail");?></TD>
				<TD class=table_td><TEXTAREA NAME="text" ROWS="10" COLS="60"></TEXTAREA></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><B><?php echo getlang("ภาพประกอบ 1::l::Image 1");?>: </B><input type=file name='img01'></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><B><?php echo getlang("ภาพประกอบ 2::l::Image 2");?>: </B><input type=file name='img02'><BR>
				*.JPG only</TD>
			</TR>

			<TR>
				<TD class=table_td align=center colspan=1><B><?php echo getlang("ให้แท็ก::l::Tags");?>: </B></TD>
				<TD><?php  
			$ts=tmq("select * from webpage_lostandfound_tag order by name");
			while ($tsr=tmq_fetch_array($ts)) {
				?><label><INPUT TYPE="checkbox" NAME="tags[]" value="<?php echo $tsr[id]?>" style="border:0"
				<?php  
$pos = strpos("$s[taglist]", ",$tsr[id],");

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
} else {
    echo " checked ";
}
				?>> <?php echo getlang($tsr[name])?></label> <?php  
			}
			?><BR><A HREF="taglist.php" class=smaller><?php echo getlang("แก้ไขแท็ก::l::Edit tags"); ?></A></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><INPUT TYPE="submit" value=" Submit "></TD>
			</TR>
			
			</TABLE>
			<?php  
		}
		?>
		</TD>

</FORM></TR>
</TABLE>
<?php  
				foot();
?>