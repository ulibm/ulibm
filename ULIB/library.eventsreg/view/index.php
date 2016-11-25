<?php 
include("../../inc/config.inc.php");
head();

mn_web("webpage");

$id=floor($id);

function localerror($str) {
   global $_TBWIDTH;
   echo "<table align=center width=$_TBWIDTH style='background-color: darkred;'><tr><td style='color: white; font-weight: bold; font-size: 18px;' align=center>$str</td></tr></table>";
}
if ($id==0) {
   html_dialog("","Invalid Event or expired");
   foot();
   die;
}

$s=tmq("select * from eventsreg where id='$id' ");
$ss=tfa($s);
if (trim($ss[name])=="") {
   html_dialog("","Invalid Event or expired.");
   foot();
   die;
}
$error="no";
if ($savereg=="yes") {
   //printr($_POST);
   @reset($regfid);
   while (list($k,$v)=each($regfid)) {
      if (trim($v)=="") {
         $error="yes";
         $tmp=tmq("select * from eventsreg_memfid where id='$k' ");
         $tmp=tfa($tmp); //printr($tmp);
         localerror("กรุณากรอก [$tmp[txt]]");
      }
   }
   if (count($regesub)==0 && $skipsubevent=="no") {
      $error="yes";
      localerror("กรุณาเลือกระบุกิจกรรมที่ต้องการเข้าร่วม");
   }
   $esub=tmq("select * from eventsreg_requests where pid=$id order by ordr");
   while ($esubr=tfa($esub)) {
      if (floor($regreq[$esubr[id]])==0) {
         $error="yes";
         localerror("กรุณาเลือก [$esubr[name]]");
      }
   }
   
   if ($error=="no") {
      if (!is_array($regreq)) {
         $regreq=Array();
      }
      if (!is_array($regesub)) {
         $regesub=Array();
      }
      $now=time();
      $reqdata=",".implode(",,",$regreq).",,";
      $subdata=",".implode(",,", array_keys($regesub)).",,";
      $sql="insert into  eventsreg_reg set
         pid=$id,
         dt=$now,
         fid1='".addslashes($regfid[1])."',
         fid2='".addslashes($regfid[2])."',
         fid3='".addslashes($regfid[3])."',
         fid4='".addslashes($regfid[4])."',
         fid5='".addslashes($regfid[5])."',
         fid6='".addslashes($regfid[6])."',
         fid7='".addslashes($regfid[7])."',
         fid8='".addslashes($regfid[8])."',
         fid9='".addslashes($regfid[9])."',
         fid10='".addslashes($regfid[10])."',
         reqdata='$reqdata',
         subdata='$subdata'
         
         ";
         //echo $sql;
         tmq($sql,false);
      ?><script> alert("ทำการบันทึกคำขอการร่วมกิจกรรมเรียบร้อยแล้ว กรุณารอเจ้าหน้าที่ยืนยัน"); </script><?php
      redir("index.php?id=$id");
      die;
   }
}
?><table align=center width="<?php  echo $_TBWIDTH;?>"><tr><td>
<center><b><?php echo stripslashes($ss[name]);?></b><br>
<?php echo stripslashes(str_webpagereplacer($ss[descr]))?></center>

<?php echo stripslashes(str_webpagereplacer($ss[bodys]))?>

