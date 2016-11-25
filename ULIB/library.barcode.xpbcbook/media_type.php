<?php 
;
 include("../inc/config.inc.php");
 head();
 include("_REQPERM.php");
mn_lib();
  ?>

  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>

        <form name="form1" action="media_type.php" method="post" >
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">

<a class=a_btn href="deleteall.php" onclick='return confirm("<?php  echo getlang("คุณต้องการที่จะ ลบรายการทั้งหมด::l::Do you want to clear all records"); ?> ?");' >
<?php  echo getlang("ลบรายการบาร์โค้ดทั้งหมด::l::Delete all barcode"); ?></a> 
<a class=a_btn href="bc_pdf.php" target=_blank><?php  echo getlang("พิมพ์รายการบาร์โค้ด::l::Print barcode"); ?></a> 
<A class=a_btn HREF="cfg.php"><?php  echo getlang("ตั้งค่า::l::Setting"); ?></A><BR><BR>
<?php 
$tbname="xpbcbook";


$c[2][text]="Bc::l::Bc";
$c[2][field]="bc";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

//dsp


$dsp[2][text]="Bc::l::Bc";
$dsp[2][field]="bc";
$dsp[2][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

  foot();
  ?>