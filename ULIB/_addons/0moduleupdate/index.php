<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");
		include_once($dcrs."_addons/0moduleupdate/archive.php");

$now=time();
pagesection(getlang("ULibM Module Update"));
//int
if ($_ISULIBMASTER=="yes") {
   html_dialog("message","Master site cannot update"); die;
}
function local_c($wh) {
	$lurl=barcodeval_get("addonssetting_moduleupdate_url");
	$lurl=$lurl."_addons/0moduleupdate/sv/index.php?cmd=";
	if ($wh=="listmodule") {
		$lurl=$lurl."listmodule";
	}
	//echo $lurl;
	$tmp=file_get_contents($lurl); 
	$tmp=base64_decode($tmp);
	//echo $lurl."=$tmp<br>";
	return $tmp;
}
$getaddon=trim($getaddon);
$getaddon=strtolower($getaddon);
if ($getnow=="yes" && $getaddon!="") {
	$tmp=local_c("listmodule");
	$tmp=unserialize($tmp);
	$tmpfile=$dcrs."_addons/_tmp/tmp.tgz";
	@unlink($tmpfile);
	$sourcefile=barcodeval_get("addonssetting_moduleupdate_url")."_addons/$getaddon/archive.tgz";
	$tmp=download_tofile($sourcefile,$tmpfile);
	if ($tmp!=true) {
		html_dialog("Error","Cannot download at this time.");
	} else {
      $hidename=$dcrs."_addons/.$getaddon"."_updatehide_".randid();
		rename($dcrs."_addons/$getaddon",$hidename);
		mkdir($dcrs."_addons/$getaddon");
		//extract
		$b = new gzip_file($tmpfile);
		$destination=$dcrs."_addons/$getaddon";
		$b->set_options(array('basedir' => "$destination"."", 'overwrite' => 1, 'level' => 1,'storepaths' => 0));
		$b->extract_files();
		if (count($b->errors) > 0) {
			print ("Errors occurred."); // Process errors here
		}
		if (count($b->error) > 0) {
         printr($b->error);
			print ("Errors occurred."); // Process errors here
          echo "<BR>Rolling back operation";
           rename($dcrs."_addons/$getaddon",$dcrs."_addons/.$getaddon"."_updatefail_".randid());
            rename($hidename,$dcrs."_addons/$getaddon");
            echo "<BR>Rolling back done";
		} else {
   		html_dialog("Done","Update and install success");
		}
	}
}
if ($check=="yes") {
	?><table width=600 align=center cellspacing=5>
	<?php 
	$tmp=local_c("listmodule");
	$tmp=unserialize($tmp);
	//printr($tmp);
	@reset($tmp);
	while (list($k,$v)=@each($tmp)) {
		?><tr valign=top>
		<td width=69 background=hex-70.png height=72><img src="<?php  echo barcodeval_get("addonssetting_moduleupdate_url");;?>_addons/<?php  echo $k;?>/logo.png" width="20" height="20" border="0" alt="" align=absmiddle style="padding-top: 24px;padding-left: 24px;"></td><td>
		 <?php 
		echo "<b style='color:darkblue'>Module: ".$tmp[$k][name]."</b><br>";
		echo "Size: ".$tmp[$k][size]."<br>";
		if (file_exists($dcrs."_addons/$k")) {
			echo "".getlang("ติดตั้งแล้ว::l::Installed")."";
			local_archiveit($dcrs."_addons/$k/","local");
         //echo sha1_file($dcrs."_addons/$k/localarchive.tgz")."!=".$tmp[$k][hashdata];
			//if (md5_file($dcrs."_addons/$k/localarchive.tgz")!=$tmp[$k][hashdata]) {
			if (filesize($dcrs."_addons/$k/localarchive.tgz")!=$tmp[$k][size]) {
				echo " - <font style='color:darkred'>" .getlang("เวอร์ชันต่างกัน::l::Different version")." </font><a href=\"index.php?getaddon=$k&getnow=yes\" onclick=\"return confirm('Please Confirm Update : ".$tmp[$k][name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> Update</a>";
				//echo "<br>".md5_file($dcrs."_addons/$k/localarchive.tgz")."/".filesize($dcrs."_addons/$k/localarchive.tgz")."!=<br>".$tmp[$k][hashdata]."/".$tmp[$k][size]."<br>";
			} else {
				echo "  </font><a href=\"index.php?getaddon=$k&getnow=yes\" onclick=\"return confirm('Please Confirm Update : ".$tmp[$k][name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> re-install</a>";
			}
		} else {
			echo "<font style='color:darkred'>".getlang("ยังไม่ติดตั้ง::l::Not Installed")."</font> <a href=\"index.php?getaddon=$k&getnow=yes\" onclick=\"return confirm('Please Confirm Install : ".$tmp[$k][name]."')\"><img src='../../neoimg/misc/icongo03.gif' width='20' height='20' border='0' alt='' align=absmiddle> ".getlang("ติดตั้ง::l::Install")."</a>";
		}

		//echo "<br>";   
		?></td>
	</tr><?php 
	}
	?>
	</table><?php 
}
if ($saveurl=="yes") {
	barcodeval_set("addonssetting_moduleupdate_url",$addonssetting_moduleupdate_url);
}
if ($seturl=="yes") {
	?><center><form method="post" action="index.php">
	<input type="hidden" name="saveurl" value="yes">
		URL หลัก : <input type="text" name="addonssetting_moduleupdate_url" value="<?php  echo barcodeval_get("addonssetting_moduleupdate_url");?>"> <input type="submit" value="Save">
	</form></center><?php 
}
?><table width=700 align=center>
<tr valign=top>
	<td width=70><img src="logo.png" width="48" height="47" border="0" alt=""></td>
	<td>ULibM Module Update ช่วยอัพเดทโมดูลหรือ Addons ที่ท่านใช้งาน<br>
	ให้ตรงรุ่นกับที่เซิร์ฟเวอร์กลางของ ULibM <br>
<a href="index.php?check=yes" class=a_btn>คลิกที่นี่ เพื่อทำการตรวจสอบ</a> 
<a href="index.php?seturl=yes" class="a_btn smaller2">ตั้งค่า</a> </td>
</tr>
</table><?php 


foot();
?>