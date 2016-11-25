<?php 
	include ("../inc/config.inc.php");
if ($_memid=="") {
	die("Pls login");
}

html_start();
if ($addcate!="" && $text!='') {
	tmq("insert into webpage_memfavbook_perscate (nested,memid,name) values ('$addcate','$_memid','$text')");
}
if ($editcate!="" && $text!='') {
	tmq("update webpage_memfavbook_perscate set name ='$text' where memid='$_memid' and id='$editcate' ");
}
if ($removecate!="") {
	///tmq("update readrule set incate ='' where memid='$_memid' and incate='$removecate' ");
	tmq("delete from webpage_memfavbook_perscate  where memid='$_memid' and id='$removecate' ");
}


function localfoldertree($wh) {
	global $_memid;
	$ss=tmq("select * from webpage_memfavbook_perscate where nested='$wh' and memid='$_memid' ");
	echo "<TABLE width=100% cellpadding=0 cellspacing=0 border=0 ><TR><TD style='padding-left: 7' align=left class=table_td>";
	while ($r=tmq_fetch_array($ss)) {
		?><IMG SRC='./miscimg/folder.png' WIDTH='12' HEIGHT='12' BORDER='0' ALT='' align=absmiddle> <?php 
		echo "<A HREF='./mainadmin.favbook.listfav.php?incate=$r[id]'  target=mainframe class=smaller2>".getlang($r[name])."</A> ";
		?>
<A HREF="javascript:addcate(<?php  echo $r[id]?>);"><IMG SRC="./miscimg/Add.png" WIDTH="12" HEIGHT="12" BORDER="0" ALT="" align=absmiddle></A>
<A HREF="javascript:editcate(<?php  echo $r[id]?>,'<?php  echo $r[name]?>');"><IMG SRC="./miscimg/edit16.png" WIDTH="12" HEIGHT="12" BORDER="0" ALT="" align=absmiddle></A>
<?php 
		$chk=tmq("select * from webpage_memfavbook_perscate where nested='$r[id]' and memid='$_memid' ");
		$chk=tmq_fetch_array($chk);
		//if ($wh!=-1 && $chk[id]=='' ) {
		if ($chk[id]=='' ) {
			?><A HREF="mainadmin.favbook.perscate.php?removecate=<?php  echo $r[id]?>" onclick="return confirm('Please confirm');"><IMG SRC="./miscimg/Cancel.png" WIDTH="12" HEIGHT="12" BORDER="0" ALT="" align=absmiddle></A><?php 
		}
		localfoldertree($r[id]);
	}
	echo "</TD>	</TR></TABLE>";
}


?>&nbsp;&nbsp;&nbsp;
<FONT SIZE="" COLOR="" class=smaller>
<IMG SRC='./miscimg/folder.png' WIDTH=16 HEIGHT=16 BORDER=0 align=absmiddle> 
	<?php  echo getlang("จัดการหัวข้อย่อย::l::Folders");?></FONT>
	<A HREF="javascript:addcate(-1);"><IMG SRC="./miscimg/Add.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle></A>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function addcate(wh) {
		tmp=prompt("กรุณากรอกชื่อหัวข้อ","");
		if (tmp!="" && tmp!=undefined) {
			self.location="mainadmin.favbook.perscate.php?addcate="+wh+"&text="+tmp;
		}
	}
	function editcate(cate,wh) {
		tmp=prompt("กรุณากรอกชื่อหัวข้อใหม่",wh);
		if (tmp!="" && tmp!=undefined) {
			self.location="mainadmin.favbook.perscate.php?editcate="+cate+"&text="+tmp;
		}
	}
	<?php  if ($mode=="user") {?>
		parent.resizeIframe2('iframe_catemanuser');;
	<?php  } else {?>
		parent.resizeIframe2('iframe_cateman');;
	<?php  } ?>
//-->
</SCRIPT>
<TABLE width=100% cellpadding=0 cellspacing=0>
<TR>
	<TD style="padding-left: 20px;">
<?php 
localfoldertree(-1);
?></TD>
</TR>
</TABLE>
