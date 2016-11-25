<?php 


	set_time_limit(0);
     include("../inc/config.inc.php");
	 //html_start();
//print_r($_FILES); die;

if ($relativepath=="") {
	die("no-relative-path");
}
if ($filetype=="") {
	die("no-filetype");
}
if ($nametype=="") {
	die("no-nametype");
}
if ($operaionmode!="") {
	echo("operaionmode: $operaionmode ");
}
echo "$filetype to $relativepath";
 $ismanager=loginchk_lib("check");


 $addtotextarea=trim($addtotextarea);
 $key=trim($key);


$_iswiki=substr($key,0,5);
if ($_iswiki=="wiki-") {
	$_iswiki="yes";
}

$relativepath=str_replace(" ","",$relativepath);
$relativepath=trim($relativepath);
$relativepath=addslashes($relativepath);
$relativepath=str_replace(".","",$relativepath);
$_VAL_FILE_SAVEPATHurl="$dcrURL/$relativepath";
$_VAL_FILE_SAVEPATH="$dcrs/$relativepath";
	if ( $ismanager!=true) {
		die("you cannot use global upload");
	}

/////////////////////////////////////////////

	$uploaddir =$_VAL_FILE_SAVEPATH;
	@mkdir("$uploaddir", 0777);
	$dir=$uploaddir;
//print_r($_FILES[Filedata]);
	$filename=str_getvalidfilename($_FILES[Filedata][name],true,$uploaddir);
	//echo "	got($filename)";
	$ext=explode('.',$filename);
	//$filename.=".".$ext[count($ext)-1];
$pureext=strtolower($ext[count($ext)-1]);
	if ($filetype=="jpgonly") {
		if ($pureext!="jpg") {
			die("ext-not-png");
		}
	}
	if ($pureext=="php" || $pureext=="php3" || $pureext=="phps" || $pureext=="exe" || $pureext=="dll") {
		die("ext-php");
	}
	$sourcefile=$_FILES['Filedata']['tmp_name'];
	$uploadedfilename=$_FILES[Filedata][name];
	$uploadedfilename=iconvth($uploadedfilename);
	$ctt=$_FILES[Filedata][type];
	if ($nametype=="origname") {
		$str_savedfilename=$uploadedfilename;
		$uploadfile="$dir$uploadedfilename";
	} else {
		$str_savedfilename=$filename;
		$uploadfile="$dir$filename";
	}
// pre upload operation
if ($operaionmode=="mediacontent") {
  $edit=barcodeval_get("TMP-ftcontent-$useradminid-mid");
  $FTCODE=barcodeval_get("TMP-ftcontent-$useradminid-FTCODE");
 		
	 if ($FTCODE=="") {
	 		filelogs("no FTCODE");
	 		die("no FTCODE");
	 }
	 
	 if ($edit=="") {
	 	 		filelogs("no edit");
	 		die("no edit");
	 }

	$uploaddir ="$dcrs/_fulltext/$FTCODE/";
	@mkdir("$uploaddir", 0777);
	
	$uploaddir ="$dcrs/_fulltext/$FTCODE/$edit/";
	@mkdir("$uploaddir", 0777);
}


if (is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
	if (copy($sourcefile, $uploadfile)) {
		filelogs("uploadlog-globalupload","$filetype-$nametype-$relativepath-$operaionmode-$uploadfile");		

// post upload operation
if ($operaionmode=="mediacontent") {
	$uploadedfilename=iconvth($uploadedfilename);
	tmq("insert into media_ftitems  set mid='$edit' , filename ='".$str_savedfilename."',fttype='$FTCODE',text='$uploadedfilename' ,uploadtype='upload'");
	$now=time();
   media_updatelastdt($edit,"ft");
	tmq("insert into media_edittrace set 
	login='$useradminid',
	dt='$now',
	bibid='$edit',
	edittype='upload fulltext name=$uploadedfilename [$FTCODE]'		");

	
	index_indexft($edit);

}
		/*if ($pureext=="jpg" || $pureext=="gif" || $pureext=="png" || $pureext=="bmp" ) {
			copy($sourcefile, $uploadfile.".thumb.jpg");
			fso_image_fixsize($uploadfile.".thumb.jpg",$pureext);
		}*/
		/*
		$s= "insert into globalupload set
		loginid='$useradminid' ,
		keyid='$key' ,
		filename='$uploadedfilename' ,
		ctt='$ctt' ,
		dt='$now' ,
		hidename='$filename'
			";
		tmq($s,true);*/
		
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
	exit(0);
?>