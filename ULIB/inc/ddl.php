<?php 
function ddl($sdat8,$smon8,$syea8,$dayTarget) {
//บอกวัน ว่าวันล่วงหน้าไป dayTarget วัน จากวันที่กำหนดให้ คือวันที่เท่าไหร่
$syea8=$syea8; //XXXXXXXXX
$edat8=15;
$emon8=9;
$eyea8=2560;
$dayCR = 1;
//echo "YEA is $syea8<br>";
while ($syea8<=$eyea8) {
  if (date("L",mktime("$sdat8-$smon8-$syea8"))==0) {
  //echo "=0";
   $monL = 28;
} else {
   $monL = 29;
  //echo "=1";
}
 $monARR =
 array("","31","$monL","31","30","31","30","31","31","30","31","30","31");
//echo "$syea8  $eyea8<hr>";      
/*echo "[(($smon8<=$emon8) && ($syea8<=$eyea8) )=" .(($smon8<=$emon8) &&
($syea8<=$eyea8) ). "]<br>";*/
   while ($smon8<=12 && $syea8<=$eyea8) {
      $monDay=$monARR[$smon8];
     // echo "MON is $smon8 .  $monDay วัน<br>";
        while ($sdat8<=$monDay) {
          if ($dayTarget==$dayCR) {
             //break;
              return "$sdat8 $smon8 " .($syea8);//XXXXXXX
          }
         // echo "$sdat8 $smon8 $syea8 ที่ $dayCR<br>";
          $dayCR++;
          $sdat8++;
        } //while day
      $sdat8=1;             
      $smon8++;
   } //while month
$smon8=1;
$syea8++;
}//while year
//return $dayCR;
}
?>