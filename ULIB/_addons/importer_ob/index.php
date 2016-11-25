<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");

$now=time();
pagesection(getlang("Import from OpenBiblio"));
//int
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
	barcodeval_set("addonssetting_importeropenbib_db",$addonssetting_importeropenbib_db);
	barcodeval_set("addonssetting_importeropenbib_dbuser",$addonssetting_importeropenbib_dbuser);
	barcodeval_set("addonssetting_importeropenbib_dbpasswd",$addonssetting_importeropenbib_dbpasswd);
	barcodeval_set("addonssetting_importeropenbib_dbcoll",$addonssetting_importeropenbib_dbcoll);
	barcodeval_set("addonssetting_importeropenbib_dbhost",$addonssetting_importeropenbib_dbhost);
}
if ($seturl=="yes") {
	?><center><form method="post" action="index.php">
	<input type="hidden" name="saveurl" value="yes">
	Tempolary Database<BR>
	ในการนำเข้าข้อมูลจะต้องนำข้อมูลจากโครงสร้างฐานข้อมูล (ไฟล์ .sql) OpenBiblio ไปใส่ไว้ในฐานข้อมูลชั่วคราวอีกฐานหนึ่ง<BR>
DB host : <input type="text" name="addonssetting_importeropenbib_dbhost" value="<?php  echo barcodeval_get("addonssetting_importeropenbib_dbhost");?>"><BR>
DB name : <input type="text" name="addonssetting_importeropenbib_db" value="<?php  echo barcodeval_get("addonssetting_importeropenbib_db");?>"><BR>
DB User : <input type="text" name="addonssetting_importeropenbib_dbuser" value="<?php  echo barcodeval_get("addonssetting_importeropenbib_dbuser");?>"><BR>
DB Password : <input type="text" name="addonssetting_importeropenbib_dbpasswd" value="<?php  echo barcodeval_get("addonssetting_importeropenbib_dbpasswd");?>"><BR>
SQL File collation : <input type="text" name="addonssetting_importeropenbib_dbcoll" value="<?php  echo barcodeval_get("addonssetting_importeropenbib_dbcoll");?>"><BR>
		 <input type="submit" value="Save">
	</form></center><?php 
}

