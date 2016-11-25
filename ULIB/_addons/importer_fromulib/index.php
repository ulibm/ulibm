<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("info.php");
head();
if ($upgradetable=="yes") {
   loginchk_lib();
} else {
   include("../chkpermission.php");
   include("../menu.php");
}
include("func.php");

$now=time();
pagesection(getlang("Import from ULib"));
//int
if ($dbmode=="mysql") {
   html_dialog("Warinig","ขณะนี้ใช้การเชื่อมต่อ MySQL - ควรใช้การเชื่อมต่อแบบ MySQLi");
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
if ($saveurl=="yes") {
	barcodeval_set("addonssetting_importerfromulib_db",$addonssetting_importerfromulib_db);
	barcodeval_set("addonssetting_importerfromulib_dbuser",$addonssetting_importerfromulib_dbuser);
	barcodeval_set("addonssetting_importerfromulib_dbpasswd",$addonssetting_importerfromulib_dbpasswd);
	barcodeval_set("addonssetting_importerfromulib_dbcoll",$addonssetting_importerfromulib_dbcoll);
	barcodeval_set("addonssetting_importerfromulib_dbhost",$addonssetting_importerfromulib_dbhost);
}
if ($seturl=="yes") {
	?><center><form method="post" action="index.php">
	<input type="hidden" name="saveurl" value="yes">
	Tempolary Database<BR>
	ในการนำเข้าข้อมูลจะต้องนำข้อมูลจากโครงสร้างฐานข้อมูล (ไฟล์ .sql) จากการสำรองข้อมูล ไปใส่ไว้ในฐานข้อมูลชั่วคราวอีกฐานหนึ่ง<BR>
DB host : <input type="text" name="addonssetting_importerfromulib_dbhost" value="<?php  echo barcodeval_get("addonssetting_importerfromulib_dbhost");?>"><BR>
DB name : <input type="text" name="addonssetting_importerfromulib_db" value="<?php  echo barcodeval_get("addonssetting_importerfromulib_db");?>"><BR>
DB User : <input type="text" name="addonssetting_importerfromulib_dbuser" value="<?php  echo barcodeval_get("addonssetting_importerfromulib_dbuser");?>"><BR>
DB Password : <input type="text" name="addonssetting_importerfromulib_dbpasswd" value="<?php  echo barcodeval_get("addonssetting_importerfromulib_dbpasswd");?>"><BR>
SQL File collation : <input type="text" name="addonssetting_importerfromulib_dbcoll" value="<?php  echo barcodeval_get("addonssetting_importerfromulib_dbcoll");?>"><BR>
		 <input type="submit" value="Save">
	</form></center><?php 
}
if ($upgradetable=="yes") {
   echo "<center>";
   include($dcrs."root.upgrade_tocurrent/tbtoupdate.php");
      $xdb=barcodeval_get("addonssetting_importerfromulib_db");
	$xdbhost=barcodeval_get("addonssetting_importerfromulib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importerfromulib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importerfromulib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importerfromulib_dbcoll");
	
	$tmq_autoconnect_collation="utf8";
   $tmq_autoconnect_host=$xdbhost;
   $tmq_autoconnect_user=$xdbuser;
   $tmq_autoconnect_passwd=$xdbpasswd;
   $ui_dbname=$xdb;
   $ui_collation=$xdbcoll;
   
      $ui_collation=$xdbcoll;
   //if ($ui_collation!="") {
   	//tmq("set names 'utf8';",false,$ui_dbname);
   //}
   $numset=count($tbtoupdate);
	if ($page=="") {
		$page=0;
	} else {
		$page=$page+1;
	}
		@reset($tbtoupdate);
      $currenttb=$tbtoupdate[$page];
		 echo getlang("กำลังอัพเกรด [$currenttb] หลังจากเสร็จ จะทำการอัพเกรดรอบต่อไปโดยอัตโนมัติ::l::. Upgrading [$currenttb]  , After finish this file, system will continue automatically"); ?><BR><BR><BR>
	<FONT SIZE="" COLOR="#5D5D5D"><B><H1>[<?php  echo $page +1?>/<?php  echo $numset ?>]</H1></B></FONT><BR><CENTER><?php 
	echo html_graph("V",$numset+1,$page,20,800,"#952F2F");
	$redirpath="index.php?upgradetable=yes&page=".($page)."&rand=".randid();
	$redirpathback="index.php?upgradetable=yes&page=".($page-1)."&rand=".randid();
	echo "</CENTER><BR><BR><BR>Creating INFO.struct ..";
    ob_flush();
    flush();
	//usleep(100);
   $ui_table=$currenttb;


   /////////////////tables form our db
   $sql = "SHOW columns FROM $ui_table";
   //$result = tmq($sql);
   $result = tmq($sql,false);
   echo "<!-- ";
   echo " -->";

   $my_col=Array();
   while ($r=tmq_fetch_array($result)) {
   	$my_col[]=$r[0];
   }
   ///////////////////
   	///////////////////
   $sql = "SHOW columns FROM $ui_table";
   $result = tmq($sql,false,$ui_dbname);
   echo "<!-- ";
   echo " -->";
   $remote_col=Array();
   echo "<!-- ";
   while ($r=tmq_fetch_array($result)) {
   	$remote_col[]=$r[0];
   }
   echo " -->";
   echo "[".count($remote_col)."] columns<BR>";


      //tmq("set names '$ui_collation';",false,$ui_dbname);
      $sql = "SELect * FROM $ui_table";
      $result = tmq($sql,false,$ui_dbname);
      echo "[".floor(tnr($result))."] records<BR>";
      echo "<!-- ";
      $tnrnum=floor(tnr($result));
      echo " -->";
     // if ($tnrnum>0) {
         //echo " [delete] ";
      	tmq("delete from $ui_table",false,"-localdb-");
         echo "<!-- ";
      	echo " -->";
      //} //else die("die");
      $content="";
      $i=0;
      echo "<!-- ";
      		while ($row=tfa($result)) {
                  $insert = "INSERT INTO $ui_table set ";
      			$usej=0;
                  for ($j=0; $j < tmq_num_fields($result); $j++) {
      				//echo $remote_col[$j]. " : j=$j/usej=$usej<br>";
      				if (!in_array($remote_col[$j],$my_col)) {
      					echo "not in array $remote_col[$j]<BR>";
      					continue;
      				}
      				$usej++;
      				$insert.=" $remote_col[$j]=";
                      if (!isset($row[$j]))
                          $insert.="'',";
                      else if ($row[$j] != "")
                          $insert.="'" . addslashes($row[$j]) . "',";
                      else
                          $insert.="'',";
      			}
      			//$insert=preg_replace(",$", "", $insert);
      			$insert=rtrim($insert,",");
      			$insert.=";\n";
      			$content.=$insert;
      			//echo $insert; 
      			if ($i<20) {
      				tmq($insert,false,"-localdb-");
      			} else { //die;
      				tmq($insert,false,"-localdb-");
      			}
      			$i++;
      		}
      		echo " -->";

      ///die;
          ob_flush();
          flush();
   	//usleep(100);

?><CENTER>
<?php  echo getlang("เรียบร้อย ดำเนินการจำนวน $i รายการ::l::DONE,  ecexcuted  $i  times"); ?></CENTER><BR><BR>
<?php 
	
  // die;

	?><CENTER><?php 
   $numset=count($tbtoupdate);
  // echo "[$page/$numset]";
   if ($currenttb=="" || $page>=($numset-1)) {
   	?><SCRIPT LANGUAGE="JavaScript">
   	<!--
   	alert("UPGRADE COMPLETED");
   	//-->
	</SCRIPT>
   
   <?php 
	//redir("index.php?upgradetable=yes",0);

       echo "<BR><BR>ดำเนินการเสร็จสมบูรณ์ กรุณาคลิกไปที่เมนูหลักเพื่อตรวจสอบข้อมูล<BR> หรือ ล็อกเอาท์แล้วล็อกอินใหม่ หากระบบล็อกอินมีปัญหา<BR>";
       echo "<a href='../../library/'>Main menu</a>";
       $s=tmq("select * from library");
       while ($r=tfa($s)) {
         tmq("delete from library_permission where code='mainmenu' and lib='$r[UserAdminID]' ");
         tmq("insert into library_permission set code='mainmenu' , lib='$r[UserAdminID]'");
       }
       } else {
       redir($redirpath,0);
       }
   die;
   
}
if ($extractvariable=="yes") {
   echo "<center>";
   $xdb=barcodeval_get("addonssetting_importerfromulib_db");
	$xdbhost=barcodeval_get("addonssetting_importerfromulib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importerfromulib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importerfromulib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importerfromulib_dbcoll");
	
	$tmq_autoconnect_collation="utf8";
   $tmq_autoconnect_host=$xdbhost;
   $tmq_autoconnect_user=$xdbuser;
   $tmq_autoconnect_passwd=$xdbpasswd;
   $ui_dbname=$xdb;
   $ui_collation=$xdbcoll;
   //if ($ui_collation!="") {
   	tmq("set names 'utf8';",false,$ui_dbname);
   //}
$sql = "select * FROM val";
//echo "[$ui_dbname]";
$result = tmq($sql,false,$ui_dbname);
echo tmq_error();
$content="";
$i=0;
while ($row=tfa($result)) {
	//printr($row);
	/*echo "[".($row[descr])."]"; 
	echo "[".iconvutf($row[descr])."]"; 
	echo "[".iconvth($row[descr])."]"; die;*/
	$s=tmq("select * from val where main='$row[main]' and sub='$row[sub]' ",false);
	if (tmq_num_rows($s)==1) {
		$rval=stripslashes($row[val]);
		$rval=stripslashes($rval);
		$rval=stripslashes($rval);
		$rval=addslashes($rval);
		//$rval=iconvth($rval);
		$s="update val set val='$rval' where main='$row[main]' and sub='$row[sub]' ";
		//echo $s."<BR>";
		tmq($s,false);
	}
}

$sql = "select * FROM barcode_val";
$tmq_autoconnect_collation=$ui_collation;
$result = tmq($sql,false,$ui_dbname);
echo tmq_error();
$content="";
$i=0;
while ($row=tfa($result)) {
	//printr($row);
	$s=tmq("select * from barcode_val where classid='$row[classid]'  ",false);
	if (tmq_num_rows($s)==1) {
		$rval=stripslashes($row[val]);
		$rval=stripslashes($rval);
		$rval=stripslashes($rval);
		$rval=addslashes($rval);
		//$rval=iconvutf($rval);
		$s="update barcode_val set val='$rval' where  classid='$row[classid]' ";
		//echo $s."<BR>";
		tmq($s);
	}
}
tmq("delete from valmem");
tmq("delete from barcode_valmem");

	barcodeval_set("addonssetting_importerfromulib_db",$xdb);
	barcodeval_set("addonssetting_importerfromulib_dbuser",$xdbuser);
	barcodeval_set("addonssetting_importerfromulib_dbpasswd",$xdbpasswd);
	barcodeval_set("addonssetting_importerfromulib_dbcoll",$xdbcoll);
	barcodeval_set("addonssetting_importerfromulib_dbhost",$xdbhost);
   
       echo "<BR><BR>นำเข้าค่าตัวแปรเรียบร้อย คลิกดำเนินการต่อเพื่อเริ่มดึงข้อมูลทั้งหมด<BR>
       <a href='index.php?upgradetable=yes'>คลิกที่นี่เพื่อดำเนินการต่อ</a>";

   die;
}
if ($preextracttable=="yes") {
   echo "<center>ตัวอย่างข้อมูล<BR>";
	$xdb=barcodeval_get("addonssetting_importerfromulib_db");
	$xdbhost=barcodeval_get("addonssetting_importerfromulib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importerfromulib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importerfromulib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importerfromulib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
   $c1 = $link->query("select count(*) as cc from media"); 
   echo mysqli_error($link);
   $c1=mysqli_fetch_array($c1);
   $c1=$c1[cc];
   echo "<BR>จำนวน Bib: $c1";
   $c1 = $link->query("select count(*) as cc from media_mid"); 
   echo mysqli_error($link);
   $c1=mysqli_fetch_array($c1);
   $c1=$c1[cc];
   echo "<BR>จำนวน Item: $c1";
   //if ($xdbcoll!="") {
      $link->query("set names 'utf8' "); 
   //}
   $c1 = $link->query("select * from media order by rand() limit 5"); 
   echo mysqli_error($link);
   //$c1=mysqli_fetch_array($c1);
  // $c1=$c1[cc];
   echo "<BR>ตัวอย่างข้อมูล";
   while ($r=mysqli_fetch_array($c1)) {
      echo "<BR>&bull; ".iconvutf($r[tag245])."/$r[tag100]";
   }

   //if ($xdbcoll!="") {
      $link->query("set names 'utf8' "); 
   //}
      $c1 = $link->query("select count(*) as cc from member"); 
   echo mysqli_error($link);

      $c1=mysqli_fetch_array($c1);
   $ccm=$c1[cc];
   $c1 = $link->query("select * from member order by rand() limit 5"); 
   echo mysqli_error($link);
   
   //$c1=mysqli_fetch_array($c1);
  // $c1=$c1[cc];
     echo "<BR><BR>จำนวน Member: $ccm";

   echo "<BR>ตัวอย่างข้อมูล";
   while ($r=mysqli_fetch_array($c1)) {
      echo "&bull; ".iconvutf($r[UserAdminName])." ";
   }
   
       echo "<BR><BR>หากอ่านเป็นภาษาไทยได้ ดำเนินการต่อได้<BR>
       <a href='index.php?extractvariable=yes'>คลิกที่นี่เพื่อดำเนินการต่อ</a>";

   
   die;
}
if ($processsqlfile=="yes") {
   	$tmp=trim(barcodeval_get("addonssetting_importerfromulib_db"));
	if ($tmp=="") {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลเป็นค่าว่าง");
	}
	if (strtolower($tmp)==strtolower($dbname)) {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลตรงกันกับฐานที่กำลังใช้งานไม่ได้");
	}
	$xdb=barcodeval_get("addonssetting_importerfromulib_db");
	$xdbhost=barcodeval_get("addonssetting_importerfromulib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importerfromulib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importerfromulib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importerfromulib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd") or die("Error " . mysqli_error($link)); 
   //consultation: 
   $query = "CREATE DATABASE IF NOT EXISTS $xdb;"; 
   //execute the query. 
   $result = $link->query($query); 
   echo mysqli_error($link);
   //display information: 

	if ($xdbcoll!="") {
	  $result = $link->query("ALTER DATABASE $xdb CHARACTER SET $xdbcoll") or die("Error " . mysqli_error($link)); 
	}
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
	//delete all tb s
   $result = tmq("show tables;",false,$link);
   $rt=Array();
   while ($r=tfa($result)) {
      //echo $r[0];
      $link->query("drop table $r[0];"); 
   }
   //die;
	
	//delete all tb e
	$result = $link->query("set names '$xdbcoll'"); 
	$dr=$dcrs."/_tmp/_import/addontemp.sql";
	//die($dr);
	// Temporary variable, used to store current query
   $templine = '';
   // Read in entire file
   $lines = file($dr);
   // Loop through each line
   foreach ($lines as $line)
   {
   // Skip it if it's a comment
   if (substr($line, 0, 2) == '--' || $line == '')
       continue;

   // Add this line to the current segment
   $templine .= $line;
   // If it has a semicolon at the end, it's the end of the query
   if (substr(trim($line), -4, 4) == ';#%%')
   {
       // Perform the query
       $link->query($templine) or print('Error performing query \'<strong style="color:red">' . $templine . '\': </strong>' . tmq_error() . '<br /><br />');
       // Reset temp variable to empty
       $templine = '';
   }
   }
   echo "<center>";
    echo "import done;<BR>";
    echo "<a href='index.php?preextracttable=yes'>คลิกที่นี่เพื่อดำเนินการต่อ</a>;";

	die;
}
if ($uploadingsql=='yes') {
	$dr="$dcrs/_tmp/_import/";
	@mkdir($dr);
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) {
	  //printr($_FILES); die;
	  if (strtolower(substr($_FILES['selectedfile']['name'],-4))==".zip") {
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "addontemp.zip");
	   $zip = new ZipArchive;
      $res = $zip->open("$dr" . "addontemp.zip");
      if ($res === TRUE) {
        $zip->extractTo($dr);
        echo '<center>Zip file extracted';
        //for( $i = 0; $i < $zip->numFiles; $i++ ){ 
            $stat = $zip->statIndex( 0 ); 
            $firstfilename=( basename( $stat['name'] )  ); 
        //}
        echo "<BR>First file in zip file= [$firstfilename]</center>";
        @unlink("$dr" . "addontemp.sql");
        rename("$dr" . "$firstfilename","$dr" . "addontemp.sql");
        $zip->close();
      } else {
        echo 'Cannot extract zip file';
      }
	  } elseif(strtolower(substr($_FILES['selectedfile']['name'],-3))==".gz") {
	  	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "addontemp.gz");
         $file_name="$dr" . "addontemp.gz";
         $buffer_size = 4096; // read 4kb at a time
         $out_file_name = "$dr" . "addontemp.sql"; 
         @unlink($out_file_name);
         // Open our files (in binary mode)
         $file = gzopen($file_name, 'rb');
         $out_file = fopen($out_file_name, 'wb'); 
         // Keep repeating until the end of the input file
         while(!gzeof($file)) {
         // Read buffer-size bytes
         // Both fwrite and gzread and binary-safe
           fwrite($out_file, gzread($file, $buffer_size));
         }  
        echo "<center>.GZ file extracted</center>";         // Files are done, close files
         fclose($out_file);
         gzclose($file);
	  } else {
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "addontemp.sql"); 
	  }
	}
	?><center>
	Uploaded: <?php echo $_FILES['selectedfile']['name']; 
	echo " ";
