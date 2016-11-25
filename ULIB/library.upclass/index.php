<?php 
set_time_limit(0);
        include ("../inc/config.inc.php");
        include ("_REQPERM.php");
head();
$tmp=mn_lib();

$localcatehead="yes";

pagesection(getlang($tmp));

?><center>
<a href="index.php?mode=main" class="a_btn" ><?php echo getlang("หน้าหลัก::l::Main");?></a>
<a href="index.php?mode=setting" class="a_btn" ><?php echo getlang("ตั้งค่า::l::Settings");?></a>
<a href="index.php?mode=history" class="a_btn" ><?php echo getlang("ประวัติ::l::History");?></a>

</center><?php

if ($mode=="") {
   $mode="main";
}
if ($mode=="main" || $mode=="operation") {
   include("main.php");
}
if ($mode=="setting") {
   include("setting.php");
}
if ($mode=="history") {
   include("history.php");
}

foot();

?>