<?php  
include("./cfg.inc.php");
include("./_localfunc.php");
loginchk_lib();
	 $ismanager=library_gotpermission("webpage-postarticle");

 $ID=trim($ID);
?><!-- <?php  pathgen($ID);?> --><?php  
	if ($tmiddata[ispost]!="on" && $ismanager!=true) {
		die("you cannot post in this forum");
	}


	
	$dir=$_VAL_FILE_SAVEPATH;
	$filename=randid();
	$ext=explode('.',$_FILES[file1][name]);
	$pureext=strtolower($ext[count($ext)-1]);
	$filename.=".".$ext[count($ext)-1];

	$uploadfile="$dir$filename";
	$uploadfile2="$uploadfile".".thumb.jpg";
		$sourcefile=$_FILES['file1']['tmp_name'];
		$uploadedfilename=$_FILES[file1][name];
		$ctt=$_FILES[file1][type];
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
	if (copy($sourcefile, $uploadfile)) {
		$s= "insert into webpage_article_attatch set
		tmid='$useradminid' ,
		postid='$editing' ,
		filename='$uploadedfilename' ,
		ctt='$ctt' ,
		hidename='$filename'
			";
		tmq($s,false);
if ($pureext=="jpg" || $pureext=="gif" || $pureext=="png" || $pureext=="bmp") {
		copy($uploadfile, $uploadfile2);
		fso_image_fixsize($uploadfile2,$pureext,150);
	}
		echo "อัพโหลดเรียบร้อย";
		redir("attach.php?ID=$ID&editing=$editing");
	} else {
		echo "copy($sourcefile, $uploadfile)";
		echo "ไม่สามารถเคลื่อนย้ายไฟล์ไปยังที่จัดเก็บได้\n";
		die;
	}
	@unlink($sourcefile);

} else {
   echo "การอัพโหลดไม่สำเร็จ ";
}


?>