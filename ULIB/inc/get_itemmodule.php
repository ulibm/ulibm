<?php 
function get_itemmodule($ID,$isjournalindex=false) {
	$s=tmq("select * from media where id =$ID ");
	if (tmq_num_rows($s)==0) {
		echo("ผิดพลาด ไม่สามารถหาวัสดุ $ID ได้");
	}

	$s=tmq_fetch_array($s);
	$d=substr($s[leader],7,1);
	if ($d=="") {
		echo("Leader/07 ผิดพลาด!");
	}
   if ($isjournalindex==true) {
   //echo "[$d]";
      if ($d=="b") {
         return "journalindex";
      }
   }
	$module["a"]="item"; // monographic component part
	$module["b"]="item"; // Serial component part
	$module["c"]="item"; // Collection
	$module["d"]="item"; // Subunit
	$module["m"]="item"; // Monograph
	$module["s"]="serial"; // Monograph
	$res=$module[$d];
	if ($res=="") {
		html_dialog("leader/07 error","ผิดพลาด ไม่สามารถหาประเภทวัสดุ ที่กำหนดใน leader/07 ของรายการ $ID ได้");
	}
	//echo "[$d]";
	return $res;
}
?>