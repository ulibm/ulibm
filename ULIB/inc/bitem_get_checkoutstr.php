<?php 
function bitem_get_checkoutstr($mMID) {
global $thaimonstr;
global $dcrURL;
  $sql25 ="SELECT *  FROM checkout where mediaId='$mMID' ";
//echo $sql25;
$result25 = tmq($sql25);
   $Num = tmq_num_rows($result25);  
     $row25 = tmq_fetch_array($result25);
                 $itemid = $row25[id];
                 $itemhd = $row25[hold];
                 $itemrq = $row25[request];
                 $itemedat = $row25[edat];
                 $itememon = $row25[emon];
                 $itemeyea = $row25[eyea];

//   echo "$Num";
if ($Num==0) {
   //check insidelib
   $insidelib=tmq("select * from useinsidelib where bcode='$mMID' ");
   if (tnr($insidelib)==0) {
      //echo "[".getval("_SETTING"."onshelfstring")."--";
      $ecstat="<FONT  COLOR=0000ff>".getlang(getval("_SETTING","onshelfstring"))."</FONT>";
   } else {
      $ecstat= getlang("ถูกยืมใช้ภายใน::l::use inside library");
   }

} else { //หากมีอยู่ในตาราง checkout
   if ($itemrq!="") {
      $ecstat.=getlang("ถูกยืม กำหนดส่งวันที่ ::l::On due return at ") . " <nobr>" . $itemedat . " " . $thaimonstr[$itememon] . " " . $itemeyea ."</nobr> " . getlang("และมีการจองต่อ::l:: with request"); 
	} else {
	  $ecstat .= getlang("ถูกยืม กำหนดส่งวันที่ ::l::On due return at ") . "  <nobr>" . $itemedat . " " . $thaimonstr[$itememon] . " " . $itemeyea ."</nobr> <br />
<A HREF='$dcrURL"."requesthold_form.php?ID=$mMID' target=_top>&nbsp;<img align=absmiddle border=0 src='$dcrURL"."neoimg/Right16.gif'> ".getlang("จอง::l::Request")."</A> ";	
	}
} 
//echo "[$ecstat]";
return $ecstat;
}
?>