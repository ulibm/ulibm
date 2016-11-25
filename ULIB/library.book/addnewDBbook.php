<?php  
;
     include("../inc/config.inc.php");
	 html_start();
loginchk_lib();
$ispublish=strtolower($ispublish);
echo $Sstr;
//die("[$ld_4]");
$leaderval="$ld_1$ld_2$ld_3$ld_4$ld_5$ld_6$ld_7$ld_8$ld_9$ld_10$ld_11$ld_12$ld_13$ld_14$ld_15$ld_16";
$fixedwidthval="$fw_1$fw_2$fw_3$fw_4$fw_5$fw_6$fw_7$fw_8$fw_9$fw_10$fw_11$fw_12$fw_13$fw_14$fw_15$fw_16$fw_17$fw_18$fw_19";
$leaderval=str_replace("฿"," ",$leaderval);
$fixedwidthval=str_replace("฿"," ",$fixedwidthval);
    // คำสั่งบันทึกลงฐานข้อมูล
	$now=time();
	$collist=",".@implode(",",$collist).",";
	$fixedwidthfield=getval("MARC","fixedwidthfield");
	if ($IDEDIT=="") { // if add new
     $sql ="INSERT INTO `media` set 
	 acqxlsref='$acqxlsref',
	 LIBSITE='$LIBSITE',
	 collist='$collist',
	 ispublish='$ispublish',
	 leader='$leaderval',
	$fixedwidthfield='$fixedwidthval',
		 ";
		$viewdifflogdata="
collist='$collist',
ispublish='$ispublish',
leader='$leaderval',
$fixedwidthfield='$fixedwidthval'".$newline;
		$sql82="select * from bkedit order by ordr";
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
						$viewdifflogdata=$viewdifflogdata.$row[fid]."=".$datatosave ;
					}
				}
				$datatosave=($datatosave);
				$sql = " $sql $row[fid]='".$datatosave."'$newline ,";
			}
		}
		$sql=trim($sql,",");
      
      if ($ld_4=="b") {
   		$media_edittrace_edittype="add new jindex.";
      } else if ($ld_4=="s") {
   		$media_edittrace_edittype="add new serial.";
      } else {
         $media_edittrace_edittype="add new bib.";
      }

	} // end if add new
else { // if edit
	$now=time();
	$timeold=$now-(60*30*1);
   tmq("delete from lock_bib where dt<$timeold");
   tmq("delete from lock_bib where bibid='$IDEDIT' ");
     $sql ="UPDATE `media` set 
	 collist='$collist',
	 ispublish='$ispublish',
	 leader='$leaderval',
	$fixedwidthfield='$fixedwidthval',
		 ";
	$sql82="select * from bkedit order by ordr";
		$result=tmq($sql82);
		$viewdifflogdata="
collist='$collist',
ispublish='$ispublish',
leader='$leaderval',
$fixedwidthfield='$fixedwidthval'".$newline;
		while ($row=tmq_fetch_array($result))	{
			$datatosave="";
			if ($fixedwidthfield!="$row[fid]") {
				for ($i=0;$i<=count($data[$row[fid]]);$i++) {
					$inditoadd=$dataindi1[$row[fid]][$i].$dataindi2[$row[fid]][$i];
					$inditoadd=str_replace('_'," ",$inditoadd);
					$datatoadd1=$inditoadd.$data[$row[fid]][$i];
					if (trim($data[$row[fid]][$i])!="") {
						$datatosave.=$datatoadd1.$newline;
						$viewdifflogdata=$viewdifflogdata.$row[fid]."=".$datatosave ;
					}
				}
				$datatosave=($datatosave);
				$sql = " $sql $row[fid]='".$datatosave."'$newline ,";
			}
		}
		$sql=trim($sql,",");
		$sql="$sql where ID='$IDEDIT' ";
		viewdiffman_add("bib","$IDEDIT",$viewdifflogdata);
      if ($ld_4=="b") {
   		$media_edittrace_edittype="update jindex.";
      } else if ($ld_4=="s") {
   		$media_edittrace_edittype="update serial.";
      } else {
         $media_edittrace_edittype="update bib.";
      }
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
		viewdiffman_add("bib","$IDEDIT",$viewdifflogdata);

	} else {
		//echo "using oldid=$IDEDIT";
	}
	index_reindex($IDEDIT);
	index_indexft($IDEDIT,true);
	sessionval_set("addbook-bringmeto",$bringmeto);

		$now=time();
		media_updatelastdt($IDEDIT);

		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$IDEDIT',
		edittype='$media_edittrace_edittype'
		",false);
		
      if ($ORIGIDEDIT!="" && $IDEDIT!=$ORIGIDEDIT) {
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$IDEDIT',
		edittype='this record copied from id=$ORIGIDEDIT'
		",false);
      }
//chainer start
if ($chainid!="" && $chainmaster!="") {
	tmq("delete from chainerlink where chain='$chainid' and fromid='$chainmaster' and destid='$IDEDIT' ");
	tmq("insert into chainerlink set chain='$chainid' , fromid='$chainmaster' , destid='$IDEDIT' ,dt='$now',frommid='$chainfrommid' ",false);
	///die;
}
//chainer end

//echo $forcebringmeto; die;
if ($forcebringmeto=="serial") {
	redir($dcrURL."library.serials/seriallist.php"); die;
}

if ($isreturn=="on") {
  echo"<meta http-equiv='refresh'
content='0;URL=addDBbook.php?sid=$sid&typeid=$typeid&faculty=$faculty&IDEDIT=$IDEDIT&startrow=$startrow'>";   
} else {
	if ($bringmeto=="") {
	  echo"<meta http-equiv='refresh' content='0;URL=DBbook.php?typeid=$typeid&faculty=$faculty&IDEDIT=$IDEDIT&startrow=$startrow&linkfrom=$IDEDIT'>";
	}
	if ($bringmeto=="backtochain") {
	  echo"<meta http-equiv='refresh' content='0;URL=../library.chainer/items.php?chainid=$chainid&chainmaster=$chainmaster'>";
	}
	if ($bringmeto=="addnewrecord") {
	  echo"<meta http-equiv='refresh' content='0;URL=addDBbook.php?startrow=$startrow'>";
	}
	if ($bringmeto=="addnewitem") {
		if (strtolower($ld_4)=="m") {
		  echo"<meta http-equiv='refresh' content='0;URL=../library.bitem/media_type.php?MID=$IDEDIT&remotes_row=$startrow'>";
		} else {
		  echo"<meta http-equiv='refresh' content='0;URL=DBbook.php?IDEDIT=$IDEDIT&linkfrom=$IDEDIT'>";
		}
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