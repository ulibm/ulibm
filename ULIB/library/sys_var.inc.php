<?php 
function local_mn($formid,$main,$sub,$filter) {
	global $issave;// พ
	if ($issave=="yes") {
		eval("global \$$formid;");
		eval("\$vals= \$$formid;");			
		$vals=addslashes($vals);
		$sql="update val set val='$vals' where main='$main' and sub='$sub' ";
		tmq($sql);
		tmq("delete from valmem where main='$main' and sub='$sub' ");
	}
	$s=tmq("select * from val where main='$main' and sub='$sub' ");
	$rechecknum=tnr($s);
		if ($rechecknum>1) {
		 tmq("delete from val where main='$main' and sub= '$sub' limit 1");
		}
	if (tmq_num_rows($s)!=1) {
		 die("val where main='$main' and sub='$sub' ");
	}
	$s=tmq_fetch_array($s);
	?><tr valign = "top" 
	onmouseover="this.style.backgroundColor='#f2f2f2'; return true;"
	onmouseout="this.style.backgroundColor='#ffffff'; return true;"
	>
	  <td width=50%><?php  echo getlang($s[descr]);?></td>
	  <td width=50%><?php  form_quickedit($formid,getval($main,$sub),$filter); ?></td>
	 </tr><?php 
}
?>