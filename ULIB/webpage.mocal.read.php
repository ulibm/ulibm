<?php 
;
  include("inc/config.inc.php");
	html_start();
	if ($issave=="yes") {
		 $now=time();
		 $comment=addslashes($comment);
		 tmq("insert into webpage_mocalen_resp set pid='$id' , dt=$now, text='$comment',memid='$_memid'; ");
	}
	if ($delete!="" && loginchk_lib('check')==true ) {
		 tmq("delete from webpage_mocalen_resp where  pid='$id' and id='$delete' ");
	}
	$s=tmq("select * from webpage_mocalen where isshow='yes' and id='$id'");
	$s=tmq_fetch_array($s);
	$s[descr]=stripslashes(trim($s[descr]));
 ?>
<table width=100% class=table_border>
<tr><td class=table_head style="color:white; background-color:<?php  echo $s[col]?>; padding-top:8;padding-bottom:8; background-image: url(./neoimg/mocalhead.png);background-repeat:no-repeat;"><?php  echo stripslashes($s[title]);?></td></tr>
<?php  if ($s[descr]!="") {?>
<tr><td class=table_head2><?php  echo stripslashes($s[descr]);?></td></tr>
<?php  } ?>
<tr><td class=table_td><?php  echo stripslashes($s[text]);?></td></tr>
</table>
<table width=100%  cellpadding=10>
<tr><td  align=right>
 <?php 
	$s2=tmq("select * from webpage_mocalen_resp where pid='$id' order by dt");
	while($r=tmq_fetch_array($s2)) {
 ?>
<table width=90%  class=table_border style="margin-top:10">
<tr><td class=table_td ><?php  echo ymd_datestr($r[dt]);?><br />
<?php  
  if ($r[memid]!="") {
		 echo "<b>".get_member_name($r[memid])."</b><BR>";
	}
	echo stripslashes($r[text]);
	if (loginchk_lib('check')==true) {
	?><br /><a href="webpage.mocal.read.php?id=<?php  echo $s[id]?>&delete=<?php  echo $r[id]?>">delete</a><?php 
	}
?></td></tr>
</table>
<?php  
}
?>
</td></tr>
</table>
<?php 
if (barcodeval_get("mocal-o-allowcomment")=="yes") {
$currentresp=tmq("select distinct memid from webpage_mocalen_resp where pid='$id' ");
$currentresp=tmq_num_rows($currentresp);
//echo "[$currentresp]";
if ($s[disablecomment]!="yes" && $currentresp<$s[maxresp]) {

	if ($_memid!="") {
?>
<table width=100% class=table_border>
<form action="webpage.mocal.read.php">
<input type="hidden" name="issave" value="yes" />
<input type="hidden" name="id" value="<?php  echo $id?>" />
<tr><td  class=table_head style="color:white; background-color:<?php  echo $s[col]?>; padding-top:5;padding-bottom:5"><?php  echo getlang("ฝากข้อความ::l::Comments");?></td></tr>
<tr><td class=table_head2><textarea rows="" cols="" name="comment" style="width:100%;height:150px;"></textarea></td></tr>
<tr><td class=table_head2><input type="submit" value=" <?php echo getlang("ส่งข้อมูล::l::Send");?> "></td></tr>
</form></table>
<?php 
	} else {
		html_dialog("","กรุณาล็อกอินก่อนจึงสามารถแสดงความเห็นได้::l::Please login before give comment");
	}
}
}
?>