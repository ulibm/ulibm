<?php 
set_time_limit(0);
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();
?><center>

<?php echo "Processing...<BR><BR>";
//printr($ctrllang);
$rsdb=tmq_dump2("media_type","code","name");
@reset($ctrllang);
while (list($k,$v)=each($ctrllang)) {
   echo "<BR><b>Processing: ".$k."</b> - " . $rsdb[$k]."";
   if (strlen($v)==3) {
      echo "<BR><font color=red>Set as: $v</font>";
      $s=tmq("select pid from media_mid where RESOURCE_TYPE='$k' ",false);
      $i=0;
      while ($r=tfa($s)) { //printr($r);
         $media=tmq("select ID,tag008 from media where ID='$r[pid]' ");
         $media=tfa($media);
         if (floor($media[ID])==0) { continue; }
         $i++;
         $new008=mb_substr($media[tag008],0,35).$v.mb_substr($media[tag008],38);
        // echo str_replace(" ","-","<BR>b=$media[tag008]<BR>a=$new008<BR>");
         tmq("update media set tag008='$new008' where ID='$r[pid]' limit 1 ",false);
      }
      echo "<BR>Processed: ".number_format($i)."<HR>";
   } else {
      echo "<BR><font color=darkgreen>Ignore</font>";
   }

}/*
   $media[tag008]=$media[tag008]."                                                         ";
   $i++;
   $media=tmq("select * from media where ID='$r[mid]' ");
   $media=tfa($media);
   if (floor($media[ID])==0) { continue; }
   $new008=mb_substr($media[tag008],0,7).$r[tag260].mb_substr($media[tag008],11);

  // tmq("update media set tag008='$new008' where ID='$r[mid]' limit 1 ",false);
}*/
?><HR>done..
</center><?php 

foot();

?>