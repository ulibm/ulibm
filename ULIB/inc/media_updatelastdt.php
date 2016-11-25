<?php //พ
function media_updatelastdt($mid,$mode="lastdt",$dt=0) {
   if ($dt==0) $dt=time();
   if ($mode=="lastdt") {
     tmq("update media set lastdt='$dt' where ID='$mid' limit 1 ;");
   } 
   
   if ($mode=="item") {
     tmq("update media set lastdtitem='$dt' where ID='$mid' limit 1 ;");
   }
   if ($mode=="ft") {
     tmq("update media set lastdtft='$dt' where ID='$mid' limit 1 ;",true);
   }
}
?>