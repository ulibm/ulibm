<?php 
$now=time();
if ($addfavbook!="") {
	$addfavbookc_publish=tmq("select * from member where UserAdminID='$_memid' ");
	$addfavbookc_publish=tmq_fetch_array($addfavbookc_publish);
	$addfavbookc_publish=$addfavbookc_publish[publishbookinfo];
	$addfavbookc=tmq("select ID from media where ID='$addfavbook' ");
	if (tmq_num_rows($addfavbookc)!=0) {
		tmq("delete from webpage_memfavbook where memid='$_memid' and bibid='$addfavbook' ");
		tmq("insert into webpage_memfavbook set memid='$_memid', bibid='$addfavbook',
		dt=$now, ispublish='$addfavbookc_publish' ");

		?><TABLE align=center width="<?php  echo $_TBWIDTH-100;?>">
		<TR>
			<TD><?php 
			echo getlang("เพิ่มรายการเรียบร้อย::l::Success add new item").":<BR>";
			res_brief_dsp($addfavbook);
		?></TD>
		</TR>
		</TABLE><?php 
	}
}
?>
<script language="javascript"> 
function resizeIframe2(id) { 
	try { 
		frame = document.getElementById(id); 
		frame.scrolling = "no"; 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight + 25; 
		 if (tmpfrheight>1600) {
			 tmpfrheight=1600;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH;?>" align=center>
<TR valign=top>
	<TD width=200><iframe width=200 height=50 src="mainadmin.favbook.perscate.php" onload="resizeIframe2('perscateiframe')" ID="perscateiframe"  FRAMEBORDER="NO" BORDER=0 SCROLLING=NO></iframe></TD>
	<TD><iframe width=580 height=550 src="mainadmin.favbook.listfav.php" noonload="resizeIframe2('mainframe')" ID="mainframe" name="mainframe" onload="resizeIframe2('mainframe')" ></iframe></TD>
</TR>
</TABLE><BR>
<?php  html_dialog("","เพิ่มหนังสือเข้ารายการโปรดได้โดยการเข้าถึงรายละเอียดหนังสือเล่มนั้น ๆ ผ่านระบบสืบค้น (UPAC) แล้วคลิก [เพิ่มเล่มนี้ไว้ในรายการโปรด]::l::Add books to your Favourite List by view it's bibliography record then click [Add this to Favourite List]");?>