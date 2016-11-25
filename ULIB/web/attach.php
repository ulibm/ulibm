<?php 
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function insertpic(wh) {
	str="<img src='"+wh+"' align=absmiddle vspace=1 hspace=1 width=200 >";
	//alert(str);
	var oEditor = parent.FCKeditorAPI.GetInstance('text') ;
	if ( oEditor.EditMode == parent.FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml( str ) ;
	} else {
		alert( 'You must be on WYSIWYG mode!' ) ;
	}
	

	//parent.Toggle('InsertImage',wh);
	//parent.editor_insertHTML("text",str);
//	parent.document.all['text'].insertAdjacentHTML("beforeEnd", str);
	//top.document.all.text.value=top.document.all.text.value+"\n"+wh
	//	alert(wh);
	//alert(top.document.all.text.value);
}

function insertlink(wh) {
	str=" <a href='"+wh+"' target=_blank>[<?php  echo getlang("คลิก::l::Click")?>]</a> ";
	//alert(str);
	var oEditor = parent.FCKeditorAPI.GetInstance('text') ;
	if ( oEditor.EditMode == parent.FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml( str ) ;
	} else {
		alert( 'You must be on WYSIWYG mode!' ) ;
	}
	
}
//-->
</SCRIPT>
<?php 

$ismanager=library_gotpermission("webpage-postarticle");

 $ID=trim($ID);
 $editing=trim($editing);
?><!-- <?php pathgen($ID);?> --><?php 
if ($editing!="") {
	$loadedit=$editing;
} else {
	$loadedit=0;
}
if ($remove!="") {
// tmid='$useradminid' and
	$remq=tmq("select * from webpage_article_attatch where postid=$loadedit and id='$remove'");
	$remq=tmq_fetch_array($remq);
	//rename($_VAL_FILE_SAVEPATH.$remq[hidename],$_VAL_FILE_SAVEPATHunused.$remq[hidename]);
	@unlink($_VAL_FILE_SAVEPATH.$remq[hidename]);
		@unlink($_VAL_FILE_SAVEPATH.$remq[hidename].".thumb.jpg");
//tmid='$useradminid' and
	tmq("delete from  webpage_article_attatch where  postid=$loadedit and id='$remove' ");
}
	if ($tmiddata[ispost]!="on" && $ismanager!=true) {
		die("you cannot post in this forum");
	}

?><TABLE class=table_border width=100%>
<TR>
	<TD class=table_head width=70%>ชื่อไฟล์</TD>
	<TD class=table_head>ขนาด</TD>
	<TD class=table_head>ลบไฟล์</TD>
</TR>
<?php 

//tmid='$useradminid' and 
$s=tmq("select * from  webpage_article_attatch where postid=$loadedit ");
html_rows0_str($s,"ไม่มีไฟล์แนบ",3);
while ($r=tmq_fetch_array($s)) {
?><TR>
	<TD class=table_td><?php 
		$ext=strtolower(substr($r[hidename],-3));
if ($ext=="jpg" || $ext=="gif" || $ext=="png" || $ext=="bmp") {
	?><img src="<?php echo "$_VAL_FILE_SAVEPATHurl/$r[hidename].thumb.jpg"; ?>" width=25 align=absmiddle border=1  onclick="insertpic('<?php  echo "$_VAL_FILE_SAVEPATHurl/$r[hidename]"; ?>');"><?php 
}	else {
	?><img src="<?php echo "$dcrURL/neoimg/misc/ICCONFIG.GIF"; ?>" width=16 align=absmiddle border=0  onclick="insertlink('<?php  echo "$_VAL_FILE_SAVEPATHurl/$r[hidename]"; ?>');" style='cursor: hand; cursor: pointer;'><?php 
}
?> <A HREF="<?php echo $_VAL_FILE_SAVEPATHurl?>/<?php  echo $r[hidename]; ?>" target=_blank><?php  echo $r[filename];;?></A> </TD>
	<TD class=table_td align=center><?php 
echo local_getfilesize($r[hidename]);	
?></TD>
	<TD class=table_td align=center><A HREF="attach.php?remove=<?php  echo $r[id];?>&ID=<?php  echo $ID;?>&editing=<?php  echo $editing;?>" onclick="return confirm('กรุณายืนยันการลบ');">ลบไฟล์</A></TD>
</TR>
<?php 
}
?>
</TABLE><TABLE class=table_border width=100%>
<FORM METHOD=POST ACTION="attach.upload.php" enctype="multipart/form-data">
<TR>
	<TD class=table_head width=20%>อัพโหลด</TD>
	<TD class=table_td><INPUT TYPE="file" NAME="file1" size=35> <INPUT TYPE="submit" value='อัพโหลด'></TD>
</TR>
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID;?>">
<INPUT TYPE="hidden" NAME="editing" value="<?php  echo $editing;?>">
</FORM>
</TABLE>
