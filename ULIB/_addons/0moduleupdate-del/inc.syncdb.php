<?php


if ($step=="") {
   $step="1pingsv";
}  
$uorig=barcodeval_get("addonssetting_libfullupgrade_url");
$u=barcodeval_get("addonssetting_libfullupgrade_url");
$u=trim($u);
$u=rtrim($u,"/ ");
if ($u=="") {
   die("source URL is empty");
}
$u=$u."/_addons/00ulibfullupgrade/sv/sv.php?cmd=";
//echo $u;
	?><center><?php
   if ($step=="1pingsv") {
      $tmp=file_get_contents($u."1ping");
      //echo $tmp;
      if ($tmp!="pingresponse") {
      html_dialog("error","ping incomplete, server response=[$tmp]");
      die;
      } else {
      html_dialog("ok","ping complete");
      }
      ?><a href="index.php?mode=syncdb&step=2syncdb" class=a_btn><?php echo getlang("Next");?></a><?php
      foot();
      die;
   }
   ////////////////////////////////////////////////////////////////////////////////////////////////////////
   if ($step=="2syncdb") {
      $tmp=file_get_contents($u."2pulldbstruct");
echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($tmp);
   $morphdata=unserialize($morphdata);
   if (!is_array($morphdata)) {
      html_dialog("","Invalid data , could not unserialize");
   } else {
   //printr($t);
      @reset($morphdata);
      while (list($k,$v)=each($morphdata)) {
         echo "<b style='color: darkred;'>$k</b><BR>";
         if (in_array($k,$t)) {
            echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields:existed";
         } else {
            echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields:not existed, creating..";
            //$tbstruct=
            $v[FULLCREATE]=rtrim($v[FULLCREATE],"%#\n ");
            tmq($v[FULLCREATE]);
         }
         echo "<BR> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields:";
         
        $result=tmq( "SHOW FIELDS FROM $k");
        $thistbhavef=Array();
        while ($row=tmq_fetch_array($result)) {
          $thistbhavef[]=$row[Field];
        }
        //printr($thistbhavef);
         while (list($k2,$v2)=each($v)) {
            if ($k2=="FULLCREATE") continue;
            if (in_array($k2,$thistbhavef)) {
               echo "<font style='color:darkgreen'>&bull;$k2</font>  ";
            } else {
               echo "<font style='color:red'>&bull;$k2 ..creating</font>  ";
               tmq("alter table $k add ".$v2);
            }
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
         ?><a href="index.php?mode=syncdb&step=3syncval" class=a_btn><?php echo getlang("Next");?></a><?php
      foot();
      die;

   
   }
      ////////////////////////////////////////////////////////////////////////////////////////////////////////
   if ($step=="3syncval") {
   $tmp=file_get_contents($u."3pulldbval");
   //echo $tmp;
      echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($tmp);
   $morphdata=unserialize($morphdata);
   if (!is_array($morphdata)) {
      html_dialog("","Invalid data , could not unserialize");
   } else {
   //printr($t);
   //printr($morphdata); die;
      @reset($morphdata);
      while (list($k,$v)=each($morphdata)) {
         echo "<b style='color: darkred;'>$k</b><BR>";
         echo "<BR> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checking record(s):<BR>";
         $tmpc=$v[data];
         @reset($tmpc);
         while (list($k2,$v2)=each($tmpc)) {
            $k2dsp=str_replace("___",",",$k2);
            $chk=tmq("select id from $k where ".stripslashes($v2[limit]));
            if (tnr($chk)==1) {
               echo "[<font color=darkgreen>$k2dsp</font>] ";
            } else {
            $v2[data]=rtrim($v2[data],"%#\n ");

               echo "[<font color=red>$k2dsp</font>] ";
               tmq("insert into $k set ".stripslashes($v2[data]));
            }
            //$
         }
         echo "<BR><BR>";
      }
   }
   barcodeval_set("addonssetting_libfullupgrade_url",$uorig);

   echo "</td></tr></table>";
            ?><a href="index.php?mode=syncdb&step=3syncforceval" class=a_btn><?php echo getlang("Next");?></a><?php
      foot();
      die;

   }
         ////////////////////////////////////////////////////////////////////////////////////////////////////////
   if ($step=="3syncforceval") {
   $morphdata=file_get_contents($u."3syncforceval"); //echo ($u."3syncforceval");
   echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($morphdata);
   $morphdata=unserialize($morphdata);
   if (!is_array($morphdata)) {
      html_dialog("","Invalid data , could not unserialize");
   } else {
   //printr($t);
   //printr($morphdata); die;
      @reset($morphdata);
      while (list($k,$v)=each($morphdata)) {
         echo "<b style='color: darkred;'>$k</b><BR>";
         echo "<BR> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checking record(s):<BR>";
         $tmpc=$v[data];
         @reset($tmpc);
         while (list($k2,$v2)=each($tmpc)) {
            $k2dsp=str_replace("___",",",$k2);
            $v2[data]=rtrim($v2[data],"%#;\n ");
            ////////////////////create if not exists
            $chk=tmq("select id from $k where ".stripslashes($v2[limit]));
            if (tnr($chk)==1) {
               echo "[<font color=darkgreen>$k2dsp</font>] ";
            } else {
               echo "[<font color=red>$k2dsp</font>] ";
               //tmq("insert into $k set ".stripslashes($v2[data]));
            }
            ////////////////////update val
           // die("update $k set ".stripslashes($v2[data])." where ".stripslashes($v2[limit]));
            tmq("update $k set ".stripslashes($v2[data])." where ".stripslashes($v2[limit]),false);
            //$
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
   barcodeval_set("addonssetting_libfullupgrade_url",$uorig);

   echo "</td></tr></table>";
            ?><a href="index.php?mode=syncdb&step=4getfilelist" class=a_btn><?php echo getlang("Next");?></a><?php
      foot();
      die;

   }
   ////////////////////////////////////////////////////////////////////////////////////////////////////////
   if ($step=="4getfilelist") {
      $tmp=file_get_contents($u."4getfilelist");
      $tmporig=$tmp;
      $tmp=base64_decode($tmp);
      $tmp=unserialize($tmp);
      if (!is_array($tmp) || count($tmp)<50) {
         die("not array- data error");
      }
      barcodeval_set("addonssetting_libfullupgrade_struct",$tmporig);
      echo "File Structure to update : ".count($tmp);;
      //print_r($tmp);
      //echo $tmp;
               ?><BR><a href="index.php?mode=folderupdate&step=5runfolderupdate" class=a_btn><?php echo getlang("Next");?></a><BR><BR><BR><BR><BR><BR><?php
         html_dialog("คำแนะนำ::l::Suggestion",getlang("ปรับโครงสร้างฐานข้อมูลสมบูรณ์<BR><BR>หากคุณใช้โมดูลนี้เพื่อปรับปรุงฐานข้อมูลเท่านั้น สามารถ<a href='../../library'>กลับไปยังเมนูหลัก</a>ได้ทันที ::l::Database Updated<BR><BR>If you are using this module just to update database structure, you can <a href='../../library'>go back to main menu</a> now."));
      foot();
      die;
   }
      ////////////////////////////////////////////////////////////////////////////////////////////////////////

   ?>
   <BR><BR><a href=index.php class=a_btn><?php echo getlang("กลับ::l::Back");?></a>
   </center><?php 

foot();
die;
?>