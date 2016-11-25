<?php 
	;
	include ("../inc/config.inc.php");
	include ("./local.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}
if ($needleid=="") {
?><CENTER><FORM METHOD=POST ACTION="mediaman.add.bybudget.php?edit=<?php  echo $edit?>">
<?php  echo getlang("กรุณาเลือกชุดงบประมาณที่จะเพิ่ม::l::Choose budget set to add");?><BR>
<SELECT NAME="needleid">
<?php 
	$s=tmq("select * from acq_setbudget order by yea,major");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[id]'>$r[yea]-$r[major] ";
}
?>
</SELECT><BR><INPUT TYPE="submit" value='<?php  echo getlang("ตกลง::l::Submit");?>'>
</FORM></CENTER><?php 
} else {
	$s=tmq("select * from acq_media where setbudget='$needleid' ");
	while ($r=tmq_fetch_array($s)) {
		addmedia($edit,$r[id]);
	}
	redir("mediaman.list.php?edit=$edit");

}

?>