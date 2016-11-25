<?php //พ
  function isUTF8($str) {
       if ($str === mb_convert_encoding(mb_convert_encoding($str, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
           return true;
       } else {
           return false;
       }
   }
?>