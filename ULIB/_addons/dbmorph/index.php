<?php 
	; include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
$now=time(); 
$input=trim($input);


$tblist=tmq("show tables");
$t=Array();
while ($r=tmq_fetch_array($tblist)) {
	$t[]=$r[0];
}

$res=Array();

if ($ismorph=="yes") {
   echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($morphdata);
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
               $v2=rtrim($v2,"%#\n ");
               tmq("alter table $k add ".$v2);
            }
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
}
$masterurl=getval("SYSCONFIG","ulibmasterurl");
$masterurl=rtrim($masterurl," /");
$autoloaddb=Array();
$autoloaddb[printtemplate]=Array();
$autoloaddb[printtemplate]["step1"]="printtemplate,printtemplate_align,printtemplate_itype,printtemplate_sub,printtemplate_sub_i,printtemplate_var";
$autoloaddb[printtemplate]["step2"]="printtemplate=id,printtemplate_align=code,printtemplate_itype=code,printtemplate_sub=code,printtemplate_sub_i=id,printtemplate_var=code";
$autoloaddb[printtemplate]["step3"]="printtemplate=id,printtemplate_align=code,printtemplate_itype=code,printtemplate_sub=code,printtemplate_sub_i=id,printtemplate_var=code";

if ($autoload=="") {
   html_dialog("","ระบบอัพเดทโครงสร้างฐานข้อมูลของโปรแกรม <BR>หากมีส่วนอัพเดทที่จำเป็น ทางทีมผู้พัฒนาจะส่งโค้ดโครงสร้างฐานข้อมูลมาให้ท่าน");
} 
if ($autoload!="" && !is_array($autoloaddb[$autoload])) {

   html_dialog("Error","ผิดพลาด - พบคำสั่งให้ปรับโครงสร้างฐานข้อมูลต่อไปนี้ <BR><BR><B>$autoload</B><BR><BR> แต่ระบบปรับโครงสร้างฐานข้อมูลไม่รู้จักชุดฐานข้อมูลดังกล่าว แนะนำให้อัพเดทโมดูลการปรับโครงสร้างฐานข้อมูล (dbmorph) เพื่อแก้ปัญหานี้");

}
if ($autoload!="" && is_array($autoloaddb[$autoload])) {

   html_dialog("","กรุณายืนยัน ระบบปรับโครงสร้างฐานข้อมูลจะทำการปรับปรุงโครงสร้างต่อไปนี้ให้ท่าน <BR><BR><B>$autoload</B><BR><BR> โดยดึงข้อมูลจาก URL หลัก $masterurl<BR><BR>กรุณาคลิกปุ่มทั้ง 3 ในแบบฟอร์มด้านล่างเรียงลำดับตามขั้นตอน เพื่อดำเนินการ");

}


?><BR>
<TABLE width=500 align=center>

<?php 


?>



<TR>
	<TD><FORM METHOD=POST ACTION="index.php" <?php if ($autoload!="") echo " target=_blank ";?> onsubmit="return confirm('Morph confirmation')">
   <?php if ($autoload!="") echo '<INPUT TYPE="hidden" name=autoclose value="yes">';?> 
<INPUT TYPE="hidden" name=ismorph value="yes">
<textarea style="width: 800px; height: 220px;" name=morphdata><?php 
if ($autoload!="" && is_array($autoloaddb[$autoload])&& $autoloaddb[$autoload]["step1"]!="") {
   echo file_get_contents($masterurl."/root.dbmorph/index.php?remotegen=".base64_encode($autoloaddb[$autoload]["step1"]));
}
echo stripslashes($_POST[morphdata]);?></textarea>
<INPUT TYPE="submit"value="[1] Update">
</FORM>
</TR>





<TR>
	<TD></TD>
</TR>


</TABLE><BR><?php 


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


			pagesection(getlang("DB Morph [val]")); 
	$ttmp=explode(",","val=main-sub,library_modules=code,library_modules_cate=code,library_modules_topcate=code,libsite_bibmodules=code,libsite_modules=code,media_mid_status=code,barcode_val=classid,index_ctrl=code,webbox_boxtype=classid,webbox_topmenu_type=code,webmobile_menu_type=code,webpage_wiki_status=code");;

$res=Array();

if ($ismorphval=="yes") {
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
            $chk=tmq("select id from $k where ".stripslashes($v2[limit]));
            if (tnr($chk)==1) {
               echo "[<font color=darkgreen>$k2dsp</font>] ";
            } else {
               echo "[<font color=red>$k2dsp</font>] ";
              $v2[data]=rtrim($v2[data],"%#\n ");
               tmq("insert into $k set ".stripslashes($v2[data]));
            }
            //$
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
}


?><BR>
<TABLE width=500 align=center>

<?php 


?>



<TR>
	<TD><FORM METHOD=POST ACTION="index.php" <?php if ($autoload!="") echo " target=_blank ";?>  onsubmit="return confirm('Morph confirmation')">
   <?php if ($autoload!="") echo '<INPUT TYPE="hidden" name=autoclose value="yes">';?> 
   <INPUT TYPE="hidden" name=ismorphval value="yes">
<textarea style="width: 800px; height: 220px;" name=morphdata><?php 
if ($autoload!="" && is_array($autoloaddb[$autoload])&& $autoloaddb[$autoload]["step2"]!="") {
   echo file_get_contents($masterurl."/root.dbmorph/index.php?remotegenval=".base64_encode($autoloaddb[$autoload]["step2"]));
}
echo stripslashes($_POST[morphdata]);?></textarea>
<INPUT TYPE="submit"value="[2] Update Val">
</FORM>
</TR>





<TR>
	<TD></TD>
</TR>


</TABLE><BR><BR>
<TABLE width=500 align=center>

<?php 


if ($ismorphupdateval=="yes") {
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
            tmq("update $k set ".stripslashes($v2[data])." where ".stripslashes($v2[limit]),false);
            //$
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
}
?>



<TR>
	<TD><FORM METHOD=POST ACTION="index.php"  <?php if ($autoload!="") echo " target=_blank ";?>  onsubmit="return confirm('Morph UPDATE confirmation')">
   <?php if ($autoload!="") echo '<INPUT TYPE="hidden" name=autoclose value="yes">';?> 
   <INPUT TYPE="hidden" name=ismorphupdateval value="yes">
<textarea style="width: 800px; height: 220px;" name=morphdata><?php 
if ($autoload!="" && is_array($autoloaddb[$autoload]) && $autoloaddb[$autoload]["step3"]!="") {
   echo file_get_contents($masterurl."/root.dbmorph/index.php?remotegenval=".base64_encode($autoloaddb[$autoload]["step3"]));
}
echo stripslashes($_POST[morphdata]);?></textarea>
<INPUT TYPE="submit"value="[3] Force Update Val">
</FORM>
</TR>





<TR>
	<TD></TD>
</TR>


</TABLE><BR><?php 
if ($autoclose=="yes") {
   ?>
   <script>
   alert("Done.");
   self.close();
   </script>
   <?php
}


foot();
?>