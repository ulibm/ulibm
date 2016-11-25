<?php 
set_time_limit(0);
     include("./inc/config.inc.php");
	 html_start();

if ($key=="TEMP") {
	$key="tempolary-for-$useradminid";
}

function local_getfilesize($wh) {
	//echo $wh2;
	if (file_exists($wh)) {
		return number_format(filesize($wh)/1024)."kb";
	} else {
		return " ไม่พบไฟล์ ";
	}
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function insertpic(wh) {
	str="<img src='"+wh+"' align=absmiddle vspace=1 hspace=1 width=200 >";
	//alert(str);
	//var oEditor = parent.CKEDITOR.currentInstance;
	/*s="";
	for (i in parent.CKEDITOR )
	{
		s=s+" "+i;
	} 
	alert(s);*/
	// Check the active editing mode.
	var CKEDITOR   = window.parent.CKEDITOR;   
for ( var i in CKEDITOR.instances ){
   var currentInstance = i;
   break;
}
var oEditor   = CKEDITOR.instances[currentInstance];
	if (oEditor.mode == 'wysiwyg' )
	{
		// Insert the desired HTML.
		oEditor.insertHtml( str ) ;
	}
	else
		alert( 'You must be on WYSIWYG mode!' ) ;
	

	//parent.Toggle('InsertImage',wh);
	//parent.editor_insertHTML("text",str);
//	parent.document.all['text'].insertAdjacentHTML("beforeEnd", str);
	//top.document.all.text.value=top.document.all.text.value+"\n"+wh
	//	alert(wh);
	//alert(top.document.all.text.value);
}

function insertlink(wh) {
	str=" <a href='"+wh+"' target=_blank><?php  echo getlang("คลิก::l::Click")?></a> ";
	//alert(str);
	//var oEditor = parent.CKEDITOR.instances.<?php echo $addtotextarea?> ;
 	var CKEDITOR   = window.parent.CKEDITOR;   
for ( var i in CKEDITOR.instances ){
   var currentInstance = i;
   break;
}
var oEditor   = CKEDITOR.instances[currentInstance];
	// Check the active editing mode.
	if (oEditor.mode == 'wysiwyg' )
	{
		// Insert the desired HTML.
		oEditor.insertHtml( str ) ;
	}
	else
		alert( 'You must be on WYSIWYG mode!' ) ;
	/*var oEditor = parent.FCKeditorAPI.GetInstance('<?php  echo $addtotextarea?>') ;
	if ( oEditor.EditMode == parent.FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml( str ) ;
	} else {
		alert( 'You must be on WYSIWYG mode!' ) ;
	}*/
	
}
//-->
</SCRIPT>
<?php 
 $ismanager=loginchk_lib("check") ;

 $addtotextarea=trim($addtotextarea);
 $key=trim($key);

if ($key=="") {
	die("globalupload.php need key ($key)");
}

$_iswiki=substr($key,0,5);
if ($_iswiki=="wiki-") {
	$_iswiki="yes";
}

$_VAL_FILE_SAVEPATHurl="$dcrURL/_globalupload/$key/";
$_VAL_FILE_SAVEPATH="$dcrs/_globalupload/$key/";
	if ( $ismanager!=true) {
		die("you cannot use global upload");
	}

/////////////////////////////////////////////

	$uploaddir =$_VAL_FILE_SAVEPATH;
	@mkdir("$uploaddir", 0777);
	$dir=$uploaddir;

	//$filename=randid();
	$filename=str_getvalidfilename($_FILES['file1']['name'],false,$dir);
	$ext=explode('.',$_FILES[file1][name]);
	$filename.=".".$ext[count($ext)-1];
$pureext=strtolower($ext[count($ext)-1]);
	if ($pureext=="php") {
		die("ext-php");
	}
	$uploadfile="$dir$filename";
		$sourcefile=$_FILES['file1']['tmp_name'];
		$uploadedfilename=addslashes($_FILES[file1][name]);
		$ctt=$_FILES[file1][type];
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
	if (copy($sourcefile, $uploadfile)) {
		if ($pureext=="jpg" || $pureext=="gif" || $pureext=="png" || $pureext=="bmp" ) {
			copy($sourcefile, $uploadfile.".thumb.jpg");
			fso_image_fixsize($uploadfile.".thumb.jpg",$pureext);
		}
		$now=time();
		$s= "insert into globalupload set
		loginid='$useradminid' ,
		keyid='$key' ,
		filename='$uploadedfilename' ,
		ctt='$ctt' ,
		dt='$now' ,
		hidename='$filename'
			";
		tmq($s,false);
		
		//echo "อัพโหลดเรียบร้อย";
	} else {
		echo "copy($sourcefile, $uploadfile)";
		echo "ไม่สามารถเคลื่อนย้ายไฟล์ไปยังที่จัดเก็บได้\n";
		die;
	}
	unlink($sourcefile);

} else {
   //echo getlang("การอัพโหลดไม่สำเร็จ::l::Upload failed");
}
/////////////////////////////////////////////

