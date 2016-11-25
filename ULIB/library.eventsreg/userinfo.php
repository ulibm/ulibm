<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

pagesection("ข้อมูลผู้ใช้ที่กำหนดให้กรอก");

function localfid($w) {
   global $issave;
   global $_TBWIDTH;
   global $pid;
   global $SAVEVALL;
   if ($issave=="yes") {
      tmq("update eventsreg_memfid set 
       ispublic='".addslashes($SAVEVALL["pub$w"])."',
       txt='".addslashes($SAVEVALL["txt$w"])."',
       type1='".addslashes($SAVEVALL["typ$w"])."',isshow='".addslashes($SAVEVALL["sho$w"])."'
      where pid=$pid and code=$w",false);
     // printr($SAVEVALL); die;
   }
   $s=tmq("select * from eventsreg_memfid where pid=$pid and code=$w"); 
   if (tnr($s)==0) {
      tmq("insert into eventsreg_memfid set pid=$pid,code=$w");
      $s=tmq("select * from eventsreg_memfid where pid=$pid and code=$w"); 
   }
   $r=tfa($s);
   ?><table align=center width="<?php echo $_TBWIDTH;?>" style="border: 0px solid #bbbbbb; border-bottom-width: 3px;"><tr valign=top><td width=100>
   Field #<?php echo $w;?><br>
   Show?<BR>
   <?php //printr($r);
   form_quickedit("SAVEVALL[sho$w]",strtoupper($r[isshow]),"yesno");
   ?>
   <BR>   เปิดเผย?<BR>
   <?php //printr($r);
   form_quickedit("SAVEVALL[pub$w]",strtoupper($r[ispublic]),"yesno");
   ?>
   </td>
   <TD>
   Text:<BR> <input type=text name='SAVEVALL[txt<?php echo $w?>]' value="<?php echo $r[txt]; ?>"></td>
   <td>
   Type: <BR><textarea name='SAVEVALL[typ<?php echo $w?>]'  style="width: 500px; height: 80px;"><?php echo $r[type1]; ?></textarea>
   </TD>
   
   </tr></table>
   <?php
}
?><center><form action=<?php echo $PHP_SELF;?> method=post><?php
for ($i=1;$i<=10;$i++) {
   localfid($i);
}
?>
<input type=hidden name=issave value=yes>
<input type=hidden name=pid value="<?php echo $pid?>">
<input type=submit><A HREF="index.php"><CENTER>กลับ</CENTER></A>
</form>

<table width=600 align=center><tr><td>
<b>Type Example:</b><BR>
text<BR>
longtext<BR>
number<BR>
yesno<BR>
list:Male,Female<BR>
list:English,Thai,Chinese
</td></tr></table>
<?php

foot();
?>