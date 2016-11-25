

           
			<table width = "<?php  echo $_TBWIDTH?>"  border =0 cellspacing = "1" cellpadding = "4" align = "center">
                <form name = "form1" method = "GET" action = "searching.php" onsubmit = "return chk(this); ">
                    <tr bgcolor = "#f3f3f3">
                        <td width = "23%" bgcolor = "#CCCCCC">
                            <font face = "Tahoma" size = "2"><b class = stupidb>&nbsp;&nbsp;&nbsp;<?php  echo getlang("ผู้แต่ง::l::Author"); ?>
</b></font></td>
                        <td width = "77%">
                            <font face = "Tahoma" size = "2"><input type = "text" name = "MAUTHOR" size = "56" 
class = "myinput"> </font></td>
                    </tr>
                    <tr bgcolor = "#e3e3e3">
                        <td width = "23%" bgcolor = "#B2B2B2">
                            <font face = "Tahoma" size = "2"><b class = stupidb>&nbsp;&nbsp;&nbsp;<?php  echo getlang("ชื่อเรื่อง::l::Title"); ?>
</b></font></td>
                        <td width = "77%">
                            <font face = "Tahoma" size = "2"><input type = "text" name = "MTITLE" size = "56" 
class = "myinput"> </font></td>
                    </tr>
                    <tr bgcolor = "#f3f3f3">
                        <td width = "23%" bgcolor = "#CCCCCC">
                            <font face = "Tahoma" size = "2"><b><nobr class = stupidb>&nbsp;&nbsp;&nbsp;ISBN/ISSN</b></font></td>
                        <td width = "77%">
                            <font face = "Tahoma" size = "2"><input type = "text" name = "MISBN" size = "32" 
class = "myinput">
                            <font face = "Tahoma" size = "2"><b class = 
stupidb>&nbsp;<?php  echo getlang("&nbsp;&nbsp;เลขเรียก &nbsp; ::l::CallNumber"); ?>
</b></font>
                            <font face = "Tahoma" size = "2"><input type = "text" name = "MCALLNUM" size = "<?php  echo getlang("11::l::9"); ?>" class = "myinput" maxlength=400> </font></td>
                    </tr>
                    <tr bgcolor = "#e3e3e3">
                        <td width = "23%" bgcolor = "#B2B2B2">
                            <font face = "Tahoma" size = "2"><b class = stupidb>&nbsp;&nbsp;&nbsp;<?php  echo getlang("หัวเรื่อง::l::Subject"); ?>
</b></font></td>
                        <td width = "77%">
                            <font face = "Tahoma" size = "2"><input type = "text" name = "MSUBJECT" size = 
"56"> </font></td>
                    </tr>
                    <tr bgcolor = "#f3f3f3">
                        <td width = "23%" bgcolor = "#CCCCCC">
                            <font face = "Tahoma" size = "2"><b class = stupidb>&nbsp;&nbsp;&nbsp;<?php  echo getlang("คำสำคัญ::l::Keyword"); ?>
</b></font></td>
                        <td width = "77%">
                            <font face = "Tahoma" size = "2"><input type = "text" name = "MDESCRIPTION" size = 
"56"> </font></td>
                    </tr>
                    <tr bgcolor = "#f3f3f3">
                        <td width = "23%" bgcolor = "#CCCCCC">
                            <font face = "Tahoma" size = "2"><b class = stupidb>&nbsp;&nbsp;&nbsp;<?php  echo getlang("อื่น ๆ::l::Others"); ?>
</b></font></td>
                        <td width = "77%">
Barcode <input type = "text" name = "searchbybarcode" size = "16">&nbsp;&nbsp;&nbsp;
Bib. ID <input type = "text" name = "searchbybibid" size = "16">
</td>
                    </tr>
                    <tr>
			<td bgcolor = "#e3e3e3" colspan=2 align=center>
                            <nobr><font face = "Tahoma" size = "2"><input type = "submit" name = "Submit" value = "<?php  echo getlang("ค้นหา::l::Search"); ?>" class = "unnamedbtnweb" style="font-weight: bold;"> <input  type = "reset" value = "<?php  echo getlang("ลบคำค้น::l::Reset"); ?>" class = "unnamedbtnweb" name = "reset"> </font>
							<?php 
$upachidechkperinfo=barcodeval_get("webpage-o-upachidechkperinfo");			
if ($upachidechkperinfo!="yes") {				
							?>
<input style='width: 280px'  type = reset value = "<?php  echo getlang("ตรวจสอบรายละเอียดส่วนตัว::l::Check personal record"); ?>" onclick = "location='/<?php 
echo $dcr;
?>/member/'" class = unnamedbtn>
<?php 
}
?><?php 
	if ($_advsearch_includemode!="yes") {
?>
 <input style='width: 125px' type = reset value = "Advance Search" onclick = "location='/<?php 
echo $dcr;
?>/index.php?setforcehpmode=advsearch'" class = unnamedbtnweb style="font-weight: normal;"> 
<?php }?>
                        </td>
                    </tr></form>
<?php  include("searchFormJS.php");?>
            </table>
<?php 
if ($_advsearch_includemode!="yes") {
	include("searchformFooter.php");
}
?>
       <script language="JavaScript1.2">
       function chk(wh) {
          pass=true;
          //alert(wh.MAUTHOR.value);
          //alert(wh.MTITLE.value);
          //alert(wh.MCALLNUM.value);
          //alert(wh.MSUBJECT.value);
          //alert(wh.MDESCRIPTION.value);
          //alert(wh.MRETYPE.value);
          //alert(wh.MFACULTY.value=="");
          if 
(wh.MISBN.value==""&&wh.MAUTHOR.value==""&&wh.MTITLE.value==""&&wh.MSUBJECT.value==""&&wh.MDESCRIPTION.value==""&&wh.MCALLNUM.value==""&&wh.searchbybarcode.value==""&&wh.searchbybibid.value=="") 
{
             pass=false;
          }
          if (pass==false) {
              alert("<?php  echo getlang("กรุณาใส่ข้อความสำหรับสืบค้นด้วยครับ::l::Please specify what you looking for"); ?>");
              return false;
          }
          return true;
       }
       </script>
