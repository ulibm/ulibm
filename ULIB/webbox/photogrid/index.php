<?php 
include("../../inc/config.inc.php");
html_start();

$sb=tmq("select * from webbox_photogrid where boxid='$boxid' ");
$sbr=tfa($sb);
?>

<script src="<?php echo $dcrURL;?>webbox/photogrid/masonry.pkgd.min.js"></script>


<style>
.grid-item { width: <?php echo floor($sbr[photowidth]/2);?>px; }
.grid-item--width2 { width: <?php echo floor($sbr[photowidth]);?>px; }
div {
   border: 1px solid red;
}
</style>
<!--   <div class="grid-item">...</div>
  <div class="grid-item grid-item--width2">...</div>
  -->
<div class="grid">



<?php

if (strtolower($sbr[israndom])=="yes") {
   $s=tmq("select * from globalupload where keyid='$keyid' order by rand() ",false);
} else {
   $s=tmq("select * from globalupload where keyid='$keyid' order by filename ",false);
}

while ($r=tfa($s)) {
   ?>  <div class="<?php
   $tmp=rand ( 1, 2);
   if ($tmp==2) {
      echo "grid-item grid-item--width2";
   } else {
      echo "grid-item";
   }
   ?>"><img
   style="width: 100%;"
    border=0 onclick="window.open(this.src);" src="<?php echo  $dcrURL."_globalupload/$r[keyid]/$r[hidename]";?>"></div>
<?php
}

?></div>

<script>
var elem = document.querySelector('.grid');
var msnry = new Masonry( elem, {
  // options
  itemSelector: '.grid-item',
  columnWidth: <?php echo $webbox_cur_columnwidth; ?>
});

// element argument can be a selector string
//   for an individual element
var msnry = new Masonry( '.grid', {
  // options
});
//alert("e");
</script>