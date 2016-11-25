<?php 
include("../inc/config.inc.php");
html_start();
include("./_REQPERM.php");
mn_lib();

$revokemember=floor($revokemember);
if ($revokemember!=0) {
   tmq("delete from servicespot_client_i where id='$revokemember';");
}
?><center><?php 
if ($clearthis=="yes") {
   tmq("delete from servicespot_client_i where spotid='$spot'");
         echo "<b style='color:red'>Spot Cleared</b>";
}
$s=tmq("select * from servicespot_client where id='$spot' ");
$s=tfa($s);
$scate=tmq("select * from servicespot_room where id='$s[pid]' ");
$scate=tfa($scate);


if ($addnew=="yes") {
   $bc=trim($bc);
   $bc=addslashes($bc);
   if ($bc=="") {
      echo "<b style='color:red'>Barcode is empty</b>";
   } else {
      $chk=tmq("select * from member where UserAdminID='$bc' ");
      if (floor(tnr($chk))!=1) {
         echo "<b style='color:red'>Barcode not found [$bc]</b>";
      } else {
         $dupchksamegrouplist=tmq("select * from servicespot_client where pid='$scate[id]' ");
         $dupchksamegroupliststr="";
         while ($dupchksamegrouplistr=tfa($dupchksamegrouplist)) {
            $dupchksamegroupliststr=$dupchksamegroupliststr.",".$dupchksamegrouplistr[id];
         }
         $dupchksamegroupliststr=trim($dupchksamegroupliststr," ,");
         $dupchk=tmq("select * from stathist_servspoti_member where foot in ($dupchksamegroupliststr) and head='$bc' 
         and floor(dat)='".floor(date('j'))."'
         and floor(mon)='".floor(date('n'))."'
         and floor(yea)='".floor(date('Y'))."' ",false);
         if (floor(tnr($dupchk))!=0 && $allowdup!="yes") {
            echo getlang("สมาชิกท่านนี้เคยใช้บริการไปแล้ววันนี้ " . tnr($dupchk)." ครั้ง::l::
            This member used " . tnr($dupchk)." times today")."<BR>";
            echo get_member_name($bc)."<BR>";
            echo getlang("คุณต้องการยืนยันการให้บริการอีกครั้งหรือไม่::l::Please confirm to allow");
            ?><a style='color:darkred; font-weight: bold;' class="a_btn "href='<?php  echo $PHP_SELF?>?spot=<?php  echo $spot?>&addnew=yes&bc=<?php  echo $bc?>&allowdup=yes'><?php  echo getlang("  ยืนยัน  ::l::  Confirm  ");?></a><?php 
         } else {
            $c=tmq("select * from servicespot_client_i where spotid='$spot' ",false);
            if (floor(tnr($c))==0) {
               stathist_add("servspot_member",$bc,$spot);	
               $now=time();
               tmq("update servicespot_client set cu_regis='$now', cu_loginid='$bc' where id='$spot' ",false);
            }
            tmq("delete from servicespot_client_i where member='$bc' ");
            tmq("insert into servicespot_client_i set spotid='$spot' , member='$bc' ");
            stathist_add("servspoti_member",$bc,$spot);	
            echo "<b style='color:darkgreen;'>".getlang("บันทึกการเข้าใช้งาน::l::Saved").":".get_member_name($bc)."</b>";
         }
      }
   }
}

$tbname="servicespot_client_i";

$c=Array();

//dsp
function localdsp($wh) {
	global $dcrURL;
	return " <B>".get_member_name($wh[member])."</B> ";
}
function localman($wh) {
	global $dcrURL;
	global $spot;
	global $PHP_SELF;
	return " <a href='$PHP_SELF?spot=$spot&revokemember=$wh[id]'
	style='color: darkred;'>".getlang("ยกเลิก::l::Revoke")."</a> ";
}



$dsp[2][text]="สมาชิก::l::Name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localdsp";
$dsp[2][width]="40%";

$dsp[3][text]="จัดการ::l::Manage";
$dsp[3][align]="center";
$dsp[3][field]="name";
$dsp[3][filter]="module:localman";
$dsp[3][width]="20%";


//pagesection("กรุณาเลือกจุดบริการที่ต้องการแสดง::l::Choose Service Spot to serve");


html_dialog(getlang("กำลังจัดการ::l::Managing"),getlang($scate[name])." - " .getlang($s[name]));
$c=tmq("select * from servicespot_client_i where spotid='$spot' ");

?><form action="<?php  echo $PHP_SELF; ?>" method=POST>
<input type=hidden name="spot" value="<?php  echo $spot; ?>">
<?php  
echo getlang("สแกนบาร์โค้ดสมาชิกเพื่อเข้าใช้งาน::l::Scan member's barcode to begin");

?><input name=addnew type="hidden" value="yes">
<input name=bc size="20" ID="BCinputID" >
<input type=submit value="Submit">
<script>
tmp=getobj("BCinputID");
tmp.focus();
</script></form>
<BR>
<?php  $c=tmq("select * from servicespot_client_i where spotid='$spot' ",false);
    if (floor(tnr($c))!=0) {
            ?>
<a href="<?php  echo $PHP_SELF;?>?spot=<?php  echo $spot; ?>&clearthis=yes" class=a_btn style='color:darkred;'><?php  echo getlang("เคลียร์จุดให้บริการนี้::l::Clear this spot");?></a> 
<a class=a_btn href="_printspot.php?spot=<?php  echo $spot; ?>" target=_blank relcloseasreload="yes"><img width=16 height=16
              src="<?php echo $dcrURL;?>neoimg/gicons/action/ic_print_black_18dp.png"> <?php echo getlang("พิมพ์::l::Print");?></a>
<?php  } else {
      tmq("update servicespot_client set addtime=0 where id='$spot' ");
} ?>
</center><?php 

fixform_tablelister($tbname," spotid='$spot' ",$dsp,"no","no","no","mi=$mi",$c);

?>