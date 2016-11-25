<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		//html_start();
		include("_REQPERM.php");
		loginchk_lib();
		html_start();
       // mn_lib();

$dr="../_input/";
$_coengine="offlinecir";
if ($isupload!="") {
	$newname="offlinecirdata.txt";
	// In PHP earlier then 4.1.0, $_FILES  should be used instead of $_FILES. 
	//echo $_FILES['file']['name'] . "<BR>";
	$importid=addslashes($_FILES['file']['name'])."-".ymd_datestr(time());
	if ($file_size>$MAX_FILE_SIZE) {
		echo "ขนาดไฟล์ใหญ่เกินไปครับ";
		die();
	}
	$now=time();
	if (strlen($_FILES['file']['tmp_name'])!=0) { 
		@unlink("$dr" . $newname);
	   copy($_FILES['file']['tmp_name'], "$dr" . $newname); 
		// s
		$eventdt=strip_tags(form_pickdt_get("eventdt"));
		$Fdat=$eventdt_dat;
		$Fmon=$eventdt_mon;
		$Fyea=$eventdt_yea;
		echo " <b>Operation Date</b> ".ymd_datestr($eventdt,"date")."<br>";
		$handle = @fopen($dcrs."_input/$newname", "r");
		if ($handle) {
			while (($buffer = fgets($handle, 4096)) !== false) {
				echo "<br>&nbsp;&nbsp;&nbsp;";
				$da=explode(":",$buffer);
				if ($da[0]=="i") {
					echo "checkin: ".$da[1];
					$res=cir_checkin($da[1],$Fdat,$Fmon,$Fyea+543,"yes");
					//printr($res);
					//echo "cir_checkin($da[1],$Fdat,$Fmon,$Fyea);"; die;
					tmq("insert into offlinecir set importid='$importid',dt='$now',act='checkin',data='".addslashes($buffer)."',res='".$res[status]."' ,fullres='".serialize($res)."' ");
				} elseif ($da[0]=="o") {
					echo "checkout: ".$da[2]." by ".$da[1];
					$res=cir_checkout($da[1],$da[2],$Fdat,$Fmon,$Fyea+543,"yes",$forcedt_dat,$forcedt_mon,$forcedt_yea+543);
					//printr($res);
					tmq("insert into offlinecir set importid='$importid',dt='$now',act='checkout',data='".addslashes($buffer)."',res='".$res[status]."',fullres='".serialize($res)."' ");
				} else {
					tmq("insert into offlinecir set importid='$importid',dt='$now',act='unknown',data='".addslashes($buffer)."',res='error' ");
					echo "unknown action: $buffer;";
				}

			}
			if (!feof($handle)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($handle);
			?><hr>Done<?php 
				die;
		}
		// e
	} else { 
	   echo "Possible file upload attack. Filename: " . $_FILES['file']['name']; 
	   echo "ท่านไม่ได้เลือกไฟล์";
		   die;
	} 
}
?>
					  
					  <form name="form1" method="post" action="<?php  echo $PHP_SELF;?>" enctype="multipart/form-data">
                        <table align=center border=0 cordercolor=666666 cellpadding=1 cellspacing=0>
                          <tr bgcolor="#FFFFFF"> 
                          <tr valign=top bgcolor="#FFFFFF"> 
                            <td class=headsepper bgcolor=#FFFFFF><font color="#000000" face="MS Sans Serif">อัพโหลดไฟล์</font></td>
                            <td class=bodysepper> <font color="#000000"> 
                              <input type="file" name="file"> 
                             <INPUT TYPE="hidden" name=isupload value=yes><br />
							 <?php 
							 $oldval=time();
							echo getlang("กำหนดวันที่::l::Operation Date")." ";
							 form_quickedit("eventdt",$oldval,"date")
							 ?><br>							 <?php 
							 $oldval=time();
							echo getlang("กรณียืมแล้วข้อมูลไม่สมบูรณ์ ให้กำหนดส่งวันที่::l::In case of lack of data, set due date to")." ";
							 form_quickedit("forcedt",$oldval,"date")
							 ?><br><center><input type="submit" name="Submit" value="   Upload & Process   "></center>
                              <input type="hidden" name="MAX_FILE_SIZE" value="<?php  echo $_GLOBAL_UPLOADSIZE;?>">
                              </font></td>
                          </tr>
						  </table>
                      </form>