if ($extracttable=="yes") {
   
   $xdb=barcodeval_get("addonssetting_importeropenbib_db");
	$xdbhost=barcodeval_get("addonssetting_importeropenbib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importeropenbib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importeropenbib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importeropenbib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
   if ($xdbcoll!="") {
      $link->query("set names 'utf8' "); 
   }
   tmq("delete from media_mid where adminnote='addons_importer_openbib' ");
   tmq("delete from media where importid='addons_importer_openbib' ");
   $c1 = $link->query("select count(*) as cc from biblio"); 
   echo mysqli_error($link);
   $s=$link->query("select* from biblio "); //limit 20
   while ($r=mysqli_fetch_array($s)) {
   //   tag082='  ".iconvutf(addslashes($r[call_nmbr1])."^b".iconvutf($r[call_nmbr2])."^c".iconvutf($r[call_nmbr3].""))."',

   $q="insert into media set
   importid='addons_importer_openbib' ,
   LIBSITE='main',
   leader='00000nam  2200000uu 4500',
   tag245='  ".iconvutf(addslashes($r[title]." ".$r[title_remainder])."^c$r[responsibility_stmt]")."',
   tag100='  ".iconvutf(addslashes($r[author]))."',
   tag650='  ".iconvutf(addslashes($r[topic1]))."
  ".iconvutf(addslashes($r[topic2]))."
  ".iconvutf(addslashes($r[topic3]))."
  ".iconvutf(addslashes($r[topic4]))."
  ".iconvutf(addslashes($r[topic5]))."',
   ";
   $s2=$link->query("select distinct tag from biblio_field where bibid='$r[bibid]' "); 
   while ($r2=mysqli_fetch_array($s2)) {
      $tagid=str_fixw("$r2[tag]",3);
      $s3=$link->query("select * from biblio_field where bibid='$r[bibid]' and tag='$r2[tag]' order by subfield_cd"); 
      $tmpdat="";
      while ($r3=mysqli_fetch_array($s3)) {
         $tmpdat.=(addslashes("^$r3[subfield_cd]$r3[field_data]"));
      }
      $q.=" tag$tagid='".iconvutf($tmpdat)."', \n";
   }
   $q=rtrim($q);
   $q=rtrim($q,"\n,");
   //echo "<pre>$q</pre><HR>";
   tmq($q,false);
   $tmpid=mysqli_insert_id($tmq_last_activelink);
   $s2=$link->query("select * from biblio_copy where bibid='$r[bibid]' "); 
   while ($r2=mysqli_fetch_array($s2)) {
      tmq("insert into media_mid set adminnote='addons_importer_openbib' ,pid='$tmpid' ,RESOURCE_TYPE='bk',bcode='$r2[barcode]' ",false);
   }
   }
   ?>
   <script>
   alert("ดำเนินการเรียบร้อย");
   </script>
   <?php
   die;
}
if ($preextracttable=="yes") {
   echo "<center>ตัวอย่างข้อมูล<BR>";
	$xdb=barcodeval_get("addonssetting_importeropenbib_db");
	$xdbhost=barcodeval_get("addonssetting_importeropenbib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importeropenbib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importeropenbib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importeropenbib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
   $c1 = $link->query("select count(*) as cc from biblio"); 
   echo mysqli_error($link);
   $c1=mysqli_fetch_array($c1);
   $c1=$c1[cc];
   echo "<BR>จำนวน Bib: $c1";
   $c1 = $link->query("select count(*) as cc from biblio_copy"); 
   echo mysqli_error($link);
   $c1=mysqli_fetch_array($c1);
   $c1=$c1[cc];
   echo "<BR>จำนวน Item: $c1";
   if ($xdbcoll!="") {
      $link->query("set names 'utf8' "); 
   }
   $c1 = $link->query("select * from biblio limit 5"); 
   echo mysqli_error($link);
   //$c1=mysqli_fetch_array($c1);
  // $c1=$c1[cc];
   echo "<BR>ตัวอย่างข้อมูล";
   while ($r=mysqli_fetch_array($c1)) {
      echo "<BR>&bull; ".iconvutf($r[title])."/$r[author]";
   }
   
       echo "<BR><BR>หากอ่านเป็นภาษาไทยได้ ดำเนินการต่อได้<BR>
       <a href='index.php?extracttable=yes'>คลิกที่นี่เพื่อดำเนินการต่อ</a>";

   
   die;
}
if ($processsqlfile=="yes") {
   	$tmp=trim(barcodeval_get("addonssetting_importeropenbib_db"));
	if ($tmp=="") {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลเป็นค่าว่าง");
	}
	if (strtolower($tmp)==strtolower($dbname)) {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลตรงกันกับฐานที่กำลังใช้งานไม่ได้");
	}
	$xdb=barcodeval_get("addonssetting_importeropenbib_db");
	$xdbhost=barcodeval_get("addonssetting_importeropenbib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importeropenbib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importeropenbib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importeropenbib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
   //consultation: 
   $query = "CREATE DATABASE IF NOT EXISTS $xdb;"; 
   //execute the query. 
   $result = $link->query($query); 
   echo mysqli_error($link);
   //display information: 

	if ($xdbcoll!="") {
	  $result = $link->query("ALTER DATABASE $xdb CHARACTER SET $xdbcoll") or die("Error " . mysqli_error($link)); 
	}
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
	$dr=$dcrs."/_tmp/_import/addontemp_openbib.sql";
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
   if (substr(trim($line), -1, 1) == ';')
   {
       // Perform the query
       $link->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
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
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "addontemp_openbib.sql"); 
	}
	?><center>
	Uploaded: <?php echo $_FILES['selectedfile']['name'];?><BR>
	<?php 
	$tmp=trim(barcodeval_get("addonssetting_importeropenbib_db"));
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
	ในการนำเข้าข้อมูลจะต้องนำข้อมูลจากโครงสร้างฐานข้อมูล OpenBiblio ไปใส่ไว้ในฐานข้อมูลชั่วคราวอีกฐานหนึ่ง<BR>
SQL file จากฐาน OpenBiblio : <INPUT TYPE="file" NAME="selectedfile" size=15 ><BR><BR><BR>
<b style='color:red;'>คำเตือน: ฐานข้อมูลดังกล่าวจะถูกลบ!!</b><BR><BR>
		 <input type="submit" value="Upload">
	</form></center><?php 
}
?><table width=700 align=center>
<tr valign=top>
	<td width=70><img src="logo.png" width="48" height="47" border="0" alt=""></td>
	<td>OpenBiblio Importer<br>
	นำเข้าข้อมูลหนังสือจาก OpenBiblio <br>
   1. <a href="index.php?seturl=yes" class="a_btn smaller2">ตั้งค่า/กำหนดฐานข้อมูลชั่วคราว</a><BR>
   2. <a href="index.php?uploadsql=yes" class="a_btn smaller2">อัพโหลดไฟล์ SQL</a><BR>
   </td>
</tr>
</table><?php 


foot();
?>