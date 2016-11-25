<?php 
;
include("../inc/config.inc.php");
head();
?><BR><?php 
    ?>
<center>
<?php 
   if (function_exists("disk_free_space")) {
    $bytes = disk_free_space("."); 
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    //echo $bytes . '<br />';
    if ($bytes>=1000*1000) {
      echo "<!--";
    }
      echo "Harddisk free space : ";
      echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
    if ($bytes>=$base) {
      echo "-->";
    }
   }
   
	pagesection(getlang("ระบบเจ้าหน้าที่สูงสุด::l::Administrator System"),"login","#950000");
        form_root_login();
   $s=tmq("repair table stat_globaluid;");
   $s=tmq("repair table sessionval;");
   /*
   $r=tfa($s); 
   printr($r);*/
    ?><?php
foot();
?>