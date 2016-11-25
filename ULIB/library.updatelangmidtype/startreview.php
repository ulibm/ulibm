<?php 
set_time_limit(0);
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();

html_dialog("Review","กรุณาตรวจสอบข้อมูลเบื้องต้นก่อนกดปุ่มดำเนินการ::l::Please verify these information before proceed");
?><center>
<form method=post action=process.php onsubmit="return confirm('Please confirm!! ');">
<table class=table_border align=center width=850>
<?php 
$s=tmq("select distinct RESOURCE_TYPE,count(id) as cc from media_mid where RESOURCE_TYPE<>'' group by RESOURCE_TYPE");
$c=0;
$i=0;
$rsdb=tmq_dump2("media_type","code","name");
while ($r=tfa($s)) { //printr($r);
   ?><tr><td width=500 class=table_td><?php  echo $r[RESOURCE_TYPE]?> = <?php 
   echo $rsdb[$r[RESOURCE_TYPE]];
   ?></td><?php 
   $i++;
   ?><td align=right class=table_td width=100><?php  echo number_format($r[cc]);?> records</td><?php 
   ?><td align=right class=table_td width=100>Set Lang: <input name="ctrllang[<?php  echo $r[RESOURCE_TYPE]?>]" value="" maxlength=3 size=5></td><?php 
   ?></tr><?php 
}
?></table><?php 
echo getlang("กรุณาใส่รหัสภาษาในรายการประเภททรัพยากรที่ต้องการอัพเดท หากไม่สนใจประเภททรัพยากรใด ให้ปล่อยว่าง
::l::Please specific language code in desired type, if left blank will ignore");
?><BR><BR><BR>


<input type=submit value="<?php  echo "Process" ?>">
</center><?php 

foot();

?>