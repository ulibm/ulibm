<?php 
include("../inc/config.inc.php");
if ($isn=="") {
   redir($dcrURL."neoimg/nocover.png");
   die;
}
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
$img=$tmp[items][0][volumeInfo][imageLinks][thumbnail];
//echo $img;
//printr($img);// พ 
redir($img);
?>