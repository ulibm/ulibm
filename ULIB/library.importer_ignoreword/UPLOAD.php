<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_ignoreword";
	$tmp=mn_lib();
			pagesection(getlang("นำเข้า Stop words::l:: Stop words Importer"));

$dr="../_input/import/";

if ($isupload!="") {

$newname=$_FILES['file']['name'];
// In PHP earlier then 4.1.0, $_FILES  should be used instead of $_FILES. 
//echo $_FILES['file']['name'] . "<BR>";
if ($file_size>$MAX_FILE_SIZE) {
	echo "ขนาดไฟล์ใหญ่เกินไปครับ";
	die();
}

if (strlen($_FILES['file']['tmp_name'])!=0) { 
   copy($_FILES['file']['tmp_name'], "$dr" . $newname); 
} else { 
   echo "Possible file upload attack. Filename: " . $_FILES['file']['name']; 
   echo "ท่านไม่ได้เลือกไฟล์";
	   die;
} 

redir("index.php");
die;
//
}
?>
					  
					  <form name="form1" method="post" action="UPLOAD.php" enctype="multipart/form-data">
                        <table align=center border=0 cordercolor=666666 cellpadding=1 cellspacing=0>
                          <tr bgcolor="#FFFFFF"> 
                          <tr valign=middle bgcolor="#FFFFFF"> 
                            <td class=headsepper bgcolor=#FFFFFF><font color="#000000" face="MS Sans Serif"><?php  echo getlang("อัพโหลดไฟล์::l::Upload file"); ?></font></td>
                            <td class=bodysepper> <font color="#000000"> 
                              <input type="file" name="file"> <input type="submit" name="Submit" value="   Upload   ">
                             <INPUT TYPE="hidden" name=isupload value=yes>
                              <input type="hidden" name="MAX_FILE_SIZE" value="<?php  echo $_GLOBAL_UPLOADSIZE;?>">
                              </font></td>
                          </tr>
						  </table>
                      </form>
<CENTER><A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back"); ?></B></A></CENTER>
					  <?php 
foot();
?>