<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
$s=tmq("select * from media_place where code='$id'  ",false);
$sr=tfa($s);
//printr($sr);


?><CENTER><center><b>Quick Preview</b><br>
<?php  echo getlang("คลิก และใช้ปุ่มลูกศรเพื่อจัดตำแหน่ง<br>
ปุ่ม 4,6 เพื่อลด-เพิ่มความกว้าง<br>ปุ่ม 8,2 เพื่อลด-เพิ่มความสูง
::l::Click and use arrow key to adjust position<br>
key 4,6 to decrease-increase width<br>
key 8,2 to decrease-increase height") ; ?><br>
<iframe width='<?php  echo $_TBWIDTH?>' height=700 src="_pospicker.php?id=<?php  echo $id; ?>&libsiteid=<?php  echo $sr[main]; ?>&view=yes"></iframe>
<BR>
<B>
<A HREF="sub.php?id=<?php  echo $id;?>" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A>
</B></CENTER><?php 

foot();
?>