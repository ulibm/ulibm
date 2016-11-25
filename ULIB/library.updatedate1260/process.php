<?php 
set_time_limit(0);
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();
?><center>

<?php echo "Processing...<BR><BR>";

$s=tmq("select * from tmp_updatedate1260 ");
$c=0;
$i=0;
while ($r=tfa($s)) { //printr($r);
   $media[tag008]=$media[tag008]."                                                         ";
   $i++;
   $media=tmq("select * from media where ID='$r[mid]' ");
   $media=tfa($media);
   if (floor($media[ID])==0) { continue; }
   $new008=mb_substr($media[tag008],0,7).$r[tag260].mb_substr($media[tag008],11);
  /* echo "[$media[tag008]-".strlen($media[tag008])."]<BR>
[$new008-".strlen($new008)."]
<a href='$dcrURL/dublin.php?ID=$media[ID]' target=_blank>$media[ID]</a><HR>

";*/
   tmq("update media set tag008='$new008' where ID='$r[mid]' limit 1 ",false);
}
?><HR>done..
</center><?php 

foot();

?>