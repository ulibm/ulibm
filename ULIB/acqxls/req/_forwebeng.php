<?php  //พ
include("../cfg.inc.php");
html_start();
?><div style="width: 390px; text-overflow:ellipsis; overflow: hidden;">
	<?php 
$s=tmq("select * from acqn_sub order by id desc  limit 15 ");
while ($r=tfa($s)) {
	?><nobr style="font-size: 14px;"> &nbsp;&nbsp;&nbsp; &bull; <?php  echo ymd_datestr($r[dt],"shortd");?>	<?php  echo stripslashes($r[titl]);?></nobr><br><?php 
}
?>
</div>