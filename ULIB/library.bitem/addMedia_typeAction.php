<?php  
;

     include("../inc/config.inc.php");
        loginchk_lib();
//printr($bcode);
//printr($inumber);
//printr($tabean);
//die;
sessionval_set("getnextbc_bitem",0);

$dt=time();
$dt_str=floor(date('d')).'-'.floor(date('m')).'-'.floor(date('Y'));

$err="no";
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
    	echo "".getlang("หมายเลขบาร์โค้ด [".$bcode[$k]."] ถูกใช้ไปแล้ว::l::Barcode ".$bcode[$k]." duplicated")."<BR>";
			$err="yes";
    }
}

if ($err!="no") {
	 echo "<a href='media_type.php?MID=$MID&remotes_row=$remotes_row'>".getlang("กลับ::l::Back")."</a>";
	 die();
}
reset($bcode);
$now=time();
$note=addslashes($note);
$adminnote=addslashes($adminnote);
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
         break;
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
     $sql ="insert into media_mid (pid,tabean,bcode,RESOURCE_TYPE,inumber,price,libsite,place,note,calln, dt,dt_str,adminnote,status_lastupdate,lastcheckin,status)";
     $sql.=" values ('$MID','".$tabean[$k]."','".$bcode[$k]."','$RESOURCE_TYPE','".$inumber[$k]."','$price','$FLIBSITE','$itemplace','$note','".$calln[$k]."','$dt','$dt_str','$adminnote','$now','$timetoshelf','$status')";
      //echo $sql;
    tmq($sql);
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='add item bc=".$bcode[$k]."'		");
		media_updatelastdt($MID,"item");
}

sessionval_set("lastrestourcetypeitem",$RESOURCE_TYPE);
sessionval_set("lastrestourceplaceitem",$itemplace);
sessionval_set("defstatussess",$status);
index_reindex($MID);
redir("media_type.php?MID=$MID&remotes_row=$remotes_row");
?>