if ($remove!="") {
	$remq=tmq("select * from globalupload where keyid='$key' and id='$remove'");
	$remq=tmq_fetch_array($remq);
	//rename($_VAL_FILE_SAVEPATH.$remq[hidename],$_VAL_FILE_SAVEPATHunused.$remq[hidename]);
	@unlink($_VAL_FILE_SAVEPATH.$remq[hidename]);
	@unlink($_VAL_FILE_SAVEPATH.$remq[hidename].".thumb.jpg");
	tmq("delete from  globalupload where keyid='$key' and id='$remove' ");
}
if ($rename!="" && $newname!="") {
	$newname=stripslashes($newname);
	$newname=stripslashes($newname);
	$newname=addslashes($newname);
	$remq=tmq("update globalupload set filename='$newname' where keyid='$key' and id='$rename'");
}

if ($switchwikiprofile!="") {
	$wicipq=tmq("select * from globalupload where keyid='$key' and id='$switchwikiprofile'");
	$wicipq=tmq_fetch_array($wicipq);
	if ($wicipq[wikiprofile]=="yes") {
		tmq("update globalupload set wikiprofile='no' where keyid='$key' and id='$switchwikiprofile'");
	} else {
		tmq("update globalupload set wikiprofile='yes' where keyid='$key' and id='$switchwikiprofile'");
	}
}
?><TABLE class=table_border width=100%>
<FORM METHOD=POST ACTION="globalupload.php" enctype="multipart/form-data">
<TR>
	<TD class=table_head width=20%><?php  echo getlang("อัพโหลด::l::Upload");?></TD>
	<TD class=table_td>
		<span ID="uploading" style="display:none">Uploading: <IMG SRC="./neoimg/uploading.gif" WIDTH="128" HEIGHT="15" BORDER="0" ALT="" align=absmiddle> <A HREF="globalupload.php?key=<?php  echo $key?>&addtotextarea=<?php  echo $addtotextarea?>" ><?php  echo getlang("ยกเลิก::l::Cancel");?></A></span>

<span ID="uploadbtn">	<INPUT TYPE="file" NAME="file1" size=5 onchange="submitchk(this)" onkeydown="return false;"></span> 
<a href="<?php  echo $dcrURL?>_globalupload_multiple/index.php?key=<?php  echo $key?>&addtotextarea=<?php  echo $addtotextarea?>">
<img src="_globalupload_multiple/upload.gif" width="24" height="24" border="0" alt="" align=absmiddle><?php  echo getlang("หลายไฟล์::l::Multiple Files"); ?></a><!-- <INPUT TYPE="submit" value='อัพโหลด'> -->
	
	
<SCRIPT LANGUAGE="JavaScript">
<!--
pic1= new Image(100,25); 
pic1.src="./neoimg/uploading.gif"; 

function submitchk(wh) {
	if (wh.value=="") {
		return;
	}
	tmp=getobj("uploadbtn");
	tmp.style.display="none";
	tmp=getobj("uploading");
	tmp.style.display="inline";
	document.forms[0].submit();
}
//-->
</SCRIPT>
</TD>
</TR>
<INPUT TYPE="hidden" NAME="key" value="<?php  echo $key;?>">
<INPUT TYPE="hidden" NAME="addtotextarea" value="<?php  echo $addtotextarea;?>">
</FORM>
</TABLE><TABLE class=table_border width=100%>
<TR>
	<TD class=table_head width=70%><?php  echo getlang("ชื่อไฟล์::l::File name");?> </TD>
	<TD class=table_head><?php  echo getlang("ขนาด::l::Size");?></TD>
	<TD class=table_head><?php  echo getlang("ลบ/แก้ชื่อ::l::Delete/Edit");?></TD>
