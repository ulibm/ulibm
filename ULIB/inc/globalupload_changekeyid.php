<?php // พ
function globalupload_changekeyid($from,$to) {
   global $dcrs;
   //echo "globalupload_changekeyid($from,$to)";
   $s=tmq("select * from globalupload where keyid='$from' ");
   @mkdir($dcrs."_globalupload/".$to);
   while ($r=tfa($s)) {
      @copy($dcrs."_globalupload/".$from."/".$r[hidename],$dcrs."_globalupload/".$to."/".$r[hidename]);
      @copy($dcrs."_globalupload/".$from."/".$r[hidename].".thumb.jpg",$dcrs."_globalupload/".$to."/".$r[hidename].".thumb.jpg");
      //echo "@rename($dcrs_globalupload/.$from.\"/\".$r[hidename],$dcrs._globalupload/.$to.\"/\".$r[hidename]);<br />";
      //tmq("update globalupload set keyid='$to' where id='$r[id]' ",true);
      tmq("insert into globalupload set 
         keyid='$to',
         filename='$r[filename]',
         ctt='$r[ctt]',
         hidename='$r[hidename]',
         loginid='$r[loginid]',
         dt='$r[dt]',
         img_out1='$r[img_out1]',
         filename_auto='$r[filename_auto]'

      
      ");
   }
   //die;
}
?>