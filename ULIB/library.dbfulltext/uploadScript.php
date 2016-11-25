<?php 
include("../inc/config.inc.php");

	 loginchk_lib();

$now=time();

filelogs("uploadlog",print_r($_FILES,true));
filelogs("uploadlog",print_r($_POST,true));
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
		
		//$uploaddir=str_replace('//','/',$uploaddir);
		
		$purename=$_FILES['Filedata']['name'];
    $ext=explode('.',$purename);
    $ext=$ext[count($ext)-1];
    $ext=strtolower($ext);
		if ($ext=="php" || $ext=="php3" || $ext=="phps" || $ext=="exe") {
			 die("extension not allowed");
		}
		///$newname=date("Ymd_His")."_".($_FILES['Filedata']['name']);
		//$newname=randid().".".$ext;
		$newname=str_getvalidfilename($_FILES['Filedata']['name'],true,$uploaddir);
    $uploadfile = $uploaddir . $newname;
	 	filelogs("uploadlog","$uploaddir-$edit-$FTCODE-$purename-$newname");		
		
		


		if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {
			//print "อัพโหลดไฟล์เรียบร้อย. ";
			tmq("insert into media_ftitems  set mid='$edit' , filename ='".$newname."',fttype='$FTCODE',text='$purename' ,uploadtype='upload'");
		} else {
			
		}
		media_updatelastdt($edit,"ft");
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$edit',
		edittype='upload fulltext name=$purename [$FTCODE]'		");
		
		index_indexft($edit);
	//$uploadDir = $_REQUEST['uploadDir'];
	//$uploadFile = $uploadDir . $_FILES['Filedata']['name'];
	///move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadFile);
	//printr($_POST);
	if ($redirback=="yes") {
		redir("mediabasic.upload.php?mid=$edit&FTCODE=$FTCODE&fname=".urlencode($purename));
	}


if ($_REQUEST['action'] == 'getMaxFilesize') {
	echo "&maxFilesize=".ini_get('upload_max_filesize');
}
?>