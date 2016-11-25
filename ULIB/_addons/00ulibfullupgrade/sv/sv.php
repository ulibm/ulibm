<?php
set_time_limit(0);
include("../../../inc/config.inc.php");
include("archive.php");
include("local_archiveit.php");
if ($cmd=="") {
   die("cmd empty");
}

//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="1ping") {
   die("pingresponse");
}
//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="2pulldbstruct") {
   $tblist=tmq("show tables");
$t=Array();
while ($r=tmq_fetch_array($tblist)) {
	$t[]=$r[0];
}

$res=Array();
   @reset($t);
   while (list($k,$v)=each($t)) {
      $res[$v]=Array();
      $result=tmq( "SHOW FIELDS FROM $v");
      while ($row=tmq_fetch_array($result)) {
         $def = "    `$row[Field]` $row[Type]";
         if ($row["Default"] != "")
            $def.=" DEFAULT '$row[Default]'";
         if ($row["Null"] != "YES")
            $def.=" NOT NULL";
         if ($row[Extra] != "")
            $def.=" $row[Extra]";
         $res[$v][$row[Field]]=$def;
      }
      $res[$v][FULLCREATE]=get_def($dbname,$v,"NO");
   }

//printr($res);
echo base64_encode(serialize($res));
die;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="3pulldbval") {
	$ttmp=explode(",","val=main-sub,library_modules=code,library_modules_cate=code,library_modules_topcate=code,libsite_bibmodules=code,libsite_modules=code,media_mid_status=code,barcode_val=classid,index_ctrl=code,webbox_boxtype=classid,webbox_topmenu_type=code,webmobile_menu_type=code,webpage_wiki_status=code,memcard_itype=code,memcard_var=code,webbox_tabs_type=code");;

$res=Array();
$t=$ttmp;
   @reset($t);
   while (list($k,$v)=each($t)) {
      $v2=explode("=",$v); //printr($v2);
      $table=$v2[0];
      $tbkeys=$v2[1];
      $tbkeysa=explode("-",$tbkeys);
      $res[$table]=Array();
      $res[$table][control]=Array();
      $res[$table][control]=$tbkeys;
      $res[$table][data]=Array();
      $resultm=tmq( "sElect * FROM $table");
      while ($row=tmq_fetch_array($resultm)) {
         $rowkey="";
         @reset($tbkeysa);
         $limitsql="";
         while (list($ktbkeysa,$vtbkeysa)=each($tbkeysa)) {
            $rowkey=$rowkey."____".$vtbkeysa."=".$row[$vtbkeysa];
            $limitsql.="$vtbkeysa='$row[$vtbkeysa]' and ";
         }
         $rowkey=ltrim($rowkey,"_");
         $limitsql=rtrim($limitsql,"and ");
         $res[$table][data][$rowkey]=Array();
         //getcontents
            $sql = "SHOW columns FROM $table";
            $result = tmq($sql);
            $my_col=Array();
            while ($r=tmq_fetch_array($result)) {
               $my_col[]=$r[0];
            }
            $insert = "";
                  for ($j=0; $j < tmq_num_fields($resultm); $j++) {
                  if ($my_col[$j]=="id") continue;
                  $insert.="$my_col[$j]=";
                  if (!isset($row[$j]))
                     $insert.="NULL,";
                  else if ($row[$j] != "") {
                     if ($destencode=="th") {
                        $row[$j]=iconvth($row[$j]);
                     }
                     if ($destencode=="utf") {
                        $row[$j]=iconvutf($row[$j]);
                     }
                     $insert.="'" . addslashes(addslashes($row[$j])) . "',";
                  } else {
                     $insert.="'',";
                     }
                  }
                  // $insert=str_replace(",$", "", $insert);
                  //$insert=str_replace(",\n", "", $insert);
                  $insert=rtrim($insert);
                  $insert=rtrim($insert,",");

                  $insert.=";#%%\n";
          //getcontents e
            $res[$table][data][$rowkey][data]=$insert;
            $res[$table][data][$rowkey][limit]=$limitsql;
      }
      //$res[$v][FULLCREATE]=get_def($dbname,$v,"NO");
   }
//printr($res);
echo base64_encode(serialize($res));
die;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="3syncforceval") {
	$ttmp=explode(",","val=main-sub=descr,library_modules=code=name-url-nested-ordr-isshow-isbold,library_modules_cate=code=name-url-isplayathead-topcate,library_modules_topcate=code=name,libsite_bibmodules=code=name,libsite_modules=code=name,webbox_boxtype=classid=name,webbox_topmenu_type=code=name,webmobile_menu_type=code=name,webpage_wiki_status=code=descr-name,webbox_tabs_type=code=name");;

   $t=$ttmp;
   @reset($t);
   while (list($k,$v)=each($t)) {
      $v2=explode("=",$v);//printr($v2);
      $table=$v2[0];
      $tbkeys=$v2[1];
      $tbonlyfields=$v2[2];
      $tbonlyfields=trim($tbonlyfields);
      $tbonlyfields=explode("-",$tbonlyfields); //printr($tbonlyfields);
      $tbonlyfieldsa=$tbonlyfields;
      $tbonlyfields=implode("','",$tbonlyfields);
      $tbonlyfields="'".$tbonlyfields."'";
      //echo "[$tbonlyfields]";
      $tbkeysa=explode("-",$tbkeys);
      $res[$table]=Array();
      $res[$table][control]=Array();
      $res[$table][control]=$tbkeys;
      $res[$table][data]=Array();
      $resultm=tmq( "select * FROM $table");
      while ($row=tmq_fetch_array($resultm)) {
         $rowkey="";
         @reset($tbkeysa);
         $limitsql="";
         while (list($ktbkeysa,$vtbkeysa)=each($tbkeysa)) {
            $rowkey=$rowkey."____".$vtbkeysa."=".$row[$vtbkeysa];
            $limitsql.="$vtbkeysa='$row[$vtbkeysa]' and ";
         }
         $rowkey=ltrim($rowkey,"_");
         $limitsql=rtrim($limitsql,"and ");
         $res[$table][data][$rowkey]=Array();
         //getcontents
            $sql = "SHOW columns FROM $table";

            //die("[$sql]");
            $result = tmq($sql);
            $my_col=Array();
            while ($r=tmq_fetch_array($result)) {
               $my_col[]=$r[0];
            } //printr($my_col); 
            $insert = "";
                  for ($j=0; $j < tmq_num_fields($resultm); $j++) {
                     if ($my_col[$j]=="id") continue;
                     if ($tbonlyfields!="" && !in_array($my_col[$j],$tbonlyfieldsa)) continue;
                     //echo "$j=".$my_col[$j]."<BR>";

                     $insert.="$my_col[$j]=";
                     if (!isset($row[$j]))
                        $insert.="NULL,";
                     else if ($row[$j] != "") {
                        if ($destencode=="th") {
                           $row[$j]=iconvth($row[$j]);
                        }
                        if ($destencode=="utf") {
                           $row[$j]=iconvutf($row[$j]);
                        }
                        $insert.="'" . addslashes(addslashes($row[$j])) . "',";
                     } else {
                        $insert.="'',";
                     }
                  }
                  // $insert=str_replace(",$", "", $insert);
                  //$insert=str_replace(",\n", "", $insert);
                  $insert=rtrim($insert);
                  $insert=rtrim($insert,",");

                  $insert.=";#%%\n";
          //getcontents e
            $res[$table][data][$rowkey][data]=$insert;
            $res[$table][data][$rowkey][limit]=$limitsql;
      }
      //$res[$v][FULLCREATE]=get_def($dbname,$v,"NO");
   }
echo base64_encode(serialize($res));
die;
}
//////////////////////////////////////////////////////////////////////////////////////////////