<?php 
//can regist?
$now=time();
$chk=tmq("select * from eventsreg_reg where pid=$id and lower(isallowed)='yes' ");
if (floor($ss[maxreg])!=0 && tnr($chk)>=$ss[maxreg] ) {
   html_dialog("เต็มจำนวนแล้ว","ไม่สามารถลงชื่อร่วมกิจกรรมได้ เนื่องจากผู้ร่วมกิจกรรมเกินจำนวนแล้ว");
} elseif ($now>$ss[dte] || $now<$ss[dts]) {
   html_dialog("ไม่สามารถร่วมกิจกรรม","ไม่สามารถลงชื่อร่วมกิจกรรมได้ ไม่อยู่ในช่วงเวลาที่เปิดให้ลงทะเบียน<BR>".ymd_datestr($ss[dts]). " - ".ymd_datestr($ss[dte]));
} else {
   //regform
   html_dialog("ลงทะเบียนร่วมกิจกรรม","ลงทะเบียนร่วมกิจกรรมด้วยแบบฟอร์มด้านล่าง<BR>* กรุณากรอกทุกช่อง");
   ?>
   <form method=post action="index.php">
   <input type=hidden name=savereg value='yes'>
   <input type=hidden name=id value='<?php echo $id;?>'>
   <table align=center width="<?php  echo $_TBWIDTH-50;?>" class=table_border>
   <?php
   for ($i=1; $i<=10; $i++) {
      $fid=tmq("select * from eventsreg_memfid where pid=$id and code=$i"); 
      $fidr=tfa($fid);
      //printr($fidr);
      if (strtolower($fidr[isshow])!="yes") { continue; }
   ?>
   <tr><td width=30% class=table_td>
      <?php echo stripslashes($fidr[txt]);?>
   </td><td class=table_td>
      <?php form_quickedit("regfid[$i]",$regfid["$i"],$fidr[type1]);?>
   </td></tr>
   <?php 
   }
   
   /////////event sub
   $esub=tmq("select * from eventsreg_sub where pid=$id order by ordr");
   if (tnr($esub)==0) {
      ?>   <input type=hidden name=skipsubevent value='yes'><?php
   } else {
      ?>   <input type=hidden name=skipsubevent value='no'>
         <tr><td width=30% class=table_td>
      กรุณาเลือกกิจกรรมที่ต้องการเข้าร่วม
   </td><td class=table_td>
      <?php 
      while ($esubr=tfa($esub)) {
         echo "<label>";
         $slstate="";
         if ($regesub[$esubr[id]]!="") {
            $slstate=" selected checked ";
         }
         echo "<input type=checkbox name='regesub[$esubr[id]]' value='yes' $slstate > ";
        // form_quickedit("esub[$i][$esubr[id]]",$_POST["esub$i"],"checkbox");
         echo stripslashes($esubr[name]);
         echo "</label>";
         echo "<BR>";
         if (trim($esubr[detail])) {
            echo "<font class=smaller>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".stripslashes($esubr[detail]);
            echo "<BR></font>";
         }
      }?>
   </td></tr>
   
      <?php
   }

   /////////requests sub
   $esub=tmq("select * from eventsreg_requests where pid=$id order by ordr");
   if (tnr($esub)==0) {
      //norequests
   } else {
      

      while ($esubr=tfa($esub)) {
      ?>
         <tr><td width=30% class=table_td>
      <?php echo stripslashes($esubr[name]);?>
   </td><td class=table_td>
      <?php 
      $req=tmq("select * from eventsreg_requests_sub where pid='$esubr[id]' order by ordr");
      $i=0;
      while ($reqr=tfa($req)) {//and lower(isallowed)='yesฝฝ'
         $chkava=tmq("select * from eventsreg_reg where reqdata like '%,$reqr[id],%'  ",false);
         $disabled="no";
         if (strtolower($reqr[openreg])!="yes" || (floor($reqr[limitpart])!=0 && tnr($chkava)>=floor($reqr[limitpart]))) {
            $disabled="yes";
         }      
         if (strtolower($reqr[openreg])=='yes' && $disabled=="no") {
            $i++;
         }
         echo "<label ";
         if ($disabled=="yes") {
            echo " style='color: #888888; ' ";
         }
         echo ">";
         $slstate="";
         if ($regreq[$esubr[id]]=="") {
            if ($i==1) {
               $slstate=" checked selected ";
            }
         } else {
            if ($regreq[$esubr[id]]==$reqr[id]) {
               $slstate=" checked selected ";
            }
         }

         echo "<input type=radio name='regreq[$esubr[id]]' value='$reqr[id]' $slstate ";
         if ($disabled=="yes") {
            echo " disabled ";
         }
         echo ">";
         echo stripslashes($reqr[name]);
         if (floor($reqr[limitpart])!=0) {
            echo "<font class=smaller2> (".tnr($chkava)."/$reqr[limitpart])</font>";
         }
         echo "</label>";
         echo "<BR>";
      }
         ?>
   </td></tr>
<?php
      }
   }
   
   
   ?>
   <tr><td></td><td><input type=submit value="   ลงทะเบียน   "></td></tr></table>
   </table>
   </form>
   <?php
   
}



