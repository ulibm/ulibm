<?php

//printr($_GET);
$giduse=floor($gateid);
if ($giduse!=0) {
   $tmp=fft_upload_get("ms_sub","custombg",$giduse);
   //printr($tmp);
   if ($tmp[status]=="ok") {
      ?><style>
      BODY {
         background-image: url(<?php echo $tmp[url];?>)!important;
      }
      </style><?php
   }
}

?>