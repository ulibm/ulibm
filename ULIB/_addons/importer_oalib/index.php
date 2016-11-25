<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");

$now=time();
pagesection(getlang("Import from oaliblio"));
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
	barcodeval_set("addonssetting_importeroalib_db",$addonssetting_importeroalib_db);
	barcodeval_set("addonssetting_importeroalib_dbuser",$addonssetting_importeroalib_dbuser);
	barcodeval_set("addonssetting_importeroalib_dbpasswd",$addonssetting_importeroalib_dbpasswd);
	barcodeval_set("addonssetting_importeroalib_dbcoll",$addonssetting_importeroalib_dbcoll);
	barcodeval_set("addonssetting_importeroalib_dbhost",$addonssetting_importeroalib_dbhost);
}
if ($seturl=="yes") {
	?><center><form method="post" action="index.php">
	<input type="hidden" name="saveurl" value="yes">
	Tempolary Database<BR>
	ในการนำเข้าข้อมูลจะต้องนำข้อมูลจากโครงสร้างฐานข้อมูล (ไฟล์ .sql) oaliblio ไปใส่ไว้ในฐานข้อมูลชั่วคราวอีกฐานหนึ่ง<BR>
DB host : <input type="text" name="addonssetting_importeroalib_dbhost" value="<?php  echo barcodeval_get("addonssetting_importeroalib_dbhost");?>"><BR>
DB name : <input type="text" name="addonssetting_importeroalib_db" value="<?php  echo barcodeval_get("addonssetting_importeroalib_db");?>"><BR>
DB User : <input type="text" name="addonssetting_importeroalib_dbuser" value="<?php  echo barcodeval_get("addonssetting_importeroalib_dbuser");?>"><BR>
DB Password : <input type="text" name="addonssetting_importeroalib_dbpasswd" value="<?php  echo barcodeval_get("addonssetting_importeroalib_dbpasswd");?>"><BR>
SQL File collation : <input type="text" name="addonssetting_importeroalib_dbcoll" value="<?php  echo barcodeval_get("addonssetting_importeroalib_dbcoll");?>"><BR>
		 <input type="submit" value="Save">
	</form></center><?php 
}