//lists


//dsp
$pid=$id;
$dsp[5][text]="วันเดือนปี::l::Date";
$dsp[5][field]="dt";
$dsp[5][filter]="datetime";
$dsp[5][width]="5%";

$dsp[2][text]="รายละเอียด::l::Registration Detail";
$dsp[2][field]="name";
$dsp[2][filter]="module:localdet";
$dsp[2][width]="30%";

$dsp[3][text]="การเข้าร่วม::l::Request and particapation";
$dsp[3][field]="name";
$dsp[3][filter]="module:localpart";
$dsp[3][width]="30%";


$dsp[4][text]="ยืนยันแล้ว";
$dsp[4][field]="isallowed";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="5%";

function localdet($w) {
   $s="";
   $dd=tmq("select * from eventsreg_memfid where pid='$w[pid]' and lower(isshow)='yes' order by code",false);
   while ($ddr=tfa($dd)) { //printr($ddr);
      if (strtolower($ddr[ispublic])!="yes") continue;
      $s.=" $ddr[txt] : ".$w["fid".$ddr[code]]."<BR>";
   }
   $s.="";
   
   return $s;
}
function localpart($w) {
   //printr($w);
   $chksub=tmq("select * from eventsreg_sub where pid='$w[pid]' ");
   if (tnr($chksub)!=0) {
      $subdata=explode(",",$w[subdata]);
      $subdata=arr_filter_remnull($subdata);
      $subdata=implode(",",$subdata);
      $s="<b>เข้าร่วม </b><BR>";
      $dd=tmq("select * from eventsreg_sub where pid='$w[pid]' and id in ($subdata) order by ordr",false);
      while ($ddr=tfa($dd)) { //printr($ddr);
         $s.=" $ddr[name],";
      }
      $s=rtrim($s,",");
   } else {
      $s.="เข้าร่วม";
   }
   //req
   $chksub=tmq("select * from eventsreg_requests where pid='$w[pid]' ");
   if (tnr($chksub)!=0) {
      $reqdata=explode(",",$w[reqdata]);
      $reqdata=arr_filter_remnull($reqdata);
      $reqdata=implode(",",$reqdata);
      $s.="<BR><b>อื่น ๆ </b><BR>";
      $dd=tmq("select * from eventsreg_requests_sub where id in ($reqdata) order by ordr",false);
      while ($ddr=tfa($dd)) { //printr($ddr);
         $ddp=tmq("select * from eventsreg_requests where id='$ddr[pid]' ");
         $ddpr=tfa($ddp);
         $s.=" $ddpr[name]=$ddr[name]<BR>";
      }
      $s=rtrim($s,",");
      $s.="";
   }
   return $s;
}
/*
$dsp[3][text]="กิจกรรมย่อย";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_sub";
$dsp[3][width]="30%";

function local_sub($wh) {
	$s=tmq("select * from areceventjournal_sub where pid='$wh[id]' ");
	$res= "<CENTER><A HREF='edit_event_sub.php?pid=$wh[id]'>กิจกรรมย่อย ".tmq_num_rows($s)."</A></CENTER>";
	return $res;
}
*/$tbname="eventsreg_reg";

fixform_tablelister($tbname," pid=$pid  ",$dsp,"no","no","no","pid=$pid",$c," dt desc ");




?>

<center><?php echo stripslashes(str_webpagereplacer($ss[bodye]))?></center>
</td></tr></table>
<?php 
foot();
?>