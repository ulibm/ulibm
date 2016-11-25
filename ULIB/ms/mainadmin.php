<?php 
    ;
include("../inc/config.inc.php");
//head();
include("mainbodybackground.php");
if ($useradminidx!="") {
	session_unset($useradminid, $passwordadmin, $loginadmin, $Level);
}
//echo "[$fieldcode]";
html_start();
if ($fieldcode=="") {
	$fieldcode="UserAdminID";
}
   if (substr($useradminidx,0,5)=="ecard") {
      $ecardid=substr($useradminidx,5);
      $ecard=tmq("select * from ulibecard where id='$ecardid' ",false);
      if (tnr($ecard)!=0) {
         $ecard=tfa($ecard);
         $useradminidx=$ecard[memid];
      }
      //die;///
   }
   
$useradminidx = $useradminidx;
if ($useradminidx=="") {
	echo "<center>กรุณาระบุรหัสสมาชิก";
	foot();  
	die;
}
?><!-- <?php 
tmq("alter table member add userid  varchar (255) ; ");
tmq("alter table member add UserID01  varchar (255) ; ");
?> --><?php 
//printr($_GET);
/*
if (strtolower($msss[welcomesound])=="ยินดีต้อนรับ") {
   ?><audio controls autoplay style="display:none">
   <source src="yindee.mp3" type="audio/mp3">
   </audio><?php
}
*/


$sql ="select * from member where $fieldcode='$useradminidx'"; 
//echo $useradminidx;
//echo $sql;  
/*
 tmq("update member set countlogin=countlogin+1  where useradminidx='$useradminidx'");

 */
                    $result = tmq($sql); 
         if(!$result) { 
             die ("SELECT มีข้อผิดพลาด".tmq_error()); 
         } 
         //http://translate.google.com/translate_tts?tl=th&q="xxxxxxxxx"
  if (!$row = tmq_fetch_array($result)) {
  echo "<BR><BR><BR><BR><CENTER><font color=red>กรุณาตรวจสอบหมายเลขบาร์โค้ด หรือติดต่อเจ้าหน้าที่บรรณารักษ์<BR><BR>[$useradminidx]</CENTER><BR><BR><BR><BR>";
   ?><audio controls autoplay style="display:none" id="welcomeaudioID">
   <source src="barcodenotfound.mp3" type="audio/mp3">
   </audio><?php
	foot();
die;
  }
  
  
$mss=tmq("select * from ms_sub where code='$use' ");
$msss=tfa($mss);
if (strtolower($msss[welcomesound])!="none" && strtolower($msss[welcomesound])!="") {
   $audio="";
   if (($msss[welcomesound])=="สวัสดี") {
      $audio="sawasdee";
   }
   if (($msss[welcomesound])=="ยินดีต้อนรับ") {
      $audio="yindee";
   }
   if (strtolower($msss[welcomesound])=="welcome") {
      $audio="welcome";
   }
   if (strtolower($msss[welcomesound])=="depending on time of day") {
      $time = date("H");
      /* Set the $timezone variable to become the current timezone */
      $timezone = date("e");
      /* If the time is less than 1200 hours, show good morning */
      if ($time < "12") {
          $audio= "Good-morning";
      } else
      /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
      if ($time >= "12" && $time < "17") {
          $audio= "Good-afternoon";
      } else
      /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
      if ($time >= "17" && $time < "21") {
          $audio= "Good-evening";
      } else
      /* Finally, show good night if the time is greater than or equal to 1900 hours */
      if ($time >= "21") {
          $audio= "Good-night";
      }
   } 
   if ($audio!="") {
   ?><audio controls autoplay style="display:none" id="welcomeaudioID">
   <source src="<?php echo $audio?>.mp3" type="audio/mp3">
   </audio><?php
   }
}

          $UserAdminName=$row[UserAdminName]; 
          $email=$row[email];
          $descr=$row[descr];
          $statusactive=$row[statusactive]; 
          $address=$row[address];
          $tel=$row[tel];
          $lib=$row[library]; 
          $prefi=$row[prefi];
          $mdat=$row[dat];
          $mmon=$row[mon];
          $myea=$row[yea];
          $mpic=$row[picture];
           $lastlog=$row[lastlogin];
//echo "LASTLOGIN $lastlog";

$passsec = time() - $lastlog;
//echo "เวลานับจากการล็อกอินผ่านไปแล้วผ่านไปแล้ว ". ( $passsec) . " วินาที";
//////////////////
  $sql3 ="SELECT *  FROM member where $fieldcode='$useradminidx'";  //หา old data
//echo $sql3; 
  $result3 = tmq($sql3);  
$row3 = tmq_fetch_array($result3);  
$useradminidxUSE=$row3[UserAdminID];

