<?php 
        include ("../inc/config.inc.php");
loginchk_lib();
?><style>
body {
	background-color: #F4F4F4;
}
</style>
<pre>
<?php 
$dr="../_input/tmpcountuse/";
if ($delll!="" && (strpos($delll,"..")==false)) {
	unlink($dr . stripslashes("$delll"));
}

if ($isupload!="") {

$newname=$_FILES['file']['name'];
// In PHP earlier then 4.1.0, $_FILES  should be used instead of $_FILES. 
//echo $_FILES['file']['name'] . "<BR>";
if ($file_size>$MAX_FILE_SIZE) {
	echo "ขนาดไฟล์ใหญ่เกินไปครับ";
	die();
}

if (strlen($_FILES['file']['tmp_name'])!=0) { 
   if (copy($_FILES['file']['tmp_name'], "$dr" . $newname)) {
	   $fpath=$dr."".$newname;

		barcodeval_set("countuse_import_sepper",$countuse_import_sepper);
		//$sep_rec=stripslashes($countuse_import_sepper);
		//$sep_rec=stripslashes($sep_rec);
		eval("\$sep_rec=\"$countuse_import_sepper\";");

		//echo "[$sep_rec]";
		//start melt
		$Stime=time();

	$reclimit =100000;
	$roundlimit =10000;
	$handle = fopen("$fpath", "rb");
	$i=0;
	$reclist=Array();
	$wholebuffer="";
	$roundcount=0;
	while (!feof($handle)) {
		$roundcount++;
		if ($i>$reclimit || $roundcount>=$roundlimit) {
			break;
		}
		$buffer =  fread($handle, 1) ;
		//echo "(".("$buffer")."==".$sep_rec.")<br>		";
		if ($buffer==$sep_rec) {
		//echo "(*************************)";
			$i++;
			$reclist[]=$wholebuffer;
			//echo "adding".$wholebuffer."<br>";
			$wholebuffer="";
		} else {
			$wholebuffer=$wholebuffer.$buffer;
		}
	}
	//$reclist[]=$buffer;
	//print_r($reclist);
	//echo "$roundcount";
	fclose($handle);
	$reclist=arr_filter_remnull($reclist);
	$reclist=array_unique($reclist);
	@reset($reclist);
	//printr($reclist);

		$reclistcount=count($reclist);
		$countexec=0;
			for ($i=0;$i<=$reclistcount;$i++) {
				$tmp=$reclist[$i];
				$tmp=trim($tmp);
				if ($tmp=="") { continue; }
				$s="update media_mid  set $qnid='YES' ";
				$s.="  where bcode='".addslashes($tmp)."' ";
				tmq( $s,false);
				$countexec=$countexec+1;
			}


		$Etime=time();

		?> 

		</TABLE>
		<BR><CENTER>
		<?php  echo getlang("การนำเข้าเรียบร้อย อัพเดท ::l::Update successfull "); ?><?php  echo number_format($countexec);?> <?php  echo getlang("รายการ โดยใช้เวลา::l:: records in"); ?>  <?php  echo number_format(($Etime-$Stime));?> <?php  echo getlang("วินาที::l::second"); ?><BR><?php 

   } else {
		echo getlang("Cannot upload file");;
		die;
   }

} else { 
   echo "Possible file upload attack. Filename: " . $_FILES['file']['name']; 
   echo "ท่านไม่ได้เลือกไฟล์";
	   die;
} 


//
}
?>
					  
					  <form name="form1" method="post" action="import.php" enctype="multipart/form-data">
                        <table align=center border=0 cordercolor=666666 cellpadding=1 cellspacing=0>
                          <tr bgcolor="#FFFFFF"> 
                          <tr valign=middle bgcolor="#FFFFFF"> 
                            <td class=headsepper bgcolor=#FFFFFF><font color="#000000" face="MS Sans Serif">อัพโหลดไฟล์</font></td>
                            <td class=bodysepper> <font color="#000000"> 
                              <input type="file" name="file"><br>
							  <?php  echo getlang("อักขระแยกรายการ::l::Seperator");?> <input type="text" name="countuse_import_sepper" value="\n">
							  <input type="submit" name="Submit" value="   Upload   ">
                             <INPUT TYPE="hidden" name=isupload value=yes>
                             <INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
							 <br />
<?php  echo getlang("ห้ามอัพโหลดไฟล์ที่ชื่อไฟล์มีเครื่องหมายพิเศษ::l::Do not upload file with special sign in filename.");?>
                              <input type="hidden" name="MAX_FILE_SIZE" value="<?php  echo $_GLOBAL_UPLOADSIZE;?>">
                              </font></td>
                          </tr>
						  </table>
                      </form>