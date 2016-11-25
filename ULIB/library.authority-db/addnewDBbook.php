<?php  
;
     include("../inc/config.inc.php");
loginchk_lib();

echo $Sstr;
    // คำสั่งบันทึกลงฐานข้อมูล
	$now=time();
	$fixedwidthfield=getval("MARC","fixedwidthfield");
	if ($IDEDIT=="") { // if add new
     $sql ="INSERT INTO  authoritydb  set 
	 leader='$ld_1$ld_2$ld_3$ld_4$ld_5$ld_6$ld_7$ld_8$ld_9$ld_10$ld_11$ld_12$ld_13$ld_14$ld_15$ld_16',
	$fixedwidthfield='$fw_1$fw_2$fw_3$fw_4$fw_5$fw_6$fw_7$fw_8$fw_9$fw_10$fw_11$fw_12$fw_13$fw_14$fw_15$fw_16$fw_17$fw_18$fw_19',
		 ";
		$sql82="select * from bkedit_authority order by ordr";
		$result=tmq($sql82);
		while ($row=tmq_fetch_array($result))	{
			$datatosave="";
			if ($fixedwidthfield!="$row[fid]") {
				for ($i=0;$i<=count($data[$row[fid]]);$i++) {
					$inditoadd=$dataindi1[$row[fid]][$i].$dataindi2[$row[fid]][$i];
					$inditoadd=str_replace('_'," ",$inditoadd);
					$datatoadd1=$inditoadd.$data[$row[fid]][$i];
					if (trim($data[$row[fid]][$i])!="") {
						$datatosave.=$datatoadd1.$newline;
					}
				}
				$datatosave=($datatosave);
				$sql = " $sql $row[fid]='".$datatosave."'$newline ,";
			}
		}
		$sql=trim($sql,",");

		$media_edittrace_edittype="add new bib.";
	} // end if add new
else { // if edit
     $sql ="UPDATE  authoritydb  set 
	 leader='$ld_1$ld_2$ld_3$ld_4$ld_5$ld_6$ld_7$ld_8$ld_9$ld_10$ld_11$ld_12$ld_13$ld_14$ld_15$ld_16',
	$fixedwidthfield='$fw_1$fw_2$fw_3$fw_4$fw_5$fw_6$fw_7$fw_8$fw_9$fw_10$fw_11$fw_12$fw_13$fw_14$fw_15$fw_16$fw_17$fw_18$fw_19',
		 ";
	$sql82="select * from bkedit_authority order by ordr";
		$result=tmq($sql82);
		while ($row=tmq_fetch_array($result))	{
			$datatosave="";
			if ($fixedwidthfield!="$row[fid]") {
				for ($i=0;$i<=count($data[$row[fid]]);$i++) {
					$inditoadd=$dataindi1[$row[fid]][$i].$dataindi2[$row[fid]][$i];
					$inditoadd=str_replace('_'," ",$inditoadd);
					$datatoadd1=$inditoadd.$data[$row[fid]][$i];
					if (trim($data[$row[fid]][$i])!="") {
						$datatosave.=$datatoadd1.$newline;
					}
				}
				$datatosave=($datatosave);
				$sql = " $sql $row[fid]='".$datatosave."'$newline ,";
			}
		}
		$sql=trim($sql,",");
		$sql="$sql where ID='$IDEDIT' ";
		
		$media_edittrace_edittype="update bib.";
	} // end if edit
		//echo "<BR><PRE>$sql</PRE>";
		//die;
  if(tmq($sql)) {

	echo"<font face ='ms sans serif'  size ='3'>";
	echo"<div align=center><br><b>ทำการเพิ่มข้อมูลเรียบร้อยแล้ว</b><br></div>";
	$typeid = str_replace(" ","%20",$typeid);
        $faculty = str_replace(" ","%20",$faculty);
	if ($IDEDIT=="") {
		$IDEDIT=tmq_insert_id();
		//echo "using new id =$IDEDIT";
	} else {
		//echo "using oldid=$IDEDIT";
	}

	sessionval_set("addauthority-bringmeto",$bringmeto);


if ($isreturn=="on") {
echo"<meta http-equiv='refresh'
content='0;URL=addDBbook.php?sid=$sid&typeid=$typeid&faculty=$faculty&IDEDIT=$IDEDIT&startrow=$startrow'>";   
} else {
	if ($bringmeto=="") {
	  echo"<meta http-equiv='refresh' content='0;URL=DBbook.php?typeid=$typeid&faculty=$faculty&IDEDIT=$IDEDIT&startrow=$startrow&linkfrom=$IDEDIT'>";
	}
	if ($bringmeto=="addnewrecord") {
	  echo"<meta http-equiv='refresh' content='0;URL=addDBbook.php?startrow=$startrow'>";
	}
}
       } else {
      echo"<font face ='ms sans serif'  size ='3'>";
		echo "<b>Error </b> $sql<br>ไม่สามารถบันทึกข้อมูล 
อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
    	echo"</font><BR>".tmq_error();
	}

	echo $Estr;
?>