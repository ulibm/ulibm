<?php 
function getduedecis($tmp, $Fdat, $Fmon, $Fyea) {
      global $LIBSITE;
      if (trim($LIBSITE)=="") {
         $LIBSITE="main";
      }
		//echo "getduedecis($tmp, $Fdat, $Fmon, $Fyea)";
		//echo $Fyea;
		$Fyea = $Fyea; //ปรับเป็น ค.ศ.

		$sqlchk="select * from checkout where mediaId='$tmp'";
        //echo "$sqlchk";
        $result1chk=tmq($sqlchk);
		if (tmq_num_rows($result1chk)==0) {
			die("getduedecis($tmp, $Fdat, $Fmon, $Fyea) cannot find from checkout where mediaId='$tmp' ");
		}
        echo tmq_error();
        $row1chk=tmq_fetch_array($result1chk);
        $edat=$row1chk[edat];
        $emon=$row1chk[emon];
        $eyea=$row1chk[eyea]-543;
        $xfine=$row1chk[fine];
        $mdtitle=$row1chk[mediaName];
        $requestid=$row1chk[request];
        $gbisrq=$row1chk[request];
        $smemberid=$row1chk[hold];
        //echo "กำหนดส่ง $edat $emon $eyea";
        /////////////////////////////////
        ///////////////// ดึงข้อมูลวันหยุด
        $sql4cf="SELECT * FROM closeservice where libsite='$LIBSITE' ";
        if ($result4cf=tmq($sql4cf)) {
            //echo "ดึงข้อมูลจากตาราง closeservice ได้";
       } else {
            echo "ไม่สามารถเปิดตาราง closeservice " . tmq_error(); 	die;
       }
        $closeserv="";
        while ($row4cf=tmq_fetch_array($result4cf)) {
            $cdat = $row4cf[dat];
            $cmon=$row4cf[mon];
			if ($row4cf[yea]!=-1) {
				$cyea=$row4cf[yea]-543;
			} else {
				$cyea=date('Y');
			}
			  $closeserv="$closeserv $cdat.$cmon.$cyea"; //สร้าง text array สำหรับวันหยุด
			  if ($row4cf[yea]==-1) {
				$cyea=date('Y')+1; //new year eve!
				$closeserv="$closeserv $cdat.$cmon.$cyea";
			  }
           }

        //echo "[$closeserv]"; die;

        $tmpdecis=ddxl($edat, $emon, $eyea, $Fdat, $Fmon, $Fyea); 
        //$tmpdecis=ddxl( $Fdat, $Fmon, $Fyea, $edat, $emon, $eyea); 
		// ได้ text array ที่เป็นวันซึ่งเกินกำหนดส่ง
		//echo $tmpdecis; 
        $closeserv=trim($closeserv);
        $tmpdecis=trim($tmpdecis);
        //echo "<hr>[tmpdecis>>$tmpdecis<<";
        $closes=explode(" ", $closeserv);
        //echo "<hr>[closeserv>>$closeserv<<";
        foreach ($closes as $closesi) {
            $tmpdecis=str_replace("$closesi", "", $tmpdecis); 
			//ลบวันที่ตรงกับวันหยุดออก โดยการแทนที่ด้วยค่าว่าง
		}

	//echo "<hr>[tmpdecisReplaced>>$tmpdecis<<";
        //echo $tmpdecis;
        $tmpdecis=rem2space($tmpdecis);
        $tmpdecis2=explode(" ", $tmpdecis);
        $tmpdecis=0; //count($tmpdecis);
        foreach ($tmpdecis2 as $tmpdecisc) {
            if ($tmpdecisc != "") {
                //echo "<U>$tmpdecisc</U> ";
                $tmpdecis++;
                }
            }
        return $tmpdecis;
}
?>