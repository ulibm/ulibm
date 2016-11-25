<?php 
;
     include("../inc/config.inc.php");
	 $_REQPERM="serialsmodule-manageserial";
	 html_start();
	 if ($setmute!=0) {
		tmq("insert into serial_muteexpect set mid='$setmute' ");
	 }
$rectag=getval("MARC","serial_rectype");


  $sql1 ="SELECT  *  FROM media where leader  like '_______s%' ";
  $sql1="$sql1 order by id desc";
  $result = tmqp($sql1,"$PHP_SELF?keyword=$keyword&isbn=$isbn&sbc=$sbc");
         
?>
<table width="100%" align=center border="0" cellspacing=0 cellpadding="1" class=table_border> 
<tr > 
<td class=table_head><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?></td>
</tr> 
                  <?php  
$i=1;  

while($row = tmq_fetch_array($result)){ 
	$chkmute=tmq("select id from serial_muteexpect where mid='$row[ID]' ");
	if (tnr($chkmute)!=0) {
		continue;
	}

	$DatabaseID = $row[DatabaseID]; 
	$mID = $row[ID]; 
	$MID = $row[ID]; 
	$mName = $row[tag245]; 
	$ittt = ($startrow)+$i; 
					
$latest=tmq("select * from media_mid where pid='$MID' and RESOURCE_TYPE='serial' and (jchrono_1<>'0' or jchrono_2<>'0' or jchrono_3<>'0') and bcode<>'' order by jchrono_1 desc, jchrono_2 desc, jchrono_3 desc,jenum_1 desc,jenum_2 desc,jenum_3 desc, jenum_4 desc, jenum_5 desc , jenum_6 desc",false);
$lateststr="";
if (tmq_num_rows($latest)<>0) {
	$havelatest="yes";
	$latest=tmq_fetch_array($latest);
	$lateststr.= marc_getserialcalln($latest[id],"sum");
	$lateststr.= " (";
	$lateststr.= "$latest[jchrono_1]";
	if ($latest[jchrono_2]!=0) {
		$lateststr.= "-$latest[jchrono_2]";
	}
	if ($latest[jchrono_3]!=0) {
		$lateststr.= "-$latest[jchrono_3]";
	}
	$lateststr.= ")";

	$rectype=$row[$rectag];
	$rectype=dspmarc(substr($rectype,2));
	$rectype=trim($rectype);
	//echo $rectype;
	$rectp=tmq("select * from serials_rectype where namelist like '%,$rectype,%' ",false);
	if (tnr($rectp)==0) {
		continue;
	}
	$rectps=tmq_fetch_array($rectp);
	$next_dat=$latest[jchrono_3]+$rectps[inc_day];
	$next_mon=$latest[jchrono_2]+$rectps[inc_mon];
	$next_yea=$latest[jchrono_1]+$rectps[inc_yea];
	if ($rectps[inc_mon]!=0 && $next_dat==0) {
		 $next_dat=1;
		 $next_dat_skipdat="yes";
	}
	//echo "[$next_dat,$latest[jchrono_2]->$next_mon,$next_yea]";

	$caler=ymd_mkdt($next_dat,$next_mon,$next_yea-543);
	$next_dat=date("j",$caler);
	$next_mon=date("n",$caler);
	$next_yea=date("Y",$caler)+543;
	//echo "[$next_dat-$next_mon-$next_yea]";
	if ($caler>time()) { // if expect in the future , continue
		continue;
	}
	if ($latest[jchrono_3]=="" && $rectps[inc_day]==0) {
		$next_dat=0;
	}
} else {
	continue;
}


	if ($linkfrom==$mID)  {
			  echo "<tr bgcolor=#BFFFE6> "; 
	} else {
		if ($i%2==0) {
			  echo "<tr bgcolor=#FFF1BB> "; 
		} else {
			  echo " <tr bgcolor=#FFFFFF> "; 
		}	
	}
          $strtype= $row3[show];  
          echo "<td class=table_td><a href=\"$dcrURL"."library.serials/serial-items.php?MID=$row[ID]&MIDpage=1\" target=_top>".marc_gettitle($mID);
		  $det=marc_getyea($mID);
		  if (trim($det)!="") {
			 echo "/".$det;
		  }
   echo "</a><br>"; 
 echo"<font class=smaller>$lateststr<br>
 <b class=smaller>Expected</b>:";
 	echo "$next_yea";
	if ($next_mon!=0) {
		echo "-". $thaimonstr[$next_mon];
	}
	if ($next_dat!=0 && $next_dat_skipdat!="yes") {
		echo "-$next_dat";
	}
 echo " </font>";

echo "<a href='$PHP_SELF?setmute=$row[ID]' class='a_btn smaller2' >Mute</a>";
           echo "</td> </tr>"; 
		$i++; 
        $s = $i-1; 
}
	
echo $_pagesplit_btn_var;
 ?> 
</table> 
