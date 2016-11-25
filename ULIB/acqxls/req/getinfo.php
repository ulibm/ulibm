<?php //พ
include("../../inc/config.inc.php");
include("../cfg.inc.php");
?>
<HTML>
<HEAD>
<TITLE>  </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="msn:thedarkside@eminem.com">
<meta name="robots" content="index,follow">
<meta name="robots" content="all"> 
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<META HTTP-EQUIV="imagetoolbar" CONTENT="false">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">  
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">  
</head><body>
<?php
$a=explode(",",$_STR_A_Z);
$a=implode($a);
$b=explode(",",$_STR_A_Zth);
$b=implode($b);
//echo $a.$b;
$isn=str_remspecialsign($isn);
$isn=trim($isn, " $a.$b");
$tmp=file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:$isn");
//echo("https://www.googleapis.com/books/v1/volumes?q=isbn:$isn");
$tmp=json_decode($tmp,true);
//print_r($tmp);
if (count($tmp[items])==0) {
   echo "ไม่พบข้อมูล ISBN นี้";
}
@reset($tmp);
while (list($k,$v)=each($tmp[items])) {
   echo "หากใช่รายการนี้ <a href='javascript:void(null);' ";
   ?>
   onclick="t=parent.getobj('titl'); t.value='<?php echo iconvth(addslashes($v[volumeInfo][title]));?>'; t=parent.getobj('auth'); t.value='<?php echo iconvth(addslashes(@join($v[volumeInfo][authors]," ")));?>'; t=parent.getobj('yeaID'); t.value='<?php echo iconvth(addslashes($v[volumeInfo][publishedDate]));?>'; t=parent.getobj('pubID'); t.value='<?php echo iconvth(addslashes($v[volumeInfo][publisher]));?>'; ";
   <?php
   echo ">คลิกที่นี่</a><BR>".addslashes(iconvth($v[volumeInfo][title]))." <BR>".addslashes(iconvth(@implode($v[volumeInfo][authors]," ")))."<BR>".addslashes(iconvth($v[volumeInfo][publisher]))." <BR>".addslashes($v[volumeInfo][publishedDate]);"<BR> <BR> ";
   $img=$v[volumeInfo][imageLinks][thumbnail];
   if ($img!="") {
      ?><BR> <img width=120 src='<?php echo $img;?>'><?php
   }
   
   echo "<BR><HR>";
}

?><!--

<? print_r($tmp);?>
 -->