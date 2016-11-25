<?php 
set_time_limit(0);
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();

html_dialog("Review","กรุณาตรวจสอบข้อมูลเบื้องต้นก่อนกดปุ่มดำเนินการ::l::Please verify these information before proceed");
?><center>

<?php 
tmq("delete from tmp_updatedate1260");
$s=tmq("select ID,tag008,tag260 from media where 1");
$c=0;
$i=0;
while ($r=tfa($s)) { //printr($r);
   $i++;
   $date1=mb_substr($r[tag008],7,4);
   $date1=floor($date1);
   //echo "[$date1]";
   $t260=explode("^c",$r[tag260]);
   $t260=$t260[1];
   $t260=explode("^",$t260);
   $t260=$t260[0];
   $t260=trim($t260,"[]./\\|'\" \t
$newline ");
   $t260=floor($t260);
   //echo "[$t260]";
   if ($t260>1000 && $t260<3000 && $date1==0) {
      $c++;
      tmq("insert into tmp_updatedate1260 set mid='$r[ID]',date1='$date1',tag260='$t260' ");
   }
   //die;
}
?><?php 
echo getlang("หากดำเนินการ จะมีการอัพเดทข้อมูลจำนวน ".number_format($c)." รายการ จากข้อมูลทั้งหมด ".number_format($i)." รายการ
::l::If process,".number_format($c)." records out of ".number_format($i)." will be processed");
?><BR><BR><BR>
<a href="process.php" class=a_btn
onclick="return confirm('Please confirm!! ');"
><?php  echo "Process" ?></a>
</center><?php 

foot();

?>