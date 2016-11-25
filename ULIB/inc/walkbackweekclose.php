<?php 
function walkbackweekclose($dat,$mon,$yea) {
	//เริ่มทำการรวบรวมข้อมูลวันหยุดประจำสัปดาห์
	      global $LIBSITE;
      if (trim($LIBSITE)=="") {
         $LIBSITE="main";
      }
	$yea=$yea-543;
	//echo "[$yea]";die;
	$r=tmq("select * from weeklyclose");
	while ($r2=tmq_fetch_array($r)) {
		$weeklyclose = "$weeklyclose,$r2[dat],";
	}
	//echo $weeklyclose;
	// สิ้นสุดการรวบรวมข้อมูลวันหยุดประจำสัปดาห์   
        //echo "$dat,$mon,$yea";
	$modyear =floatval($yea) ;
	//echo $modyear;
	global $thaidaystr;

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

		   	$modi=0;
			//echo "$mon, $dat-$modi, $modyear<br>";
		   //echo date("j.n.Y",mktime(0, 0, 0, $mon, $dat-$modi, $modyear));
		//	echo "[$closeserv]"; //die;

while (strpos($weeklyclose,date("w",mktime(0, 0, 0, $mon, $dat-$modi, $modyear))) !== false ||
		strpos($closeserv,date("j.n.Y",mktime(0, 0, 0, $mon, $dat-$modi, $modyear))) !== false
) {
	//$weekdat = mktime(0, 0, 0, $mon, $dat-$modi, $modyear);
	//echo date("d m Y",$weekdat) . " =  " . $thaidaystr[date("w",$weekdat)] .  "*** ";
	if (strtolower(getval("_SETTING","checkoutwalkbackmode"))=="forth") {
		$modi =$modi-1;
	} else {
		$modi =$modi+1;
	}
	//echo " modi=$modi";
}

	$weekdat = mktime(0, 0, 0, $mon, $dat-$modi,  $modyear);
	$tmp= date("d m Y",$weekdat);
	//echo $tmp; die;

	//adding 543 tobe thai date
	$tmp=explode(" ",$tmp);
	return "$tmp[0] $tmp[1] " . ($tmp[2]+543);
	//. " =  " . $thaidaystr[date("w",$weekdat)] .  "*** ";
	//return $tmp;
}
?>