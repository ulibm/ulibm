<?php 
@error_reporting( E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
//@error_reporting( E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
//@error_reporting( E_ALL  & ~E_WARNING );
@ini_set( "display_errors", false );
@setlocale(LC_TIME, 'th_TH.UTF8'); 
//@setlocale(LC_TIME, 'th_TH'); 
@date_default_timezone_set('Asia/Bangkok');
@ini_set('precision',30);

//include("../../inc/config.inc.php");
//include("info.php");
//head();
//include("../chkpermission.php");
//include("../menu.php");
//include("func.php");

function explodenewline($wh) { 
	$wh=str_replace("
",chr(13),$wh); 
	$wh=str_replace("\r\n",chr(13),$wh); 
	$wh=str_replace("\n",chr(13),$wh); 
	//$wh=str_replace("\t",chr(13),$wh); 
	$wh=str_replace("\r",chr(13),$wh); 
	//$wh=str_replace("\t",chr(13),$wh); 
	/*
	$wh=str_replace(chr(13),"
	",$wh); 
	$wh=str_replace(chr(10),"
	",$wh); 
	for ($i=1;$i<strlen($wh);$i++) {
		echo substr($wh,$i,1)."=".ord(substr($wh,$i,1))."<BR>";
	}
	*/
	$wh=explode(chr(13),$wh);
	//printr($wh);
	return $wh; 
} 

function local_get_proc() {
   $boldprocess=explode(",","mysqld_usbwv8.exe,httpd_usbwv8.exe,mysqld,httpd,httpd.exe,mysqld.exe,mysqld_safe");
   if(php_uname('s')=='Windows NT'){ 
      $data=`tasklist`; 
      $data=explodenewline($data);
      @reset($data);
      $tmpa=Array();
      while (list($k,$v)=each($data)) {
         $v=str_replace("\t"," ",$v);
         if ($v=="") continue;
         $v=explode("\t",$v);
         if (substr($v[0],0,1)=="=") continue;
         $bs="";$be="";
         if (in_array($v[0],$boldprocess)) {
            $bs="<b class=smaller style='color:darkgreen;'>";
            $be="</b>";
         }
         $tmpa[]=$bs.$v[0].$be;
      }
      return $tmpa;
      //echo $data;
   } else {//linux
      $data=`ps -A`; 
      $data=explodenewline($data);
      //print_r($data);
      @reset($data);
      $tmpa=Array();
      while (list($k,$v)=each($data)) {
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace("  "," ",$v);
         $v=str_replace(" ","\t",$v);
         $v=str_replace(" ","\t",$v);
         $v=trim($v);
         if ($v=="") { continue; }
         $v=explode("\t",$v); //print_r($v); 
         $vuse=$v[count($v)-1];
         if (substr($vuse,0,1)=="=") continue;
         $bs="";$be="";
         if (in_array($vuse,$boldprocess)) {
            $bs="<b class=smaller style='color:darkgreen;'>";
            $be="</b>";
         }
         $tmpa[]=$bs.$vuse.$be;
      }
      return $tmpa;
   }

}

function local_size($size) 
{ 
if (!is_numeric($size)) { 
   return FALSE; 
} else { 
   if ($size >= 1073741824) {
      $size = round(round($size/1073741824*100)/100) ."GB";; //
   } elseif ($size >= 1048576) {
      $size =round( round($size/1048576*100)/100) ."MB"; //
   } elseif ($size >= 1024) {
      $size = round(round($size/1024*100)/100) ."KB";
   } else {
      $size = $size."B";
   } 

return $size; 
}
}


function local_get_disks(){ 
    if(php_uname('s')=='Windows NT'){ 
        // windows 
        $disks=`fsutil fsinfo drives`; 
        $disks=str_word_count($disks,1); 
        if($disks[0]!='Drives') { 
         return ''; 
        }
        unset($disks[0]); 
        $allfree=0;
        $allspace=0;
        foreach($disks as $key=>$disk) {
         $disks[$key]=Array();
         $disks[$key][name]=$disk.':\\'; 
         $disks[$key][free]=local_size(@disk_free_space($disk.':\\'));
         $allfree=$allfree+floor(@disk_free_space($disk.':\\'));
         $allspace=$allspace+floor(@disk_total_space($disk.':\\'));
         $disks[$key][total]=local_size(@disk_total_space($disk.':\\'));
        }
        //echo "[$allfree]";
        $disks[SUM]=floor(($allfree*100)/$allspace);

        return $disks; 
    }else{ 
        // unix 
        $data=`mount`; 
        $data=explode("\n",$data); 
        $disks=array(); 
        //print_r($data);
        $allfree=0;
        $allspace=0;
        while (list($k,$v)=each($data)) {
         //echo substr($v,0,1);
         if ($v=="" || substr($v,0,1)!='/') {
          continue;
         }
         //echo "$k,$v<BR>";
         // if(true || substr($token,0,5)=='/dev/') {
            $va=explode(" ",$v);
            $disks[$k]=Array();
            $token=$va[0];
            $disks[$k][name]=$token; 
            $disks[$k][free]=local_size(@disk_free_space($token.''));
            $disks[$k][total]=local_size(@disk_total_space($token.''));
            $allfree=$allfree+floor(@disk_free_space($token.''));
            $allspace=$allspace+floor(@disk_total_space($token.''));

            //$disks[]=$token;                 
          //}disk                                     
         }
         $disks[SUM]=floor(($allfree*100)/$allspace);
        return $disks; 
    }
}

function local_get_cpu() {
   if (function_exists("sys_getloadavg")) {
      $load = sys_getloadavg();
      return $load[0];
   } else {
      $data=`wmic cpu get loadpercentage`; 
      $data=explode("\n",$data); 
      while (list($k,$v)=each($data)) {
         if (floor($v)!=0) {
            return floor($v);
         }
      }
   }
   return "-";
}

$now=time();
$res=Array();
$res[server_software]=$_SERVER[SERVER_SOFTWARE];
$res[Disks]=local_get_disks();
@reset($res[Disks]);



$res[CPU]=local_get_cpu();
$res[CPU]=round($res[CPU]);

$res[Processes]=local_get_proc();

//echo "here";
//echo "<PRE>";
$dat=serialize($res);
echo $dat;
print_r($res);
?>