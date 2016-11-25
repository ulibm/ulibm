<?php  
;

     include("../inc/config.inc.php");
        loginchk_lib();
sessionval_set("getnextbc_bitem",0);

$now=time();

//printr($bcode);
//printr($inumber);
//printr($tabean);
//die;
$err="no";
if ($forcenoitem!="yes") {
	while (list($k,$v)=each($bcode)) {
		if ($bcode[$k]=="") {
				 echo getlang("บาร์โค้ดห้ามเป็นค่าว่าง::l::Barcode cannot be empty")." tabean=".$tabean[$k];
				 echo ",inumber=".$inumber[$k]."<BR>";
				 $err="yes";
			}
		$s="select * from media_mid where bcode='".$bcode[$k]."' ";
		$r=tmq($s);
		$n=tmq_num_rows($r);
		if ($n!=0) {
			echo "".getlang("หมายเลขบาร์โค้ด ".$bcode[$k]." ถูกใช้ไปแล้ว::l::Barcode ".$bcode[$k]." duplicated")."<BR>";
				$err="yes";
		}
	}
}

if ($err!="no") {
	 echo "<a href='serial-items.php?MID=$MID&MIDpage=$MIDpage'>".getlang("กลับ::l::Back")."</a>";
	 die();
}

if ($mode=="bounditem") {
	reset($slist);
	tmq("delete from globalupload where keyid='tmpbound'");
	foreach ($slist as $value) {
		//tmq("update media_mid set bcode='' ,RESOURCE_TYPE='boundedserial' where id='$value' ");
		$sourcesitem=tmq("select * from media_mid where id='$value'");
		while ($row=tmq_fetch_array($sourcesitem)) {
   		$keyid="SERIAL-$row[pid]-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";
   		//tmq("update globalupload set keyid='tmpbound' where keyid='$keyid' ");
   		globalupload_changekeyid($keyid,"tmpbound");
   	}
		//$chka=tmq("select * from globalupload where keyid='$keyid' ",false);
		
		//die;
		
		
	}
	reset($slist);
	foreach ($slist as $value) {
	  tmq("delete from media_mid where id='$value' ");
	}
} 

reset($bcode);
	/*tmq("delete from media_mid where pid='$MID' and 	jenum_1='$jenum_1' and
	jenum_2='$jenum_2' and
	jenum_3='$jenum_3' and
	jenum_4='$jenum_4' and
	jenum_5='$jenum_5' and
	jenum_6='$jenum_6' and
	jchrono_1='$jchrono_1' and
	jchrono_2='$jchrono_2' and
	jchrono_3='$jchrono_3'  ");*/
	$hrs=getval("config","timetocirputtoshelf");
$hrsod=trim(getval("config","timeofdaytocirputtoshelf"),", ");
if ("$hrs"=="-1" && $hrsod!="") {
   $hrsoda=explode(",",$hrsod);
   sort($hrsoda);
   $hrsoda=arr_filter_remnull($hrsoda);
   @reset($hrsoda);
   $plusaday=0;
   $nowhrs=date("H.i");
   $usehrs="";
   while (list($hrsodk,$hrsodv)=each($hrsoda)) {
      //echo "[$nowhrs--$hrsodv]<BR>";
      if ($nowhrs<$hrsodv) {
         $usehrs=$hrsodv;
      }
   }
   if ($usehrs=="") {
      //first on next day
      $plusaday=1;
      @reset($hrsoda);
      list($hrsodk,$hrsodv)=each($hrsoda);
      $usehrs=$hrsodv;
   }
   $timetoshelf=ymd_mkdt(date("d")+$plusaday,date("m"),date("Y"));
   $usehrsa=explode(".",$usehrs);
   $timetoshelf=$timetoshelf+(($usehrsa[0])*60*60)+(($usehrsa[1])*60);
   
      //echo "got $usehrs - ".ymd_datestr($timetoshelf);; die;

} else {
   $timetoshelf=time()+(60*60*$hrs);
}

while (list($k,$v)=each($bcode)) {

     $sql ="insert into media_mid ";
     $sql.=" set pid='$MID',
     status='$Fstatus',
		 tabean='".$tabean[$k]."',
		 bcode='".$bcode[$k]."',
		 RESOURCE_TYPE='$RESOURCE_TYPE',
		 inumber='".$inumber[$k]."',
		 price='$price',
		 libsite='$FLIBSITE',
		 place='$itemplace',
		 note='$note',
		 lastcheckin='$timetoshelf',
		 dt='$now',
		 calln='$calln',
		 status_lastupdate='$now',
		 
	jenum_1='$jenum_1' ,
	jenum_2='$jenum_2' ,
	jenum_3='$jenum_3' ,
	jenum_4='$jenum_4' ,
	jenum_5='$jenum_5' ,
	jenum_6='$jenum_6' ,
	jchrono_1='$jchrono_1' ,
	jchrono_2='$jchrono_2' ,
	jchrono_3='$jchrono_3' ,
	jnonpublicnote='$jnonpublicnote' ,
	javaistatusnote='$javaistatusnote' ,
	jpublicnote='$jpublicnote'
	
		";
      //echo $sql;
    tmq($sql,false);
$newid=tmq_insert_id();

media_updatelastdt($MID,"item");


////////////////update chainer start
if ($mode=="bounditem") {
	reset($slist);
	foreach ($slist as $value) {
		tmq("update chainerlink set frommid='$newid' where frommid='$value' ");
	}
	$keyid="SERIAL-$MID-attatch-$jenum_1-$jenum_2-$jenum_3-$jenum_4-$jenum_5-$jenum_6-$calln";
	globalupload_changekeyid("tmpbound",$keyid);
	//tmq("update globalupload set keyid='$keyid' where keyid='tmpbound' ");

}
////////////////update chainer end

	$now=time();
	if ($mode=="bounditem") {

		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='bound item bc=".$bcode[$k]."'		",false);
	} else {
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='add serial item bc=".$bcode[$k]."'		",false);
	}
}
redir("serial-items.php?MID=$MID&MIDpage=$MIDpage");
?>