<?php 
    ;
set_time_limit(0); //havester need this;

	include ("../inc/config.inc.php");
	head();
	$_REQPERM="index_reindex";
	mn_lib();

if ($_ISULIBHAVESTER=="yes" && $havestercommand=="addrelation" && $code!="") {
	include ("../_havester/globalfunc.php");
	echo "adding relation (ULIB Havester)<HR>";
	$index=barcodeval_get("havester-tagstocheckdup");
	$index=explode(";",$index);
	//printr($index);
	$sql="";
	@reset($index);
	while (list($k,$v)=each($index)) {
			$sql.=",trim($v),':--:' ";
	}
	$sql=trim($sql,',');
	$sql=trim($sql,',');
	$all=tmq("select ID,trim(concat($sql)) as hashes from media where importid='$importid' and keyid=''");
	while ($r=tmq_fetch_array($all)) {
		$hashed=havester_formatkeyid($r[hashes]);
		tmq("delete from media_havest_id where hashed='$hashed' and havestpid='$code' ");
		tmq("insert into media_havest_id set hashed='$hashed' , havestpid='$code' , bibid='$r[ID]' ");
	}
}


if ($_ISULIBHAVESTER=="yes" && $havestercommand=="recreatekeyid") {
	include ("../_havester/globalfunc.php");
	echo "recreatekeyid (ULIB Havester)<HR>";
	$index=barcodeval_get("havester-tagstocheckdup");
	$index=explode(";",$index);
	//printr($index);
	$sql="";
	@reset($index);
	while (list($k,$v)=each($index)) {
			$sql.=",trim($v),':--:' ";
	}
	$sql=trim($sql,',');
	$sql=trim($sql,',');
	$all=tmq("select ID,trim(concat($sql)) as hashes from media where importid='$importid' ");
	while ($r=tmq_fetch_array($all)) {
		$hashed=havester_formatkeyid($r[hashes]);
		tmq("update media set keyid='$hashed' where ID='$r[ID]' limit 1 ");
	}
}

	if ($trunct=="yes") {
		tmq("delete from index_db where remoteindex='localDB'");
		tmq("delete from index_db_subj");
  	if ($_IS_ENABLE_AUTO_INDEXWORD=="yes") {
  		tmq("delete from indexword where mid<'1' ");
  	}
	}
	
	if ($clearindex!="") {
	  tmq("update media set reindexstatus='no' where importid='$clearindex'  ");
		tmq("delete from index_db where importid='$clearindex' and remoteindex='localDB'");
		tmq("delete from index_db_subj where importid='$clearindex'");
  	if ($_IS_ENABLE_AUTO_INDEXWORD=="yes") {
  		tmq("delete from indexword where importid='$clearindex'");
		}
	}
	if ($clearremoteindex!="") {
		tmq("delete from index_db where remoteindex='$clearremoteindex' ");
	}
		
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

	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT distinct importid, count(id) as cc FROM media  group by importid"; 

	$sql2 = "$sql1 order by importid desc ";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
	$NRow = tmq_num_rows($result);
     							
?> </div>
<BR><A HREF="merge.php"><?php echo getlang("รวมรายการย่อย ๆ ไว้ด้วยกัน::l::Merge Small Import ID");?></A>
                <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699" align=center> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("หมายเลขการนำเข้า::l::Import id"); ?></font></b></font></td>
 <td width=20% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
 size="2"><?php  echo getlang("จำนวนข้อมูล::l::Record count"); ?></td> 
 <td width=20% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
 size="2"><?php  echo getlang("Index แล้ว::l::Indexed"); ?></td> 
                    <td width="20%">
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2">Re-Index</font></b></font></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];

               $name=$row[name];
$ittt = (($startrow))+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
	 $importid=$row[importid];
if ($importid=="") {
	$importid="[EMPTY]";
}
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>$importid  ";
            if ($importid=="$reindexdone") {
               echo "&lt;-&bull;";
            }
            echo "</font></a>";

if ($_ISULIBHAVESTER=="yes") {
	?><BR><FORM METHOD=POST ACTION="media_type.php" onsubmit="return confirm('Please confirm, this action cannot stop until it done.');">
		 <B><FONT SIZE="" COLOR="darkred">add relation for </FONT></B><?php 
		frm_genlist("code","select * from ulibhavestlist ","code","name");
	?><INPUT TYPE="submit" value="OK">
	<INPUT TYPE="hidden" NAME="havestercommand" value="addrelation">
	<INPUT TYPE="hidden" NAME="importid" value="<?php echo $row[importid];?>"> 
	</FORM><?php 

	?><BR><FORM METHOD=POST ACTION="media_type.php" onsubmit="return confirm('Please confirm, this action cannot stop until it done.');">
		 <B><FONT SIZE="" COLOR="darkred">recreatekeyid<INPUT TYPE="submit" value="OK">
	<INPUT TYPE="hidden" NAME="havestercommand" value="recreatekeyid">
	<INPUT TYPE="hidden" NAME="importid" value="<?php echo $row[importid];?>"> (set bibid = importref)
	</FORM><?php 
}
echo "</td>";
			$i2 = $i2 +1;  
			$numindexed=tmq_num_rows(tmq("select id from index_db where importid='$importid' and remoteindex='localDB' "));
 echo"<td align=center>".number_format($row[cc])."</td>";
 echo"<td align=center>";
 if ($numindexed>$row[cc]) {
	echo "<FONT class=smaller2>(".getlang("index เกิน::l::duplicates indexes").")</FONT><BR><b style='color:red'>";
 }
 echo number_format($numindexed);
 echo "</td>";
