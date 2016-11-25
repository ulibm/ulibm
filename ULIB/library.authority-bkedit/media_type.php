<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
mn_lib();
	if ($item!="") {
		include("chstat.php");
	}
?><BR>
  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
        <form name="form1" action="media_type.php" method="post" >
          <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="1" cellpadding="3">
        <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<a href="addMedia_type.php?sid=<?php 
echo $sid;?>" class=a_btn><?php  echo getlang("เพิ่มแท็ก::l::Add tag"); ?></a> 
<?php 

  $sql1 ="SELECT *  FROM bkedit_authority"; 
	$sql2 = "$sql1 order by ordr";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
?> </div>
                <table width="<?php  echo $_TBWIDTH;?>" border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699"> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td width=150><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("ชื่อแท็ก [ชื่อแท็ก] ::l::Tag name [tag name]"); ?></font></b></font></td>
 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
width=20% size="2"><?php  echo getlang("จัดการกฏ/ตัวอย่าง/อธิบาย::l::Edit rules/Example/Description"); ?> </td> 
                    <td width="5%"><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2" style="direction: ltr; writing-mode: tb-rl;" >Default show?</font></b></font></td>                    
                    <td width="5%"><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2" style="direction: ltr; writing-mode: tb-rl;" >Repeat?</font></b></font></td>                    
                    <td width="5%"><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2" style="direction: ltr; writing-mode: tb-rl;" >Indicator?</font></b></font></td>
                    <td width="5%"><nobr>
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit"); ?></font></b></font></td>
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
$name [<B>$row[fid]</B>]   </font></a></td>";
            $i2 = $i2 +1;  
//การดูสื่อประกอล
//echo "</td>";
echo "<td width=1% width=2 > <A HREF='sub.php?fid=$row[fid]' class='a_btn'>".getlang("จัดการกฏ::l::Edit rules")."</A>";
	$tmps=tmq("select * from authoritydb_rule where fid='$row[fid]' ");
	echo "(".tnr($tmps).")";
echo "<BR>
<font size=1> $row[example]/$row[descr] </td>";
echo "<td width=1% width=2 > <font size=1>";
            if ("$row[defshow]" == "yes") {
                echo "<A HREF='media_type.php?page=$page&mid=$ID&item=defshow&val=no&startrow=$startrow'><FONT SIZE=2 COLOR=darkblue><B>Show</B></FONT></A>";
            }  else  {
                echo "<A HREF='media_type.php?page=$page&mid=$ID&item=defshow&val=yes&startrow=$startrow'><FONT SIZE=2 COLOR=black><nobr>Hide</FONT></A>";
            }
echo "</td>";echo "<td width=1% width=2 > <font size=1>";
            if ("$row[isrepeat]" == "R") {
                echo "<A HREF='media_type.php?page=$page&mid=$ID&item=isrepeat&val=NR&startrow=$startrow'><FONT SIZE=2 COLOR=darkblue><B>Repeat</B></FONT></A>";
            }  else  {
                echo "<A HREF='media_type.php?page=$page&mid=$ID&item=isrepeat&val=R&startrow=$startrow'><FONT SIZE=2 COLOR=black><nobr>no-Repeat</FONT></A>";
            }
echo "</td>";

echo "<td width=1% width=2 > <font size=1>";
            if ("$row[ishasindi]" == "YES") {
                echo "<A HREF='media_type.php?page=$page&mid=$ID&item=ishasindi&val=NO&startrow=$startrow'><FONT SIZE=2 COLOR=darkblue>YES</FONT></A>";
            }  else  {
                echo "<A HREF='media_type.php?page=$page&mid=$ID&item=ishasindi&val=YES&startrow=$startrow'><FONT SIZE=2 COLOR=black>NO</FONT></A>";
            }
echo "</td>";

echo"<td>";
 echo"<font face='MS Sans Serif' size=2>
<a href='delMedia_type.php?ID=$ID' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>/<font face='MS Sans Serif' 
size=2>";
echo "<a href='editMedia_type.php?ID=$ID&TYPE=$mType'>".getlang("แก้::l::Edit")."</a></font></td>";
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