function local_getfilesize($wh) {
   clearstatcache(true);
	//echo $wh2;
	if (file_exists($wh)) {
		return number_format(filesize($wh)/1024)."kb";
	} else {
		return " ไม่พบไฟล์ ";
	}
}
   echo local_getfilesize("$dr" . "addontemp.sql");
	?><BR>
	<?php 
	$tmp=trim(barcodeval_get("addonssetting_importerfromulib_db"));
	if ($tmp=="") {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลเป็นค่าว่าง");
	}
	if (strtolower($tmp)==strtolower($dbname)) {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลตรงกันกับฐานที่กำลังใช้งานไม่ได้");
	}
	?>
	<a href="index.php?processsqlfile=yes">คลิกที่นี่เพื่อดำเนินการต่อ</a><BR>
	<br>
	<?php
	die;
}
if ($uploadsql=="yes") {
	?><center><form method="post" action="index.php" enctype="multipart/form-data" >
	<input type="hidden" name="uploadingsql" value="yes">
	นำเข้าสู่ Tempolary Database<BR>
	ในการนำเข้าข้อมูลจะต้องนำข้อมูลจากโครงสร้างฐานข้อมูลที่ได้จากการสำรองข้อมูล ไปใส่ไว้ในฐานข้อมูลชั่วคราวอีกฐานหนึ่ง<BR>
SQL file จากการสำรองข้อมูล : <INPUT TYPE="file" NAME="selectedfile" size=15 ><BR><BR><BR>
<b style='color:red;'>คำเตือน: ฐานข้อมูลดังกล่าวจะถูกลบ!!</b><BR>
<b style='color:red;'>คำเตือน: ฐานข้อมูลปัจจุบันจะถูกลบและถูกอัพเดททับ!!</b><BR>

<BR>
<font class=smaller2>(หากไฟล์มีขนาดใหญ่ สามารถ zip ไฟล์, ใช้ไฟล์ .gz ได้)</font>
<BR>
		 <input type="submit" value="Upload">
	</form></center><?php 
}
?><table width=700 align=center>
<tr valign=top>
	<td width=70><img src="logo.png" width="48" height="47" border="0" alt=""></td>
	<td>Importer<br>
	นำเข้าข้อมูลและอัพเกรดข้อมูลต่าง ๆ จากเวอร์ชันเก่า <br>
   1. <a href="index.php?seturl=yes" class="a_btn smaller2">ตั้งค่า/กำหนดฐานข้อมูลชั่วคราว</a><BR>
   2. <a href="index.php?uploadsql=yes" class="a_btn smaller2">อัพโหลดไฟล์ SQL</a><BR>
   </td>
</tr>
</table><?php 


foot();
?>