<?php 
; //พ
include("../../inc/config.inc.php");
//$str=base64_decode($str);
if (mb_strlen(trim($str))<3) {
   die;
}
$str= iconvth(($str));
$str=str_replace2("  "," ",$str);
$stra=explode(" ",$str);
//printr($stra);
$str=$stra[count($stra)-1];
$str=trim($str);
if ($str=="") { die; }
$s=tmq("select * from indexword where word1 like '$str%' order by length(word1) limit 20",false);
$res="";
while ($r=tfa($s)) {
	$res.= "".addslashes($r[word1]).":::";
}
echo uencode($res);

?>