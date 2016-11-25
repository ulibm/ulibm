<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");
		include_once($dcrs."_addons/0ulibupdate/archive.php");
if ($_ISULIBMASTER=="yes") {
   html_dialog("message","Master site cannot update"); die;
}
$now=time();
pagesection(getlang("ULibM Update"));
?><center><?php
//int
function local_c($wh,$param="") {
	$lurl=barcodeval_get("addonssetting_update_url");
	$lurl=$lurl."_addons/0ulibupdate/sv/index.php?cmd=";
	if ($wh=="listmodule") {
		$lurl=$lurl."listmodule";
	}
	if ($wh=="getsectiondetail") {
		$lurl=$lurl."getsectiondetail&"."sectionname=".base64_encode($param);
	}
	if ($wh=="getsection") {
		$lurl=$lurl."getsection&"."getsectionname=".base64_encode($param);
	}
	//echo  $lurl;
	$tmp=file_get_contents($lurl); 
	//echo "[$tmp]";
	$tmp=base64_decode($tmp);
	//echo"=$tmp<br>";
	return $tmp;
}
$sectionname=base64_decode($sectionname);
$sectionname=trim($sectionname);
$sectionname=strtolower($sectionname);
if ($checkupdate=="yes" && $sectionname!="") {
	$tmp=local_c("getsectiondetail",$sectionname);
	$tmp=unserialize($tmp);
	//printr($tmp);
	?><table width=600 class=table_border align=center>
	<tr>
		<td class=table_td><b>Check Update for: <?php  echo stripslashes($tmp[1])?><font class=smaller2> [<?php  echo stripslashes($tmp[0])?>]</font></b><br>
		<?php  echo stripslashes($tmp[2]);
		echo "<br>";
		echo "<b>".getlang("สถานะ::l::Status")." :</b>";
		echo "<br>";
		if (file_exists($dcrs."".$tmp[0])) {
			echo "".getlang("ติดตั้งแล้ว::l::Installed")."";
			$localdata=local_archiveit_getinfo($dcrs."".$tmp[0]);
			//printr($localdata); printr($tmp);
			if ($localdata[size]!=$tmp[size]."") {
				echo " - <font style='color:darkred'>" .getlang("เวอร์ชันต่างกัน::l::Different version")." </font><a href=\"index.php?getaddon=".base64_encode($tmp[0])."&getnow=yes\" onclick=\"return confirm('Please Confirm Update : ".$tmp[name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> Update</a>";
				//echo "<br>".md5_file($dcrs."_addons/$k/localarchive.tgz")."/".filesize($dcrs."_addons/$k/localarchive.tgz")."!=<br>".$tmp[$k][hashdata]."/".$tmp[$k][size]."<br>";
 			} else {
				echo "  </font><a href=\"index.php?getaddon=".base64_encode($tmp[0])."&getnow=yes\" onclick=\"return confirm('Please Confirm Update : ".$tmp[name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> re-install</a>";
 			}
		} else {
			echo "<font style='color:darkred'>".getlang("ยังไม่ติดตั้ง::l::Not Installed")."</font> <a href=\"index.php?getaddon=".base64_encode($tmp[0])."&getnow=yes\" onclick=\"return confirm('Please Confirm Install : ".$tmp[name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> ".getlang("ติดตั้ง::l::Install")."</a>";
		}
	?>
		</td>
	</tr>
	</table><br><?php 
}

$getaddon=base64_decode($getaddon);
$getaddon=trim($getaddon);
$getaddon=strtolower($getaddon);
if ($getnow=="yes" && $getaddon!="") {
	$tmp=local_c("getsection",$getaddon);
	$tmp=unserialize($tmp);
	//printr($tmp);
	$dlfilename=trim($tmp[dlfilename]);
	if ($dlfilename=="") {
		html_dialog("Error","Cannot get info for download at this time. <br> Click back to continue"); 
		die;
	}
	$tmpfile=$dcrs."_addons/_tmp/tmp.tgz";
	@unlink($tmpfile);
	$sourcefile=barcodeval_get("addonssetting_update_url")."_addons/0ulibupdate/_download/$dlfilename.tgz";
	$tmp=download_tofile($sourcefile,$tmpfile);
	if ($tmp!=true) {
		html_dialog("Error","Cannot download at this time.");
	} else {
	  $destrename=$getaddon;
	  $destrename=str_replace("/","__",$destrename);
	  $destrename=$dcrs.".$destrename"."_updatehide_".randid();
	  $destrename=str_replace("._addons__","_addons/._addons__",$destrename);
		if (rename($dcrs."$getaddon",$destrename)) {
		    echo "Move old folder ok<BR>";
             
   		mkdir($dcrs."$getaddon");
         chmod($dcrs."$getaddon",0777);
   		//extract
   		$b = new gzip_file($tmpfile);
   		$destination=$dcrs."$getaddon";
   		$b->set_options(array('basedir' => "$destination"."", 'overwrite' => 1, 'level' => 0,'storepaths' => 0));
   		$b->extract_files();
         
   		if (count($b->errors) > 0) {
            printr($b->errors);
   			print ("Errors occurred."); // Process errors here
   		}
   		if (count($b->error) > 0) {
            printr($b->error);
   			print ("Errors occurred."); // Process errors here
            echo "<BR>Rolling back operation";
            rename($dcrs."$getaddon",$dcrs."$getaddon"."_updatefail_".randid());
            rename($destrename,$dcrs."$getaddon");
            echo "<BR>Rolling back done";

   		} else {
      		html_dialog("Done","Update and install success");
   		}
         
         
		} else {
		    echo "Error - can not move old folder (moving [$dcrs$getaddon]<BR> to $destrename)<BR>";
		} 

	}
}
if ($check=="yes") {
	?>
	<center><?php 
		echo getlang("คลิกที่ชื่อระบบเพื่อทำการตรวจสอบการอัพเดท::l::Click section's name to check for update");	
	?></center><table width=600 align=center cellspacing=5>
	<?php 
	$tmp=local_c("listmodule");
	$tmp=unserialize($tmp);
	//printr($tmp);
	@reset($tmp);
	while (list($k,$v)=each($tmp)) {
		?><tr valign=top>
		<td width=45 ><img src="hex-70.png" width="45" height="45" border="0" alt="" align=absmiddle ></td><td>
		 <?php 
		echo "<a href=\"index.php?checkupdate=yes&sectionname=".base64_encode($tmp[$k][0])."\"><b style='color:darkblue'>".getlang("ระบบ::l::Section").": ".stripslashes($tmp[$k][1])."</b></a><br>
		".stripslashes($tmp[$k][2])."   ";
		/*echo "Size: ".$tmp[$k][size]."<br>";
		if (file_exists($dcrs."_addons/$k")) {
			echo "".getlang("ติดตั้งแล้ว::l::Installed")."";
			local_archiveit($dcrs."_addons/$k/","local");
			if (md5_file($dcrs."_addons/$k/localarchive.tgz")!=$tmp[$k][hashdata]) {
				echo " - <font style='color:darkred'>" .getlang("เวอร์ชันต่างกัน::l::Different version")." </font><a href=\"index.php?getaddon=$k&getnow=yes\" onclick=\"return confirm('Please Confirm Update : ".$tmp[$k][name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> Update</a>";
				//echo "<br>".md5_file($dcrs."_addons/$k/localarchive.tgz")."/".filesize($dcrs."_addons/$k/localarchive.tgz")."!=<br>".$tmp[$k][hashdata]."/".$tmp[$k][size]."<br>";
			}
		} else {
			echo "<font style='color:darkred'>".getlang("ยังไม่ติดตั้ง::l::Not Installed")."</font> <a href=\"index.php?getaddon=$k&getnow=yes\" onclick=\"return confirm('Please Confirm Install : ".$tmp[$k][name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> ".getlang("ติดตั้ง::l::Install")."</a>";
		}*/

		//echo "<br>";   
		?></td>
	</tr><?php 
	}
	?>
	</table><?php 
}
if ($saveurl=="yes") {
	barcodeval_set("addonssetting_update_url",$addonssetting_update_url);
}
if ($seturl=="yes") {
	?><center><form method="post" action="index.php">
	<input type="hidden" name="saveurl" value="yes">
		URL หลัก : <input type="text" name="addonssetting_update_url" value="<?php  echo barcodeval_get("addonssetting_update_url");?>"> <input type="submit" value="Save">
	</form></center><?php 
}
?><table width=700 align=center>
<tr valign=top>
	<td width=70><img src="logo.png" width="48" height="47" border="0" alt=""></td>
	<td>ULibM Update ช่วยอัพเดทบางส่วนของโปรแกรมที่ท่านใช้งาน<br>
	ให้ตรงรุ่นกับที่เซิร์ฟเวอร์กลางของ ULibM <br>
<a href="index.php?check=yes" class=a_btn>คลิกที่นี่ เพื่อทำการตรวจสอบ</a> 
<a href="index.php?seturl=yes" class="a_btn smaller2">ตั้งค่า</a> </td>
</tr>
</table><?php 


foot();
?>