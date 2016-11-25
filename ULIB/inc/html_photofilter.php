<?php 
function html_photofilter($path,$text="",$echonow=true) {
   //echo "html_photofilter($path,$text,$echonow)";
   $text=trim($text);
   if ($text=="") {
      $text="PhotoFilter";
   }
   //echo "html_photofilter($path,$text,$echonow)";
   global $dcrs;
   global $dcrURL;
   $str="";
   $path=ltrim($path,"/");
   $path=str_replace("..","",$path);
   
   $path_parts = pathinfo($path);
   $ex=strtolower($path_parts[extension]);
   if ($ex=="jpg" || $ex=="png" || $ex=="jpeg" ) {
   } else {
      return;
   }
   if (!file_exists($dcrs."$path")) {
      $str="<font TITLE='$path'>path not found</font>";
   } else {
      $str="<a href='$dcrURL"."_misc/photofilter/index.php?p=".base64_encode($path)."' 
      target=_blank style='text-decoration: underline; ' class=smaller2>$text</a>";
   }
   if ($echonow==true) {
      echo $str;
   } else {
      return $str;
   }
}
?>