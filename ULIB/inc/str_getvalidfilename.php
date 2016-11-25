<?php 
function str_getvalidfilename($fname,$getext=false,$fullpath) {
   //echo "str_getvalidfilename($fname,$getext)";
   $ext=explode('.',$fname);
   $purename=implode(".",$ext);
   $purename=substr($purename,0,0-(strlen($ext[count($ext)-1])+1));
   $new_str = str_replace(str_split('1234567890_-abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), '', $purename);
	$fileext="".$ext[count($ext)-1];
   //echo "[fname=$fname/purename=$purename/fileext=$fileext/new_str=$new_str]";
   //check file exists
   $fullpath=rtrim($fullpath," /\\");
   $fullpath=$fullpath."/".$purename.".".$fileext;
   if (!file_exists($fullpath) && strlen($new_str)==0) {
      if ($getext==true) {
         return $purename.".".$fileext;
      } else {
         return $purename;
      }
   }
   if ($getext==true) {
      return randid().".".$fileext;
   } else {
      return randid();
   }
}
?>