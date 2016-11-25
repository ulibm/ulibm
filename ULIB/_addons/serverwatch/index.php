<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("info.php");


$now=time();

if ($refresh=="true") {
   $outstr="";
   $outstr.="<table width=1000 align=center><tr><td>";
   $s=tmq("select * from addonsdb_serverwatch");
   while ($r=tfa($s)) {
      $url=$r[url];
      $url=str_replace("[dcr]",$dcrURL,$url);
      /////////////////////
      $ch = curl_init($url); // get cURL handle
      $opts = array(CURLOPT_RETURNTRANSFER => true, // do not output to browser
      CURLOPT_URL => $url,            // set URL
      //CURLOPT_NOBODY => true,                 // do a HEAD request only
      CURLOPT_TIMEOUT => 45);   // set timeout
      curl_setopt_array($ch, $opts); 

      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html')); 
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
      curl_setopt($ch, CURLOPT_TIMEOUT, 50); //timeout in seconds
      $dat=curl_exec($ch); // do it!
      $datorig=$dat;
      $retval = curl_getinfo($ch, CURLINFO_HTTP_CODE) ; // check if HTTP OK
         $outstr.="<table border=1
      width='$_TBWIDTH' align=center ";
      if ($retval=="200") {
         $outstr.=" bgcolor=#D2FFD5  ";
      }
      $outstr.="><tr><td>";
      $outstr.= "<b style='font-size: 18px; color: darkblue'>".stripslashes($r[name])."</b><BR>";
      $outstr.= "<font>$url</font><BR>";
      $outstr.= "<b style=' color: darkblue' class=smaller>Start</b><BR>";

      $outstr.=("[HTTP Code=$retval] ");
      if ($retval=="") {
         $retval="000";
      }
      if ("$retval"=="200") {
         $outstr.= "OK";
      }
      if ("$retval"=="404") {
         $outstr.= "Not found!";
      }
      if ("$retval"=="500") {
         $outstr.= "Server Error!";
      }
      //if ("$retval"=="200") {
      $dat=unserialize($dat);
      ///if 200, stage 2
      
      $outstr.= "<BR><font class=smaller>".$dat["server_software"]."</font>";
     if (is_array($dat[Disks])) {
      $outstr.= "<BR>Disks: ".$dat[Disks][SUM]."% free<BR>";
      @reset($dat[Disks]);
      while (list($k,$v)=each($dat[Disks])) {
         $total=($v[total]);
         $free=($v[free]);
         if ($total=="") { $total="-";}
         if ($free=="") { $free="-";}
         $outstr.= " <font class=smaller2><b style='color:#555555'>".$v[name]."</b> ".$free."/".$total."</font>";
      }
     }
     $outstr.= "<BR><b>Current CPU</b>:".$dat[CPU]."%";;
         //printr($dat);
      //echo $dat;

      ///if 200 e
      //}
      if (is_array($dat) && is_array($dat[Processes])) {
         $outstr.= "<BR>Processes: <a href='javascript:void(null);'
         onclick=\"tmp=getobj('proc".$r[id]."'); tmp.style.display='block';\">
         ".@count($dat[Processes])."</a><BR>";
         @reset($dat[Processes]);
         $outstr.= "<div style='display:none' ID='proc".$r[id]."'>";
         while (list($k,$v)=each($dat[Processes])) {
            $outstr.= $v." ";
         }
         $outstr.= "</div>";
      }

      $outstr.= "<BR>";
      curl_close($ch); // close handle
       $outstr.="</td></tr></table>";
      /////////////////////
      tmq("insert into addonsdb_serverwatch_log set
      pid='$r[id]',
      dt='$now',
      hcode='$retval',
      dat='".date("d")."',
      mon='".date("m")."',
      yea='".date("Y")."',
      cache='".addslashes($datorig)."'
      ");
      
   }
   $outstr.="</td></tr></table>";
   if (loginchk_lib("chk")==false) {
    //head();
      die("refresh done");
      //foot();
   }   
      head();
   include("../chkpermission.php");
   include("../menu.php");
   include("func.php");

   echo $outstr;
} else {
   head();
   include("../chkpermission.php");
   include("../menu.php");
   include("func.php");
pagesection(getlang("Server Status"));

//int
html_dialog("Module Server Status","โมดูลนี้ช่วยแสดงรายละเอียดของเซิร์ฟเวอร์ได้ โดยต้องนำไฟล์ php (ซึ่งดาวน์โหลดได้จากด้านล่างของเพจนี้) ไปไว้บนเซิร์ฟเวอร์ที่ต้องการดูรายละเอียด และเพิ่ม URL ที่จะเข้าถึง URL ดังกล่าวมากรอกลงด้วย");
}
$tbname="addonsdb_serverwatch";


$c[1][text]="ชื่อเรียก::l::Name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="URL";
$c[2][field]="url";
$c[2][fieldtype]="text";
$c[2][descr]="<BR>URL ของไฟล์ php ที่นำไปวางไว้บนเซิร์ฟเวอร์นั้น";
$c[2][defval]="";

//dsp

$dsp[1][text]="ชื่อเรียก::l::Name";
$dsp[1][field]="name";
$dsp[1][width]="40%";

$dsp[2][text]="URL";
$dsp[2][field]="url";
$dsp[2][width]="60%";

?><center>

<a href="index.php?refresh=true" class=a_btn>Refresh</a>
 <a href="stat.php" class=a_btn>Stat</a>
 <a href="statsv.php" class=a_btn>Stat-SV</a>

</center><?php
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);
?><center><a href="serverwatch.cli.zip" class='smaller a_btn'>Download Script</a></center><?php
html_dialog("","<font class=smaller>Url for ping <BR>
$dcrURL"."_addons/serverwatch/index.php?refresh=true</font>");
foot();
?>