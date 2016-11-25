<?php
include("../inc/config.inc.php");
$path=$dcrs."_tmp/$file";
//echo substr($file,-4);
if (substr($file,-4)!=".jpg") {
   die("invalid file");
}
//echo $path;
header('Content-Type: image/jpeg');

echo file_get_contents($path);
//sleep(1);
@unlink($path);
?>