<?php 
function ddxl($sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8) {
	//echo "ddxl[$sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8]";
	$schk =date("U",ymd_mkdt($sdat8, $smon8, $syea8));
	$echk =date("U",ymd_mkdt($edat8, $emon8, $eyea8));
	//echo "[ $schk - $echk  ($sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8)] ";
	//die;

	if ($schk > $echk) {
		/*echo "<PRE>$schk =date(U,ymd_mkdt($sdat8, $smon8, $syea8));
$echk =date(U,ymd_mkdt($edat8, $emon8, $eyea8));</PRE>";
	    echo " <BLOCKQUOTE><U>วันยืม</U> ถูกกำหนดอยู่หลัง <U>วันส่ง</U></BLOCKQUOTE>";
		*/
	    //echo " <U>ยังไม่ถึงกำหนดส่ง</U> (everything is ok, dont panic)";
		return;
	} 

$syea8=$syea8;
$eyea8=$eyea8;
$dayTarget = (ddx($sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8));
//echo " day target=$dayTarget";
$dayCR = 1;
$dayCRV="";
if ($dayTarget<=0) {
	//echo "<b>$dayTarget</b>";
	return "";
	//หากส่งก่อนกำหนด
}
//echo "YEA is $syea8<br>";
while ($syea8<=$eyea8) {
  if (date("L",mktime("$sdat8-$smon8-$syea8"))==0) {
  //echo "=0";
   $monL = 28;
} else {
   $monL = 29;
  //echo "=1";
}
 $monARR = array("","31","$monL","31","30","31","30","31","31","30","31","30","31");
//echo "$syea8  $eyea8<hr>";      
   while ($smon8<=12 && $syea8<=$eyea8) {
      $monDay=$monARR[$smon8];
     // echo "MON is $smon8 .  $monDay วัน<br>";
	 //echo "[ $sdat8<=$monDay ]";
        while ($sdat8<=$monDay) {
             $dayCRV = "$dayCRV $sdat8.$smon8.$syea8";   
           //echo " dayTarget:dayCR===$dayTarget==$dayCR ";
          if ($dayTarget==$dayCR) {
             // echo $dayCRV;
               //break;
              //echo "DDXL";
              return "$dayCRV";
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
echo "<b>ERROR </b> เกิดข้อผิดพลาด ข้อมูลระบบ: <hr>DDXL Last dayTarget=$dayTarget 
[$sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8] dayCRV=[$dayCRV] dayCR=$dayCR";
//return $dayCR;
}
?>