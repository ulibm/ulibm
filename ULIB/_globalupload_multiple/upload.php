<?php 


	set_time_limit(0);
     include("../inc/config.inc.php");
	 //html_start();
//print_r($_FILES); die;

if ($key=="TEMP") {
	$key="tempolary-for-$useradminid";
}

echo "keyis $key;
";
 $ismanager=loginchk_lib("check");

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

	$filename=randid();
	$ext=explode('.',$_FILES[Filedata][name]);
	$filename.=".".$ext[count($ext)-1];
$pureext=strtolower($ext[count($ext)-1]);
	if ($pureext=="php") {
		die("ext-php");
	}
	$uploadfile="$dir$filename";
		$sourcefile=$_FILES['Filedata']['tmp_name'];
		$uploadedfilename=$_FILES[Filedata][name];
		$ctt=$_FILES[Filedata][type];
if (is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
	if (copy($sourcefile, $uploadfile)) {
		if ($pureext=="jpg" || $pureext=="gif" || $pureext=="png" || $pureext=="bmp" ) {
			copy($sourcefile, $uploadfile.".thumb.jpg");
			fso_image_fixsize($uploadfile.".thumb.jpg",$pureext);
		}
		$uploadedfilename=iconvth($uploadedfilename);
		$now=time();
		$s= "insert into globalupload set
		loginid='$useradminid' ,
		keyid='$key' ,
		filename='$uploadedfilename' ,
		ctt='$ctt' ,
		dt='$now' ,
		hidename='$filename'
			";
		tmq($s,true);
		
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