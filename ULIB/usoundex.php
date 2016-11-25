<?php 
;
      include("inc/config.inc.php");
      include("./index.inc.php");
	  head();
		mn_web("usoundex");
 ?>


        <table width="780" align=center border="0" cellspacing="0" cellpadding="6">
          <tr> 
            <td align="center" bgcolor="#666666" ><font size="6" color="#FFFFFF"><b><font face="AngsanaUPC, CordiaUPC">U-SOUNDEX </font></b></font></td>
          </tr>
        </table>
				<CENTER><TABLE width=600 align=center>
<TR>
	<TD><BR><BR><?php  echo getlang("<B>U-SOUNDEX </B>คือ ระบบการสืบค้นโดย<U>ค้นหาคำที่มีการออกเสียงคล้ายกัน</U> ซึ่งพัฒนาขึ้นมาให้สนับสนุนกับระบบสืบค้นผ่าน UPAC (Union Library Management) โดยเฉพาะ<BR>  โดยใช้เทคนิคดูจากการออกเสียงของคำเป็นหลัก  ซึ่งได้พัฒนาต่อขึ้นมาจาก <A HREF=\"http://www.php.net/soundex\">soundex</A> ซึ่งใช้กันทั่วโลก แต่ว่า <U>soundex สนับสนุนเฉพาะภาษาอังกฤษเท่านั้น</U> ส่วน U-SOUNDEX ที่พัฒนาขึ้นมานี้	ออกแบบมาให้สนับสนุนภาษาไทยโดยเฉพาะ  ซึ่งมีรายละเอียดการเปลี่ยนสระและพยัญชนะดังนี้::l::<B>U-SOUNDEX </B>is a search-assistant system which suggest word(s)  <U> pronounced similarly produce the same U-SOUNDEX key </U>. U-SOUNDEX develope for UPAC (Union Library Management)   like <A HREF=\"http://www.php.net/soundex\">soundex</A> system . <U>soundex not support Thai language</U> but U-SOUNDEX design espacially for Thai  language	  , the convertion table are below"); ?>			<CENTER><BR><BR><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER></TD>
</TR>
</TABLE></CENTER>

        <form name="form1" action="media_type.php" method="post" >
          <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
      <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<?php 

  $sql1 ="SELECT *  FROM usoundex"; 
	$sql2 = "$sql1 order by ordr";

	$result = tmq($sql2);
	$NRow = tmq_num_rows($result);
	if($NRow >0) { 
		
?> </div>
                <table width="770" align=center border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td colspan=50><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2">รายละเอียดการแปลงคำ</font></b></font></td>

                  </tr>
                  <?php 
         $i=1; 
          echo"<tr valign=top bgcolor=#ffffff height=2>";
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $search1=$row[search1];
			   $search1=str_replace("([a-zA-Z0-9ก-ฮ๐-๙])","อ",$search1);
			   $search1=str_replace("([a-zA-Z0-9ก-ฮ๐-๙]{1,2})","อ",$search1);
               $replace1=$row[replace1];
			   $replace1=str_replace("([a-zA-Z0-9ก-ฮ๐-๙])","อ",$replace1);
			   $replace1=str_replace("([a-zA-Z0-9ก-ฮ๐-๙]{1,2})","อ",$replace1);
			   $replace1=str_replace("\\1","",$replace1);
			   $replace1=str_replace("\\2","",$replace1);
$ittt = (($page*20)-20)+$i;
            echo"<td><font face='MS Sans Serif' size=2>";
if ($i!=1) {
 //echo ",";
}
if ($replace1=="") {
	$replace1="<FONT  COLOR=gray><B>".getlang("ค่าว่าง::l::empty")."</B></FONT>";
}
echo " <B>$search1</B>  ".getlang("แปลงเป็น::l::converted to")." <B>$replace1</B>";
echo "</td>";
if ($i % 4 ==0) {
  echo "</tr><tr>";
}
            $i2 = $i2 +1;  
//การดูสื่อประกอล
    $i++;
		$s = $i-1;	
       } 
echo"</tr>";
 ?>
                </table><BR><BR>
				
								<CENTER><TABLE width=600 align=center>
<TR>
	<TD align=center><?php  pagesection("ประโยชน์ด้านการหาคำใกล้เคียง");?>
<TABLE width=600 align=center>
	<TR valign=top>
		<TD><B>วิทยาการ</B></TD>
		<TD>แปลงได้เป็น <?php  echo usoundex_get("วิทยาการ");?><BR> มีคำที่ใกล้เคียงคือ วิทยาการผลิต , วิทยาคาร , สหวิทยาการ </TD>
	</TR>
	<TR valign=top>
		<TD><B>เอเชีย</B></TD>
		<TD>แปลงได้เป็น <?php  echo usoundex_get("เอเชีย");?><BR> มีคำที่ใกล้เคียงคือ ทวีปเอเชีย , อาเจียน , คนเอเชีย , คนเอเชีย  </TD>
	</TR>
	</TABLE>
	<BR>
	
	<?php  pagesection("ประโยชน์เมื่อการใช้คำค้นไม่ถูก");?><B></B> 
<TABLE width=600 align=center>
	<TR valign=top>
		<TD>หากค้นด้วยคำว่า <B>โลกาพิ</B></TD>
		<TD>แปลงได้เป็น <?php  echo usoundex_get("โลกาพิ");?><BR> มีคำที่ใกล้เคียงคือ โลกาภิวัตน์  </TD>
	</TR>
	</TABLE>
	<BR>
	
	<?php  pagesection("ประโยชน์เมื่อต้องการหาคำอื่น ๆ ที่ยาวกว่า");?><B></B> 
<TABLE width=600 align=center>
	<TR valign=top>
		<TD>หากค้นด้วยคำว่า <B>โรคจิต</B></TD>
		<TD>แปลงได้เป็น <?php  echo usoundex_get("โรคจิต");?><BR> มีคำที่ใกล้เคียงคือ โรคจิตเภท , โรงพยาบาลโรคจิต   </TD>
	</TR>
	</TABLE>
	
	
	
	</TD>
</TR>
</TABLE></CENTER>
<BR>
				<CENTER><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER>

<?php  
    }
  
  
else {
       echo "<center><br><br><hr width='100%' size='1' color=red><font size=+2 face='MS Sans Serif'>Sorry, no results were found</font><br><br></center>\n";
 }
?>
              </td>
            </tr>
          </table>
<?php 
foot();
?>