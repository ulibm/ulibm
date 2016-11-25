<?php 
    ;
	set_time_limit (0);
	include ("../inc/config.inc.php");
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
<?php 
  $sql1 ="SELECT distinct importid, count(id) as cc FROM media  group by importid"; 
	$sql2 = "$sql1 order by id desc";
	$result = tmqp($sql2,"importid.php?");
?> </div>
<BR>
                <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699"> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("หมายเลขการนำเข้า::l::Import ID"); ?></font></b></font></td>
 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
width=20% size="2"><?php  echo getlang("จำนวนรายการ::l::Count records"); ?></td> 
                    <td width="13%">
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2">Export</font></b></font></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = (($startrow))+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>$row[importid]  </font></a></td>";
            $i2 = $i2 +1;  
 echo"<td>$row[cc]</td><td>";
echo " <nobr>&nbsp;<A HREF='importid.php?IMPORTID=$row[importid]' >Export</A>";
		echo "</td>";
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
			echo $_pagesplit_btn_var
 ?>
                </table>
<?php  
    
?>
              </td>
            </tr>
          </table>
 
<CENTER>** <?php  echo getlang("none หรือ [EMPTY] หมายถึง ชุดข้อมูลที่ได้จากการคีย์ด้วยมือ::l::none or [EMPTY] is records you key mannually"); ?></CENTER>
<?php 
if ($IMPORTID!="") {
		 $fnameURL=$dcrURL."_output/marcexport-importid.mrc";
		 $fname=$dcrs."_output/marcexport-importid.mrc";
		@unlink($fname);
		pagesection(getlang("ส่งออก Marc::l::Export Marc"));
		$s=tmq("select * from media where importid='$IMPORTID'");
		$ise=barcodeval_get("lib_marcexport_items");
		while ($r=tmq_fetch_array($s)) {
		if ($ise=="yes") {
			marc_meltin_item($r[ID]);
		}
				fso_file_write($fname,'a+',marc_export($r[ID]).chr(29));
		}
				fso_file_write($fname,'a+',chr(13).chr(10));
}
if (file_exists($fname)) {
	?><CENTER><HR> <A HREF="<?php  echo $fnameURL?>?<?php echo randid()?>.mrc" target=_blank><?php  echo getlang("กรุณาคลิกที่นี่เพื่อดาวน์โหลดข้อมูล::l::Click here to download your file"); ?></A> <?php 
	echo "(".round(filesize($fname)/1024)."kb)";
	?></CENTER><?php 
	echo "";
}
?>
</form>
      </td>
    </tr>
  </table>
  <CENTER><B><A HREF="mn.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
</B></CENTER><BR><BR>
  <?php 
		foot();   
	   ?>