echo " <td><nobr><A HREF='reindex.php?newindex=yes&ID=".urlencode($importid)."' >Re-Index</A></nobr><br />
<nobr><A HREF='index.php?clearindex=".urlencode($importid)."' onclick=\"return confirm('confirm to clear (delete)');\">Clear index</A></nobr><br />
<nobr><A HREF='reindex.php?contindex=yes&ID=".urlencode($importid)."' >Re-Index (continue)</A></nobr>";
		echo "</td>";
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
 
<CENTER>**  none <?php  echo getlang("หมายถึง ชุดข้อมูลที่ได้จากการคีย์ด้วยมือ::l::means records you entered mannually."); ?><BR><BR>
<A HREF="media_type.php?trunct=yes" onclick="return confirm('<?php  echo getlang("กรุณายืนยันหากไม่มีข้อมูลการ Index จะไม่สามารถใช้งานระบบ UPAC ได้::l:: Please confirm again, UPAC must use Index data to perform searching");?>')"><?php  echo getlang("คลิกที่นี่ เพื่อลบข้อมูลในฐานข้อมูลการ Index ทั้งหมด::l::Click here to delete all Index Database");?></A><BR>
<?php 
//$numall= (tmq_num_rows(tmq("select id from index_db where remoteindex='localDB'")));
$nummedia= (tmq_num_rows(tmq("select id from media")));
$numall= (tmq_num_rows(tmq("select id from index_db where remoteindex='localDB'")));
echo number_format($numall);
echo getlang(" รายการ::l:: records.");
echo "<BR>";

  $s ="SELECT distinct importid FROM media  group by importid"; 
	$l="0";
	$l2="1 ";
	$s=tmq($s);
	while ($r=tmq_fetch_array($s)) {
				$l.=" or importid='$r[importid]' ";	
				$l2.=" and importid<>'$r[importid]' ";					
	}
	
	$numrealmedia=tmq("select * from media");
	$numrealmedia= (tmq_num_rows($numrealmedia));
	
	$s=tmq("select * from index_db where remoteindex='localDB' and $l");
	$numinlist= (tmq_num_rows($s));
	//echo "($numinlist<$numrealmedia)";
	if ($numinlist<$numrealmedia) {
		 html_dialog("Status","มีบางรายการยัง Index ไม่ครบ::l::Some importid not completely index.");
	}
	if ($numinlist>$numrealmedia) {
		 html_dialog("Status","มีการ Index เกิน<BR>แนะนำให้ลบ Index ใน importid นั้นทั้งหมด และ index ใหม่::l::Some importid have duplicates index.<BR> please delete indexes of importid with red sign, then reindex");
	}
	if ($numinlist==$numall) {
		 html_dialog("Status","จำนวน Index ครบ::l::Complete index (by counting).");
	}
	
	$s=tmq("select * from index_db where remoteindex='localDB' and $l2 ",false);
	$numlost= (tmq_num_rows($s));
	if ($numlost!=0) {
		if ($deletelostlink=="yes") {
			tmq("delete from index_db where remoteindex='localDB' and $l2");
			html_dialog("Status","กำลังทำการลบรายการที่ไม่โยง, กรุณารีเฟรชเพื่อดูผล::l::Deleting lost link, refresh to view result");
		} else {
			html_dialog("Status","บาง Index ($numlost) ไม่โยงกับ Bib ::l::Some index ($numlost) lost link to Bib..");
			echo "<a href='index.php?deletelostlink=yes'>".getlang("คลิกที่นี่เพื่อลบรายการที่ไม่โยง::l::Click here to delete lost link")."</a>";
		}
	}
	$s=tmq("select * from index_db where remoteindex<>'localDB'  ");
	$numlost= (tmq_num_rows($s));
	if ($numlost!=0) {
		 if ($deleteallremote=="yes") {
		 		tmq("delete from index_db where remoteindex<>'localDB' ");
			 html_dialog("Status","กำลังทำการลบรายการที่เป็น Remote Index, กรุณารีเฟรชเพื่อดูผล::l::Deleting remote index, refresh to view result");
		 } else {
		 		 html_dialog("Status","บาง Index ($numlost) เป็นการ Remote index ::l::Some index ($numlost) is a Remote index..");
		 		 echo "<a href='index.php?deleteallremote=yes'>".getlang("คลิกที่นี่เพื่อลบรายการ Remote index::l::Click here to delete all Remote index")."</a>";
			}
	}
?>
</CENTER>
        </form>
      </td>
    </tr>
  </table>

<?php 

	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT distinct remoteindex, count(ID) as cc FROM index_db where remoteindex<>'localDB' group by remoteindex"; 

	$sql2 = "$sql1 order by remoteindex  ";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
	$NRow = tmq_num_rows($result);
     							
?> 

                <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699" align=center> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("RemoteIndex"); ?></font></b></font></td>
 <td width=20% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
 size="2"><?php  echo getlang("จำนวนข้อมูล::l::Record count"); ?></td> 
                    <td width="20%">
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2">Delete</font></b></font></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];

               $name=$row[name];
$ittt = (($startrow))+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
	 $remoteindex=$row[remoteindex];
if ($remoteindex=="") {
	$remoteindex="[EMPTY]";
}
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>$remoteindex  </font></a></td>";
            $i2 = $i2 +1;  
 echo"<td align=center>".number_format($row[cc])."</td>";

echo " <td>
<nobr><A HREF='index.php?clearremoteindex=".urlencode($remoteindex)."' onclick=\"return confirm('confirm to clear (delete)');\">Clear Remote index</A></nobr>";
		echo "</td>";
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
			echo $_pagesplit_btn_var;

 ?>
                </table>
  <?php 
		foot();   
	   ?>