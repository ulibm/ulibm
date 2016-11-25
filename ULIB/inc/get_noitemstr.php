<?php 
function get_noitemstr($code,$strfor=searchlist) {
   $code=strtolower($code);
   $s=tmq("select * from noitemstrbymarctype where code='$code' ");
   if (tnr($s)==0) {
      return getlang("ไม่มีไอเทมให้บริการ::l::No item available");
   }
   $s=tfa($s);
   if ($strfor=="searchlist") {
      return getlang($s[str]);
   }
   return getlang($s[strforlist]);

}
?>