<?php 
    ;
	
	$s=tmq("select * from bkedit");
	while ($r=tfa($s)) {
	  $indiexamplecache="";
	  $indi1="";
	  $indi2="";
	  
	  $s2=tmq("select * from bkedit_indi where tag='$r[fid]' and indiid=1 ");
	  if (tnr($s2)!=0) {
	     $indiexamplecache.="\nIndicator #1";
	  }
	  if (tnr($s2)==10) {
   	     $indi1=$indi1."0,1,2,3,4,5,6,7,8,9";
   	     $indiexamplecache=$indiexamplecache."\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>0-9</b> - Number of nonfiling characters";
   	} else {
   	  while ($r2=tfa($s2)) {
   	     $indi1=$indi1.",".$r2[indi];
   	     $indiexamplecache=$indiexamplecache."\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$r2[indi]</b> - ".$r2[descr];
   	  }
	  }
	  $s2=tmq("select * from bkedit_indi where tag='$r[fid]' and indiid=2 ");
	  if (tnr($s2)!=0) {
	     $indiexamplecache.="\nIndicator #2";
	  }
	  if (tnr($s2)==10) {
   	     $indi2=$indi2."0,1,2,3,4,5,6,7,8,9";
   	     $indiexamplecache=$indiexamplecache."\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>0-9</b> - Number of nonfiling characters";
   	} else {	  
   	  while ($r2=tfa($s2)) {
   	     $indi2=$indi2.",".$r2[indi];
   	     $indiexamplecache=$indiexamplecache."\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$r2[indi]</b> - ".$r2[descr];
   	  }
	  }
	  $indi1=trim($indi1,",");
	  $indi2=trim($indi2,",");
	  tmq("update bkedit set defindi1='$indi1',defindi2='$indi2',indiexamplecache='".addslashes($indiexamplecache)."' where id='$r[id]' ",false);
	}
	// พ
  ?>