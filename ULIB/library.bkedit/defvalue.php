<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);


?><?php 
if ($saveedittag!="" && $savetp!="") {
	$valueit=addslashes($valueit);
	tmq(" delete from bkedit_defval where template='$savetp' and tag='$saveedittag'");
	if (trim($valueit)!="") {
		tmq("insert into bkedit_defval set template='$savetp' , tag='$saveedittag', value='$valueit' ");
	}
}
if ($edittag!="" && $tp!="") {
	?>  <table width="600" align=center border="0" cellspacing="0" cellpadding="0" class=table_border>
	<TR>
		<TD class=table_head><?php  echo getlang("แท็ก::l::Tag ID");?></TD>
		<TD class=table_td><?php  echo $edittag?></TD>
	</TR>
	<TR>
		<TD class=table_head><?php  echo getlang("เทมเพลท::l::Template");?></TD>
		<TD class=table_td><?php  
		$chk=tmq("select * from marc_template where fid='$tp'  ",false);
		if (tmq_num_rows($chk)==0) {
			die ("$tp not exist");
		}
		$chk=tmq_fetch_array($chk);
	echo $chk[name]?></TD>
	</TR><FORM METHOD=POST ACTION="defvalue.php">
		<INPUT TYPE="hidden" NAME="saveedittag" value="<?php  echo $edittag?>">
		<INPUT TYPE="hidden" NAME="savetp" value="<?php  echo $tp?>">
		<INPUT TYPE="hidden" NAME="startrow" value="<?php  echo $startrow?>">
	<TR>
		<TD class=table_head><?php  echo getlang("ค่าเริ่มต้น::l::Default Value");?></TD>
		<TD class=table_td><TEXTAREA NAME="valueit" ROWS="6" COLS="60"><?php  
$chk=tmq("select * from bkedit_defval where template='$tp' and tag='$edittag' ",false);
$chk=tmq_fetch_array($chk);
echo $chk[value]?></TEXTAREA><BR>* includes 2 digit indicators</TD>
	</TR>	
	<TR>
		<TD align=center><INPUT TYPE="submit"></TD>
	</TR>
	</FORM>
	</TABLE><?php 
}
?><BR>
  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
        <form name="form1" action="defvalue.php" method="post" >
          <table width="<?php  echo $_TBWIDTH?>"
 border="0" cellspacing="1" cellpadding="3">
        <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<a href="../library.marctemplate/index.php"  class=a_btn><?php  echo getlang("จัดการชุดฟอร์มการแก้ไขข้อมูล::l::Manage Marc template"); ?></a>  : 
<a href="./media_type.php"  class=a_btn><?php  echo getlang("กลับไปโครงสร้างมาร์ค::l::Back to MARC structure"); ?></a>
<?php 

  $sql1 ="SELECT *  FROM bkedit"; 
	$sql2 = "$sql1 order by ordr";
//echo $sql2;
	$result = tmqp($sql2,"defvalue.php?");
?> </div>
                <table width="<?php  echo $_TBWIDTH?>"
 border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699"> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td width=150><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("ชื่อแท็ก [ชื่อแท็ก] ::l::Tag name [tag name]"); ?></font></b></font></td>
					<?php 
					$marctemplates=tmq("select * from marc_template order by id");
					$marctemplate=Array();
					while ($marctemplater=tmq_fetch_array($marctemplates)) {
						$marctemplate[$marctemplater[fid]]=$marctemplater[name];
					}
//					print_r($marctemplate);
					foreach ($marctemplate as $marctemplatekey => $marctemplatevalue) {
						?><td width="5%" style="border-top-style: solid; border-top-width: 6px; border-top-color: red"><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2" style="direction: ltr; writing-mode: tb-rl; font-family: 'MS Sans Serif'; " >TP:<?php  echo $marctemplatevalue?>?</font></b></font></td><?php 
					}
					?>

                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = ($startrow)+$i;
      if ($i % 2 ==0) {
          echo"<tr valign=top bgcolor=#ffffff height=2>";
      } else {
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
      }             
            echo"<td><font face='MS Sans Serif' size=2><nobr>$ittt [ $row[ordr] ]</font></td>";
     //       echo"<td><font face='MS Sans Serif' size=2 color=#003366>$ID </font></a></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>
$name [<B>$row[fid]</B>]   </font></a><BR>$row[example]/$row[descr] </td>";
            $i2 = $i2 +1;  
/////////////////
foreach ($marctemplate as $marctemplatekey => $marctemplatevalue) {
echo "<td width=15% width=2 style=\"border-bottom-style: solid; border-bottom-width: 2px; border-bottom-color: black; background-color: #DDDDDD\"> <font size=1>";
$chk=tmq("select * from bkedit_defval where template='$marctemplatekey' and tag='$row[fid]' ",false);
$chk=tmq_fetch_array($chk);
echo "<FONT class=smaller>[<A HREF='defvalue.php?edittag=$row[fid]&tp=$marctemplatekey&startrow=$startrow' class='smaller a_btn'>แก้ไข</A>]</FONT> $chk[value]";
echo "</td>";
}
//////////////////

           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
	   	echo $_pagesplit_btn_var;

 ?>
                </table>
<?php  
    
?>
              </td>
            </tr>
          </table>
 
        </form>
      </td>
    </tr>
  </table>
  <?php 
  foot();
  ?>