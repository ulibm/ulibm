<?php 
     include("./inc/config.inc.php");
	 html_start();

//print_r($_SESSION);

function local_getfilesize($wh) {
	//echo $wh2;
	if (file_exists($wh)) {
		return number_format(filesize($wh)/1024)."kb";
	} else {
		return " ไม่พบไฟล์ ";
	}
}


 $ismanager=loginchk_lib("check") || $useradminid!="";


if ($table=="") {
	die("fft_upload need table ($table)");
}
if ($fid=="") {
	die("fft_upload need fid ($fid)");
}
if ($keyid=="") {
	die("fft_upload need keyid ($keyid)");
}
$key="$table:$fid:$keyid";

$_VAL_FILE_SAVEPATHurl="$dcrURL/_tmp/fft_upload/$table/";
$_VAL_FILE_SAVEPATH="$dcrs/_tmp/fft_upload/$table/";
	if ( $ismanager!=true) {
		die("you cannot use global upload");
	}

/////////////////////////////////////////////

	$uploaddir =$_VAL_FILE_SAVEPATH;
	@mkdir("$uploaddir", 0777);
	$dir=$uploaddir;

	$filename=randid();
	$ext=explode('.',$_FILES[file1][name]);
	$filename.=".".$ext[count($ext)-1];
	$pureext=strtolower($ext[count($ext)-1]);

	if ($pureext=="php") {
		die("ext-php");
	}

	$uploadfile="$dir$filename";
		$sourcefile=$_FILES['file1']['tmp_name'];
		$uploadedfilename=$_FILES[file1][name];
		$ctt=$_FILES[file1][type];
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
	if (copy($sourcefile, $uploadfile)) {
		$now=time();
		$s= "insert into fft_upload set
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
	$remq=tmq("select * from fft_upload where keyid='$key' and id='$remove'");
	$remq=tmq_fetch_array($remq);
	//rename($_VAL_FILE_SAVEPATH.$remq[hidename],$_VAL_FILE_SAVEPATHunused.$remq[hidename]);
	@unlink($_VAL_FILE_SAVEPATH.$remq[hidename]);
	@unlink($_VAL_FILE_SAVEPATH.$remq[hidename].".thumb.jpg");
	tmq("delete from  fft_upload where keyid='$key' and id='$remove' ");
}

$chkmode=tmq("select * from  fft_upload where keyid='$key' ");
if (tmq_num_rows($chkmode)==0) {
?><TABLE width=100% cellpadding=0 cellspacing=0 border=0>
<FORM METHOD=POST ACTION="fft_upload.php" enctype="multipart/form-data">
<TR>
	<TD >
	<span ID="uploading" style="display:none">Uploading: <IMG SRC="./neoimg/uploading.gif" WIDTH="128" HEIGHT="15" BORDER="0" ALT="" align=absmiddle> <A HREF="fft_upload.php?table=<?php  echo $table;?>&fid=<?php  echo $fid;?>&keyid=<?php  echo $keyid;?>" ><?php  echo getlang("ยกเลิก::l::Cancel");?></A></span>
	<span ID="uploadbtn">
	<INPUT TYPE="file" NAME="file1" size=1 onchange="submitchk(this)" onkeydown="return false;"> </span><!-- <INPUT TYPE="submit" value='อัพโหลด'> --></TD>
</TR>
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
<INPUT TYPE="hidden" NAME="table" value="<?php  echo $table;?>">
<INPUT TYPE="hidden" NAME="fid" value="<?php  echo $fid;?>">
<INPUT TYPE="hidden" NAME="keyid" value="<?php  echo $keyid;?>">
</FORM>
</TABLE>
<?php 
} else {
	?><FONT class=smaller><?php 
	while ($r=tmq_fetch_array($chkmode)) {
		$ext=explode('.',$r[hidename]);
		$ext=strtolower($ext[count($ext)-1]);
	//printr($r);
		if ($ext=="jpg" || $ext=="gif" || $ext=="png" || $ext=="bmp" ) {
			?><img src="<?php echo "$_VAL_FILE_SAVEPATHurl/$r[hidename]"; ?>" height=32 width=32  align=absmiddle border=0 style="border-color: black; border-style: solid;border-width: 0;border-right-width: 1"> <?php 
		} else {
				echo html_geticon($r[hidename],"width=24 align=absmiddle border=0  style='cursor: hand; cursor: pointer;;'");
		}
		?> <A HREF="<?php echo $_VAL_FILE_SAVEPATHurl?>/<?php  echo $r[hidename]; ?>" target=_blank class=smaller><?php  echo substr($r[filename],0,70);;?></A> <?php 
		echo local_getfilesize($_VAL_FILE_SAVEPATH.$r[hidename]);	
		?> &nbsp; 
<A HREF="fft_upload.php?remove=<?php  echo $r[id];?>&table=<?php  echo $table;?>&fid=<?php  echo $fid;?>&keyid=<?php  echo $keyid;?>" onclick="return confirm('กรุณายืนยันการลบ');"><?php  echo getlang("ลบไฟล์::l::Delete");?></A><?php 

	}
}
?>
<!--  <FONT color=888888 style="font-size:1"><?php echo $key;?></FONT> -->