if ($extracttable=="yes") {
   
   $xdb=barcodeval_get("addonssetting_importeroalib_db");
	$xdbhost=barcodeval_get("addonssetting_importeroalib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importeroalib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importeroalib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importeroalib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
   if ($xdbcoll!="") {
      $link->query("set names 'utf8' "); 
   }
   tmq("delete from media_mid where adminnote='addons_importer_oalib' ");
   tmq("delete from media where importid='addons_importer_oalib' ");
   $c1 = $link->query("select count(*) as cc from tb_book_title"); 
   echo mysqli_error($link);
   $s=$link->query("select* from tb_book_title "); //limit 20
   while ($r=mysqli_fetch_array($s)) {
   //   tag082='  ".iconvutf(addslashes($r[call_nmbr1])."^b".iconvutf($r[call_nmbr2])."^c".iconvutf($r[call_nmbr3].""))."',

   $q="insert into media set
   importid='addons_importer_oalib' ,
   LIBSITE='main',
   leader='00000nam  2200000uu 4500',
   tag245='  ".iconvutf(addslashes($r[bk_title]))."',
   tag100='  ".iconvutf(addslashes($r[bk_author]))."',
   tag060='  ".iconvutf(addslashes($r[cat_code]))." ".iconvutf(addslashes($r[bk_author_code]))."',
   tag020='  ".iconvutf(addslashes($r[bk_isbn]))."',
   tag022='  ".iconvutf(addslashes($r[bk_issn]))."',
   tag260='  ^a".iconvutf(addslashes($r[bk_pub_place])).":^b".iconvutf(addslashes($r[bk_pub_name])).",^c".iconvutf(addslashes($r[bk_pub_year]))."',
   ";
   $q=rtrim($q);
   $q=rtrim($q,"\n,");
   //echo "<pre>$q</pre><HR>";
   tmq($q,false);
   $tmpid=mysqli_insert_id($tmq_last_activelink);
   
   $s2=$link->query("select * from tb_book where ref_id='$r[ref_id]' "); 
   while ($r2=mysqli_fetch_array($s2)) {
      $bcode=str_fixw($r2[bk_barcode],6);
      tmq("insert into media_mid set adminnote='addons_importer_oalib' ,pid='$tmpid' ,RESOURCE_TYPE='bk',price='$r2[bk_cost]',bcode='$bcode' ",false);
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
	$xdb=barcodeval_get("addonssetting_importeroalib_db");
	$xdbhost=barcodeval_get("addonssetting_importeroalib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importeroalib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importeroalib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importeroalib_dbcoll");
   	//conection: 
   $link = mysqli_connect("$xdbhost","$xdbuser","$xdbpasswd","$xdb") or die("Error " . mysqli_error($link)); 
   $c1 = $link->query("select count(*) as cc from tb_book"); 
   echo mysqli_error($link);
   $c1=mysqli_fetch_array($c1);
   $c1=$c1[cc];
   echo "<BR>จำนวน Bib: $c1";
   $c1 = $link->query("select count(*) as cc from tb_book_title"); 
   echo mysqli_error($link);
   $c1=mysqli_fetch_array($c1);
   $c1=$c1[cc];
   echo "<BR>จำนวน Item: $c1";
   if ($xdbcoll!="") {
      $link->query("set names 'utf8' "); 
   }
   $c1 = $link->query("select * from tb_book_title order by rand() limit 5"); 
   echo mysqli_error($link);
   //$c1=mysqli_fetch_array($c1);
  // $c1=$c1[cc];
   echo "<BR>ตัวอย่างข้อมูล";
   while ($r=mysqli_fetch_array($c1)) {
      echo "<BR>&bull; ".iconvutf($r[bk_title])."/$r[bk_author]";
   }
   
       echo "<BR><BR>หากอ่านเป็นภาษาไทยได้ ดำเนินการต่อได้<BR>
       <a href='index.php?extracttable=yes'>คลิกที่นี่เพื่อดำเนินการต่อ</a>";

   
   die;
}
if ($processsqlfile=="yes") {
   	$tmp=trim(barcodeval_get("addonssetting_importeroalib_db"));
	if ($tmp=="") {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลเป็นค่าว่าง");
	}
	if (strtolower($tmp)==strtolower($dbname)) {
	  die("กรุณาตั้งค่าฐานข้อมูลชั่วคราวใหม่ - ชื่อฐานข้อมูลตรงกันกับฐานที่กำลังใช้งานไม่ได้");
	}
	$xdb=barcodeval_get("addonssetting_importeroalib_db");
	$xdbhost=barcodeval_get("addonssetting_importeroalib_dbhost");
	$xdbuser=barcodeval_get("addonssetting_importeroalib_dbuser");
	$xdbpasswd=barcodeval_get("addonssetting_importeroalib_dbpasswd");
	$xdbcoll=barcodeval_get("addonssetting_importeroalib_dbcoll");
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
	$dr=$dcrs."/_tmp/_import/addontemp_oalib.sql";
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
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "addontemp_oalib.sql"); 
	} else {
      die("อัพโหลดไฟล์ไม่สำเร็จ ");
   }
	?><center>
	Uploaded: <?php echo $_FILES['selectedfile']['name'];?><BR>
	<?php 
	$tmp=trim(barcodeval_get("addonssetting_importeroalib_db"));
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
	ในการนำเข้าข้อมูลจะต้องนำข้อมูลจากโครงสร้างฐานข้อมูล oaliblio ไปใส่ไว้ในฐานข้อมูลชั่วคราวอีกฐานหนึ่ง<BR>
SQL file จากฐาน oaliblio : <INPUT TYPE="file" NAME="selectedfile" size=15 ><BR><BR><BR>
<b style='color:red;'>คำเตือน: ฐานข้อมูลดังกล่าวจะถูกลบ!!</b><BR><BR>
		 <input type="submit" value="Upload">
	</form></center><?php 
}
?><table width=700 align=center>
<tr valign=top>
	<td width=70><img src="logo.png" width="48" height="47" border="0" alt=""></td>
	<td>oaliblio Importer<br>
	นำเข้าข้อมูลหนังสือจาก oaliblio <br>
   1. <a href="index.php?seturl=yes" class="a_btn smaller2">ตั้งค่า/กำหนดฐานข้อมูลชั่วคราว</a><BR>
   2. <a href="index.php?uploadsql=yes" class="a_btn smaller2">อัพโหลดไฟล์ SQL</a><BR>
   </td>
</tr>
</table><?php 


foot();
?>