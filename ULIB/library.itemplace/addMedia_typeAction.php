<?php  
;
include("../inc/config.inc.php");
$_REQPERM="itemplace";
html_start();
$tmp=mn_lib();
// พ

     

    // คำสั่งบันทึกลงฐานข้อมูล

     

     $sql ="insert into media_place (code,name,main,isrq,collcode,defformattype)";

     $sql.=" values ('$code','$name','$main','$isrq','$collcode','$defformattype')";

       //echo $sql;

  tmq($sql);

	redir("media_type.php");
?>