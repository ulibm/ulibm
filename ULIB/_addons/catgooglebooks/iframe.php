<?php 
include("../../inc/config.inc.php");
html_start();

$a=explode(",",$_STR_A_Z);
$a=implode($a);
$b=explode(",",$_STR_A_Zth);
$b=implode($b);
//echo $a.$b;
$isn=str_remspecialsign($isn);
$isn=trim($isn, " $a.$b");
if ($isn!="") {
   $tmp=file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:$isn");
}
if ($kw!="") {           //https://www.googleapis.com/books/v1/volumes?q=search+terms
   $tmp=file_get_contents("https://www.googleapis.com/books/v1/volumes?q=".urlencode($kw));
}
if ($tmp==false || trim($tmp)=="") {
   echo "มีปัญหาการเชื่อมต่อ - ได้ผลลัพธ์ค่าว่าง<BR>";
}
//echo("https://www.googleapis.com/books/v1/volumes?q=isbn:$isn");
$tmp=json_decode($tmp,true);
//printr($tmp);
if (count($tmp[items])==0) {
   if ($isn!="") {
      echo "ไม่พบข้อมูล ISBN นี้ [$isn]";
   } elseif ($kw!="") {
      echo "ไม่พบข้อมูลจากการค้นด้วยคำสำคัญนี้ [$kw]";
   } else {
      echo "กรุณาระบุข้อมูลสำหรับค้นหา";
   }
}
@reset($tmp);
$i=0;
while (list($k,$v)=@each($tmp[items])) {
$i++;
?><script>
function localsetdat<?php echo $i;?>(tagid,marcval) {
			errored=false;
				try {
					newhtml=parent.getobj("source_"+tagid);
					newhtml=parent.getobj("result_"+tagid);
				  }
				catch(err)
				  {
					errored=true;
					alert(" error:" + wh);
				  //Handle errors here
				  }
				if (errored==false) 	{
					if(parent.taglistiscanrepeat.indexOf("tag"+tagid) != -1) 	{  
					   // element found - can repeat
						parent.removemarcbytag("tag"+tagid);
						parent.duplicatemarc("tag"+tagid," "," ",marcval);
						//mmv.value=mmv.value+"\n replacing "+tagid+"/"+indi1+"/"+indi2+"/"+marcval+"/";
						//alert('trtag'+tagid);
					} else {
						parent.duplicatemarc("tag"+tagid," "," ",marcval);
						//mmv.value=mmv.value+"\n adding "+tagid+"/"+indi1+"/"+indi2+"/"+marcval+"/";
					}
				}
}
</script><?php 
   echo "หากใช่รายการนี้ <a href='javascript:void(null);' ";
   ?>
   onclick="localsetdat<?php  echo $i?>('245','<?php  echo (addslashes($v[volumeInfo][title]));?>');<?php 
   list($k2,$v2)=@each($v[volumeInfo][authors]);
   ?>localsetdat<?php  echo $i?>('100','<?php  echo addslashes($v2);?>');<?php 
   while (list($k2,$v2)=@each($v[volumeInfo][authors])) {
      ?>localsetdat<?php  echo $i?>('700','<?php  echo addslashes($v2);?>');<?php 
   }
   if (floor($v[volumeInfo][pageCount])!=0) {
      ?>localsetdat<?php  echo $i?>('300','<?php  echo addslashes($v[volumeInfo][pageCount]);?> หน้า');<?php 
   }
   ?>localsetdat<?php  echo $i?>('246','<?php  echo addslashes($v[volumeInfo][subtitle]);?>');<?php 
   while (list($k2,$v2)=@each($v[volumeInfo][categories])) {
      ?>localsetdat<?php  echo $i?>('653','<?php  echo addslashes($v2);?>');<?php 
   }
   while (list($k2,$v2)=@each($v[volumeInfo][industryIdentifiers])) {
      if ($v2[type]=="ISBN_13" || $v2[type]=="ISBN_10")  {
         ?>localsetdat<?php  echo $i?>('020','<?php  echo addslashes($v2[identifier]);?>');<?php 
      }
   }
   $tmpdescr=$v[volumeInfo][description];
   $tmpdescr=str_replace('"','&quot;',$tmpdescr);
   ?>localsetdat<?php  echo $i?>('500','<?php  echo (addslashes($tmpdescr));?>');<?php 
   $date=mb_substr($v[volumeInfo][publishedDate],0,4);
   $date=floor($date);
   $pub=trim($v[volumeInfo][publisher]);
   if ($pub!="" && $date!=0) {
      $pub=$pub.",";
   }
   if ($date!=0) {
      $pub=$pub."^c$date";
   }
   ?>localsetdat<?php  echo $i?>('260','^b<?php  echo (addslashes($pub));?>');<?php 

   //echo "xxx".$date."xxx";
   
   ?>;tmp=parent.getobj('addonscatgooglebooks'); tmp.style.display='none';"
   noonclick="t=parent.getobj('titl'); t.value='<?php  echo (addslashes($v[volumeInfo][title]));?>'; t=parent.getobj('auth'); t.value='<?php  echo (addslashes(@join($v[volumeInfo][authors]," ")));?>'; t=parent.getobj('yeaID'); t.value='<?php  echo (addslashes($v[volumeInfo][publishedDate]));?>'; t=parent.getobj('pubID'); t.value='<?php  echo (addslashes($v[volumeInfo][publisher]));?>'; ";
   <?php 
   echo ">คลิกที่นี่</a><BR>Title:<a href='".$v[volumeInfo][previewLink]."' target=_blank>".stripslashes(($v[volumeInfo][title]))."</a> <BR>
   Authors:".addslashes((@join($v[volumeInfo][authors]," ")))."<BR>
   Publisher:".addslashes(($v[volumeInfo][publisher]))." <BR>
   Published Date:".addslashes($v[volumeInfo][publishedDate]);"<BR> <BR> ";
   $img=$v[volumeInfo][imageLinks][thumbnail];
   if ($img!="") {
      ?><BR> <img width=120 src='<?php  echo $img;?>'><?php 
   }
   
   echo "<BR><HR>";
}

?><!--

<?php  print_r($tmp);?>
 -->