$oldc = $row3[room];
$mstat = $row3[type];
$passwordadmin = $row3[type];
//$min=getval("config","timeout-at-libgate");; //เวลาระยะห่างระหว่างการล็อกอิน
$timesetting=tmq("select * from ms_sub where code='".sessionval_get("msrunningsub")."' ");
$timesetting=tfa($timesetting);
$min=floor($timesetting[min]);
$mins=$min*60;
//echo "วินาที= $mins";
          $membertype=$row[type];
if ( ($passsec<($mins) || $lastlog>time()) && $mins != 0) {
       echo "<center>ยังไม่ครบ $min นาที ยังไม่ทำการเพิ่มสถิติ</center>";  
} else {
	//echo "(($passsec<($mins) || $lastlog>time()) && $mins != 0) ";
	stathist_add("ms_member_ip",$useradminidxUSE,$IPADDR);	
	stathist_add("ms_member_gate",$useradminidxUSE,$use);	
	stathist_add("ms_member_ms",$useradminidxUSE,sessionval_get("msrunningsub"));	
	statordr_add("ms_member",$useradminidxUSE);	
	stat_add("ms_membertype",$membertype);
	//echo "adsf".sessionval_get("msrunningsub");
	stat_add("ms_gatecode",sessionval_get("msrunningsub"));
	stat_add("ms_byhrs",date("G"));
	$now=time();
	tmq("update member set lastlogin='$now' where $fieldcode='$useradminidx'");
}
 $sql2 ="select * from library where UserAdminID='$lib'";
//echo ($sql2);
$result2 = tmq($sql2);
$row2 = tmq_fetch_array($result2);   
  $libname=$row2[UserAdminName]; 
  echo "<meta http-equiv=refresh content='20;url=body.php?gateid=$gateid'>";

					
					member_showlonginfo($useradminidxUSE,"forms");
					//member_showinfo($useradminidx);
	
					member_showhold($useradminidxUSE);
					member_showfine($useradminidxUSE);
					member_showrequest($useradminidxUSE);
					member_showrequestlist($useradminidxUSE);
$audio="";
/*
echo "member_showrequest_isreadypickup=$member_showrequest_isreadypickup;<BR>
member_showfine_ishasfine=$member_showfine_ishasfine<BR>
member_showhold_isoverdue=$member_showhold_isoverdue<BR>
member_showhold_isreturntoday=$member_showhold_isreturntoday<BR>
member_showhold_isreturntomorrow=$member_showhold_isreturntomorrow<BR>";*/
if ($member_showrequest_isreadypickup=="yes") {			
   if ($member_showfine_ishasfine=="yes") {
      if ($member_showhold_isoverdue=="yes") {
         $audio="readypickup-fine-overdue";
      } else {
         if ($member_showhold_isreturntoday=="yes") {
            $audio="readypickup-fine-returntoday";
         } else {
            if ($member_showhold_isreturntomorrow=="yes") {
               $audio="readypickup-fine-returntomorrow";
            } else {
               $audio="readypickup-fine";
            }
         }
      }
   } else {
      if ($member_showhold_isreturntoday=="yes") {
         $audio="readypickup-returntoday";
      } else {
         if ($member_showhold_isreturntomorrow=="yes") {
            $audio="readypickup-returntomorrow";
         } else {
            $audio="readypickup";
         }
      }
   }
} else {
   if ($member_showfine_ishasfine=="yes") {
      if ($member_showhold_isoverdue=="yes") {
         $audio="fine-overdue";
      } else {
         if ($member_showhold_isreturntoday=="yes") {
            $audio="fine-returntoday";
         } else {
            if ($member_showhold_isreturntomorrow=="yes") {
               $audio="fine-returntomorrow";
            } else {
               $audio="fine";
            }
         }
      }
   } else {
      if ($member_showhold_isoverdue=="yes") {
         $audio="overdue";
      } else {
         if ($member_showhold_isreturntoday=="yes") {
            $audio="returntoday";
         } else {
            if ($member_showhold_isreturntomorrow=="yes") {
               $audio="returntomorrow";
            } else {
               $audio="";
            }
         }
      }
   }
}
///////////
   if ($audio!="") {
   ?><audio controls  style="display:none" id="welcomeaudioID2">
   <source src="<?php echo $audio?>.mp3" type="audio/mp3">
   </audio>
<script>

var aud = getobj("welcomeaudioID");
//alert(aud);
if (aud!=undefined && aud!=null) {
   aud.onended = function() {
      var aud2 = getobj("welcomeaudioID2");
      aud2.play();
      //alert("The audio has ended");
   };
} else {
   var aud2 = getobj("welcomeaudioID2");
   aud2.play();
}
</script>
<?php
   }
?><?php ?><?php //echo $audio?>