</TR>
<?php 
$s=tmq("select * from  globalupload where keyid='$key' order by wikiprofile desc,dt desc");
html_rows0_str($s,getlang("ไม่มีไฟล์แนบ::l::No uploaded file"),3);
while ($r=tmq_fetch_array($s)) {
$ext=strtolower(substr($r[hidename],-3));
if ($ext=="jpg" || $ext=="gif" || $ext=="png" || $ext=="bmp" ) {
	$_isimg="yes";
} else {
	$_isimg="no";
}
?><TR>
	<TD class=table_td class=smaller><?php 
if ($_isimg=="yes") {
	?><img src="<?php echo "$_VAL_FILE_SAVEPATHurl/$r[hidename]"; 
		if (file_exists("$_VAL_FILE_SAVEPATH/$r[hidename].thumb.jpg")) {
			echo ".thumb.jpg";
		}
	?>" width=32 align=absmiddle border=1  onerror="this.display='none';" <?php 
	if ( $addtotextarea!="") {	
		?>onclick="insertpic('<?php  echo "$_VAL_FILE_SAVEPATHurl/$r[hidename]"; ?>'); " style="cursor: hand; cursor: pointer;"><?php 
	}
} else {
	if ( $addtotextarea!="") {	
		echo html_geticon($r[hidename],"width=24 align=absmiddle border=0  onclick=\"insertlink('$_VAL_FILE_SAVEPATHurl/$r[hidename]');\" style='cursor: hand; cursor: pointer;;'");
		?><?php 
	}
}
if ($_isimg=="yes" && $_iswiki=="yes") {
	?><A HREF="globalupload.php?switchwikiprofile=<?php  echo $r[id];?>&key=<?php  echo $key;?>&addtotextarea=<?php  echo $addtotextarea;?>"><?php 
	if ($r[wikiprofile]=="yes") {	
		?><img src="<?php  echo $dcrURL?>neoimg/stamp.gif" width=28 height=28 hspace=2  align=absmiddle border=0 title="<?php  echo getlang("ตั้งเป็นภาพหลักของ Wiki นี้::l::Set as Wiki's Image");?>"><?php 
	} else {
		?><img src="<?php  echo $dcrURL?>neoimg/stamp-dis.gif" width=28 height=28 hspace=2  align=absmiddle border=0 title="<?php  echo getlang("ตั้งเป็นภาพหลักของ Wiki นี้::l::Set as Wiki's Image");?>"><?php 
	}	
	?></A><?php 
}
?> <A HREF="<?php echo $_VAL_FILE_SAVEPATHurl?>/<?php  echo $r[hidename]; ?>" target=_blank><?php  echo mb_substr($r[filename],0,40);;?></A> </TD>
	<TD class=table_td align=center class=smaller><?php 
echo local_getfilesize($_VAL_FILE_SAVEPATH.$r[hidename]);	
?></TD>
	<TD class=table_td align=center>
	<A HREF="globalupload.php?remove=<?php  echo $r[id];?>&key=<?php  echo $key;?>&addtotextarea=<?php  echo $addtotextarea;?>" onclick="return confirm('กรุณายืนยันการลบ');" class=smaller><?php  echo getlang("ลบ::l::Delete");?></A> :
		<A HREF="javascript:void(null);" onclick="renamemodule('<?php  echo $r[id];?>','<?php  echo addslashes($r[filename])?>')" class=smaller><?php  echo getlang("แก้ชื่อ::l::Edit");?></A><BR>
		<?php 
		$tmphtml_photofilter=str_replace($dcrs,"",$_VAL_FILE_SAVEPATH.$r[hidename]);
		html_photofilter($tmphtml_photofilter,"",true)?>
	</TD>
</TR>
<?php 
}
?>
</TABLE>
 <FONT color=888888 class=smaller2><?php echo $key;?></FONT><SCRIPT LANGUAGE="JavaScript">
 <!--
function renamemodule(wh,oldname) {
	newname=prompt("<?php  echo getlang("เลือกชื่อใหม่::l::Enter new name");?>",oldname);
	if (newname=="" || newname==false || newname==null) {
		return false;
	}
	self.location="globalupload.php?rename="+wh+"&key=<?php  echo $key;?>&addtotextarea=<?php  echo $addtotextarea;?>&newname="+newname;
	return true;
}
 //-->
 </SCRIPT>