if ($cmd=="4getfilelist") {
   $res=Array();
   function listFolderFiles($dir){
   global $res;
    $ffs = scandir($dir);
    $res[]="".$dir;
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'
        && $ff != 'c.inc.php'
        && $ff != 'config.inc.sv.php'
        && $ff != 'backup-full.sql'
        && $ff != 'backup-full.gz'
        && $ff != '_logs'
        && $ff != '_fulltext'
        && $ff != '_pdftemp'
        && $ff != '_globalupload'
        && $ff != 'pic'
        && $ff != '_input'
        && $ff != 'graphtemp'
        && $ff != '_cache'
        && $ff != '_bctemp'
        && $ff != '_media'
        && $ff != '_output'
        && $ff != '_import'
        && $ff != '_files'
        && $ff != '_addons'
        ){ //&& $ff != '.htaccess'
            if(is_dir($dir.'/'.$ff)) {
               listFolderFiles($dir.'/'.$ff);
            } /*else {
               $ext=strtolower(substr($ff,-4)); 
               if ($ext==".psd") continue;
               if ($ext==".exe") continue;
               if ($ext==".zip") continue;
               if ($ext==".tmp") continue;
               if ($ext==".tgz") continue;
               if ($ext=="s.db") continue;
               //$res[]=$dir."/".$ff;
            }*/
        }
    }
}

listFolderFiles(rtrim($dcrs,"/ "));
@reset($res);
$i=0;
while (list($k,$v)=each($res)) {
   $i=$i+1;
   if (substr($v,0,strlen($dcrs))==$dcrs) {
      $res[$k]=substr($v,strlen($dcrs));
   }/*
   if (substr($v,0,4)=="dir:") {
      if (substr($v,0,strlen($dcrs)+4)=="dir:".$dcrs) {
        $res[$k]="dir:".substr($v,strlen($dcrs)+4);
      }
   }*/
   //remove root
   if ($v=="".rtrim($dcrs," /")) {
      $res[$k]="[ROOT]";
   }
   //if ($i>100) { printr($res); die; }
}
//printr($res);
echo base64_encode(serialize($res));
   die;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="genfolder") {
   $fd=base64_decode($fd);
   if ($fd=="[ROOT]") {
      $ddest=rtrim($dcrs," /");
   } else {
      $ddest=$dcrs."$fd";
   }
   if (!file_exists($ddest)) {
      die("$ddest not exists");
   }
   if (!is_dir($ddest)) {
      die("$ddest not directory");
   }
   $tmp=local_archiveit("$ddest");
   echo "ok:".$tmp.":eou";


   die;
}
 ?>unknown command, eof