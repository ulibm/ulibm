<?php 
;
 include("../inc/config.inc.php");

////
$data=tmq("select * from quickstattp where id='$tpidid' ",false);
$data=tmq_fetch_array($data);
//printr($data);
$rplc=$data[rplc];
$_SQLFORCEORDERBY=stripslashes($data[orderby]);
$dataforall=$data[data];
$removesubfield=trim(strtolower($data[removesubfield]));
$rplc=explodenewline($rplc);
$rplc=arr_filter_remnull($rplc);

	$s=tmq("select * from quickstat where id='$id'");
	$s=tmq_fetch_array($s);
//printr($s);
include("export.inc.php");
$statname=stripslashes($data[name]);
$statdetail= getlang("ดึงข้อมูลจากแท็ก::l::Use tag").": ".getlang($s[tag]). " ";
$statdetaily= getlang("เฉพาะข้อมูลในปี::l::These year(s) only").": ".($s[yea]);
if (trim($s[yea])=="") {
	$statdetaily= getlang("ในปี::l::year").": ".getlang("ทุกปี::l::All years");
}
$statdetail=$statdetail.$statdetaily;

$tmphead=stripslashes($data[htmlhead]);
$tmphead=str_replace("\$statname",$statname,$tmphead);
$tmphead=str_replace("\$statdetail",$statdetail,$tmphead);
echo $tmphead;

$i=0;
while ($r=tmq_fetch_array($sql)) {
$i++;
if ($i>=10) {
  // die;
}
   $localdata=$dataforall;
   //echo ($localdata)."<HR>";
	$value=$r[ID];
   $tmp=marc_melt($r[ID]);
   //printr($tmp);
   //printr($r);
   @reset($tmp);
   //echo "[$r[ID]]";
   $localdata=str_replace("\$data[ID]",$r[ID],$localdata);

   while (list($k,$v)=each($tmp)) {
      if (strlen($k)==6 && substr($k,0,3)=="tag") {
         $v=mb_substr($v,2);
      }
      if ($removesubfield=="yes") {
         $v=dspmarc($v);
      }
      //echo "\$data[$k]-$v<BR>";
      $localdata=str_replace("\$data[$k]",$v,$localdata);
   }
   @reset($rplc);
   while (list($k,$v)=each($rplc)) {
      $v2=explode("===",$v);
      $localdata=str_replace($v2[0],$v2[1],$localdata);
   }
   
     // $localdata= preg_replace('/[\$,data_g\[\]012MARC3456789]/', '', $localdata);
   $localdata = preg_replace('#\$data[^\]]+\]#', '', $localdata);

   echo stripslashes($localdata);
}
   
   
$tmpfoot=stripslashes($data[htmlfoot]);
$tmpfoot=str_replace("\$statname",$statname,$tmpfoot);
$tmpfoot=str_replace("\$statdetail",$statdetail,$tmpfoot);
echo $tmpfoot;
   
   
?>