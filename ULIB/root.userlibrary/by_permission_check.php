<?php
include("../inc/config.inc.php");
html_start();

loginchk_root();

$addpermission=trim($addpermission);
if ($addpermission!="") {
   tmq("delete from library_permission where code='$permid' and lib='$addpermission' ");
   tmq("insert into library_permission set code='$permid' , lib='$addpermission' ");
}
$rempermid=trim($rempermid);
if ($rempermid!="") {
   tmq("delete from library_permission where code='$permid' and lib='$rempermid' ",false);
}
		$s=tmq("select * from library_modules where code='$permid' ",false);
      $s=tfa($s);
      $p=tmq("select * from library_modules_cate where code='$s[nested]' ");
      $p=tfa($p);
      //printr($s);
      ?><table width=100% class=table_border>
      <?php if ($p[code]!="") {
      ?>      <tr><td width=30%>Category</td><td class=table_td><?php echo stripslashes($p[name]);?></td></tr>
<?php
      }?>
      <tr><td width=30%>Permission</td><td class=table_td><?php echo stripslashes($s[name]);?></td></tr>

      </table>
      <?php 
      $ls=tmq("select * from library where isallowall='YES' ",false);
      $fullpermlib=Array();
      $fullpermlibstr="";
      while ($r=tfa($ls)) {
         $fullpermlibstr=$fullpermlibstr.",'".$r[UserAdminID]."'";
         $fullpermlib[]=$r[UserAdminID]."";
      }
      $fullpermlibstr=trim($fullpermlibstr,", ");
      if ($fullpermlibstr=="") { $fullpermlibstr="'xxxxxxxxxxxxxxxxxxxxxxxx'";}

      $ls=tmq("select * from library where permtp<>'' ",false);
      $setbypermlib=Array();
      $setbypermlibstr="";
      while ($r=tfa($ls)) {
         $setbypermlibstr=$setbypermlibstr.",'".$r[UserAdminID]."'";
         $setbypermlib[$r[UserAdminID]]=$r[permtp]."";
      }
      $setbypermlibstr=trim($setbypermlibstr,", ");
      if ($setbypermlibstr=="") { $setbypermlibstr="'xxxxxxxxxxxxxxxxxxxxxxxx'";}


      ?>
      <table width=100% class=table_border>
      <tr><td colspan=2 style='color:darkgreen; font-weight: bolder'> <?php echo getlang("ผู้มีสิทธิ์ใช้::l::Allowed Librarian");?></td></td>
      <?php
      $ls=tmq("select * from library_permission where code='$permid' and lib not in ($fullpermlibstr) and lib not in ($setbypermlibstr)",false);
      $allowedlibrarian="";
      while ($r=tfa($ls)) {
      $chk=tmq("select * from library where UserAdminID='$r[lib]'  ");
      if (tnr($chk)==0) { continue;}
      $allowedlibrarian=$allowedlibrarian.",'".$r[lib]."'";
      echo "<tr class=table_dr><td width=70% class=table_td>[$r[lib]] ".get_library_name($r[lib])."</td>";
      
      echo "<td class=table_td align=center><a style='color: darkred' href='$PHP_SELF?permid=$permid&rempermid=$r[lib]' onclick=\"return confirm('remove permission from this user?');\">remove</a></td></tr>";
      }
?></table>


      <table width=100% class=table_border>
      <tr><td colspan=2 style='color:darkred; font-weight: bolder'> <?php echo getlang("ผู้ไม่มีสิทธิ์ใช้::l::Unallowed Librarian");?></td></td>
      <?php
      $allowedlibrarian=trim($allowedlibrarian,", ");
      if ($allowedlibrarian=="") { $allowedlibrarian="'xxxxxxxxxxxxxxxxxxxxxxxx'";}
      $ls=tmq("select * from library where UserAdminID not in ($allowedlibrarian) and UserAdminID not in ($fullpermlibstr) and UserAdminID not in ($setbypermlibstr)",false);
      while ($r=tfa($ls)) {
      echo "<tr class=table_dr><td width=70% class=table_td>[$r[UserAdminID]] ".get_library_name($r[UserAdminID])."</td>";
      
      echo "<td class=table_td align=center><a style='color: darkgreen' href='$PHP_SELF?permid=$permid&addpermission=$r[UserAdminID]'>Allow</a></td></tr>";
      }
?></table><BR><BR>
<?php
if (count($fullpermlib)!=0) {
   //printr($fullpermlib);
   echo getlang("หมายเหตุ* บรรณารักษ์ต่อไปนี้มีสิทธิ์ใช้งานได้ทุกระบบอยู่แล้ว::l::Note* The following librarian can use any functions");
   echo "<BR><font class=smaller2>";

   @reset($fullpermlib);
   while (list($k,$v)=each($fullpermlib)) {
      echo " &bull; [$v] ".get_library_name($v);
   }
}
?></font><BR><BR><?php
if (count($setbypermlib)!=0) {
   //printr($fullpermlib);
   echo getlang("หมายเหตุ* บรรณารักษ์ต่อไปนี้ตั้งสิทธิ์ใช้งานตามเทมเพลท::l::Note* The following librarian can use permission by template");
   echo "<BR><font class=smaller2>";

   @reset($setbypermlib);
   while (list($k,$v)=each($setbypermlib)) {
      echo " &bull; [$k] ".get_library_name($k)."($v)  " ;
   }
}
?></font>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>