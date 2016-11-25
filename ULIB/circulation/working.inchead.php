<?php // พ
$isatcirculation="yes";
if (loginchk_lib("check")!=true) {
   ?>
   <script>
   alert("<?php echo getlang("กรุณาล็อกอินเข้าระบบ::l::Please Login");?>");
   top.location="<?php echo $dcrURL;?>library/";
   </script>
   <?php
   die;
}
?>
