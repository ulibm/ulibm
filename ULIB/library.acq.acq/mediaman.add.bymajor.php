<?php 
	;
	include ("../inc/config.inc.php");
	include ("./local.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}
if ($needleid=="") {
?><CENTER><FORM METHOD=POST ACTION="mediaman.add.bymajor.php?edit=<?php  echo $edit?>">
<?php  echo getlang("กรุณาเลือกสาขาวิชาที่จะเพิ่ม::l::Add subject to add");?><BR>
<SELECT NAME="needleid">
<?php 
	$s=tmq("select * from major order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[name]'>$r[name] ";
}
?>
</SELECT><BR><INPUT TYPE="submit" value='<?php  echo getlang("ตกลง::l::Submit");?>'>
</FORM></CENTER><?php 
} else {
	$s=tmq("select * from acq_setbudget where major='$needleid' ");
	while ($r=tmq_fetch_array($s)) {
		$s2=tmq("select * from acq_media where setbudget='$r[id]' ");
		while ($r2=tmq_fetch_array($s2)) {
			addmedia($edit,$r2[id]);
		}
	}
	redir("mediaman.list.php?edit=$edit");

}

?>